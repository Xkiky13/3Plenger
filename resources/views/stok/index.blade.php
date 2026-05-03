@extends('layouts.app')

@section('content')
    <x-card title="Manajemen Stok" subtitle="Pantau dan update jumlah stok produk">
        <x-table caption="Tabel stok produk">
            <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                <tr>
                    <th class="px-4 py-3">Produk</th>
                    <th class="px-4 py-3">Harga</th>
                    <th class="px-4 py-3">Jumlah Stok</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                @foreach ($stok as $item)
                    <tr>
                        <td class="px-4 py-3 font-semibold">{{ $item['nama_produk'] }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-lg bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-200">{{ $item['jumlah'] }} unit</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <x-button variant="secondary" @click="showToast('Update stok {{ $item['nama_produk'] }} (simulasi)')">Update Stok</x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-table>

        <div class="mt-4">
            {{ $stok->links() }}
        </div>
    </x-card>
@endsection
