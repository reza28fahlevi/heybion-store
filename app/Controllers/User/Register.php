<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;

class Register extends BaseController
{

    protected $menu, $model;

    public function __construct()
    {
        // Initialize the variable
        $this->menu = "Register User";
        $this->model = new UsersModel();
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
        if ($this->checkLogin()) {
            return redirect()->to('');
        }

        $data = [
            "menu" => $this->menu
        ];
        return view('User/Register', $data);
    }

    public function createAccount()
    {
        $error = "";
        // Get form data
        $name = htmlspecialchars((string)$this->request->getPost('name'),ENT_QUOTES);
        $username = htmlspecialchars((string)$this->request->getPost('username'),ENT_QUOTES);
        $password = htmlspecialchars((string)$this->request->getPost('password'),ENT_QUOTES);
        $salt = bin2hex(random_bytes(22)); // Generate a random salt
        $hashedPassword = crypt($password, $salt); // Hash the password with the salt
        // Prepare data for insertion
        $data = [
            'name' => $name,
            'username' => $username,
            'password' => $hashedPassword,
        ];

        // pre($data,1);
        // Insert data into the database
        $insert = $this->model->insert($data);
        if ($insert) {
            return $this->response->setJSON([
                'status' => 'success',
                'error' => $error,
                'message' => "Successfully created a new account",
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'error' => $error,
                'message' => "Failed to register",
            ]);
        }
    }
}
