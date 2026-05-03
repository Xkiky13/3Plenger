@props(['menus' => []])

<aside class="panel fixed inset-y-4 left-4 z-40 w-72 px-4 py-5 lg:static lg:inset-auto lg:w-full" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-[120%] lg:translate-x-0'">
    <div class="mb-6 flex items-center gap-3">
        <div class="h-10 w-10 rounded-2xl bg-gradient-to-br from-amber-400 to-teal-500"></div>
        <div>
            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">Plenger Club</p>
            <p class="text-xs text-slate-500 dark:text-slate-400">Admin Dashboard</p>
        </div>
    </div>

    <nav class="space-y-1.5">
        @foreach ($menus as $menu)
            <a
                href="{{ route($menu['route']) }}"
                @click="startLoading(); sidebarOpen = false"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs($menu['route']) ? 'bg-teal-500 text-white shadow-sm shadow-teal-500/30' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}"
            >
                <span>{{ $menu['icon'] }}</span>
                <span>{{ $menu['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="mt-6 rounded-2xl bg-gradient-to-br from-slate-900 to-slate-700 p-4 text-slate-100 dark:from-slate-800 dark:to-slate-700">
        <p class="text-sm font-semibold">Insights</p>
        <p class="mt-1 text-xs text-slate-200/90">Pantau performa produk terlaris dan stok rendah setiap hari.</p>
    </div>
</aside>
