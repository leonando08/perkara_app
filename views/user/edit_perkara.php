<?php
include_once("../../config/database.php");
include_once("../../models/Perkara.php");

// Cek apakah id dikirim
if (!isset($_GET['id'])) {
    header("Location: ../user/dashboard_user1.php");
    exit();
}

$perkaraModel = new Perkara($conn);
$id = $_GET['id'];
$perkara = $perkaraModel->getById($id);

$error = "";
$success = "";

// Proses form submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fields = [
        'asal_pengadilan',
        'nomor_perkara_tk1',
        'parent',
        'klasifikasi',
        'tgl_register_banding',
        'nomor_perkara_banding',
        'lama_proses',
        'status_perkara_tk_banding',
        'pemberitahuan_putusan_banding',
        'permohonan_kasasi',
        'pengiriman_berkas_kasasi',
        'status'
    ];

    $data = [];
    foreach ($fields as $field) {
        // untuk tanggal boleh kosong
        if (in_array($field, ['pemberitahuan_putusan_banding', 'permohonan_kasasi', 'pengiriman_berkas_kasasi'])) {
            $data[$field] = !empty($_POST[$field]) ? $_POST[$field] : null;
        } else {
            if (empty($_POST[$field])) {
                $error = "Semua kolom wajib diisi (kecuali tanggal kasasi/putusan boleh kosong).";
                break;
            }
            $data[$field] = $_POST[$field];
        }
    }

    if (empty($error)) {
        if ($perkaraModel->update($id, $data)) {
            $success = "Data berhasil diupdate!";
        } else {
            $error = "Gagal mengupdate data.";
        }
    }
}

include("../navbar/header.php");
?>

<div class="container mt-4">
    <h2>Edit Perkara</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alertBox">
            <?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="alertBox">
            <?= $success ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = "../user/dashboard_user1.php";
            }, 2000);
        </script>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>ID Perkara</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($perkara['id']) ?>" readonly>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Asal Pengadilan</label>
                <input type="text" name="asal_pengadilan" class="form-control"
                    value="<?= htmlspecialchars($_POST['asal_pengadilan'] ?? $perkara['asal_pengadilan']) ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Nomor Perkara Tk1</label>
            <input type="text" name="nomor_perkara_tk1" class="form-control"
                value="<?= htmlspecialchars($_POST['nomor_perkara_tk1'] ?? $perkara['nomor_perkara_tk1']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Parent</label>
            <input list="parentList" name="parent" class="form-control"
                placeholder="Ketik atau pilih parent"
                value="<?= htmlspecialchars($_POST['parent'] ?? $perkara['parent']) ?>" required>

            <datalist id="parentList">
                <?php
                $resultParent = $conn->query("SELECT parent_id, nama FROM jenis_perkara ORDER BY nama ASC");
                while ($row = $resultParent->fetch_assoc()) {
                    $value = $row['parent_id']; // angka parent_id
                    $label = $row['parent_id'] . " - " . $row['nama']; // tampil ID - Nama
                    echo "<option value='" . htmlspecialchars($value) . "' label='" . htmlspecialchars($label) . "'>";
                }
                ?>
            </datalist>
        </div>



        <div class="mb-3">
            <label>Klasifikasi</label>
            <input list="klasifikasiList" name="klasifikasi" class="form-control"
                placeholder="Pilih atau ketik klasifikasi"
                value="<?= htmlspecialchars($_POST['klasifikasi'] ?? $perkara['klasifikasi']) ?>" required>
            <datalist id="klasifikasiList">
                <?php
                $result = $conn->query("SELECT nama FROM jenis_perkara ORDER BY nama ASC");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['nama']) . "'>";
                }
                ?>
            </datalist>
        </div>

        <div class="mb-3">
            <label>Tgl Register Banding</label>
            <input type="date" name="tgl_register_banding" class="form-control"
                value="<?= htmlspecialchars($_POST['tgl_register_banding'] ?? $perkara['tgl_register_banding']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Nomor Perkara Banding</label>
            <input type="text" name="nomor_perkara_banding" class="form-control"
                value="<?= htmlspecialchars($_POST['nomor_perkara_banding'] ?? $perkara['nomor_perkara_banding']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Lama Proses</label>
            <input type="text" name="lama_proses" class="form-control"
                value="<?= htmlspecialchars($_POST['lama_proses'] ?? $perkara['lama_proses']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Status Perkara Tk Banding</label>
            <input type="text" name="status_perkara_tk_banding" class="form-control"
                value="<?= htmlspecialchars($_POST['status_perkara_tk_banding'] ?? $perkara['status_perkara_tk_banding']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Pemberitahuan Putusan Banding</label>
            <input type="date" name="pemberitahuan_putusan_banding" class="form-control"
                value="<?= htmlspecialchars($_POST['pemberitahuan_putusan_banding'] ?? $perkara['pemberitahuan_putusan_banding']) ?>">
        </div>

        <div class="mb-3">
            <label>Permohonan Kasasi</label>
            <input type="date" name="permohonan_kasasi" class="form-control"
                value="<?= htmlspecialchars($_POST['permohonan_kasasi'] ?? $perkara['permohonan_kasasi']) ?>">
        </div>

        <div class="mb-3">
            <label>Pengiriman Berkas Kasasi</label>
            <input type="date" name="pengiriman_berkas_kasasi" class="form-control"
                value="<?= htmlspecialchars($_POST['pengiriman_berkas_kasasi'] ?? $perkara['pengiriman_berkas_kasasi']) ?>">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="Proses" <?= (($_POST['status'] ?? $perkara['status']) == 'Proses') ? 'selected' : '' ?>>Proses</option>
                <option value="Selesai" <?= (($_POST['status'] ?? $perkara['status']) == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                <option value="Ditolak" <?= (($_POST['status'] ?? $perkara['status']) == 'Ditolak') ? 'selected' : '' ?>>Ditolak</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="../user/dashboard_user1.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script>
    setTimeout(function() {
        const alertBox = document.getElementById('alertBox');
        if (alertBox) {
            alertBox.classList.remove('show');
            alertBox.classList.add('hide');
        }
    }, 3000);
</script>

<?php include("../navbar/footer.php"); ?>