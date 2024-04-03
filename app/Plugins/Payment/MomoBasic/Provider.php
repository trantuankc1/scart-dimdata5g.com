<?php
    $this->loadTranslationsFrom(__DIR__.'/Lang', 'Plugins/Payment/MomoBasic');
    $this->loadViewsFrom(__DIR__.'/Views', 'Plugins/Payment/MomoBasic');
    $this->mergeConfigFrom(
        __DIR__.'/config.php', 'momo'
    );