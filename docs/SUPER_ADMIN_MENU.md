# Menu Navigasi untuk Super Admin

## 🎯 Quick Access URLs

### Dashboard & Home
```
/admin/dashboard_admin          → Dashboard Super Admin
/                               → Homepage
```

### Kelola User
```
/kelola_user                    → Daftar semua user
/kelola_user/create             → Tambah user baru
/kelola_user/edit/{id}          → Edit user
/kelola_user/delete/{id}        → Hapus user
```

### Kelola Perkara
```
/perkara                        → Daftar semua perkara (all pengadilan)
/perkara/create                 → Tambah perkara baru
/perkara/detail/{id}            → Detail perkara
/perkara/update/{id}            → Edit perkara
/perkara/delete/{id}            → Hapus perkara
```

### Kelola Pengadilan ⭐ NEW!
```
/kelola_pengadilan              → Dashboard kelola pengadilan
/kelola_pengadilan/validasi     → Validasi konsistensi nama
/kelola_pengadilan/generate_sql → Generate SQL standarisasi
/kelola_pengadilan/export_json  → Export data JSON
/kelola_pengadilan/rename       → Rename pengadilan (POST)
/kelola_pengadilan/perbaiki     → Perbaiki inkonsistensi (POST)
/kelola_pengadilan/perbaiki_semua_otomatis → Auto-fix semua (GET)
```

### Laporan
```
/laporan                        → Laporan dan statistik
/laporan/print                  → Print laporan
/laporan/export_excel           → Export ke Excel
```

### Profile & Auth
```
/profile                        → Profile pengguna
/profile/edit                   → Edit profile
/profile/change_password        → Ganti password
/auth/logout                    → Logout
```

---

## 🔐 Access Control Matrix

| URL                              | Super Admin | Admin | User |
|----------------------------------|-------------|-------|------|
| `/admin/dashboard_admin`         | ✅          | ✅    | ❌   |
| `/user/dashboard_user`           | ✅          | ✅    | ✅   |
| `/kelola_user/*`                 | ✅          | ❌    | ❌   |
| `/kelola_pengadilan/*`           | ✅          | ❌    | ❌   |
| `/perkara` (all data)            | ✅          | ❌*   | ❌*  |
| `/perkara` (filtered)            | -           | ✅    | ✅   |
| `/laporan`                       | ✅          | ✅    | ✅   |
| `/profile/*`                     | ✅          | ✅    | ✅   |

*Admin dan User hanya melihat data pengadilan mereka sendiri

---

## 📋 Super Admin Task List

### Setup Awal Sistem

1. **Login sebagai Super Admin**
   - Username: `superadmin`
   - Password: `SuperAdmin123!`

2. **Kelola Nama Pengadilan**
   - Akses: `/kelola_pengadilan`
   - Validasi konsistensi nama
   - Standarisasi format nama

3. **Buat User Admin per Pengadilan**
   - Akses: `/kelola_user/create`
   - Role: `admin`
   - Assign pengadilan yang benar

4. **Buat User Biasa per Pengadilan**
   - Akses: `/kelola_user/create`
   - Role: `user`
   - Assign pengadilan yang benar

### Maintenance Rutin

#### Mingguan
- [ ] Check dashboard statistik
- [ ] Review user baru yang ditambahkan
- [ ] Check data tanpa pengadilan

#### Bulanan
- [ ] Validasi konsistensi nama pengadilan (`/kelola_pengadilan/validasi`)
- [ ] Export JSON untuk backup (`/kelola_pengadilan/export_json`)
- [ ] Review laporan per pengadilan

#### Triwulan
- [ ] Backup database lengkap
- [ ] Audit access log
- [ ] Review dan update dokumentasi

---

## 🛠️ Quick Actions

### Rename Pengadilan
```
1. Akses: /kelola_pengadilan
2. Klik tombol "Rename" pada baris pengadilan
3. Isi nama baru
4. Konfirmasi
```

### Fix Inkonsistensi Nama
```
1. Akses: /kelola_pengadilan/validasi
2. Review grup inkonsistensi
3. Pilih nama standar
4. Klik "Perbaiki Grup Ini"
   ATAU
   Klik "Perbaiki Semua Otomatis"
```

### Generate SQL Standarisasi
```
1. Akses: /kelola_pengadilan/generate_sql
2. Review mapping nama
3. Edit jika perlu
4. Klik "Generate SQL"
5. Copy atau Download SQL
```

### Export Data
```
1. Akses: /kelola_pengadilan/export_json
2. File JSON akan otomatis terdownload
```

### Tambah User Baru
```
1. Akses: /kelola_user/create
2. Isi form:
   - Username
   - Password
   - Role (super_admin/admin/user)
   - Pengadilan (PENTING: pilih yang sudah standar!)
3. Submit
```

### Reset Password User
```
1. Akses: /kelola_user
2. Cari user yang akan direset
3. Klik "Edit"
4. Isi password baru
5. Save
```

---

## 🎨 UI Components

### Dashboard Cards
```html
Statistik Cards:
- Total Pengadilan
- Total User Ter-assign
- Total Perkara Ter-assign
- Data Tanpa Pengadilan (warning jika > 0)
```

### Tables
```html
Tabel Pengadilan:
- No
- Nama Pengadilan
- Jumlah User (badge primary)
- Jumlah Perkara (badge info)
- Aksi (button rename)
```

### Validation Page
```html
Grup Inkonsistensi:
- Badge danger (grup number)
- Radio buttons untuk pilih nama standar
- Statistik per variant (user count, perkara count)
- Button "Perbaiki Grup Ini"
- Button "Perbaiki Semua Otomatis" (di bawah)
```

