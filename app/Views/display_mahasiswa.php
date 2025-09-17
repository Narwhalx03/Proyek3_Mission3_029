<!DOCTYPE html>
<html>
    <head>
        <title> Data Mahasiswa</title>
    </head>
    <body>
        <h1> Daftar Mahasiwa</h1>
        <table border="1" cellpadding="5">
            <tr>
                <th>Nim</th>
                <th>Nama</th>
                <th>Umur</th>
            </tr>
            <?php if (!empty($mahasiswa)) :?>
                <?php foreach ($mahasiswa as $m): ?>
                    <tr>
                        <td><?= esc($m['nim']) ?></td>
                        <td><?= esc($m['nama']) ?></td>
                        <td><?= esc($m['umur']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php else :?>
                    <tr>
                        <td colspan ="3"> Belum ada data Mahasiswa </td>
                </tr>
                <?php endif; ?>
        </table>
    </body>
</html>