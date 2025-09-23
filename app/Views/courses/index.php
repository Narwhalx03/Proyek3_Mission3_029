<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>

    <style>
        .action-btn a, .action-btn button, .btn { display: inline-block; padding: 8px 12px; color: white; text-decoration: none; border-radius: 6px; font-size: 0.9em; margin-right: 5px; border: none; cursor: pointer; font-family: 'Poppins', sans-serif; transition: opacity 0.2s; font-weight: 500; }
        .action-btn a:hover, .action-btn button:hover, .btn:hover { opacity: 0.8; }
        .btn-add { background-color: #198754; color: white; }
        .btn-update { background-color: #ffc107; color: #000; }
        .btn-delete { background-color: #dc3545; color: white; }

        .alert { padding: 1rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .375rem; }
        .alert-success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
        .alert-error { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }
        
        /* CSS untuk Modal (form pop-up) */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(5px); }
        .modal-content { background-color: #fefefe; margin: 10% auto; padding: 30px; border: 1px solid #ddd; width: 90%; max-width: 500px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); position: relative; }
        .close-btn { color: #aaa; float: right; font-size: 28px; font-weight: bold; position: absolute; top: 10px; right: 20px;}
        .close-btn:hover, .close-btn:focus { color: black; text-decoration: none; cursor: pointer; }
        
        /* CSS untuk Form di dalam Modal */
        .form-group { margin-bottom: 1rem; text-align: left; }
        .form-group label { display: block; margin-bottom: .5rem; font-weight: 500; color: #495057; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ced4da; font-size: 1rem; font-family: 'Poppins', sans-serif; }
        .form-group input:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25); }
        .form-group input.is-invalid { border-color: #dc3545; }
        .invalid-feedback { display: none; width: 100%; margin-top: .25rem; font-size: .875em; color: #dc3545; }
        .is-invalid + .invalid-feedback { display: block; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid var(--border-color); padding: 12px; text-align: left; }
        th { background-color: var(--light-gray); font-weight: 600; }
    </style>

    <div class="header"><h1>Kelola Mata Kuliah</h1></div>

    <div class="card">
        <div id="notification"></div>
        <button id="addCourseBtn" class="btn btn-add">Tambah Course Baru</button>
        <br><br>
        <table>
            <thead>
                <tr>
                    <th>Kode MK</th>
                    <th>Nama Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="course-table-body">
                <?php if (!empty($courses)) : ?>
                    <?php foreach ($courses as $course) : ?>
                    <tr data-id="<?= $course['id'] ?>">
                        <td><?= esc($course['kode_mk']); ?></td>
                        <td><?= esc($course['nama_mk']); ?></td>
                        <td><?= esc($course['sks']); ?></td>
                        <td class="action-btn">
                            <a href="#" class="btn-update" data-id="<?= $course['id'] ?>">Edit</a>
                            <a href="#" class="btn-delete" data-id="<?= $course['id'] ?>">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr id="no-data-row"><td colspan="4" style="text-align: center;">Belum ada data mata kuliah.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div id="courseModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2 id="modal-title">Tambah Course Baru</h2>
            <form id="courseForm" method="post">
                <input type="hidden" name="<?= csrf_token() ?>" class="csrf" value="<?= csrf_hash() ?>" />
                <input type="hidden" name="_method" id="form-method" value="POST">
                <div class="form-group"><label for="kode_mk">Kode Mata Kuliah</label><input type="text" name="kode_mk"><div class="invalid-feedback"></div></div>
                <div class="form-group"><label for="nama_mk">Nama Mata Kuliah</label><input type="text" name="nama_mk"><div class="invalid-feedback"></div></div>
                <div class="form-group"><label for="sks">SKS</label><input type="number" name="sks" min="1"><div class="invalid-feedback"></div></div>
                <div class="form-group"><label for="deskripsi">Deskripsi</label><textarea name="deskripsi" rows="4"></textarea></div>
                <button type="submit" class="btn">Simpan</button>
            </form>
        </div>
    </div>
    
    <div id="deleteConfirmModal" class="modal">
        <div class="modal-content" style="max-width: 400px; text-align: center;">
            <span class="close-btn">&times;</span>
            <h2>Konfirmasi Hapus</h2>
            <p id="deleteMessage" style="margin: 20px 0;"></p>
            <div>
                <button id="cancelDeleteBtn" class="btn" style="background-color: #6c757d;">Batal</button>
                <button id="confirmDeleteBtn" class="btn btn-delete">Ya, Hapus</button>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Definisi Elemen
    const addModal = document.getElementById('courseModal');
    const deleteModal = document.getElementById('deleteConfirmModal');
    const addBtn = document.getElementById('addCourseBtn');
    const addSpan = document.querySelector('#courseModal .close-btn');
    const deleteSpan = document.querySelector('#deleteConfirmModal .close-btn');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const form = document.getElementById('courseForm');
    const tableBody = document.getElementById('course-table-body');
    const notification = document.getElementById('notification');
    const modalTitle = document.getElementById('modal-title');
    const formMethod = document.getElementById('form-method');

    // Fungsi untuk memperbarui semua token CSRF di halaman
    function updateCsrfToken(newHash) {
        document.querySelectorAll('.csrf').forEach(input => {
            input.value = newHash;
        });
    }

    // Fungsi Notifikasi
    function showNotification(message, type) {
        notification.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
        setTimeout(() => { notification.innerHTML = ''; }, 4000);
    }

    // Buka Modal untuk Tambah Data
    addBtn.onclick = function() {
        form.reset();
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        form.action = '<?= site_url("admin/courses") ?>';
        formMethod.value = 'POST';
        modalTitle.textContent = 'Tambah Course Baru';
        form.querySelector('button[type=submit]').textContent = 'Simpan';
        form.querySelector('button[type=submit]').className = 'btn btn-add';
        addModal.style.display = 'block';
    }

    // Tutup Modal
    addSpan.onclick = () => addModal.style.display = 'none';
    deleteSpan.onclick = () => deleteModal.style.display = 'none';
    cancelDeleteBtn.onclick = () => deleteModal.style.display = 'none';
    window.onclick = (event) => { 
        if (event.target == addModal || event.target == deleteModal) {
            addModal.style.display = 'none';
            deleteModal.style.display = 'none';
        }
    };

    // Event listener pada tabel (untuk Edit & Delete)
    tableBody.addEventListener('click', function(event) {
        const target = event.target;
        if (!target.classList.contains('btn-update') && !target.classList.contains('btn-delete')) return;
        
        event.preventDefault();
        const courseId = target.dataset.id;
        const row = target.closest('tr');

        // Logika Tombol EDIT
        if (target.classList.contains('btn-update')) {
            fetch(`<?= site_url('admin/courses/') ?>${courseId}/edit`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    form.reset();
                    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

                    form.querySelector('[name="kode_mk"]').value = data.course.kode_mk;
                    form.querySelector('[name="nama_mk"]').value = data.course.nama_mk;
                    form.querySelector('[name="sks"]').value = data.course.sks;
                    form.querySelector('[name="deskripsi"]').value = data.course.deskripsi;
                    
                    form.action = `<?= site_url('admin/courses/') ?>${courseId}`;
                    formMethod.value = 'PUT';
                    modalTitle.textContent = 'Edit Mata Kuliah';
                    form.querySelector('button[type=submit]').textContent = 'Update Course';
                    form.querySelector('button[type=submit]').className = 'btn btn-update';
                    addModal.style.display = 'block';
                }
            });
        }

        // Logika Tombol DELETE
        if (target.classList.contains('btn-delete')) {
            const courseName = row.querySelector('td:nth-child(2)').textContent;
            document.getElementById('deleteMessage').textContent = `Anda yakin ingin menghapus course: ${courseName}?`;
            confirmDeleteBtn.dataset.id = courseId;
            deleteModal.style.display = 'block';
        }
    });

    // Event listener untuk konfirmasi DELETE
    confirmDeleteBtn.addEventListener('click', function() {
        const courseId = this.dataset.id;
        const csrfToken = document.querySelector('.csrf').value;
        fetch(`<?= site_url('admin/courses/') ?>${courseId}`, {
            method: 'POST',
            body: new URLSearchParams({ '_method': 'DELETE', '<?= csrf_token() ?>': csrfToken }),
            headers: {"X-Requested-With": "XMLHttpRequest"}
        })
        .then(res => res.json()).then(data => {
            if(data.csrf) updateCsrfToken(data.csrf);
            deleteModal.style.display = 'none';
            if(data.success) {
                document.querySelector(`tr[data-id="${courseId}"]`).remove();
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message || 'Gagal menghapus.', 'error');
            }
        });
    });

    // Event listener untuk submit form (Create & Update)
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(form);
        const url = form.getAttribute('action');
        
        fetch(url, { method: 'POST', body: formData, headers: {"X-Requested-With": "XMLHttpRequest"} })
        .then(res => res.json())
        .then(data => {
            if(data.csrf) updateCsrfToken(data.csrf);
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

            if (data.success) {
                addModal.style.display = 'none';
                const course = data.course;
                
                if (formData.get('_method') === 'PUT') {
                    const row = tableBody.querySelector(`tr[data-id="${course.id}"]`);
                    row.querySelector('td:nth-child(1)').textContent = course.kode_mk;
                    row.querySelector('td:nth-child(2)').textContent = course.nama_mk;
                    row.querySelector('td:nth-child(3)').textContent = course.sks;
                    showNotification('Course berhasil diupdate.', 'success');
                } else {
                    const newRow = `<tr data-id="${course.id}"><td>${course.kode_mk}</td><td>${course.nama_mk}</td><td>${course.sks}</td><td class="action-btn"><a href="#" class="btn-update" data-id="${course.id}">Edit</a> <a href="#" class="btn-delete" data-id="${course.id}">Hapus</a></td></tr>`;
                    tableBody.insertAdjacentHTML('beforeend', newRow);
                    const noDataRow = document.getElementById('no-data-row');
                    if (noDataRow) noDataRow.remove();
                    showNotification('Course berhasil ditambahkan.', 'success');
                }
            } else {
                for (const field in data.errors) {
                    const input = form.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        input.nextElementSibling.textContent = data.errors[field];
                    }
                }
            }
        });
    });
});
</script>

<?= $this->endSection() ?>