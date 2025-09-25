<?php
defined('BASEPATH') or exit('No direct script access allowed');
$role = $this->session->userdata('role');
?>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header mb-3">
        <h6 class="sidebar-title">
            <i class="fas fa-th-list me-2"></i>Menu Utama
        </h6>
    </div>

    <ul class="nav flex-column">
        <!-- PERKARA MENU -->
        <li class="nav-item mb-2">
            <a class="nav-link d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse" href="#submenuPerkara" role="button"
                aria-expanded="false" aria-controls="submenuPerkara">
                <span><i class="fas fa-folder me-2"></i>Perkara</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse" id="submenuPerkara">
                <ul class="nav flex-column ms-3 mt-2">
                    <?php if ($role == 'user'): ?>
                        <li><a class="nav-link" href="<?= site_url('user/dashboard_user'); ?>">
                                <i class="fas fa-tasks me-2"></i>Kelola Data
                            </a></li>
                        <li><a class="nav-link" href="<?= site_url('perkara/tambah'); ?>">
                                <i class="fas fa-plus me-2"></i>Tambah
                            </a></li>
                        <li><a class="nav-link" href="<?= site_url('laporan'); ?>">
                                <i class="fas fa-file-alt me-2"></i>Laporan
                            </a></li>
                    <?php else: ?>
                        <li><a class="nav-link" href="<?= site_url('admin/dashboard_admin'); ?>">
                                <i class="fas fa-eye me-2"></i>Lihat Data
                            </a></li>
                        <li><a class="nav-link" href="<?= site_url('laporan'); ?>">
                                <i class="fas fa-file-alt me-2"></i>Laporan
                            </a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </li>

        <!-- MEDIASI MENU -->
        <li class="nav-item mb-2">
            <a class="nav-link d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse" href="#submenuMediasi" role="button"
                aria-expanded="false" aria-controls="submenuMediasi">
                <span><i class="fas fa-balance-scale me-2"></i>Mediasi</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse" id="submenuMediasi">
                <ul class="nav flex-column ms-3 mt-2">
                    <?php if ($role == 'user'): ?>
                        <li><a class="nav-link" href="<?= site_url('user/dashboard_user'); ?>">
                                <i class="fas fa-tasks me-2"></i>Kelola Data
                            </a></li>
                        <li><a class="nav-link" href="<?= site_url('perkara/tambah'); ?>">
                                <i class="fas fa-plus me-2"></i>Tambah
                            </a></li>
                        <li><a class="nav-link" href="<?= site_url('laporan'); ?>">
                                <i class="fas fa-file-alt me-2"></i>Laporan
                            </a></li>
                    <?php else: ?>
                        <li><a class="nav-link" href="<?= site_url('admin/dashboard_admin'); ?>">
                                <i class="fas fa-eye me-2"></i>Lihat Data
                            </a></li>
                        <li><a class="nav-link" href="<?= site_url('laporan'); ?>">
                                <i class="fas fa-file-alt me-2"></i>Laporan
                            </a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </li>

        <!-- USER MENU (ADMIN ONLY) -->
        <?php if ($role == 'admin'): ?>
            <li class="nav-item mb-2">
                <a class="nav-link d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" href="#submenuUser" role="button"
                    aria-expanded="false" aria-controls="submenuUser">
                    <span><i class="fas fa-users me-2"></i>User</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="collapse" id="submenuUser">
                    <ul class="nav flex-column ms-3 mt-2">
                        <li><a class="nav-link" href="<?= site_url('kelola_user'); ?>">
                                <i class="fas fa-user-cog me-2"></i>Kelola User
                            </a></li>
                    </ul>
                </div>
            </li>
        <?php endif; ?>
    </ul>
</div>

<style>
    .sidebar {
        background: #ffffff;
        height: calc(100vh - 60px);
        position: fixed;
        top: 60px;
        left: 0;
        width: 250px;
        padding: 1.5rem 1rem;
        box-shadow: 1px 0 10px rgba(0, 0, 0, 0.05);
        overflow-y: auto;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .sidebar-header {
        padding-bottom: 1rem;
        border-bottom: 1px solid #e0e0e0;
        margin-bottom: 1rem;
    }

    .sidebar-title {
        color: #2c3e50;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin: 0;
    }

    .sidebar .nav-item {
        margin-bottom: 0.5rem;
    }

    .sidebar .nav-link {
        color: #4a5568;
        font-weight: 500;
        font-size: 0.875rem;
        padding: 0.675rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
    }

    .sidebar .nav-link i {
        font-size: 1rem;
        width: 1.25rem;
        text-align: center;
        color: #718096;
        transition: color 0.2s ease;
    }

    .sidebar .nav-link:hover {
        background: #f7fafc;
        color: #006400;
        transform: translateX(4px);
    }

    .sidebar .nav-link:hover i {
        color: #006400;
    }

    .sidebar .nav-link.active {
        background: linear-gradient(135deg, #006400, #004d00);
        color: #ffffff;
    }

    .sidebar .nav-link.active i {
        color: #ffffff;
    }

    .sidebar .collapse {
        padding: 0.5rem 0;
    }

    .sidebar .collapse .nav-link {
        padding-left: 2.75rem;
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
    }

    .sidebar .fa-chevron-down {
        transition: transform 0.2s ease;
        font-size: 0.75rem;
        opacity: 0.75;
    }

    .sidebar .nav-link[aria-expanded="true"] .fa-chevron-down {
        transform: rotate(180deg);
    }

    .sidebar .nav-link[aria-expanded="true"] {
        background: #f7fafc;
        color: #006400;
        font-weight: 600;
    }

    .sidebar .nav-link[aria-expanded="true"] i {
        color: #006400;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            transform: translateX(-100%);
            background: #ffffff;
            padding: 1rem;
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .sidebar-header {
            padding-bottom: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .sidebar .nav-link {
            padding: 0.5rem 0.75rem;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .sidebar {
            width: 220px;
        }
    }
</style>