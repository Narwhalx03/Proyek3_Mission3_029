<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
    <div class="header">
        <h1>Add New Course</h1>
    </div>
    <div class="card">
        <form action="<?= site_url('admin/courses') ?>" method="post">
            <?= csrf_field() ?>

            <label for="kode_mk">Kode Mata Kuliah</label>
            <input type="text" name="kode_mk" required>
            
            <label for="nama_mk">Nama Mata Kuliah</label>
            <input type="text" name="nama_mk" required>

            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" rows="4"></textarea>
            <br><br>
            <button type="submit">Save Course</button>
            <a href="<?= site_url('admin/courses') ?>">Back</a>
        </form>
    </div>
<?= $this->endSection() ?>