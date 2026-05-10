@extends('layouts.app')

@section('content')
    <div x-data="{ openCreate: false, openEdit: null }" @modal-close.window="openCreate = false; openEdit = null">
    <x-card class="mb-4" title="{{ __('messages.manajemen_produk') }}" subtitle="{{ __('messages.manage_products_subtitle') }}">
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

        <form method="GET" action="{{ route('produk.index') }}" class="grid gap-3 md:grid-cols-4">
            <div class="md:col-span-2">
                <label class="muted-label">{{ __('messages.search_produk') }}</label>
                <input type="text" name="q" value="{{ $filters['keyword'] }}" class="soft-input mt-1" placeholder="{{ __('messages.placeholder_cari_produk') }}">
            </div>
            <div>
                <label class="muted-label">{{ __('messages.kategori') }}</label>
                <select name="kategori" class="soft-input mt-1">
                    <option value="">{{ __('messages.semua_kategori') }}</option>
                    @foreach ($kategoriList as $kategori)
                        <option value="{{ $kategori['id_kategori'] }}" @selected($filters['kategori'] === (string) $kategori['id_kategori'])>{{ $kategori['nama_kategori'] }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="muted-label">{{ __('messages.brand') }}</label>
                <select name="brand" class="soft-input mt-1">
                    <option value="">{{ __('messages.semua_brand') }}</option>
                    @foreach ($brandList as $brand)
                        <option value="{{ $brand['id_brand'] }}" @selected($filters['brand'] === (string) $brand['id_brand'])>{{ $brand['nama_brand'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-4 flex flex-wrap gap-2">
                <x-button type="submit" variant="primary">{{ __('messages.apply_filter') }}</x-button>
                <a href="{{ route('produk.index') }}">
                    <x-button variant="secondary">{{ __('messages.reset') }}</x-button>
                </a>
                <x-button type="button" variant="primary" @click="openCreate = true">{{ __('messages.tambah_produk') }}</x-button>
            </div>
        </form>
    </x-card>

    <x-table caption="{{ __('messages.tabel_produk') }}" class="hidden md:block">
        <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-800 dark:text-slate-400">
            <tr>
                <th class="px-4 py-3">{{ __('messages.produk') }}</th>
                <th class="px-4 py-3">{{ __('messages.kategori') }}</th>
                <th class="px-4 py-3">{{ __('messages.brand') }}</th>
                <th class="px-4 py-3">{{ __('messages.harga') }}</th>
                <th class="px-4 py-3">{{ __('messages.stok') }}</th>
                <th class="px-4 py-3 text-right">{{ __('messages.aksi') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
            @foreach ($produk as $item)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/70">
                    <td class="px-4 py-3">
                        <p class="font-semibold text-slate-700 dark:text-slate-100">{{ $item['nama_produk'] }}</p>
                        <p class="text-xs text-slate-500">{{ $item['tipe_produk'] }}</p>
                    </td>
                    <td class="px-4 py-3">{{ $item['nama_kategori'] }}</td>
                    <td class="px-4 py-3">{{ $item['nama_brand'] }}</td>
                    <td class="px-4 py-3">{{ format_currency($item['harga']) }}</td>
                    <td class="px-4 py-3">{{ $item['stok'] }}</td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('produk.show', $item['id_produk']) }}"><x-button variant="ghost">{{ __('messages.detail') }}</x-button></a>
                            <x-button variant="secondary" @click="openEdit = {{ (int) $item['id_produk'] }}">{{ __('messages.edit') }}</x-button>
                            <form action="{{ route('produk.destroy', $item['id_produk']) }}" method="POST" onsubmit="return confirm('{{ __('messages.hapus_produk_confirm') }}')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger">{{ __('messages.hapus') }}</x-button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </x-table>

    <div class="space-y-3 md:hidden">
        @foreach ($produk as $item)
            <x-card>
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $item['nama_produk'] }}</h3>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $item['nama_kategori'] }} · {{ $item['nama_brand'] }}</p>
                    </div>
                    <span class="rounded-lg bg-slate-100 px-2 py-1 text-xs dark:bg-slate-800">{{ __('messages.stok') }} {{ $item['stok'] }}</span>
                </div>

                <p class="mt-3 text-sm font-bold text-teal-600 dark:text-teal-400">{{ format_currency($item['harga']) }}</p>

                <div class="mt-3 flex flex-wrap gap-2">
                    <a href="{{ route('produk.show', $item['id_produk']) }}"><x-button variant="ghost">{{ __('messages.detail') }}</x-button></a>
                    <x-button variant="secondary" @click="openEdit = {{ (int) $item['id_produk'] }}">{{ __('messages.edit') }}</x-button>
                    <form action="{{ route('produk.destroy', $item['id_produk']) }}" method="POST" onsubmit="return confirm('{{ __('messages.hapus_produk_confirm') }}')">
                        @csrf
                        @method('DELETE')
                        <x-button type="submit" variant="danger">{{ __('messages.hapus') }}</x-button>
                    </form>
                </div>
            </x-card>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $produk->links() }}
    </div>

    <x-modal show="openCreate" title="{{ __('messages.tambah_produk_title') }}">
        <form method="POST" action="{{ route('produk.store') }}" class="grid gap-3 sm:grid-cols-2">
            @csrf
            <div class="sm:col-span-2">
                <label class="muted-label">{{ __('messages.nama_produk') }}</label>
                <input type="text" name="nama_produk" class="soft-input mt-1" required>
            </div>
            <div>
                <label class="muted-label">{{ __('messages.tipe_produk') }}</label>
                <input type="text" name="tipe_produk" class="soft-input mt-1" required>
            </div>
            <div>
                <label class="muted-label">{{ __('messages.harga') }}</label>
                <input type="number" name="harga" min="0" class="soft-input mt-1" required>
            </div>
            <div>
                <label class="muted-label">{{ __('messages.kategori') }}</label>
                <select name="id_kategori" class="soft-input mt-1" required>
                    @foreach ($kategoriList as $kategori)
                        <option value="{{ $kategori['id_kategori'] }}">{{ $kategori['nama_kategori'] }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="muted-label">{{ __('messages.brand') }}</label>
                <select name="id_brand" class="soft-input mt-1" required>
                    @foreach ($brandList as $brand)
                        <option value="{{ $brand['id_brand'] }}">{{ $brand['nama_brand'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="muted-label">{{ __('messages.stok_awal') }}</label>
                <input type="number" name="stok" min="0" class="soft-input mt-1" required>
            </div>
            <div class="sm:col-span-2 flex justify-end gap-2">
                <x-button type="button" variant="secondary" @click="openCreate = false">{{ __('messages.batal') }}</x-button>
                <x-button type="submit">{{ __('messages.simpan') }}</x-button>
            </div>
        </form>
    </x-modal>

    @foreach ($produk as $item)
        <x-modal show="openEdit === {{ (int) $item['id_produk'] }}" title="{{ __('messages.edit') }} {{ $item['nama_produk'] }}">
            <form method="POST" action="{{ route('produk.update', $item['id_produk']) }}" class="grid gap-3 sm:grid-cols-2">
                @csrf
                @method('PUT')
                <div class="sm:col-span-2">
                    <label class="muted-label">{{ __('messages.nama_produk') }}</label>
                    <input type="text" name="nama_produk" value="{{ $item['nama_produk'] }}" class="soft-input mt-1" required>
                </div>
                <div>
                    <label class="muted-label">{{ __('messages.tipe_produk') }}</label>
                    <input type="text" name="tipe_produk" value="{{ $item['tipe_produk'] }}" class="soft-input mt-1" required>
                </div>
                <div>
                    <label class="muted-label">{{ __('messages.harga') }}</label>
                    <input type="number" name="harga" min="0" value="{{ $item['harga'] }}" class="soft-input mt-1" required>
                </div>
                <div>
                    <label class="muted-label">{{ __('messages.kategori') }}</label>
                    <select name="id_kategori" class="soft-input mt-1" required>
                        @foreach ($kategoriList as $kategori)
                            <option value="{{ $kategori['id_kategori'] }}" @selected((int) $item['id_kategori'] === (int) $kategori['id_kategori'])>{{ $kategori['nama_kategori'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="muted-label">{{ __('messages.brand') }}</label>
                    <select name="id_brand" class="soft-input mt-1" required>
                        @foreach ($brandList as $brand)
                            <option value="{{ $brand['id_brand'] }}" @selected((int) $item['id_brand'] === (int) $brand['id_brand'])>{{ $brand['nama_brand'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="muted-label">{{ __('messages.stok') }}</label>
                    <input type="number" name="stok" min="0" value="{{ $item['stok'] }}" class="soft-input mt-1" required>
                </div>
                <div class="sm:col-span-2 flex justify-end gap-2">
                    <x-button type="button" variant="secondary" @click="openEdit = null">{{ __('messages.batal') }}</x-button>
                    <x-button type="submit">{{ __('messages.update') }}</x-button>
                </div>
            </form>
        </x-modal>
    @endforeach

    </div>

@endsection
