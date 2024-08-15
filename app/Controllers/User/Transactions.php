<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductsModel;
use App\Models\ProductPicturesModel;
use App\Models\CartModel;

class Transactions extends BaseController
{
    protected $menu, $modelProduct, $modelGallery, $modelCart;

    public function __construct()
    {
        // Initialize the variable
        $this->menu = "";
        $this->modelProduct = new ProductsModel();
        $this->modelGallery = new ProductPicturesModel();
    }

    private function checkLogin(){
        $session = session();
        if (!$session->get('logged')) {
            return false;
        }else{
            return true;
        }
    }

    public function index()
    {
        //
    }

    public function addCart()
    {
        if (!$this->checkLogin()) {
            return redirect()->to('login');
        }
        $error = "";
        // Get form data
        $qty = htmlspecialchars((string)$this->request->getPost('qty'),ENT_QUOTES);
        $product_id = htmlspecialchars((string)$this->request->getPost('product_id'),ENT_QUOTES);

        // Prepare data for insertion
        $data = [
            'product_id' => $product_id,
            'qty' => $qty,
            'status' => 1,
        ];

        // pre($data,1);
        // Insert data into the database
        $insert = $this->modelCart->insert($data);
        if ($insert) {

            return $this->response->setJSON([
                'status' => 'success',
                'error' => $error,
                'message' => "Successfully added to cart",
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'error' => $error,
                'message' => "Failed to add, something wrong",
            ]);
        }
    }
}
