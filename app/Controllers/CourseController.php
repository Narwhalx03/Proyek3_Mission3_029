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
        $courseModel = new \App\Models\CourseModel();
        $data = [
            'kode_mk'   => $this->request->getPost('kode_mk'),
            'nama_mk'   => $this->request->getPost('nama_mk'),
            'deskripsi' => $this->request->getPost('deskripsi')
        ];

        $courseModel->insert($data);

        return redirect()->to('/admin/courses')->with('success', 'Course added successfully.');
    }
}