<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Products extends BaseController
{
    protected $menu;

    public function __construct()
    {
        // Initialize the variable
        $this->menu = "Products";
    }
    public function index()
    {
        $data = [
            "menu" => $this->menu
        ];
        return view('Admin/Products/Product.php', $data);
    }
}
