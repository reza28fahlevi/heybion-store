<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table            = 'usr_cart';
    protected $primaryKey       = 'cart_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id','product_id','qty','status','created_by','updated_by','deleted_by','is_deleted'];

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
        $builder = $this->db->table($this->table);
        $builder->where($this->primaryKey, $data['id'][0]); // Where clause to select the deleted row
        $builder->update([
            'is_deleted' => true,
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => session()->get('username'),
        ]);
    }

    public function getMyCart($user_id)
    {
        $builder = $this->db->table($this->table);
        $builder->select('cart_id,user_id,usr_cart.product_id,qty,status,product_name,price_tag,thumbnail,description,stock,product_status,max_purchase,min_purchase');
        $builder->join('prd_products', 'usr_cart.product_id = prd_products.product_id', 'left');
        $builder->where('usr_cart.user_id', $user_id);
        $builder->where('status', 1);
        $builder->where('product_status <>', 2);
        $builder->where('usr_cart.is_deleted', false);
        return $builder->get()->getResult();
    }

    public function updateMyCart($user_id)
    {
        $builder = $this->db->table($this->table);
        $builder->set('status',2);
        $builder->where('user_id', $user_id);
        $builder->where('status', 1);
        $builder->where('is_deleted', false);
        return $builder->update();
    }
}
