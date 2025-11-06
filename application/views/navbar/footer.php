        <!-- Footer -->

        <?php if (basename($_SERVER['PHP_SELF']) === 'laporan_data.php'): ?>
            <footer class="footer custom-footer-laporan" style="background:#fff;border-top:1px solid #e0e0e0;padding:14px 0 12px 0;text-align:center;position:fixed;left:280px;right:0;bottom:0;width:calc(100% - 280px);z-index:1000;box-shadow:0 -2px 8px rgba(0,0,0,0.04);font-size:14px;">
                <span style="color:#198754;font-weight:500;letter-spacing:0.5px;">Sistem Informasi Perkara &mdash; Pengadilan Tinggi Banjarmasin</span>
                <span style="color:#6c757d;margin-left:12px;">Exported <?= date('d-m-Y H:i') ?></span>
            </footer>
        <?php else: ?>
            <footer class="footer d-flex justify-content-end align-items-center">
                <small class="text-muted me-3">Pengadilan Tinggi Banjarmasin</small>
            </footer>
        <?php endif; ?>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Font Awesome -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>

        <script>
            // Toggle active class untuk menu yang aktif
            document.addEventListener('DOMContentLoaded', function() {
                const currentPath = window.location.pathname;
                const navLinks = document.querySelectorAll('.nav-link');

                navLinks.forEach(link => {
                    if (link.getAttribute('href') === currentPath) {
                        link.classList.add('active');
                    }
                });

                // Toggle sidebar di mobile
                const sidebarToggle = document.getElementById('sidebarToggle');
                const sidebar = document.querySelector('.sidebar');

                if (sidebarToggle && sidebar) {
                    sidebarToggle.addEventListener('click', function() {
                        sidebar.classList.toggle('show');
                    });
                }
            });
        </script>

        <style>
            .footer {
                background-color: #ffffff;
                border-top: 1px solid rgba(0, 0, 0, 0.1);
                padding: 0.75rem 1.5rem;
                position: fixed;
                bottom: 0;
                left: 280px;
                /* Match sidebar width from global-layout.css */
                right: 0;
                width: calc(100% - 280px);
                z-index: 1000;
                display: flex;
                justify-content: flex-end;
                align-items: center;
                box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.05);
            }

            .footer small {
                color: #6c757d;
                font-weight: 500;
            }

            /* Tablet responsiveness (769px - 1024px) */
            @media (min-width: 769px) and (max-width: 1024px) {
                .footer {
                    left: 240px;
                    /* Match tablet sidebar width */
                    width: calc(100% - 240px);
                }
            }

            /* Mobile responsiveness (≤ 768px) */
            @media (max-width: 768px) {
                .footer {
                    left: 0;
                    width: 100%;
                    font-size: 0.8rem;
                    padding: 0.75rem 1rem;
                    justify-content: center;
                }
            }
        </style>
        </body>

        </html>