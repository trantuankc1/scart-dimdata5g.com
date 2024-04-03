<?php
if(sc_config('MomoBasic')) {
Route::group(
    [
        'prefix'    => 'plugin/payment/momobasic',
        'namespace' => 'App\Plugins\Payment\MomoBasic\Controllers',
    ], function () {
        Route::get('index', 'FrontController@index')
            ->name('momobasic.index');
        Route::get('process', 'FrontController@processResponse')
            ->name('momobasic.process');
        Route::get('ipn', 'FrontController@processIpn')
        ->name('momobasic.ipn');    
    });
}