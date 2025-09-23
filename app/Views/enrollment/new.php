<?= $this->extend('layout/student_template') ?>

<?= $this->section('content') ?>
    <div class="card">
        <h2>Pendaftaran Mata Kuliah</h2>
        <p>Pilih mata kuliah yang ingin Anda ambil semester ini.</p>

        <form action="<?= site_url('student/enroll') ?>" method="post">
            <?= csrf_field() ?>
            <table>
                <thead>
                    <tr>
                        <th>Pilih</th>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($availableCourses as $course) : ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="course_ids[]" value="<?= $course['id'] ?>" class="course-checkbox" data-sks="<?= $course['sks'] ?>">
                        </td>
                        <td><?= esc($course['kode_mk']) ?></td>
                        <td><?= esc($course['nama_mk']) ?></td>
                        <td><?= esc($course['sks']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <hr>
            <div style="text-align: right; margin-top: 20px;">
                <h3>Total SKS Dipilih: <span id="total-sks">0</span></h3>
                <button type="submit" class="btn">Daftar</button>
            </div>
        </form>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.course-checkbox');
    const totalSksSpan = document.getElementById('total-sks');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            let totalSks = 0;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    totalSks += parseInt(cb.dataset.sks, 10);
                }
            });
            totalSksSpan.textContent = totalSks;
        });
    });
});
</script>
<?= $this->endSection() ?>