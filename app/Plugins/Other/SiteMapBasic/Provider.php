<?php
/**
 * Provides everything needed for the Plugin
 */
    $this->loadTranslationsFrom(__DIR__.'/Lang', 'Plugins/Other/SiteMapBasic');
    $this->loadViewsFrom(__DIR__.'/Views', 'Plugins/Other/SiteMapBasic');

    if (sc_config('SiteMapBasic')) {
    // $this->mergeConfigFrom(
    //     __DIR__.'/config.php', 'key_define_for_plugin'
    // );
    }
