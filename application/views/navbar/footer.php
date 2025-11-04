        <!-- Footer -->

        <footer class="footer d-flex justify-content-end align-items-center">
            <small class="text-muted me-3">Pengadilan Tinggi Banjarmasin</small>
        </footer>

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
                padding: 0.5rem 0;
                position: fixed;
                bottom: 0;
                left: 160px;
                right: 0;
                width: calc(100% - 160px);
                z-index: 1000;
                display: flex;
                justify-content: flex-end;
                align-items: center;
            }

            /* Main content padding handled by global-layout.css */

            @media (max-width: 768px) {
                .footer {
                    left: 0;
                    width: 100%;
                    font-size: 0.8rem;
                    padding: 0.5rem 0;
                    justify-content: center;
                }
            }
        </style>
        </body>

        </html>
