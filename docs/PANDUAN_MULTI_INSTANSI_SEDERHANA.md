# PANDUAN MULTI-INSTANSI PENGADILAN (VERSI SEDERHANA)

## 📌 Gambaran Umum

Versi sederhana ini memisahkan data per pengadilan dengan cara yang lebih simpel:
- **Tidak butuh tabel pengadilan** terpisah
- Cukup tambah kolom `pengadilan` (VARCHAR) di tabel `users` dan `perkara_banding`
- Nama pengadilan disimpan langsung sebagai text

---

## 🚀 Cara Install (3 Langkah Mudah!)

### Step 1: Backup Database
```bash
# WAJIB backup dulu!
mysqldump -u root -p perkara_db > backup_sebelum_migration.sql
```

### Step 2: Jalankan Migration
1. Buka file `migration_multi_instansi_SEDERHANA.sql`
2. Import via **PhpMyAdmin** atau jalankan:
   ```bash
   mysql -u root -p perkara_db < migration_multi_instansi_SEDERHANA.sql
   ```

### Step 3: Assign Pengadilan ke User
```sql
-- Lihat user yang ada
SELECT id, username, role, pengadilan FROM users;

-- Assign user ke pengadilan (sesuaikan nama!)
UPDATE users SET pengadilan = 'Pengadilan Negeri Banjarbaru' WHERE username = 'admin1';
UPDATE users SET pengadilan = 'Pengadilan Negeri Banjarmasin' WHERE username = 'user';

-- Assign perkara ke pengadilan
UPDATE perkara_banding SET pengadilan = 'Pengadilan Negeri Banjarbaru' WHERE pengadilan IS NULL;
```

**SELESAI!** 🎉

---

## ⚠️ PENTING: Konsistensi Nama Pengadilan

Nama pengadilan **HARUS PERSIS SAMA** di seluruh sistem (case-sensitive):

✅ **BENAR:**
- `Pengadilan Negeri Banjarbaru`
- `Pengadilan Negeri Banjarmasin`

❌ **SALAH:**
- `pengadilan negeri banjarbaru` (huruf kecil)
- `PN Banjarbaru` (singkatan)
- `Banjarbaru` (tidak lengkap)
- `Pengadilan Negeri  Banjarbaru` (spasi ganda)

**Tips:** Gunakan dropdown di form input untuk menghindari typo!

---

## 📝 Daftar Nama Pengadilan Standar

Gunakan salah satu nama standar ini:

```
Pengadilan Negeri Banjarbaru
Pengadilan Negeri Banjarmasin
Pengadilan Negeri Martapura
Pengadilan Negeri Pelaihari
Pengadilan Negeri Rantau
Pengadilan Negeri Amuntai
Pengadilan Negeri Marabahan
Pengadilan Negeri Barabai
```

---

## 👤 Role & Akses

### 1. Super Admin (`role = 'super_admin'`)
- **Username:** `superadmin`
- **Password:** `superadmin123` (⚠️ **WAJIB DIGANTI!**)
- **Pengadilan:** `NULL` (tidak terikat pengadilan)
- **Akses:** Bisa lihat dan kelola data SEMUA pengadilan

### 2. Admin (`role = 'admin'`)
- **Pengadilan:** Wajib diisi (contoh: `Pengadilan Negeri Banjarbaru`)
- **Akses:** Hanya bisa lihat/kelola data pengadilan mereka sendiri

### 3. User (`role = 'user'`)
- **Pengadilan:** Wajib diisi
- **Akses:** Hanya bisa lihat/kelola data pengadilan mereka sendiri

---

## 💡 Cara Kerja Sistem

### Saat Login:
```
User "admin1" login 
→ Sistem ambil pengadilan dari tabel users
→ Simpan di session: $_SESSION['pengadilan'] = 'Pengadilan Negeri Banjarbaru'
```

### Saat Query Data:
```php
// Sistem otomatis tambahkan WHERE clause
SELECT * FROM perkara_banding 
WHERE pengadilan = 'Pengadilan Negeri Banjarbaru';  // Auto-filter!
```

### Saat Input Perkara Baru:
```php
// Sistem otomatis isi kolom pengadilan
INSERT INTO perkara_banding 
(pengadilan, nomor_perkara_tk1, ...) 
VALUES ('Pengadilan Negeri Banjarbaru', ...);  // Auto-assign!
```

---

## 🔧 Contoh Penggunaan

