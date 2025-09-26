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

    <!-- Custom Styles -->
    <style>
        .table-wrapper {
            position: relative;
            margin-bottom: 1rem;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            border-radius: 0.5rem;
        }

        .table-responsive-custom {
            overflow: auto;
            margin: 0;
            padding: 0.5rem;
            max-width: 100%;
        }

        .table {
            width: max-content;
            min-width: 100%;
            margin-bottom: 0;
            background-color: white;
            border-collapse: collapse;
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
            border: 1px solid #dee2e6;
        }

        /* Column widths */
        .table .id-column {
            min-width: 60px;
            text-align: center;
        }

        .table .action-column {
            min-width: 120px;
            text-align: center;
            white-space: nowrap;
        }

        .table .date-column {
            min-width: 130px;
            white-space: nowrap;
        }

        .table .text-column {
            min-width: 150px;
        }

        .table .status-column {
            min-width: 100px;
            text-align: center;
            white-space: nowrap;
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

        /* Alert styling */
        .alert {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
        }
    </style>

    <!-- Table -->
    <div class="table-wrapper">
        <div class="table-responsive-custom">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="number-column">No</th>
                        <th>Pengadilan</th>
                        <th>Perkara Tk1</th>
                        <th class="parent-column">Parent</th> <!-- kasih class khusus -->
                        <th>Klasifikasi</th>
                        <th>Tgl Register</th>
                        <th>Perkara Banding</th>
                        <th>Lama</th>
                        <th>Status Tk Banding</th>
                        <th>Putusan Banding</th>
                        <th>Kasasi</th>
                        <th>Berkas Kasasi</th>
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
                                <td><?= htmlspecialchars($row->asal_pengadilan) ?></td>
                                <td><?= htmlspecialchars($row->nomor_perkara_tk1) ?></td>
                                <td class="parent-column"><?= $row->parent_nama ? htmlspecialchars($row->parent_nama) : '-' ?></td>
                                <td><?= htmlspecialchars($row->klasifikasi) ?></td>
                                <td><?= $row->tgl_register_banding ? date("d-m-Y", strtotime($row->tgl_register_banding)) : '-' ?></td>
                                <td><?= htmlspecialchars($row->nomor_perkara_banding) ?></td>
                                <td><?= htmlspecialchars($row->lama_proses) ?></td>
                                <td><?= htmlspecialchars($row->status_perkara_tk_banding) ?></td>
                                <td><?= $row->pemberitahuan_putusan_banding ? date("d-m-Y", strtotime($row->pemberitahuan_putusan_banding)) : '-' ?></td>
                                <td><?= $row->permohonan_kasasi ? date("d-m-Y", strtotime($row->permohonan_kasasi)) : '-' ?></td>
                                <td><?= $row->pengiriman_berkas_kasasi ? date("d-m-Y", strtotime($row->pengiriman_berkas_kasasi)) : '-' ?></td>
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
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= site_url('user/edit/' . $row->id) ?>" class="btn btn-warning" title="Edit Perkara">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= site_url('user/hapus/' . $row->id) ?>"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')"
                                            class="btn btn-danger" title="Hapus Perkara">
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

    <?php $this->load->view('navbar/footer'); ?>