-- =====================================================
-- QUICK TEST - Update User untuk Testing Login
-- =====================================================
-- Jalankan script ini SETELAH migration_add_pengadilan.sql

-- 1. Update user admin1 dengan pengadilan Banjarmasin
UPDATE users 
SET pengadilan_id = 1, 
    nama_lengkap = 'Super Admin',
    email = 'admin1@gmail.com',
    nip = '199001012010011001',
    jabatan = 'Administrator Sistem',
    telepon = '0511-3304808'
WHERE username = 'admin1';

-- 2. Update user biasa dengan pengadilan Martapura  
UPDATE users 
SET pengadilan_id = 2, 
    nama_lengkap = 'John Doe',
    email = 'user@example.com',
    nip = '199102022012012002',
    jabatan = 'Panitera Muda',
    telepon = '0511-4772225'
WHERE username = 'user';

-- 3. Update admin2 dengan pengadilan Paringin
UPDATE users 
SET pengadilan_id = 4, 
    nama_lengkap = 'Ahmad Fauzi',
    email = 'admin2@example.com',
    nip = '198905052009051001',
    jabatan = 'Kepala Sub Bagian',
    telepon = '0526-2021012'
WHERE username = 'admin2';

-- 4. Cek hasil update
SELECT 
    u.id,
    u.username,
    u.nama_lengkap,
    u.role,
    u.nip,
    u.jabatan,
    p.nama_pengadilan,
    p.kode_pengadilan
FROM users u
LEFT JOIN pengadilan p ON u.pengadilan_id = p.id
ORDER BY u.id;

-- =====================================================
-- Expected Output:
-- =====================================================
-- | id | username | nama_lengkap    | role  | nip            | jabatan              | nama_pengadilan            | kode_pengadilan |
-- |----|----------|-----------------|-------|----------------|----------------------|----------------------------|-----------------|
-- | 3  | admin1   | Super Admin     | admin | 199001012...   | Administrator Sistem | Pengadilan Negeri Banjarmasin | PN-BJM       |
-- | 4  | user     | John Doe        | user  | 199102022...   | Panitera Muda        | Pengadilan Negeri Martapura   | PN-MTP       |
-- | 6  | admin2   | Ahmad Fauzi     | admin | 198905052...   | Kepala Sub Bagian    | Pengadilan Negeri Paringin    | PN-PRN       |
-- =====================================================
