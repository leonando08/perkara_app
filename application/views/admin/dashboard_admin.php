<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<?php $this->load->view('navbar/header'); ?>

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

<div class="container mt-4">
    <h2>Dashboard Admin</h2>
    <p>Selamat datang, <b><?= htmlspecialchars($username) ?></b> (Admin)</p>

    <?php if (!empty($notif) && $notif > 0): ?>
        <div class="alert alert-warning">
            🔔 Ada <?= $notif ?> perkara dengan permohonan kasasi besok
        </div>
    <?php endif; ?>

    <?php if (!empty($terlambat) && $terlambat > 0): ?>
        <div class="alert alert-danger">
            ⚠️ Ada <?= $terlambat ?> perkara yang permohonan kasasinya sudah lewat
        </div>
    <?php endif; ?>

    <div class="table-wrapper">
        <div class="table-responsive-custom">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="id-column">ID</th>
                        <th class="text-column">Asal Pengadilan</th>
                        <th class="text-column">Nomor Perkara Tk1</th>
                        <th class="text-column">Klasifikasi</th>
                        <th class="date-column">Tgl Register Banding</th>
                        <th class="text-column">Nomor Perkara Banding</th>
                        <th class="text-column">Lama Proses</th>
                        <th class="text-column">Status Perkara Tk Banding</th>
                        <th class="date-column">Pemberitahuan Putusan Banding</th>
                        <th class="date-column">Permohonan Kasasi</th>
                        <th class="date-column">Pengiriman Berkas Kasasi</th>
                        <th class="status-column">Status</th>
                        <th class="action-column">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($perkaras)): ?>
                        <?php foreach ($perkaras as $row): ?>
                            <tr>
                                <td class="id-column"><?= (int)$row->id ?></td>
                                <td class="text-column"><?= htmlspecialchars($row->asal_pengadilan ?? '-') ?></td>
                                <td class="text-column"><?= htmlspecialchars($row->nomor_perkara_tk1 ?? '-') ?></td>
                                <td class="text-column"><?= htmlspecialchars($row->klasifikasi ?? '-') ?></td>
                                <td class="date-column">
                                    <?= !empty($row->tgl_register_banding)
                                        ? date('d-m-Y', strtotime($row->tgl_register_banding))
                                        : '-' ?>
                                </td>
                                <td class="text-column"><?= htmlspecialchars($row->nomor_perkara_banding ?? '-') ?></td>
                                <td class="text-column"><?= htmlspecialchars($row->lama_proses ?? '-') ?></td>
                                <td class="text-column"><?= htmlspecialchars($row->status_perkara_tk_banding ?? '-') ?></td>
                                <td class="date-column">
                                    <?= !empty($row->pemberitahuan_putusan_banding)
                                        ? date('d-m-Y', strtotime($row->pemberitahuan_putusan_banding))
                                        : '-' ?>
                                </td>
                                <td class="date-column">
                                    <?= !empty($row->permohonan_kasasi)
                                        ? date('d-m-Y', strtotime($row->permohonan_kasasi))
                                        : '-' ?>
                                </td>
                                <td class="date-column">
                                    <?= !empty($row->pengiriman_berkas_kasasi)
                                        ? date('d-m-Y', strtotime($row->pengiriman_berkas_kasasi))
                                        : '-' ?>
                                </td>
                                <td class="status-column">
                                    <?php if ($row->status === 'Proses'): ?>
                                        <span class="badge bg-warning">Proses</span>
                                    <?php elseif ($row->status === 'Selesai'): ?>
                                        <span class="badge bg-success">Selesai</span>
                                    <?php elseif ($row->status === 'Ditolak'): ?>
                                        <span class="badge bg-danger">Ditolak</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="action-column">
                                    <a href="<?= site_url('perkara/edit/' . $row->id) ?>" class="btn btn-warning btn-sm">Edit</a>

                                    <a href="<?= site_url('perkara/hapus/' . $row->id) ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="13" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php $this->load->view('navbar/footer'); ?>