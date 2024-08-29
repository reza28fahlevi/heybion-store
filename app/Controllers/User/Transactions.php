<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductsModel;
use App\Models\ProductPicturesModel;
use App\Models\CartModel;
use App\Models\UsersModel;
use App\Models\UserAddressModel;
use App\Models\InvoicesModel;
use App\Models\InvoiceDetailsModel;
use App\Models\InvoiceProductPicturesModel;

class Transactions extends BaseController
{
    protected $menu, $menuCart, $modelProduct, $modelGallery, $modelCart, $modelUser, $modelUserAddress, $modelInvoices, $modelInvoiceDetail, $modelInvoicePP;

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
        $this->modelInvoices = new InvoicesModel();
        $this->modelInvoiceDetail = new InvoiceDetailsModel();
        $this->modelInvoicePP = new InvoiceProductPicturesModel();
    }

    private function checkLogin()
    {
        $session = session();
        if (!$session->get('logged')) {
            return false;
        } else {
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
        $qty = htmlspecialchars((string)$this->request->getPost('qty'), ENT_QUOTES);
        $product_id = htmlspecialchars((string)$this->request->getPost('pid'), ENT_QUOTES);

        $user = $this->modelUser->where('username', session()->get('username'))->first();

        $mycart = $this->modelCart
            ->where('product_id', $product_id)
            ->where('status', 1)
            ->where('user_id', $user->user_id)->first();

        if ($mycart) {
            $data = [
                'qty' => ($qty + $mycart->qty),
            ];

            // Update data into the database
            $execute = $this->modelCart->update($mycart->cart_id, $data);
        } else {
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

    public function getProvince()
    {
        $error = "";
        if (!$this->checkLogin()) {
            return redirect()->to('login');
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 21af2f80476c25637947cfdd1024c8c7"
            ),
        ));

        $response = json_decode(curl_exec($curl));
        $rajaongkir = $response->rajaongkir;
        $err = curl_error($curl);

        curl_close($curl);

        if ($response) {
            return $this->response->setJSON([
                'status' => 'success',
                'error' => $error,
                'message' => "Successfully get data province",
                'data' => $rajaongkir->results
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'error' => $error,
                'message' => $err,
            ]);
        }
    }

    public function getCity()
    {
        $error = "";
        if (!$this->checkLogin()) {
            return redirect()->to('login');
        }

        $id_province = $this->request->getPost('province');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=$id_province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 21af2f80476c25637947cfdd1024c8c7"
            ),
        ));

        $response = json_decode(curl_exec($curl));
        $rajaongkir = $response->rajaongkir;
        $err = curl_error($curl);

        curl_close($curl);

        if ($response) {
            return $this->response->setJSON([
                'status' => 'success',
                'error' => $error,
                'message' => "Successfully get data city",
                'data' => $rajaongkir->results
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'error' => $error,
                'message' => $err,
            ]);
        }
    }

    public function getCost()
    {
        $error = "";
        if (!$this->checkLogin()) {
            return redirect()->to('login');
        }
        $user = $this->modelUser->where('username', session()->get('username'))->first();
        $userAddress = $this->modelUserAddress->where('user_id', $user->user_id)->first();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=23&destination=$userAddress->id_city&weight=1000&courier=jne",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 21af2f80476c25637947cfdd1024c8c7"
            ),
        ));

        $response = json_decode(curl_exec($curl));
        $rajaongkir = $response->rajaongkir;
        $err = curl_error($curl);

        curl_close($curl);

        if ($response) {
            return $this->response->setJSON([
                'status' => 'success',
                'error' => $error,
                'message' => "Successfully get data cost",
                'data' => $rajaongkir->results
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'error' => $error,
                'message' => $err,
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

    public function updateCart()
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
        $qty = $this->request->getPost('qty');
        $cart = $this->request->getPost('cart');

        $update = [
            'qty' => $qty
        ];

        $product = $this->modelProduct->find($id);
        if ($product->stock < $qty) {
            $error = "Quantity More Than Stock";
        } else {
            $updateCart = $this->modelCart->update($cart, $update);
        }

        if ($product) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => "Success to get data " . $product->product_name . " from catalog",
                'data' => $product,
                'error' => $error
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => "Failed. Product not found",
            ]);
        }
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
        if ($address) $return = "update";
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

        $recipient_name = htmlspecialchars((string)$this->request->getPost('recipient_name'), ENT_QUOTES);
        $phone_number = htmlspecialchars((string)$this->request->getPost('phone_number'), ENT_QUOTES);
        $address = htmlspecialchars((string)$this->request->getPost('address'), ENT_QUOTES);
        $pos_code = htmlspecialchars((string)$this->request->getPost('pos_code'), ENT_QUOTES);
        $city = htmlspecialchars((string)$this->request->getPost('city'), ENT_QUOTES);
        $id_city = htmlspecialchars((string)$this->request->getPost('id_city'), ENT_QUOTES);
        $province = htmlspecialchars((string)$this->request->getPost('province'), ENT_QUOTES);
        $id_province = htmlspecialchars((string)$this->request->getPost('id_province'), ENT_QUOTES);
        $country = htmlspecialchars((string)$this->request->getPost('country'), ENT_QUOTES);

        $data = [
            'recipient_name' => $recipient_name,
            'phone_number' => $phone_number,
            'address' => $address,
            'pos_code' => $pos_code,
            'city' => $city,
            'id_city' => $id_city,
            'province' => $province,
            'id_province' => $id_province,
            'country' => $country
        ];

        $user = $this->modelUser->where('username', session()->get('username'))->first();
        // Check if the address exists
        $address = $this->modelUserAddress->where('user_id', $user->user_id)->first();
        if ($address) {
            $return = $this->modelUserAddress->update($address->uad_id, $data);
        } else {
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
        $carts = $this->modelCart->getMyCart($user->user_id);
        $totalbill = 0;
        foreach ($carts as $c) {
            $totalbill += $c->price_tag * $c->qty;
        }
        $checkAddress = $this->modelUserAddress->where('user_id', $user->user_id)->first();
        if (!$checkAddress) {
            $error = "empty_address";
            return $this->response->setJSON([
                'status' => 'success',
                'error' => $error,
                'message' => "Please input your address first!",
            ]);
        }
        $randomNumber = rand(0, 9999);
        $invoicenumber = "INV-" . date('YmdHis') . str_pad($randomNumber, 4, '0', STR_PAD_LEFT);

        $dataInvoice = [
            'invoice_number' => $invoicenumber,
            'total_invoice' => $totalbill + intval(htmlspecialchars((string)$this->request->getPost('ongkir'), ENT_QUOTES)),
            'total_cart' => $totalbill,
            'shipping_cost' => intval(htmlspecialchars((string)$this->request->getPost('ongkir'), ENT_QUOTES)),
            'payment_method' => 1,
            'payment_status' => 1,
            'user_id' => $user->user_id,
        ];

        // Load the database or model
        $db = \Config\Database::connect();
        // Start the transaction
        $db->transStart();

        try {
            $insertInvoice = $this->modelInvoices->insert($dataInvoice);

            if ($insertInvoice) {
                $this->modelCart->updateMyCart($user->user_id);
                $datadetail = [];
                foreach ($carts as $cart) {
                    $datadetail = [
                        'transaction_id' => $insertInvoice,
                        'product_id' => $cart->product_id,
                        'product_name' => $cart->product_name,
                        'price_tag' => $cart->price_tag,
                        'thumbnail' => $cart->thumbnail,
                        'description' => $cart->description,
                        'qty' => $cart->qty,
                    ];
                    $insertDetail = $this->modelInvoiceDetail->insert($datadetail);
                    $productDetail = $this->modelProduct->find($cart->product_id);
                    if ($productDetail) {
                        $remainingStock = $productDetail->stock - $cart->qty;
                        $stock = [
                            'stock' => $remainingStock
                        ];
                        $updateStock = $this->modelProduct->update($cart->product_id, $stock);
                    }

                    $galleries = $this->modelGallery->where('product_id', $cart->product_id)->findAll();
                    $dataIPP = [];
                    foreach ($galleries as $gallery) {
                        if ($gallery->path) {
                            $dataIPP = [
                                'transaction_id' => $insertInvoice,
                                'product_id' => $cart->product_id,
                                'path' => $gallery->path
                            ];
                            // pre($dataIPP,1);
                            // $dataIPP
                            if ($dataIPP) $this->modelInvoicePP->insert($dataIPP);
                            // pre($this->modelInvoicePP->insert($dataIPP),1);
                        }
                    }
                }
            }

            // Check if the transaction was successful
            if ($db->transStatus() === FALSE) {
                // Something went wrong, so rollback
                $db->transRollback();
                return $this->response->setJSON(['status' => 'error', 'message' => 'Cannot do this action, something wrong!']);
            } else {
                // Everything is good, so commit
                $db->transCommit();
                return $this->response->setJSON(['status' => 'success', 'message' => 'Invoice successfully created', 'tid' => $insertInvoice]);
            }
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            $db->transRollback();
            return $this->response->setJSON(['status' => 'error', 'message' => 'Cannot do this action, something wrong!']);
        }

        // pre($totalbill,1);
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

        $transaction_id = htmlspecialchars((string)$this->request->getPost('tid'), ENT_QUOTES);

        $path = WRITEPATH . 'uploads/payment_bill';
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
            if ($this->request->getFile('upload_bill')->isValid()) {
                $pic = $this->request->getFile('upload_bill');
                $picName = $pic->getRandomName();
                $pic->move(WRITEPATH . 'uploads/payment_bill', $picName);
            }
        }

        $data = [
            'payment_proof' => $picName,
            'payment_status' => 2,
        ];
        $update = $this->modelInvoices->update($transaction_id, $data);

        if ($update) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Bill successfully uploaded']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Cannot do this action, something wrong!']);
        }
    }

    public function myHistory()
    {
        $error = "";
        if (!$this->checkLogin()) {
            return redirect()->to('login');
        }
        $user = $this->modelUser->where('username', session()->get('username'))->first();
        $userAddress = $this->modelUserAddress->where('user_id', $user->user_id)->first();

        $mytransaction = $this->modelInvoices->where('user_id', $user->user_id)->orderBy('invoice_number', 'DESC')->findAll();
        if ($mytransaction) {
            foreach ($mytransaction as $key => $value) {
                $mytransaction[$key]->details = $this->modelInvoiceDetail->where('transaction_id', $value->transaction_id)->orderBy('trd_id', 'ASC')->findAll();
                $btn_pay = '';
                $btn_finish = '';
                if ($value->payment_status == 1) {
                    $btn_pay = '<button type="button" class="btn-default btn-paybill form-control" data-trd="' . $value->transaction_id . '"> <i class="bi bi-upload"></i> Pay</button>';
                }
                if ($value->payment_status == 4) {
                    $btn_finish = '<button type="button" class="btn-default btn-finish form-control" data-trd="' . $value->transaction_id . '"> <i class="bi bi-patch-check"></i> Received</button>';
                }
                $mytransaction[$key]->badge_status = badgeStatus($value->payment_status);
                $mytransaction[$key]->btnPay = $btn_pay;
                $mytransaction[$key]->btnFinish = $btn_finish;
            }
        }
        // pre($mytransaction);
        $data = [
            "menu" => $this->menu,
            "mytransaction" => $mytransaction,
        ];

        // pre($data,1);
        return view('User/Transactions/Transactions_List', $data);
    }

    public function getDetailInvoice($id)
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
        $userAddress = $this->modelUserAddress->where('user_id', $user->user_id)->first();

        $invoice = $this->modelInvoices->find($id);
        $invoiceDetails = $this->modelInvoiceDetail->where('transaction_id', $id)->orderBy('trd_id', 'ASC')->findAll();

        $invoice->badge_status = badgeStatus($invoice->payment_status);

        $listProducts = '';
        foreach ($invoiceDetails as $detail) {
            $listProducts .= '
            <div class="row gy-4 mb-1 justify-content-center">
                <div class="col-lg-2">
                    <a href="' . site_url('product/' . $detail->product_id) . '"><img src="' . site_url('uploads/thumbnails/' . $detail->thumbnail) . '" class="img-fluid img-thumbnail " alt=""></a>
                </div>
                <div class="col-lg-10 content pricing">
                    <h6><a href="' . site_url('product/' . $detail->product_id) . '">' . $detail->product_name . '</a></h6>
                    <ul>
                        <li class="pricing-item d-flex justify-content-between"><h4 style="font-size: 15px;"><i class="bi bi-chevron-right"></i> Rp. <label class="item-pricing">' . $detail->price_tag . '</label></h4><h4>x' . $detail->qty . '</h4></li>
                    </ul>
                </div>
            </div>';
        }

        $data = [
            "userDetail" => $userAddress,
            "invoice" => $invoice,
            "invoiceDetails" => $invoiceDetails,
            "listProducts" => $listProducts
        ];

        if ($invoice) {
            return $this->response->setJSON(['status' => 'success', 'data' => $data, 'message' => 'Success get data']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Cannot do this action, something wrong!']);
        }
    }

    public function finishOrder()
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

        $transaction_id = htmlspecialchars((string)$this->request->getPost('trd'), ENT_QUOTES);

        $data = [
            'payment_status' => 5,
        ];

        // pre($data,1);
        $update = $this->modelInvoices->update($transaction_id, $data);

        if ($update) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Order Finished!']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Cannot do this action, something wrong!']);
        }
    }
}
