<?php
#App\Plugins\Other\ProductFlashSale\AppConfig.php
namespace App\Plugins\Other\ProductFlashSale;

use App\Plugins\Other\ProductFlashSale\Models\PluginModel;
use SCart\Core\Admin\Models\AdminConfig;
use SCart\Core\Admin\Models\AdminMenu;
use App\Plugins\ConfigDefault;
use Illuminate\Support\Facades\File;

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
        $this->scartVersion = $config['scartVersion'];
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
            $return = ['error' => 1, 'msg' =>  sc_language_render('admin.plugin.plugin_exist')];
        } else {
            //Insert plugin to config
            $dataInsert = [
                [
                    'group'  => $this->configGroup,
                    'code'   => $this->configCode,
                    'key'    => $this->configKey,
                    'sort'   => 0,
                    'value'  => self::ON, //Enable extension
                    'detail' => $this->pathPlugin.'::lang.title',
                ],
            ];
            $process = AdminConfig::insert(
                $dataInsert
            );

            $blockMarketing = AdminMenu::where('key','MARKETING')->first();
            if($blockMarketing) {
                AdminMenu::insert([
                    'sort' => 100,
                    'parent_id' => $blockMarketing->id,
                    'title' => ''.$this->pathPlugin.'::lang.title',
                    'icon' => 'fa fa-bolt',
                    'uri' => 'route::admin_productflashsale.index',
                    'key' => $this->configKey,
                    ]);
            }


            if (!$process) {
                $return = ['error' => 1, 'msg' => sc_language_render('admin.plugin.install_faild')];
            } else {
                if (is_writable(base_path('resources/views/templates/'.sc_store('template')))) {
                    if(!File::isDirectory(base_path('resources/views/templates/'.sc_store('template').'/block'))){
                        File::makeDirectory(base_path('resources/views/templates/'.sc_store('template').'/block'));
                    }

                    foreach (glob(app_path($this->configGroup.'/'.$this->configCode.'/'.$this->configKey.'/template/block/*.blade.php')) as $filename) {
                        $checkFile = str_replace(
                            app_path($this->configGroup.'/'.$this->configCode.'/'.$this->configKey.'/template'),
                            base_path('resources/views/templates/'.sc_store('template')),
                            $filename
                        );
                        if (!file_exists($checkFile)) {
                            File::copy($filename, $checkFile);
                        }
                    }
                }
                $return = (new PluginModel)->installExtension();
            }
        }

        return $return;
    }

    public function uninstall()
    {
        $return = ['error' => 0, 'msg' => ''];
        //Please delete all values inserted in the installation step
        $process = (new AdminConfig)
            ->where('key', $this->configKey)
            ->orWhere('code', $this->configKey.'_config')
            ->delete();

        AdminMenu::where('key', $this->configKey)->delete();

        if (!$process) {
            $return = ['error' => 1, 'msg' => sc_language_render('admin.plugin.action_error', ['action' => 'Uninstall'])];
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
        //redirect to url config of plugin
        return redirect(sc_route_admin('admin_productflashsale.index'));
    }

    public function getData()
    {
        $arrData = [
            'title'      => $this->title,
            'code'       => $this->configCode,
            'key'        => $this->configKey,
            'image'      => $this->image,
            'permission' => self::ALLOW,
            'version'    => $this->version,
            'auth'       => $this->auth,
            'link'       => $this->link,
            'value'      => 0, // this return need for plugin shipping
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
