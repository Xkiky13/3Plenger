@php
    $supportedLocales = config('locale.supported_locales', []);
    $currentLocale = app()->getLocale();
    $currentLocaleMeta = $supportedLocales[$currentLocale] ?? [];
    $currentFlag = $currentLocaleMeta['flag'] ?? '🌐';
@endphp

<div x-data="languageSwitcher()" class="relative">
    <button
        type="button"
        @click="open = !open"
        class="rounded-xl p-2 text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
    >
        <span class="sr-only">{{ __('messages.language') ?? 'Language' }}</span>
        <span class="text-lg">{{ $currentFlag }}</span>
    </button>

    <div
        x-show="open"
        @click.outside="open = false"
        x-transition
        class="absolute right-0 mt-2 w-56 rounded-xl bg-white shadow-lg dark:bg-slate-800 z-50"
    >
        <div class="p-2">
            @foreach ($supportedLocales as $localeCode => $localeMeta)
                <a
                    href="{{ languageSwitcherUrl($localeCode) }}"
                    class="block w-full text-left px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 {{ $currentLocale === $localeCode ? 'bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-300 font-semibold' : 'text-slate-700 dark:text-slate-200' }}"
                    @click="open = false"
                >
                    <span class="text-lg">{{ $localeMeta['flag'] ?? '🌐' }}</span>
                    <span class="ml-2">{{ $localeMeta['native'] ?? $localeMeta['name'] ?? strtoupper($localeCode) }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<script>
function languageSwitcher() {
    return {
        open: false,
    };
}
</script>