### SQL Generator
```html
Mapping Table:
- Nama Saat Ini (readonly)
- Nama Standar (editable input)
- User count (badge)
- Perkara count (badge)

Buttons:
- Generate SQL
- Reset ke Original
- Gunakan Standar PN (auto-format)

Output:
- SQL code block dengan syntax highlighting
- Copy to Clipboard button
- Download SQL button
- Statistik perubahan (total changes, users, perkara)
```

---

## 📊 Reports & Analytics

### Dashboard Stats
```
Total Pengadilan: 8
Total Users: 45
Total Perkara: 1,250
Data Tanpa Pengadilan: 5 (warning!)
```

### Per Pengadilan Breakdown
```
Pengadilan Negeri Banjarbaru
├── Users: 12
└── Perkara: 350

Pengadilan Negeri Banjarmasin
├── Users: 18
└── Perkara: 520
```

### Inconsistency Report
```
Grup Inkonsistensi Ditemukan: 3

Grup 1: "banjarbaru"
├── Pengadilan Negeri Banjarbaru (10 users, 200 perkara)
├── pengadilan negeri banjarbaru (2 users, 50 perkara)
└── PN Banjarbaru (5 users, 100 perkara)

Grup 2: "banjarmasin"
├── Pengadilan Negeri Banjarmasin (15 users, 400 perkara)
└── PN Banjarmasin (3 users, 120 perkara)
```

---

## 🔔 Notifications & Alerts

### Success Messages (Green)
```
✓ Berhasil mengubah nama pengadilan
✓ Berhasil memperbaiki 5 inkonsistensi
✓ SQL script berhasil disalin ke clipboard
✓ User berhasil ditambahkan
```

### Error Messages (Red)
```
✗ Gagal mengubah nama pengadilan
✗ Nama pengadilan baru sudah digunakan
✗ Akses ditolak! Hanya Super Admin yang dapat mengakses
```

### Warning Messages (Yellow)
```
⚠ 15 data tanpa pengadilan ditemukan
⚠ 3 grup inkonsistensi terdeteksi
⚠ Backup database sebelum menjalankan script SQL
```

### Info Messages (Blue)
```
ℹ Tidak ada inkonsistensi yang perlu diperbaiki
ℹ Tidak ada perubahan yang perlu dilakukan
ℹ Form telah dikembalikan ke nilai original
```

---

## 🚨 Emergency Actions

### Rollback Migration
```sql
-- Jika terjadi error, rollback dengan:
-- (Script ada di migration_multi_instansi_SEDERHANA.sql)

ALTER TABLE users DROP COLUMN pengadilan;
ALTER TABLE perkara_banding DROP COLUMN pengadilan;
ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'user') NOT NULL;
DELETE FROM users WHERE role = 'super_admin';
```

### Reset Pengadilan ke Default
```sql
-- Set semua user ke pengadilan default
UPDATE users 
SET pengadilan = 'Pengadilan Negeri Banjarbaru' 
WHERE pengadilan IS NULL AND role != 'super_admin';

-- Set semua perkara ke pengadilan default
UPDATE perkara_banding 
SET pengadilan = 'Pengadilan Negeri Banjarbaru' 
WHERE pengadilan IS NULL;
```

### Force Logout All Users
```sql
-- Hapus semua session (jika sistem pakai database session)
TRUNCATE TABLE ci_sessions;
```

### Recreate Super Admin
```sql
-- Jika super admin terhapus atau password lupa
INSERT INTO users (username, password, role, pengadilan, created_at) 
VALUES (
    'superadmin', 
    '$2y$10$YourHashedPasswordHere',  -- Gunakan password_hash('NewPassword', PASSWORD_DEFAULT)
    'super_admin',
    NULL,
    NOW()
);
```

---

## 📖 Documentation Links

### Internal Docs
- [PANDUAN_MULTI_INSTANSI_SEDERHANA.md](PANDUAN_MULTI_INSTANSI_SEDERHANA.md) - Setup guide
- [PANDUAN_KELOLA_PENGADILAN.md](PANDUAN_KELOLA_PENGADILAN.md) - Kelola pengadilan guide
- [IMPLEMENTASI_CHECKLIST.md](IMPLEMENTASI_CHECKLIST.md) - Implementation checklist

### Database Schema
- [migration_multi_instansi_SEDERHANA.sql](migration_multi_instansi_SEDERHANA.sql) - Migration script
- [perkara_db.sql](perkara_db.sql) - Full database schema

---

## 🎓 Tips & Best Practices

### Naming Convention
```
✅ BENAR:
Pengadilan Negeri Banjarbaru
Pengadilan Negeri Banjarmasin

❌ SALAH:
PN Banjarbaru
pn banjarbaru
Pengadilan Negeri  Banjarbaru (spasi ganda)
```

### User Assignment
```
✅ BENAR:
- Assign pengadilan saat create user
- Pilih dari dropdown (future enhancement)
- Gunakan nama yang sudah tervalidasi

❌ SALAH:
- Biarkan pengadilan NULL untuk user non-super-admin
- Ketik manual (risiko typo)
- Gunakan singkatan
```

### Data Entry
```
✅ BENAR:
1. Login sebagai admin PN A
2. Tambah perkara
3. Sistem otomatis assign pengadilan PN A

❌ SALAH:
- Manual isi kolom pengadilan di database
- Edit pengadilan via SQL tanpa konsistensi check
```

---

**Quick Start Command**:
```bash
# Akses kelola pengadilan
http://localhost/Perkara_app/kelola_pengadilan

# Login credentials
Username: superadmin
Password: SuperAdmin123!
```

---

**Last Updated**: 2024  
**Version**: 1.0  
**For**: Super Admin Only
