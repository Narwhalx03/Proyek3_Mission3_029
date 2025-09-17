<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
    <div class="header">
        <h1>Edit Student</h1>
    </div>

    <div class="card">
        <form action="<?= site_url('mahasiswa/' . $student['id']) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT"> <label for="nim">NIM</label>
            <input type="text" name="nim" required value="<?= esc($student['nim']) ?>">

            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" required value="<?= esc($student['nama_lengkap']) ?>">

            <label for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" required value="<?= esc($student['tanggal_lahir']) ?>">

            <label for="entry_year">Entry Year</label>
            <input type="number" name="entry_year" min="1990" max="2099" step="1" required value="<?= esc($student['entry_year']) ?>">
            <br><br>
            <button type="submit" class="btn">Update Student</button>
            <a href="<?= site_url('mahasiswa') ?>">Back</a>
        </form>
    </div>
<?= $this->endSection() ?>