<?php
include("../navbar/header.php");
?>
<div class="container mt-4">
    <h2>Dashboard User</h2>
    <p>Selamat datang, <b><?= htmlspecialchars($_SESSION['user']['username']) ?></b> (User)</p>

    <!-- Form Pencarian -->
    <div class="mb-3">
        <form method="GET">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small">Asal Pengadilan</label>
                    <input type="text" name="cari_pengadilan" class="form-control"
                        value="<?= $_GET['cari_pengadilan'] ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Klasifikasi</label>
                    <input type="text" name="cari_klasifikasi" class="form-control"
                        value="<?= $_GET['cari_klasifikasi'] ?? '' ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Tanggal Permohonan Kasasi</label>
                    <input type="date" name="cari_permohonan" class="form-control"
                        value="<?= $_GET['cari_permohonan'] ?? '' ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label small">Tanggal Berkas Kasasi</label>
                    <input type="date" name="cari_berkas" class="form-control"
                        value="<?= $_GET['cari_berkas'] ?? '' ?>">
                </div>
                <div class="col-md-2 d-flex">
                    <button type="submit" class="btn btn-primary me-2 flex-fill">Cari</button>
                    <a href="dashboard_user1.php" class="btn btn-secondary flex-fill">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <?php
    include_once("../../config/database.php");
    include_once("../../models/Perkara.php");

    $perkaraModel = new Perkara($conn);

    // parameter pencarian
    $where = [];
    $params = [];
    $types = "";

    if (!empty($_GET['cari_pengadilan'])) {
        $where[] = "p.asal_pengadilan LIKE ?";
        $params[] = "%" . $_GET['cari_pengadilan'] . "%";
        $types .= "s";
    }
    if (!empty($_GET['cari_klasifikasi'])) {
        $where[] = "j.nama LIKE ?";
        $params[] = "%" . $_GET['cari_klasifikasi'] . "%";
        $types .= "s";
    }
    if (!empty($_GET['cari_permohonan'])) {
        $where[] = "p.permohonan_kasasi = ?";
        $params[] = $_GET['cari_permohonan'];
        $types .= "s";
    }
    if (!empty($_GET['cari_berkas'])) {
        $where[] = "p.pengiriman_berkas_kasasi = ?";
        $params[] = $_GET['cari_berkas'];
        $types .= "s";
    }

    // query utama
    $sql = "
        SELECT 
            p.id,
            p.asal_pengadilan,
            p.nomor_perkara_tk1,
            p.klasifikasi,
            p.tgl_register_banding,
            p.nomor_perkara_banding,
            p.lama_proses,
            p.status_perkara_tk_banding,
            p.pemberitahuan_putusan_banding,
            p.permohonan_kasasi,
            p.pengiriman_berkas_kasasi,
            p.status,
            j.nama AS klasifikasi_nama,
            jp.nama AS parent_nama
        FROM perkara_banding p
        LEFT JOIN jenis_perkara j ON p.klasifikasi = j.nama
        LEFT JOIN jenis_perkara jp ON p.parent = jp.parent_id
    ";

    if (!empty($where)) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    $sql .= " ORDER BY p.id ASC";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    if (!empty($where)) {
        $stmt->bind_param($types, ...$params);
    }
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $perkaras = $stmt->get_result();
    ?>

    <!-- Table Scroll Horizontal -->
    <div style="overflow-x:auto;">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-primary text-center">
                <tr>
                    <th style="min-width:40px;">No</th>
                    <th style="min-width:100px;">Pengadilan</th>
                    <th style="min-width:120px;">Perkara Tk1</th>
                    <th style="min-width:90px;">Parent</th>
                    <th style="min-width:100px;">Klasifikasi</th>
                    <th style="min-width:110px;">Tgl Register</th>
                    <th style="min-width:120px;">Perkara Banding</th>
                    <th style="min-width:80px;">Lama</th>
                    <th style="min-width:120px;">Status Tk Banding</th>
                    <th style="min-width:110px;">Putusan Banding</th>
                    <th style="min-width:110px;">Kasasi</th>
                    <th style="min-width:110px;">Berkas Kasasi</th>
                    <th style="min-width:80px;">Status</th>
                    <th style="min-width:90px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $perkaras->fetch_assoc()): ?>
                    <tr>
                        <td class="text-center"><?= $row['id'] ?></td>
                        <td style="white-space:normal; word-wrap:break-word;"><?= htmlspecialchars($row['asal_pengadilan']) ?></td>
                        <td style="white-space:normal; word-wrap:break-word;"><?= htmlspecialchars($row['nomor_perkara_tk1']) ?></td>
                        <td style="white-space:normal; word-wrap:break-word;"><?= htmlspecialchars($row['parent_nama'] ?? '-') ?></td>
                        <td style="white-space:normal; word-wrap:break-word;"><?= htmlspecialchars($row['klasifikasi_nama'] ?? '-') ?></td>
                        <td><?= $row['tgl_register_banding'] ? date("d-m-Y", strtotime($row['tgl_register_banding'])) : '-' ?></td>
                        <td style="white-space:normal; word-wrap:break-word;"><?= htmlspecialchars($row['nomor_perkara_banding']) ?></td>
                        <td><?= htmlspecialchars($row['lama_proses']) ?></td>
                        <td style="white-space:normal; word-wrap:break-word;"><?= htmlspecialchars($row['status_perkara_tk_banding']) ?></td>
                        <td><?= $row['pemberitahuan_putusan_banding'] ? date("d-m-Y", strtotime($row['pemberitahuan_putusan_banding'])) : '-' ?></td>
                        <td><?= $row['permohonan_kasasi'] ? date("d-m-Y", strtotime($row['permohonan_kasasi'])) : '-' ?></td>
                        <td><?= $row['pengiriman_berkas_kasasi'] ? date("d-m-Y", strtotime($row['pengiriman_berkas_kasasi'])) : '-' ?></td>
                        <td class="text-center">
                            <?php
                            switch ($row['status']) {
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
                            <a href="edit_perkara.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏ Edit</a>
                            <a href="hapus_perkara.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">🗑 Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>
<?php include("../navbar/footer.php"); ?>