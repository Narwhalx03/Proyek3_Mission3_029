<?php
namespace App\Controllers;

use App\Models\CourseModel;

class CourseController extends BaseController
{
    public function index()
    {
        // Panggil model
        $courseModel = new CourseModel();
        
        // Siapkan data untuk dikirim ke view
        $data = [
            'title'   => 'Kelola Mata Kuliah',
            'courses' => $courseModel->findAll() // Ambil semua data courses
        ];
        
        // Tampilkan view
        return view('courses/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Add New Course'
        ];
        return view('courses/new', $data);
    }

    /**
     * Menyimpan data course baru
     */
    public function create()
{
    // Atur aturan validasi
    $rules = [
        'kode_mk'   => 'required|is_unique[courses.kode_mk]|min_length[3]',
        'nama_mk'   => 'required|min_length[5]'
    ];

    if (!$this->validate($rules)) {
        // Jika validasi gagal, kirim error dalam format JSON
        return $this->response->setJSON([
            'success' => false,
            'errors' => $this->validator->getErrors()
        ]);
    }

    // Jika validasi berhasil, simpan data
    $courseModel = new \App\Models\CourseModel();
    $data = [
        'kode_mk'   => $this->request->getPost('kode_mk'),
        'nama_mk'   => $this->request->getPost('nama_mk'),
        'deskripsi' => $this->request->getPost('deskripsi')
    ];

    $courseModel->insert($data);
    $newCourseId = $courseModel->getInsertID();
    $newCourse = $courseModel->find($newCourseId); // Ambil data lengkap course baru

    // Kirim respons sukses dalam format JSON
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Course added successfully!',
        'course'  => $newCourse
    ]);
}

public function edit($id = null)
    {
        $courseModel = new \App\Models\CourseModel();
        $course = $courseModel->find($id);

        if ($course) {
            return $this->response->setJSON(['success' => true, 'course' => $course]);
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Course not found.'])->setStatusCode(404);
    }

    /**
     * Memproses update data course (merespons AJAX)
     */
    public function update($id = null)
    {
        $rules = [
            'kode_mk' => "required|is_unique[courses.kode_mk,id,{$id}]",
            'nama_mk' => 'required|min_length[5]',
            'sks'     => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors(), 'csrf' => csrf_hash()]);
        }

        $courseModel = new \App\Models\CourseModel();
        $data = [
            'kode_mk'   => $this->request->getPost('kode_mk'),
            'nama_mk'   => $this->request->getPost('nama_mk'),
            'sks'       => $this->request->getPost('sks'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ];
        
        $courseModel->update($id, $data);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Course updated successfully!',
            'course'  => $courseModel->find($id),
            'csrf'    => csrf_hash()
        ]);
    }

    public function delete($id = null)
    {
        try {
            $courseModel = new \App\Models\CourseModel();
            $course = $courseModel->find($id);

            if ($course) {
                $courseModel->delete($id);
                return $this->response->setJSON([
                    'success' => true, 
                    'message' => 'Course berhasil dihapus.',
                    'csrf'    => csrf_hash()
                ]);
            }

            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Course not found.'
            ])->setStatusCode(404);

        } catch (\Exception $e) {
            // Menangani error jika course tidak bisa dihapus (misal: karena terhubung dengan data enrollment)
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Course tidak bisa dihapus karena sudah diambil oleh mahasiswa.'
            ])->setStatusCode(500);
        }
    }

}