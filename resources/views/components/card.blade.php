@props(['title' => null, 'subtitle' => null])

<section {{ $attributes->merge(['class' => 'panel p-5 sm:p-6']) }}>
    @if($title)
        <header class="mb-4">
            <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">{{ $title }}</h3>
            @if($subtitle)
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $subtitle }}</p>
            @endif
        </header>
    @endif

    {{ $slot }}
</section>
