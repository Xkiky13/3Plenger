@extends('layouts.app')

@section('content')
    <x-card class="mb-4" title="Manajemen Produk" subtitle="Cari, filter, dan kelola produk dengan cepat">
        <form method="GET" action="{{ route('produk.index') }}" class="grid gap-3 md:grid-cols-4">
            <div class="md:col-span-2">
                <label class="muted-label">Search Produk</label>
                <input type="text" name="q" value="{{ $filters['keyword'] }}" class="soft-input mt-1" placeholder="Cari nama produk...">
            </div>
            <div>
                <label class="muted-label">Kategori</label>
                <select name="kategori" class="soft-input mt-1">
                    <option value="">Semua kategori</option>
                    @foreach ($kategoriList as $kategori)
                        <option value="{{ $kategori['id_kategori'] }}" @selected($filters['kategori'] === (string) $kategori['id_kategori'])>{{ $kategori['nama_kategori'] }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="muted-label">Brand</label>
                <select name="brand" class="soft-input mt-1">
                    <option value="">Semua brand</option>
                    @foreach ($brandList as $brand)
                        <option value="{{ $brand['id_brand'] }}" @selected($filters['brand'] === (string) $brand['id_brand'])>{{ $brand['nama_brand'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-4 flex flex-wrap gap-2">
                <x-button type="submit" variant="primary">Terapkan Filter</x-button>
                <a href="{{ route('produk.index') }}">
                    <x-button variant="secondary">Reset</x-button>
                </a>
                <x-button type="button" variant="primary" @click="showToast('Form tambah produk siap dihubungkan ke backend.')">+ Tambah Produk</x-button>
            </div>
        </form>
    </x-card>

    <x-table caption="Tabel produk" class="hidden md:block">
        <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-800 dark:text-slate-400">
            <tr>
                <th class="px-4 py-3">Produk</th>
                <th class="px-4 py-3">Kategori</th>
                <th class="px-4 py-3">Brand</th>
                <th class="px-4 py-3">Harga</th>
                <th class="px-4 py-3">Stok</th>
                <th class="px-4 py-3 text-right">Aksi</th>
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
                    <td class="px-4 py-3">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td class="px-4 py-3">{{ $item['stok'] }}</td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('produk.show', $item['id_produk']) }}"><x-button variant="ghost">Detail</x-button></a>
                            <x-button variant="secondary" @click="showToast('Mode edit aktif untuk {{ $item['nama_produk'] }}')">Edit</x-button>
                            <x-button variant="danger" @click="askConfirm('Hapus produk {{ $item['nama_produk'] }}?', () => showToast('Produk dihapus (simulasi).'))">Hapus</x-button>
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
                    <span class="rounded-lg bg-slate-100 px-2 py-1 text-xs dark:bg-slate-800">Stok {{ $item['stok'] }}</span>
                </div>

                <p class="mt-3 text-sm font-bold text-teal-600 dark:text-teal-400">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>

                <div class="mt-3 flex flex-wrap gap-2">
                    <a href="{{ route('produk.show', $item['id_produk']) }}"><x-button variant="ghost">Detail</x-button></a>
                    <x-button variant="secondary" @click="showToast('Mode edit aktif')">Edit</x-button>
                    <x-button variant="danger" @click="askConfirm('Hapus {{ $item['nama_produk'] }}?', () => showToast('Produk dihapus (simulasi).'))">Hapus</x-button>
                </div>
            </x-card>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $produk->links() }}
    </div>
@endsection
