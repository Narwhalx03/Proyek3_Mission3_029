<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Dashboard Mahasiswa'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #198754; /* Warna hijau untuk mahasiswa */
            --light-gray: #f8f9fa;
            --border-color: #dee2e6;
            --text-dark: #343a40;
            --text-light: #ffffff;
            --shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        }
        body { font-family: 'Poppins', sans-serif; margin: 0; background-color: var(--light-gray); color: var(--text-dark); }
        .header { background: var(--primary-color); color: var(--text-light); padding: 1rem 2rem; box-shadow: var(--shadow); }
        .header h2 { margin: 0; font-weight: 600; }
        .menu { background: var(--text-light); padding: 0.75rem 2rem; border-bottom: 1px solid var(--border-color); }
        .menu a { margin-right: 20px; text-decoration: none; color: var(--primary-color); font-weight: 500; }
        .menu a:hover { color: var(--text-dark); }
        .content { padding: 2rem; }
        .card { background-color: var(--text-light); padding: 25px; border-radius: 8px; border: 1px solid var(--border-color); box-shadow: var(--shadow); margin-bottom: 2rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid var(--border-color); padding: 12px; text-align: left; }
        th { background-color: var(--light-gray); font-weight: 600; }
        .btn-enroll { display: inline-block; padding: 5px 10px; background-color: var(--primary-color); color: white; text-decoration: none; border-radius: 6px; font-size: 0.9rem;}
        .footer { background: var(--text-dark); color: var(--text-light); text-align: center; padding: 1rem; margin-top: 2rem; font-size: 0.9rem; }
        .footer p { margin: 0; }
    </style>
</head>
<body>

    <header class="header">
        <h2>Portal Mahasiswa</h2>
    </header>

    <nav class="menu">
        <a href="<?= site_url('/student/dashboard') ?>">Home</a>
        <a href="<?= site_url('/logout') ?>">Logout</a>
    </nav>

    <main class="content">
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="footer">
        <p>&copy; <?= date('Y') ?> Akademik System</p>
    </footer>

</body>
</html>