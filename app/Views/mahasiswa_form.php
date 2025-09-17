<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mahasiswa Baru</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-bottom: 15px; border-radius: 4px; border: 1px solid #ccc; box-sizing: border-box; }
        button { padding: 10px 15px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { text-decoration: none; color: #555; }
    </style>
</head>
<body>

<div class="container">
    <h1>Form Tambah Mahasiswa</h1>

    <form action="<?= site_url('mahasiswa/create') ?>" method="post">
        <?= csrf_field() ?> <label for="nim">NIM:</label>
        <input type="text" id="nim" name="nim" required>

        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required>

        <label for="umur">Umur:</label>
        <input type="number" id="umur" name="umur" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Simpan Mahasiswa</button>
    </form>
    <hr>
    <a href="<?= site_url('login') ?>">Kembali halaman login</a>
</div>

</body>
</html>