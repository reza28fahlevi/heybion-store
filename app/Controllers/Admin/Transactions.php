<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\InvoicesModel;
use App\Models\InvoiceDetailsModel;
use App\Models\InvoiceProductPicturesModel;
use App\Models\UsersModel;
use App\Models\UserAddressModel;

class Transactions extends BaseController
{
    protected $menu, $model, $modelDetails, $modelPicture, $modelUser, $modelUserAddress;

    public function __construct()
    {
        // Initialize the variable
        $this->menu = "Transactions";
        $this->model = new InvoicesModel();
        $this->modelDetails = new InvoiceDetailsModel();
        $this->modelPicture = new InvoiceProductPicturesModel();
        $this->modelUser = new UsersModel();
        $this->modelUserAddress = new UserAddressModel();
    }
    
    private function checkLogin(){
        $session = session();
        if (!$session->get('logged_admin')) {
            return false;
        }else{
            return true;
        }
    }

    public function needConfirm()
    {
        if (!$this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }
        $data = [
            "menu" => $this->menu,
            "submenu" => 'Confirmation'
        ];
        return view('Admin/Transactions/NeedConfirmation', $data);
    }

    public function needDelivery()
    {
        if (!$this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }
        $data = [
            "menu" => $this->menu,
            "submenu" => 'Delivery'
        ];
        return view('Admin/Transactions/NeedDelivery', $data);
    }

    public function allTransactions()
    {
        if (!$this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }
        $data = [
            "menu" => $this->menu,
            "submenu" => 'All'
        ];
        return view('Admin/Transactions/AllTransactions', $data);
    }

    public function getListTransactions($status = NULL)
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
            $this->model->like('invoice_number', $search);
        }
        if($status == 4){
            $this->model->where('payment_status >=', $status);
        }else{
            $this->model->where('payment_status', $status);
        }
        $totalFilteredRecords = $this->model->countAllResults(false);

        // Fetch the data (excluding soft deleted)
        if (!empty($search)) {
            $this->model->like('invoice_number', $search);
        }
        if($status == 4){
            $this->model->where('payment_status >=', $status);
        }else{
            $this->model->where('payment_status', $status);
        }
        $data = $this->model->where('deleted_at', null)->findAll($length, $start);

        foreach($data as $key => $val){
            $data[$key]->username = $this->modelUser->find($val->user_id)->username;
            $data[$key]->date_order = date('d/m/Y', strtotime($val->created_at));
        }
        // if($data) pre($data);

        // Prepare the response
        $response = [
            "draw" => intval($this->request->getPost('draw')),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalFilteredRecords,
            "data" => $data
        ];
        // pre($response,1);

        return $this->response->setJSON($response);
    }

    public function getDetailInvoice($id)
    {
        $error = "";
        
        if (!$this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }else{
            
            $invoice = $this->model->find($id);
            $userAddress = $this->modelUserAddress->where('user_id', $invoice->user_id)->first();
            $invoiceDetails = $this->modelDetails->where('transaction_id', $id)->orderBy('trd_id', 'ASC')->findAll();
            
            $badge = '';
            if($invoice){
                $badge = badgeStatus($invoice->payment_status);
            }
            $invoice->badge_status = $badge;
    
            $listProducts = '';
            foreach($invoiceDetails as $detail){
                $listProducts .= '
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <img src="'.site_url('uploads/thumbnails/'.$detail->thumbnail).'" class="img-fluid img-thumbnail" style="max-width: 100px;" alt="">
                    <span> '.$detail->product_name.' <p class="fst-italic"> Rp.'.$detail->price_tag.'</p></span>
                    <span class="badge bg-primary rounded-pill">'.$detail->qty.'</span>
                </li>';
            }
            $listProducts .= '
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Total
                    <strong class="total-invoice">Rp. '.$invoice->total_invoice.'</strong>
                </li>
            ';
    
            $data = [
                "userDetail" => $userAddress,
                "invoice" => $invoice,
                "invoiceDetails" => $invoiceDetails,
                "listProducts" => $listProducts
            ];
            // pre($data,1);
    
            if($invoice){
                return $this->response->setJSON(['status' => 'success', 'data' => $data, 'message' => 'Success get data']);
            }else{
                return $this->response->setJSON(['status' => 'error', 'message' => 'Cannot do this action, something wrong!']);
            }
        }
    }

    public function submit()
    {
        $error = "";
        if (!$this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }

        $act = strtolower(htmlspecialchars((string)$this->request->getPost('act'),ENT_QUOTES));
        $transaction_id = htmlspecialchars((string)$this->request->getPost('transaction_id'),ENT_QUOTES);

        if($act == 'confirm'){
            $data = [
                'payment_status' => 3,
            ];
        }elseif($act == 'delivery'){
            $receipt_number = htmlspecialchars((string)$this->request->getPost('receipt_number'),ENT_QUOTES);
            $delivery_service = htmlspecialchars((string)$this->request->getPost('delivery_service'),ENT_QUOTES);
            $data = [
                'payment_status' => 4,
                'receipt_number' => $receipt_number,
                'delivery_service' => $delivery_service,
            ];
        }elseif($act == 'finished'){
            $data = [
                'payment_status' => 5,
            ];
        }elseif($act == 'cancel'){
            $cancel_reason = htmlspecialchars((string)$this->request->getPost('cancel_reason'),ENT_QUOTES);
            $data = [
                'payment_status' => 6,
                'cancel_reason' => $cancel_reason,
            ];
        }else{
            $data = [];
        }

        // pre($data,1);
        $update = $this->model->update($transaction_id, $data);

        if($update){
            return $this->response->setJSON(['status' => 'success', 'message' => 'Invoice successfully '.$act]);
        }else{
            return $this->response->setJSON(['status' => 'error', 'message' => 'Cannot do this action, something wrong!']);
        }
    }
}
