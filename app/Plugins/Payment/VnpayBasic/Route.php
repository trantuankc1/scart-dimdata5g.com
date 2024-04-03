<?php
/**
 * Route front
 */
if(sc_config('VnpayBasic')) {
Route::group(
    [
        'prefix'    => 'plugin/payment/vnpay_basic',
        'namespace' => 'App\Plugins\Payment\VnpayBasic\Controllers',
    ],
    function () {
        Route::get('index', 'FrontController@index')
        ->name('vnpay_basic.index');
        Route::post('process-form', 'FrontController@processForm')
        ->name('vnpay_basic.process_form');
        Route::get('process', 'FrontController@processResponse')
        ->name('vnpay_basic.process');
    }
    
);
}