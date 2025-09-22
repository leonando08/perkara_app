<?php
include_once("../../config/database.php");
include_once("../../models/Perkara.php");

$perkaraModel = new Perkara($conn);
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi kolom wajib
    $requiredFields = ['asal_pengadilan', 'klasifikasi', 'tgl_register_banding', 'status'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $error = "Kolom '" . ucfirst(str_replace("_", " ", $field)) . "' tidak boleh kosong.";
            break;
        }
    }

    if (empty($error)) {
        $data = [
            'asal_pengadilan'              => $_POST['asal_pengadilan'],
            'nomor_perkara_tk1'            => $_POST['nomor_perkara_tk1'],
            'klasifikasi'                  => $_POST['klasifikasi'], // id jenis_perkara
            'tgl_register_banding'         => $_POST['tgl_register_banding'],
            'nomor_perkara_banding'        => $_POST['nomor_perkara_banding'],
            'lama_proses'                  => $_POST['lama_proses'],
            'status_perkara_tk_banding'    => $_POST['status_perkara_tk_banding'],
            'pemberitahuan_putusan_banding' => $_POST['pemberitahuan_putusan_banding'],
            'permohonan_kasasi'            => $_POST['permohonan_kasasi'],
            'pengiriman_berkas_kasasi'     => $_POST['pengiriman_berkas_kasasi'],
            'status'                       => $_POST['status']
        ];

        if ($perkaraModel->add($data)) {
            $success = "Data berhasil ditambahkan!";
        } else {
            $error = "Gagal menambahkan data.";
        }
    }
}
?>

<?php include("../navbar/header.php"); ?>
<div class="container mt-4">
    <h2>Tambah Perkara</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $success ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = "dashboard_user1.php";
            }, 2000);
        </script>
    <?php endif; ?>

    <form method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Asal Pengadilan</label>
                <input type="text" name="asal_pengadilan" class="form-control"
                    value="<?= htmlspecialchars($_POST['asal_pengadilan'] ?? '') ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Nomor Perkara Tk1</label>
            <input type="text" name="nomor_perkara_tk1" class="form-control"
                value="<?= htmlspecialchars($_POST['nomor_perkara_tk1'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label>Parent</label>
            <select name="parent" class="form-select">
                <option value="">-- Pilih Parent --</option>
                <?php
                $resultParent = $conn->query("SELECT parent_id, nama FROM jenis_perkara ORDER BY nama ASC");
                while ($row = $resultParent->fetch_assoc()) {
                    $selected = ($_POST['parent'] ?? '') == $row['parent_id'] ? "selected" : "";
                    echo "<option value='{$row['parent_id']}' $selected>{$row['parent_id']} - {$row['nama']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Klasifikasi</label>
            <select name="klasifikasi" class="form-select" required>
                <option value="">-- Pilih Klasifikasi --</option>
                <?php
                $result = $conn->query("SELECT nama FROM jenis_perkara ORDER BY nama ASC");
                while ($row = $result->fetch_assoc()) {
                    $selected = ($_POST['klasifikasi'] ?? '') == $row['nama'] ? "selected" : "";
                    echo "<option value='{$row['nama']}' $selected>{$row['nama']}</option>";
                }
                ?>
            </select>
        </div>


        <div class="mb-3">
            <label>Tgl Register Banding</label>
            <input type="date" name="tgl_register_banding" class="form-control"
                value="<?= htmlspecialchars($_POST['tgl_register_banding'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label>Nomor Perkara Banding</label>
            <input type="text" name="nomor_perkara_banding" class="form-control"
                value="<?= htmlspecialchars($_POST['nomor_perkara_banding'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label>Lama Proses (.. Hari)</label>
            <input type="text" name="lama_proses" class="form-control"
                value="<?= htmlspecialchars($_POST['lama_proses'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label>Status Perkara Tk Banding</label>
            <input type="text" name="status_perkara_tk_banding" class="form-control"
                value="<?= htmlspecialchars($_POST['status_perkara_tk_banding'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label>Pemberitahuan Putusan Banding</label>
            <input type="date" name="pemberitahuan_putusan_banding" class="form-control"
                value="<?= htmlspecialchars($_POST['pemberitahuan_putusan_banding'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label>Permohonan Kasasi</label>
            <input type="date" name="permohonan_kasasi" class="form-control"
                value="<?= htmlspecialchars($_POST['permohonan_kasasi'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label>Pengiriman Berkas Kasasi</label>
            <input type="date" name="pengiriman_berkas_kasasi" class="form-control"
                value="<?= htmlspecialchars($_POST['pengiriman_berkas_kasasi'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="Proses" <?= (($_POST['status'] ?? '') == 'Proses') ? 'selected' : '' ?>>Proses</option>
                <option value="Selesai" <?= (($_POST['status'] ?? '') == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                <option value="Ditolak" <?= (($_POST['status'] ?? '') == 'Ditolak') ? 'selected' : '' ?>>Ditolak</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="dashboard_user1.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
<?php include("../navbar/footer.php"); ?>