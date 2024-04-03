<?php
#App\Plugins\Other\ProductFlashSale\Controllers\FrontController.php
namespace App\Plugins\Other\ProductFlashSale\Controllers;

use App\Plugins\Other\ProductFlashSale\AppConfig;
use SCart\Core\Front\Controllers\RootFrontController;
class FrontController extends RootFrontController
{
    public $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
    }

    public function index() {
        return view($this->plugin->pathPlugin.'::Front',
            [
                //
            ]
        );
    }

    /**
     * Process front flash sale
     *
     * @param [type] ...$params
     * @return void
     */
    public function flashSaleProcessFront(...$params) 
    {
        if (config('app.seoLang')) {
            $lang = $params[0] ?? '';
            sc_lang_switch($lang);
        }
        return $this->_flashSaleProcess();
    }


    /**
     * flashSaleProcess product
     * @return [view]
     */
    private function _flashSaleProcess()
    {
        $filter_sort = request('filter_sort') ?? '';
        if (function_exists('sc_product_flash')) {
            $products = sc_product_flash(sc_config('product_list'), $paginate = true);
        } else {
            $products = [];
        }
        sc_check_view($this->templatePath . '.screen.shop_product_list');
        return view(
            $this->templatePath . '.screen.shop_product_list',
            array(
                'title' => sc_language_render('front.flash_title'),
                'products' => $products,
                'layout_page' => 'shop_product_list',
                'filter_sort' => $filter_sort,
            )
        );
    }
}
