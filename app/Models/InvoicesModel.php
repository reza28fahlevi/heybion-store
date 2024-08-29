<?php

namespace App\Models;

use CodeIgniter\Model;
use PharIo\Version\OrVersionConstraintGroup;

class InvoicesModel extends Model
{
    protected $table            = 'trt_invoices';
    protected $primaryKey       = 'transaction_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['invoice_number', 'total_invoice', 'payment_method', 'payment_status', 'payment_proof', 'created_by', 'updated_by', 'deleted_by', 'is_deleted', 'user_id', 'receipt_number', 'delivery_service', 'cancel_reason', 'total_cart', 'shipping_cost'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['beforeAdd'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['beforeUpdate'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = ['afterDelete'];

    protected function beforeAdd(array $data){
        $data['data']['is_deleted'] = false;
        $data['data']['created_by'] = session()->get('username');
        return $data;
    }

    protected function beforeUpdate(array $data){
        $data['data']['updated_by'] = session()->get('username') ?? session()->get('username_admin');
        return $data;
    }

    // Callback method after delete
    protected function afterDelete(array $data)
    {
        // Perform the update after soft delete
        $builder = $this->db->table($this->table);
        $builder->where($this->primaryKey, $data['id'][0]); // Where clause to select the deleted row
        $builder->update([
            'is_deleted' => true,
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => session()->get('username'),
        ]);
    }

