@props([
    'variant' => 'primary',
    'type' => 'button',
])

@php
    $variant = (string) $variant;

    $variants = [
        'primary' => 'bg-teal-600 text-white hover:bg-teal-700 focus:ring-teal-300 dark:focus:ring-teal-900',
        'secondary' => 'bg-slate-200 text-slate-700 hover:bg-slate-300 focus:ring-slate-300 dark:bg-slate-700 dark:text-slate-100 dark:hover:bg-slate-600',
        'danger' => 'bg-rose-600 text-white hover:bg-rose-700 focus:ring-rose-300 dark:focus:ring-rose-900',
        'ghost' => 'bg-transparent text-slate-600 hover:bg-slate-100 focus:ring-slate-200 dark:text-slate-300 dark:hover:bg-slate-800',
    ];

    $className = $variants[$variant] ?? $variants['primary'];
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => "inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold transition focus:outline-none focus:ring-2 {$className}",
    ]) }}
>
    {{ $slot }}
</button>
