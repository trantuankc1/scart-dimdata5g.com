<?php
#App\Plugins\Payment\SepayBasic\Models\PluginModel.php
namespace App\Plugins\Payment\SepayBasic\Models;

use Illuminate\Database\Eloquent\Model;

class PluginModel extends Model
{
    public $timestamps    = false;
    public $table = '';
    protected $connection = SC_CONNECTION;
    protected $guarded    = [];

    public function uninstallExtension()
    {
        return ['error' => 0, 'msg' => 'uninstall success'];
    }

    public function installExtension()
    {
        return ['error' => 0, 'msg' => 'install success'];
    }
    
}
