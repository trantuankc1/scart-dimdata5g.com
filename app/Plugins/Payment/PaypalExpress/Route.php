<?php
/**
 * Route front
 */
if(sc_config('PaypalExpress')) {
Route::group(
    [
        'prefix'    => 'plugin/paypalexpress',
        'namespace' => 'App\Plugins\Payment\PaypalExpress\Controllers',
    ],
    function () {
        Route::get('index', 'FrontController@index')
        ->name('paypalexpress.index');
        Route::get('process-order', 'FrontController@processOrder')
        ->name('paypalexpress.processOrder');
        Route::get('return/{orderId}', 'FrontController@getReturn')
        ->name('paypalexpress.return');
    }
);
}
/**
 * Route admin
 */
Route::group(
    [
        'prefix' => SC_ADMIN_PREFIX.'/paypalexpress',
        'middleware' => SC_ADMIN_MIDDLEWARE,
        'namespace' => 'App\Plugins\Payment\PaypalExpress\Admin',
    ], 
    function () {
        Route::get('/', 'AdminController@index')
        ->name('admin_paypalexpress.index');
    }
);
