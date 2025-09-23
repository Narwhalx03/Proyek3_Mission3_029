<?php
namespace App\Models;
use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'nim', 'nama_lengkap', 'umur', 'jurusan', 'tanggal_lahir', 'entry_year'];

    // Fungsi untuk menampilkan SEMUA mahasiswa
    public function getStudentsWithUserDetails()
    {
        return $this->select('mahasiswa.*, user.username')
                    ->join('user', 'user.id = mahasiswa.user_id')
                    ->findAll();
    }

    // Fungsi untuk mencari SATU mahasiswa (ini yang kita perbaiki)
    public function findStudentById($id)
    {
        return $this->select('mahasiswa.*, user.username, user.last_known_password') 
                    ->join('user', 'user.id = mahasiswa.user_id')
                    ->where('mahasiswa.id', $id)
                    ->first();
    }
}