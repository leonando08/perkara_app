-- ============================================
-- MIGRATION: MULTI-INSTANSI PENGADILAN
-- ============================================
-- Tujuan: Memisahkan data per pengadilan sehingga setiap user
-- hanya bisa melihat dan mengelola data pengadilan mereka sendiri
--
-- Fitur:
-- 1. Tabel master pengadilan
-- 2. Relasi user ke pengadilan tertentu
-- 3. Relasi data perkara ke pengadilan tertentu
-- 4. Role super_admin untuk mengelola semua pengadilan
-- ============================================

-- ============================================
-- STEP 1: Buat tabel master pengadilan
-- ============================================
CREATE TABLE IF NOT EXISTS `pengadilan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) NOT NULL COMMENT 'Kode unik pengadilan, contoh: BJB (Banjarbaru), BJM (Banjarmasin)',
  `nama_pengadilan` varchar(255) NOT NULL COMMENT 'Nama lengkap pengadilan',
  `alamat` text DEFAULT NULL COMMENT 'Alamat lengkap pengadilan',
  `telepon` varchar(50) DEFAULT NULL COMMENT 'Nomor telepon pengadilan',
  `email` varchar(100) DEFAULT NULL COMMENT 'Email pengadilan',
  `website` varchar(255) DEFAULT NULL COMMENT 'Website pengadilan',
  `kepala_pengadilan` varchar(255) DEFAULT NULL COMMENT 'Nama kepala pengadilan',
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT 'Status aktif pengadilan',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`),
  KEY `aktif` (`aktif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Master data pengadilan untuk multi-instansi';

-- Insert data pengadilan contoh
INSERT INTO `pengadilan` (`kode`, `nama_pengadilan`, `alamat`, `telepon`, `email`, `aktif`) VALUES
('BJB', 'Pengadilan Negeri Banjarbaru', 'Jl. Jenderal Sudirman No. 1, Banjarbaru', '(0511) 4772123', 'pn.banjarbaru@mahkamahagung.go.id', 'Y'),
('BJM', 'Pengadilan Negeri Banjarmasin', 'Jl. Sultan Adam No. 99, Banjarmasin', '(0511) 3354321', 'pn.banjarmasin@mahkamahagung.go.id', 'Y'),
('MTW', 'Pengadilan Negeri Martapura', 'Jl. Brigjend Hasan Basri, Martapura', '(0511) 4721234', 'pn.martapura@mahkamahagung.go.id', 'Y'),
('PLS', 'Pengadilan Negeri Pelaihari', 'Jl. Jenderal A. Yani KM 17, Pelaihari', '(0512) 2101234', 'pn.pelaihari@mahkamahagung.go.id', 'Y');

-- ============================================
-- STEP 2: Ubah role di tabel users untuk menambah super_admin
-- ============================================
-- Backup data role terlebih dahulu (opsional)
-- ALTER TABLE `users` MODIFY `role` enum('super_admin','admin','user') NOT NULL DEFAULT 'user';

-- Untuk keamanan, kita buat dengan cara yang lebih aman:
-- 1. Tambah kolom baru sementara
ALTER TABLE `users` ADD COLUMN `role_new` enum('super_admin','admin','user') NOT NULL DEFAULT 'user' AFTER `role`;

-- 2. Copy data dari role lama ke role baru
UPDATE `users` SET `role_new` = `role`;

-- 3. Hapus kolom lama
ALTER TABLE `users` DROP COLUMN `role`;

-- 4. Rename kolom baru menjadi role
ALTER TABLE `users` CHANGE `role_new` `role` enum('super_admin','admin','user') NOT NULL DEFAULT 'user';

-- ============================================
-- STEP 3: Tambahkan kolom pengadilan_id ke tabel users
-- ============================================
ALTER TABLE `users` 
ADD COLUMN `pengadilan_id` int(11) DEFAULT NULL COMMENT 'ID Pengadilan tempat user bekerja' AFTER `role`,
ADD KEY `pengadilan_id` (`pengadilan_id`),
ADD CONSTRAINT `fk_users_pengadilan` 
  FOREIGN KEY (`pengadilan_id`) 
  REFERENCES `pengadilan` (`id`) 
  ON DELETE RESTRICT 
  ON UPDATE CASCADE;

-- Set pengadilan_id untuk user yang sudah ada (sesuaikan dengan kebutuhan)
-- Contoh: Set semua user existing ke Pengadilan Negeri Banjarbaru
UPDATE `users` SET `pengadilan_id` = 1 WHERE `pengadilan_id` IS NULL;

-- Atau jika ingin assign berdasarkan username/kondisi tertentu:
-- UPDATE `users` SET `pengadilan_id` = 2 WHERE `username` LIKE '%bjm%';

-- ============================================
-- STEP 4: Cek apakah tabel perkara_banding ada dan tambahkan pengadilan_id
-- ============================================
-- Tambahkan kolom pengadilan_id ke tabel perkara_banding
ALTER TABLE `perkara_banding` 
ADD COLUMN `pengadilan_id` int(11) DEFAULT NULL COMMENT 'ID Pengadilan yang mengelola perkara ini' AFTER `id`,
ADD KEY `pengadilan_id` (`pengadilan_id`),
ADD CONSTRAINT `fk_perkara_pengadilan` 
  FOREIGN KEY (`pengadilan_id`) 
  REFERENCES `pengadilan` (`id`) 
  ON DELETE RESTRICT 
  ON UPDATE CASCADE;

-- Set pengadilan_id untuk data perkara yang sudah ada
-- Anda bisa set berdasarkan user yang membuat atau pengadilan default
UPDATE `perkara_banding` SET `pengadilan_id` = 1 WHERE `pengadilan_id` IS NULL;

-- ============================================
-- STEP 5: Buat user super admin (opsional)
-- ============================================
-- Password default: superadmin123 (HARUS DIGANTI setelah login pertama kali!)
-- Hash: $2y$10$xKj8PqGJZ7gE9mVQKZnYJ.M9VFf6mVYn0xQNzJ3qWMgSCfPuKjq5W
INSERT INTO `users` (`username`, `password`, `role`, `pengadilan_id`, `email`, `nama_lengkap`) VALUES
('superadmin', '$2y$10$xKj8PqGJZ7gE9mVQKZnYJ.M9VFf6mVYn0xQNzJ3qWMgSCfPuKjq5W', 'super_admin', NULL, 'superadmin@example.com', 'Super Administrator')
ON DUPLICATE KEY UPDATE `role` = 'super_admin';

-- ============================================
-- VERIFIKASI
-- ============================================
-- Cek struktur tabel
DESCRIBE `pengadilan`;
DESCRIBE `users`;
DESCRIBE `perkara_banding`;

-- Cek data
SELECT * FROM `pengadilan`;
SELECT `id`, `username`, `role`, `pengadilan_id`, `email` FROM `users`;

-- ============================================
-- ROLLBACK (jika diperlukan)
-- ============================================
-- JANGAN JALANKAN KECUALI INGIN MENGHAPUS SEMUA PERUBAHAN!
/*
ALTER TABLE `perkara_banding` DROP FOREIGN KEY `fk_perkara_pengadilan`;
ALTER TABLE `perkara_banding` DROP COLUMN `pengadilan_id`;

ALTER TABLE `users` DROP FOREIGN KEY `fk_users_pengadilan`;
ALTER TABLE `users` DROP COLUMN `pengadilan_id`;

-- Kembalikan role ke enum lama
ALTER TABLE `users` ADD COLUMN `role_temp` enum('admin','user') NOT NULL DEFAULT 'user' AFTER `role`;
UPDATE `users` SET `role_temp` = IF(`role` = 'super_admin', 'admin', `role`);
ALTER TABLE `users` DROP COLUMN `role`;
ALTER TABLE `users` CHANGE `role_temp` `role` enum('admin','user') NOT NULL DEFAULT 'user';

DROP TABLE IF EXISTS `pengadilan`;
*/

-- ============================================
-- CATATAN PENTING
-- ============================================
-- 1. Setelah migrasi, pastikan update semua query di model untuk include filter pengadilan_id
-- 2. Di session, simpan pengadilan_id saat login
-- 3. Super admin (role='super_admin') bisa melihat semua data dari semua pengadilan
-- 4. Admin dan user biasa hanya bisa melihat data pengadilan mereka sendiri
-- 5. Jangan lupa update controller Auth untuk set session pengadilan_id
-- ============================================
