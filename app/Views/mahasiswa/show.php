<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
    <style>
        .detail-table { width: 100%; }
        .detail-table td { padding: 10px; border-bottom: 1px solid #eee; }
        .detail-table td:first-child { font-weight: bold; width: 200px; }
    </style>
    <div class="header">
        <h1>Detail Student</h1>
    </div>
    <div class="card">
        <a href="<?= site_url('mahasiswa') ?>">Back to Student List</a>
        <hr>
        <?php if (!empty($student)) : ?>
            <table class="detail-table">
                <tr>
                    <td>Full Name</td>
                    <td>: <?= esc($student['nama_lengkap']) ?></td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td>: <?= esc($student['nim']) ?></td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td>: <?= esc($student['tanggal_lahir']) ?></td>
                </tr>
                <tr>
                    <td>Entry Year</td>
                    <td>: <?= esc($student['entry_year']) ?></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td>: <?= esc($student['username']) ?></td>
                </tr>
            </table>
        <?php else : ?>
            <p>Student data not found.</p>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>