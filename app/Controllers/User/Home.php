<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductsModel;

class Home extends BaseController
{
    protected $menu, $productModel;

    public function __construct()
    {
        $this->menu = "Shop";
        $this->productModel = new ProductsModel();
    }

    public function index()
    {
        $productList = $this->productModel->findAll();
        $data = [
            "menu" => $this->menu,
            "products" => $productList,
        ];

        return view('User/Gallery/Home', $data);
    }

    public function product($id)
    {
        $product = $this->productModel->find($id);
        $data = [
            "menu" => $this->menu,
            "product" => $product,
        ];
        return view('User/Gallery/View_Product', $data);
    }

    public function getProduct($id){
        $product = $this->productModel->find($id);

        if($product){
            return $this->response->setJSON([
                'status' => 'success',
                'message' => "Success to get data ".$product->product_name." from catalog",
                'data' => $product
            ]);
        }else{
            return $this->response->setJSON([
                'status' => 'error',
                'message' => "Failed. Product not found",
            ]);
        }
    }
}
