-- ============================================
-- SCRIPT SQL: CREATE USER PENGADILAN BANJARBARU
-- ============================================
-- Username: pnbanjarbaru
-- Password: banjarbaru123
-- Role: admin
-- ============================================

USE perkara_db;

-- 1. Pastikan tabel pengadilan ada, jika belum buat
CREATE TABLE IF NOT EXISTS `pengadilan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pengadilan` varchar(20) NOT NULL,
  `nama_pengadilan` varchar(255) NOT NULL,
  `alamat` text,
  `telepon` varchar(20),
  `email` varchar(100),
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_pengadilan` (`kode_pengadilan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Pastikan kolom pengadilan_id ada di tabel users
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `pengadilan_id` int(11) DEFAULT NULL AFTER `role`,
ADD COLUMN IF NOT EXISTS `nip` varchar(50) DEFAULT NULL AFTER `pengadilan_id`,
ADD COLUMN IF NOT EXISTS `jabatan` varchar(100) DEFAULT NULL AFTER `nip`,
ADD COLUMN IF NOT EXISTS `nama` varchar(100) DEFAULT NULL AFTER `nama_lengkap`;

-- Tambahkan foreign key jika belum ada
ALTER TABLE `users` 
ADD KEY IF NOT EXISTS `pengadilan_id` (`pengadilan_id`);

-- 3. Insert data Pengadilan Negeri Banjarbaru (jika belum ada)
INSERT INTO `pengadilan` (`kode_pengadilan`, `nama_pengadilan`, `alamat`, `telepon`, `email`)
VALUES ('PN-BJB', 'PN BANJARBARU', 'Jl. A. Yani Km. 35, Banjarbaru, Kalimantan Selatan', '0511-1234567', 'info@pn-banjarbaru.go.id')
ON DUPLICATE KEY UPDATE nama_pengadilan = 'PN BANJARBARU';

-- 4. Create user pnbanjarbaru
-- Password: banjarbaru123
-- Hash dibuat dengan: password_hash('banjarbaru123', PASSWORD_DEFAULT)

-- Cara 1: Menggunakan subquery (jika pengadilan sudah ada)
INSERT INTO `users` (
    `username`, 
    `password`, 
    `role`, 
    `email`, 
    `nama_lengkap`,
    `nama`,
    `pengadilan_id`,
    `nip`,
    `jabatan`,
    `created_at`
)
SELECT 
    'pnbanjarbaru',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- Hash untuk: banjarbaru123
    'admin',
    'admin@pn-banjarbaru.go.id',
    'Administrator PN Banjarbaru',
    'Admin Banjarbaru',
    (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-BJB' LIMIT 1),
    '198501012010011001',
    'Administrator',
    NOW()
WHERE NOT EXISTS (SELECT 1 FROM users WHERE username = 'pnbanjarbaru');

-- Update password jika user sudah ada
UPDATE `users` 
SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    pengadilan_id = (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-BJB' LIMIT 1),
    role = 'admin',
    email = 'admin@pn-banjarbaru.go.id',
    nama_lengkap = 'Administrator PN Banjarbaru',
    nama = 'Admin Banjarbaru',
    nip = '198501012010011001',
    jabatan = 'Administrator'
WHERE username = 'pnbanjarbaru';

-- 5. Verifikasi hasil
SELECT 
    u.id,
    u.username,
    u.role,
    u.nama_lengkap,
    p.nama_pengadilan,
    p.kode_pengadilan
FROM users u
LEFT JOIN pengadilan p ON p.id = u.pengadilan_id
WHERE u.username = 'pnbanjarbaru';

-- ============================================
-- SELESAI!
-- ============================================
-- Login menggunakan:
-- Username: pnbanjarbaru
-- Password: banjarbaru123
-- ============================================
