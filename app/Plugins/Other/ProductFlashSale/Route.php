<?php
/**
 * Route front
 */
if(sc_config('ProductFlashSale')) {
     
Route::group(
    [
        'prefix' => $langUrl
    ], 
    function ($router) {
        $router->get('flash-sale.html', '\App\Plugins\Other\ProductFlashSale\Controllers\FrontController@flashSaleProcessFront')
            ->name('flash-sale');
    }
);

Route::group(
    [
        'prefix'    => 'plugin/productflashsale',
        'namespace' => 'App\Plugins\Other\ProductFlashSale\Controllers',
    ],
    function () {
        Route::get('index', 'FrontController@index')
        ->name('productflashsale.index');
    }
);
}
/**
 * Route admin
 */
Route::group(
    [
        'prefix' => SC_ADMIN_PREFIX.'/productflashsale',
        'middleware' => SC_ADMIN_MIDDLEWARE,
        'namespace' => 'App\Plugins\Other\ProductFlashSale\Admin',
    ], 
    function () {
        Route::get('/', 'AdminController@index')
        ->name('admin_productflashsale.index');
        Route::post('/create', 'AdminController@postCreate')->name('admin_productflashsale.create');
        Route::get('/edit/{id}', 'AdminController@edit')->name('admin_productflashsale.edit');
        Route::post('/edit/{id}', 'AdminController@postEdit')->name('admin_productflashsale.edit');
        Route::post('/delete', 'AdminController@deleteList')->name('admin_productflashsale.delete');
    }
);
