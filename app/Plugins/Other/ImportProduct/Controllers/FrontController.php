<?php
#App\Plugins\Other\ImportProduct\Controllers\FrontController.php
namespace App\Plugins\Other\ImportProduct\Controllers;

use App\Plugins\Other\ImportProduct\AppConfig;
use App\Http\Controllers\GeneralController;
class FrontController extends GeneralController
{
    public $plugin;

    public function __construct()
    {
        $this->plugin = new AppConfig;
    }

    public function index() {
        return view($this->plugin->pathPlugin.'::Front',
            [
                
            ]
        );
    }
}
