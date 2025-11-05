-- Migration untuk menambahkan kolom profil pada tabel users
-- Jalankan query ini di database MySQL

ALTER TABLE `users` 
ADD COLUMN `email` VARCHAR(100) NULL AFTER `role`,
ADD COLUMN `nama_lengkap` VARCHAR(100) NULL AFTER `email`,
ADD COLUMN `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`;

-- Update data existing users dengan email dan nama lengkap default (opsional)
UPDATE `users` SET 
    `email` = CONCAT(username, '@example.com'),
    `nama_lengkap` = CONCAT('User ', username)
WHERE `email` IS NULL;