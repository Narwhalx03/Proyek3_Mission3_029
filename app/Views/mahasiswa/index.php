<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>

    <style>
        /* Menggunakan variabel dari template utama dan beberapa tambahan */
        .action-btn a, .action-btn button, .btn { display: inline-block; padding: 8px 12px; color: white; text-decoration: none; border-radius: 6px; font-size: 0.9em; margin-right: 5px; border: none; cursor: pointer; font-family: 'Poppins', sans-serif; transition: opacity 0.2s; font-weight: 500; }
        .action-btn a:hover, .action-btn button:hover, .btn:hover { opacity: 0.8; }
        .btn-detail { background-color: #0d6efd; }
        .btn-update { background-color: #ffc107; color: #000; }
        .btn-delete { background-color: #dc3545; }
        .btn-add { background-color: #198754; }
        .btn-reset { background-color: #fd7e14; }

        .alert { padding: 1rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .375rem; }
        .alert-success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
        .alert-error { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }
        
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(5px); }
        .modal-content { background-color: #fefefe; margin: 10% auto; padding: 30px; border: 1px solid #ddd; width: 90%; max-width: 500px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); position: relative; }
        .close-btn { color: #aaa; float: right; font-size: 28px; font-weight: bold; position: absolute; top: 10px; right: 20px;}
        .close-btn:hover, .close-btn:focus { color: black; text-decoration: none; cursor: pointer; }
        
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: .5rem; font-weight: 500; color: #495057; }
        .form-group input { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ced4da; font-size: 1rem; font-family: 'Poppins', sans-serif; }
        .form-group input:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25); }
        .form-group input.is-invalid { border-color: #dc3545; }
        .invalid-feedback { display: none; width: 100%; margin-top: .25rem; font-size: .875em; color: #dc3545; }
        .is-invalid + .invalid-feedback { display: block; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid var(--border-color); padding: 12px; text-align: left; }
        th { background-color: var(--light-gray); font-weight: 600; }
    </style>

    <div class="header">
        <h1>Student List</h1>
    </div>

    <div class="card">
        <div id="notification"></div>
        <button id="addStudentBtn" class="btn btn-add">Add Student</button>
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
            <tbody id="student-table-body">
                <?php if (!empty($students)) : ?>
                    <?php foreach ($students as $student) : ?>
                    <tr data-id="<?= $student['id'] ?>">
                        <td><?= esc($student['nim']); ?></td>
                        <td><?= esc($student['nama_lengkap']); ?></td>
                        <td><?= esc($student['tanggal_lahir']); ?></td>
                        <td><?= esc($student['entry_year']); ?></td>
                        <td class="action-btn">
                            <a href="<?= site_url('mahasiswa/' . $student['id']) ?>" class="btn-detail">Detail</a>
                            <a href="#" class="btn-update" data-id="<?= $student['id'] ?>">Update</a>
                            <a href="#" class="btn-delete" data-id="<?= $student['id'] ?>">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr id="no-data-row"><td colspan="5" style="text-align: center;">Belum ada data mahasiswa.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Add Student</h2>
            <form id="addStudentForm" action="<?= site_url('mahasiswa') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group"><label for="nim">NIM</label><input type="text" name="nim"><div class="invalid-feedback"></div></div>
                <div class="form-group"><label for="nama_lengkap">Nama Lengkap</label><input type="text" name="nama_lengkap"><div class="invalid-feedback"></div></div>
                <div class="form-group"><label for="tanggal_lahir">Tanggal Lahir</label><input type="date" name="tanggal_lahir"><div class="invalid-feedback"></div></div>
                <div class="form-group"><label for="entry_year">Entry Year</label><input type="number" name="entry_year" min="1990" max="2099" step="1"><div class="invalid-feedback"></div></div>
                <button type="submit" class="btn">Save Student</button>
            </form>
        </div>
    </div>

    <div id="editStudentModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Edit Student</h2>
            <form id="editStudentForm" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group"><label for="nim">NIM</label><input type="text" name="nim" id="edit_nim"><div class="invalid-feedback"></div></div>
                <div class="form-group"><label for="nama_lengkap">Nama Lengkap</label><input type="text" name="nama_lengkap" id="edit_nama_lengkap"><div class="invalid-feedback"></div></div>
                <div class="form-group"><label for="tanggal_lahir">Tanggal Lahir</label><input type="date" name="tanggal_lahir" id="edit_tanggal_lahir"><div class="invalid-feedback"></div></div>
                <div class="form-group"><label for="entry_year">Entry Year</label><input type="number" name="entry_year" min="1990" max="2099" step="1" id="edit_entry_year"><div class="invalid-feedback"></div></div>
                <button type="submit" class="btn btn-update">Update Student</button>
            </form>
            <hr style="margin: 20px 0;">
            <div>
                <h4>Reset Password</h4>
                <p style="font-size: 0.9em; color: #6c757d;">Klik link di bawah untuk membuat password acak baru untuk mahasiswa ini.</p>
                <a href="#" id="resetPasswordLink" class="btn btn-reset" onclick="return confirm('Anda yakin ingin mereset password mahasiswa ini? Password lama akan hilang selamanya.');">Reset Password</a>
            </div>
        </div>
    </div>

    <div id="deleteConfirmModal" class="modal">
        <div class="modal-content" style="max-width: 400px; text-align: center;">
            <span class="close-btn">&times;</span>
            <h2>Konfirmasi Hapus</h2>
            <p id="deleteMessage" style="margin: 20px 0;">Anda yakin ingin menghapus data ini?</p>
            <div>
                <button id="cancelDeleteBtn" class="btn" style="background-color: #6c757d;">Batal</button>
                <button id="confirmDeleteBtn" class="btn btn-delete">Ya, Hapus</button>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Definisi semua elemen
    const addModal = document.getElementById('addStudentModal');
    const editModal = document.getElementById('editStudentModal');
    const deleteModal = document.getElementById('deleteConfirmModal');
    const addBtn = document.getElementById('addStudentBtn');
    const addSpan = document.querySelector('#addStudentModal .close-btn');
    const editSpan = document.querySelector('#editStudentModal .close-btn');
    const deleteSpan = document.querySelector('#deleteConfirmModal .close-btn');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const addForm = document.getElementById('addStudentForm');
    const editForm = document.getElementById('editStudentForm');
    const tableBody = document.getElementById('student-table-body');
    const notification = document.getElementById('notification');
    const resetPasswordLink = document.getElementById('resetPasswordLink');

    // Fungsi notifikasi
    function showNotification(message, type) {
        notification.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
        setTimeout(() => { notification.innerHTML = ''; }, 5000);
    }

    // Logika Buka/Tutup Modal
    addBtn.onclick = () => addModal.style.display = 'block';
    addSpan.onclick = () => addModal.style.display = 'none';
    editSpan.onclick = () => editModal.style.display = 'none';
    deleteSpan.onclick = () => deleteModal.style.display = 'none';
    cancelDeleteBtn.onclick = () => deleteModal.style.display = 'none';
    window.onclick = (event) => {
        if (event.target == addModal || event.target == editModal || event.target == deleteModal) {
            addModal.style.display = 'none';
            editModal.style.display = 'none';
            deleteModal.style.display = 'none';
        }
    };

    // Event listener pada tabel (Update & Delete)
    tableBody.addEventListener('click', function(event) {
        const target = event.target;
        if (target.classList.contains('btn-update')) {
            event.preventDefault();
            const studentId = target.dataset.id;
            fetch(`<?= site_url('mahasiswa/') ?>${studentId}/edit`).then(res => res.json()).then(data => {
                if (data.success) {
                    editForm.querySelector('[name="nim"]').value = data.student.nim;
                    editForm.querySelector('[name="nama_lengkap"]').value = data.student.nama_lengkap;
                    editForm.querySelector('[name="tanggal_lahir"]').value = data.student.tanggal_lahir;
                    editForm.querySelector('[name="entry_year"]').value = data.student.entry_year;
                    editForm.action = `<?= site_url('mahasiswa/') ?>${studentId}`;
                    resetPasswordLink.href = `<?= site_url('mahasiswa/reset_password/') ?>${studentId}`;
                    editModal.style.display = 'block';
                } else {
                    showNotification('Error: ' + data.message, 'error');
                }
            });
        }
        if (target.classList.contains('btn-delete')) {
            event.preventDefault();
            const studentId = target.dataset.id;
            const studentName = target.closest('tr').querySelector('td:nth-child(2)').textContent;
            document.getElementById('deleteMessage').textContent = `Apakah Anda yakin ingin menghapus mahasiswa: ${studentName}?`;
            confirmDeleteBtn.dataset.id = studentId;
            deleteModal.style.display = 'block';
        }
    });

    // Event listener untuk konfirmasi DELETE
    confirmDeleteBtn.addEventListener('click', function() {
        const studentId = this.dataset.id;
        fetch(`<?= site_url('mahasiswa/') ?>${studentId}`, {
            method: 'DELETE',
            headers: {"X-Requested-With": "XMLHttpRequest"}
        }).then(response => response.json()).then(data => {
            deleteModal.style.display = 'none';
            if (data.success) {
                document.querySelector(`tr[data-id="${studentId}"]`).remove();
                showNotification(data.message, 'success');
            } else {
                showNotification('Error: ' + data.message, 'error');
            }
        });
    });

    // Event listener untuk submit form ADD
    addForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(addForm);
        fetch(addForm.action, { method: 'POST', body: formData, headers: {"X-Requested-With": "XMLHttpRequest"} })
        .then(response => response.json()).then(data => {
            document.querySelectorAll('#addStudentForm .is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('#addStudentForm .invalid-feedback').forEach(el => el.textContent = '');
            if (data.success) {
                const newRow = `<tr data-id="${data.student.id}"><td>${data.student.nim}</td><td>${data.student.nama_lengkap}</td><td>${data.student.tanggal_lahir}</td><td>${data.student.entry_year}</td><td class="action-btn"><a href="<?= site_url('mahasiswa/') ?>${data.student.id}" class="btn-detail">Detail</a> <a href="#" class="btn-update" data-id="${data.student.id}">Update</a> <a href="#" class="btn-delete" data-id="${data.student.id}">Delete</a></td></tr>`;
                tableBody.insertAdjacentHTML('beforeend', newRow);
                const noDataRow = document.getElementById('no-data-row');
                if (noDataRow) noDataRow.remove();
                showNotification(data.message || 'Mahasiswa berhasil ditambahkan!', 'success');
                addForm.reset();
                addModal.style.display = 'none';
            } else {
                for (const field in data.errors) {
                    const input = document.querySelector(`#addStudentForm [name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        input.nextElementSibling.textContent = data.errors[field];
                    }
                }
            }
        });
    });
    
    // Event listener untuk submit form EDIT
    editForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(editForm);
        const url = editForm.getAttribute('action');
        fetch(url, { method: 'POST', body: formData, headers: {"X-Requested-With": "XMLHttpRequest"} })
        .then(res => res.json()).then(data => {
            document.querySelectorAll('#editStudentForm .is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('#editStudentForm .invalid-feedback').forEach(el => el.textContent = '');
            if (data.success) {
                editModal.style.display = 'none';
                const studentId = url.split('/').pop();
                const row = document.querySelector(`tr[data-id="${studentId}"]`);
                if(row){
                    row.querySelector('td:nth-child(1)').textContent = formData.get('nim');
                    row.querySelector('td:nth-child(2)').textContent = formData.get('nama_lengkap');
                    row.querySelector('td:nth-child(3)').textContent = formData.get('tanggal_lahir');
                    row.querySelector('td:nth-child(4)').textContent = formData.get('entry_year');
                }
                showNotification('Data mahasiswa berhasil diupdate.', 'success');
            } else {
                for (const field in data.errors) {
                    const input = document.querySelector(`#editStudentForm [name="${field}"]`);
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