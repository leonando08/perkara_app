<?php $this->load->view('navbar/header'); ?>
<div class="content-wrapper">
    <!-- Welcome Card -->
    <div class="content-card mb-4">
        <h4 class="mb-1">Dashboard Admin</h4>
        <p class="text-muted mb-0">
            <i class="fas fa-user-circle me-1"></i>
            <b><?= htmlspecialchars($username) ?></b> (Admin)
        </p>
    </div>

    <?php if (!empty($notif) && $notif > 0): ?>
        <div class="alert alert-warning">
            🔔 Ada <?= $notif ?> perkara dengan permohonan kasasi besok
        </div>
    <?php endif; ?>

    <!-- Search Card -->
    <div class="search-card mb-4">
        <h5 class="mb-3">
            <i class="fas fa-search me-2"></i>
            Filter Data
        </h5>
        <form method="get" action="<?= site_url('admin/dashboard_admin') ?>" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Jenis Perkara</label>
                <select name="perkara" class="form-select">
                    <option value="">Semua Jenis</option>
                    <option value="PIDANA" <?= ($this->input->get('perkara') == 'PIDANA') ? 'selected' : '' ?>>PIDANA</option>
                    <option value="PERDATA" <?= ($this->input->get('perkara') == 'PERDATA') ? 'selected' : '' ?>>PERDATA</option>
                    <option value="ANAK" <?= ($this->input->get('perkara') == 'ANAK') ? 'selected' : '' ?>>ANAK</option>
                    <option value="TIPIKOR" <?= ($this->input->get('perkara') == 'TIPIKOR') ? 'selected' : '' ?>>TIPIKOR</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Asal Pengadilan</label>
                <input type="text" name="cari_pengadilan" class="form-control"
                    value="<?= htmlspecialchars($this->input->get('cari_pengadilan')) ?>"
                    placeholder="Cari pengadilan...">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Proses" <?= ($this->input->get('status') == 'Proses') ? 'selected' : '' ?>>Proses</option>
                    <option value="Selesai" <?= ($this->input->get('status') == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <div class="d-flex gap-2 w-100">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>
                    <a href="<?= site_url('admin/dashboard_admin') ?>" class="btn btn-secondary flex-grow-1">
                        <i class="fas fa-redo me-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <?php if (!empty($terlambat) && $terlambat > 0): ?>
        <div class="alert alert-danger">
            ⚠️ Ada <?= $terlambat ?> perkara yang permohonan kasasinya sudah lewat
        </div>
    <?php endif; ?>

    <style>
        .content-card.p-0 {
            padding: 0;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        }

        .table-wrapper {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .table-responsive-custom {
            overflow-x: auto;
            overflow-y: auto;
            max-height: 70vh;
            width: 100%;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        /* Make specific columns fixed width */
        .table .number-column {
            width: 60px;
        }

        .table .date-column {
            width: 120px;
        }

        .table .putusan-banding-column {
            width: 160px;
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
    </style>

    <!-- Table -->
    <style>
        .content-card.p-0 {
            padding: 0;
            overflow: hidden;
            border-radius: 8px;
            background: white;
        }

        .table-container {
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .table-responsive-custom {
            width: 100%;
            overflow-x: auto;
            overflow-y: auto;
            max-height: 70vh;
        }

        .table {
            margin: 0;
            width: 100%;
        }

        /* Fixed column widths */
        .number-column {
            width: 60px !important;
            min-width: 60px !important;
        }

        .date-column {
            width: 120px !important;
            min-width: 120px !important;
        }

        .putusan-banding-column {
            width: 160px !important;
            min-width: 160px !important;
        }

        .status-column {
            width: 100px !important;
            min-width: 100px !important;
        }

        .action-column {
            width: 100px !important;
            min-width: 100px !important;
        }

        .parent-column {
            width: 150px !important;
            min-width: 150px !important;
        }

        .text-column {
            min-width: 180px !important;
            white-space: normal !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
        }

        .lama-column {
            width: 80px !important;
            min-width: 80px !important;
            max-width: 80px !important;
        }

        /* Scrollbar styling */
        .table-responsive-custom::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        .table-responsive-custom::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 5px;
        }

        .table-responsive-custom::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
            border: 2px solid #f1f1f1;
        }

        .table-responsive-custom::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Table header styling */
        .table thead th {
            background-color: #198754;
            color: white;
            font-weight: 600;
            padding: 0.75rem 0.5rem;
            white-space: nowrap;
            vertical-align: middle;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 10;
            text-align: left;
            font-size: 0.8rem;
        }

        /* Table body styling */
        .table tbody td {
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

        .table tbody tr:hover td {
            background-color: rgba(25, 135, 84, 0.05);
            transition: background-color 0.2s ease;
        }

        .table tbody tr:nth-child(even) td {
            background-color: #f8f9fa;
        }
    </style>

    <div class="content-card p-0">
        <div class="table-container">
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
                            <th class="putusan-banding-column text-center align-middle">Putusan Banding</th>
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
                                    <td class="parent-column" title="<?= $row->perkara ? htmlspecialchars($row->perkara) : '-' ?>">
                                        <?= $row->perkara ? htmlspecialchars($row->perkara) : '-' ?>
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
                                    <td class="text-column"><?= str_replace('Minutas tanggal', 'Putusan Banding PT tanggal', htmlspecialchars($row->status_perkara_tk_banding)) ?></td>
                                    <td class="putusan-banding-column">
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
                                            <a href="<?= site_url('admin/edit_perkara/' . $row->id) ?>"
                                                class="btn btn-warning"
                                                title="Edit Perkara">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)"
                                                data-url="<?= site_url('admin/hapus_perkara/' . $row->id) ?>"
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
        </style>

        <!-- JavaScript untuk Tabel Responsif -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
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

                // Horizontal scroll control
                const scrollTrack = document.querySelector('.scroll-track');
                const scrollThumb = document.querySelector('.scroll-thumb');
                let isScrolling = false;
                let startX;
                let scrollLeft;

                function updateScrollThumb() {
                    if (!scrollThumb || !tableContainer) return;

                    const tableWidth = table.offsetWidth;
                    const containerWidth = tableContainer.offsetWidth;
                    const scrollPercentage = tableContainer.scrollLeft / (tableWidth - containerWidth);
                    const thumbWidth = (containerWidth / tableWidth) * scrollTrack.offsetWidth;
                    const maxOffset = scrollTrack.offsetWidth - thumbWidth;

                    scrollThumb.style.width = `${thumbWidth}px`;
                    scrollThumb.style.left = `${scrollPercentage * maxOffset}px`;
                }

                scrollThumb.addEventListener('mousedown', (e) => {
                    isScrolling = true;
                    startX = e.pageX - scrollThumb.offsetLeft;
                    scrollLeft = tableContainer.scrollLeft;
                });

                document.addEventListener('mousemove', (e) => {
                    if (!isScrolling) return;

                    e.preventDefault();
                    const x = e.pageX - scrollTrack.getBoundingClientRect().left;
                    const walk = (x - startX);
                    const tableWidth = table.offsetWidth;
                    const containerWidth = tableContainer.offsetWidth;
                    const scrollRatio = (tableWidth - containerWidth) / (scrollTrack.offsetWidth - scrollThumb.offsetWidth);

                    tableContainer.scrollLeft = scrollLeft + (walk * scrollRatio);
                });

                document.addEventListener('mouseup', () => {
                    isScrolling = false;
                });

                // Event listeners
                tableContainer.addEventListener('scroll', () => {
                    updateScrollShadows();
                    updateScrollThumb();
                });
                window.addEventListener('resize', () => {
                    checkScrollable();
                    updateScrollThumb();
                });

                // Inisialisasi
                checkScrollable();
                updateScrollThumb();

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
            });
        </script>

        <!-- SweetAlert Scripts -->
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

                // Konfirmasi hapus dengan SweetAlert
                document.querySelectorAll('.btn-hapus').forEach(function(button) {
                    button.addEventListener('click', function() {
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
                            reverseButtons: true
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
            });
        </script>

        <?php $this->load->view('navbar/footer'); ?>