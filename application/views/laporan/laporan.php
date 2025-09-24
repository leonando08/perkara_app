<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<?php $this->load->view('navbar/header'); ?>

<div class="container mt-4">
    <h2>Laporan Perkara</h2>
    <p>
        Halo,
        <b><?= htmlspecialchars($this->session->userdata('username') ?? 'Guest'); ?></b>.
        Berikut laporan data perkara.
    </p>

    <!-- Form Filter -->
    <form method="GET" class="d-flex flex-wrap align-items-end gap-3 mb-3">
        <div>
            <label for="bulan" class="form-label">Pilih Bulan:</label>
            <input type="month" id="bulan" name="bulan" class="form-control"
                value="<?= htmlspecialchars($filters['bulan'] ?? ''); ?>">
        </div>

        <div>
            <label for="asal_pengadilan" class="form-label">Asal Pengadilan:</label>
            <input type="text" id="asal_pengadilan" name="asal_pengadilan" class="form-control"
                value="<?= htmlspecialchars($filters['asal_pengadilan'] ?? ''); ?>">
        </div>

        <div>
            <label for="klasifikasi" class="form-label">Klasifikasi:</label>
            <input type="text" id="klasifikasi" name="klasifikasi" class="form-control"
                value="<?= htmlspecialchars($filters['klasifikasi'] ?? ''); ?>">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Filter</button>
            <a href="<?= site_url('laporan'); ?>" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <!-- Tombol Cetak Laporan -->
    <div class="mb-3">
        <a href="<?= site_url('laporan/cetak_laporan?' . $_SERVER['QUERY_STRING']); ?>" class="btn btn-primary mb-3">
            🖨️ Cetak Laporan
        </a>
    </div>

    <!-- Tabel Laporan -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-success text-center">
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
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($perkaras)): ?>
                    <?php foreach ($perkaras as $row): ?>
                        <tr>
                            <td class="text-center"><?= htmlspecialchars($row->id); ?></td>
                            <td><?= htmlspecialchars($row->asal_pengadilan); ?></td>
                            <td><?= htmlspecialchars($row->nomor_perkara_tk1); ?></td>
                            <td><?= htmlspecialchars($row->klasifikasi); ?></td>
                            <td>
                                <?= !empty($row->tgl_register_banding)
                                    ? date("d-m-Y", strtotime($row->tgl_register_banding))
                                    : '-'; ?>
                            </td>
                            <td><?= htmlspecialchars($row->nomor_perkara_banding); ?></td>
                            <td><?= htmlspecialchars($row->lama_proses); ?></td>
                            <td><?= htmlspecialchars($row->status_perkara_tk_banding); ?></td>
                            <td>
                                <?= !empty($row->pemberitahuan_putusan_banding)
                                    ? date("d-m-Y", strtotime($row->pemberitahuan_putusan_banding))
                                    : '-'; ?>
                            </td>
                            <td>
                                <?= !empty($row->permohonan_kasasi)
                                    ? date("d-m-Y", strtotime($row->permohonan_kasasi))
                                    : '-'; ?>
                            </td>
                            <td>
                                <?= !empty($row->pengiriman_berkas_kasasi)
                                    ? date("d-m-Y", strtotime($row->pengiriman_berkas_kasasi))
                                    : '-'; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($row->status == "Proses"): ?>
                                    <span class="badge bg-warning text-dark">Proses</span>
                                <?php elseif ($row->status == "Selesai"): ?>
                                    <span class="badge bg-success">Selesai</span>
                                <?php elseif ($row->status == "Ditolak"): ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" class="text-center">Tidak ada data perkara.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->load->view('navbar/footer'); ?>