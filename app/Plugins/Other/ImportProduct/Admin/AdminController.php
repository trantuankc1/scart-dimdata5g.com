<?php
#App\Plugins\Other\ImportProduct\Admin\AdminController.php

namespace App\Plugins\Other\ImportProduct\Admin;

use App\Http\Controllers\Controller;
use App\Plugins\Other\ImportProduct\AppConfig;
use SCart\Core\Library\ProcessData\Import;
use SCart\Core\Front\Models\ShopProduct;
use SCart\Core\Front\Models\ShopProductBuild;
use SCart\Core\Front\Models\ShopProductDescription;
use SCart\Core\Front\Models\ShopProductGroup;
use SCart\Core\Front\Models\ShopProductImage;
use SCart\Core\Front\Models\ShopProductPromotion;

class AdminController extends Controller
{
    public $plugin;

    public function __construct()
    {
        $this->plugin = new AppConfig;
    }

    public function index()
    {
        return view($this->plugin->pathPlugin.'::Admin',
            [
                'title' => trans($this->plugin->pathPlugin.'::lang.admin.title'),
                'pathPlugin' => $this->plugin->pathPlugin,
                'import_submit' => trans($this->plugin->pathPlugin.'::lang.admin.import_submit'),
                'import_note' => trans($this->plugin->pathPlugin.'::lang.admin.import_note'),
                'import_note' => trans($this->plugin->pathPlugin.'::lang.admin.import_note'),
            ]
        );
    }


/**
 * Import product
 */
    public function processImport() {
        $data = request()->all();
        $validator = \Validator::make(
            $data,
            [
                'file'   => 'required|mimetypes:application/vnd.ms-excel|max:5120',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $dataUpload = (new Import)->readFile($data['file'], 'xls');
        $headings = array_shift($dataUpload); // title line 1
        array_walk(
            $dataUpload,
            function (&$row) use ($headings) {
                $row = array_combine($headings, $row);
            }
        );
        $arraySuccess = [];
        $arrayError = [];
        foreach ($dataUpload as $k => $row) {
            try {
            //Create or update product
            $dataInsert['image']        = $row['image'] ?? '';
            $dataInsert['brand_id']     = $row['brand_id'] ?? 0;
            $dataInsert['supplier_id']  = $row['supplier_id'] ?? 0;
            $dataInsert['price']        = (int)($row['price'] ?? 0);
            $dataInsert['cost']         = (int)($row['cost'] ?? 0);
            $dataInsert['stock']        = (int)($row['stock'] ?? 0);
            $dataInsert['minimum']      = (int)($row['minimum'] ?? 0);
            $dataInsert['weight_class'] = $row['weight_class'] ?? '';
            $dataInsert['weight']       = (int)($row['weight'] ?? 0);
            $dataInsert['length_class'] = $row['length_class'] ?? '';
            $dataInsert['length']       = (int)($row['length'] ?? 0);
            $dataInsert['width']        = (int)($row['width'] ?? 0);
            $dataInsert['height']       = (int)($row['height'] ?? 0);
            $dataInsert['kind']         = (int)($row['kind'] ?? 0);
            $dataInsert['tax_id']       = (int)($row['tax_id'] ?? 0);
            $dataInsert['status']       = (int)($row['status'] ?? 0);
            $dataInsert['sort']         = (int)$row['sort'] ?? 0;

            $alias = $row['alias'] ?? ($row['name'] ?? '');
            $alias = str_replace([" ","."],["-","-"],$alias);
            $alias = sc_word_format_url($alias);
            $dataInsert['alias'] = sc_word_limit($alias, 100);

            $product = ShopProduct::updateOrCreate(
                ['sku' => $row['sku']],
                $dataInsert,
            );

            //Update category
            $listCategories = str_replace("\n","",$row['categories']);
            $arrCategory = array_filter(explode(',', $listCategories));
            $product->categories()->detach();
            $product->categories()->attach($arrCategory);


            //Update sub image
            $subImages = str_replace("\n","",$row['sub-images']);
            $arrImages = array_filter(explode(',', $subImages));
            $product->images()->delete();
            if(count($arrImages)) {
                $imagesMap = array_map(function($v){
                    return new ShopProductImage(['image' => $v]);
                },$arrImages);
                if($imagesMap) {
                    $product->images()->saveMany($imagesMap);
                }
            }
            $arraySuccess[] = $row['sku'];
            } catch (\Throwable $th) {
                $arrayError[] = [$row['sku'] => $th->getMessage()];
            }

            if (sc_config_global('MultiStorePro') || sc_config_global('MultiVendorPro')) {
                // If multi-store
                $shopStore        = [$row['store_id']];
                $product->stores()->detach();
                $product->stores()->attach($shopStore);
            }

        }
        return redirect()->back()->with(['arrayError' => $arrayError, 'arraySuccess' => $arraySuccess, 'step' => 'product']);
    }

    /**
     * Import product info
     */
    public function processImportInfo() {
        $data = request()->all();
        $validator = \Validator::make(
            $data,
            [
                'file_info'   => 'required|mimetypes:application/vnd.ms-excel|max:5120',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $dataUpload = (new Import)->readFile($data['file_info'],'xls');
        $headings = array_shift($dataUpload); // title line 1
        array_walk(
            $dataUpload,
            function (&$row) use ($headings) {
                $row = array_combine($headings, $row);
            }
        );
        $arraySuccess = [];
        $arrayError = [];
        foreach ($dataUpload as $k => $row) {
            $product = ShopProduct::where('sku', $row['sku'])->first();
            if(!$product) {
                $arrayError[] = [$row['sku'] => 'Product not found'];
                continue;
            }
            $lang = $row['lang'] ?? 'en';
            try {
            $description = strip_tags(($row['description'] ?? ''));
            $name = strip_tags(($row['name'] ?? ''));
            $keyword = strip_tags(($row['keyword'] ?? ''));
            $content = strip_tags(($row['content'] ?? ''));
            $content = str_replace("\n","<br>", $content);
            $dataInsert['name'] = $name;
            $dataInsert['keyword'] = $keyword;
            $dataInsert['description'] = $description;
            $dataInsert['content'] = $content;
            
            ShopProductDescription::updateOrCreate(
                ['product_id' => $product->id, 'lang' => $lang],
                $dataInsert
            );
            $arraySuccess[] = $row['sku'].'_'.$lang;
            } catch (\Throwable $th) {
                $indexSku = $row['sku'].'_'.$lang;
                $arrayError[] = [$indexSku => $th->getMessage()];
            }
        }
        return redirect()->back()->with(['arrayError' => $arrayError, 'arraySuccess' => $arraySuccess, 'step' => 'product-info']);
    }

/**
 * Import promotion
 */
    public function processImportPromotion() {
        $data = request()->all();
        $validator = \Validator::make(
            $data,
            [
                'file_promotion'   => 'required|mimetypes:application/vnd.ms-excel|max:5120',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $dataUpload = (new Import)->readFile($data['file_promotion'],'xls');
        $headings = array_shift($dataUpload); // title line 1
        array_walk(
            $dataUpload,
            function (&$row) use ($headings) {
                $row = array_combine($headings, $row);
            }
        );
        $arraySuccess = [];
        $arrayError = [];
        foreach ($dataUpload as $k => $row) {
            $product = ShopProduct::where('sku', $row['sku'])->first();
            if(!$product) {
                $arrayError[] = [$row['sku'] => 'Product not found'];
                continue;
            }
            try {
            $dataInsert['price_promotion'] = (int)$row['price_promotion'] ?? 0;
            $dataInsert['date_start'] = $row['date_start'] ?? null;
            $dataInsert['date_end'] = $row['date_end'] ?? null;
            $dataInsert['status_promotion'] = $row['status_promotion'] ?? 0;
            $dataInsert['product_id'] = $product->id;
            ShopProductPromotion::where('product_id',$product->id)->delete();
            ShopProductPromotion::create($dataInsert);
            $arraySuccess[] = $row['sku'];
            } catch (\Throwable $th) {
                $indexSku = $row['sku'];
                $arrayError[] = [$indexSku => $th->getMessage()];
            }
        }
        return redirect()->back()->with(['arrayError' => $arrayError, 'arraySuccess' => $arraySuccess, 'step' => 'product-promotion']);
    }

/**
 * Import build
 */
public function processImportBuild() {
    $data = request()->all();
    $validator = \Validator::make(
        $data,
        [
            'file_build'   => 'required|mimetypes:application/vnd.ms-excel|max:5120',
        ]
    );

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
    $dataUpload = (new Import)->readFile($data['file_build'],'xls');
    $headings = array_shift($dataUpload); // title line 1
    array_walk(
        $dataUpload,
        function (&$row) use ($headings) {
            $row = array_combine($headings, $row);
        }
    );
    $arraySuccess = [];
    $arrayError = [];
    foreach ($dataUpload as $k => $row) {
        try {
        $productParent = ShopProduct::where('sku', $row['sku_parent'])->first();
        if(!$productParent) {
            $arrayError[] = [$row['sku_parent'] => 'Product not found'];
            continue;
        }
        if($productParent->kind == 0) {
            $arrayError[] = [$row['sku_parent'] => 'Product single can not is parent'];
            continue;
        }
        $productChild = ShopProduct::where('sku', $row['sku_child'])->first();
        if(!$productChild) {
            $arrayError[] = [$row['sku_child'] => 'Product not found'];
            continue;
        }
        if($productChild->kind != 0) {
            $arrayError[] = [$row['sku_child'] => 'Product child must is single'];
            continue;
        }
        if($productParent->kind == 1) {
            $qty = empty($row['quantity']) ? 1: (int)$row['quantity'];
            ShopProductBuild::where(['build_id'=>$productParent->id, 'product_id' => $productChild->id])->delete();
            ShopProductBuild::create(
                [
                    'build_id' => $productParent->id,
                    'product_id' => $productChild->id,
                    'quantity' => $qty
                ]
            );
        }
        if($productParent->kind == 2) {
            ShopProductGroup::updateOrCreate(
                ['group_id' => $productParent->id, 'product_id' => $productChild->id],
            );
        }
        $arraySuccess[] = $row['sku_parent'].'__'.$row['sku_child'];
        } catch (\Throwable $th) {
            $indexSku = $row['sku_parent'].'__'.$row['sku_child'];
            $arrayError[] = [$indexSku => $th->getMessage()];
        }
    }
    return redirect()->back()->with(['arrayError' => $arrayError, 'arraySuccess' => $arraySuccess, 'step' => 'product-build']);
    }
}
