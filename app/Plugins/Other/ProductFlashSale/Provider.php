<?php
    $this->loadTranslationsFrom(__DIR__.'/Lang', 'Plugins/Other/ProductFlashSale');
    $this->loadViewsFrom(__DIR__.'/Views', 'Plugins/Other/ProductFlashSale');
    // $this->mergeConfigFrom(
    //     __DIR__.'/config.php', 'key_define_for_plugin'
    // );
    if(sc_config('ProductFlashSale')) {
        /**
         *Check product flash sale over stock
        */
        if (!function_exists('sc_product_flash_check_over')) {
            function sc_product_flash_check_over($pId, $qty) {
                $product = (new \App\Plugins\Other\ProductFlashSale\Models\PluginModel)
                    ->where('product_id', $pId)
                    ->first();
                if ($product && ((int)$product ->stock - (int)$product->sold) < $qty) {
                    return false;
                } else {
                    return true;
                }
            }
        }

        /**
         * Update stock flash sale
         */
        if (!function_exists('sc_product_flash_update_stock')) {
            function sc_product_flash_update_stock($pId, $qty) {
                $product = (new \App\Plugins\Other\ProductFlashSale\Models\PluginModel)
                    ->where('product_id', $pId)
                    ->first();
                if ($product) {
                    $product->sold = $product->sold + $qty;
                    $product->save();
                }
            }
        }

        /**
         * Get top flash sale
         */
        if (!function_exists('sc_product_flash')) {
            function sc_product_flash($limit = 8, $paginate = false) {
                $productFlash = (new \App\Plugins\Other\ProductFlashSale\Models\PluginModel)->getProductFlash($limit, $paginate);
                return $productFlash;
            }
            
        }
    }