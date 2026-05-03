import Alpine from 'alpinejs';

window.appLayout = () => ({
	sidebarOpen: false,
	isDark: localStorage.getItem('ui-theme') === 'dark',
	loading: false,
	toastOpen: false,
	toastText: '',
	toastType: 'success',
	confirmOpen: false,
	confirmMessage: '',
	confirmAction: null,

	init() {
		this.applyTheme();

		window.addEventListener('notify', (event) => {
			this.showToast(event.detail?.message || 'Berhasil', event.detail?.type || 'success');
		});
	},

	applyTheme() {
		document.documentElement.classList.toggle('dark', this.isDark);
	},

	toggleTheme() {
		this.isDark = !this.isDark;
		localStorage.setItem('ui-theme', this.isDark ? 'dark' : 'light');
		this.applyTheme();
	},

	startLoading() {
		this.loading = true;
		setTimeout(() => {
			this.loading = false;
		}, 450);
	},

	showToast(message, type = 'success') {
		this.toastText = message;
		this.toastType = type;
		this.toastOpen = true;

		setTimeout(() => {
			this.toastOpen = false;
		}, 2200);
	},

	askConfirm(message, callback) {
		this.confirmMessage = message;
		this.confirmAction = callback;
		this.confirmOpen = true;
	},

	runConfirm() {
		if (typeof this.confirmAction === 'function') {
			this.confirmAction();
		}

		this.closeConfirm();
	},

	closeConfirm() {
		this.confirmOpen = false;
		this.confirmMessage = '';
		this.confirmAction = null;
	},
});

window.posPage = (products) => ({
	products,
	customerName: '',
	search: '',
	cart: [],

	get filteredProducts() {
		if (!this.search.trim()) return this.products;

		return this.products.filter((item) =>
			item.nama_produk.toLowerCase().includes(this.search.toLowerCase())
		);
	},

	addToCart(product) {
		const found = this.cart.find((item) => item.id_produk === product.id_produk);
		if (found) {
			found.jumlah += 1;
			return;
		}

		this.cart.push({ ...product, jumlah: 1 });
	},

	removeItem(idProduk) {
		this.cart = this.cart.filter((item) => item.id_produk !== idProduk);
	},

	increase(item) {
		item.jumlah += 1;
	},

	decrease(item) {
		if (item.jumlah <= 1) {
			this.removeItem(item.id_produk);
			return;
		}

		item.jumlah -= 1;
	},

	subtotal(item) {
		return item.harga * item.jumlah;
	},

	get total() {
		return this.cart.reduce((sum, item) => sum + item.harga * item.jumlah, 0);
	},

	checkout() {
		if (!this.customerName.trim()) {
			window.dispatchEvent(
				new CustomEvent('notify', {
					detail: {
						type: 'error',
						message: 'Masukkan nama customer terlebih dahulu.',
					},
				})
			);
			return;
		}

		if (this.cart.length === 0) {
			window.dispatchEvent(
				new CustomEvent('notify', {
					detail: {
						type: 'error',
						message: 'Keranjang masih kosong.',
					},
				})
			);
			return;
		}

		this.cart = [];
		this.customerName = '';
		this.search = '';

		window.dispatchEvent(
			new CustomEvent('notify', {
				detail: {
					type: 'success',
					message: 'Checkout berhasil diproses.',
				},
			})
		);
	},
});

window.Alpine = Alpine;
Alpine.start();
