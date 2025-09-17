<?php
namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\UserModel;

class MahasiswaController extends BaseController
{
    /**
     * Menampilkan daftar semua mahasiswa (Fitur: Student List)
     */
    public function index()
    {
        $mahasiswaModel = new MahasiswaModel();
        $data = [
            'title' => 'Student List',
            // Kita pakai fungsi kustom dari model untuk mengambil data gabungan
            'students' => $mahasiswaModel->getStudentsWithUserDetails() 
        ];
        return view('mahasiswa/index', $data);
    }

    /**
     * Menampilkan form untuk menambah mahasiswa baru (Fitur: Add Student Form)
     */
    public function new()
    {
        $data = [
            'title' => 'Add Student'
        ];
        return view('mahasiswa/new', $data);
    }

    /**
     * Memproses data dari form tambah mahasiswa baru
     */
    public function create()
{
    // 1. Panggil helper 'text' untuk bisa menggunakan fungsi random_string()
    helper('text');

    // 2. Buat password acak (8 karakter, alfanumerik)
    $plainPassword = random_string('alnum', 8);

    // 3. Siapkan data untuk tabel 'user', gunakan password acak yang sudah di-hash
    $userModel = new \App\Models\UserModel();
    $userData = [
        'username'  => $this->request->getPost('nim'),
        'password'  => password_hash($plainPassword, PASSWORD_DEFAULT), // <-- Gunakan password acak
        'full_name' => $this->request->getPost('nama_lengkap'),
        'role'      => 'Student'
    ];

    // 4. Coba simpan data user dan cek keberhasilannya
    if ($userModel->insert($userData)) {
        $userId = $userModel->getInsertID();
        
        $mahasiswaModel = new \App\Models\MahasiswaModel();
        $mahasiswaData = [
            'user_id'       => $userId,
            'nim'           => $this->request->getPost('nim'),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'entry_year'    => $this->request->getPost('entry_year')
        ];
        $mahasiswaModel->insert($mahasiswaData);

        // 5. Siapkan pesan sukses yang berisi username dan password baru
        $successMessage = "Mahasiswa baru berhasil ditambahkan! <br><strong>Username:</strong> " . esc($this->request->getPost('nim')) . " <br><strong>Password:</strong> " . esc($plainPassword);

        return redirect()->to('/mahasiswa')->with('success', $successMessage);

    } else {
        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data. Kemungkinan NIM sudah terdaftar.');
    }
}

public function show($id = null)
    {
        $mahasiswaModel = new MahasiswaModel();
        $data = [
            'title'   => 'Detail Student',
            'student' => $mahasiswaModel->findStudentById($id)
        ];

        if (empty($data['student'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the student item: ' . $id);
        }

        return view('mahasiswa/show', $data);
    }

    public function delete($id = null)
    {
        $mahasiswaModel = new MahasiswaModel();
        $userModel = new \App\Models\UserModel();

        // Cari data mahasiswa untuk mendapatkan user_id
        $student = $mahasiswaModel->find($id);

        if ($student) {
            // Hapus data di tabel 'user', maka data di 'mahasiswa' akan ikut terhapus
            $userModel->delete($student['user_id']);
            return redirect()->to('/mahasiswa')->with('success', 'Student deleted successfully.');
        }

        return redirect()->to('/mahasiswa')->with('error', 'Student not found.');
    }

    public function edit($id = null)
    {
        $mahasiswaModel = new MahasiswaModel();
        $data = [
            'title'   => 'Edit Student',
            'student' => $mahasiswaModel->findStudentById($id) // Kita pakai lagi fungsi yang sudah ada
        ];

        if (empty($data['student'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the student item: ' . $id);
        }

        return view('mahasiswa/edit', $data);
    }

    /**
     * Memproses data dari form edit
     */
    public function update($id = null)
    {
        $mahasiswaModel = new MahasiswaModel();
        $userModel = new \App\Models\UserModel();

        // Cari data mahasiswa untuk mendapatkan user_id
        $student = $mahasiswaModel->find($id);

        // 1. Update data di tabel user
        $userData = [
            'full_name' => $this->request->getPost('nama_lengkap')
        ];
        $userModel->update($student['user_id'], $userData);

        // 2. Update data di tabel mahasiswa
        $mahasiswaData = [
            'nim'           => $this->request->getPost('nim'),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'entry_year'    => $this->request->getPost('entry_year')
        ];
        $mahasiswaModel->update($id, $mahasiswaData);

        return redirect()->to('/mahasiswa')->with('success', 'Student data updated successfully.');
    }

    
}