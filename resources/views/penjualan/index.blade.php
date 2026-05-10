@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-xl bg-rose-50 px-3 py-2 text-sm font-medium text-rose-700 dark:bg-rose-900/30 dark:text-rose-300">{{ session('error') }}</div>
    @endif

    <div x-data="{ openDetail: null }" @modal-close.window="openDetail = null">
        <x-card title="{{ __('messages.riwayat_penjualan') }}" subtitle="{{ __('messages.detail_transaksi') }}">
            <x-table caption="{{ __('messages.riwayat_penjualan') }}">
                <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                    <tr>
                        <th class="px-4 py-3">{{ __('messages.id') }}</th>
                        <th class="px-4 py-3">{{ __('messages.tanggal') }}</th>
                        <th class="px-4 py-3">{{ __('messages.customer') }}</th>
                        <th class="px-4 py-3">{{ __('messages.kasir') }}</th>
                        <th class="px-4 py-3">{{ __('messages.total') }}</th>
                        <th class="px-4 py-3 text-right">{{ __('messages.aksi') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @foreach ($penjualan as $trx)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/70">
                            <td class="px-4 py-3 font-semibold">#{{ $trx['id_penjualan'] }}</td>
                            <td class="px-4 py-3">{{ $trx['tanggal'] }}</td>
                            <td class="px-4 py-3">{{ $trx['nama_customer'] }}</td>
                            <td class="px-4 py-3">{{ $trx['nama_user'] }}</td>
                            <td class="px-4 py-3 font-semibold text-teal-600 dark:text-teal-400">Rp {{ number_format($trx['total'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right">
                                <x-button variant="secondary" @click="openDetail = {{ (int) $trx['id_penjualan'] }}">{{ __('messages.detail') }}</x-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-table>

            <div class="mt-4">
                {{ $penjualan->links() }}
            </div>
        </x-card>

        @foreach ($penjualan as $trx)
            <x-modal show="openDetail === {{ (int) $trx['id_penjualan'] }}" title="{{ __('messages.detail_transaksi_title', ['id' => $trx['id_penjualan']]) }}">
                <div class="space-y-3">
                    <div class="rounded-xl bg-slate-50 p-3 text-sm dark:bg-slate-800">
                        <p><span class="font-semibold">{{ __('messages.customer') }}:</span> {{ $trx['nama_customer'] }}</p>
                        <p><span class="font-semibold">{{ __('messages.kasir') }}:</span> {{ $trx['nama_user'] }}</p>
                        <p><span class="font-semibold">{{ __('messages.tanggal') }}:</span> {{ $trx['tanggal'] }}</p>
                    </div>

                    <div class="space-y-2">
                        @foreach ($trx['details'] as $detail)
                            <div class="flex items-center justify-between rounded-xl border border-slate-200 p-3 text-sm dark:border-slate-700">
                                <div>
                                    <p class="font-semibold">{{ $detail['nama_produk'] }}</p>
                                    <p class="text-xs text-slate-500">{{ $detail['jumlah'] }} x Rp {{ number_format($detail['harga'], 0, ',', '.') }}</p>
                                </div>
                                <p class="font-semibold">Rp {{ number_format($detail['subtotal'], 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-end text-sm font-semibold">
                        {{ __('messages.total') }}: Rp {{ number_format($trx['total'], 0, ',', '.') }}
                    </div>
                </div>
            </x-modal>
        @endforeach
    </div>
@endsection
