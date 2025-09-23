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
    helper('text');
    $plainPassword = random_string('alnum', 8); // Buat password acak

    $rules = [
        'nim'           => 'required|is_unique[user.username]',
        'nama_lengkap'  => 'required|min_length[3]',
        'tanggal_lahir' => 'required|valid_date',
        'entry_year'    => 'required|integer|exact_length[4]'
    ];

    if (!$this->validate($rules)) {
        return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors(), 'csrf' => csrf_hash()]);
    }

    $userModel = new \App\Models\UserModel();
    $mahasiswaModel = new \App\Models\MahasiswaModel();
    
    // 1. Buat data user
     $userData = [
        'username'  => $this->request->getPost('nim'),
        'password'  => password_hash($plainPassword, PASSWORD_DEFAULT),
        'full_name' => $this->request->getPost('nama_lengkap'),
        'role'      => 'Student',
        'last_known_password' => $plainPassword 
    ];
    
    $userModel->insert($userData);
    $userId = $userModel->getInsertID();

    // 2. Buat data mahasiswa yang terhubung dengan user_id
    $mahasiswaData = [
        'user_id'       => $userId,
        'nim'           => $this->request->getPost('nim'),
        'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
        'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
        'entry_year'    => $this->request->getPost('entry_year')
    ];
    $mahasiswaModel->insert($mahasiswaData);
    
    $newStudent = $mahasiswaModel->findStudentById($mahasiswaModel->getInsertID());

    return $this->response->setJSON([
        'success' => true,
        'message' => 'Student added successfully!',
        'student' => $newStudent,
        'csrf'    => csrf_hash()
    ]);
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
    try {
        $mahasiswaModel = new \App\Models\MahasiswaModel();
        $userModel = new \App\Models\UserModel();

        // Cari data mahasiswa untuk mendapatkan user_id
        $student = $mahasiswaModel->find($id);

        if ($student) {
            // Hapus data di tabel 'user', data di 'mahasiswa' akan ikut terhapus otomatis
            $userModel->delete($student['user_id']);
            
            // Kirim respons sukses dalam format JSON
            return $this->response->setJSON(['success' => true, 'message' => 'Student deleted successfully.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Student not found.'])->setStatusCode(404);
        }
    } catch (\Exception $e) {
        return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()])->setStatusCode(500);
    }
}

    public function edit($id = null)
{
    $mahasiswaModel = new \App\Models\MahasiswaModel();
    $student = $mahasiswaModel->findStudentById($id);

    if ($student) {
        // Jika data ditemukan, kirim sebagai respons JSON
        return $this->response->setJSON(['success' => true, 'student' => $student]);
    }

    // Jika tidak ditemukan, kirim error 404
    return $this->response->setJSON(['success' => false, 'message' => 'Student not found.'])->setStatusCode(404);
}
    public function update($id = null)
{
    // Cari data mahasiswa untuk mendapatkan user_id
    $mahasiswaModel = new \App\Models\MahasiswaModel();
    $student = $mahasiswaModel->find($id);

    // Aturan validasi (nim harus unik, tapi abaikan data nim milik mahasiswa ini sendiri)
    $rules = [
        'nim'           => "required|is_unique[mahasiswa.nim,id,{$id}]",
        'nama_lengkap'  => 'required|min_length[3]',
        'tanggal_lahir' => 'required|valid_date',
        'entry_year'    => 'required|integer|exact_length[4]'
    ];

    if (!$this->validate($rules)) {
        // Jika validasi gagal
        return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
    }

    // Jika validasi berhasil
    $userModel = new \App\Models\UserModel();

    // 1. Update data di tabel user
    $userData = [
        'full_name' => $this->request->getPost('nama_lengkap'),
        'username'  => $this->request->getPost('nim')
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

    // Kirim session flash untuk pesan sukses di halaman berikutnya
    session()->setFlashdata('success', 'Student data updated successfully.');

    // Kirim respons sukses
    return $this->response->setJSON(['success' => true]);
}

public function resetPassword($id = null)
    {
        helper('text'); // Panggil helper untuk membuat string acak
        $mahasiswaModel = new \App\Models\MahasiswaModel();
        $userModel = new \App\Models\UserModel();

        // 1. Cari data mahasiswa untuk mendapatkan user_id
        $student = $mahasiswaModel->find($id);
        if (!$student) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // 2. Buat password baru yang acak
        $newPassword = random_string('alnum', 10); // contoh: aB1cD2eF3g

        // 3. Siapkan data untuk diupdate di tabel 'user'
        $userData = [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'last_known_password' => $newPassword // Simpan versi teks biasa untuk simulasi
        ];

        // 4. Update password di tabel user
        $userModel->update($student['user_id'], $userData);

        // 5. Siapkan pesan sukses yang berisi password baru
        $successMessage = "Password berhasil direset. <br><strong>Password Baru:</strong> " . esc($newPassword);
        
        // 6. Kembali ke halaman edit dengan pesan sukses
        return redirect()->to('mahasiswa/' . $id)->with('success', $successMessage);
    }
    

    
}