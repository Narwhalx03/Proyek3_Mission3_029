<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
    <div class="header">
        <h1>Add Student</h1>
    </div>

    <div class="card">
        <form action="<?= site_url('mahasiswa') ?>" method="post">
            <?= csrf_field() ?>
            <label for="nim">NIM</label>
            <input type="text" name="nim" required>

            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" required>

            <label for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" required>

            <label for="entry_year">Entry Year</label>
            <input type="number" name="entry_year" min="1990" max="2099" step="1" required>
            <br><br>
            <button type="submit" class="btn">Save Student</button>
            <a href="<?= site_url('mahasiswa') ?>">Back</a>
        </form>
    </div>
<?= $this->endSection() ?>