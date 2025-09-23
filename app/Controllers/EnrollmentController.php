<?php
namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use App\Models\MahasiswaModel;

class EnrollmentController extends BaseController
{
    public function new()
{
    $courseModel = new \App\Models\CourseModel();
    $enrollmentModel = new \App\Models\EnrollmentModel();
    $mahasiswaModel = new \App\Models\MahasiswaModel();

    // Cari data mahasiswa yang sedang login
    $mahasiswa = $mahasiswaModel->where('user_id', session()->get('user_id'))->first();

    // Jika karena suatu hal data mahasiswa tidak ada, kembalikan
    if (!$mahasiswa) {
        return redirect()->to('/student/dashboard')->with('error', 'Profil mahasiswa tidak ditemukan.');
    }

    // Ambil ID mata kuliah yang sudah di-enroll
    $myCourses = $enrollmentModel->where('mahasiswa_id', $mahasiswa['id'])->findColumn('course_id') ?? [];

    if (!empty($myCourses)) {
        // Jika sudah ada course yang diambil, cari sisa course yang belum diambil
        $availableCourses = $courseModel->whereNotIn('id', $myCourses)->findAll();
    } else {
        // Jika belum pernah ambil course sama sekali, tampilkan semua course
        $availableCourses = $courseModel->findAll();
    }

    $data = [
        'title'            => 'Enroll New Course',
        'availableCourses' => $availableCourses,
    ];

    return view('enrollment/new', $data);
}

    /**
     * Memproses data dari form enroll
     */
    public function create()
    {
        $enrollmentModel = new EnrollmentModel();
        $mahasiswaModel = new MahasiswaModel();

        // Dapatkan course_ids yang dipilih dari form (berupa array)
        $courseIds = $this->request->getPost('course_ids');

        // Cari data mahasiswa yang sedang login
        $mahasiswa = $mahasiswaModel->where('user_id', session()->get('user_id'))->first();

        if (!empty($courseIds) && $mahasiswa) {
            foreach ($courseIds as $courseId) {
                $enrollmentData = [
                    'mahasiswa_id' => $mahasiswa['id'],
                    'course_id'    => $courseId
                ];
                // Masukkan satu per satu ke database
                $enrollmentModel->insert($enrollmentData);
            }
            return redirect()->to('/student/dashboard')->with('success', 'Berhasil mendaftar di mata kuliah yang dipilih.');
        }

        return redirect()->back()->with('error', 'Tidak ada mata kuliah yang dipilih.');
    }
}