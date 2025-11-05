<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - Simple</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h3>Daftar Akun Baru</h3>
                    </div>
                    <div class="card-body">
                        <?= form_open('auth/register_simple', ['class' => 'needs-validation', 'novalidate' => true]) ?>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap *</label>
                                <input type="text" name="nama_lengkap" class="form-control" required value="<?= set_value('nama_lengkap') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username *</label>
                                <input type="text" name="username" class="form-control" required value="<?= set_value('username') ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" name="email" class="form-control" required value="<?= set_value('email') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIP</label>
                                <input type="text" name="nip" class="form-control" value="<?= set_value('nip') ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Password *</label>
                                <input type="password" name="password" class="form-control" required minlength="6">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Konfirmasi Password *</label>
                                <input type="password" name="confirm_password" class="form-control" required minlength="6">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" value="<?= set_value('jabatan') ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success w-100">Daftar</button>
                            </div>
                            <div class="col-md-6">
                                <a href="<?= site_url('auth/login') ?>" class="btn btn-secondary w-100">Kembali</a>
                            </div>
                        </div>

                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        var password = form.querySelector('input[name="password"]').value;
                        var confirmPassword = form.querySelector('input[name="confirm_password"]').value;

                        if (password !== confirmPassword) {
                            event.preventDefault();
                            event.stopPropagation();

                            Swal.fire({
                                icon: 'error',
                                title: 'Password Tidak Cocok!',
                                text: 'Password dan konfirmasi password harus sama.'
                            });
                            return false;
                        }

                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // SweetAlert notifications
        <?php if (validation_errors()): ?>
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Valid!',
                html: '<?= str_replace(["\n", "\r"], "<br>", addslashes(validation_errors())) ?>'
            });
        <?php endif; ?>

        <?php if (isset($error)): ?>
            Swal.fire({
                icon: 'error',
                title: 'Registrasi Gagal!',
                text: '<?= addslashes($error) ?>'
            });
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= addslashes($this->session->flashdata('success')) ?>'
            }).then(() => {
                window.location.href = '<?= site_url('auth/login') ?>';
            });
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= addslashes($this->session->flashdata('error')) ?>'
            });
        <?php endif; ?>
    </script>
</body>

</html>
