# DOKUMENTASI FITUR MULTI-INSTANSI PENGADILAN

## Daftar Isi
1. [Gambaran Umum](#gambaran-umum)
2. [Perubahan Database](#perubahan-database)
3. [Cara Install](#cara-install)
4. [Struktur Role](#struktur-role)
5. [Cara Penggunaan](#cara-penggunaan)
6. [Keamanan Data](#keamanan-data)
7. [Troubleshooting](#troubleshooting)

---

## Gambaran Umum

Fitur multi-instansi pengadilan memungkinkan satu sistem aplikasi digunakan oleh beberapa pengadilan yang berbeda dengan data yang terpisah dan aman.

### Fitur Utama:
- ✅ **Isolasi Data**: Setiap pengadilan hanya bisa melihat dan mengelola data mereka sendiri
- ✅ **Master Data Pengadilan**: Tabel master untuk menyimpan informasi pengadilan
- ✅ **Role Super Admin**: Role khusus yang bisa melihat dan mengelola data semua pengadilan
- ✅ **Auto-Filter**: Semua query otomatis di-filter berdasarkan pengadilan_id user yang login
- ✅ **Session Management**: Informasi pengadilan disimpan di session setelah login

---

## Perubahan Database

### 1. Tabel Baru: `pengadilan`
```sql
CREATE TABLE `pengadilan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) NOT NULL,
  `nama_pengadilan` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `kepala_pengadilan` varchar(255) DEFAULT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'Y',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`)
);
```

### 2. Perubahan Tabel `users`
- Tambah kolom `pengadilan_id` (int, nullable, foreign key ke tabel pengadilan)
- Update enum role menjadi: `'super_admin', 'admin', 'user'`

### 3. Perubahan Tabel `perkara_banding`
- Tambah kolom `pengadilan_id` (int, nullable, foreign key ke tabel pengadilan)

---

## Cara Install

### Step 1: Backup Database
**PENTING**: Backup database sebelum menjalankan migration!

```bash
# Via mysqldump
mysqldump -u root -p perkara_db > backup_before_migration.sql

# Atau via PhpMyAdmin: Export → SQL
```

### Step 2: Jalankan Migration SQL
1. Buka file `migration_multi_instansi_pengadilan.sql`
2. Jalankan SQL via:
   - **PhpMyAdmin**: Import file SQL
   - **MySQL Command Line**:
     ```bash
     mysql -u root -p perkara_db < migration_multi_instansi_pengadilan.sql
     ```
   - **HeidiSQL/MySQL Workbench**: Load and execute file

### Step 3: Verifikasi Perubahan
Jalankan query berikut untuk memastikan migration berhasil:

```sql
-- Cek struktur tabel
DESCRIBE pengadilan;
DESCRIBE users;
DESCRIBE perkara_banding;

-- Cek data default
SELECT * FROM pengadilan;
SELECT id, username, role, pengadilan_id FROM users;
```

### Step 4: Assign Pengadilan ke User Existing
Update user yang sudah ada untuk assign ke pengadilan tertentu:

```sql
-- Contoh: Assign admin1 ke Pengadilan Negeri Banjarbaru (id=1)
UPDATE users SET pengadilan_id = 1 WHERE username = 'admin1';

-- Assign user ke Pengadilan Negeri Banjarmasin (id=2)
UPDATE users SET pengadilan_id = 2 WHERE username = 'user';
```

### Step 5: Assign Pengadilan ke Data Perkara Existing
```sql
-- Set semua perkara existing ke pengadilan default (misalnya BJB)
UPDATE perkara_banding SET pengadilan_id = 1 WHERE pengadilan_id IS NULL;

-- Atau assign berdasarkan asal_pengadilan
UPDATE perkara_banding 
SET pengadilan_id = 1 
WHERE asal_pengadilan LIKE '%Banjarbaru%';
```

---

## Struktur Role

### 1. **Super Admin** (`role = 'super_admin'`)
- **Hak Akses**: 
  - Bisa melihat dan mengelola data SEMUA pengadilan
  - Tidak terikat ke pengadilan tertentu (`pengadilan_id = NULL`)
  - Bisa mengelola master data pengadilan
  - Bisa membuat user untuk pengadilan manapun

- **Login Credentials** (default dari migration):
  - Username: `superadmin`
  - Password: `superadmin123` (WAJIB DIGANTI!)

### 2. **Admin** (`role = 'admin'`)
- **Hak Akses**:
  - Hanya bisa melihat dan mengelola data pengadilan mereka sendiri
  - Terikat ke satu pengadilan (`pengadilan_id` wajib diisi)
  - Bisa mengelola user di pengadilan mereka
  - Bisa mengelola semua perkara di pengadilan mereka

### 3. **User** (`role = 'user'`)
- **Hak Akses**:
  - Hanya bisa melihat dan mengelola data pengadilan mereka sendiri
  - Terikat ke satu pengadilan (`pengadilan_id` wajib diisi)
  - Hak akses terbatas (sesuai aturan existing)

---

## Cara Penggunaan

### A. Untuk Super Admin

#### 1. Login sebagai Super Admin
```
URL: http://localhost/Perkara_app/auth/login
Username: superadmin
Password: superadmin123
```

#### 2. Mengelola Master Pengadilan
Super admin bisa:
- Menambah pengadilan baru
- Edit data pengadilan
- Menonaktifkan pengadilan
- Melihat statistik per pengadilan

#### 3. Melihat Data Semua Pengadilan
Super admin akan melihat data dari SEMUA pengadilan saat membuka:
- Dashboard
- List perkara
- Laporan

### B. Untuk Admin/User Pengadilan

#### 1. Login Normal
Login dengan username dan password seperti biasa.

#### 2. Otomatis Filter Data
Setelah login, sistem akan otomatis:
- Menyimpan `pengadilan_id` di session
- Mem-filter semua data yang ditampilkan hanya untuk pengadilan user tersebut
- Mencegah akses ke data pengadilan lain

#### 3. Menambah Data Perkara
Saat menambah perkara baru, sistem otomatis:
- Mengisi `pengadilan_id` dengan ID pengadilan user
- User tidak perlu memilih pengadilan (auto-assigned)

---

## Keamanan Data

### 1. **Isolasi Data di Model Layer**
Semua query di `Perkara_model` sudah di-filter otomatis dengan method `apply_pengadilan_filter()`:

```php
private function apply_pengadilan_filter()
{
    // Super admin bisa melihat semua data
    if ($this->session->userdata('role') === 'super_admin') {
        return;
    }

    // User biasa dan admin hanya bisa melihat data pengadilan mereka
    $pengadilan_id = $this->session->userdata('pengadilan_id');
    if ($pengadilan_id) {
        $this->db->where('pb.pengadilan_id', $pengadilan_id);
    }
}
```

### 2. **Foreign Key Constraints**
- User tidak bisa dihapus jika masih ada relasi ke perkara
- Pengadilan tidak bisa dihapus jika masih ada user atau perkara terkait
- Cascade update untuk menjaga konsistensi data

### 3. **Session Validation**
Semua controller harus check session `pengadilan_id` sebelum akses data:

```php
// Di controller
$pengadilan_id = $this->session->userdata('pengadilan_id');
if (!$pengadilan_id && $this->session->userdata('role') !== 'super_admin') {
    // Handle error: user belum assigned ke pengadilan
    show_error('Anda belum terdaftar di pengadilan manapun.');
}
```

---

## Troubleshooting

### Error: "Foreign key constraint fails"
**Penyebab**: Ada data orphan (user/perkara tanpa pengadilan_id valid)

**Solusi**:
```sql
-- Cek data orphan di users
SELECT * FROM users WHERE pengadilan_id IS NOT NULL 
  AND pengadilan_id NOT IN (SELECT id FROM pengadilan);

-- Cek data orphan di perkara
SELECT * FROM perkara_banding WHERE pengadilan_id IS NOT NULL 
  AND pengadilan_id NOT IN (SELECT id FROM pengadilan);

-- Fix: Assign ke pengadilan default
UPDATE users SET pengadilan_id = 1 
WHERE pengadilan_id IS NOT NULL 
  AND pengadilan_id NOT IN (SELECT id FROM pengadilan);
```

### Error: "User tidak bisa login setelah migration"
**Penyebab**: User belum di-assign ke pengadilan

**Solusi**:
```sql
-- Check pengadilan_id user
SELECT id, username, role, pengadilan_id FROM users WHERE username = 'nama_user';

-- Assign ke pengadilan (kecuali super_admin)
UPDATE users SET pengadilan_id = 1 WHERE username = 'nama_user';
```

### Data tidak muncul setelah login
**Penyebab 1**: Data perkara belum di-assign pengadilan_id
```sql
UPDATE perkara_banding SET pengadilan_id = 1 WHERE pengadilan_id IS NULL;
```

**Penyebab 2**: Session `pengadilan_id` tidak ter-set
- Clear browser cache dan cookies
- Logout dan login ulang
- Check session di controller debug: `http://localhost/Perkara_app/auth/debug_session`

### Rollback Migration
Jika ada masalah dan perlu rollback:

```sql
-- HATI-HATI! Ini akan menghapus semua perubahan
-- Pastikan sudah backup database!

ALTER TABLE perkara_banding DROP FOREIGN KEY fk_perkara_pengadilan;
ALTER TABLE perkara_banding DROP COLUMN pengadilan_id;

ALTER TABLE users DROP FOREIGN KEY fk_users_pengadilan;
ALTER TABLE users DROP COLUMN pengadilan_id;

-- Kembalikan role ke enum lama
ALTER TABLE users ADD COLUMN role_temp enum('admin','user') NOT NULL DEFAULT 'user';
UPDATE users SET role_temp = IF(role = 'super_admin', 'admin', role);
ALTER TABLE users DROP COLUMN role;
ALTER TABLE users CHANGE role_temp role enum('admin','user') NOT NULL DEFAULT 'user';

DROP TABLE pengadilan;
```

---

## Contoh Skenario Penggunaan

### Skenario 1: Menambah Pengadilan Baru
1. Login sebagai `superadmin`
2. Masuk ke menu "Kelola Pengadilan"
3. Klik "Tambah Pengadilan"
4. Isi form:
   - Kode: `BJH` 
   - Nama: `Pengadilan Negeri Barabai`
   - Alamat, telepon, email, dll.
5. Submit → Pengadilan baru ter-create dengan ID auto-increment

### Skenario 2: Membuat User untuk Pengadilan Tertentu
1. Login sebagai `superadmin` atau admin pengadilan
2. Masuk ke menu "Kelola User"
3. Klik "Tambah User"
4. Isi form:
   - Username: `admin_bjh`
   - Password: `****`
   - Role: `admin`
   - **Pengadilan**: Pilih `Pengadilan Negeri Barabai`
5. Submit → User baru terdaftar dengan `pengadilan_id = 4`

### Skenario 3: Login dan Input Perkara
1. User `admin_bjh` login
2. Session akan berisi:
   ```php
   [
       'user_id' => 10,
       'username' => 'admin_bjh',
       'role' => 'admin',
       'pengadilan_id' => 4,
       'pengadilan_nama' => 'Pengadilan Negeri Barabai',
       'pengadilan_kode' => 'BJH'
   ]
   ```
3. Buka menu "Tambah Perkara"
4. Isi form perkara (tanpa field pengadilan, otomatis di-set)
5. Submit → Data perkara tersimpan dengan `pengadilan_id = 4`
6. User hanya akan melihat perkara dari Pengadilan Negeri Barabai saja

### Skenario 4: Super Admin Monitoring Semua Pengadilan
1. Login sebagai `superadmin`
2. Buka dashboard → Melihat statistik dari SEMUA pengadilan
3. Buka list perkara → Melihat perkara dari semua pengadilan (tidak di-filter)
4. Buka laporan → Generate laporan lintas pengadilan

---

## Update Berikutnya (Opsional)

### 1. **Halaman Kelola Pengadilan**
File yang perlu dibuat:
- `application/controllers/Kelola_pengadilan.php`
- `application/views/pengadilan/index.php`
- `application/views/pengadilan/form.php`

### 2. **Update Form Input Perkara**
- Untuk super admin: Tampilkan dropdown pilih pengadilan
- Untuk admin/user: Hide field pengadilan (auto-assigned)

### 3. **Dashboard Enhancement**
- Tambah widget statistik per pengadilan
- Grafik perbandingan antar pengadilan (khusus super admin)

### 4. **Laporan Multi-Pengadilan**
- Export laporan dengan filter pengadilan
- Laporan konsolidasi semua pengadilan

---

## Kontak Support
Jika ada pertanyaan atau masalah, hubungi tim developer:
- Email: support@example.com
- Phone: (0511) 1234567

---

**Versi Dokumentasi**: 1.0  
**Tanggal**: 2025-11-03  
**Author**: Sistem Informasi Perkara Development Team
