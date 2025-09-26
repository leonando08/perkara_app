<?php
defined('BASEPATH') or exit('No direct script access allowed');
$role = $this->session->userdata('role');
?>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
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

<!-- Overlay untuk mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<style>
    /* Sidebar Styles */
    .sidebar {
        background: #ffffff;
        height: calc(100vh - 60px);
        position: fixed;
        top: 60px;
        left: 0;
        width: 260px;
        /* Standarisasi lebar sidebar */
        padding: 1.5rem 1rem;
        box-shadow: 2px 0 15px rgba(0, 0, 0, 0.08);
        overflow-y: auto;
        overflow-x: hidden;
        /* Cegah horizontal overflow */
        transition: all 0.3s ease;
        z-index: 1040;
        border-right: 1px solid #e5e7eb;
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
        text-decoration: none;
        border: none;
        background: none;
    }

    .sidebar .nav-link i {
        font-size: 1rem;
        width: 1.25rem;
        text-align: center;
        color: #718096;
        transition: color 0.2s ease;
        flex-shrink: 0;
    }

    .sidebar .nav-link:hover {
        background: #f7fafc;
        color: #006400;
        transform: translateX(4px);
        text-decoration: none;
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
        flex-shrink: 0;
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

    /* Sidebar Overlay */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 60px;
        left: 0;
        width: 100%;
        height: calc(100vh - 60px);
        background: rgba(0, 0, 0, 0.5);
        z-index: 1035;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    /* Content adjustment */
    body {
        margin-left: 260px;
        /* Sesuaikan dengan lebar sidebar */
        transition: margin-left 0.3s ease;
    }

    .main-content {
        margin-left: 0;
        /* Reset karena body sudah memiliki margin */
        width: 100%;
        min-height: calc(100vh - 60px);
        background: #f8f9fa;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        body {
            margin-left: 0;
            /* Reset margin di mobile */
        }

        .sidebar {
            width: 280px;
            transform: translateX(-100%);
            background: #ffffff;
            padding: 1rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        .sidebar-header {
            padding-bottom: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .sidebar .nav-link {
            padding: 0.6rem 0.75rem;
        }

        .sidebar .collapse .nav-link {
            padding-left: 2.5rem;
        }
    }

    /* Tablet */
    @media (min-width: 769px) and (max-width: 1024px) {
        .sidebar {
            width: 240px;
        }

        body {
            margin-left: 240px;
        }
    }

    /* Large screens */
    @media (min-width: 1200px) {
        .sidebar {
            width: 280px;
        }

        body {
            margin-left: 280px;
        }
    }

    /* Custom scrollbar untuk sidebar */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    /* Hover effects */
    .sidebar .nav-link span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Focus states untuk accessibility */
    .sidebar .nav-link:focus {
        outline: 2px solid #006400;
        outline-offset: 2px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle sidebar on mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                sidebarOverlay.classList.toggle('show');
                document.body.classList.toggle('sidebar-open');
            });
        }

        // Close sidebar when clicking overlay
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
                document.body.classList.remove('sidebar-open');
            });
        }

        // Close sidebar on mobile when clicking menu item
        const navLinks = document.querySelectorAll('.sidebar .nav-link:not([data-bs-toggle])');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                }
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
                document.body.classList.remove('sidebar-open');
            }
        });

        // Set active menu based on current URL
        const currentPath = window.location.pathname;
        const menuLinks = document.querySelectorAll('.sidebar .nav-link[href]');

        menuLinks.forEach(link => {
            if (link.getAttribute('href') && currentPath.includes(link.getAttribute('href').split('/').pop())) {
                link.classList.add('active');

                // Expand parent collapse if this is a submenu item
                const parentCollapse = link.closest('.collapse');
                if (parentCollapse) {
                    parentCollapse.classList.add('show');
                    const toggleButton = document.querySelector(`[href="#${parentCollapse.id}"]`);
                    if (toggleButton) {
                        toggleButton.setAttribute('aria-expanded', 'true');
                    }
                }
            }
        });
    });
</script>