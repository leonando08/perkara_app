# 🧪 Panduan Testing Login dengan Fitur Pengadilan

## 📅 Tanggal: 3 November 2025

---

## 🚀 LANGKAH-LANGKAH TESTING

### **Step 1: Jalankan Migration SQL** ⚡

#### Metode 1: Via phpMyAdmin (Paling Mudah)
1. Buka browser: `http://localhost/phpmyadmin`
2. Login (default: username `root`, password kosong)
3. Pilih database: `perkara_db`
4. Klik tab **SQL**
5. Copy-paste isi file `migration_add_pengadilan.sql`
6. Klik **Go** atau **Kirim**

#### Metode 2: Via Laragon Terminal
```bash
# Buka Laragon Terminal (klik kanan icon Laragon > Terminal)
cd C:\laragon\www\Perkara_app
mysql -u root perkara_db < migration_add_pengadilan.sql
```

#### Metode 3: Via PowerShell
```powershell
# Buka PowerShell di folder project
cd C:\laragon\www\Perkara_app
& "C:\laragon\bin\mysql\mysql-8.0.30\bin\mysql.exe" -u root perkara_db < migration_add_pengadilan.sql
```

---

### **Step 2: Verifikasi Database** ✅

Buka phpMyAdmin dan cek:

#### Cek Tabel Pengadilan:
```sql
SELECT * FROM pengadilan;
```
**Expected Output:** 6 pengadilan (PN Banjarmasin, Martapura, dll)

#### Cek Struktur Tabel Users:
```sql
DESCRIBE users;
```
**Expected:** Ada kolom baru: `pengadilan_id`, `nip`, `jabatan`, `telepon`

---

### **Step 3: Update User dengan Pengadilan** 🔧

#### Cara 1: Via SQL (Manual)
```sql
-- Update user admin1 dengan pengadilan Banjarmasin
UPDATE users 
SET pengadilan_id = 1, 
    nama_lengkap = 'Super Admin',
    nip = '199001012010011001',
    jabatan = 'Administrator Sistem'
WHERE username = 'admin1';

-- Update user biasa dengan pengadilan Martapura
UPDATE users 
SET pengadilan_id = 2, 
    nama_lengkap = 'John Doe',
    nip = '199102022012012002',
    jabatan = 'Panitera'
WHERE username = 'user';
```

#### Cara 2: Via Interface (Setelah login sebagai admin)
1. Login sebagai admin
2. Akses: `http://localhost/Perkara_app/kelola_user`
3. Edit user yang ingin ditambahkan pengadilan
4. Pilih pengadilan dari dropdown
5. Isi NIP, Jabatan (opsional)
6. Simpan

---

### **Step 4: Testing Login** 🔐

#### Test Case 1: Login User Tanpa Pengadilan
```
Username: admin1 (sebelum diupdate)
Password: [password admin1]

Expected Session:
✅ user_id, username, role
❌ pengadilan_id, nama_pengadilan (NULL)

Welcome Message:
"Login berhasil! Selamat datang admin1"
```

#### Test Case 2: Login User Dengan Pengadilan
```
Username: admin1 (setelah diupdate dengan pengadilan_id = 1)
Password: [password admin1]

Expected Session:
✅ user_id = 3
✅ username = 'admin1'
✅ role = 'admin'
✅ email = 'admin1@gmail.com'
✅ nama_lengkap = 'Super Admin'
✅ pengadilan_id = 1
✅ nama_pengadilan = 'Pengadilan Negeri Banjarmasin'
✅ kode_pengadilan = 'PN-BJM'
✅ nip = '199001012010011001'
✅ jabatan = 'Administrator Sistem'

Welcome Message:
"Login berhasil! Selamat datang Super Admin - Pengadilan Negeri Banjarmasin"
```

---

### **Step 5: Cek Session Login** 🔍

#### Metode 1: Tambahkan Debug di Dashboard
Edit file `application/views/admin/dashboard_admin.php` atau `application/views/user/dashboard_user.php`

Tambahkan di bagian atas (sementara):
```php
<!-- DEBUG SESSION (Hapus setelah testing) -->
<?php if (ENVIRONMENT === 'development'): ?>
<div class="alert alert-info">
    <h5>🔍 Debug Session Login:</h5>
    <ul>
        <li><strong>User ID:</strong> <?= $this->session->userdata('user_id') ?></li>
        <li><strong>Username:</strong> <?= $this->session->userdata('username') ?></li>
        <li><strong>Nama Lengkap:</strong> <?= $this->session->userdata('nama_lengkap') ?></li>
        <li><strong>Role:</strong> <?= $this->session->userdata('role') ?></li>
        <li><strong>Pengadilan ID:</strong> <?= $this->session->userdata('pengadilan_id') ?: 'TIDAK ADA' ?></li>
        <li><strong>Nama Pengadilan:</strong> <?= $this->session->userdata('nama_pengadilan') ?: 'TIDAK ADA' ?></li>
        <li><strong>Kode Pengadilan:</strong> <?= $this->session->userdata('kode_pengadilan') ?: 'TIDAK ADA' ?></li>
        <li><strong>NIP:</strong> <?= $this->session->userdata('nip') ?: 'TIDAK ADA' ?></li>
        <li><strong>Jabatan:</strong> <?= $this->session->userdata('jabatan') ?: 'TIDAK ADA' ?></li>
    </ul>
</div>
<?php endif; ?>
```

#### Metode 2: Buat Controller Testing
Buat file: `application/controllers/Test_session.php`
```php
<?php
class Test_session extends CI_Controller {
    public function index() {
        echo "<h1>Session Data Login</h1>";
        echo "<pre>";
        print_r($this->session->userdata());
        echo "</pre>";
    }
}
```

