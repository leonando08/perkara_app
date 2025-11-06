<?php
defined('BASEPATH') or exit('No direct script access allowed');
$role = $this->session->userdata('role');
$current_url = current_url();
?>

<!-- Sidebar - no-transition class akan di-remove setelah restore selesai -->
<div class="sidebar no-transition" id="sidebar">
    <div class="sidebar-header mb-3">
        <h6 class="sidebar-title">
            <i class="fas fa-th-list me-2"></i>Menu Utama
        </h6>
    </div>

    <ul class="nav flex-column" style="text-align:left;">

        <!-- DASHBOARD & DATA PERKARA MENU -->
        <li class="nav-item mb-2">
            <a class="nav-link d-flex justify-content-between align-items-center menu-toggle"
                data-bs-toggle="collapse" data-bs-target="#submenuDashboard" href="#submenuDashboard" role="button"
                aria-expanded="false" aria-controls="submenuDashboard">
                <span><i class="fas fa-tachometer-alt me-2"></i>Dashboard</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse" id="submenuDashboard">
                <ul class="nav flex-column ms-3 mt-2">
                    <?php if ($role == 'admin'): ?>
                        <li><a class="nav-link submenu-link" href="<?= site_url('admin/dashboard_admin'); ?>" data-menu="dashboard">
                                <i class="fas fa-home me-2"></i>Data Perkara
                            </a></li>
                    <?php else: ?>
                        <li><a class="nav-link submenu-link" href="<?= site_url('perkara/tambah'); ?>" data-menu="dashboard">
                                <i class="fas fa-plus me-2"></i>Tambah Perkara
                            </a></li>
                        <li><a class="nav-link submenu-link" href="<?= site_url('user/dashboard_user'); ?>" data-menu="dashboard">
                                <i class="fas fa-home me-2"></i>Data Perkara
                            </a></li>
                        
                    <?php endif; ?>
                </ul>
            </div>
        </li>
        
        <!-- LAPORAN MENU -->
        <li class="nav-item mb-2">
            <a class="nav-link d-flex justify-content-between align-items-center menu-toggle"
                data-bs-toggle="collapse" data-bs-target="#submenuLaporan" href="#submenuLaporan" role="button"
                aria-expanded="false" aria-controls="submenuLaporan">
                <span><i class="fas fa-chart-line me-2"></i>Laporan</span>
                <i class="fas fa-chevron-down"></i>
            </a>
            <div class="collapse" id="submenuLaporan">
                <ul class="nav flex-column ms-3 mt-2">
                    <li><a class="nav-link submenu-link" href="<?= site_url('laporan'); ?>" data-menu="laporan">
                            <i class="fas fa-file-alt me-2"></i>Laporan Detail
                        </a></li>
                    <li><a class="nav-link submenu-link" href="<?= site_url('laporan/laporan_data'); ?>" data-menu="laporan">
                            <i class="fas fa-table me-2"></i>Data Perkara
                        </a></li>
                    <li><a class="nav-link submenu-link" href="<?= site_url('laporan/rekap'); ?>" data-menu="laporan">
                            <i class="fas fa-chart-bar me-2"></i>Rekap Kasasi
                        </a></li>
                    <li><a class="nav-link submenu-link" href="<?= site_url('laporan/laporan_putus_tepat_waktu'); ?>" data-menu="laporan">
                            <i class="fas fa-clock-check me-2"></i>Putus Tepat Waktu
                        </a></li>
                    <li><a class="nav-link submenu-link" href="<?= site_url('laporan/rekapitulasi_bulanan'); ?>" data-menu="laporan">
                            <i class="fas fa-calendar-alt me-2"></i>Rekapitulasi Bulanan
                        </a></li>
                    <?php if ($role == 'admin'): ?>
                        <li><a class="nav-link submenu-link" href="<?= site_url('admin/grafik_perkara_bulanan'); ?>" data-menu="grafik">
                                <i class="fas fa-chart-bar me-2"></i>Grafik Perkara Bulanan
                            </a></li>
                    <?php else: ?>
                        <li><a class="nav-link submenu-link" href="<?= site_url('grafik/perkara_bulanan'); ?>" data-menu="grafik">
                                <i class="fas fa-chart-bar me-2"></i>Grafik Perkara Bulanan
                            </a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </li>

        <!-- USER MANAGEMENT MENU (ADMIN ONLY) -->
        <?php if ($role == 'admin'): ?>
            <li class="nav-item mb-2">
                <a class="nav-link d-flex justify-content-between align-items-center menu-toggle"
                    data-bs-toggle="collapse" data-bs-target="#submenuUser" href="#submenuUser" role="button"
                    aria-expanded="false" aria-controls="submenuUser">
                    <span><i class="fas fa-users me-2"></i>Kelola User</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="collapse" id="submenuUser">
                    <ul class="nav flex-column ms-3 mt-2">
                        <li><a class="nav-link submenu-link" href="<?= site_url('admin/kelola_user'); ?>" data-menu="user">
                                <i class="fas fa-list me-2"></i>Daftar User
                            </a></li>
                        <li><a class="nav-link submenu-link" href="<?= site_url('admin/tambah_user'); ?>" data-menu="user">
                                <i class="fas fa-user-plus me-2"></i>Tambah User
                            </a></li>
                    </ul>
                </div>
            </li>
        <?php endif; ?>

        <!-- LOGOUT MENU -->
        <li class="nav-item mt-4 pt-3" style="border-top: 1px solid #e5e7eb;">
            <a class="nav-link text-danger" href="#" id="logoutBtn">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
        </li>
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
        transition: all 0.15s ease;
        z-index: 1040;
        border-right: 1px solid #e5e7eb;
        /* PENTING: Prevent smooth scroll behavior yang menyebabkan "jump" effect */
        scroll-behavior: auto !important;
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

    .current-page-indicator {
        background: linear-gradient(135deg, #e8f5e9, #f1f8f4);
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        border-left: 3px solid #006400;
        box-shadow: 0 1px 3px rgba(0, 100, 0, 0.1);
        transition: all 0.3s ease;
    }

    .current-page-indicator small {
        font-size: 0.75rem;
    }

    /* Removed bounce animation for better performance */

    .sidebar .nav-item {
        margin-bottom: 0.5rem;
    }

    .sidebar .nav-link {
        color: #4a5568;
        font-weight: 500;
        font-size: 0.875rem;
        padding: 0.675rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.1s ease;
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
        transition: color 0.1s ease;
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

    /* Active state untuk submenu - elegant dan clean */
    .sidebar .submenu-link.active {
        background: linear-gradient(135deg, #006400, #008000);
        color: #ffffff !important;
        position: relative;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(0, 100, 0, 0.25);
        border-left: 3px solid #28a745;
        transform: translateX(2px);
    }

    .sidebar .submenu-link.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #00ff00, #28a745);
        box-shadow: 0 0 8px rgba(0, 255, 0, 0.3);
    }

    .sidebar .submenu-link.active i {
        color: #ffffff !important;
    }

    /* Active menu hover - smooth transition */
    .sidebar .submenu-link.active:hover {
        background: linear-gradient(135deg, #007a00, #009600);
        transform: translateX(4px);
        box-shadow: 0 3px 10px rgba(0, 100, 0, 0.35);
    }

    /* Parent menu active state - subtle and elegant */
    .sidebar .menu-toggle.parent-active {
        background: #f0fdf4;
        color: #006400;
        font-weight: 600;
        border-left: 3px solid #28a745;
    }

    .sidebar .menu-toggle.parent-active i {
        color: #006400;
    }

    .sidebar .menu-toggle.parent-active .fa-chevron-down {
        color: #006400;
    }

    .sidebar .collapse {
        padding: 0.5rem 0;
        /* Override Bootstrap default collapse animation */
        transition: height 0.2s ease !important;
    }

    /* CRITICAL: Completely disable transitions on initial page load */
    .sidebar.no-transition,
    .sidebar.no-transition * {
        transition: none !important;
        -webkit-transition: none !important;
        animation: none !important;
        -webkit-animation: none !important;
    }

    .sidebar .collapse .nav-link {
        padding-left: 2.75rem;
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
    }

    .sidebar .fa-chevron-down {
        transition: transform 0.15s ease;
        font-size: 0.75rem;
        opacity: 0.75;
        flex-shrink: 0;
    }

    .sidebar .nav-link[aria-expanded="true"] .fa-chevron-down {
        transform: rotate(180deg);
    }

    /* Highlight efek saat klik - faster */
    .sidebar .submenu-link.clicked {
        animation: clickPulse 0.15s ease;
    }

    @keyframes clickPulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(0.98);
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
        transition: opacity 0.15s ease;
    }

    /* Content adjustment - Layout now handled by global-layout.css */
    /* Removed inline .main-content styles to prevent conflicts */

    /* Force proper width calculation */
    body {
        margin: 0;
        padding: 0;
        width: 100%;
        overflow-x: hidden;
    }

    /* Mobile Responsive - Sidebar behavior only */
    @media (max-width: 768px) {
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

    /* Logout menu styling */
    .sidebar .nav-link.text-danger {
        color: #dc3545 !important;
        font-weight: 500;
    }

    .sidebar .nav-link.text-danger:hover {
        background: #fee2e2;
        color: #b91c1c !important;
        transform: translateX(4px);
    }

    .sidebar .nav-link.text-danger i {
        color: #dc3545 !important;
    }

    .sidebar .nav-link.text-danger:hover i {
        color: #b91c1c !important;
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

    /* Prevent double click effects */
    .nav-link {
        pointer-events: auto;
    }

    .nav-link:active {
        transform: scale(0.98);
    }

    /* Ensure collapse animation is smooth and doesn't duplicate */
    .collapse {
        transition: height 0.2s ease;
    }

    .collapsing {
        transition: height 0.2s ease;
    }

    /* Prevent menu flickering */
    .collapse.show {
        display: block;
    }

    /* Smooth transition for menu states */
    .menu-toggle[aria-expanded="true"] {
        transition: all 0.15s ease;
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

        // Handle menu toggle - single click untuk expand/collapse
        const menuToggles = document.querySelectorAll('.menu-toggle');
        menuToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();

                const target = this.getAttribute('data-bs-target');
                const collapse = document.querySelector(target);

                if (collapse) {
                    const bsCollapse = bootstrap.Collapse.getInstance(collapse) || new bootstrap.Collapse(collapse, {
                        toggle: false
                    });

                    if (collapse.classList.contains('show')) {
                        bsCollapse.hide();
                        this.setAttribute('aria-expanded', 'false');
                        this.classList.remove('parent-active');
                    } else {
                        bsCollapse.show();
                        this.setAttribute('aria-expanded', 'true');
                        this.classList.add('parent-active');
                    }
                }
            });
        });

        // Set active menu based on current URL
        const currentUrl = window.location.href;
        const currentPath = window.location.pathname;
        const submenuLinks = document.querySelectorAll('.submenu-link');

        // Reset all active states first
        submenuLinks.forEach(link => {
            link.classList.remove('active');
        });
        document.querySelectorAll('.menu-toggle').forEach(toggle => {
            toggle.classList.remove('parent-active');
            toggle.setAttribute('aria-expanded', 'false');
        });

        let activeLink = null;
        let bestMatchScore = 0;

        submenuLinks.forEach(link => {
            const linkHref = link.getAttribute('href');

            if (linkHref) {
                let matchScore = 0;
                let isMatch = false;

                // Extract clean URL paths
                const cleanCurrentPath = currentPath.replace(/\/+$/, ''); // Remove trailing slashes
                const cleanLinkPath = linkHref.replace(window.location.origin, '').replace(/\/+$/, '');

                // Exact match gets highest score
                if (cleanCurrentPath === cleanLinkPath) {
                    matchScore = 100;
                    isMatch = true;
                }
                // Dashboard & Perkara patterns - Prioritas tertinggi untuk edit/tambah
                else if (cleanCurrentPath.includes('/admin/edit_perkara') && cleanLinkPath.includes('/admin/dashboard_admin')) {
                    matchScore = 95;
                    isMatch = true;
                } else if (cleanCurrentPath.includes('/user/edit') && cleanLinkPath.includes('/user/dashboard_user')) {
                    matchScore = 95;
                    isMatch = true;
                } else if (cleanCurrentPath.includes('/perkara/tambah') && cleanLinkPath.includes('/perkara/tambah')) {
                    matchScore = 100;
                    isMatch = true;
                } else if (cleanCurrentPath.includes('/admin/dashboard_admin') && cleanLinkPath.includes('/admin/dashboard_admin')) {
                    matchScore = 100;
                    isMatch = true;
                } else if (cleanCurrentPath.includes('/user/dashboard_user') && cleanLinkPath.includes('/user/dashboard_user')) {
                    matchScore = 100;
                    isMatch = true;
                }
                // Laporan patterns - PENTING: Check yang lebih spesifik DULU!
                // rekapitulasi_bulanan harus dicek SEBELUM rekap
                else if (cleanCurrentPath.includes('/laporan/rekapitulasi_bulanan') && cleanLinkPath.includes('/laporan/rekapitulasi_bulanan')) {
                    matchScore = 100;
                    isMatch = true;
                } else if (cleanCurrentPath.includes('/laporan/laporan_putus_tepat_waktu') && cleanLinkPath.includes('/laporan/laporan_putus_tepat_waktu')) {
                    matchScore = 100;
                    isMatch = true;
                } else if (cleanCurrentPath.includes('/laporan/laporan_data') && cleanLinkPath.includes('/laporan/laporan_data')) {
                    matchScore = 100;
                    isMatch = true;
                }
                // CRITICAL: Exact match untuk /laporan/rekap (bukan rekapitulasi)
                // Pastikan tidak match dengan rekapitulasi_bulanan
                else if (cleanCurrentPath.includes('/laporan/rekap') && cleanLinkPath.includes('/laporan/rekap') &&
                    !cleanCurrentPath.includes('rekapitulasi') && !cleanLinkPath.includes('rekapitulasi')) {
                    matchScore = 100;
                    isMatch = true;
                } else if (cleanCurrentPath.includes('/laporan/cetak') && cleanLinkPath.includes('/laporan/index')) {
                    matchScore = 95;
                    isMatch = true;
                } else if (cleanCurrentPath.includes('/laporan') && cleanLinkPath.includes('/laporan') &&
                    cleanCurrentPath.split('/').length === cleanLinkPath.split('/').length) {
                    matchScore = 90;
                    isMatch = true;
                }
                // User management patterns
                else if (cleanCurrentPath.includes('/admin/edit_user') && cleanLinkPath.includes('/admin/kelola_user')) {
                    matchScore = 95;
                    isMatch = true;
                } else if (cleanCurrentPath.includes('/admin/kelola_user') && cleanLinkPath.includes('/admin/kelola_user')) {
                    matchScore = 100;
                    isMatch = true;
                } else if (cleanCurrentPath.includes('/admin/tambah_user') && cleanLinkPath.includes('/admin/tambah_user')) {
                    matchScore = 100;
                    isMatch = true;
                }
                // Profile patterns
                else if (cleanCurrentPath.includes('/profile') && cleanLinkPath.includes('/profile')) {
                    matchScore = 100;
                    isMatch = true;
                }

                // Only set as active if this is the best match so far
                if (isMatch && matchScore > bestMatchScore) {
                    bestMatchScore = matchScore;
                    activeLink = link;
                }
            }
        });

        // Apply active state only to the best matching link
        if (activeLink) {
            activeLink.classList.add('active');

            // Add tooltip to indicate current page
            activeLink.setAttribute('title', 'Anda sedang di halaman ini');
            activeLink.setAttribute('data-bs-toggle', 'tooltip');
            activeLink.setAttribute('data-bs-placement', 'right');

            // Find and expand parent collapse
            const parentCollapse = activeLink.closest('.collapse');
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

            // JANGAN auto-scroll ke active link - biarkan posisi tersimpan yang digunakan
            // Ini mencegah "jump" effect yang mengganggu
            // User sudah tahu posisinya dari sebelumnya, tidak perlu di-scroll ulang
        }

        // Initialize Bootstrap tooltips for active menu
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Show current page indicator at top of sidebar
        if (activeLink) {
            const currentPageIndicator = document.getElementById('currentPageIndicator');
            const currentPageText = document.getElementById('currentPageText');
            const menuText = activeLink.textContent.trim();

            if (currentPageIndicator && currentPageText) {
                currentPageText.textContent = menuText;
                currentPageIndicator.style.display = 'block';
                currentPageIndicator.style.transition = 'all 0.3s ease';
                currentPageIndicator.style.opacity = '1';
                currentPageIndicator.style.transform = 'translateY(0)';
            }
        }

        // Handle submenu link clicks - instant response
        submenuLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Add visual feedback
                this.classList.add('clicked');

                // Pada mobile, tutup sidebar langsung
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                }
            });
        });

        // Save and restore menu state + scroll position menggunakan sessionStorage
        const saveMenuState = () => {
            const openMenus = [];
            document.querySelectorAll('.collapse.show').forEach(collapse => {
                openMenus.push(collapse.id);
            });
            sessionStorage.setItem('openMenus', JSON.stringify(openMenus));

            // Save scroll position
            const sidebarMenu = document.querySelector('.sidebar-menu');
            if (sidebarMenu) {
                sessionStorage.setItem('sidebarScrollPos', sidebarMenu.scrollTop);
            }
        };

        const restoreMenuState = () => {
            const sidebar = document.getElementById('sidebar');

            try {
                const openMenus = JSON.parse(sessionStorage.getItem('openMenus') || '[]');
                const scrollPos = sessionStorage.getItem('sidebarScrollPos');

                // 1. Expand menu LANGSUNG tanpa animasi (masih ada class no-transition)
                openMenus.forEach(menuId => {
                    const collapse = document.getElementById(menuId);
                    if (collapse) {
                        collapse.classList.add('show');

                        const toggle = document.querySelector(`[data-bs-target="#${menuId}"]`);
                        if (toggle) {
                            toggle.classList.remove('collapsed');
                            toggle.setAttribute('aria-expanded', 'true');
                        }
                    }
                });

                // 2. Set scroll position LANGSUNG (synchronous)
                if (scrollPos !== null && sidebar) {
                    sidebar.scrollTop = parseInt(scrollPos);
                }

            } catch (e) {
                console.error('Error restoring menu state:', e);
            }

            // 3. Remove no-transition class setelah DOM fully loaded
            // Ini akan re-enable smooth transitions untuk interaksi user
            if (sidebar) {
                // Double RAF untuk ensure rendering selesai
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        sidebar.classList.remove('no-transition');
                    });
                });
            }
        };

        // CRITICAL: Run IMMEDIATELY - sebelum browser render
        restoreMenuState();

        // Save menu state when collapse changes
        collapseElements.forEach(el => {
            el.addEventListener('shown.bs.collapse', saveMenuState);
            el.addEventListener('hidden.bs.collapse', saveMenuState);
        });

        // Save scroll position on scroll
        const sidebarMenu = document.querySelector('.sidebar-menu');
        if (sidebarMenu) {
            let scrollTimeout;
            sidebarMenu.addEventListener('scroll', function() {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    sessionStorage.setItem('sidebarScrollPos', this.scrollTop);
                }, 100); // Debounce untuk performa
            });
        }

        // Save state before navigation - ensure state is saved
        document.querySelectorAll('.sidebar a').forEach(link => {
            link.addEventListener('click', function(e) {
                // Simpan state IMMEDIATELY sebelum navigasi
                saveMenuState();
            });
        });

        // Backup: Save state sebelum page unload
        window.addEventListener('beforeunload', function() {
            saveMenuState();
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
                document.body.classList.remove('sidebar-open');
            }
        });

        // Handle logout with SweetAlert
        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi Logout',
                    text: 'Apakah Anda yakin ingin keluar dari sistem?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Logout!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading alert
                        Swal.fire({
                            title: 'Logging out...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Redirect to logout - instant
                        window.location.href = '<?= site_url('auth/logout'); ?>';
                    }
                });
            });
        }
    });
</script>