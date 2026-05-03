@extends('layouts.app')

@section('content')
    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-card title="Total Produk">
            <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ number_format($totalProduk) }}</p>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Produk aktif terdaftar</p>
        </x-card>

        <x-card title="Total Transaksi">
            <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ number_format($totalTransaksi) }}</p>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Transaksi bulan ini</p>
        </x-card>

        <x-card title="Omzet Penjualan">
            <p class="text-3xl font-bold text-slate-900 dark:text-white">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
            <p class="mt-1 text-sm text-emerald-600 dark:text-emerald-400">+12.8% dari bulan lalu</p>
        </x-card>

        <x-card title="Produk Terlaris">
            <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $topProduk->first()['nama_produk'] }}</p>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $topProduk->first()['terjual'] }} unit terjual</p>
        </x-card>
    </section>

    <section class="mt-5 grid gap-4 xl:grid-cols-3">
        <x-card title="Grafik Penjualan Mingguan" subtitle="Visual sederhana performa pendapatan harian" class="xl:col-span-2">
            @php
                $maxValue = max(array_column($grafik, 'value'));
            @endphp

            <div class="grid grid-cols-7 items-end gap-3 pt-3">
                @foreach ($grafik as $item)
                    @php
                        $scale = $item['value'] / $maxValue;
                        $heightClass = match (true) {
                            $scale >= 0.95 => 'h-48',
                            $scale >= 0.85 => 'h-44',
                            $scale >= 0.75 => 'h-40',
                            $scale >= 0.65 => 'h-36',
                            $scale >= 0.55 => 'h-32',
                            $scale >= 0.45 => 'h-28',
                            $scale >= 0.35 => 'h-24',
                            $scale >= 0.25 => 'h-20',
                            default => 'h-16',
                        };
                    @endphp
                    <div class="space-y-2 text-center">
                        <div class="{{ $heightClass }} mx-auto w-full max-w-10 rounded-2xl bg-gradient-to-t from-teal-500 to-cyan-400"></div>
                        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">{{ $item['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </x-card>

        <x-card title="Top 5 Produk">
            <ul class="space-y-3">
                @foreach ($topProduk as $item)
                    <li class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2.5 dark:bg-slate-800/70">
                        <div>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ $item['nama_produk'] }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $item['tipe_produk'] }}</p>
                        </div>
                        <span class="rounded-lg bg-teal-100 px-2.5 py-1 text-xs font-bold text-teal-700 dark:bg-teal-900/50 dark:text-teal-300">{{ $item['terjual'] }}x</span>
                    </li>
                @endforeach
            </ul>
        </x-card>
    </section>
@endsection
