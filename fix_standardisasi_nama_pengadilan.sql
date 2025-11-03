-- Fix: Standardisasi Nama Pengadilan di Data Perkara
-- Date: 2025-11-03
-- Purpose: Menyamakan nama pengadilan di tabel perkara_banding dengan tabel pengadilan

USE perkara_db;

-- Update nama pengadilan agar sesuai dengan master data di tabel pengadilan
UPDATE perkara_banding SET asal_pengadilan = 'Pengadilan Negeri Banjarmasin' WHERE asal_pengadilan = 'BANJARMASIN';
UPDATE perkara_banding SET asal_pengadilan = 'Pengadilan Negeri Kandangan' WHERE asal_pengadilan = 'KANDANGAN';
UPDATE perkara_banding SET asal_pengadilan = 'Pengadilan Negeri Martapura' WHERE asal_pengadilan = 'PN MARTAPURA';
UPDATE perkara_banding SET asal_pengadilan = 'Pengadilan Negeri Kotabaru' WHERE asal_pengadilan = 'KOTABARU';
UPDATE perkara_banding SET asal_pengadilan = 'Pengadilan Negeri Paringin' WHERE asal_pengadilan = 'PARINGIN';
UPDATE perkara_banding SET asal_pengadilan = 'Pengadilan Negeri Barabai' WHERE asal_pengadilan = 'BARABAI';
UPDATE perkara_banding SET asal_pengadilan = 'Pengadilan Negeri Amuntai' WHERE asal_pengadilan = 'AMUNTAI';
UPDATE perkara_banding SET asal_pengadilan = 'Pengadilan Negeri Tanjung' WHERE asal_pengadilan = 'TANJUNG';
UPDATE perkara_banding SET asal_pengadilan = 'Pengadilan Negeri Rantau' WHERE asal_pengadilan = 'RANTAU';
UPDATE perkara_banding SET asal_pengadilan = 'Pengadilan Negeri Pelaihari' WHERE asal_pengadilan = 'PELAIHARI';
UPDATE perkara_banding SET asal_pengadilan = 'Pengadilan Negeri Marabahan' WHERE asal_pengadilan = 'MARABAHAN';
UPDATE perkara_banding SET asal_pengadilan = 'Pengadilan Negeri Banjarbaru' WHERE asal_pengadilan = 'BANJARBARU';
UPDATE perkara_banding SET asal_pengadilan = 'Pengadilan Negeri Batulicin' WHERE asal_pengadilan = 'BATULICIN';

-- Verifikasi hasil update
SELECT DISTINCT asal_pengadilan FROM perkara_banding ORDER BY asal_pengadilan;

-- Check match dengan tabel pengadilan
SELECT 
    pb.asal_pengadilan,
    COUNT(*) as total_perkara,
    p.nama_pengadilan as nama_di_master
FROM perkara_banding pb
LEFT JOIN pengadilan p ON pb.asal_pengadilan = p.nama_pengadilan
GROUP BY pb.asal_pengadilan, p.nama_pengadilan
ORDER BY pb.asal_pengadilan;
