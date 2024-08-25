<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductsModel;
use App\Models\ProductPicturesModel;

class Home extends BaseController
{
    protected $menu, $productModel, $galleryModel;

    public function __construct()
    {
        $this->menu = "Shop";
        $this->productModel = new ProductsModel();
        $this->galleryModel = new ProductPicturesModel();
    }

    public function index()
    {
        $productList = $this->productModel->orderBy('product_id','asc')->findAll();
        $data = [
            "menu" => $this->menu,
            "products" => $productList,
        ];

        return view('User/Gallery/Home', $data);
    }

    public function product($id)
    {
        $product = $this->productModel->find($id);
        $productGallery = $this->galleryModel->where('product_id',$id)->findAll();
        $gallery = [];
        if(count($productGallery) == 0){
            $gallery = [];
        }elseif(count($productGallery) < 4){
            for ($i = 0; $i < 4; $i++) {
                if(count($productGallery) == 2){
                    $index = $i % 2;
                }elseif(count($productGallery) == 3){
                    $index = $i % 3;
                }else{
                    $index = 0;
                }
                $gallery[$i] = $productGallery[$index];
            }
        }
        // pre($gallery,1);
        $data = [
            "menu" => $this->menu,
            "product" => $product,
            "gallery" => $gallery,
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
