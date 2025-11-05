-- ============================================
-- QUICK FIX: Filter Data PN Banjarbaru
-- Jalankan script ini di phpMyAdmin untuk memperbaiki masalah
-- ============================================

USE perkara_db;

-- STEP 1: Tambah kolom pengadilan_id
ALTER TABLE `perkara_banding` 
ADD COLUMN IF NOT EXISTS `pengadilan_id` INT(11) NULL AFTER `id`,
ADD INDEX IF NOT EXISTS `idx_pengadilan_id` (`pengadilan_id`);

-- STEP 2: Update mapping untuk SEMUA 13 Pengadilan Negeri

-- 1. PN Banjarmasin
UPDATE `perkara_banding` SET pengadilan_id = (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-BJM' LIMIT 1)
WHERE asal_pengadilan LIKE '%BANJARMASIN%' AND (pengadilan_id IS NULL OR pengadilan_id = 0);

-- 2. PN Banjarbaru
UPDATE `perkara_banding` SET pengadilan_id = (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-BJB' LIMIT 1)
WHERE asal_pengadilan LIKE '%BANJARBARU%' AND (pengadilan_id IS NULL OR pengadilan_id = 0);

-- 3. PN Kandangan
UPDATE `perkara_banding` SET pengadilan_id = (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-KDG' LIMIT 1)
WHERE asal_pengadilan LIKE '%KANDANGAN%' AND (pengadilan_id IS NULL OR pengadilan_id = 0);

-- 4. PN Martapura
UPDATE `perkara_banding` SET pengadilan_id = (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-MTP' LIMIT 1)
WHERE asal_pengadilan LIKE '%MARTAPURA%' AND (pengadilan_id IS NULL OR pengadilan_id = 0);

-- 5. PN Kotabaru
UPDATE `perkara_banding` SET pengadilan_id = (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-KTB' LIMIT 1)
WHERE asal_pengadilan LIKE '%KOTABARU%' AND (pengadilan_id IS NULL OR pengadilan_id = 0);

-- 6. PN Barabai
UPDATE `perkara_banding` SET pengadilan_id = (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-BRB' LIMIT 1)
WHERE asal_pengadilan LIKE '%BARABAI%' AND (pengadilan_id IS NULL OR pengadilan_id = 0);

-- 7. PN Amuntai
UPDATE `perkara_banding` SET pengadilan_id = (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-AMT' LIMIT 1)
WHERE asal_pengadilan LIKE '%AMUNTAI%' AND (pengadilan_id IS NULL OR pengadilan_id = 0);

-- 8. PN Tanjung
UPDATE `perkara_banding` SET pengadilan_id = (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-TJG' LIMIT 1)
WHERE asal_pengadilan LIKE '%TANJUNG%' AND (pengadilan_id IS NULL OR pengadilan_id = 0);

-- 9. PN Rantau
UPDATE `perkara_banding` SET pengadilan_id = (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-RTU' LIMIT 1)
WHERE asal_pengadilan LIKE '%RANTAU%' AND (pengadilan_id IS NULL OR pengadilan_id = 0);

-- 10. PN Pelaihari
UPDATE `perkara_banding` SET pengadilan_id = (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-PLH' LIMIT 1)
WHERE asal_pengadilan LIKE '%PELAIHARI%' AND (pengadilan_id IS NULL OR pengadilan_id = 0);

-- 11. PN Marabahan
UPDATE `perkara_banding` SET pengadilan_id = (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-MRH' LIMIT 1)
WHERE asal_pengadilan LIKE '%MARABAHAN%' AND (pengadilan_id IS NULL OR pengadilan_id = 0);

-- 12. PN Batulicin
UPDATE `perkara_banding` SET pengadilan_id = (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-BTL' LIMIT 1)
WHERE asal_pengadilan LIKE '%BATULICIN%' AND (pengadilan_id IS NULL OR pengadilan_id = 0);

-- 13. PN Paringin
UPDATE `perkara_banding` SET pengadilan_id = (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PN-PRG' LIMIT 1)
WHERE asal_pengadilan LIKE '%PARINGIN%' AND (pengadilan_id IS NULL OR pengadilan_id = 0);

-- STEP 3: Update mapping untuk Pengadilan Tinggi
UPDATE `perkara_banding` SET pengadilan_id = (SELECT id FROM pengadilan WHERE kode_pengadilan = 'PT-BJM' LIMIT 1)
WHERE asal_pengadilan LIKE '%TINGGI%' AND (pengadilan_id IS NULL OR pengadilan_id = 0);

-- STEP 4: Verifikasi hasil
SELECT '=== VERIFIKASI MAPPING ===' as Info;

SELECT 
    p.nama_pengadilan as 'Nama Pengadilan',
    COUNT(pb.id) as 'Jumlah Perkara'
FROM pengadilan p
LEFT JOIN perkara_banding pb ON pb.pengadilan_id = p.id
GROUP BY p.id, p.nama_pengadilan
ORDER BY p.nama_pengadilan;

-- STEP 5: Cek data yang belum ter-mapping
SELECT '=== DATA BELUM TER-MAPPING ===' as Info;

SELECT 
    COUNT(*) as 'Total Data',
    asal_pengadilan as 'Asal Pengadilan'
FROM perkara_banding
WHERE pengadilan_id IS NULL OR pengadilan_id = 0
GROUP BY asal_pengadilan;

-- DONE! Sekarang logout dan login lagi untuk test.
