<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<?php $this->load->view('navbar/header'); ?>

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

    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Asal Pengadilan</th>
                <th>Nomor Perkara Tk1</th>
                <th>Klasifikasi</th>
                <th>Tgl Register Banding</th>
                <th>Nomor Perkara Banding</th>
                <th>Lama Proses</th>
                <th>Status Perkara Tk Banding</th>
                <th>Pemberitahuan Putusan Banding</th>
                <th>Permohonan Kasasi</th>
                <th>Pengiriman Berkas Kasasi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($perkaras)): ?>
                <?php foreach ($perkaras as $row): ?>
                    <tr>
                        <td><?= (int)$row->id ?></td>
                        <td><?= htmlspecialchars($row->asal_pengadilan ?? '-') ?></td>
                        <td><?= htmlspecialchars($row->nomor_perkara_tk1 ?? '-') ?></td>
                        <td><?= htmlspecialchars($row->klasifikasi ?? '-') ?></td>
                        <td>
                            <?= !empty($row->tgl_register_banding)
                                ? date('d-m-Y', strtotime($row->tgl_register_banding))
                                : '-' ?>
                        </td>
                        <td><?= htmlspecialchars($row->nomor_perkara_banding ?? '-') ?></td>
                        <td><?= htmlspecialchars($row->lama_proses ?? '-') ?></td>
                        <td><?= htmlspecialchars($row->status_perkara_tk_banding ?? '-') ?></td>
                        <td>
                            <?= !empty($row->pemberitahuan_putusan_banding)
                                ? date('d-m-Y', strtotime($row->pemberitahuan_putusan_banding))
                                : '-' ?>
                        </td>
                        <td>
                            <?= !empty($row->permohonan_kasasi)
                                ? date('d-m-Y', strtotime($row->permohonan_kasasi))
                                : '-' ?>
                        </td>
                        <td>
                            <?= !empty($row->pengiriman_berkas_kasasi)
                                ? date('d-m-Y', strtotime($row->pengiriman_berkas_kasasi))
                                : '-' ?>
                        </td>
                        <td>
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
                        <td>
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