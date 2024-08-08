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

    private function checkLogin(){
        $session = session();
        if (!$session->get('logged_admin')) {
            return false;
        }else{
            return true;
        }
    }

    public function index()
    {
        if (!$this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }
        $data = [
            "menu" => $this->menu
        ];
        return view('Admin/Home/Dashboard', $data);
    }
}
