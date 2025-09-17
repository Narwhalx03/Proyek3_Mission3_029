<?php
namespace App\Controllers;
class Student extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $query = $db->table('mahasiswa')->get();
        $data['mahasiswa'] = $query->getResultArray();
        
        // Memuat view dan mengirimkan data students
        return view('admin/student_list', $data);
    }

    public function create()
    {
        return view('admin/student_add');
    }

    public function store()
    {
        $db = \Config\Database::connect();
        
        $data = [
            'nim'           => $this->request->getPost('nim'),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'email'         => $this->request->getPost('email'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'entry_year'    => $this->request->getPost('entry_year'),
        ];

        $db->table('mahasiswa')->insert($data);

        // Arahkan kembali ke halaman daftar student
        return redirect()->to('/mahasiswa');
    }
}