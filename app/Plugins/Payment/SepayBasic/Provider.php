<?php
    $this->loadTranslationsFrom(__DIR__.'/Lang', 'Plugins/Payment/SepayBasic');
    $this->loadViewsFrom(__DIR__.'/Views', 'Plugins/Payment/SepayBasic');
    $this->mergeConfigFrom(
        __DIR__.'/config.php', 'sepay'
    );