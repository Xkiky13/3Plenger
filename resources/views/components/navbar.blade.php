@props(['title' => 'Dashboard'])

<header class="panel sticky top-4 z-30 mb-6 flex items-center justify-between gap-3 px-4 py-3 sm:px-5">
    <div class="flex items-center gap-2">
        <button
            class="rounded-xl p-2 text-slate-600 hover:bg-slate-100 lg:hidden dark:text-slate-300 dark:hover:bg-slate-800"
            @click="sidebarOpen = true"
            type="button"
        >
            <span class="sr-only">Open Sidebar</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">Sistem Penjualan</p>
            <h1 class="text-base font-semibold text-slate-800 dark:text-slate-100">{{ $title }}</h1>
        </div>
    </div>

    <div class="flex items-center gap-2">
        <button
            type="button"
            class="rounded-xl p-2 text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
            @click="toggleTheme"
        >
            <span class="sr-only">Toggle Theme</span>
            <svg x-show="!isDark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v2.5m0 13V21m8.49-8.5H18m-12 0H3.5m14.26-5.76-1.77 1.77M7.99 16.01l-1.77 1.77m0-11.04 1.77 1.77m8.77 8.77 1.77 1.77M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <svg x-show="isDark" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 12.79A9 9 0 1111.21 3c0 4.97 4.03 9 9 9h.79z" />
            </svg>
        </button>

        <div class="h-8 w-8 rounded-xl bg-gradient-to-br from-teal-500 to-cyan-500"></div>
    </div>
</header>
