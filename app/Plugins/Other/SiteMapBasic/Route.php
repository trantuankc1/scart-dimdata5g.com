<?php
/**
 * Route front
 */
if(sc_config('SiteMapBasic')) {
    Route::group(
        [
            'prefix'    => 'sitemap-basic',
            'namespace' => 'App\Plugins\Other\SiteMapBasic\Controllers',
        ],
        function () {
            Route::get('sitemap.xml', 'FrontController@index')
            ->name('SiteMapBasic.index');
        }
    );
}