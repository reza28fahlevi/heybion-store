<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductsModel;
use App\Models\ProductPicturesModel;

class Products extends BaseController
{
    protected $menu, $model, $modelGallery;

    public function __construct()
    {
        // Initialize the variable
        $this->menu = "Products";
        $this->model = new ProductsModel();
        $this->modelGallery = new ProductPicturesModel();
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
        return view('Admin/Products/Product', $data);
    }

    public function fetch()
    {
        if (!$this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }
        // Read the parameters sent by DataTables
        $start = (int) $this->request->getPost('start');
        $length = $this->request->getPost('length');
        $search = $this->request->getPost('search')['value'];

        // Get the total number of records (including soft deleted)
        $totalRecords = $this->model->withDeleted()->countAllResults();

        // Get the total number of filtered records (excluding soft deleted)
        if (!empty($search)) {
            $this->model->like('product_name', $search);
        }
        $totalFilteredRecords = $this->model->countAllResults(false);

        // Fetch the data (excluding soft deleted)
        if (!empty($search)) {
            $this->model->like('product_name', $search);
        }
        $data = $this->model->where('deleted_at', null)->findAll($length, $start);

        // Prepare the response
        $response = [
            "draw" => intval($this->request->getPost('draw')),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalFilteredRecords,
            "data" => $data
        ];

        return $this->response->setJSON($response);
    }

    public function add()
    {
        if (!$this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }
        $error = "";
        // Get form data
        $product_name = htmlspecialchars((string)$this->request->getPost('product_name'),ENT_QUOTES);
        $price_tag = htmlspecialchars((string)$this->request->getPost('price_tag'),ENT_QUOTES);
        $stock = htmlspecialchars((string)$this->request->getPost('stock'),ENT_QUOTES);
        $min_purchase = htmlspecialchars((string)$this->request->getPost('min_purchase'),ENT_QUOTES);
        $max_purchase = htmlspecialchars((string)$this->request->getPost('max_purchase'),ENT_QUOTES);
        $description = $this->request->getPost('description');
        $product_status = htmlspecialchars((string)$this->request->getPost('product_status'),ENT_QUOTES);

        $path = WRITEPATH . 'uploads/thumbnails';
        $picName = "";
        if (!file_exists($path)) {
            // Try to create the directory
            if (mkdir($path, 0777, true)) {
                //
            } else {
                $error = "Failed to create directory.";
            }
        } 
        if (file_exists($path)) {
            if ($this->request->getFile('thumbnail')->isValid()) {
                $pic = $this->request->getFile('thumbnail');
                $picName = $pic->getRandomName();
                $pic->move(WRITEPATH . 'uploads/thumbnails', $picName);
            }
        }

        // Prepare data for insertion
        $data = [
            'product_name' => $product_name,
            'price_tag' => $price_tag,
            'stock' => $stock,
            'min_purchase' => $min_purchase,
            'max_purchase' => ($max_purchase) ? $max_purchase : $stock,
            'description' => $description,
            'product_status' => $product_status,
            'thumbnail' => $picName,
        ];

        // pre($data,1);
        // Insert data into the database
        $insert = $this->model->insert($data);
        if ($insert) {
            return $this->response->setJSON([
                'status' => 'success',
                'error' => $error,
                'message' => "Successfully added ".$product_name." to catalog",
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'error' => $error,
                'message' => "Failed to add ".$product_name." to catalog",
            ]);
        }
    }

