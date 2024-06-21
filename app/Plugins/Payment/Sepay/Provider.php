<?php
    $this->loadTranslationsFrom(__DIR__.'/Lang', 'Plugins/Payment/Sepay');
    $this->loadViewsFrom(__DIR__.'/Views', 'Plugins/Payment/Sepay');
    $this->mergeConfigFrom(
        __DIR__.'/config.php', 'sepay'
    );