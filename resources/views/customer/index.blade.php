@extends('layouts.app')

@section('content')
    <x-card title="Data Customer" subtitle="CRUD sederhana customer">
        <div class="mb-4 flex flex-wrap gap-2">
            <x-button @click="showToast('Form tambah customer siap dihubungkan backend')">+ Tambah Customer</x-button>
            <x-button variant="secondary" @click="showToast('Export data customer (simulasi)')">Export</x-button>
        </div>

        <x-table caption="Tabel customer">
            <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">No HP</th>
                    <th class="px-4 py-3">Alamat</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                @foreach ($customer as $item)
                    <tr>
                        <td class="px-4 py-3 font-semibold">{{ $item['nama'] }}</td>
                        <td class="px-4 py-3">{{ $item['no_hp'] }}</td>
                        <td class="px-4 py-3">{{ $item['alamat'] }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <x-button variant="secondary" @click="showToast('Edit customer {{ $item['nama'] }}')">Edit</x-button>
                                <x-button variant="danger" @click="askConfirm('Hapus customer {{ $item['nama'] }}?', () => showToast('Customer dihapus (simulasi).'))">Hapus</x-button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-table>

        <div class="mt-4">
            {{ $customer->links() }}
        </div>
    </x-card>
@endsection
