<!-- Pastikan Bootstrap JS sudah di-include sebelum </body> -->
<!-- Contoh: <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
<?php
defined('BASEPATH') or exit('No direct script access allowed');
$role = $this->session->userdata('role');
$current_url = current_url();
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
            <a class="nav-link d-flex justify-content-between align-items-center menu-toggle"
                data-bs-toggle="collapse" data-bs-target="#submenuPerkara" href="#submenuPerkara" role="button"
                aria-expanded="false" aria-controls="submenuPerkara">
                <span><i class="fas fa-folder me-2"></i>Perkara</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse" id="submenuPerkara">
                <ul class="nav flex-column ms-3 mt-2">
                    <?php if ($role == 'user'): ?>
                        <li><a class="nav-link submenu-link" href="<?= site_url('perkara/dashboard'); ?>" data-menu="perkara">
                                <i class="fas fa-tasks me-2"></i>Kelola Data Perkara
                            </a></li>
                        <li><a class="nav-link submenu-link" href="<?= site_url('perkara/tambah'); ?>" data-menu="perkara">
                                <i class="fas fa-plus me-2"></i>Tambah Perkara
                            </a></li>
                        <li><a class="nav-link submenu-link" href="<?= site_url('laporan'); ?>" data-menu="perkara">
                                <i class="fas fa-file-alt me-2"></i>Laporan Perkara
                            </a></li>
                    <?php else: ?>
                        <li><a class="nav-link submenu-link" href="<?= site_url('perkara/dashboard'); ?>" data-menu="perkara">
                                <i class="fas fa-eye me-2"></i>Lihat Data Perkara
                            </a></li>
                        <li><a class="nav-link submenu-link" href="<?= site_url('laporan'); ?>" data-menu="perkara">
                                <i class="fas fa-file-alt me-2"></i>Laporan Perkara
                            </a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </li>

        <!-- MEDIASI MENU -->
        <li class="nav-item mb-2">
            <a class="nav-link d-flex justify-content-between align-items-center menu-toggle"
                data-bs-toggle="collapse" data-bs-target="#submenuMediasi" href="#submenuMediasi" role="button"
                aria-expanded="false" aria-controls="submenuMediasi">
                <span><i class="fas fa-balance-scale me-2"></i>Mediasi</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse" id="submenuMediasi">
                <ul class="nav flex-column ms-3 mt-2">
                    <?php if ($role == 'user'): ?>
                        <li><a class="nav-link submenu-link" href="<?= site_url('mediasi/kelola'); ?>" data-menu="mediasi">
                                <i class="fas fa-tasks me-2"></i>Kelola Data Mediasi
                            </a></li>
                        <li><a class="nav-link submenu-link" href="<?= site_url('mediasi/tambah'); ?>" data-menu="mediasi">
                                <i class="fas fa-plus me-2"></i>Tambah Mediasi
                            </a></li>
                        <li><a class="nav-link submenu-link" href="<?= site_url('mediasi/laporan'); ?>" data-menu="mediasi">
                                <i class="fas fa-file-alt me-2"></i>Laporan Mediasi
                            </a></li>
                    <?php else: ?>
                        <li><a class="nav-link submenu-link" href="<?= site_url('mediasi/lihat'); ?>" data-menu="mediasi">
                                <i class="fas fa-eye me-2"></i>Lihat Data Mediasi
                            </a></li>
                        <li><a class="nav-link submenu-link" href="<?= site_url('mediasi/laporan'); ?>" data-menu="mediasi">
                                <i class="fas fa-file-alt me-2"></i>Laporan Mediasi
                            </a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </li>

        <!-- USER MENU (ADMIN ONLY) -->
        <?php if ($role == 'admin'): ?>
            <li class="nav-item mb-2">
                <a class="nav-link d-flex justify-content-between align-items-center menu-toggle"
                    data-bs-toggle="collapse" data-bs-target="#submenuUser" href="#submenuUser" role="button"
                    aria-expanded="false" aria-controls="submenuUser">
                    <span><i class="fas fa-users me-2"></i>User</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="collapse" id="submenuUser">
                    <ul class="nav flex-column ms-3 mt-2">
                        <li><a class="nav-link submenu-link" href="<?= site_url('kelola_user'); ?>" data-menu="user">
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
        width: 280px;
        padding: 1rem;
        box-shadow: 1px 0 5px rgba(0, 0, 0, 0.05);
        overflow-y: auto;
        overflow-x: hidden;
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

    /* Active state untuk submenu dengan efek visual yang jelas */
    .sidebar .submenu-link.active {
        background: linear-gradient(135deg, #006400, #004d00);
        color: #ffffff !important;
        position: relative;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0, 100, 0, 0.2);
    }

    .sidebar .submenu-link.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 70%;
        background: #00ff00;
        border-radius: 0 2px 2px 0;
    }

    .sidebar .submenu-link.active i {
        color: #ffffff !important;
    }

    /* Parent menu active state */
    .sidebar .menu-toggle.parent-active {
        background: #f0fdf4;
        color: #006400;
        font-weight: 600;
        border-left: 3px solid #006400;
    }

    .sidebar .menu-toggle.parent-active i {
        color: #006400;
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

    /* Highlight efek saat klik */
    .sidebar .submenu-link.clicked {
        animation: clickPulse 0.3s ease;
    }

    @keyframes clickPulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(0.98);
            background: #e0f2e0;
        }

        100% {
            transform: scale(1);
        }
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
        margin-left: 280px;
        transition: margin-left 0.3s ease;
    }

    .main-content {
        margin-left: 0;
        width: 100%;
        min-height: calc(100vh - 60px);
        background: #f8f9fa;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        body {
            margin-left: 0;
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

    /* Prevent text selection on menu toggle */
    .menu-toggle {
        user-select: none;
        cursor: pointer;
    }

    /* Smooth transition for collapse */
    .collapsing {
        transition: height 0.35s ease;
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

        // Initialize Bootstrap Collapse instances
        const collapseElements = document.querySelectorAll('.collapse');
        collapseElements.forEach(el => {
            new bootstrap.Collapse(el, {
                toggle: false
            });
        });

        // Set active menu based on current URL
        const currentUrl = window.location.href;
        const submenuLinks = document.querySelectorAll('.submenu-link');

        submenuLinks.forEach(link => {
            const linkHref = link.getAttribute('href');

            // Check if current URL matches this link
            if (linkHref && currentUrl.includes(linkHref)) {
                // Mark this link as active
                link.classList.add('active');

                // Find and expand parent collapse
                const parentCollapse = link.closest('.collapse');
                if (parentCollapse) {
                    const bsCollapse = bootstrap.Collapse.getInstance(parentCollapse) || new bootstrap.Collapse(parentCollapse, {
                        toggle: false
                    });
                    bsCollapse.show();

                    // Mark parent toggle as active
                    const parentToggle = document.querySelector(`[data-bs-target="#${parentCollapse.id}"]`);
                    if (parentToggle) {
                        parentToggle.classList.add('parent-active');
                        parentToggle.setAttribute('aria-expanded', 'true');
                    }
                }
            }
        });

        // Handle submenu link clicks - add visual feedback but don't close menu
        submenuLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Jangan hentikan default action (navigasi)
                // Hanya tambahkan efek visual

                // Remove active class from other links in same menu
                const siblingLinks = this.closest('.collapse').querySelectorAll('.submenu-link');
                siblingLinks.forEach(sibling => {
                    if (sibling !== this) {
                        sibling.classList.remove('active');
                    }
                });

                // Add active class to clicked link
                this.classList.add('active', 'clicked');

                // Remove clicked animation class after animation completes
                setTimeout(() => {
                    this.classList.remove('clicked');
                }, 300);

                // Pada mobile, tutup sidebar setelah delay singkat untuk menampilkan animasi
                if (window.innerWidth <= 768) {
                    setTimeout(() => {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                        document.body.classList.remove('sidebar-open');
                    }, 500);
                }
            });
        });

        // Save and restore menu state menggunakan sessionStorage
        const saveMenuState = () => {
            const openMenus = [];
            document.querySelectorAll('.collapse.show').forEach(collapse => {
                openMenus.push(collapse.id);
            });
            sessionStorage.setItem('openMenus', JSON.stringify(openMenus));
        };

        const restoreMenuState = () => {
            try {
                const openMenus = JSON.parse(sessionStorage.getItem('openMenus') || '[]');
                openMenus.forEach(menuId => {
                    const collapse = document.getElementById(menuId);
                    if (collapse) {
                        const bsCollapse = bootstrap.Collapse.getInstance(collapse) || new bootstrap.Collapse(collapse, {
                            toggle: false
                        });
                        bsCollapse.show();

                        const toggle = document.querySelector(`[data-bs-target="#${menuId}"]`);
                        if (toggle) {
                            toggle.setAttribute('aria-expanded', 'true');
                        }
                    }
                });
            } catch (e) {
                console.error('Error restoring menu state:', e);
            }
        };

        // Restore menu state on page load
        restoreMenuState();

        // Save menu state when collapse changes
        collapseElements.forEach(el => {
            el.addEventListener('shown.bs.collapse', saveMenuState);
            el.addEventListener('hidden.bs.collapse', saveMenuState);
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
                document.body.classList.remove('sidebar-open');
            }
        });

        // Prevent menu toggle dari navigasi
        const menuToggles = document.querySelectorAll('.menu-toggle');
        menuToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
            });
        });
    });
</script>