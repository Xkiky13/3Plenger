@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <a href="{{ route('produk.index') }}" class="text-sm font-medium text-teal-600 hover:text-teal-700 dark:text-teal-400">← Kembali ke Produk</a>
    </div>

    <x-card title="Detail Produk" subtitle="Informasi lengkap produk, kategori, brand, dan stok">
        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-4">
                <div>
                    <p class="muted-label">Nama Produk</p>
                    <p class="mt-1 text-lg font-semibold text-slate-800 dark:text-slate-100">{{ $produk['nama_produk'] }}</p>
                </div>
                <div>
                    <p class="muted-label">Tipe Produk</p>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">{{ $produk['tipe_produk'] }}</p>
                </div>
                <div>
                    <p class="muted-label">Harga</p>
                    <p class="mt-1 text-2xl font-bold text-teal-600 dark:text-teal-400">Rp {{ number_format($produk['harga'], 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <p class="muted-label">Kategori</p>
                    <p class="mt-1 text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $kategori['nama_kategori'] ?? '-' }}</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <p class="muted-label">Brand</p>
                    <p class="mt-1 text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $brand['nama_brand'] ?? '-' }}</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <p class="muted-label">Stok</p>
                    <p class="mt-1 text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $stok['jumlah'] ?? 0 }} unit tersedia</p>
                </div>
            </div>
        </div>
    </x-card>
