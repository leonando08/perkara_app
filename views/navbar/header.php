<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: ../public/index.php");
    exit();
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Perkara</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5fff5;
            padding-top: 70px;
            /* jarak navbar */
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #00b300, #006400);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.2rem;
            letter-spacing: 0.5px;
        }

        .navbar-text {
            font-weight: 600;
        }

        .btn-outline-light {
            border-radius: 8px;
            font-weight: 600;
            transition: 0.3s ease-in-out;
        }

        .btn-outline-light:hover {
            background: #fff;
            color: #006400;
            transform: scale(1.05);
        }

        /* Sidebar */
        .sidebar {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-right: 2px solid rgba(0, 128, 0, 0.2);
            height: 100vh;
            position: fixed;
            top: 70px;
            /* mulai di bawah navbar */
            left: 0;
            width: 220px;
            padding: 25px 20px;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.08);
            overflow-y: auto;
            transition: all 0.3s ease-in-out;
            z-index: 999;
        }

        .sidebar h6 {
            font-weight: 700;
            color: #004d00;
            font-size: 0.95rem;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .sidebar .nav-link {
            color: #006400;
            font-weight: 500;
            border-radius: 12px;
            padding: 10px 14px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
        }

        .sidebar .nav-link:hover {
            background: linear-gradient(135deg, #00b300, #009933);
            color: #fff;
            transform: translateX(4px);
            box-shadow: 0 4px 8px rgba(0, 128, 0, 0.2);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, #00b300, #006400);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0, 128, 0, 0.3);
        }

        /* Main content */
        .content {
            margin-left: 220px;
            /* geser biar tidak ketimpa sidebar */
            padding: 2rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
                <img src="https://sepeda.pt-banjarmasin.go.id/assets/logo.ico" alt="Logo"
                    class="me-2" style="height: 35px; width: auto;">
                Sistem Informasi Perkara
            </a>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">
                    <?= $user['username']; ?> (<?= $user['role']; ?>)
                </span>
                <a href="../login/logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <h6 class="mb-3">📌 Menu</h6>
        <ul class="nav flex-column">
            <!-- PERKARA MENU -->
            <li class="nav-item mb-2">
                <a class="nav-link d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#submenuPerkara" role="button"
                    aria-expanded="false" aria-controls="submenuPerkara">
                    📂 Perkara
                    <span class="ms-auto">▼</span>
                </a>
                <div class="collapse" id="submenuPerkara">
                    <ul class="nav flex-column ms-3 mt-2">
                        <?php if ($user['role'] == 'user'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../user/dashboard_user1.php">📋 Kelola Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../user/tambah_perkara.php">➕ Tambah</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../laporan/laporan.php">📄 Laporan</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../admin/dashboard_admin.php">👁 Lihat Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../laporan/laporan.php">📄 Laporan</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>

            <!-- MEDIASI MENU -->
            <li class="nav-item mb-2">
                <a class="nav-link d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#submenuMediasi" role="button"
                    aria-expanded="false" aria-controls="submenuMediasi">
                    📂 Mediasi
                    <span class="ms-auto">▼</span>
                </a>
                <div class="collapse" id="submenuMediasi">
                    <ul class="nav flex-column ms-3 mt-2">
                        <?php if ($user['role'] == 'user'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../views/dashboard_user1.php">📋 Kelola Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="tambah_perkara.php">➕ Tambah</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="laporan.php">📄 Laporan</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="dashboard_admin.php">👁 Lihat Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="laporan.php">📄 Laporan</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>

            <!-- USER MENU (ADMIN ONLY) -->
            <?php if ($user['role'] != 'user'): ?>
                <li class="nav-item mb-2">
                    <a class="nav-link d-flex justify-content-between align-items-center"
                        data-bs-toggle="collapse" href="#submenuUser" role="button"
                        aria-expanded="false" aria-controls="submenuUser">
                        👥 User
                        <span class="ms-auto">▼</span>
                    </a>
                    <div class="collapse" id="submenuUser">
                        <ul class="nav flex-column ms-3 mt-2">
                            <li class="nav-item">
                                <a class="nav-link" href="kelola_user.php">⚙ Kelola User</a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">