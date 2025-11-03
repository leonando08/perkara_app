-- Insert Data Pengadilan Negeri Kalimantan Selatan
-- File: insert_pengadilan_kalsel.sql
-- Created: 2025-11-03

USE perkara_db;

-- Hapus data lama jika ada (optional)
-- TRUNCATE TABLE pengadilan;

-- Insert 13 Pengadilan Negeri di Kalimantan Selatan
INSERT INTO pengadilan (kode_pengadilan, nama_pengadilan, alamat, telepon, email) VALUES
('PN-BJM', 'Pengadilan Negeri Banjarmasin', 'Jl. Brig Jend. Hasan Basri No.3, Banjarmasin', '0511-3304713', 'pn.banjarmasin@mahkamahagung.go.id'),
('PN-KDG', 'Pengadilan Negeri Kandangan', 'Jl. Brigjend Hasan Basri, Kandangan', '0517-21014', 'pn.kandangan@mahkamahagung.go.id'),
('PN-MTP', 'Pengadilan Negeri Martapura', 'Jl. Trikora, Martapura', '0511-4722234', 'pn.martapura@mahkamahagung.go.id'),
('PN-KTB', 'Pengadilan Negeri Kotabaru', 'Jl. H. Hasan Basri, Kotabaru', '0518-21015', 'pn.kotabaru@mahkamahagung.go.id'),
('PN-BRB', 'Pengadilan Negeri Barabai', 'Jl. Jenderal Sudirman, Barabai', '0517-41016', 'pn.barabai@mahkamahagung.go.id'),
('PN-AMT', 'Pengadilan Negeri Amuntai', 'Jl. Jenderal Ahmad Yani, Amuntai', '0527-61017', 'pn.amuntai@mahkamahagung.go.id'),
('PN-TJG', 'Pengadilan Negeri Tanjung', 'Jl. Pasar Baru, Tanjung', '0526-2021018', 'pn.tanjung@mahkamahagung.go.id'),
('PN-RTU', 'Pengadilan Negeri Rantau', 'Jl. A. Yani, Rantau', '0517-21019', 'pn.rantau@mahkamahagung.go.id'),
('PN-PLH', 'Pengadilan Negeri Pelaihari', 'Jl. Aneka Tambang, Pelaihari', '0512-21020', 'pn.pelaihari@mahkamahagung.go.id'),
('PN-MRH', 'Pengadilan Negeri Marabahan', 'Jl. Jenderal Sudirman, Marabahan', '0511-4722021', 'pn.marabahan@mahkamahagung.go.id'),
('PN-BJB', 'Pengadilan Negeri Banjarbaru', 'Jl. Jenderal Ahmad Yani Km 36, Banjarbaru', '0511-4772022', 'pn.banjarbaru@mahkamahagung.go.id'),
('PN-BTL', 'Pengadilan Negeri Batulicin', 'Jl. Trans Kalimantan, Batulicin', '0518-21023', 'pn.batulicin@mahkamahagung.go.id'),
('PN-PRG', 'Pengadilan Negeri Paringin', 'Jl. Pangeran Antasari, Paringin', '0526-2021024', 'pn.paringin@mahkamahagung.go.id')
ON DUPLICATE KEY UPDATE 
    nama_pengadilan = VALUES(nama_pengadilan),
    alamat = VALUES(alamat),
    telepon = VALUES(telepon),
    email = VALUES(email);

-- Verifikasi data
SELECT 
    id,
    kode_pengadilan,
    nama_pengadilan,
    alamat
FROM pengadilan
ORDER BY id;

-- Count total
SELECT COUNT(*) as total_pengadilan FROM pengadilan;
