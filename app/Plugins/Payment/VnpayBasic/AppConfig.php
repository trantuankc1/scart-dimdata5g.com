<?php
/**
 * AppConfig Vnpay basic
 * User for Vnpay api v2.0
 * http://sandbox.vnpayment.vn/paymentv2/vpcpay.html
 *
 * @package    App\Plugins\Payment\VnpayBasic
 * @subpackage AppConfig
 * @copyright  Copyright (c) 2020 SCart ecommerce.
 * @author     Lanh le <lanhktc@gmail.com>
 */
#App\Plugins\Payment\VnpayBasic\AppConfig.php
namespace App\Plugins\Payment\VnpayBasic;

use App\Plugins\Payment\VnpayBasic\Models\PluginModel;
use SCart\Core\Admin\Models\AdminConfig;
use SCart\Core\Front\Models\ShopOrderStatus;
use SCart\Core\Front\Models\ShopPaymentStatus;
use App\Plugins\ConfigDefault;
class AppConfig extends ConfigDefault
{
    public $currencyAllow;
    public $urlApi;
    private $secretKey;
    private $partnerCode;

    const ORDER_STATUS_PROCESSING = 2; // Processing
    const ORDER_STATUS_FAILD = 6; // Failed
    const PAYMENT_STATUS = 3; // Paid

    public function __construct()
    {
        //Read config from config.json
        $config = file_get_contents(__DIR__.'/config.json');
        $config = json_decode($config, true);
    	$this->configGroup = $config['configGroup'];
    	$this->configCode = $config['configCode'];
        $this->configKey = $config['configKey'];
        //Path
        $this->pathPlugin = $this->configGroup . '/' . $this->configCode . '/' . $this->configKey;
        //Language
        $this->title = trans($this->pathPlugin.'::lang.title');
        //Image logo or thumb
        $this->image = $this->pathPlugin.'/'.$config['image'];
        //
        $this->version = $config['version'];
        $this->auth = $config['auth'];
        $this->link = $config['link'];

        
        $this->currencyAllow = ['VND'];
        //Process Payment
        $this->secretKey = sc_config('vnpay_secretKey');
        $this->partnerCode = sc_config('vnpay_partnerCode');
        $this->urlApi = sc_config('vnpay_urlApi');
    }

    /**
     * Get secrectkey
     */
    public function getSecretKey() {
        return $this->secretKey;
    }

    /**
     * Get partnerCode
     */
    public function getPartnerCode() {
        return $this->partnerCode;
    }

    public function install()
    {
        $return = ['error' => 0, 'msg' => ''];
        $check = AdminConfig::where('key', $this->configKey)->first();
        if ($check) {
            //Check Plugin key exist
            $return = ['error' => 1, 'msg' => 'Plugin exist'];
        } else {
            //Insert plugin to config
            $dataInsert = [
                [
                    'group' => $this->configGroup,
                    'code' => $this->configCode,
                    'key' => $this->configKey,
                    'sort' => 0,
                    'value' => self::ON, //Enable extension
                    'detail' => $this->pathPlugin.'::lang.title',
                ],
                [
                    'group' => '',
                    'code' => $this->configKey.'_config',
                    'key' => 'vnpay_urlApi',
                    'sort' => 0, // Sort extensions in group
                    'value' => 'http://sandbox.vnpayment.vn/paymentv2/vpcpay.html',
                    'detail' => $this->pathPlugin.'::lang.vnpay_urlApi',
                ],
                [
                    'group' => '',
                    'code' => $this->configKey.'_config',
                    'key' => 'vnpay_secretKey',
                    'sort' => 0, // Sort extensions in group
                    'value' => '',
                    'detail' => $this->pathPlugin.'::lang.vnpay_secretKey',
                ],
                [
                    'group' => '',
                    'code' => $this->configKey.'_config',
                    'key' => 'vnpay_partnerCode',
                    'sort' => 0, // Sort extensions in group
                    'value' => '',
                    'detail' => $this->pathPlugin.'::lang.vnpay_partnerCode',
                ],
                [
                    'group' => '',
                    'code' => $this->configKey.'_config',
                    'key' => 'vnpay_order_status_faild',
                    'sort' => 0, // Sort extensions in group
                    'value' => self::ORDER_STATUS_FAILD,
                    'detail' => $this->pathPlugin.'::lang.vnpay_order_status_faild',
                ],
                [
                    'group' => '',
                    'code' => $this->configKey.'_config',
                    'key' => 'vnpay_order_status_success',
                    'sort' => 0, // Sort extensions in group
                    'value' => self::ORDER_STATUS_PROCESSING,
                    'detail' => $this->pathPlugin.'::lang.vnpay_order_status_success',
                ],
                [
                    'group' => '',
                    'code' => $this->configKey.'_config',
                    'key' => 'vnpay_payment_status',
                    'sort' => 0, // Sort extensions in group
                    'value' => self::PAYMENT_STATUS,
                    'detail' => $this->pathPlugin.'::lang.vnpay_payment_status',
                ],
            ];
            $process = AdminConfig::insert(
                $dataInsert
            );

            if (!$process) {
                $return = ['error' => 1, 'msg' => 'Error when install'];
            } else {
                $return = (new PluginModel)->installExtension();
            }
        }

        return $return;
    }

    public function uninstall()
    {
        $return = ['error' => 0, 'msg' => ''];
        //Please delete all values inserted in the installation step
        $process = (new AdminConfig)->where('key', $this->configKey)->delete();
        $process2 = (new AdminConfig)->where('code', $this->configKey.'_config')->delete();
        if (!$process && $process2) {
            $return = ['error' => 1, 'msg' => 'Error when uninstall'];
        }
        (new PluginModel)->uninstallExtension();
        return $return;
    }
    
    public function enable()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)->where('key', $this->configKey)->update(['value' => self::ON]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error enable'];
        }
        return $return;
    }

    public function disable()
    {
        $return = ['error' => 0, 'msg' => ''];
        $process = (new AdminConfig)
            ->where('key', $this->configKey)
            ->update(['value' => self::OFF]);
        if (!$process) {
            $return = ['error' => 1, 'msg' => 'Error disable'];
        }
        return $return;
    }

    public function config()
    {
        $breadcrumb['url'] = sc_route_admin('admin_plugin', ['code' => $this->configCode]);
        $breadcrumb['name'] = sc_language_render('plugin.' . $this->configCode.'_plugin');
        return view($this->pathPlugin . '::Admin')->with(
            [
                'code' => $this->configCode,
                'key' => $this->configKey,
                'title' => $this->title,
                'breadcrumb' => $breadcrumb,
                'jsonStatusOrder' => json_encode(ShopOrderStatus::getIdAll()),
                'jsonPaymentStatus' => json_encode(ShopPaymentStatus::getIdAll()),
            ]);
    }

    public function getData()
    {
        $arrData = [
            'title' => $this->title,
            'code' => $this->configCode,
            'key' => $this->configKey,
            'image' => $this->image,
            'permission' => self::ALLOW,
            'version' => $this->version,
            'auth' => $this->auth,
            'link' => $this->link,
            'pathPlugin' => $this->pathPlugin
        ];

        return $arrData;
    }

    /**
     * Process after order success
     *
     * @param   [array]  $data  
     *
     */
    public function endApp($data = []) {
        //action after end app
    }
}
