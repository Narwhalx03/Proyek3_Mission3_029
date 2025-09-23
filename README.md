# Sistem Informasi Akademik (SiAkad) Sederhana

Sebuah aplikasi web sederhana untuk manajemen akademik yang dibangun menggunakan CodeIgniter 4. Aplikasi ini didesain untuk memisahkan hak akses dan fitur antara peran **Admin** dan **Mahasiswa** dengan antarmuka yang interaktif dan modern (AJAX-based).

Proyek ini dibuat sebagai simulasi dan hasil pembelajaran intensif.

---

## Fitur Utama

Aplikasi ini memiliki dua hak akses utama dengan fitur yang berbeda:

### Sebagai Admin
* **Manajemen Mahasiswa (CRUD):** Admin dapat menambah, melihat, mengedit, dan menghapus data mahasiswa. Semua interaksi ini berjalan tanpa refresh halaman (AJAX).
* **Manajemen Mata Kuliah (CRUD):** Admin dapat mengelola data mata kuliah (menambah, melihat, mengedit, menghapus) secara interaktif.
* **Reset Password:** Admin dapat membuatkan password acak baru untuk mahasiswa yang lupa passwordnya. Password baru ini akan ditampilkan di halaman detail.
* **Validasi Form:** Form tambah/edit memiliki validasi di sisi server yang pesannya ditampilkan secara real-time di form.

### Sebagai Mahasiswa
* **Dashboard:** Melihat daftar mata kuliah yang sudah diambil dan yang tersedia.
* **Enroll & Un-enroll:** Mahasiswa dapat mendaftar dan membatalkan pendaftaran pada mata kuliah yang tersedia.
* **Form Pendaftaran Canggih:** Halaman khusus untuk memilih beberapa mata kuliah sekaligus menggunakan checklist, lengkap dengan kalkulator total SKS yang dipilih secara real-time.

### Fitur UI & UX
* **Interaksi Tanpa Refresh:** Sebagian besar aksi (Tambah, Hapus, Update) tidak memerlukan muat ulang halaman.
* **Menu Aktif:** Menu navigasi secara dinamis menandakan halaman yang sedang dibuka.
* **Dialog Konfirmasi:** Aksi-aksi penting seperti 'Delete' memiliki dialog konfirmasi custom untuk mencegah kesalahan.

---

## Teknologi yang Digunakan

* **Backend:** PHP 8.2, CodeIgniter 4.4.8
* **Frontend:** HTML5, CSS3, JavaScript (ES6+), Fetch API (untuk AJAX)
* **Database:** MySQL / MariaDB
* **Server Lokal:** XAMPP
* **Package Manager:** Composer


## Akun Demo

Anda bisa menggunakan akun di bawah ini untuk melakukan testing:

* **Admin**
    * **Username:** `admin`
    * **Password:** `password`
