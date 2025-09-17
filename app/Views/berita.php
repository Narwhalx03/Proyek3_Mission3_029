<div class="container">
    <h1>Halaman Berita</h1>
    <p>Selamat datang, <?= esc(session()->get('nama')); ?>!</p>
    <p>Peran Anda adalah: <strong><?= esc(session()->get('role')); ?></strong></p>

    <nav>
        <a href="<?= site_url('/home') ?>">Home</a>
        
        <?php if (session()->get('role') === 'Admin') : ?>
            <a href="<?= site_url('/mahasiswa') ?>">| Kelola Mahasiswa</a>
            <a href="#">| Kelola Courses</a>
        <?php else : ?>
            <a href="#">| Lihat Daftar Courses</a>
        <?php endif; ?>
        
        <a href="<?= site_url('/logout') ?>">| Logout</a>
    </nav>
    <hr>
    
    </div>