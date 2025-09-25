        </div> <!-- Penutup main-content -->

        <!-- Footer -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <small class="text-muted">© <?= date('Y') ?> Sistem Informasi Perkara</small>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <small class="text-muted">Pengadilan Tinggi Banjarmasin</small>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Font Awesome -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

        <script>
            // Toggle active class untuk menu yang aktif
            document.addEventListener('DOMContentLoaded', function() {
                const currentPath = window.location.pathname;
                const navLinks = document.querySelectorAll('.nav-link');

                navLinks.forEach(link => {
                    if (link.getAttribute('href') === currentPath) {
                        link.classList.add('active');

                        // Buka collapse parent jika ada
                        const collapseParent = link.closest('.collapse');
                        if (collapseParent) {
                            collapseParent.classList.add('show');
                        }
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
                padding: 0.75rem 0;
                position: fixed;
                bottom: 0;
                width: 100%;
                z-index: 1000;
            }

            .main-content {
                padding-bottom: 50px;
                /* Memberikan ruang untuk footer */
            }

            @media (max-width: 768px) {
                .footer {
                    font-size: 0.8rem;
                    padding: 0.5rem 0;
                }
            }
        </style>
        </body>

        </html>