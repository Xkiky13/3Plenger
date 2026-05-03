@extends('layouts.app')

@section('content')
    <div x-data="posPage(@js($produk))" class="grid gap-4 xl:grid-cols-3">
        <x-card title="Produk POS" subtitle="Pilih produk untuk masuk ke keranjang" class="xl:col-span-2">
            <div class="mb-4">
                <label class="muted-label">Cari Produk</label>
                <input type="text" class="soft-input mt-1" placeholder="Ketik nama produk..." x-model="search">
            </div>

            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                <template x-for="item in filteredProducts" :key="item.id_produk">
                    <div class="rounded-2xl border border-slate-200 p-3 dark:border-slate-700">
                        <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100" x-text="item.nama_produk"></h3>
                        <p class="mt-1 text-xs text-slate-500" x-text="item.tipe_produk"></p>
                        <p class="mt-2 text-sm font-bold text-teal-600 dark:text-teal-400" x-text="'Rp ' + Number(item.harga).toLocaleString('id-ID')"></p>
                        <x-button class="mt-3 w-full" @click="addToCart(item)">Tambah</x-button>
                    </div>
                </template>
            </div>
        </x-card>

        <x-card title="Keranjang" subtitle="Subtotal dan total otomatis">
            <div>
                <label class="muted-label">Nama Customer</label>
                <input type="text" class="soft-input mt-1" x-model="customerName" placeholder="Contoh: Rizky Aditya">
            </div>

            <div class="mt-4 space-y-2">
                <template x-if="cart.length === 0">
                    <p class="rounded-xl bg-slate-50 p-3 text-sm text-slate-500 dark:bg-slate-800 dark:text-slate-300">Keranjang kosong.</p>
                </template>

                <template x-for="item in cart" :key="item.id_produk">
                    <div class="rounded-xl border border-slate-200 p-3 dark:border-slate-700">
                        <div class="flex items-start justify-between gap-2">
                            <p class="text-sm font-semibold" x-text="item.nama_produk"></p>
                            <button type="button" class="text-xs text-rose-600" @click="removeItem(item.id_produk)">Hapus</button>
                        </div>
                        <div class="mt-2 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <button type="button" class="rounded-lg bg-slate-200 px-2 dark:bg-slate-700" @click="decrease(item)">-</button>
                                <span class="text-sm" x-text="item.jumlah"></span>
                                <button type="button" class="rounded-lg bg-slate-200 px-2 dark:bg-slate-700" @click="increase(item)">+</button>
                            </div>
                            <p class="text-sm font-semibold" x-text="'Rp ' + Number(subtotal(item)).toLocaleString('id-ID')"></p>
                        </div>
                    </div>
                </template>
            </div>

            <div class="mt-4 rounded-xl bg-slate-50 p-4 dark:bg-slate-800">
                <div class="flex items-center justify-between text-sm">
                    <span>Total</span>
                    <span class="text-lg font-bold text-teal-600 dark:text-teal-400" x-text="'Rp ' + Number(total).toLocaleString('id-ID')"></span>
                </div>
            </div>

            <x-button class="mt-4 w-full" @click="checkout()">Checkout</x-button>
        </x-card>
    </div>
@endsection
