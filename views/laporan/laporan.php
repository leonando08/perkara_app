<?php
include("../navbar/header.php");

// --- Include database & model ---
include_once("../../config/database.php");
include_once("../../models/Perkara.php");

$perkaraModel = new Perkara($conn);

// --- Inisialisasi filter ---
$filters = [
    'bulan'           => isset($_GET['bulan']) ? trim($_GET['bulan']) : '',
    'asal_pengadilan' => isset($_GET['asal_pengadilan']) ? trim($_GET['asal_pengadilan']) : '',
    'klasifikasi'     => isset($_GET['klasifikasi']) ? trim($_GET['klasifikasi']) : '',
];

// --- Ambil data perkara ---
$useFilter = ($filters['bulan'] !== '' || $filters['asal_pengadilan'] !== '' || $filters['klasifikasi'] !== '');

if ($useFilter && method_exists($perkaraModel, 'getFiltered')) {
    $perkaras = $perkaraModel->getFiltered($filters);
} else {
    $perkaras = $perkaraModel->getAll();
}
?>
<div class="container mt-4">
    <h2>Laporan Perkara</h2>
    <p>Halo, <b><?= htmlspecialchars($_SESSION['user']['username'] ?? 'Guest') ?></b>. Berikut laporan data perkara.</p>

    <!-- Form Filter -->
    <form method="GET" class="d-flex flex-wrap align-items-end gap-3 mb-3">
        <div>
            <label for="bulan" class="form-label">Pilih Bulan:</label>
            <input type="month" id="bulan" name="bulan" class="form-control"
                value="<?= htmlspecialchars($filters['bulan']) ?>">
        </div>

        <div>
            <label for="asal_pengadilan" class="form-label">Asal Pengadilan:</label>
            <input type="text" id="asal_pengadilan" name="asal_pengadilan" class="form-control"
                value="<?= htmlspecialchars($filters['asal_pengadilan']) ?>">
        </div>

        <div>
            <label for="klasifikasi" class="form-label">Klasifikasi:</label>
            <input type="text" id="klasifikasi" name="klasifikasi" class="form-control"
                value="<?= htmlspecialchars($filters['klasifikasi']) ?>">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Filter</button>
            <a href="laporan.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
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
                <?php if ($perkaras && $perkaras->num_rows > 0): ?>
                    <?php while ($row = $perkaras->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?= htmlspecialchars($row['id'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['asal_pengadilan'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['nomor_perkara_tk1'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['klasifikasi'] ?? '-') ?></td>
                            <td><?= !empty($row['tgl_register_banding']) ? date("d-m-Y", strtotime($row['tgl_register_banding'])) : '-' ?></td>
                            <td><?= htmlspecialchars($row['nomor_perkara_banding'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['lama_proses'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['status_perkara_tk_banding'] ?? '-') ?></td>
                            <td><?= !empty($row['pemberitahuan_putusan_banding']) ? date("d-m-Y", strtotime($row['pemberitahuan_putusan_banding'])) : '-' ?></td>
                            <td><?= !empty($row['permohonan_kasasi']) ? date("d-m-Y", strtotime($row['permohonan_kasasi'])) : '-' ?></td>
                            <td><?= !empty($row['pengiriman_berkas_kasasi']) ? date("d-m-Y", strtotime($row['pengiriman_berkas_kasasi'])) : '-' ?></td>
                            <td class="text-center">
                                <?php
                                switch ($row['status'] ?? '-') {
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
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" class="text-center">Tidak ada data perkara.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <?php
        // buat query string dari filter yang terisi
        $queryString = http_build_query(array_filter($filters, fn($v) => $v !== ''));
        ?>

        <div class="mt-3">
            <?php
            // buat query string dari filter yang terisi
            $queryString = http_build_query(array_filter($filters, fn($v) => $v !== ''));
            ?>

            <div class="btn-group shadow-sm">
                <!-- Tombol utama langsung cetak laporan biasa -->
                <a href="cetak_laporan.php<?= $queryString ? '?' . $queryString : '' ?>"
                    target="_blank"
                    class="btn btn-dark fw-bold px-4 py-2">
                    🖨 Cetak Laporan
                </a>

                <!-- Tombol dropdown -->
                <button type="button"
                    class="btn btn-dark dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>

                <ul class="dropdown-menu dropdown-menu-dark shadow">
                    <li>
                        <a class="dropdown-item d-flex align-items-center"
                            href="cetak_laporan_data.php<?= $queryString ? '?' . $queryString : '' ?>"
                            target="_blank">
                            📑 <span class="ms-2">Cetak Laporan Data Kasasi</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center"
                            href="cetak_laporan.php<?= $queryString ? '?' . $queryString : '' ?>"
                            target="_blank">
                            📃 <span class="ms-2">Cetak Laporan </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>




    </div>
    <?php include("../navbar/footer.php"); ?>