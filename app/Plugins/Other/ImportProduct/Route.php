<?php
/**
 * Route admin
 */
Route::group(
    [
        'prefix' => SC_ADMIN_PREFIX.'/import_product',
        'middleware' => SC_ADMIN_MIDDLEWARE,
        'namespace' => 'App\Plugins\Other\ImportProduct\Admin',
    ], 
    function () {
        Route::get('/', 'AdminController@index')
        ->name('admin_import_product.index');
        Route::post('/processImport', 'AdminController@processImport')
        ->name('admin_import_product.process_import');
        Route::post('/processImportInfo', 'AdminController@processImportInfo')
        ->name('admin_import_product.process_import_info');
        Route::post('/processImportPromotion', 'AdminController@processImportPromotion')
        ->name('admin_import_product.process_import_promotion');
        Route::post('/processImportBuild', 'AdminController@processImportBuild')
        ->name('admin_import_product.process_import_build');
    }
);
