<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>

    <style>
        .profile-card {
            display: flex;
            align-items: flex-start;
            gap: 30px;
        }
        .profile-avatar {
            flex-shrink: 0;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 600;
            color: #adb5bd;
            border: 4px solid #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .profile-details {
            flex-grow: 1;
        }
        .profile-header {
            margin-bottom: 20px;
        }
        .profile-header h2 {
            margin: 0 0 5px 0;
            font-size: 1.8rem;
        }
        .profile-header p {
            margin: 0;
            color: #6c757d;
            font-size: 1rem;
        }
        .detail-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .detail-list li {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-list li:last-child {
            border-bottom: none;
        }
        .detail-list dt { /* Label */
            font-weight: 500;
            color: #6c757d;
            width: 180px;
        }
        .detail-list dd { /* Value */
            margin: 0;
            font-weight: 500;
            color: #212529;
        }
        .actions {
            margin-top: 25px;
            display: flex;
            gap: 10px; 
        }
        .btn { 
            display: inline-block; 
            padding: 10px 15px; 
            color: white; 
            text-decoration: none; 
            border-radius: 6px; 
            font-weight: 500; 
            border: none; 
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .btn:hover { 
            opacity: 0.8; 
        }
        .btn-secondary { 
            background-color: #6c757d; 
        }
        .btn-reset { 
            background-color: #fd7e14; /* Warna oranye untuk aksi penting */
        }

        
        /* CSS untuk notifikasi */
        .alert { padding: 1rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .375rem; }
        .alert-success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
    </style>

    <div class="header">
        <h1>Detail Mahasiswa</h1>
    </div>

    <div class="card">
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
            <hr style="margin-bottom: 30px;">
        <?php endif; ?>

        <?php if (!empty($student)) : ?>
            <div class="profile-card">
                <div class="profile-avatar">
                    <?= esc(substr($student['nama_lengkap'], 0, 1)); ?>
                </div>
                <div class="profile-details">
                    <div class="profile-header">
                        <h2><?= esc($student['nama_lengkap']) ?></h2>
                        <p>NIM: <?= esc($student['nim']) ?></p>
                    </div>
                    <dl class="detail-list">
                        <li>
                            <dt>Username</dt>
                            <dd><?= esc($student['username']) ?></dd>
                        </li>
                        <li>
                            <dt>Tanggal Lahir</dt>
                            <dd><?= esc($student['tanggal_lahir']) ?></dd>
                        </li>
                        <li>
                            <dt>Tahun Masuk</dt>
                            <dd><?= esc($student['entry_year']) ?></dd>
                        </li>
                        <li style="align-items: center;">
                            <dt>Password (Simulasi)</dt>
                            <dd><strong style="color: #dc3545;"><?= esc($student['last_known_password']) ?></strong></dd>
                        </li>
                    </dl>
                </div>
            </div>
            <hr style="margin: 30px 0;">
            <div class="actions">
            <a href="<?= site_url('mahasiswa') ?>" class="btn btn-secondary">Kembali ke Daftar</a>
            <a href="<?= site_url('mahasiswa/reset_password/' . $student['id']) ?>" class="btn btn-reset" onclick="return confirm('Anda yakin ingin mereset password mahasiswa ini?');">Reset Password</a>
            </div>
        <?php else : ?>
            <p>Data mahasiswa tidak ditemukan.</p>
        <?php endif; ?>
    </div>

<?= $this->endSection() ?>