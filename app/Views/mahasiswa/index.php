<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>

    <style>
        .action-btn a, .action-btn button { 
            display: inline-block; 
            padding: 5px 10px; 
            color: white; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 0.9em; 
            margin-right: 5px;
            border: none; /* Untuk tombol delete */
            cursor: pointer; /* Untuk tombol delete */
            font-family: 'Poppins', sans-serif; /* Menyamakan font */
        }
        .btn-detail { background-color: #0d6efd; }
        .btn-update { background-color: #ffc107; }
        .btn-delete { background-color: #dc3545; }

        /* CSS untuk notifikasi */
        .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 6px; }
        .alert-success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
        .alert-error { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }
    </style>

    <div class="header">
        <h1>Student List</h1>
    </div>

    <div class="card">
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php elseif (session()->getFlashdata('error')) : ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <a href="<?= site_url('mahasiswa/new') ?>" class="btn">Add Student</a>
        <br><br>

        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Lengkap</th>
                    <th>Tanggal Lahir</th>
                    <th>Entry Year</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($students)) : ?>
                    <?php foreach ($students as $student) : ?>
                    <tr>
                        <td><?= esc($student['nim']); ?></td>
                        <td><?= esc($student['nama_lengkap']); ?></td>
                        <td><?= esc($student['tanggal_lahir']); ?></td>
                        <td><?= esc($student['entry_year']); ?></td>
                        <td class="action-btn">
                            <a href="<?= site_url('mahasiswa/' . $student['id']) ?>" class="btn-detail">Detail</a>
                            <a href="<?= site_url('mahasiswa/' . $student['id'] . '/edit') ?>" class="btn-update">Update</a>
                            <form action="<?= site_url('mahasiswa/' . $student['id']) ?>" method="post" style="display:inline;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Belum ada data mahasiswa.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?= $this->endSection() ?>