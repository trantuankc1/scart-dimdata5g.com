<?php
#App\Plugins\Other\ProductFlashSale\Models\PluginModel.php
namespace App\Plugins\Other\ProductFlashSale\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SCart\Core\Front\Models\ShopProduct;
use SCart\Core\Front\Models\ShopProductPromotion;

class PluginModel extends Model
{
    use \SCart\Core\Front\Models\UuidTrait;
    
    public $timestamps    = false;
    public $table = SC_DB_PREFIX.'shop_product_flash';
    protected $connection = SC_CONNECTION;
    protected $guarded    = [];

    public function product()
    {
        return $this->belongsTo(ShopProduct::class, 'product_id', 'id');
    }

    public function uninstallExtension()
    {
        if (Schema::hasTable($this->table)) {
            Schema::drop($this->table);
        }
        return ['error' => 0, 'msg' => 'uninstall success'];
    }

    public function installExtension()
    {
        $this->uninstallExtension();

        Schema::create($this->table, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id')->unique();
            $table->integer('stock');
            $table->integer('sold');
            $table->integer('sort');
        });

        return ['error' => 0, 'msg' => 'install success'];
    }

    /**
     * Get produc flash sale
     *
     * @return void
     */
    public function getProduct($pid) {
        $select = $this->table.'.*, pr.price_promotion, pr.date_start, pr.date_end, pr.status_promotion';
        return $this->leftjoin(SC_DB_PREFIX.'shop_product_promotion as pr', 'pr.product_id', $this->table.'.product_id')
            ->selectRaw($select)
            ->where($this->table.'.id', $pid)
            ->first();
    }

    /**
     * Get all product flash sale
     *
     * @return void
     */
    public function getAllProductFlashSale() {
        $select = $this->table.'.*, pr.price_promotion, pr.date_start, pr.date_end, pr.status_promotion';
        return  $this->leftjoin(SC_DB_PREFIX.'shop_product_promotion as pr', 'pr.product_id', $this->table.'.product_id')
            ->selectRaw($select)
            ->paginate(20);
    }

    /**
     * Get name product not group
     *
     * @return void
     */
    public function getAllProductNotGroup() {
        return (new ShopProduct)
            ->leftJoin(SC_DB_PREFIX . 'shop_product_description', SC_DB_PREFIX . 'shop_product_description.product_id', SC_DB_PREFIX.'shop_product.id')
            ->where(SC_DB_PREFIX . 'shop_product_description.lang', sc_get_locale())
            ->whereIn('kind', [SC_PRODUCT_SINGLE, SC_PRODUCT_BUILD])
            ->get()
            ->pluck('name', 'id');
    }
    

    /**
     * Get product flash
     *
     * @return void
     */
    public function getProductFlash($limit = 8, $paginate = false) {
        $productFlash = (new ShopProduct)
            ->select(SC_DB_PREFIX.'shop_product.*', 'pf.sold as pf_sold', 'pf.stock as pf_stock')
            ->join(SC_DB_PREFIX.'shop_product_flash as pf', 'pf.product_id', SC_DB_PREFIX.'shop_product.id')
            ->join(SC_DB_PREFIX.'shop_product_promotion as pr', 'pr.product_id', 'pf.product_id');

            if (sc_config_global('MultiStorePro') || (sc_config_global('MultiVendorPro') && config('app.storeId') != SC_ID_ROOT)) {
                $tableProductStore = (new \SCart\Core\Front\Models\ShopProductStore)->getTable();
                $tableStore = (new \SCart\Core\Front\Models\ShopStore)->getTable();
                $productFlash = $productFlash->join($tableProductStore, $tableProductStore.'.product_id', SC_DB_PREFIX.'shop_product' . '.id');
                $productFlash = $productFlash->join($tableStore, $tableStore . '.id', $tableProductStore.'.store_id');
                $productFlash = $productFlash->where($tableStore . '.status', '1');
                $productFlash = $productFlash->where($tableProductStore.'.store_id', config('app.storeId'));
            }
            $productFlash = $productFlash->where('pr.status_promotion', 1)
                ->where('pr.date_start', '<=', date('Y-m-d'))
                ->where('pr.date_end', '>=', date('Y-m-d'))
                ->whereColumn('pf.sold', '<', 'pf.stock')
                ->orderBy('pf.sort', 'asc');
        if ($paginate) {
            $productFlash = $productFlash->paginate($limit);
        } else {
            $productFlash = $productFlash->limit($limit)->get();
        }
        return $productFlash;
    }

    protected static function boot()
    {
        parent::boot();
        // before delete() method call this
        static::deleting(function ($item) {
            //Delete promotion
            (new ShopProductPromotion)->where('product_id', $item->product_id)->delete();
            }
        );

        //Uuid
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = sc_generate_id($type = 'shop_product_flash');
            }
        });
    }
}
