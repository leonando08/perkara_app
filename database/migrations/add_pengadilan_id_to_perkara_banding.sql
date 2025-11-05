-- ============================================
-- MIGRATION: Add pengadilan_id to perkara_banding
-- Tujuan: Memperbaiki filter data berdasarkan pengadilan
-- ============================================

USE perkara_db;

-- 1. Tambahkan kolom pengadilan_id jika belum ada
ALTER TABLE `perkara_banding` 
ADD COLUMN IF NOT EXISTS `pengadilan_id` INT(11) NULL AFTER `id`,
ADD INDEX IF NOT EXISTS `idx_pengadilan_id` (`pengadilan_id`);

-- 2. Update pengadilan_id berdasarkan asal_pengadilan yang ada
-- Mapping untuk SEMUA 13 Pengadilan Negeri di Kalimantan Selatan

-- 1. PN Banjarmasin (PN-BJM)
UPDATE `perkara_banding` pb
LEFT JOIN `pengadilan` p ON p.kode_pengadilan = 'PN-BJM'
SET pb.pengadilan_id = p.id
WHERE pb.asal_pengadilan LIKE '%BANJARMASIN%' AND pb.pengadilan_id IS NULL;

-- 2. PN Banjarbaru (PN-BJB)
UPDATE `perkara_banding` pb
LEFT JOIN `pengadilan` p ON p.kode_pengadilan = 'PN-BJB'
SET pb.pengadilan_id = p.id
WHERE pb.asal_pengadilan LIKE '%BANJARBARU%' AND pb.pengadilan_id IS NULL;

-- 3. PN Kandangan (PN-KDG)
UPDATE `perkara_banding` pb
LEFT JOIN `pengadilan` p ON p.kode_pengadilan = 'PN-KDG'
SET pb.pengadilan_id = p.id
WHERE pb.asal_pengadilan LIKE '%KANDANGAN%' AND pb.pengadilan_id IS NULL;

-- 4. PN Martapura (PN-MTP)
UPDATE `perkara_banding` pb
LEFT JOIN `pengadilan` p ON p.kode_pengadilan = 'PN-MTP'
SET pb.pengadilan_id = p.id
WHERE pb.asal_pengadilan LIKE '%MARTAPURA%' AND pb.pengadilan_id IS NULL;

-- 5. PN Kotabaru (PN-KTB)
UPDATE `perkara_banding` pb
LEFT JOIN `pengadilan` p ON p.kode_pengadilan = 'PN-KTB'
SET pb.pengadilan_id = p.id
WHERE pb.asal_pengadilan LIKE '%KOTABARU%' AND pb.pengadilan_id IS NULL;

-- 6. PN Barabai (PN-BRB)
UPDATE `perkara_banding` pb
LEFT JOIN `pengadilan` p ON p.kode_pengadilan = 'PN-BRB'
SET pb.pengadilan_id = p.id
WHERE pb.asal_pengadilan LIKE '%BARABAI%' AND pb.pengadilan_id IS NULL;

-- 7. PN Amuntai (PN-AMT)
UPDATE `perkara_banding` pb
LEFT JOIN `pengadilan` p ON p.kode_pengadilan = 'PN-AMT'
SET pb.pengadilan_id = p.id
WHERE pb.asal_pengadilan LIKE '%AMUNTAI%' AND pb.pengadilan_id IS NULL;

-- 8. PN Tanjung (PN-TJG)
UPDATE `perkara_banding` pb
LEFT JOIN `pengadilan` p ON p.kode_pengadilan = 'PN-TJG'
SET pb.pengadilan_id = p.id
WHERE pb.asal_pengadilan LIKE '%TANJUNG%' AND pb.pengadilan_id IS NULL;

-- 9. PN Rantau (PN-RTU)
UPDATE `perkara_banding` pb
LEFT JOIN `pengadilan` p ON p.kode_pengadilan = 'PN-RTU'
SET pb.pengadilan_id = p.id
WHERE pb.asal_pengadilan LIKE '%RANTAU%' AND pb.pengadilan_id IS NULL;

-- 10. PN Pelaihari (PN-PLH)
UPDATE `perkara_banding` pb
LEFT JOIN `pengadilan` p ON p.kode_pengadilan = 'PN-PLH'
SET pb.pengadilan_id = p.id
WHERE pb.asal_pengadilan LIKE '%PELAIHARI%' AND pb.pengadilan_id IS NULL;

-- 11. PN Marabahan (PN-MRH)
UPDATE `perkara_banding` pb
LEFT JOIN `pengadilan` p ON p.kode_pengadilan = 'PN-MRH'
SET pb.pengadilan_id = p.id
WHERE pb.asal_pengadilan LIKE '%MARABAHAN%' AND pb.pengadilan_id IS NULL;

-- 12. PN Batulicin (PN-BTL)
UPDATE `perkara_banding` pb
LEFT JOIN `pengadilan` p ON p.kode_pengadilan = 'PN-BTL'
SET pb.pengadilan_id = p.id
WHERE pb.asal_pengadilan LIKE '%BATULICIN%' AND pb.pengadilan_id IS NULL;

-- 13. PN Paringin (PN-PRG)
UPDATE `perkara_banding` pb
LEFT JOIN `pengadilan` p ON p.kode_pengadilan = 'PN-PRG'
SET pb.pengadilan_id = p.id
WHERE pb.asal_pengadilan LIKE '%PARINGIN%' AND pb.pengadilan_id IS NULL;

-- 3. Update pengadilan_id untuk Pengadilan Tinggi
UPDATE `perkara_banding` pb
LEFT JOIN `pengadilan` p ON p.kode_pengadilan = 'PT-BJM'
SET pb.pengadilan_id = p.id
WHERE pb.asal_pengadilan LIKE '%TINGGI%' AND pb.pengadilan_id IS NULL;

-- 4. Fallback: Update pengadilan_id untuk pengadilan lainnya (generic matching)
UPDATE `perkara_banding` pb
LEFT JOIN `pengadilan` p ON (
    pb.asal_pengadilan LIKE CONCAT('%', p.nama_pengadilan, '%')
    OR p.nama_pengadilan LIKE CONCAT('%', pb.asal_pengadilan, '%')
)
SET pb.pengadilan_id = p.id
WHERE pb.pengadilan_id IS NULL
AND p.id IS NOT NULL;

-- 5. Verifikasi hasil
SELECT 
    pb.id,
    pb.asal_pengadilan,
    pb.pengadilan_id,
    p.nama_pengadilan,
    p.kode_pengadilan
FROM perkara_banding pb
LEFT JOIN pengadilan p ON p.id = pb.pengadilan_id
ORDER BY pb.id DESC
LIMIT 20;

-- 6. Cek data yang belum ter-mapping
SELECT 
    COUNT(*) as total_unmapped,
    asal_pengadilan
FROM perkara_banding
WHERE pengadilan_id IS NULL
GROUP BY asal_pengadilan;

-- ============================================
-- SELESAI!
-- ============================================
-- Setelah migration ini, filter data akan menggunakan pengadilan_id
-- yang lebih akurat daripada nama_pengadilan
-- ============================================