### Skenario 1: Menambah User Baru untuk Pengadilan Tertentu

```sql
-- Tambah user admin untuk PN Martapura
INSERT INTO users (username, password, role, pengadilan, email, nama_lengkap)
VALUES (
    'admin_mtw', 
    '$2y$10$...hash_password_disini...', 
    'admin', 
    'Pengadilan Negeri Martapura',  -- Wajib isi!
    'admin_mtw@pn-martapura.go.id',
    'Admin Martapura'
);
```

### Skenario 2: Pindahkan User ke Pengadilan Lain

```sql
-- Pindah user dari PN Banjarbaru ke PN Banjarmasin
UPDATE users 
SET pengadilan = 'Pengadilan Negeri Banjarmasin' 
WHERE username = 'admin1';
```

### Skenario 3: Cek Distribusi Data Per Pengadilan

```sql
-- Lihat jumlah user per pengadilan
SELECT pengadilan, COUNT(*) as jumlah 
FROM users 
GROUP BY pengadilan;

-- Lihat jumlah perkara per pengadilan
SELECT pengadilan, COUNT(*) as jumlah 
FROM perkara_banding 
GROUP BY pengadilan;
```

---

## 🐛 Troubleshooting

### Masalah: "Data tidak muncul setelah login"

**Penyebab:** User belum di-assign pengadilan

**Solusi:**
```sql
-- Cek pengadilan user
SELECT id, username, role, pengadilan FROM users WHERE username = 'nama_user';

-- Assign pengadilan
UPDATE users SET pengadilan = 'Pengadilan Negeri Banjarbaru' WHERE username = 'nama_user';

-- Logout dan login ulang
```

---

### Masalah: "User bisa lihat data pengadilan lain"

**Penyebab:** Nama pengadilan tidak konsisten (typo/case berbeda)

**Solusi:**
```sql
-- Cek variasi nama pengadilan
SELECT DISTINCT pengadilan FROM users;
SELECT DISTINCT pengadilan FROM perkara_banding;

-- Perbaiki inkonsistensi (contoh)
UPDATE users 
SET pengadilan = 'Pengadilan Negeri Banjarbaru' 
WHERE pengadilan IN ('PN Banjarbaru', 'banjarbaru', 'Pengadilan Banjarbaru');

UPDATE perkara_banding 
SET pengadilan = 'Pengadilan Negeri Banjarbaru' 
WHERE pengadilan LIKE '%Banjarbaru%';
```

---

### Masalah: "Session pengadilan hilang"

**Solusi:**
1. Clear browser cache & cookies
2. Logout dan login ulang
3. Pastikan kolom `pengadilan` di tabel `users` terisi

---

## 🔄 Rollback (Jika Ada Masalah)

```sql
-- HATI-HATI! Ini akan menghapus semua perubahan
ALTER TABLE perkara_banding DROP INDEX idx_pengadilan;
ALTER TABLE perkara_banding DROP COLUMN pengadilan;

ALTER TABLE users DROP INDEX idx_pengadilan;
ALTER TABLE users DROP COLUMN pengadilan;

-- Kembalikan role ke enum lama
ALTER TABLE users ADD COLUMN role_temp enum('admin','user') NOT NULL DEFAULT 'user';
UPDATE users SET role_temp = IF(role = 'super_admin', 'admin', role);
ALTER TABLE users DROP COLUMN role;
ALTER TABLE users CHANGE role_temp role enum('admin','user') NOT NULL DEFAULT 'user';

DELETE FROM users WHERE username = 'superadmin';
```

---

## ✅ Checklist Setelah Install

- [ ] Migration SQL berhasil dijalankan
- [ ] Kolom `pengadilan` ada di tabel `users`
- [ ] Kolom `pengadilan` ada di tabel `perkara_banding`
- [ ] Semua user existing sudah di-assign pengadilan
- [ ] Semua perkara existing sudah di-assign pengadilan
- [ ] Login sebagai user biasa → hanya lihat data pengadilan mereka
- [ ] Login sebagai super admin → bisa lihat semua data
- [ ] Input perkara baru → otomatis ter-assign ke pengadilan user
- [ ] Nama pengadilan konsisten di seluruh sistem

---

## 📞 Butuh Bantuan?

Jika ada pertanyaan atau masalah, tanya saja! 😊

---

**Versi:** 1.0 (Sederhana)  
**Tanggal:** 2025-11-03
