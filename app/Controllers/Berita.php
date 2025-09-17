<?php
namespace App\Controllers;

use App\Models\MahasiswaModel;

class Berita extends BaseController
{
    public function index()
    {
        // 2. Buat instance dari model
        $mahasiswaModel = new MahasiswaModel();

        $data = [
            'title'      => 'Halaman Berita & Data Mahasiswa',
            'mahasiswas' => $mahasiswaModel->findAll() // Ambil data mahasiswa
        ];
        
        // 4. "Render" view berita sambil mengirimkan data ke dalamnya
        $data['content'] = view('berita', $data);
        return view('template', $data);
    }
}