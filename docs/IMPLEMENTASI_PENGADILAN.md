# 📋 Implementasi Fitur Nama Pengadilan untuk Multi-Instansi

## 📅 Tanggal: 3 November 2025

## 🎯 Tujuan
Menambahkan fitur **nama pengadilan** untuk setiap user agar sistem dapat mendukung **multi-instansi pengadilan** dengan session yang sesuai untuk masing-masing pengadilan.

---

## 🗃️ Perubahan Database

### 1. **Tabel Baru: `pengadilan`**
```sql
CREATE TABLE IF NOT EXISTS `pengadilan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_pengadilan` varchar(200) NOT NULL,
  `kode_pengadilan` varchar(50) DEFAULT NULL,
  `alamat` text,
  `telepon` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `aktif` enum('Y','N') DEFAULT 'Y',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nama_pengadilan` (`nama_pengadilan`),
  UNIQUE KEY `kode_pengadilan` (`kode_pengadilan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### 2. **Update Tabel `users`**
Tambahkan kolom:
- `pengadilan_id` (INT) - Foreign Key ke tabel pengadilan
- `nip` (VARCHAR) - Nomor Induk Pegawai
- `jabatan` (VARCHAR) - Jabatan pegawai
- `telepon` (VARCHAR) - No telepon

```sql
ALTER TABLE `users` 
ADD COLUMN `pengadilan_id` int(11) DEFAULT NULL AFTER `role`,
ADD COLUMN `nip` varchar(50) DEFAULT NULL AFTER `pengadilan_id`,
ADD COLUMN `jabatan` varchar(100) DEFAULT NULL AFTER `nip`,
ADD COLUMN `telepon` varchar(20) DEFAULT NULL AFTER `email`,
ADD KEY `fk_users_pengadilan` (`pengadilan_id`),
ADD CONSTRAINT `fk_users_pengadilan` 
  FOREIGN KEY (`pengadilan_id`) 
  REFERENCES `pengadilan` (`id`) 
  ON DELETE SET NULL 
  ON UPDATE CASCADE;
```

### 3. **Data Sample Pengadilan**
```sql
INSERT INTO `pengadilan` (`nama_pengadilan`, `kode_pengadilan`, `alamat`, `telepon`, `aktif`) VALUES
('Pengadilan Negeri Banjarmasin', 'PN-BJM', 'Jl. Brig Jend Hasan Basri No.3, Banjarmasin', '0511-3304808', 'Y'),
('Pengadilan Negeri Martapura', 'PN-MTP', 'Jl. A. Yani Km 38, Martapura', '0511-4772225', 'Y'),
('Pengadilan Negeri Kandangan', 'PN-KDG', 'Jl. Jend. Sudirman No.1, Kandangan', '0517-21011', 'Y'),
('Pengadilan Negeri Paringin', 'PN-PRN', 'Jl. Ir. P.M. Noor No.100, Paringin', '0526-2021012', 'Y'),
('Pengadilan Negeri Kotabaru', 'PN-KTB', 'Jl. H.M. Arsyad No.31, Kotabaru', '0518-21013', 'Y'),
('Pengadilan Tinggi Banjarmasin', 'PT-BJM', 'Jl. Lambung Mangkurat No.19, Banjarmasin', '0511-3305555', 'Y');
```

---

## 📁 File yang Dibuat/Diupdate

### ✅ Model
1. **`Pengadilan_model.php`** (Sudah ada, lengkap dengan fungsi)
2. **`User_model.php`** - Update untuk JOIN dengan tabel pengadilan

### ✅ Controller
1. **`Kelola_pengadilan.php`** - Update untuk CRUD pengadilan
2. **`Kelola_user.php`** - Update untuk tambah field pengadilan
3. **`Auth.php`** - Update session login dengan data pengadilan

### ✅ View
1. **`admin/kelola_pengadilan.php`** - Interface kelola pengadilan (perlu dibuat)
2. **`admin/kelola_user.php`** - Update form tambah/edit user dengan dropdown pengadilan

---

## 🔐 Session Login yang Ditambahkan

Setelah login berhasil, session akan menyimpan:
```php
$session_data = [
    'user_id' => $user->id,
    'username' => $user->username,
    'role' => $user->role,
    'email' => $user->email,
    'nama_lengkap' => $user->nama_lengkap,
    'pengadilan_id' => $user->pengadilan_id,         // ✨ BARU
    'nama_pengadilan' => $user->nama_pengadilan,     // ✨ BARU
    'kode_pengadilan' => $user->kode_pengadilan,     // ✨ BARU
    'nip' => $user->nip,                             // ✨ BARU
    'jabatan' => $user->jabatan,                     // ✨ BARU
    'logged_in' => TRUE,
    'login_time' => time(),
    'login_ip' => $ip
];
```

---

## 🚀 Cara Menggunakan

### 1. **Jalankan Migration SQL**
```bash
# Import file migration ke database
mysql -u perkara_user -p perkara_db < migration_add_pengadilan.sql
```

### 2. **Akses Menu Kelola Pengadilan**
- URL: `http://localhost/Perkara_app/kelola_pengadilan`
- Hanya admin yang bisa akses
- Fitur: Tambah, Edit, Hapus, Toggle Status

### 3. **Tambah/Edit User dengan Pengadilan**
- Pilih pengadilan dari dropdown saat tambah/edit user
- Field opsional: NIP, Jabatan, Telepon

### 4. **Cek Session Pengadilan**
```php
// Di controller atau view
$nama_pengadilan = $this->session->userdata('nama_pengadilan');
$kode_pengadilan = $this->session->userdata('kode_pengadilan');

echo "Pengadilan: " . $nama_pengadilan; // Output: Pengadilan Negeri Banjarmasin
```

---

## 📊 Struktur Relasi

```
┌──────────────┐
│  pengadilan  │
│  (Master)    │
└──────┬───────┘
       │ 1
       │
       │ N
┌──────▼───────┐
│    users     │
│ pengadilan_id│
└──────────────┘
```

---

## 🔍 Query Contoh

### Ambil User dengan Pengadilan
```php
$this->db->select('users.*, pengadilan.nama_pengadilan, pengadilan.kode_pengadilan');
$this->db->from('users');
$this->db->join('pengadilan', 'pengadilan.id = users.pengadilan_id', 'left');
$this->db->where('users.id', $user_id);
$user = $this->db->get()->row();
```

### Ambil User per Pengadilan
```php
$users = $this->User_model->get_by_pengadilan($pengadilan_id);
```

### Dropdown Pengadilan untuk Form
```php
$pengadilan_list = $this->Pengadilan_model->get_dropdown();
// Output: [1 => 'PN Banjarmasin', 2 => 'PN Martapura', ...]
```

---

## ⚠️ Catatan Penting

1. **Foreign Key ON DELETE SET NULL** - Jika pengadilan dihapus, `pengadilan_id` di users akan jadi NULL
2. **Soft Delete** - Pengadilan tidak dihapus permanen, hanya status `aktif = 'N'`
3. **Validasi** - Tidak boleh hapus pengadilan yang masih ada usernya
4. **Session** - Data pengadilan otomatis tersimpan saat login

---

## 🎨 UI Improvements

### Welcome Message dengan Nama Pengadilan
```
Login berhasil! Selamat datang John Doe - Pengadilan Negeri Banjarmasin
```

### Filter Data per Pengadilan
```php
// Di controller
$pengadilan_id = $this->session->userdata('pengadilan_id');
$data['perkara'] = $this->Perkara_model->get_by_pengadilan($pengadilan_id);
```

---

## 📝 TODO Next

- [ ] Tambah view `admin/kelola_pengadilan.php`
- [ ] Update form tambah/edit user dengan field pengadilan
- [ ] Tambah filter data perkara per pengadilan
- [ ] Buat laporan per pengadilan
- [ ] Export data per pengadilan

---

## 🔄 Rollback (Jika Diperlukan)

```sql
ALTER TABLE `users` DROP FOREIGN KEY `fk_users_pengadilan`;
ALTER TABLE `users` 
  DROP COLUMN `pengadilan_id`, 
  DROP COLUMN `nip`, 
  DROP COLUMN `jabatan`, 
  DROP COLUMN `telepon`;
DROP TABLE `pengadilan`;
```

---

## ✅ Status Implementasi

- [x] Migration SQL dibuat
- [x] Model Pengadilan_model sudah ada
- [x] Model User_model diupdate dengan JOIN
- [x] Controller Kelola_pengadilan diupdate
- [x] Controller Kelola_user diupdate
- [x] Controller Auth diupdate untuk session
- [ ] View kelola_pengadilan perlu dibuat
- [ ] View kelola_user perlu update form

---

## 📞 Support

Jika ada pertanyaan atau issue, silakan hubungi tim developer.

---

**Dibuat oleh:** GitHub Copilot
**Tanggal:** 3 November 2025