    public function getDataSalesMonthly()
    {
        $previousMonth = date('Ym', strtotime('-1 month'));
        $thisMonth = date('Ym');
        // sales
        $totalSalesThisMonth = $this->db->query("SELECT
                COALESCE(SUM(qty),0) AS totalsales
            FROM
                trt_invoicedetails
            WHERE
                transaction_id IN(
                    SELECT
                        transaction_id FROM trt_invoices
                    WHERE
                        SUBSTRING(invoice_number FROM 1 FOR 10) = 'INV-".$thisMonth."')")->getRow()->totalsales;
        $totalSalesPreviousMonth = $this->db->query("SELECT
                COALESCE(SUM(qty),0) AS totalsales
            FROM
                trt_invoicedetails
            WHERE
                transaction_id IN(
                    SELECT
                        transaction_id FROM trt_invoices
                    WHERE
                        SUBSTRING(invoice_number FROM 1 FOR 10) = 'INV-".$previousMonth."')")->getRow()->totalsales;

        // user
        $totalUserCheckout = $this->db->query("SELECT
                count(*) AS uid
            FROM (
                SELECT
                    user_id
                FROM
                    trt_invoices
                WHERE
                    SUBSTRING(invoice_number FROM 1 FOR 10) = 'INV-".$thisMonth."'
                GROUP BY
                    user_id) x")->getRow()->uid;
        $totalUserPrevious = $this->db->query("SELECT
                count(*) AS uid
            FROM (
                SELECT
                    user_id
                FROM
                    trt_invoices
                WHERE
                    SUBSTRING(invoice_number FROM 1 FOR 10) = 'INV-".$previousMonth."'
                GROUP BY
                    user_id) x")->getRow()->uid;

        // invoice
        $totalInvoice = $this->db->query("SELECT
                count(*) AS total
            FROM 
                trt_invoices
            WHERE
                SUBSTRING(invoice_number FROM 1 FOR 10) = 'INV-".$thisMonth."'")->getRow()->total;
        $totalPreviousInvoice = $this->db->query("SELECT
                count(*) AS total
            FROM 
                trt_invoices
            WHERE
                SUBSTRING(invoice_number FROM 1 FOR 10) = 'INV-".$previousMonth."'")->getRow()->total;

        // revenue
        $totalRevenue = $this->db->query("SELECT
                sum(total_invoice) AS total
            FROM 
                trt_invoices
            WHERE
                SUBSTRING(invoice_number FROM 1 FOR 10) = 'INV-".$thisMonth."'")->getRow()->total;
        $totalPreviousRevenue = $this->db->query("SELECT
                sum(total_invoice) AS total
            FROM 
                trt_invoices
            WHERE
                SUBSTRING(invoice_number FROM 1 FOR 10) = 'INV-".$previousMonth."'")->getRow()->total;


        // percentage
        if($totalSalesPreviousMonth > 0){
            $percentageSales = (($totalSalesThisMonth-$totalSalesPreviousMonth)/$totalSalesPreviousMonth)*100;
        }else{
            $percentageSales = 100;
        }

        if($totalUserPrevious > 0){
            $percentageUser = (($totalUserCheckout-$totalUserPrevious)/$totalUserPrevious)*100;
        }else{
            $percentageUser = 100;
        }
        
        if($totalPreviousInvoice > 0){
            $percentageInvoice = (($totalInvoice-$totalPreviousInvoice)/$totalPreviousInvoice)*100;
        }else{
            $percentageInvoice = 100;
        }
        
        if($totalPreviousRevenue > 0){
            $percentageRevenue = (($totalRevenue-$totalPreviousRevenue)/$totalPreviousRevenue)*100;
        }else{
            $percentageRevenue = 100;
        }
        $data_result = (object) [
            'percentageSales' => $percentageSales,
            'percentageUser' => $percentageUser,
            'percentageInvoice' => $percentageInvoice,
            'percentageRevenue' => $percentageRevenue,
            'thisMonth' => $totalSalesThisMonth,
            'previousMonth' => $totalSalesPreviousMonth,
            'userThisMonth' => $totalUserCheckout,
            'userPreviousMonth' => $totalUserPrevious,
            'totalInvoice' => $totalInvoice,
            'totalPreviousInvoice' => $totalPreviousInvoice,
            'totalRevenue' => $totalRevenue,
            'totalPreviousRevenue' => $totalPreviousRevenue,
        ];
        return $data_result;
    }

    public function bestSeller()
    {
        $previousMonth = date('Ym', strtotime('-1 month'));
        $thisMonth = date('Ym');
        $bestSeller = $this->db->query("WITH bestseller AS (
                SELECT
                    product_id,
                    sum(qty) AS total
                FROM
                    trt_invoicedetails
                WHERE
                    transaction_id IN(
                        SELECT
                            transaction_id FROM trt_invoices
                        WHERE
                            SUBSTRING(invoice_number FROM 1 FOR 10) = 'INV-".$thisMonth."')
                GROUP BY
                    product_id
                ORDER BY
                    total DESC
                LIMIT 5
            )
            SELECT
                bs.total,
                pr.*
            FROM
                bestseller bs
                LEFT JOIN prd_products pr ON bs.product_id = pr.product_id ORDER BY bs.total DESC")->getResult();
        if(!$bestSeller){
            $bestSeller = $this->db->query("WITH bestseller AS (
                    SELECT
                        product_id,
                        sum(qty) AS total
                    FROM
                        trt_invoicedetails
                    WHERE
                        transaction_id IN(
                            SELECT
                                transaction_id FROM trt_invoices
                            WHERE
                                SUBSTRING(invoice_number FROM 1 FOR 10) = 'INV-".$previousMonth."')
                    GROUP BY
                        product_id
                    ORDER BY
                        total DESC
                    LIMIT 5
                )
                SELECT
                    bs.total,
                    pr.*
                FROM
                    bestseller bs
                    LEFT JOIN prd_products pr ON bs.product_id = pr.product_id ORDER BY bs.total DESC")->getResult();
        }
        return $bestSeller;
    }

    public function recentSales()
    {
        $result = $this->db->query("SELECT
                ti.invoice_number,
                ti.payment_status,
                usr.name,
                td.*
            FROM
                trt_invoicedetails td
                LEFT JOIN trt_invoices ti ON td.transaction_id = ti.transaction_id
                LEFT JOIN usr_users usr ON ti.user_id = usr.user_id
            ORDER BY
                created_at DESC
            LIMIT 10")->getResult();
        return $result;
    }

}
