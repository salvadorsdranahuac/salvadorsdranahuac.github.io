<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        function ($request, $next) {
            App::setLocale(session('locale', 'en'));

            return $next($request);
        }
    ]
], function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/lang/{locale}', function ($locale) {
        if (in_array($locale, ['en', 'es'])) {
            session(['locale' => $locale]);
        }

        return back();
    });

});