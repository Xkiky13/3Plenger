@extends('layouts.app')

@section('content')
    <div x-data="{ openCreate: false, openEdit: null }" @modal-close.window="openCreate = false; openEdit = null">
    <x-card title="Data Customer" subtitle="CRUD sederhana customer">
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

        <div class="mb-4 flex flex-wrap gap-2">
            <x-button @click="openCreate = true">{{ __('messages.tambah_customer') }}</x-button>
        </div>

        <x-table caption="{{ __('messages.tabel_customer') }}">
            <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                <tr>
                    <th class="px-4 py-3">{{ __('messages.nama') }}</th>
                    <th class="px-4 py-3">{{ __('messages.no_hp') }}</th>
                    <th class="px-4 py-3">{{ __('messages.alamat') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('messages.aksi') }}</th>
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
                                <x-button variant="secondary" @click="openEdit = {{ (int) $item['id_customer'] }}">{{ __('messages.edit') }}</x-button>
                                <form action="{{ route('customer.destroy', $item['id_customer']) }}" method="POST" onsubmit="return confirm('{{ __('messages.hapus_customer_confirm') }}')">
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

        <div class="mt-4">
            {{ $customer->links() }}
        </div>
    </x-card>

    <x-modal show="openCreate" title="{{ __('messages.tambah_customer') }}">
        <form action="{{ route('customer.store') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="muted-label">{{ __('messages.nama') }}</label>
                <input type="text" name="nama" class="soft-input mt-1" required>
            </div>
            <div>
                <label class="muted-label">{{ __('messages.no_hp') }}</label>
                <input type="text" name="no_hp" class="soft-input mt-1" required>
            </div>
            <div>
                <label class="muted-label">{{ __('messages.alamat') }}</label>
                <textarea name="alamat" rows="3" class="soft-input mt-1" required></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <x-button type="button" variant="secondary" @click="openCreate = false">{{ __('messages.batal') }}</x-button>
                <x-button type="submit">{{ __('messages.simpan') }}</x-button>
            </div>
        </form>
    </x-modal>

    @foreach ($customer as $item)
        <x-modal show="openEdit === {{ (int) $item['id_customer'] }}" title="{{ __('messages.edit') }} {{ $item['nama'] }}">
            <form action="{{ route('customer.update', $item['id_customer']) }}" method="POST" class="space-y-3">
                @csrf
                @method('PUT')
                <div>
                    <label class="muted-label">{{ __('messages.nama') }}</label>
                    <input type="text" name="nama" value="{{ $item['nama'] }}" class="soft-input mt-1" required>
                </div>
                <div>
                    <label class="muted-label">{{ __('messages.no_hp') }}</label>
                    <input type="text" name="no_hp" value="{{ $item['no_hp'] }}" class="soft-input mt-1" required>
                </div>
                <div>
                    <label class="muted-label">{{ __('messages.alamat') }}</label>
                    <textarea name="alamat" rows="3" class="soft-input mt-1" required>{{ $item['alamat'] }}</textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <x-button type="button" variant="secondary" @click="openEdit = null">{{ __('messages.batal') }}</x-button>
                    <x-button type="submit">{{ __('messages.update') }}</x-button>
                </div>
            </form>
        </x-modal>
    @endforeach
    </div>
@endsection
