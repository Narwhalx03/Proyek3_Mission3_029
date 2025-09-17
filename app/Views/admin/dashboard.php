<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>

    <div class="header">
        <h1>Dashboard</h1>
    </div>

    <div class="card">
        <h2>Selamat datang, <?= esc(session()->get('full_name')); ?>!</h2>
        <p>Anda login sebagai Admin. Gunakan menu di yang tersedia untuk mengelola sistem.</p>
    </div>

<?= $this->endSection() ?>