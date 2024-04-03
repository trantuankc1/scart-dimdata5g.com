<?php
#App\Plugins\Other\SiteMapBasic\Admin\AdminController.php

namespace App\Plugins\Other\SiteMapBasic\Admin;

use SCart\Core\Admin\Controllers\RootAdminController;
use App\Plugins\Other\SiteMapBasic\AppConfig;

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
