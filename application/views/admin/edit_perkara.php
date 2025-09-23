<?php
include_once("../../config/database.php");
include_once("../../models/Perkara.php");

// Cek apakah id dikirim
if (!isset($_GET['id'])) {
    header("Location: ../admin/dashboard_admin.php");
    exit();
}

$perkaraModel = new Perkara($conn);
$id = $_GET['id'];
$perkara = $perkaraModel->getById($id);

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi semua kolom tidak boleh kosong
    $fields = [
        'asal_pengadilan',
        'nomor_perkara_tk1',
        'klasifikasi',
        'tgl_register_banding',
        'nomor_perkara_banding',
        'lama_proses',
        'status_perkara_tk_banding',
        'pemberitahuan_putusan_banding',
        'permohonan_kasasi',
        'pengiriman_berkas_kasasi',
        'status' // ✅ tambahkan status
    ];

    $data = [];
    $error = "";

    foreach ($fields as $field) {
        if (empty($_POST[$field])) {
            $error = "Semua kolom wajib diisi.";
            break;
        }
        $data[$field] = $_POST[$field];
    }

    if (empty($error)) {
        if ($perkaraModel->update($id, $data)) {
            header("Location: ../admin/dashboard_admin.php");
            exit();
        } else {
            $error = "Gagal mengupdate data.";
        }
    }
}

include("../navbar/header.php");
?>

<div class="container mt-4">
    <h2>Edit Perkara</h2>

    <?php if (isset($error) && $error != ""): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <!-- ID ditampilkan tapi readonly (tidak bisa diubah) -->
        <div class="mb-3">
            <label>ID Perkara</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($perkara['id']) ?>" readonly>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Asal Pengadilan</label>
                <input type="text" name="asal_pengadilan" class="form-control" value="<?= htmlspecialchars($perkara['asal_pengadilan']) ?>" required>
            </div>
        </div>
        <div class="mb-3">
            <label>Nomor Perkara Tk1</label>
            <input type="text" name="nomor_perkara_tk1" class="form-control" value="<?= htmlspecialchars($perkara['nomor_perkara_tk1']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Klasifikasi</label>
            <input list="klasifikasiList"
                name="klasifikasi"
                class="form-control"
                placeholder="Pilih atau ketik klasifikasi"
                value="<?= htmlspecialchars($perkara['klasifikasi']) ?>"
                required>
            <datalist id="klasifikasiList">
                <?php
                $result = $conn->query("SELECT nama FROM klasifikasi ORDER BY nama ASC");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['nama']}'>";
                }
                ?>
            </datalist>
        </div>

        <div class="mb-3">
            <label>Tgl Register Banding</label>
            <input type="date" name="tgl_register_banding" class="form-control" value="<?= htmlspecialchars($perkara['tgl_register_banding']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Nomor Perkara Banding</label>
            <input type="text" name="nomor_perkara_banding" class="form-control" value="<?= htmlspecialchars($perkara['nomor_perkara_banding']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Lama Proses (..Hari)</label>
            <input type="text" name="lama_proses" class="form-control" value="<?= htmlspecialchars($perkara['lama_proses']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Status Perkara Tk Banding</label>
            <input type="text" name="status_perkara_tk_banding" class="form-control" value="<?= htmlspecialchars($perkara['status_perkara_tk_banding']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Pemberitahuan Putusan Banding</label>
            <input type="date" name="pemberitahuan_putusan_banding" class="form-control" value="<?= htmlspecialchars($perkara['pemberitahuan_putusan_banding']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Permohonan Kasasi</label>
            <input type="date" name="permohonan_kasasi" class="form-control" value="<?= htmlspecialchars($perkara['permohonan_kasasi']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Pengiriman Berkas Kasasi</label>
            <input type="date" name="pengiriman_berkas_kasasi" class="form-control" value="<?= htmlspecialchars($perkara['pengiriman_berkas_kasasi']) ?>" required>
        </div>

        <!-- ✅ Tambahan kolom Status -->
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="Proses" <?= ($perkara['status'] ?? '') == 'Proses' ? 'selected' : '' ?>>Proses</option>
                <option value="Selesai" <?= ($perkara['status'] ?? '') == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                <option value="Ditolak" <?= ($perkara['status'] ?? '') == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="dashboard_admin.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include("../navbar/footer.php"); ?>