<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>

    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid var(--border-color); padding: 12px; text-align: left; }
        th { background-color: var(--bg-light); font-weight: 600; }
        .btn { display: inline-block; padding: 10px 15px; background-color: var(--primary-color); color: white; text-decoration: none; border-radius: 6px; font-weight: 500;}
    </style>

    <div class="header">
        <h1>Kelola Mata Kuliah</h1>
    </div>

    <div class="card">
        <a href="<?= site_url('admin/courses/new') ?>" class="btn">Tambah Course Baru</a>
        <br><br>
        <table>
            <thead>
                <tr>
                    <th>Kode MK</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($courses)) : ?>
                    <?php foreach ($courses as $course) : ?>
                    <tr>
                        <td><?= esc($course['kode_mk']); ?></td>
                        <td><?= esc($course['nama_mk']); ?></td>
                        <td><?= esc($course['deskripsi']); ?></td>
                        <td>
                            <a href="#">Edit</a> | <a href="#">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">Belum ada data mata kuliah.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

<?= $this->endSection() ?>