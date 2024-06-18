<?php
/**
 * Route front
 */

use Illuminate\Support\Facades\Route;

if (sc_config('Sepay')) {
    Route::group(
        [
            'prefix' => 'plugin/sepay',
            'namespace' => 'App\Plugins\Payment\Sepay\Controllers',
        ],
        function () {
            Route::get('index', 'FrontController@index')
                ->name('sepay.index');
        }

    );
}


/**
 * Route admin
 */
Route::group(
    [
        'prefix' => SC_ADMIN_PREFIX . '/sepay',
        'middleware' => SC_ADMIN_MIDDLEWARE,
        'namespace' => 'App\Plugins\Payment\Sepay\Admin',
    ],
    function () {
        Route::get('/', 'AdminController@index')
            ->name('admin_sepay.index');
    }
);
