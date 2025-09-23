<?= $this->extend('layout/student_template') ?>

<?= $this->section('content') ?>

    <?php if (session()->getFlashdata('success')) : ?>
    <div style="background-color: #d1e7dd; color: #0f5132; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #badbcc;">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php elseif (session()->getFlashdata('error')) : ?>
     <div style="background-color: #f8d7da; color: #842029; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c2c7;">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h2>Mata Kuliah Anda</h2>
            <a href="<?= site_url('student/enroll') ?>" class="btn-enroll">Ambil Mata Kuliah Baru</a>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Kode MK</th>
                    <th>Nama Mata Kuliah</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($myCourses)) : ?>
                    <?php foreach ($myCourses as $course) : ?>
                    <tr>
                        <td><?= esc($course['kode_mk']); ?></td>
                        <td><?= esc($course['nama_mk']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="2" style="text-align: center;">Anda belum mengambil mata kuliah apapun.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h2>Mata Kuliah Tersedia</h2>
        <table>
            <thead>
                <tr>
                    <th>Kode MK</th>
                    <th>Nama Mata Kuliah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                 <?php if (!empty($availableCourses)) : ?>
                    <?php foreach ($availableCourses as $course) : ?>
                    <tr>
                        <td><?= esc($course['kode_mk']); ?></td>
                        <td><?= esc($course['nama_mk']); ?></td>
                        <td>
                            <?php if (in_array($course['id'], $enrolledCourseIds)): ?>
                                <a href="<?= site_url('student/unenroll/' . $course['id']) ?>" 
                                   class="btn-enroll" style="background-color: #dc3545;"
                                   onclick="return confirm('Anda yakin ingin un-enroll dari mata kuliah: <?= esc($course['nama_mk']) ?>?');">
                                   Un-Enroll
                                </a>
                            <?php else: ?>
                                <a href="<?= site_url('student/enroll/' . $course['id']) ?>" 
                                   class="btn-enroll"
                                   onclick="return confirm('Anda yakin ingin mendaftar di mata kuliah: <?= esc($course['nama_mk']) ?>?');">
                                   Enroll
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                     <tr>
                        <td colspan="3" style="text-align: center;">Tidak ada mata kuliah yang tersedia saat ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

<?= $this->endSection() ?>