<!DOCTYPE html>
<html>

<head>
    <title>Test Simple Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h3>Test Simple Registration System</h3>
                    </div>
                    <div class="card-body">
                        <h4>Field yang Digunakan:</h4>
                        <ul class="list-group mb-4">
                            <li class="list-group-item">✅ <strong>Username</strong> - unique, alphanumeric, 4-50 char</li>
                            <li class="list-group-item">✅ <strong>Email</strong> - unique, valid email format</li>
                            <li class="list-group-item">✅ <strong>Password</strong> - minimum 6 characters</li>
                            <li class="list-group-item">✅ <strong>Pengadilan</strong> - dropdown selection</li>
                        </ul>

                        <div class="row">
                            <div class="col-md-6">
                                <a href="index.php/auth_simple/register" class="btn btn-primary btn-lg w-100 mb-2">
                                    📝 Test Registration Form
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="index.php/auth_simple/login" class="btn btn-success btn-lg w-100 mb-2">
                                    🔐 Go to Login
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <a href="run_simple_migration.php" class="btn btn-warning btn-lg w-100 mb-2">
                                    🔧 Check Database Migration
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="index.php/auth_simple/test" class="btn btn-info btn-lg w-100 mb-2">
                                    🧪 Test Database Connection
                                </a>
                            </div>
                        </div>

                        <hr>

                        <h5>Sample Test Data:</h5>
                        <div class="alert alert-info">
                            <strong>Username:</strong> testuser<br>
                            <strong>Email:</strong> test@example.com<br>
                            <strong>Password:</strong> password123<br>
                            <strong>Pengadilan:</strong> Pilih dari dropdown
                        </div>

                        <h5>Database Structure:</h5>
                        <div class="alert alert-secondary">
                            <code>users</code> table fields:<br>
                            • <strong>username</strong> VARCHAR(50) UNIQUE<br>
                            • <strong>email</strong> VARCHAR(100) UNIQUE<br>
                            • <strong>password</strong> VARCHAR(255)<br>
                            • <strong>pengadilan_id</strong> INT(11)<br>
                            • <strong>role</strong> ENUM('admin','user') DEFAULT 'user'<br>
                            • <strong>aktif</strong> ENUM('Y','N') DEFAULT 'Y'
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>