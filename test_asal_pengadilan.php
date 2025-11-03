<!DOCTYPE html>
<html>

<head>
    <title>Test Asal Pengadilan Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h3><i class="bi bi-check-circle"></i> Sistem Registrasi dengan Asal Pengadilan</h3>
                        <p class="mb-0">Updated sesuai dengan gambar yang diberikan</p>
                    </div>
                    <div class="card-body">

                        <!-- Form Fields Summary -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h4><i class="bi bi-clipboard-check"></i> Field Registrasi:</h4>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Username</span>
                                        <span class="badge bg-primary">Required</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Email</span>
                                        <span class="badge bg-primary">Required</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><strong>Asal Pengadilan</strong></span>
                                        <span class="badge bg-success">Updated!</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Password</span>
                                        <span class="badge bg-primary">Required</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h4><i class="bi bi-building"></i> Pengadilan Negeri (13 Total):</h4>
                                <div class="row">
                                    <div class="col-6">
                                        <ul class="list-unstyled small">
                                            <li>• PN Banjarmasin</li>
                                            <li>• PN Kandangan</li>
                                            <li>• PN Martapura</li>
                                            <li>• PN Kotabaru</li>
                                            <li>• PN Barabai</li>
                                            <li>• PN Amuntai</li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <ul class="list-unstyled small">
                                            <li>• PN Tanjung</li>
                                            <li>• PN Rantau</li>
                                            <li>• PN Pelaihari</li>
                                            <li>• PN Marabahan</li>
                                            <li>• PN Banjarbaru</li>
                                            <li>• PN Batulicin</li>
                                            <li>• PN Paringin</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <a href="index.php/auth_simple/register" class="btn btn-success btn-lg w-100">
                                    <i class="bi bi-person-plus"></i> Test Form Registrasi
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="index.php/auth_simple/login" class="btn btn-primary btn-lg w-100">
                                    <i class="bi bi-box-arrow-in-right"></i> Test Login
                                </a>
                            </div>
                        </div>

                        <!-- Database Actions -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <a href="insert_pengadilan_data.php" class="btn btn-warning w-100">
                                    <i class="bi bi-database-check"></i> Verify Pengadilan Data
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="run_simple_migration.php" class="btn btn-info w-100">
                                    <i class="bi bi-gear"></i> Check Migration
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="index.php/auth_simple/test" class="btn btn-secondary w-100">
                                    <i class="bi bi-bug"></i> Test Connection
                                </a>
                            </div>
                        </div>

                        <!-- Sample Test Data -->
                        <div class="alert alert-info">
                            <h5><i class="bi bi-info-circle"></i> Sample Test Data:</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Username:</strong> userbanjarbaru<br>
                                    <strong>Email:</strong> user@banjarbaru.com
                                </div>
                                <div class="col-md-6">
                                    <strong>Password:</strong> password123<br>
                                    <strong>Asal Pengadilan:</strong> PN Banjarbaru
                                </div>
                            </div>
                        </div>

                        <!-- Changes Made -->
                        <div class="alert alert-success">
                            <h5><i class="bi bi-check-all"></i> Perubahan yang Telah Dilakukan:</h5>
                            <ul class="mb-0">
                                <li>✅ Label "Nama Pengadilan" → "Asal Pengadilan"</li>
                                <li>✅ Placeholder "Pilih Pengadilan" → "Pilih Asal Pengadilan"</li>
                                <li>✅ Data pengadilan diisi sesuai gambar (13 PN di Kalsel)</li>
                                <li>✅ Validation message updated untuk "Asal Pengadilan"</li>
                                <li>✅ Session flash message include "Asal: [Pengadilan]"</li>
                            </ul>
                        </div>

                        <!-- Database Structure -->
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6><i class="bi bi-table"></i> Database Structure:</h6>
                                <code style="font-size: 0.9em;">
                                    users: username, email, password, pengadilan_id, role, aktif<br>
                                    pengadilan: id, kode, nama_pengadilan, created_at
                                </code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto refresh pengadilan count
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Asal Pengadilan system ready!');
        });
    </script>
</body>

</html>