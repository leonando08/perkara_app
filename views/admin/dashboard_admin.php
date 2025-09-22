<?php include("../navbar/header.php"); ?>
<div class="container mt-4">
    <h2>Dashboard Admin</h2>
    <p>Selamat datang, <b><?= htmlspecialchars($_SESSION['user']['username']) ?></b> (Admin)</p>

    <?php
    include_once("../../config/database.php");

    // Notifikasi Jadwal Sidang Besok
    $besok = date('Y-m-d', strtotime('+1 day'));
    $notifQuery = $conn->prepare("
        SELECT id 
        FROM perkara_banding 
        WHERE permohonan_kasasi = ? 
          AND status = 'Proses'
    ");
    $notifQuery->bind_param("s", $besok);
    $notifQuery->execute();
    $notifResult = $notifQuery->get_result();

    //Notifikasi Terlambat
    $hariIni = date('Y-m-d');
    $terlambatQuery = $conn->prepare("
        SELECT id 
        FROM perkara_banding 
        WHERE permohonan_kasasi < ? 
          AND status = 'Proses'
    ");
    $terlambatQuery->bind_param("s", $hariIni);
    $terlambatQuery->execute();
    $terlambatResult = $terlambatQuery->get_result();
    ?>

    <?php if ($notifResult->num_rows > 0): ?>
        <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
            🔔 <b>Notifikasi:</b> Ada <b><?= $notifResult->num_rows; ?></b> perkara dengan jadwal
            <b>permohonan kasasi</b> besok (<?= date('d-m-Y', strtotime($besok)); ?>).
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($terlambatResult->num_rows > 0): ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            ⚠️ <b>Peringatan:</b> Ada <b><?= $terlambatResult->num_rows; ?></b> perkara yang
            <b>permohonan kasasi</b>-nya sudah lewat dari batas tanggal (hingga <?= date('d-m-Y', strtotime($hariIni)); ?>).
            Segera ditindaklanjuti!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Form pencarian -->
    <div class="mb-3">
        <form method="GET">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small">Asal Pengadilan</label>
                    <input type="text" name="cari_pengadilan" class="form-control"
                        value="<?= isset($_GET['cari_pengadilan']) ? htmlspecialchars($_GET['cari_pengadilan']) : '' ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Klasifikasi</label>
                    <input type="text" name="cari_klasifikasi" class="form-control"
                        value="<?= isset($_GET['cari_klasifikasi']) ? htmlspecialchars($_GET['cari_klasifikasi']) : '' ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Tanggal Permohonan Kasasi</label>
                    <input type="date" name="cari_permohonan" class="form-control"
                        value="<?= isset($_GET['cari_permohonan']) ? htmlspecialchars($_GET['cari_permohonan']) : '' ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Tanggal Berkas Kasasi</label>
                    <input type="date" name="cari_berkas" class="form-control"
                        value="<?= isset($_GET['cari_berkas']) ? htmlspecialchars($_GET['cari_berkas']) : '' ?>">
                </div>
                <!-- Tombol -->
                <div class="col-md-2 d-flex">
                    <button type="submit" class="btn btn-primary me-2 flex-fill">Cari</button>
                    <a href="dashboard_admin.php" class="btn btn-secondary flex-fill">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Data -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary text-center">
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
                <?php
                include_once("../../models/Perkara.php");

                $sql = "SELECT * FROM perkara_banding ORDER BY id ASC";
                $perkaras = $conn->query($sql);

                if ($perkaras && $perkaras->num_rows > 0) :
                    while ($row = $perkaras->fetch_assoc()) :
                ?>
                        <tr>
                            <td class="text-center"><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['asal_pengadilan'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['nomor_perkara_tk1'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['klasifikasi'] ?? '-') ?></td>
                            <td><?= !empty($row['tgl_register_banding']) ? date('d-m-Y', strtotime($row['tgl_register_banding'])) : '-' ?></td>
                            <td><?= htmlspecialchars($row['nomor_perkara_banding'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['lama_proses'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['status_perkara_tk_banding'] ?? '-') ?></td>
                            <td><?= !empty($row['pemberitahuan_putusan_banding']) ? date('d-m-Y', strtotime($row['pemberitahuan_putusan_banding'])) : '-' ?></td>
                            <td><?= !empty($row['permohonan_kasasi']) ? date('d-m-Y', strtotime($row['permohonan_kasasi'])) : '-' ?></td>
                            <td><?= !empty($row['pengiriman_berkas_kasasi']) ? date('d-m-Y', strtotime($row['pengiriman_berkas_kasasi'])) : '-' ?></td>


                            <!-- Kolom Status -->
                            <td class="text-center">
                                <?php if ($row['status'] == "Proses"): ?>
                                    <span class="badge bg-warning text-dark">Proses</span>
                                <?php elseif ($row['status'] == "Selesai"): ?>
                                    <span class="badge bg-success">Selesai</span>
                                <?php elseif ($row['status'] == "Ditolak"): ?>
                                    <span class="badge bg-danger">Ditolak</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">-</span>
                                <?php endif; ?>
                            </td>


                            <td class="text-center">
                                <a href="../admin/edit_perkara.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏ Edit</a>
                            </td>
                        </tr>
                    <?php endwhile;
                else : ?>
                    <tr>
                        <td colspan="13" class="text-center">⚠ Tidak ada data</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
<?php include("../navbar/footer.php"); ?>