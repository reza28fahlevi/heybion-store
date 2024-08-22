<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoicesModel extends Model
{
    protected $table            = 'trt_invoices';
    protected $primaryKey       = 'transaction_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['invoice_number', 'total_invoice', 'payment_method', 'payment_status', 'payment_proof', 'created_by', 'updated_by', 'deleted_by', 'is_deleted', 'user_id', 'receipt_number', 'delivery_service'];

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
        $data['data']['updated_by'] = session()->get('username');
        return $data;
    }

    // Callback method after delete
    protected function afterDelete(array $data)
    {
        // Perform the update after soft delete
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where($this->primaryKey, $data['id'][0]); // Where clause to select the deleted row
        $builder->update([
            'is_deleted' => true,
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => session()->get('username'),
        ]);
    }

}
