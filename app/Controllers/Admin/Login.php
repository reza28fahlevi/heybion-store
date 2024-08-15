<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AdminModel;

class Login extends BaseController
{
    protected $menu, $model;

    public function __construct()
    {
        // Initialize the variable
        $this->menu = "Login Admin";
        $this->model = new AdminModel();
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
        if ($this->checkLogin()) {
            return redirect()->to('hb-admin/login');
        }
        $data = [
            "menu" => $this->menu
        ];
        return view('Admin/Home/Login', $data);
    }

    public function login()
    {
        $session = session();

        $username = htmlspecialchars((string)$this->request->getPost('username'),ENT_QUOTES);
        $password = htmlspecialchars((string)$this->request->getPost('password'),ENT_QUOTES);

        $user = $this->model->where('username', $username)->first();

        if ($user) {
            if (hash_equals($user->password, crypt($password, $user->password))) {
                // pre($user,1);
                $session->set([
                    'username_admin' => $user->username,
                    'logged_admin' => true,
                ]);

                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid password.']);
            }
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'User not found.']);
        }
    }

    public function logout()
    {
        $data = [
            'username_admin' => NULL,
            'logged_admin' => false,
        ];

        session()->set($data);
        return redirect()->to('/hb-admin/login');
    }

    // public function logout()
    // {
    //     $session = session();
    //     $session->destroy();
    //     return redirect()->to('/login');
    // }
}
