<?php
/**
 * Provides everything needed for the Plugin
 */
    $this->loadTranslationsFrom(__DIR__.'/Lang', 'Plugins/Payment/Sepay');
    $this->loadViewsFrom(__DIR__.'/Views', 'Plugins/Payment/Sepay');

    if (sc_config('Sepay')) {
    // $this->mergeConfigFrom(
    //     __DIR__.'/config.php', 'key_define_for_plugin'
    // );
    }
