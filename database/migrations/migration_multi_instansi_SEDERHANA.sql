-- ============================================
-- MIGRATION: MULTI-INSTANSI PENGADILAN (VERSI SEDERHANA)
-- ============================================
-- Tujuan: Memisahkan data per pengadilan dengan cara sederhana
-- Metode: Tambah kolom 'pengadilan' (VARCHAR) langsung di tabel users dan perkara_banding
-- 
-- Kelebihan:
-- - Lebih sederhana, tidak butuh tabel tambahan
-- - Cepat implementasi
-- - Mudah dipahami
-- ============================================

-- ============================================
-- STEP 1: Tambah kolom pengadilan di tabel users
-- ============================================
ALTER TABLE `users` 
ADD COLUMN `pengadilan` VARCHAR(100) NULL 
COMMENT 'Nama pengadilan tempat user bekerja (contoh: Pengadilan Negeri Banjarbaru)' 
AFTER `role`;

-- Buat index untuk performa query
ALTER TABLE `users` ADD INDEX `idx_pengadilan` (`pengadilan`);

-- ============================================
-- STEP 2: Tambah kolom pengadilan di tabel perkara_banding
-- ============================================
ALTER TABLE `perkara_banding` 
ADD COLUMN `pengadilan` VARCHAR(100) NULL 
COMMENT 'Nama pengadilan yang mengelola perkara ini' 
AFTER `id`;

-- Buat index untuk performa query
ALTER TABLE `perkara_banding` ADD INDEX `idx_pengadilan` (`pengadilan`);

-- ============================================
-- STEP 3: Set nilai default untuk data yang sudah ada
-- ============================================
-- CATATAN: Sesuaikan nama pengadilan dengan kebutuhan Anda!

-- Set pengadilan untuk users yang sudah ada
-- Contoh: Set semua user existing ke "Pengadilan Negeri Banjarbaru"
UPDATE `users` 
SET `pengadilan` = 'Pengadilan Negeri Banjarbaru' 
WHERE `pengadilan` IS NULL;

-- ATAU assign berdasarkan username pattern
-- UPDATE `users` SET `pengadilan` = 'Pengadilan Negeri Banjarmasin' WHERE `username` LIKE '%bjm%';
-- UPDATE `users` SET `pengadilan` = 'Pengadilan Negeri Martapura' WHERE `username` LIKE '%mtw%';

-- Set pengadilan untuk perkara yang sudah ada
-- Contoh: Set semua perkara existing ke "Pengadilan Negeri Banjarbaru"
UPDATE `perkara_banding` 
SET `pengadilan` = 'Pengadilan Negeri Banjarbaru' 
WHERE `pengadilan` IS NULL;

-- ATAU assign berdasarkan asal_pengadilan
-- UPDATE `perkara_banding` SET `pengadilan` = 'Pengadilan Negeri Banjarmasin' 
-- WHERE `asal_pengadilan` LIKE '%Banjarmasin%';

-- ============================================
-- STEP 4: Ubah enum role untuk tambah super_admin (OPSIONAL)
-- ============================================
-- Jika ingin ada role super_admin yang bisa lihat semua pengadilan

-- Cara aman mengubah enum:
ALTER TABLE `users` ADD COLUMN `role_new` enum('super_admin','admin','user') NOT NULL DEFAULT 'user' AFTER `role`;
UPDATE `users` SET `role_new` = `role`;
ALTER TABLE `users` DROP COLUMN `role`;
ALTER TABLE `users` CHANGE `role_new` `role` enum('super_admin','admin','user') NOT NULL DEFAULT 'user';

-- Buat user super admin (opsional)
-- Password: superadmin123 (WAJIB DIGANTI!)
INSERT INTO `users` (`username`, `password`, `role`, `pengadilan`, `email`, `nama_lengkap`) 
VALUES ('superadmin', '$2y$10$xKj8PqGJZ7gE9mVQKZnYJ.M9VFf6mVYn0xQNzJ3qWMgSCfPuKjq5W', 'super_admin', NULL, 'superadmin@example.com', 'Super Administrator')
ON DUPLICATE KEY UPDATE `role` = 'super_admin', `pengadilan` = NULL;

-- ============================================
-- VERIFIKASI
-- ============================================
-- Cek struktur tabel
DESCRIBE `users`;
DESCRIBE `perkara_banding`;

-- Cek data users
SELECT `id`, `username`, `role`, `pengadilan`, `email` FROM `users`;

-- Cek data perkara
SELECT `id`, `pengadilan`, `asal_pengadilan`, `nomor_perkara_tk1` FROM `perkara_banding` LIMIT 10;

-- Cek distribusi per pengadilan
SELECT `pengadilan`, COUNT(*) as jumlah_user FROM `users` GROUP BY `pengadilan`;
SELECT `pengadilan`, COUNT(*) as jumlah_perkara FROM `perkara_banding` GROUP BY `pengadilan`;

-- ============================================
-- ROLLBACK (jika diperlukan)
-- ============================================
-- JANGAN JALANKAN KECUALI INGIN MENGHAPUS SEMUA PERUBAHAN!
/*
-- Hapus kolom pengadilan
ALTER TABLE `perkara_banding` DROP INDEX `idx_pengadilan`;
ALTER TABLE `perkara_banding` DROP COLUMN `pengadilan`;

ALTER TABLE `users` DROP INDEX `idx_pengadilan`;
ALTER TABLE `users` DROP COLUMN `pengadilan`;

-- Kembalikan role ke enum lama (jika sudah diubah)
ALTER TABLE `users` ADD COLUMN `role_temp` enum('admin','user') NOT NULL DEFAULT 'user' AFTER `role`;
UPDATE `users` SET `role_temp` = IF(`role` = 'super_admin', 'admin', `role`);
ALTER TABLE `users` DROP COLUMN `role`;
ALTER TABLE `users` CHANGE `role_temp` `role` enum('admin','user') NOT NULL DEFAULT 'user';

-- Hapus user super admin
DELETE FROM `users` WHERE `username` = 'superadmin';
*/

-- ============================================
-- CATATAN PENTING
-- ============================================
-- 1. Nama pengadilan HARUS konsisten (case-sensitive!)
--    Contoh BENAR: "Pengadilan Negeri Banjarbaru"
--    Contoh SALAH: "pengadilan negeri banjarbaru", "PN Banjarbaru", "Banjarbaru"
--
-- 2. Gunakan nama pengadilan yang sama persis di seluruh sistem
--
-- 3. Disarankan buat dropdown di form untuk menghindari typo
--
-- 4. Super admin (role='super_admin') tidak perlu pengadilan, set NULL
--    untuk bisa melihat data semua pengadilan
--
-- 5. Setelah migration, update Auth controller dan Perkara_model
-- ============================================

-- ============================================
-- DAFTAR NAMA PENGADILAN STANDAR (Contoh)
-- ============================================
-- Gunakan salah satu nama standar ini untuk konsistensi:
-- - Pengadilan Negeri Banjarbaru
-- - Pengadilan Negeri Banjarmasin
-- - Pengadilan Negeri Martapura
-- - Pengadilan Negeri Pelaihari
-- - Pengadilan Negeri Rantau
-- - Pengadilan Negeri Amuntai
-- - Pengadilan Negeri Marabahan
-- - Pengadilan Negeri Barabai
-- ============================================
