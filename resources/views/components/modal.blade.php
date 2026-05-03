@props([
    'show' => 'false',
    'title' => 'Modal',
])

<div
    x-show="{{ $show }}"
    x-cloak
    x-transition.opacity
    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 p-4"
>
    <div
        @click.outside="{{ $show }} = false"
        class="panel w-full max-w-2xl p-5 sm:p-6"
    >
        <div class="mb-4 flex items-start justify-between gap-4">
            <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">{{ $title }}</h3>
            <button type="button" class="rounded-lg p-1.5 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800" @click="{{ $show }} = false">
                <span class="sr-only">Close</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{ $slot }}
    </div>
</div>
