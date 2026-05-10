@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <a href="{{ route('produk.index') }}" class="text-sm font-medium text-teal-600 hover:text-teal-700 dark:text-teal-400">{{ __('messages.kembali_ke_produk') }}</a>
    </div>

    <x-card title="{{ __('messages.detail_produk') }}" subtitle="{{ __('messages.informasi_lengkap') }}">
        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-4">
                <div>
                    <p class="muted-label">{{ __('messages.nama_produk') }}</p>
                    <p class="mt-1 text-lg font-semibold text-slate-800 dark:text-slate-100">{{ $produk['nama_produk'] }}</p>
                </div>
                <div>
                    <p class="muted-label">{{ __('messages.tipe_produk') }}</p>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">{{ $produk['tipe_produk'] }}</p>
                </div>
                <div>
                    <p class="muted-label">{{ __('messages.harga') }}</p>
                    <p class="mt-1 text-2xl font-bold text-teal-600 dark:text-teal-400">Rp {{ number_format($produk['harga'], 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <p class="muted-label">{{ __('messages.kategori') }}</p>
                    <p class="mt-1 text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $kategori['nama_kategori'] ?? '-' }}</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <p class="muted-label">{{ __('messages.brand') }}</p>
                    <p class="mt-1 text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $brand['nama_brand'] ?? '-' }}</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-800">
                    <p class="muted-label">{{ __('messages.stok') }}</p>
                    <p class="mt-1 text-sm font-semibold text-slate-700 dark:text-slate-200">{{ __('messages.stok_tersedia', ['count' => $stok['jumlah'] ?? 0]) }}</p>
                </div>
            </div>
        </div>
    </x-card>
