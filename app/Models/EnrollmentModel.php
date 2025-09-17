<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table            = 'enrollments';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['mahasiswa_id', 'course_id'];

    // Timestamps
    protected $useTimestamps    = true;
    protected $createdField     = 'tanggal_daftar';
    protected $updatedField     = ''; 

    public function getCoursesByStudentId($mahasiswaId)
    {
        return $this->select('courses.id, courses.kode_mk, courses.nama_mk')
                    ->join('courses', 'courses.id = enrollments.course_id')
                    ->where('enrollments.mahasiswa_id', $mahasiswaId)
                    ->findAll();
    }

}