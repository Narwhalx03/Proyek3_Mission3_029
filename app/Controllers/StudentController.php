<?php
namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use App\Models\MahasiswaModel;

class StudentController extends BaseController
{
    public function index()
    {
      
        $courseModel = new CourseModel();
        $enrollmentModel = new EnrollmentModel();
        $mahasiswaModel = new MahasiswaModel();

        $mahasiswa = $mahasiswaModel->where('user_id', session()->get('user_id'))->first();
        
        $myCourses = [];
        $enrolledCourseIds = [];

        if ($mahasiswa) {
            $myCourses = $enrollmentModel->getCoursesByStudentId($mahasiswa['id']);
            $enrolledCourseIds = array_column($myCourses, 'id'); 
        }

        $data = [
            'title'            => 'Student Dashboard',
            'availableCourses' => $courseModel->findAll(),
            'myCourses'        => $myCourses,
            'enrolledCourseIds' => $enrolledCourseIds
        ];
        
        return view('student/dashboard', $data);
    }

    public function enroll($courseId)
    {
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $mahasiswaModel = new \App\Models\MahasiswaModel();
        $mahasiswa = $mahasiswaModel->where('user_id', session()->get('user_id'))->first();
        
        if (!$mahasiswa) {
            return redirect()->to('/student/dashboard')->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $mahasiswaId = $mahasiswa['id'];
        $alreadyEnrolled = $enrollmentModel->where([
            'mahasiswa_id' => $mahasiswaId,
            'course_id'    => $courseId
        ])->first();

        if ($alreadyEnrolled) {
            return redirect()->to('/student/dashboard')->with('error', 'Anda sudah terdaftar di mata kuliah ini.');
        }

        $data = [
            'mahasiswa_id' => $mahasiswaId,
            'course_id'    => $courseId,
        ];
        $enrollmentModel->insert($data);

        return redirect()->to('/student/dashboard')->with('success', 'Berhasil mendaftar mata kuliah.');
    }

    public function unenroll($courseId)
    {
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $mahasiswaModel = new \App\Models\MahasiswaModel();
        
        $mahasiswa = $mahasiswaModel->where('user_id', session()->get('user_id'))->first();
        
        if (!$mahasiswa) {
            return redirect()->to('/student/dashboard')->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $enrollment = $enrollmentModel->where([
            'mahasiswa_id' => $mahasiswa['id'],
            'course_id'    => $courseId
        ])->first();
        
        if ($enrollment) {
            $enrollmentModel->delete($enrollment['id']);
            return redirect()->to('/student/dashboard')->with('success', 'Berhasil un-enroll dari mata kuliah.');
        }

        return redirect()->to('/student/dashboard')->with('error', 'Data pendaftaran tidak ditemukan.');
    }
}