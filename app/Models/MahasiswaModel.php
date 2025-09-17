<?php
namespace App\Models;
use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'nim', 'nama_lengkap', 'umur', 'jurusan', 'tanggal_lahir', 'entry_year'];

    public function getStudentsWithUserDetails()
    {
        return $this->select('mahasiswa.*, user.username')
                    ->join('user', 'user.id = mahasiswa.user_id')
                    ->findAll();
    }

    public function findStudentById($id)
    {
        return $this->select('mahasiswa.*, user.username') 
                    ->join('user', 'user.id = mahasiswa.user_id')
                    ->where('mahasiswa.id', $id)
                    ->first();
    }
}