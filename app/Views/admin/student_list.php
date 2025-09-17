<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student List</title>
    </head>
<body>
    <h2>Student List</h2>
    <a href="/student/create">Add New Student</a>
    <br><br>
    <table border="1">
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Entry Year</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($students as $student): ?>
            <tr>
                <td><?= htmlspecialchars($student['nim']) ?></td>
                <td><?= htmlspecialchars($student['nama_lengkap']) ?></td>
                <td><?= htmlspecialchars($student['email']) ?></td>
                <td><?= htmlspecialchars($student['entry_year']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>