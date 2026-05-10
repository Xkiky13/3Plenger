<?php

use App\Models\Brand;
use App\Models\Customer;
use App\Models\DetailPenjualan;
use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Stok;
use App\Http\Controllers\LanguageController;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

if (! function_exists('ui_paginate')) {
    function ui_paginate(Collection $items, int $perPage = 8): LengthAwarePaginator
    {
        $page = LengthAwarePaginator::resolveCurrentPage();
        $slice = $items->forPage($page, $perPage)->values();

        return new LengthAwarePaginator(
            $slice,
            $items->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }
}

Route::get('/', function () {
    return redirect()->to('/' . config('locale.default', 'id') . '/dashboard');
});

$supportedLocales = array_keys(config('locale.supported_locales', []));

// ====================
// URL-Based Locale Routing
// ====================
// Each enabled locale gets its own URL prefix, for example:
// /id/, /en/, /zh/ and any additional locales added in config/locale.php.

Route::prefix('{locale}')
    ->whereIn('locale', $supportedLocales)
    ->group(function () {
        // ==================
        // DASHBOARD
        // ==================
        Route::get('/dashboard', function () {
            $topProduk = Produk::orderByDesc('terjual')->take(5)->get();
            $totalPenjualan = Penjualan::sum('total');

            return view('dashboard.index', [
                'totalProduk' => Produk::count(),
                'totalTransaksi' => Penjualan::count(),
                'totalPenjualan' => $totalPenjualan,
                'topProduk' => $topProduk,
                'grafik' => [
                    ['label' => 'Sen', 'value' => 4200000],
                    ['label' => 'Sel', 'value' => 6800000],
                    ['label' => 'Rab', 'value' => 5100000],
                    ['label' => 'Kam', 'value' => 7900000],
                    ['label' => 'Jum', 'value' => 9200000],
                    ['label' => 'Sab', 'value' => 10100000],
                    ['label' => 'Min', 'value' => 6300000],
                ],
            ]);
        })->name('dashboard');

        // ==================
        // PRODUK
        // ==================
        Route::get('/produk', function () {
            $kategoriList = Kategori::all();
            $brandList = Brand::all();

            $keyword = trim((string) request('q', ''));
            $kategori = (string) request('kategori', '');
            $brand = (string) request('brand', '');

            $query = Produk::with('kategori', 'brand', 'stok');

            if ($keyword !== '') {
                $query->where('nama_produk', 'like', "%{$keyword}%");
            }

            if ($kategori !== '') {
                $query->where('id_kategori', (int) $kategori);
            }

            if ($brand !== '') {
                $query->where('id_brand', (int) $brand);
            }

            $produkCollection = $query->get()->map(function ($item) {
                return [
                    'id_produk' => $item->id_produk,
                    'nama_produk' => $item->nama_produk,
                    'tipe_produk' => $item->tipe_produk,
                    'id_kategori' => $item->id_kategori,
                    'id_brand' => $item->id_brand,
                    'harga' => $item->harga,
                    'terjual' => $item->terjual,
                    'nama_kategori' => $item->kategori->nama_kategori ?? '-',
                    'nama_brand' => $item->brand->nama_brand ?? '-',
                    'stok' => $item->stok->jumlah ?? 0,
                ];
            });

            return view('produk.index', [
                'produk' => ui_paginate(collect($produkCollection)),
                'kategoriList' => $kategoriList,
                'brandList' => $brandList,
                'filters' => compact('keyword', 'kategori', 'brand'),
            ]);
        })->name('produk.index');

        Route::get('/produk/{id}', function (string $locale, int $id) {
            $produk = Produk::with('kategori', 'brand', 'stok')->find($id);
            abort_if(! $produk, 404);

            return view('produk.show', [
                'produk' => $produk,
                'kategori' => $produk->kategori,
                'brand' => $produk->brand,
                'stok' => $produk->stok,
            ]);
        })->name('produk.show');

        Route::post('/produk', function () {
            $validator = Validator::make(request()->all(), [
                'nama_produk' => ['required', 'string', 'max:100'],
                'tipe_produk' => ['required', 'string', 'max:50'],
                'id_kategori' => ['required', 'integer'],
                'id_brand' => ['required', 'integer'],
                'harga' => ['required', 'integer', 'min:0'],
                'stok' => ['required', 'integer', 'min:0'],
            ]);

            if ($validator->fails()) {
                return redirect()->route('produk.index')->withErrors($validator)->withInput();
            }

            $produk = Produk::create([
                'nama_produk' => request('nama_produk'),
                'tipe_produk' => request('tipe_produk'),
                'id_kategori' => (int) request('id_kategori'),
                'id_brand' => (int) request('id_brand'),
                'harga' => (int) request('harga'),
                'terjual' => 0,
            ]);

            Stok::create([
                'id_produk' => $produk->id_produk,
                'jumlah' => (int) request('stok'),
            ]);

            return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
        })->name('produk.store');

        Route::put('/produk/{id}', function (string $locale, int $id) {
            $validator = Validator::make(request()->all(), [
                'nama_produk' => ['required', 'string', 'max:100'],
                'tipe_produk' => ['required', 'string', 'max:50'],
                'id_kategori' => ['required', 'integer'],
                'id_brand' => ['required', 'integer'],
                'harga' => ['required', 'integer', 'min:0'],
                'stok' => ['required', 'integer', 'min:0'],
            ]);

            if ($validator->fails()) {
                return redirect()->route('produk.index')->withErrors($validator)->withInput();
            }

            $produk = Produk::find($id);
            if (! $produk) {
                return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan.');
            }

            $produk->update([
                'nama_produk' => request('nama_produk'),
                'tipe_produk' => request('tipe_produk'),
                'id_kategori' => (int) request('id_kategori'),
                'id_brand' => (int) request('id_brand'),
                'harga' => (int) request('harga'),
            ]);

            $stok = Stok::where('id_produk', $id)->first();
            if ($stok) {
                $stok->update(['jumlah' => (int) request('stok')]);
            }

            return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
        })->name('produk.update');

        Route::delete('/produk/{id}', function (string $locale, int $id) {
            $usedInSales = DetailPenjualan::where('id_produk', $id)->exists();

            if ($usedInSales) {
                return redirect()->route('produk.index')->with('error', 'Produk tidak bisa dihapus karena sudah pernah digunakan transaksi.');
            }

            $produk = Produk::find($id);
            if ($produk) {
                Stok::where('id_produk', $id)->delete();
                $produk->delete();
            }

            return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
        })->name('produk.destroy');

        // ==================
        // TRANSAKSI
        // ==================
        Route::get('/transaksi', function () {
            $produk = Produk::all()->map(function ($item) {
                return [
                    'id_produk' => $item->id_produk,
                    'nama_produk' => $item->nama_produk,
                    'tipe_produk' => $item->tipe_produk,
                    'harga' => $item->harga,
                ];
            })->toArray();
            
            $customer = Customer::all()->map(function ($item) {
                return [
                    'id_customer' => $item->id_customer,
                    'nama' => $item->nama,
                ];
            })->toArray();

            return view('transaksi.index', [
                'produk' => $produk,
                'customer' => $customer,
            ]);
        })->name('transaksi.index');

        Route::post('/transaksi/checkout', function () {
            $validator = Validator::make(request()->all(), [
                'customer_id' => ['nullable', 'integer'],
                'customer_name' => ['nullable', 'string', 'max:100'],
                'cart' => ['required', 'string'],
            ]);

            if ($validator->fails()) {
                return redirect()->route('transaksi.index')->withErrors($validator)->withInput();
            }

            $cart = json_decode((string) request('cart'), true);
            if (! is_array($cart) || count($cart) === 0) {
                return redirect()->route('transaksi.index')->with('error', 'Keranjang masih kosong.');
            }

            $customerId = (int) request('customer_id', 0);
            $customerName = trim((string) request('customer_name', ''));

            if ($customerId <= 0 && $customerName === '') {
                return redirect()->route('transaksi.index')->with('error', 'Pilih customer atau isi nama customer baru.');
            }

            if ($customerId > 0) {
                $customer = Customer::find($customerId);
                if (! $customer) {
                    return redirect()->route('transaksi.index')->with('error', 'Customer tidak ditemukan.');
                }
            } else {
                $customer = Customer::create([
                    'nama' => $customerName,
                    'no_hp' => '-',
                    'alamat' => '-',
                ]);
                $customerId = $customer->id_customer;
            }

            $total = 0;
            $detailRows = [];

            foreach ($cart as $row) {
                $idProduk = (int) ($row['id_produk'] ?? 0);
                $jumlah = (int) ($row['jumlah'] ?? 0);

                if ($idProduk <= 0 || $jumlah <= 0) {
                    return redirect()->route('transaksi.index')->with('error', 'Item keranjang tidak valid.');
                }

                $produk = Produk::find($idProduk);
                $stok = Stok::where('id_produk', $idProduk)->first();

                if (! $produk || ! $stok) {
                    return redirect()->route('transaksi.index')->with('error', 'Data produk tidak ditemukan.');
                }

                if ((int) $stok->jumlah < $jumlah) {
                    return redirect()->route('transaksi.index')->with('error', 'Stok untuk '.$produk->nama_produk.' tidak mencukupi.');
                }

                $subtotal = ((int) $produk->harga) * $jumlah;
                $total += $subtotal;

                $detailRows[] = [
                    'id_produk' => $idProduk,
                    'jumlah' => $jumlah,
                    'harga' => (int) $produk->harga,
                    'subtotal' => $subtotal,
                ];
            }

            $penjualan = Penjualan::create([
                'id_customer' => $customerId,
                'id_user' => null,
                'tanggal' => now()->toDateString(),
                'total' => $total,
            ]);

            foreach ($detailRows as $detail) {
                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id_penjualan,
                    'id_produk' => $detail['id_produk'],
                    'jumlah' => $detail['jumlah'],
                    'harga' => $detail['harga'],
                    'subtotal' => $detail['subtotal'],
                ]);

                $produk = Produk::find($detail['id_produk']);
                $produk->increment('terjual', $detail['jumlah']);

                $stok = Stok::where('id_produk', $detail['id_produk'])->first();
                if ($stok) {
                    $stok->decrement('jumlah', $detail['jumlah']);
                }
            }

            return redirect()->route('penjualan.index')->with('success', 'Checkout berhasil diproses.');
        })->name('transaksi.checkout');

        // ==================
        // PENJUALAN
        // ==================
        Route::get('/penjualan', function () {
            $penjualanData = Penjualan::with('customer', 'details.produk')->get();

            $rows = $penjualanData->map(function ($penjualan) {
                $details = $penjualan->details->map(function ($detail) {
                    return [
                        'id_detail' => $detail->id_detail,
                        'id_penjualan' => $detail->id_penjualan,
                        'id_produk' => $detail->id_produk,
                        'jumlah' => $detail->jumlah,
                        'harga' => $detail->harga,
                        'subtotal' => $detail->subtotal,
                        'nama_produk' => $detail->produk->nama_produk ?? '-',
                    ];
                })->values();

                return [
                    'id_penjualan' => $penjualan->id_penjualan,
                    'id_customer' => $penjualan->id_customer,
                    'id_user' => $penjualan->id_user,
                    'tanggal' => $penjualan->tanggal,
                    'total' => $penjualan->total,
                    'nama_customer' => $penjualan->customer->nama ?? '-',
                    'nama_user' => $penjualan->id_user ? 'Kasir' : '-',
                    'details' => $details,
                ];
            });

            return view('penjualan.index', [
                'penjualan' => ui_paginate(collect($rows), 6),
            ]);
        })->name('penjualan.index');

        // ==================
        // CUSTOMER
        // ==================
        Route::get('/customer', function () {
            $customer = Customer::all();

            return view('customer.index', [
                'customer' => ui_paginate(collect($customer), 5),
            ]);
        })->name('customer.index');

        Route::post('/customer', function () {
            $validator = Validator::make(request()->all(), [
                'nama' => ['required', 'string', 'max:100'],
                'no_hp' => ['required', 'string', 'max:20'],
                'alamat' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return redirect()->route('customer.index')->withErrors($validator)->withInput();
            }

            Customer::create([
                'nama' => request('nama'),
                'no_hp' => request('no_hp'),
                'alamat' => request('alamat'),
            ]);

            return redirect()->route('customer.index')->with('success', 'Customer berhasil ditambahkan.');
        })->name('customer.store');

        Route::put('/customer/{id}', function (string $locale, int $id) {
            $validator = Validator::make(request()->all(), [
                'nama' => ['required', 'string', 'max:100'],
                'no_hp' => ['required', 'string', 'max:20'],
                'alamat' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return redirect()->route('customer.index')->withErrors($validator)->withInput();
            }

            $customer = Customer::find($id);
            if (! $customer) {
                return redirect()->route('customer.index')->with('error', 'Customer tidak ditemukan.');
            }

            $customer->update([
                'nama' => request('nama'),
                'no_hp' => request('no_hp'),
                'alamat' => request('alamat'),
            ]);

            return redirect()->route('customer.index')->with('success', 'Customer berhasil diperbarui.');
        })->name('customer.update');

        Route::delete('/customer/{id}', function (string $locale, int $id) {
            $used = Penjualan::where('id_customer', $id)->exists();

            if ($used) {
                return redirect()->route('customer.index')->with('error', 'Customer tidak bisa dihapus karena punya riwayat transaksi.');
            }

            $customer = Customer::find($id);
            if ($customer) {
                $customer->delete();
            }

            return redirect()->route('customer.index')->with('success', 'Customer berhasil dihapus.');
        })->name('customer.destroy');

        // ==================
        // STOK
        // ==================
        Route::get('/stok', function () {
            $stokData = Stok::with('produk')->get();

            $rows = $stokData->map(function ($stok) {
                return [
                    'id_stok' => $stok->id_stok,
                    'id_produk' => $stok->id_produk,
                    'jumlah' => $stok->jumlah,
                    'nama_produk' => $stok->produk->nama_produk ?? '-',
                    'harga' => $stok->produk->harga ?? 0,
                ];
            });

            return view('stok.index', [
                'stok' => ui_paginate(collect($rows)),
            ]);
        })->name('stok.index');

        Route::patch('/stok/{idProduk}', function (string $locale, int $idProduk) {
            $validator = Validator::make(request()->all(), [
                'jumlah' => ['required', 'integer', 'min:0'],
            ]);

            if ($validator->fails()) {
                return redirect()->route('stok.index')->withErrors($validator)->withInput();
            }

            $stok = Stok::where('id_produk', $idProduk)->first();
            if (! $stok) {
                return redirect()->route('stok.index')->with('error', 'Data stok tidak ditemukan.');
            }

            $stok->update(['jumlah' => (int) request('jumlah')]);

            return redirect()->route('stok.index')->with('success', 'Stok berhasil diperbarui.');
        })->name('stok.update');

        // ==================
        // TEST LANGUAGE
        // ==================
        Route::get('/test-language', function () {
            return response()->json([
                'current_locale' => app()->getLocale(),
                'session_locale' => session('locale'),
                'config_default' => config('locale.default'),
                'config_supported' => config('locale.supported_locales'),
                'test_translation' => __('messages.dashboard'),
                'test_currency' => format_currency(100000),
            ]);
        })->name('test.language');
    });

// ==================
// Legacy Language Routes
// ==================
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
Route::get('/api/language/current', [LanguageController::class, 'getCurrent'])->name('language.current');
