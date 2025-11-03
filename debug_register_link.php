<!DOCTYPE html>
<html>

<head>
    <title>Debug Link Issue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light p-4">
    <div class="container">
        <h2>🐛 Debug: Tombol Daftar Issue</h2>

        <div class="alert alert-warning">
            <strong>Problem:</strong> Tombol "Daftar" tidak pindah ke halaman register.php
        </div>

        <!-- Test Manual Links -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Test Manual Links</h4>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="index.php/auth_simple/register" class="btn btn-primary btn-lg">
                        ✅ Test Link 1: index.php/auth_simple/register
                    </a>

                    <a href="http://localhost:8080/index.php/auth_simple/register" class="btn btn-success btn-lg">
                        ✅ Test Link 2: Full URL
                    </a>

                    <button onclick="window.location='index.php/auth_simple/register'" class="btn btn-info btn-lg">
                        ✅ Test Link 3: JavaScript redirect
                    </button>
                </div>
            </div>
        </div>

        <!-- Check Current URLs -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Current Configuration Check</h4>
            </div>
            <div class="card-body">
                <p><strong>Current Page:</strong> <?= $_SERVER['REQUEST_URI'] ?></p>
                <p><strong>Server Name:</strong> <?= $_SERVER['HTTP_HOST'] ?></p>
                <p><strong>Document Root:</strong> <?= $_SERVER['DOCUMENT_ROOT'] ?></p>

                <?php if (function_exists('base_url')): ?>
                    <p><strong>Base URL:</strong> <?= base_url() ?></p>
                    <p><strong>Site URL (register):</strong> <?= site_url('auth_simple/register') ?></p>
                <?php else: ?>
                    <p class="text-danger">⚠️ CodeIgniter functions not loaded</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Simulate Login Form Link -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Simulate Login Form Link</h4>
            </div>
            <div class="card-body">
                <div class="text-center border p-3">
                    <p>Simulasi link dari form login:</p>
                    <?php if (function_exists('site_url')): ?>
                        <a href="<?= site_url('auth_simple/register') ?>" class="text-decoration-none">
                            Belum punya akun? Daftar
                        </a>
                        <br><small class="text-muted">Generated URL: <?= site_url('auth_simple/register') ?></small>
                    <?php else: ?>
                        <a href="index.php/auth_simple/register" class="text-decoration-none">
                            Belum punya akun? Daftar (Manual Link)
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Check Controller -->
        <div class="card">
            <div class="card-header">
                <h4>Controller Check</h4>
            </div>
            <div class="card-body">
                <p>Cek apakah controller dan method ada:</p>
                <div class="d-grid gap-2">
                    <a href="index.php/auth_simple/test" class="btn btn-secondary">
                        🧪 Test auth_simple/test method
                    </a>
                    <a href="index.php/auth_simple" class="btn btn-secondary">
                        🏠 Test auth_simple default (index method)
                    </a>
                </div>
            </div>
        </div>

    </div>

    <script>
        console.log('Debug page loaded');
        console.log('Current location:', window.location.href);

        // Test if any script is preventing navigation
        document.addEventListener('click', function(e) {
            if (e.target.tagName === 'A') {
                console.log('Link clicked:', e.target.href);
                // Allow normal navigation
            }
        });
    </script>
</body>

</html>