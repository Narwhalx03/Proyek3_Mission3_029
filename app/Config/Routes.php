<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Arahkan root ke login
$routes->get('/', 'Login::index');

// Rute Autentikasi
$routes->get('/login', 'Login::index');
$routes->post('/login/process', 'Login::process');
$routes->get('/logout', 'Login::logout');

// Rute Dashboard
$routes->get('/admin/dashboard', 'AdminController::index');
$routes->get('/student/dashboard', 'StudentController::index');

// Rute Admin
$routes->get('mahasiswa/reset_password/(:num)', 'MahasiswaController::resetPassword/$1');
$routes->resource('mahasiswa', ['controller' => 'MahasiswaController']);
$routes->resource('admin/courses', ['controller' => 'CourseController']);

// Rute Student
$routes->get('/student/enroll', 'EnrollmentController::new');
$routes->post('/student/enroll', 'EnrollmentController::create');
$routes->get('/student/enroll/(:num)', 'StudentController::enroll/$1'); 
$routes->get('/student/unenroll/(:num)', 'StudentController::unenroll/$1'); 