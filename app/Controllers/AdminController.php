<?php
namespace App\Controllers;

class AdminController extends BaseController
{
    public function index()
    {
        // Menyiapkan data untuk dikirim ke view
        $data = [
            'title' => 'Admin Dashboard',
            'full_name' => session()->get('full_name') // Ambil nama dari session
        ];
        
        // Menampilkan view dashboard admin
        return view('admin/dashboard', $data);
    }
}