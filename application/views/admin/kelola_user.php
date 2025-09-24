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
            foreach ($users as $row): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td class="text-center"><?= htmlspecialchars($row['role']) ?></td>
                    <td class="text-center">
                        <!-- Tombol Edit -->
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $row['id'] ?>">Edit</button>

                        <!-- Tombol Hapus -->
                        <a href="<?= site_url('kelola_user/delete/' . $row['id']) ?>"
                            onclick="return confirm('Yakin ingin menghapus user ini?')"
                            class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>

                <!-- Modal Edit User -->
                <div class="modal fade" id="editUserModal<?= $row['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="POST" action="<?= site_url('kelola_user/edit/' . $row['id']) ?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control"
                                            value="<?= htmlspecialchars($row['username']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Password (kosongkan jika tidak diubah)</label>
                                        <input type="password" name="password" class="form-control">
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
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="<?= site_url('kelola_user/add') ?>">
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
                    <button type="submit" class="btn btn-success">Tambah</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>