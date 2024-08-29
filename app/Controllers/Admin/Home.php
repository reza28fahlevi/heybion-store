<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\InvoicesModel;
use App\Models\InvoiceDetailsModel;

class Home extends BaseController
{
    protected $menu, $modelInvoices, $modelInvoiceDetails;

    public function __construct()
    {
        $this->menu = "Dashboard";
        $this->modelInvoices = new InvoicesModel();
        $this->modelInvoiceDetails = new InvoiceDetailsModel();
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
        $monthlySales = $this->modelInvoices->getDataSalesMonthly();
        $bestSeller = $this->modelInvoices->bestSeller();
        $recentSales = $this->modelInvoices->recentSales();
        $data = [
            "menu" => $this->menu,
            "sales" => $monthlySales,
            "bestSeller" => $bestSeller,
            "recentSales" => $recentSales
        ];
        // pre($data,1);
        return view('Admin/Home/Dashboard', $data);
    }
}