Akses: `http://localhost/Perkara_app/test_session`

---

### **Step 6: Testing Skenario Lengkap** 📝

#### Skenario A: Admin dari PN Banjarmasin
1. **Setup Database:**
   ```sql
   UPDATE users SET pengadilan_id = 1, nama_lengkap = 'Ahmad Fauzi' WHERE username = 'admin1';
   ```

2. **Login:**
   - Username: `admin1`
   - Password: [password]

3. **Expected Results:**
   - Welcome message: "Login berhasil! Selamat datang Ahmad Fauzi - Pengadilan Negeri Banjarmasin"
   - Session ada: `nama_pengadilan`, `kode_pengadilan`
   - Di navbar/header tampil nama pengadilan

#### Skenario B: User Biasa dari PN Martapura
1. **Setup Database:**
   ```sql
   UPDATE users SET pengadilan_id = 2, nama_lengkap = 'Budi Santoso', jabatan = 'Panitera Muda' WHERE username = 'user';
   ```

2. **Login:**
   - Username: `user`
   - Password: [password]

3. **Expected Results:**
   - Welcome message dengan nama pengadilan
   - Dashboard menampilkan data sesuai pengadilan user
   - Filter perkara otomatis sesuai pengadilan

#### Skenario C: User Tanpa Pengadilan (Legacy)
1. **Setup:** Biarkan user lama tanpa pengadilan_id (NULL)

2. **Login:** Harus tetap bisa login

3. **Expected Results:**
   - Login berhasil tanpa nama pengadilan
   - Session: `pengadilan_id` = NULL
   - Tidak ada filter pengadilan (akses semua data)

---

### **Step 7: SQL Query untuk Cek Data** 🔎

```sql
-- Cek user dan pengadilan mereka
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

-- Cek pengadilan yang aktif
SELECT * FROM pengadilan WHERE aktif = 'Y';

-- Hitung user per pengadilan
SELECT 
    p.nama_pengadilan,
    COUNT(u.id) as jumlah_user
FROM pengadilan p
LEFT JOIN users u ON p.id = u.pengadilan_id
GROUP BY p.id, p.nama_pengadilan;
```

---

### **Step 8: Troubleshooting** 🔧

#### Problem 1: "Table 'pengadilan' doesn't exist"
**Solution:**
```sql
-- Jalankan migration manual
CREATE TABLE pengadilan (
  id int(11) NOT NULL AUTO_INCREMENT,
  nama_pengadilan varchar(200) NOT NULL,
  kode_pengadilan varchar(50) DEFAULT NULL,
  aktif enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (id)
);
```

#### Problem 2: Session pengadilan tidak muncul
**Cek:**
1. Apakah user sudah punya `pengadilan_id`?
   ```sql
   SELECT pengadilan_id FROM users WHERE username = 'admin1';
   ```
2. Apakah Auth controller sudah diupdate?
3. Clear browser cache & session

#### Problem 3: Error "Undefined property $Pengadilan_model"
**Solution:** Model belum di-load
```php
$this->load->model('Pengadilan_model');
```

---

### **Step 9: Quick Test Commands** ⚡

#### Test 1: Cek tabel sudah ada
```sql
SHOW TABLES LIKE 'pengadilan';
```

#### Test 2: Cek data pengadilan
```sql
SELECT COUNT(*) FROM pengadilan;
-- Expected: 6
```

#### Test 3: Cek user sudah punya pengadilan
```sql
SELECT username, pengadilan_id FROM users WHERE pengadilan_id IS NOT NULL;
```

#### Test 4: Simulate login query
```sql
SELECT 
    users.*, 
    pengadilan.nama_pengadilan, 
    pengadilan.kode_pengadilan
FROM users
LEFT JOIN pengadilan ON pengadilan.id = users.pengadilan_id
WHERE users.username = 'admin1';
```

---

## 📊 Checklist Testing

- [ ] Migration SQL berhasil dijalankan
- [ ] Tabel `pengadilan` sudah ada dengan 6 data
- [ ] Tabel `users` punya kolom `pengadilan_id`, `nip`, `jabatan`, `telepon`
- [ ] Update minimal 1 user dengan pengadilan
- [ ] Login berhasil dan session ada `nama_pengadilan`
- [ ] Welcome message tampil dengan nama pengadilan
- [ ] Debug session menampilkan data lengkap
- [ ] User tanpa pengadilan tetap bisa login
- [ ] Dropdown pengadilan muncul di form user (jika view sudah dibuat)

---

## 🎯 Expected Final Result

### Session Login Lengkap:
```php
Array (
    [user_id] => 3
    [username] => admin1
    [role] => admin
    [email] => admin1@gmail.com
    [nama_lengkap] => Super Admin
    [pengadilan_id] => 1
    [nama_pengadilan] => Pengadilan Negeri Banjarmasin
    [kode_pengadilan] => PN-BJM
    [nip] => 199001012010011001
    [jabatan] => Administrator Sistem
    [logged_in] => 1
    [login_time] => 1730620800
    [login_ip] => 127.0.0.1
)
```

### Welcome Message:
```
✅ Login berhasil! Selamat datang Super Admin - Pengadilan Negeri Banjarmasin
```

---

## 🚀 Ready to Test!

1. **Jalankan migration** (Step 1)
2. **Update user dengan pengadilan** (Step 3 - via SQL cepat)
3. **Login dan lihat hasil** (Step 4)
4. **Cek session** (Step 5 - tambah debug code)

---

**Good Luck! 🎉**
