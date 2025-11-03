<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="content-card mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">
                        <i class="fas fa-code me-2"></i>
                        Generate SQL Standardisasi
                    </h4>
                    <p class="text-muted mb-0">Generate script SQL untuk menyeragamkan nama pengadilan</p>
                </div>
                <a href="<?= site_url('kelola_pengadilan'); ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Informasi -->
        <div class="alert alert-info">
            <div class="d-flex align-items-start">
                <i class="fas fa-info-circle me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <h5 class="alert-heading mb-2">Cara Menggunakan:</h5>
                    <ol class="mb-0">
                        <li>Review daftar nama pengadilan saat ini dan standar yang direkomendasikan</li>
                        <li>Edit nama standar sesuai kebutuhan jika perlu</li>
                        <li>Klik "Generate SQL" untuk membuat script UPDATE</li>
                        <li>Copy SQL script dan eksekusi di database atau simpan untuk backup</li>
                        <li><strong>PENTING:</strong> Backup database sebelum eksekusi SQL!</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Form Mapping -->
        <div class="content-card mb-4">
            <h5 class="mb-3">
                <i class="fas fa-table me-2"></i>
                Mapping Nama Pengadilan
            </h5>

            <form id="mappingForm">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th width="5%">No</th>
                                <th width="35%">Nama Saat Ini</th>
                                <th width="35%">Nama Standar (Edit Jika Perlu)</th>
                                <th width="15%">User</th>
                                <th width="10%">Perkara</th>
                            </tr>
                        </thead>
                        <tbody id="mappingTableBody">
                            <?php if (empty($pengadilan_list)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data pengadilan</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1;
                                foreach ($pengadilan_list as $pengadilan): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($pengadilan->nama_pengadilan); ?></strong>
                                            <input type="hidden" class="nama-lama" value="<?= htmlspecialchars($pengadilan->nama_pengadilan); ?>">
                                        </td>
                                        <td>
                                            <input type="text"
                                                class="form-control nama-baru"
                                                value="<?= htmlspecialchars($pengadilan->nama_pengadilan); ?>"
                                                data-original="<?= htmlspecialchars($pengadilan->nama_pengadilan); ?>">
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary"><?= $pengadilan->jumlah_user; ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info"><?= $pengadilan->jumlah_perkara; ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <button type="button" class="btn btn-primary" onclick="generateSQL()">
                        <i class="fas fa-magic me-1"></i> Generate SQL
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">
                        <i class="fas fa-undo me-1"></i> Reset ke Original
                    </button>
                    <button type="button" class="btn btn-success" onclick="applyStandardNaming()">
                        <i class="fas fa-check me-1"></i> Gunakan Standar PN
                    </button>
                </div>
            </form>
        </div>

        <!-- SQL Output -->
        <div class="content-card" id="sqlOutputCard" style="display: none;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="fas fa-file-code me-2"></i>
                    Generated SQL Script
                </h5>
                <div>
                    <button class="btn btn-success btn-sm" onclick="copySQL()">
                        <i class="fas fa-copy me-1"></i> Copy to Clipboard
                    </button>
                    <button class="btn btn-info btn-sm" onclick="downloadSQL()">
                        <i class="fas fa-download me-1"></i> Download SQL
                    </button>
                </div>
            </div>

            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>PERINGATAN:</strong> Backup database Anda sebelum menjalankan script ini!
            </div>

            <div class="position-relative">
                <pre class="sql-output" id="sqlOutput"><code class="language-sql"></code></pre>
            </div>

            <div class="mt-3">
                <h6>Statistik Perubahan:</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="stat-box">
                            <div class="stat-value" id="statTotalChanges">0</div>
                            <div class="stat-label">Total Perubahan</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box">
                            <div class="stat-value" id="statTotalUsers">0</div>
                            <div class="stat-label">Users Terpengaruh</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box">
                            <div class="stat-value" id="statTotalPerkara">0</div>
                            <div class="stat-label">Perkara Terpengaruh</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nama Standar Reference -->
        <div class="content-card mt-4">
            <h5 class="mb-3">
                <i class="fas fa-book me-2"></i>
                Panduan Penamaan Standar
            </h5>
            <div class="row">
                <div class="col-md-6">
                    <h6>Format Standar:</h6>
                    <ul>
                        <li><code>Pengadilan Negeri [Nama Kota]</code></li>
                        <li>Contoh: <strong>Pengadilan Negeri Banjarbaru</strong></li>
                        <li>Contoh: <strong>Pengadilan Negeri Banjarmasin</strong></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Aturan Penulisan:</h6>
                    <ul>
                        <li>Huruf awal setiap kata <strong>kapital</strong></li>
                        <li>Tidak menggunakan singkatan (hindari "PN")</li>
                        <li>Konsisten untuk semua nama</li>
                        <li>Hindari spasi ganda atau karakter khusus</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .sql-output {
        background-color: #2d3748;
        color: #e2e8f0;
        padding: 1.5rem;
        border-radius: 8px;
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
        max-height: 500px;
        overflow-y: auto;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .sql-output code {
        color: #e2e8f0;
    }

    .stat-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 8px;
        text-align: center;
    }

    .stat-box .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-box .stat-label {
        font-size: 0.875rem;
        opacity: 0.9;
    }

    .nama-baru:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function generateSQL() {
        const rows = document.querySelectorAll('#mappingTableBody tr');
        let sql = "-- Script Standardisasi Nama Pengadilan\n";
        sql += "-- Generated: " + new Date().toLocaleString('id-ID') + "\n";
        sql += "-- PENTING: Backup database sebelum eksekusi!\n\n";
        sql += "START TRANSACTION;\n\n";

        let totalChanges = 0;
        let totalUsers = 0;
        let totalPerkara = 0;

        rows.forEach((row, index) => {
            const namaLama = row.querySelector('.nama-lama')?.value;
            const namaBaru = row.querySelector('.nama-baru')?.value;
            const jumlahUser = parseInt(row.querySelector('.badge.bg-primary')?.textContent) || 0;
            const jumlahPerkara = parseInt(row.querySelector('.badge.bg-info')?.textContent) || 0;

            if (namaLama && namaBaru && namaLama !== namaBaru) {
                sql += `-- Update #${totalChanges + 1}: ${namaLama} → ${namaBaru}\n`;
                sql += `-- Affected: ${jumlahUser} users, ${jumlahPerkara} perkara\n`;
                sql += `UPDATE users SET pengadilan = '${escapeSQL(namaBaru)}' WHERE pengadilan = '${escapeSQL(namaLama)}';\n`;
                sql += `UPDATE perkara_banding SET pengadilan = '${escapeSQL(namaBaru)}' WHERE pengadilan = '${escapeSQL(namaLama)}';\n\n`;

                totalChanges++;
                totalUsers += jumlahUser;
                totalPerkara += jumlahPerkara;
            }
        });

        if (totalChanges === 0) {
            Swal.fire({
                icon: 'info',
                title: 'Tidak Ada Perubahan',
                text: 'Tidak ada perubahan yang perlu dilakukan. Semua nama sudah standar.'
            });
            return;
        }

        sql += "COMMIT;\n\n";
        sql += `-- Summary:\n`;
        sql += `-- Total Changes: ${totalChanges}\n`;
        sql += `-- Total Users Affected: ${totalUsers}\n`;
        sql += `-- Total Perkara Affected: ${totalPerkara}\n`;

        document.getElementById('sqlOutput').textContent = sql;
        document.getElementById('sqlOutputCard').style.display = 'block';
        document.getElementById('statTotalChanges').textContent = totalChanges;
        document.getElementById('statTotalUsers').textContent = totalUsers;
        document.getElementById('statTotalPerkara').textContent = totalPerkara;

        // Scroll to output
        document.getElementById('sqlOutputCard').scrollIntoView({
            behavior: 'smooth'
        });
    }

    function escapeSQL(str) {
        return str.replace(/'/g, "''");
    }

    function copySQL() {
        const sqlText = document.getElementById('sqlOutput').textContent;
        navigator.clipboard.writeText(sqlText).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'SQL script berhasil disalin ke clipboard',
                timer: 2000,
                showConfirmButton: false
            });
        });
    }

    function downloadSQL() {
        const sqlText = document.getElementById('sqlOutput').textContent;
        const blob = new Blob([sqlText], {
            type: 'text/plain'
        });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'standardisasi_pengadilan_' + Date.now() + '.sql';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);

        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'SQL script berhasil didownload',
            timer: 2000,
            showConfirmButton: false
        });
    }

    function resetForm() {
        const inputs = document.querySelectorAll('.nama-baru');
        inputs.forEach(input => {
            input.value = input.dataset.original;
        });
        document.getElementById('sqlOutputCard').style.display = 'none';

        Swal.fire({
            icon: 'info',
            title: 'Reset',
            text: 'Form telah dikembalikan ke nilai original',
            timer: 2000,
            showConfirmButton: false
        });
    }

    function applyStandardNaming() {
        const inputs = document.querySelectorAll('.nama-baru');
        inputs.forEach(input => {
            let nama = input.value.trim();

            // Remove common prefixes
            nama = nama.replace(/^(PN|pn|Pn)\s*/i, '');

            // Standardize to "Pengadilan Negeri [City]"
            if (!nama.toLowerCase().startsWith('pengadilan negeri')) {
                nama = 'Pengadilan Negeri ' + nama;
            }

            // Capitalize each word
            nama = nama.split(' ')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
                .join(' ');

            input.value = nama;
        });

        Swal.fire({
            icon: 'success',
            title: 'Standarisasi Diterapkan',
            text: 'Format standar "Pengadilan Negeri [Kota]" telah diterapkan',
            timer: 2000,
            showConfirmButton: false
        });
    }
</script>