@extends('layouts.app')

@section('content')
    <x-card title="{{ __('messages.manajemen_stok') }}" subtitle="{{ __('messages.stok_subtitle') }}">
        @if (session('success'))
            <div class="mb-3 rounded-xl bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-3 rounded-xl bg-rose-50 px-3 py-2 text-sm font-medium text-rose-700 dark:bg-rose-900/30 dark:text-rose-300">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-3 rounded-xl bg-rose-50 px-3 py-2 text-sm text-rose-700 dark:bg-rose-900/30 dark:text-rose-300">
                {{ $errors->first() }}
            </div>
        @endif

        <x-table caption="{{ __('messages.tabel_stok') }}">
            <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                <tr>
                    <th class="px-4 py-3">{{ __('messages.produk') }}</th>
                    <th class="px-4 py-3">{{ __('messages.harga') }}</th>
                    <th class="px-4 py-3">{{ __('messages.jumlah_stok') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('messages.aksi') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                @foreach ($stok as $item)
                    <tr>
                        <td class="px-4 py-3 font-semibold">{{ $item['nama_produk'] }}</td>
                        <td class="px-4 py-3">{{ format_currency($item['harga']) }}</td>
                        <td class="px-4 py-3 text-sm font-semibold">{{ __('messages.unit', ['count' => $item['jumlah']]) }}</td>
                        <td class="px-4 py-3 text-right">
                            <form action="{{ route('stok.update', $item['id_produk']) }}" method="POST" class="flex items-center justify-end gap-2">
                                @csrf
                                @method('PATCH')
                                <input
                                    type="number"
                                    name="jumlah"
                                    min="0"
                                    value="{{ $item['jumlah'] }}"
                                    class="soft-input w-28"
                                    required
                                >
                                <x-button type="submit" variant="secondary">{{ __('messages.update') }}</x-button>
                            </form>
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
