<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Student</title>
</head>
<body>
    <h2>Add Student</h2>
    <a href="/student">Back to List</a>
    <br><br>
    <form action="/student/store" method="post">
        <?= csrf_field() ?> <label>NIM</label><br>
        <input type="text" name="nim" required><br><br>
        
        <label>Nama Lengkap</label><br>
        <input type="text" name="nama_lengkap" required><br><br>

        <button type="submit">Add Student</button>
    </form>
</body>
</html>