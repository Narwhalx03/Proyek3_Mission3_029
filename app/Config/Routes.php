<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute Halaman Utama & Berita
// Keduanya memerlukan login (filter 'auth')
$routes->get('/home', 'Home::index', ['filter' => 'auth']);
$routes->get('/home/berita', 'Berita::index', ['filter' => 'auth']);

// Rute Autentikasi (Login & Logout)
$routes->get('/login', 'Login::index');
$routes->post('/login/process', 'Login::process');
$routes->get('/logout', 'Login::logout');

// Rute Dashboard berdasarkan Role
$routes->get('/admin/dashboard', 'AdminController::index', ['filter' => 'auth']);
$routes->get('/student/dashboard', 'StudentController::index', ['filter' => 'auth']);
$routes->get('/student/enroll/(:num)', 'StudentController::enroll/$1', ['filter' => 'auth']);
$routes->get('/student/unenroll/(:num)', 'StudentController::unenroll/$1', ['filter' => 'auth']);
$routes->resource('admin/courses', ['controller' => 'CourseController', 'filter' => 'admin']);
$routes->get('/student', 'Student::index'); // Menampilkan daftar
$routes->get('/student/create', 'Student::create'); // Menampilkan form
$routes->post('/student/store', 'Student::store'); // Memproses form
$routes->resource('mahasiswa', ['controller' => 'MahasiswaController', 'filter' => 'admin']);
$routes->group('mahasiswa', function ($routes) {
    $routes->get('/', 'Mahasiswa::index');
    $routes->get('new', 'Mahasiswa::new');
    $routes->post('create', 'Mahasiswa::create');
});

// Mengarahkan halaman root (/) ke halaman login
$routes->get('/', 'Login::index');

/*
 * Fungsi '/mahasiswa' sekarang ditangani oleh route group di atas.
 */
// $routes->get('/mahasiswa/display', 'Mahasiswa::display');
// $routes->get('/dosen/display', 'Dosen::display');