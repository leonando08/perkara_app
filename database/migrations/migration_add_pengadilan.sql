-- ========================================
-- MIGRATION: Tambah Fitur Nama Pengadilan
-- Tanggal: 2025-11-03
-- ========================================

-- 1. Buat tabel pengadilan
CREATE TABLE IF NOT EXISTS `pengadilan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pengadilan` varchar(200) NOT NULL,
  `kode_pengadilan` varchar(50) DEFAULT NULL,
  `alamat` text,
  `telepon` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `aktif` enum('Y','N') DEFAULT 'Y',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nama_pengadilan` (`nama_pengadilan`),
  UNIQUE KEY `kode_pengadilan` (`kode_pengadilan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabel Master Pengadilan';

-- 2. Insert data pengadilan contoh
INSERT INTO `pengadilan` (`nama_pengadilan`, `kode_pengadilan`, `alamat`, `telepon`, `aktif`) VALUES
('Pengadilan Negeri Banjarmasin', 'PN-BJM', 'Jl. Brig Jend Hasan Basri No.3, Banjarmasin', '0511-3304808', 'Y'),
('Pengadilan Negeri Martapura', 'PN-MTP', 'Jl. A. Yani Km 38, Martapura', '0511-4772225', 'Y'),
('Pengadilan Negeri Kandangan', 'PN-KDG', 'Jl. Jend. Sudirman No.1, Kandangan', '0517-21011', 'Y'),
('Pengadilan Negeri Paringin', 'PN-PRN', 'Jl. Ir. P.M. Noor No.100, Paringin', '0526-2021012', 'Y'),
('Pengadilan Negeri Kotabaru', 'PN-KTB', 'Jl. H.M. Arsyad No.31, Kotabaru', '0518-21013', 'Y'),
('Pengadilan Tinggi Banjarmasin', 'PT-BJM', 'Jl. Lambung Mangkurat No.19, Banjarmasin', '0511-3305555', 'Y');

-- 3. Tambah kolom pengadilan_id ke tabel users
ALTER TABLE `users` 
ADD COLUMN `pengadilan_id` int(11) DEFAULT NULL AFTER `role`,
ADD COLUMN `nip` varchar(50) DEFAULT NULL AFTER `pengadilan_id`,
ADD COLUMN `jabatan` varchar(100) DEFAULT NULL AFTER `nip`,
ADD COLUMN `telepon` varchar(20) DEFAULT NULL AFTER `email`,
ADD KEY `fk_users_pengadilan` (`pengadilan_id`),
ADD CONSTRAINT `fk_users_pengadilan` FOREIGN KEY (`pengadilan_id`) REFERENCES `pengadilan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- 4. Update existing users dengan pengadilan default (opsional)
-- UPDATE `users` SET `pengadilan_id` = 1 WHERE `role` = 'user' AND `pengadilan_id` IS NULL;

-- ========================================
-- ROLLBACK (jika diperlukan):
-- ========================================
-- ALTER TABLE `users` DROP FOREIGN KEY `fk_users_pengadilan`;
-- ALTER TABLE `users` DROP COLUMN `pengadilan_id`, DROP COLUMN `nip`, DROP COLUMN `jabatan`, DROP COLUMN `telepon`;
-- DROP TABLE `pengadilan`;
