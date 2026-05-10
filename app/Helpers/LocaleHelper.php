<?php

if (!function_exists('get_currency_symbol')) {
    function get_currency_symbol($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $defaultLocale = config('locale.default', 'id');
        $currency = config('locale.currency_map.' . $locale, config('locale.currency_map.' . $defaultLocale, 'IDR'));

        return config('locale.currency_symbol.' . $currency, '');
    }
}

if (!function_exists('format_currency')) {
    function format_currency($amount, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $defaultLocale = config('locale.default', 'id');
        $currency = config('locale.currency_map.' . $locale, config('locale.currency_map.' . $defaultLocale, 'IDR'));
        $symbol = get_currency_symbol($locale);

        $formatted = number_format($amount, 0, ',', '.');

        return match($currency) {
            'IDR', 'JPY', 'KRW', 'VND' => $symbol . ' ' . $formatted,
            'USD', 'EUR', 'TRY', 'RUB', 'SAR', 'CNY', 'THB', 'MYR', 'INR' => $symbol . number_format($amount, 2, '.', ','),
            default => $formatted,
        };
    }
}

if (!function_exists('trans_choice_id')) {
    function trans_choice_id($key, $count, array $replace = [], $locale = null)
    {
        return trans_choice($key, $count, $replace, $locale);
    }
}

if (!function_exists('languageSwitcherUrl')) {
    /**
     * Generate a localized URL for the current page.
     */
    function languageSwitcherUrl($targetLocale, $dashboardPrefix = null)
    {
        $supportedLocales = array_keys(config('locale.supported_locales', []));
        $defaultLocale = config('locale.default', 'id');

        if (! in_array($targetLocale, $supportedLocales, true)) {
            $targetLocale = $defaultLocale;
        }

        if (app()->bound('laravellocalization')) {
            $localizedUrl = app('laravellocalization')->getLocalizedURL($targetLocale, request()->fullUrl(), [], true);

            if (is_string($localizedUrl) && $localizedUrl !== '') {
                return $localizedUrl;
            }
        }

        $segments = request()->segments();
        if (! empty($segments) && in_array($segments[0], $supportedLocales, true)) {
            array_shift($segments);
        }

        array_unshift($segments, $targetLocale);

        $url = url(implode('/', $segments));
        $queryString = request()->getQueryString();

        return $queryString ? $url . '?' . $queryString : $url;
    }
}
