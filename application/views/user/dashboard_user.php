<?php $this->load->view('navbar/header'); ?>
<div class="content-wrapper">
    <!-- Welcome Card -->
    <div class="content-card mb-4">
        <h4 class="mb-1">Selamat Datang di Dashboard</h4>
        <p class="text-muted mb-0">
            <i class="fas fa-user-circle me-1"></i>
            <b><?= htmlspecialchars($this->session->userdata('username')) ?></b> (User)
        </p>
    </div>

    <!-- Search Card -->
    <div class="search-card mb-4">
        <h5 class="mb-3">
            <i class="fas fa-search me-2"></i>
            Filter Data
        </h5>
        <form method="get" action="<?= site_url('user/dashboard_user') ?>">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Jenis Perkara</label>
                    <select name="perkara" class="form-select">
                        <option value="">Semua Jenis</option>
                        <option value="PIDANA" <?= isset($filters['perkara']) && $filters['perkara'] == 'PIDANA' ? 'selected' : '' ?>>PIDANA</option>
                        <option value="PERDATA" <?= isset($filters['perkara']) && $filters['perkara'] == 'PERDATA' ? 'selected' : '' ?>>PERDATA</option>
                        <option value="ANAK" <?= isset($filters['perkara']) && $filters['perkara'] == 'ANAK' ? 'selected' : '' ?>>ANAK</option>
                        <option value="TIPIKOR" <?= isset($filters['perkara']) && $filters['perkara'] == 'TIPIKOR' ? 'selected' : '' ?>>TIPIKOR</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Asal Pengadilan</label>
                    <input type="text" name="cari_pengadilan" class="form-control"
                        value="<?= htmlspecialchars($filters['asal_pengadilan'] ?? '') ?>"
                        placeholder="Cari pengadilan...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Klasifikasi</label>
                    <input type="text" name="cari_klasifikasi" class="form-control"
                        value="<?= htmlspecialchars($filters['klasifikasi'] ?? '') ?>"
                        placeholder="Cari klasifikasi...">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <div class="d-flex gap-2 w-100">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                        <a href="<?= site_url('user/dashboard_user') ?>" class="btn btn-secondary flex-grow-1">
                            <i class="fas fa-redo me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Custom Styles -->
    <style>
        body {
            padding: 0 !important;
            margin: 0 !important;
            overflow-x: hidden;
        }

        .content-wrapper {
            padding: 15px 0 15px 0;
            max-width: 100%;
            overflow-x: hidden;
            margin: 0;
            width: 100%;
            box-sizing: border-box;
        }

        .content-card {
            background: white;
            padding: 15px;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            margin-bottom: 15px;
            margin-left: 0;
            margin-right: 0;
        }

        .content-card.p-0 {
            padding: 0;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        }

        .search-card {
            background: white;
            padding: 15px;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            margin-bottom: 15px;
            margin-left: 0;
            margin-right: 0;
        }

        /* Table Styles */
        .table-wrapper {
            position: relative;
            width: 100%;
            overflow: hidden;
            margin: 0;
        }

        .table-responsive-custom {
            width: 100%;
            overflow-x: auto;
            overflow-y: auto;
            max-height: 70vh;
            margin: 0;
            padding: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            min-width: 1200px;
            /* Memastikan tabel memiliki lebar minimum untuk scroll horizontal */
        }

        /* Make specific columns fixed width */
        .table .number-column {
            width: 60px;
        }

        .table .date-column {
            width: 120px;
        }

        .table .status-column {
            width: 100px;
        }

        .table .action-column {
            width: 100px;
        }

        .table .parent-column {
            width: 150px;
        }

        .table .text-column {
            min-width: 180px;
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .table .lama-column {
            width: 80px;
            min-width: 80px;
            max-width: 80px;
        }

        /* Indikator scroll */
        .table-wrapper::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 15px;
            height: 15px;
            background: #f1f3f4;
            border-radius: 0 0 0.5rem 0;
        }

        .table-responsive-custom::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }

        .table-responsive-custom::-webkit-scrollbar-track {
            background: #f1f3f4;
            border-radius: 4px;
        }

        .table-responsive-custom::-webkit-scrollbar-thumb {
            background: #198754;
            border-radius: 4px;
            border: 1px solid #f1f3f4;
        }

        .table-responsive-custom::-webkit-scrollbar-thumb:hover {
            background: #157347;
        }

        /* Loading state */
        .table-loading {
            position: relative;
            overflow: hidden;
        }

        .table-loading::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
            animation: loading-shimmer 1.5s infinite;
            z-index: 1000;
        }

        @keyframes loading-shimmer {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }



        .table th,
        .table td {
            padding: 0.5rem 0.25rem;
            vertical-align: middle;
            border: 1px solid #dee2e6;
            background-color: white;
            text-align: left;
            font-size: 0.75rem;
            line-height: 1.3;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
            max-width: none;
        }

        /* Responsive table columns */

        /* Table header */
        .table thead th {
            background-color: #198754;
            color: white;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 1;
            padding: 0.75rem 0.5rem;
            white-space: nowrap;
            vertical-align: middle;
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: left;
            font-size: 0.8rem;
        }

        /* Ensure content doesn't overflow */

        /* Hover effects */
        .table tbody tr:hover td {
            background-color: rgba(25, 135, 84, 0.05);
            transition: background-color 0.2s ease;
        }

        .table tbody tr:nth-child(even) td {
            background-color: #f8f9fa;
        }

        /* Scrollbar styling - Diperbaiki dan disempurnakan */
        .table-responsive-custom::-webkit-scrollbar {
            height: 12px;
            width: 12px;
        }

        .table-responsive-custom::-webkit-scrollbar-track {
            background: #f1f3f4;
            border-radius: 6px;
            margin: 2px;
            border: 1px solid #e0e0e0;
        }

        .table-responsive-custom::-webkit-scrollbar-thumb {
            background: #198754;
            border-radius: 6px;
            border: 2px solid #f1f3f4;
            min-height: 40px;
            min-width: 40px;
        }

        .table-responsive-custom::-webkit-scrollbar-thumb:hover {
            background: #157347;
        }

        .table-responsive-custom::-webkit-scrollbar-corner {
            background: #f1f3f4;
        }

        /* Indikator scroll */
        .table-wrapper::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 15px;
            height: 15px;
            background: #f1f3f4;
            border-radius: 0 0 0.5rem 0;
        }

        /* Shadow untuk scroll indicator - Diperbaiki */
        .table-wrapper::before,
        .table-wrapper::after {
            content: '';
            position: absolute;
            pointer-events: none;
            z-index: 2;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Shadow kanan untuk scroll horizontal */
        .table-wrapper::before {
            top: 0;
            right: 0;
            width: 15px;
            height: 100%;
            background: linear-gradient(to left, rgba(0, 0, 0, 0.15), transparent);
        }

        /* Shadow bawah untuk scroll vertikal */
        .table-wrapper::after {
            bottom: 0;
            left: 0;
            width: 100%;
            height: 15px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.15), transparent);
        }

        .table-wrapper.scrollable-x::before {
            opacity: 1;
        }

        .table-wrapper.scrollable-y::after {
            opacity: 1;
        }

        /* Alert styling - Diperbaiki */
        .alert {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .alert-info {
            background-color: #e7f3ff;
            color: #0c5460;
            border-left: 4px solid #007bff;
        }

        /* Responsive breakpoints */
        @media (max-width: 1200px) {
            .content-wrapper {
                padding: 10px;
            }

            .table td,
            .table th {
                padding: 0.5rem;
            }
        }

        @media (max-width: 992px) {
            .content-wrapper {
                padding: 8px;
            }

            .table {
                font-size: 0.9rem;
            }

            .table-responsive-custom {
                max-height: 60vh;
            }

            .number-column {
                width: 40px;
            }

            .action-column {
                width: 90px;
            }
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding: 5px;
            }

            .table {
                font-size: 0.85rem;
            }

            .table td,
            .table th {
                padding: 0.4rem;
            }

            .number-column {
                width: 35px;
            }

            .action-column {
                width: 80px;
            }

            .table-responsive-custom::-webkit-scrollbar {
                height: 8px;
                width: 8px;
            }
        }

        @media (max-width: 576px) {
            .content-wrapper {
                padding: 3px;
            }

            .table {
                font-size: 0.8rem;
            }

            .table td,
            .table th {
                padding: 0.3rem;
            }

            .number-column {
                width: 30px;
            }

            .action-column {
                width: 70px;
            }

            .table-responsive-custom::-webkit-scrollbar {
                height: 6px;
                width: 6px;
            }
        }

        /* Tambahan: Styling untuk loading state */
        .table-loading {
            position: relative;
            overflow: hidden;
        }

        .table-loading::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
            animation: loading-shimmer 1.5s infinite;
            z-index: 1000;
        }

        @keyframes loading-shimmer {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        .table>thead th,
        .table>tbody td {
            padding: 0.5rem;
            font-size: 0.875rem;
        }

        .table .number-column {
            min-width: 50px;
            max-width: 50px;
        }

        .table .action-column {
            min-width: 100px;
            max-width: 100px;
        }

        @media (max-width: 576px) {
            .table-responsive-custom {
                max-height: 50vh;
            }

            .table>thead th,
            .table>tbody td {
                padding: 0.375rem;
                font-size: 0.8rem;
            }
        }
    </style>

    <!-- Table -->
    <div class="content-card p-0">
        <div class="table-wrapper">
            <div class="table-responsive-custom" tabindex="0" role="region" aria-label="Tabel data perkara yang dapat di-scroll">
                <table class="table table-bordered table-striped table-hover m-0">
                    <thead>
                        <tr>
                            <th class="number-column text-center align-middle">No</th>
                            <th class="text-column align-middle">Pengadilan</th>
                            <th class="parent-column align-middle">Jenis Perkara</th>
                            <th class="text-column align-middle">Perkara Tk1</th>
                            <th class="text-column align-middle">Klasifikasi</th>
                            <th class="date-column text-center align-middle">Tgl Register</th>
                            <th class="text-column align-middle">Perkara Banding</th>
                            <th class="lama-column text-center align-middle">Lama</th>
                            <th class="text-column align-middle">Status Tk Banding</th>
                            <th class="date-column text-center align-middle">Putusan Banding</th>
                            <th class="date-column text-center align-middle">Kasasi</th>
                            <th class="date-column text-center align-middle">Berkas Kasasi</th>
                            <th class="status-column text-center align-middle">Status</th>
                            <th class="action-column text-center align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($perkaras)): ?>
                            <tr>
                                <td colspan="14" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-folder-open text-muted mb-2" style="font-size: 2rem;"></i>
                                        <p class="text-muted mb-0">Belum ada data perkara yang tersedia</p>
                                    </div>
                                </td>
                            </tr>
                            <?php else: $no = 1;
                            foreach ($perkaras as $row): ?>
                                <tr>
                                    <td class="number-column"><?= $no++ ?></td>
                                    <td class="text-column" title="<?= htmlspecialchars($row->asal_pengadilan) ?>">
                                        <?= htmlspecialchars($row->asal_pengadilan) ?>
                                    </td>
                                    <td class="parent-column" title="<?= htmlspecialchars($row->perkara) ?>">
                                        <?= htmlspecialchars($row->perkara) ?>
                                    </td>
                                    <td class="text-column" title="<?= htmlspecialchars($row->nomor_perkara_tk1) ?>">
                                        <?= htmlspecialchars($row->nomor_perkara_tk1) ?>
                                    </td>
                                    <td class="text-column" title="<?= htmlspecialchars($row->klasifikasi) ?>">
                                        <?= htmlspecialchars($row->klasifikasi) ?>
                                    </td>
                                    <td class="date-column">
                                        <?= $row->tgl_register_banding ? date("d-m-Y", strtotime($row->tgl_register_banding)) : '-' ?>
                                    </td>
                                    <td class="text-column" title="<?= htmlspecialchars($row->nomor_perkara_banding) ?>">
                                        <?= htmlspecialchars($row->nomor_perkara_banding) ?>
                                    </td>
                                    <td class="lama-column"><?= htmlspecialchars($row->lama_proses) ?></td>
                                    <td class="text-column"><?= htmlspecialchars($row->status_perkara_tk_banding) ?></td>
                                    <td class="date-column">
                                        <?= $row->pemberitahuan_putusan_banding ? date("d-m-Y", strtotime($row->pemberitahuan_putusan_banding)) : '-' ?>
                                    </td>
                                    <td class="date-column">
                                        <?= $row->permohonan_kasasi ? date("d-m-Y", strtotime($row->permohonan_kasasi)) : '-' ?>
                                    </td>
                                    <td class="date-column">
                                        <?= $row->pengiriman_berkas_kasasi ? date("d-m-Y", strtotime($row->pengiriman_berkas_kasasi)) : '-' ?>
                                    </td>
                                    <td class="status-column">
                                        <?php
                                        switch ($row->status) {
                                            case "Proses":
                                                echo '<span class="badge bg-warning text-dark">Proses</span>';
                                                break;
                                            case "Selesai":
                                                echo '<span class="badge bg-success">Selesai</span>';
                                                break;
                                            default:
                                                echo '<span class="badge bg-secondary">-</span>';
                                        }
                                        ?>
                                    </td>
                                    <td class="action-column">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= site_url('user/edit/' . $row->id) ?>"
                                                class="btn btn-warning"
                                                title="Edit Perkara">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#"
                                                data-url="<?= site_url('user/hapus/' . $row->id) ?>"
                                                class="btn btn-danger btn-hapus"
                                                title="Hapus Perkara">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                        <?php endforeach;
                        endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- JavaScript untuk Tabel Responsif -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // SweetAlert untuk flashdata success
                <?php if ($this->session->flashdata('success')): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '<?= addslashes($this->session->flashdata('success')) ?>',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#28a745',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                <?php endif; ?>

                // SweetAlert untuk flashdata error
                <?php if ($this->session->flashdata('error')): ?>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: '<?= addslashes($this->session->flashdata('error')) ?>',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                <?php endif; ?>

                // SweetAlert untuk login berhasil
                <?php if ($this->session->flashdata('login_success')): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Selamat Datang!',
                        text: '<?= addslashes($this->session->flashdata('login_success')) ?>',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#198754',
                        timer: 3000,
                        timerProgressBar: true
                    });
                <?php endif; ?>

                const tableWrapper = document.querySelector('.table-wrapper');
                const tableContainer = document.querySelector('.table-responsive-custom');
                const table = document.querySelector('.table');

                if (!tableWrapper || !tableContainer || !table) return;

                // Cek apakah tabel perlu scroll
                function checkScrollable() {
                    const isScrollableX = tableContainer.scrollWidth > tableContainer.clientWidth;
                    const isScrollableY = tableContainer.scrollHeight > tableContainer.clientHeight;

                    // Update class untuk shadow indicators
                    tableWrapper.classList.toggle('scrollable-x', isScrollableX);
                    tableWrapper.classList.toggle('scrollable-y', isScrollableY);

                    if (isScrollableX || isScrollableY) {
                        tableContainer.setAttribute('title', 'Gunakan scroll mouse atau tombol panah untuk navigasi');
                    } else {
                        tableContainer.removeAttribute('title');
                    }

                    updateScrollShadows();
                }

                // Update shadow indicators berdasarkan posisi scroll
                function updateScrollShadows() {
                    const scrollLeft = tableContainer.scrollLeft;
                    const scrollTop = tableContainer.scrollTop;
                    const maxScrollLeft = tableContainer.scrollWidth - tableContainer.clientWidth;
                    const maxScrollTop = tableContainer.scrollHeight - tableContainer.clientHeight;

                    // Hapus semua shadow classes
                    tableWrapper.classList.remove('scroll-left', 'scroll-right', 'scroll-top', 'scroll-bottom');

                    // Tambahkan shadow berdasarkan posisi untuk scroll horizontal
                    if (scrollLeft > 5) {
                        tableWrapper.classList.add('scroll-left');
                    }
                    if (scrollLeft < maxScrollLeft - 5) {
                        tableWrapper.classList.add('scroll-right');
                    }

                    // Tambahkan shadow berdasarkan posisi untuk scroll vertikal
                    if (scrollTop > 5) {
                        tableWrapper.classList.add('scroll-top');
                    }
                    if (scrollTop < maxScrollTop - 5) {
                        tableWrapper.classList.add('scroll-bottom');
                    }
                }

                // Event listeners
                tableContainer.addEventListener('scroll', updateScrollShadows);
                window.addEventListener('resize', checkScrollable);

                // Inisialisasi
                checkScrollable();

                // Smooth scrolling untuk mobile
                if ('ontouchstart' in window) {
                    tableContainer.style.webkitOverflowScrolling = 'touch';
                }

                // Keyboard navigation
                tableContainer.addEventListener('keydown', function(e) {
                    const scrollAmount = 50;

                    switch (e.key) {
                        case 'ArrowLeft':
                            e.preventDefault();
                            tableContainer.scrollLeft -= scrollAmount;
                            break;
                        case 'ArrowRight':
                            e.preventDefault();
                            tableContainer.scrollLeft += scrollAmount;
                            break;
                        case 'ArrowUp':
                            e.preventDefault();
                            tableContainer.scrollTop -= scrollAmount;
                            break;
                        case 'ArrowDown':
                            e.preventDefault();
                            tableContainer.scrollTop += scrollAmount;
                            break;
                        case 'Home':
                            e.preventDefault();
                            tableContainer.scrollLeft = 0;
                            break;
                        case 'End':
                            e.preventDefault();
                            tableContainer.scrollLeft = tableContainer.scrollWidth;
                            break;
                        case 'PageUp':
                            e.preventDefault();
                            tableContainer.scrollTop -= tableContainer.clientHeight * 0.8;
                            break;
                        case 'PageDown':
                            e.preventDefault();
                            tableContainer.scrollTop += tableContainer.clientHeight * 0.8;
                            break;
                    }
                });

                // Observer untuk perubahan konten tabel
                if ('MutationObserver' in window) {
                    const observer = new MutationObserver(checkScrollable);
                    observer.observe(table, {
                        childList: true,
                        subtree: true
                    });
                }
            });

            // Utility function untuk scroll ke kolom tertentu
            function scrollToColumn(columnIndex) {
                const table = document.querySelector('.table');
                const container = document.querySelector('.table-responsive-custom');

                if (!table || !container) return;

                const cells = table.querySelectorAll(`th:nth-child(${columnIndex}), td:nth-child(${columnIndex})`);
                if (cells.length > 0) {
                    const firstCell = cells[0];
                    const cellLeft = firstCell.offsetLeft;

                    container.scrollTo({
                        left: cellLeft - 100,
                        behavior: 'smooth'
                    });
                }
            }

            // Utility function untuk scroll ke baris tertentu
            function scrollToRow(rowIndex) {
                const container = document.querySelector('.table-responsive-custom');
                const rows = document.querySelectorAll('tbody tr');

                if (!container || !rows[rowIndex]) return;

                const targetRow = rows[rowIndex];
                const rowTop = targetRow.offsetTop;

                container.scrollTo({
                    top: rowTop - 100,
                    behavior: 'smooth'
                });
            }

            // Konfirmasi hapus dengan SweetAlert
            document.querySelectorAll('.btn-hapus').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('data-url');

                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: 'Apakah Anda yakin ingin menghapus data perkara ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Tampilkan loading
                            Swal.fire({
                                title: 'Menghapus...',
                                text: 'Mohon tunggu sebentar',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Redirect ke URL hapus
                            window.location.href = url;
                        }
                    });
                });
            });
        </script>
    </div>

    <?php $this->load->view('navbar/footer');
