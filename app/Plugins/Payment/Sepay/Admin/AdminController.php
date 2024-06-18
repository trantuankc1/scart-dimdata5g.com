<?php
#App\Plugins\Payment\Sepay\Admin\AdminController.php

namespace App\Plugins\Payment\Sepay\Admin;

use SCart\Core\Admin\Controllers\RootAdminController;
use App\Plugins\Payment\Sepay\AppConfig;

class AdminController extends RootAdminController
{
    public $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->plugin = new AppConfig;
    }
    public function index()
    {
        return view($this->plugin->pathPlugin.'::Admin',
            [
                
            ]
        );
    }
}
