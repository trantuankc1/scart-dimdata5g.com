<?php
    $this->loadTranslationsFrom(__DIR__.'/Lang', 'Plugins/Payment/VnpayBasic');
    $this->loadViewsFrom(__DIR__.'/Views', 'Plugins/Payment/VnpayBasic');
    $this->mergeConfigFrom(
        __DIR__.'/config.php', 'vnpay'
    );