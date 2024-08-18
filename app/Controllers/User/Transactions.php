<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductsModel;
use App\Models\ProductPicturesModel;
use App\Models\CartModel;
use App\Models\UsersModel;
use App\Models\UserAddressModel;

class Transactions extends BaseController
{
    protected $menu, $menuCart, $modelProduct, $modelGallery, $modelCart, $modelUser, $modelUserAddress;

    public function __construct()
    {
        // Initialize the variable
        $this->menu = "Transaction";
        $this->menuCart = "Cart";
        $this->modelProduct = new ProductsModel();
        $this->modelUser = new UsersModel();
        $this->modelCart = new CartModel();
        $this->modelGallery = new ProductPicturesModel();
        $this->modelUserAddress = new UserAddressModel();
    }

    private function checkLogin(){
        $session = session();
        if (!$session->get('logged')) {
            return false;
        }else{
            return true;
        }
    }

    public function addCart()
    {
        $error = "";
        if (!$this->checkLogin()) {
            $error = "signin";
            return $this->response->setJSON([
                'status' => 'success',
                'error' => $error,
                'message' => "Login First",
            ]);
        }

        // Get form data
        $qty = htmlspecialchars((string)$this->request->getPost('qty'),ENT_QUOTES);
        $product_id = htmlspecialchars((string)$this->request->getPost('pid'),ENT_QUOTES);

        $user = $this->modelUser->where('username', session()->get('username'))->first();

        $mycart = $this->modelCart
        ->where('product_id', $product_id)
        ->where('status', 1)
        ->where('user_id', $user->user_id)->first();

        if($mycart){
            $data = [
                'qty' => ($qty + $mycart->qty),
            ];

            // Update data into the database
            $execute = $this->modelCart->update($mycart->cart_id, $data);
        }else{
            // Prepare data for insertion
            $data = [
                'product_id' => $product_id,
                'qty' => $qty,
                'status' => 1,
                'user_id' => $user->user_id,
            ];

            // Insert data into the database
            $execute = $this->modelCart->insert($data);
        }
        if ($execute) {
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

    public function myCart()
    {
        $error = "";
        if (!$this->checkLogin()) {
            return redirect()->to('login');
        }
        $user = $this->modelUser->where('username', session()->get('username'))->first();
        $userAddress = $this->modelUserAddress->where('user_id', $user->user_id)->first();

        $mycart = $this->modelCart->getMyCart($user->user_id);
        // pre($mycart,1);
        $data = [
            "menu" => $this->menuCart,
            "mycart" => $mycart,
            "address" => $userAddress,
        ];

        return view('User/Cart/Cart_List', $data);
    }

    public function removeFromCart()
    {
        $error = "";
        if (!$this->checkLogin()) {
            $error = "signin";
            return $this->response->setJSON([
                'status' => 'success',
                'error' => $error,
                'message' => "Login First",
            ]);
        }

        $id = $this->request->getPost('id'); // Get the ID from the AJAX request
        
        // Check if the cart exists
        $cart = $this->modelCart->find($id);
        if (!$cart) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Cart not found']);
        }
        // pre($id,1);
        // Delete the cart
        if ($this->modelCart->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Cart deleted successfully']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to delete product']);
        }
    }

    public function getAddress()
    {
        $error = "";
        if (!$this->checkLogin()) {
            $error = "signin";
            return $this->response->setJSON([
                'status' => 'success',
                'error' => $error,
                'message' => "Login First",
            ]);
        }

        $user = $this->modelUser->where('username', session()->get('username'))->first();
        // Check if the address exists
        $address = $this->modelUserAddress->where('user_id', $user->user_id)->first();
        $return = "add";
        if($address) $return = "update";
        if ($return) {
            return $this->response->setJSON(['status' => 'success', 'return' => $return, 'data' => $address, 'message' => 'Getting Address']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Cannot do this action, something wrong!']);
        }
    }

    public function updateAddress()
    {
        $error = "";
        if (!$this->checkLogin()) {
            $error = "signin";
            return $this->response->setJSON([
                'status' => 'success',
                'error' => $error,
                'message' => "Login First",
            ]);
        }

        $recipient_name = htmlspecialchars((string)$this->request->getPost('recipient_name'),ENT_QUOTES);
        $phone_number = htmlspecialchars((string)$this->request->getPost('phone_number'),ENT_QUOTES);
        $address = htmlspecialchars((string)$this->request->getPost('address'),ENT_QUOTES);
        $pos_code = htmlspecialchars((string)$this->request->getPost('pos_code'),ENT_QUOTES);
        $city = htmlspecialchars((string)$this->request->getPost('city'),ENT_QUOTES);
        $province = htmlspecialchars((string)$this->request->getPost('province'),ENT_QUOTES);
        $country = htmlspecialchars((string)$this->request->getPost('country'),ENT_QUOTES);

        $data = [
            'recipient_name' => $recipient_name,
            'phone_number' => $phone_number,
            'address' => $address,
            'pos_code' => $pos_code,
            'city' => $city, 
            'province' => $province,
            'country' => $country
        ];
        
        $user = $this->modelUser->where('username', session()->get('username'))->first();
        // Check if the address exists
        $address = $this->modelUserAddress->where('user_id', $user->user_id)->first();
        if($address){
            $return = $this->modelUserAddress->update($address->uad_id, $data);
        }else{
            $data['user_id'] = $user->user_id;
            $return = $this->modelUserAddress->insert($data);
        }
        $useraddress = $this->modelUserAddress->find($return);

        if ($useraddress) {
            return $this->response->setJSON(['status' => 'success', 'return' => $useraddress, 'message' => 'Address successfully updated']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Cannot do this action, something wrong!']);
        }
    }

    public function createInvoice()
    {
        $error = "";
        if (!$this->checkLogin()) {
            $error = "signin";
            return $this->response->setJSON([
                'status' => 'success',
                'error' => $error,
                'message' => "Login First",
            ]);
        }

        $user = $this->modelUser->where('username', session()->get('username'))->first();
        $cart = $this->modelCart->getMyCart($user->user_id);

        $randomNumber = rand(0, 9999);

        $invoicenumber = "INV-".date('YmdHis').str_pad($randomNumber, 4, '0', STR_PAD_LEFT);

        pre($invoicenumber,1);
    }

    public function payBill()
    {
        $error = "";
        if (!$this->checkLogin()) {
            $error = "signin";
            return $this->response->setJSON([
                'status' => 'success',
                'error' => $error,
                'message' => "Login First",
            ]);
        }

    }
}
