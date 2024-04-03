<?php
/**
 * AppConfig Momo basic
 * User for Momo api v1.0
 *
 * @package    App\Plugins\Payment\MomoBasic
 * @subpackage AppConfig
 * @copyright  Copyright (c) 2020 SCart opensource.
 * @author     Lanh le <lanhktc@gmail.com>
 */
#App\Plugins\Payment\MomoBasic\AppConfig.php

namespace App\Plugins\Payment\MomoBasic;
use App\Plugins\Payment\MomoBasic\Models\PluginModel;
use SCart\Core\Admin\Models\AdminConfig;
use SCart\Core\Front\Models\ShopOrderStatus;
use SCart\Core\Front\Models\ShopPaymentStatus;
use App\Plugins\ConfigDefault;

use App\Plugins\Payment\MomoBasic\ProcessPayment;


class AppConfig extends ConfigDefault
{
    const ORDER_STATUS_PROCESSING = 2; // Processing
    const ORDER_STATUS_FAILD = 6; // Failed
    const PAYMENT_STATUS = 3; // Paid

    private $urlAPI;
    private $accessKey;
    private $secretKey;
    private $partnerCode;
    public $payment;
    public $currencyAllow;
    
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

        //Process Payment
        $this->accessKey = sc_config('momo_accessKey');
        $this->secretKey = sc_config('momo_secretKey');
        $this->partnerCode = sc_config('momo_partnerCode');

        if(sc_config('momo_env') == 'production'){
            $this->urlAPI = 'https://payment.momo.vn';
        } else {
            $this->urlAPI = 'https://test-payment.momo.vn';
        }

        $this->currencyAllow = ['VND'];
        $this->payment = new ProcessPayment($this->accessKey, $this->partnerCode, $this->secretKey, $this->urlAPI);
    }

    public function install()
    {
        $return = ['error' => 0, 'msg' => ''];
        $check = AdminConfig::where('key', $this->configKey)->first();
        if ($check) {
            //Check Plugin key exist
            $return = ['error' => 1, 'msg' => 'Plugin exist'];
        } else {
            $dataInsert = [
                [
                    'group' => $this->configGroup,
                    'code' => $this->configCode,
                    'key' => $this->configKey,
                    'sort' => 0, // Sort extensions in group
                    'value' => self::ON, //1- Enable extension; 0 - Disable
                    'detail' => $this->pathPlugin.'::lang.title',
                ],
                [
                    'group' => '',
                    'code' => $this->configKey.'_config',
                    'key' => 'momo_accessKey',
                    'sort' => 0, // Sort extensions in group
                    'value' => '',
                    'detail' => $this->pathPlugin.'::lang.momo_accessKey',
                ],
                [
                    'group' => '',
                    'code' => $this->configKey.'_config',
                    'key' => 'momo_secretKey',
                    'sort' => 0, // Sort extensions in group
                    'value' => '',
                    'detail' => $this->pathPlugin.'::lang.momo_secretKey',
                ],
                [
                    'group' => '',
                    'code' => $this->configKey.'_config',
                    'key' => 'momo_partnerCode',
                    'sort' => 0, // Sort extensions in group
                    'value' => '',
                    'detail' => $this->pathPlugin.'::lang.momo_partnerCode',
                ],
                [
                    'group' => '',
                    'code' => $this->configKey.'_config',
                    'key' => 'momo_env',
                    'sort' => 0, // Sort extensions in group
                    'value' => 'sandbox',
                    'detail' => $this->pathPlugin.'::lang.momo_env',
                ],
                [
                    'group' => '',
                    'code' => $this->configKey.'_config',
                    'key' => 'momo_order_status_faild',
                    'sort' => 0, // Sort extensions in group
                    'value' => self::ORDER_STATUS_FAILD,
                    'detail' => $this->pathPlugin.'::lang.momo_order_status_faild',
                ],
                [
                    'group' => '',
                    'code' => $this->configKey.'_config',
                    'key' => 'momo_order_status_success',
                    'sort' => 0, // Sort extensions in group
                    'value' => self::ORDER_STATUS_PROCESSING,
                    'detail' => $this->pathPlugin.'::lang.momo_order_status_success',
                ],
                [
                    'group' => '',
                    'code' => $this->configKey.'_config',
                    'key' => 'momo_payment_status',
                    'sort' => 0, // Sort extensions in group
                    'value' => self::PAYMENT_STATUS,
                    'detail' => $this->pathPlugin.'::lang.momo_payment_status',
                ],


            ];
            //Insert plugin to config
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
            ]
        );
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
