<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;

class Login extends BaseController
{
    protected $menu, $model;

    public function __construct()
    {
        // Initialize the variable
        $this->menu = "Login User";
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
        return view('User/Login', $data);
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
                    // 'uid' => $user->user_id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'logged' => true,
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
            // 'uid' => NULL,
            'name' => NULL,
            'username' => NULL,
            'logged' => false,
        ];

        session()->set($data);
        return redirect()->to('/login');
    }
}
