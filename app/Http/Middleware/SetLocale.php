<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = array_keys(config('locale.supported_locales', []));
        $defaultLocale = config('locale.default', 'id');
        $sessionLocale = session('locale', $defaultLocale);
        $urlLocale = (string) $request->segment(1, '');

        $locale = in_array($urlLocale, $supportedLocales, true)
            ? $urlLocale
            : (in_array($sessionLocale, $supportedLocales, true) ? $sessionLocale : $defaultLocale);

        app()->setLocale($locale);
        session(['locale' => $locale]);
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
