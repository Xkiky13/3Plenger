<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request, $locale)
    {
        $supported = array_keys(config('locale.supported_locales', []));

        if (! in_array($locale, $supported, true)) {
            abort(404);
        }

        session()->put('locale', $locale);
        app()->setLocale($locale);

        $previousUrl = url()->previous();
        $redirectUrl = app('laravellocalization')->getLocalizedURL($locale, $previousUrl, [], true) ?? url('/');

        return redirect()->to($redirectUrl);
    }

    public function getCurrent()
    {
        $locale = app()->getLocale();
        $defaultLocale = config('locale.default', 'id');

        return response()->json([
            'locale' => $locale,
            'currency' => config('locale.currency_map.' . $locale, config('locale.currency_map.' . $defaultLocale, 'IDR')),
            'supported_locales' => array_keys(config('locale.supported_locales', [])),
        ]);
    }
}
