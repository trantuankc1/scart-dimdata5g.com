<?php
/**
 * Route front
 */


use App\Plugins\Payment\VnpayBasic\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

if (sc_config('VnpayBasic')) {
    Route::group(
        [
            'prefix' => 'plugin/payment/vnpay_basic',
            'namespace' => 'App\Plugins\Payment\VnpayBasic\Controllers',
        ],
        function () {
            Route::get('index', [FrontController::class, 'index'])
                ->name('vnpay_basic.index');

            Route::post('process-form', [FrontController::class, 'processForm'])
                ->name('vnpay_basic.process_form');

            Route::get('process', [FrontController::class, 'processResponse'])
                ->name('vnpay_basic.process');
        }

    );
}