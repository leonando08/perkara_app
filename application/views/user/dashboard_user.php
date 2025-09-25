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
                    <label class="form-label">Asal Pengadilan</label>
                    <input type="text" name="cari_pengadilan" class="form-control"
                        value="<?= htmlspecialchars($this->input->get('cari_pengadilan')) ?>"
                        placeholder="Cari pengadilan...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Klasifikasi</label>
                    <input type="text" name="cari_klasifikasi" class="form-control"
                        value="<?= htmlspecialchars($this->input->get('cari_klasifikasi')) ?>"
                        placeholder="Cari klasifikasi...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tanggal Permohonan</label>
                    <input type="date" name="cari_permohonan" class="form-control"
                        value="<?= htmlspecialchars($this->input->get('cari_permohonan')) ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tanggal Berkas</label>
                    <input type="date" name="cari_berkas" class="form-control"
                        value="<?= htmlspecialchars($this->input->get('cari_berkas')) ?>">
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

    <style>
        .table-wrapper {
            position: relative;
            margin-bottom: 1rem;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            border-radius: 0.5rem;
        }

        .table-responsive-custom {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            max-width: 100%;
            margin: 0;
            padding: 0.5rem;
        }

        .table {
            width: 100%;
            min-width: 1200px;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table>thead {
            background-color: #f8f9fa;
            position: sticky;
            top: 0;
            z-index: 2;
        }

        .table>thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            padding: 1rem 0.75rem;
            white-space: nowrap;
            vertical-align: middle;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }

        .table>tbody td {
            padding: 0.75rem;
            vertical-align: middle;
            background-color: #fff;
        }

        .table .number-column {
            width: 50px;
            min-width: 50px;
            text-align: center;
            position: sticky;
            left: 0;
            z-index: 1;
            background-color: #fff;
        }

        .table thead .number-column {
            background-color: #f8f9fa;
            z-index: 3;
            left: 0;
        }

        .table .action-column {
            width: 100px;
            min-width: 100px;
            text-align: center;
            position: sticky;
            right: 0;
            z-index: 1;
            background-color: #fff;
        }

        .table thead .action-column {
            background-color: #f8f9fa;
            z-index: 3;
            right: 0;
        }

        .table .date-column {
            width: 120px;
            min-width: 120px;
            white-space: nowrap;
        }

        .table .text-column {
            min-width: 150px;
        }

        .table .status-column {
            width: 100px;
            min-width: 100px;
            text-align: center;
        }

        /* Hover effects */
        .table tbody tr:hover td {
            background-color: rgba(0, 0, 0, 0.075) !important;
        }

        /* Shadow indicators for scroll */
        .table-responsive-custom::before,
        .table-responsive-custom::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 30px;
            z-index: 3;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .table-responsive-custom::before {
            left: 0;
            background: linear-gradient(to right, rgba(255, 255, 255, 0.9) 0%, transparent 100%);
        }

        .table-responsive-custom::after {
            right: 0;
            background: linear-gradient(to left, rgba(255, 255, 255, 0.9) 0%, transparent 100%);
        }

        .table-responsive-custom:hover::before,
        .table-responsive-custom:hover::after {
            opacity: 1;
        }

        /* Fix for sticky columns on hover */
        .table tbody tr:hover .number-column,
        .table tbody tr:hover .action-column {
            background-color: rgba(0, 0, 0, 0.075) !important;
        }
    </style>

    <style>
        .table-wrapper {
            position: relative;
            margin-bottom: 1rem;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            border-radius: 0.5rem;
        }

        .table-responsive-custom {
            overflow-x: scroll;
            overflow-y: visible;
            margin: 0;
            padding: 0.5rem;
        }

        .table {
            width: max-content;
            min-width: 100%;
            margin-bottom: 0;
            background-color: white;
        }

        .table>thead {
            background-color: #f8f9fa;
        }

        .table>thead th {
            background-color: #f8f9fa;
            padding: 0.75rem;
            white-space: nowrap;
            vertical-align: middle;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }

        .table>tbody td {
            padding: 0.75rem;
            vertical-align: middle;
        }

        .table .number-column {
            width: 60px;
            text-align: center;
        }

        .table .action-column {
            width: 110px;
            text-align: center;
        }

        .table .date-column {
            width: 130px;
            white-space: nowrap;
        }

        .table .text-column {
            min-width: 150px;
        }

        .table .status-column {
            width: 100px;
            text-align: center;
        }

        /* Hover effects */
        .table tbody tr:hover td {
            background-color: rgba(0, 0, 0, 0.075);
        }

        /* Better scrollbar styling */
        .table-responsive-custom::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive-custom::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .table-responsive-custom::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .table-responsive-custom::-webkit-scrollbar-thumb:hover {
            background: #666;
        }
    </style>

    <!-- Table Wrapper -->
    <div class="table-wrapper">
        <!-- Loading Overlay -->
        <div id="loadingOverlay" class="d-none">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div class="table-responsive-custom">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="number-column">No</th>
                        <th class="text-column">Pengadilan</th>
                        <th class="text-column">Perkara Tk1</th>
                        <th class="text-column">Parent</th>
                        <th class="text-column">Klasifikasi</th>
                        <th class="date-column">Tgl Register</th>
                        <th class="text-column">Perkara Banding</th>
                        <th class="text-column">Lama</th>
                        <th class="text-column">Status Tk Banding</th>
                        <th class="date-column">Putusan Banding</th>
                        <th class="date-column">Kasasi</th>
                        <th class="date-column">Berkas Kasasi</th>
                        <th class="status-column">Status</th>
                        <th class="action-column">Aksi</th>
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
                                <td class="text-column"><?= htmlspecialchars($row->asal_pengadilan) ?></td>
                                <td class="text-column"><?= htmlspecialchars($row->nomor_perkara_tk1) ?></td>
                                <td class="text-column"><?= $row->parent_nama ? htmlspecialchars($row->parent_nama) : '-' ?></td>
                                <td class="text-column"><?= htmlspecialchars($row->klasifikasi) ?></td>
                                <td class="date-column"><?= $row->tgl_register_banding ? date("d-m-Y", strtotime($row->tgl_register_banding)) : '-' ?></td>
                                <td class="text-column"><?= htmlspecialchars($row->nomor_perkara_banding) ?></td>
                                <td class="text-column"><?= htmlspecialchars($row->lama_proses) ?></td>
                                <td class="text-column"><?= htmlspecialchars($row->status_perkara_tk_banding) ?></td>
                                <td class="date-column"><?= $row->pemberitahuan_putusan_banding ? date("d-m-Y", strtotime($row->pemberitahuan_putusan_banding)) : '-' ?></td>
                                <td class="date-column"><?= $row->permohonan_kasasi ? date("d-m-Y", strtotime($row->permohonan_kasasi)) : '-' ?></td>
                                <td class="date-column"><?= $row->pengiriman_berkas_kasasi ? date("d-m-Y", strtotime($row->pengiriman_berkas_kasasi)) : '-' ?></td>
                                <td class="text-center">
                                    <?php
                                    switch ($row->status) {
                                        case "Proses":
                                            echo '<span class="badge bg-warning text-dark">Proses</span>';
                                            break;
                                        case "Selesai":
                                            echo '<span class="badge bg-success">Selesai</span>';
                                            break;
                                        case "Ditolak":
                                            echo '<span class="badge bg-danger">Ditolak</span>';
                                            break;
                                        default:
                                            echo '<span class="badge bg-secondary">-</span>';
                                    }
                                    ?>
                                </td>
                                <td class="text-center fit-content">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= site_url('user/edit/' . $row->id) ?>"
                                            class="btn btn-warning"
                                            title="Edit Perkara">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= site_url('user/hapus/' . $row->id) ?>"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')"
                                            class="btn btn-danger"
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
</div>
<?php $this->load->view('navbar/footer'); ?>