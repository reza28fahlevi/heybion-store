<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    protected $menu;

    public function __construct()
    {
        $this->menu = "Dashboard";
    }

    public function index()
    {
        $data = [
            "menu" => $this->menu
        ];
        return view('Admin/Home/Dashboard', $data);
    }
}
