@extends('layouts.app')

@section('content')
    <div x-data="{ openDetail: null }">
        <x-card title="Riwayat Penjualan" subtitle="Daftar transaksi terbaru dengan detail item">
            <x-table caption="Riwayat penjualan">
                <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Kasir</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
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
                                <x-button variant="secondary" @click="openDetail = {{ $trx['id_penjualan'] }}">Detail</x-button>
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
            <x-modal show="openDetail === {{ $trx['id_penjualan'] }}" title="Detail Transaksi #{{ $trx['id_penjualan'] }}">
                <div class="space-y-3">
                    <div class="rounded-xl bg-slate-50 p-3 text-sm dark:bg-slate-800">
                        <p><span class="font-semibold">Customer:</span> {{ $trx['nama_customer'] }}</p>
                        <p><span class="font-semibold">Kasir:</span> {{ $trx['nama_user'] }}</p>
                        <p><span class="font-semibold">Tanggal:</span> {{ $trx['tanggal'] }}</p>
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
                        Total: Rp {{ number_format($trx['total'], 0, ',', '.') }}
                    </div>
                </div>
            </x-modal>
        @endforeach
    </div>
@endsection
