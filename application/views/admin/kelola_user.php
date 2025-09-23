<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: ../public/index.php");
    exit();
}

$user = $_SESSION['user'];
if (!is_array($user) || $user['role'] != 'admin') {
    header("Location: dashboard_user.php");
    exit();
}

include_once("../config/database.php");

// === Proses Tambah User ===
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    $stmt->execute();

    header("Location: kelola_user.php");
    exit();
}

// === Proses Edit User ===
if (isset($_POST['edit_user'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $role = $_POST['role'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    if ($password) {
        $stmt = $conn->prepare("UPDATE users SET username=?, password=?, role=? WHERE id=?");
        $stmt->bind_param("sssi", $username, $password, $role, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username=?, role=? WHERE id=?");
        $stmt->bind_param("ssi", $username, $role, $id);
    }
    $stmt->execute();

    header("Location: kelola_user.php");
    exit();
}

// === Proses Hapus User ===
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: kelola_user.php");
    exit();
}

// === Ambil Semua User ===
$query = $conn->query("SELECT id, username, role FROM users ORDER BY id ASC");

include("header.php");
?>

<div class="container mt-4">
    <h2>Kelola User</h2>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">➕ Tambah User</button>

    <table class="table table-bordered table-striped">
        <thead class="table-primary text-center">
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            while ($row = $query->fetch_assoc()): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td class="text-center"><?= htmlspecialchars($row['role']) ?></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $row['id'] ?>">Edit</button>
                        <a href="kelola_user.php?delete=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus user ini?')" class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>

                <!-- Modal Edit User -->
                <div class="modal fade" id="editUserModal<?= $row['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($row['username']) ?>" required>
                                    </div>

                                    <div class="mb-3 position-relative">
                                        <label>Password (kosongkan jika tidak diubah)</label>
                                        <input type="password" id="password<?= $row['id'] ?>" name="password" class="form-control">
                                        <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-0 end-0 mt-1 me-1" onclick="togglePassword('password<?= $row['id'] ?>')">👁</button>
                                    </div>

                                    <div class="mb-3">
                                        <label>Role</label>
                                        <select name="role" class="form-select" required>
                                            <option value="admin" <?= $row['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                            <option value="user" <?= $row['role'] == 'user' ? 'selected' : '' ?>>User</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="edit_user" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-select" required>
                            <option value="admin">Admin</option>
                            <option value="user" selected>User</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add_user" class="btn btn-success">Tambah</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include("footer.php"); ?>