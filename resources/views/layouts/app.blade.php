<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Plenger Club' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700" rel="stylesheet" />
    <style>[x-cloak]{display:none!important;}</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen" x-data="appLayout()" x-init="init()">
    <div class="pointer-events-none fixed inset-0 -z-10 bg-[radial-gradient(circle_at_10%_20%,rgba(20,184,166,0.12),transparent_45%),radial-gradient(circle_at_88%_10%,rgba(251,191,36,0.14),transparent_40%)]"></div>

    <div class="mx-auto flex max-w-[1500px] gap-4 p-4 sm:p-5 lg:gap-6 lg:p-6">
        <div
            x-show="sidebarOpen"
            x-cloak
            @click="sidebarOpen = false"
            class="fixed inset-0 z-30 bg-slate-900/40 lg:hidden"
        ></div>

        <div class="w-full max-w-72 shrink-0 lg:sticky lg:top-6 lg:h-[calc(100vh-3rem)]">
            <x-sidebar :menus="[
                ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => '🏠'],
                ['label' => 'Produk', 'route' => 'produk.index', 'icon' => '📦'],
                ['label' => 'Transaksi', 'route' => 'transaksi.index', 'icon' => '🧾'],
                ['label' => 'Riwayat Penjualan', 'route' => 'penjualan.index', 'icon' => '📚'],
                ['label' => 'Customer', 'route' => 'customer.index', 'icon' => '👥'],
                ['label' => 'Stok', 'route' => 'stok.index', 'icon' => '🏷️'],
            ]" />
        </div>

        <main class="min-w-0 flex-1">
            <x-navbar :title="$title ?? 'Dashboard'" />

            @yield('content')
        </main>
    </div>

    <div
        x-show="loading"
        x-cloak
        x-transition.opacity
        class="fixed inset-0 z-[60] grid place-items-center bg-slate-950/25 backdrop-blur-sm"
    >
        <div class="panel flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-700 dark:text-slate-200">
            <span class="h-4 w-4 animate-spin rounded-full border-2 border-slate-300 border-t-teal-500"></span>
            Loading...
        </div>
    </div>

    <div
        x-show="toastOpen"
        x-cloak
        x-transition
        class="fixed bottom-6 right-6 z-[70]"
    >
        <div class="rounded-2xl px-4 py-3 text-sm font-semibold text-white shadow-lg" :class="toastType === 'error' ? 'bg-rose-600' : 'bg-teal-600'" x-text="toastText"></div>
    </div>

    <x-modal show="confirmOpen" title="Konfirmasi Aksi">
        <p class="text-sm text-slate-600 dark:text-slate-300" x-text="confirmMessage"></p>
        <div class="mt-5 flex justify-end gap-2">
            <x-button variant="secondary" @click="closeConfirm()">Batal</x-button>
            <x-button variant="danger" @click="runConfirm()">Ya, lanjutkan</x-button>
        </div>
    </x-modal>
</body>
</html>
