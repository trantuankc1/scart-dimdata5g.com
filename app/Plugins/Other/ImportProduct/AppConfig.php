<?php
/**
 * Format plugin for S-Cart 3.x
 */
#App\Plugins\Other\ImportProduct\AppConfig.php
namespace App\Plugins\Other\ImportProduct;

use App\Plugins\Other\ImportProduct\Models\PluginModel;
use SCart\Core\Admin\Models\AdminConfig;
use App\Plugins\ConfigDefault;
class AppConfig extends ConfigDefault
{
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
            $process = AdminConfig::insert(
                [
                    'group' => $this->configGroup,
                    'code' => $this->configCode,
                    'key' => $this->configKey,
                    'sort' => 0,
                    'value' => self::ON, //Enable extension
                    'detail' => $this->pathPlugin.'::lang.title',
                ]
            );

            /*Insert plugin's html elements into index of admin pages*/

            AdminConfig::insert(
                [
                    /*
                    This is where the html content of the Plugin appears
                    group_of_layout allow:
                    Position include "menuLeft,topMenuRight, topMenuLeft, topMenuRight, blockBottom" -> Show on all index pages in admin with corresponding position as above.
                    or Position_route_name_of_admin_page. Example menuLeft_admin_product.index, topMenuLeft_admin_order.index
                    */
                    'group' => 'menuLeft__admin_product.index',
                    /*
                    code is value option
                    */
                    'code' => $this->configKey.'_config',
                    'key' => $this->configKey.'_config_1', //
                    'sort' => 0, // int value
                    'value' => '<a href="'.sc_route_admin('admin.home').'/import_product" target="_new"><span class="btn btn-success btn-flat"><i class="fas fa-file-export"></i> Import</span></a>', // allow html or view::path_to_view
                    'detail' => '',
                ]
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
        $process = (new AdminConfig)->where('code', $this->configKey.'_config')->delete();
        if (!$process) {
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
        return redirect(sc_route_admin('admin.home').'/import_product');
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