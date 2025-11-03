-- Migration untuk update tabel users - Simple Registration Fields
-- Date: 2025-11-03
-- Description: Update tabel users untuk registrasi sederhana (username, email, password, pengadilan)

USE perkara_db;

-- Cek struktur tabel users yang ada
DESCRIBE users;

-- Tambahkan kolom pengadilan_id jika belum ada
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS pengadilan_id INT(11) NULL AFTER role,
ADD INDEX idx_pengadilan_id (pengadilan_id);

-- Pastikan kolom yang diperlukan ada dengan struktur yang benar
ALTER TABLE users 
MODIFY COLUMN username VARCHAR(50) NOT NULL UNIQUE,
MODIFY COLUMN email VARCHAR(100) NOT NULL UNIQUE,
MODIFY COLUMN password VARCHAR(255) NOT NULL,
MODIFY COLUMN role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
MODIFY COLUMN aktif ENUM('Y', 'N') NOT NULL DEFAULT 'Y';

-- Buat foreign key constraint ke tabel pengadilan (jika tabel pengadilan ada)
SET @table_exists = (SELECT COUNT(*) FROM information_schema.tables 
                    WHERE table_schema = 'perkara_db' AND table_name = 'pengadilan');

SET @sql = IF(@table_exists > 0,
    'ALTER TABLE users ADD CONSTRAINT fk_users_pengadilan FOREIGN KEY (pengadilan_id) REFERENCES pengadilan(id) ON DELETE SET NULL ON UPDATE CASCADE',
    'SELECT "Tabel pengadilan tidak ditemukan, skip foreign key constraint" as message'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Buat index untuk performance
CREATE INDEX IF NOT EXISTS idx_users_username ON users(username);
CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);
CREATE INDEX IF NOT EXISTS idx_users_aktif ON users(aktif);

-- Update existing data jika ada
UPDATE users SET aktif = 'Y' WHERE aktif IS NULL;
UPDATE users SET role = 'user' WHERE role IS NULL;

-- Tampilkan struktur tabel yang sudah diupdate
DESCRIBE users;

SELECT 'Tabel users berhasil diupdate untuk registrasi sederhana!' as status;