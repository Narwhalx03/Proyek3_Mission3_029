<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class StudentFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah role di session BUKAN 'Student'
        if (session()->get('role') !== 'Student') {
            // Jika bukan student, kembalikan ke halaman sebelumnya dengan pesan error
            return redirect()->back()->with('error', 'Halaman ini hanya untuk mahasiswa.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}