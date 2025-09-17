<?php
namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login_view');
    }

    public function process()
    {
        $model = new UserModel();
        
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Jika berhasil, simpan data ke session
            $session_data = [
                'user_id'    => $user['id'],
                'username'   => $user['username'],
                'full_name'  => $user['full_name'],
                'role'       => $user['role'],
                'isLoggedIn' => true,
            ];
            session()->set($session_data);
            
            // Arahkan sesuai role
            if ($user['role'] === 'Admin') {
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/student/dashboard');
            }

        } else {
            // Jika gagal, kembali ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Username atau Password salah.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}