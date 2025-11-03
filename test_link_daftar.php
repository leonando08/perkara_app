<!DOCTYPE html>
<html>

<head>
    <title>Test Link Daftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h3>🔍 Test Link Daftar / Register</h3>
            </div>
            <div class="card-body">
                <h4>Test berbagai link ke halaman register:</h4>

                <div class="list-group mb-4">
                    <a href="index.php/auth_simple/register" class="list-group-item list-group-item-action">
                        <strong>1. Link Langsung:</strong> index.php/auth_simple/register
                    </a>

                    <a href="<?= site_url('auth_simple/register') ?>" class="list-group-item list-group-item-action">
                        <strong>2. Link dengan site_url():</strong> <?= site_url('auth_simple/register') ?>
                    </a>

                    <a href="http://localhost:8080/index.php/auth_simple/register" class="list-group-item list-group-item-action">
                        <strong>3. Link Absolute:</strong> http://localhost:8080/index.php/auth_simple/register
                    </a>
                </div>

                <h4>Test dari halaman login:</h4>
                <div class="alert alert-info">
                    <p><strong>Langkah untuk test:</strong></p>
                    <ol>
                        <li>Buka halaman login: <a href="index.php/auth_simple/login" target="_blank">index.php/auth_simple/login</a></li>
                        <li>Cari link "Belum punya akun? Daftar" di bagian bawah form</li>
                        <li>Klik link tersebut</li>
                        <li>Seharusnya redirect ke form registrasi</li>
                    </ol>
                </div>

                <h4>Debugging Info:</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Base URL:</strong></td>
                            <td><?= base_url() ?></td>
                        </tr>
                        <tr>
                            <td><strong>Site URL (auth_simple/register):</strong></td>
                            <td><?= site_url('auth_simple/register') ?></td>
                        </tr>
                        <tr>
                            <td><strong>Current URL:</strong></td>
                            <td><?= current_url() ?></td>
                        </tr>
                    </table>
                </div>

                <div class="alert alert-warning">
                    <h5>Possible Issues:</h5>
                    <ul>
                        <li>❓ JavaScript intercepting clicks</li>
                        <li>❓ Form submission preventing navigation</li>
                        <li>❓ Base URL configuration issue</li>
                        <li>❓ Controller method not found</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Test if JavaScript is interfering
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded, testing links...');

            const links = document.querySelectorAll('a[href*="register"]');
            links.forEach((link, index) => {
                console.log(`Link ${index + 1}: ${link.href}`);

                link.addEventListener('click', function(e) {
                    console.log(`Clicked link ${index + 1}: ${this.href}`);
                });
            });
        });
    </script>
</body>

</html>