    public function getProduct($id){
        if (!$this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }
        $product = $this->model->find($id);

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

    public function update()
    {
        if (!$this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }
        $error = "";
        $id = $this->request->getPost('product_id');

        $product_name = htmlspecialchars((string)$this->request->getPost('product_name'),ENT_QUOTES);
        $price_tag = htmlspecialchars((string)$this->request->getPost('price_tag'),ENT_QUOTES);
        $stock = htmlspecialchars((string)$this->request->getPost('stock'),ENT_QUOTES);
        $min_purchase = htmlspecialchars((string)$this->request->getPost('min_purchase'),ENT_QUOTES);
        $max_purchase = htmlspecialchars((string)$this->request->getPost('max_purchase'),ENT_QUOTES);
        $description = $this->request->getPost('description');
        $product_status = htmlspecialchars((string)$this->request->getPost('product_status'),ENT_QUOTES);
      

        $path = WRITEPATH . 'uploads/thumbnails';
        $picName = "";
        if (!file_exists($path)) {
            // Try to create the directory
            if (mkdir($path, 0777, true)) {
                //
            } else {
                $error = "Failed to create directory.";
            }
        } 
        if (file_exists($path)) {
            if ($this->request->getFile('thumbnail')->isValid()) {
                $pic = $this->request->getFile('thumbnail');
                $picName = $pic->getRandomName();
                $pic->move(WRITEPATH . 'uploads/thumbnails', $picName);
            }
        }

        $imgpath = WRITEPATH . 'uploads/images';
        $imgName = "";
        if (!file_exists($imgpath)) {
            // Try to create the directory
            if (mkdir($imgpath, 0777, true)) {
                //
            } else {
                $error = "Failed to create directory.";
            }
        } 
        if (file_exists($imgpath)) {
            if ($this->request->getFile('thumbnail')->isValid()) {
                $img = $this->request->getFile('thumbnail');
                $imgName = $img->getRandomName();
                $img->move(WRITEPATH . 'uploads/images', $imgName);
            }
        }

        // Prepare data for insertion
        $data = [
            'product_name' => $product_name,
            'price_tag' => $price_tag,
            'stock' => $stock,
            'min_purchase' => $min_purchase,
            'max_purchase' => ($max_purchase) ? $max_purchase : $stock,
            'description' => $description,
            'product_status' => $product_status,
        ];
        if($picName) $data['thumbnail'] = $picName;

        if($imgName){
            $dataGallery = [
                'product_id' => $id,
                'path' => $imgName,
            ];
            
            $insertGallery = $this->modelGallery->insert($dataGallery);
        }
        // Delete the product
        if ($this->model->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'error' => $error,
                'message' => "Successfully updated ".$product_name."",
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'error' => $error,
                'message' => "Failed to update ".$product_name."",
            ]);
        }
    }

    public function delete()
    {
        if (!$this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }
        $id = $this->request->getPost('id'); // Get the ID from the AJAX request
        
        // Check if the product exists
        $product = $this->model->find($id);
        if (!$product) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Product not found']);
        }

        // Delete the product
        if ($this->model->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Product deleted successfully']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete product']);
        }
    }

    public function gallery($id)
    {
        if (!$this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }
        $product_detail = $this->model->where('product_id', $id)->first();
        $data = [
            "menu" => $this->menu,
            "product_id" => $id,
            "product" => $product_detail,
        ];
        return view('Admin/Products/Gallery', $data);
    }

    public function fetchGallery()
    {
        if (!$this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }
        $p_id = $this->request->getPost('product_id');
        // Read the parameters sent by DataTables
        $start = (int) $this->request->getPost('start');
        $length = $this->request->getPost('length');
        $search = $this->request->getPost('search')['value'];

        // Get the total number of records (including soft deleted)
        $totalRecords = $this->model->withDeleted()->countAllResults();

        $totalFilteredRecords = $this->model->countAllResults(false);

        $data = $this->modelGallery->where('product_id', $p_id)->where('deleted_at', null)->findAll($length, $start);

        // Prepare the response
        $response = [
            "draw" => intval($this->request->getPost('draw')),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalFilteredRecords,
            "data" => $data
        ];

        return $this->response->setJSON($response);
    }

    public function addGallery()
    {
        if (!$this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }
        $error = "";
        // Get form data
        $product_id = htmlspecialchars((string)$this->request->getPost('product_id'),ENT_QUOTES);

        $path = WRITEPATH . 'uploads/images';
        $picName = "";
        if (!file_exists($path)) {
            // Try to create the directory
            if (mkdir($path, 0777, true)) {
                //
            } else {
                $error = "Failed to create directory.";
            }
        } 
        if (file_exists($path)) {
            if ($this->request->getFile('imagesProduct')->isValid()) {
                $pic = $this->request->getFile('imagesProduct');
                $picName = $pic->getRandomName();
                $pic->move(WRITEPATH . 'uploads/images', $picName);
            }
        }

        // Prepare data for insertion
        $data = [
            'product_id' => $product_id,
            'path' => $picName,
        ];

        // pre($data,1);
        // Insert data into the database
        if ($this->modelGallery->insert($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'error' => $error,
                'message' => "Successfully added photo to gallery",
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'error' => $error,
                'message' => "Failed to add photo to gallery",
            ]);
        }
    }

    public function deleteGallery(){
        if (!$this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }
        $id = $this->request->getPost('id'); // Get the ID from the AJAX request
        
        // Check if the product exists
        $product = $this->modelGallery->find($id);
        if (!$product) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Product not found']);
        }

        // Delete the product
        if ($this->modelGallery->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Product photo deleted successfully']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete product photo']);
        }
    }
}
