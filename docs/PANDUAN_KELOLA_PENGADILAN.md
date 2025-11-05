# Panduan Kelola Pengadilan Standar

## Deskripsi
Fitur ini memungkinkan **Super Admin** untuk mengelola nama-nama pengadilan yang terdaftar dalam sistem dan memvalidasi konsistensi penamaan.

## Akses
- **URL**: `/kelola_pengadilan`
- **Role**: Super Admin only
- **Lokasi**: Menu navigasi → Kelola Pengadilan

---

## Fitur Utama

### 1. Dashboard Kelola Pengadilan

**URL**: `/kelola_pengadilan/index`

**Tampilan**:
- Statistik global:
  - Total Pengadilan
  - Total User Ter-assign
  - Total Perkara Ter-assign
  - Data Tanpa Pengadilan (warning)
  
- Tabel daftar pengadilan dengan:
  - Nama Pengadilan
  - Jumlah User
  - Jumlah Perkara
  - Tombol Rename

**Aksi**:
- **Rename**: Mengubah nama satu pengadilan
- **Validasi Konsistensi**: Cek inkonsistensi nama
- **Generate SQL**: Buat script SQL standarisasi
- **Export JSON**: Download data dalam format JSON

---

### 2. Validasi Konsistensi

**URL**: `/kelola_pengadilan/validasi`

**Fungsi**: Mendeteksi dan memperbaiki inkonsistensi dalam penamaan pengadilan.

#### Jenis Inkonsistensi yang Terdeteksi:
1. **Perbedaan huruf besar/kecil**:
   - `Pengadilan Negeri Banjarbaru`
   - `pengadilan negeri banjarbaru`
   - `PENGADILAN NEGERI BANJARBARU`

2. **Variasi penulisan**:
   - `PN Banjarbaru`
   - `Pengadilan Negeri Banjarbaru`
   - `Pengadilan Negeri  Banjarbaru` (spasi ganda)

3. **Singkatan berbeda**:
   - `PN Banjarmasin`
   - `Peng. Negeri Banjarmasin`

#### Cara Memperbaiki Inkonsistensi:

**Metode 1: Manual per Grup**
1. Lihat daftar grup inkonsistensi
2. Pilih salah satu varian sebagai "Nama Standar"
3. Klik "Perbaiki Grup Ini"
4. Konfirmasi perubahan
5. Sistem akan mengupdate semua varian menjadi nama standar yang dipilih

**Metode 2: Otomatis Semua**
1. Klik "Perbaiki Semua Otomatis"
2. Sistem memilih nama dengan **jumlah user terbanyak** sebagai standar
3. Semua varian di semua grup akan diseragamkan

#### Hasil Validasi:
- ✅ **Tidak Ada Inkonsistensi**: Tampilan success
- ⚠️ **Ada Inkonsistensi**: Daftar grup inkonsistensi dengan opsi perbaikan

---

### 3. Generate SQL Standarisasi

**URL**: `/kelola_pengadilan/generate_sql`

**Fungsi**: Membuat script SQL untuk standarisasi nama pengadilan.

#### Cara Menggunakan:

1. **Review Mapping**:
   - Tabel menampilkan "Nama Saat Ini" vs "Nama Standar"
   - Edit kolom "Nama Standar" sesuai kebutuhan

2. **Tombol Aksi**:
   - **Generate SQL**: Buat script UPDATE
   - **Reset ke Original**: Kembalikan ke nilai awal
   - **Gunakan Standar PN**: Otomatis format ke "Pengadilan Negeri [Kota]"

3. **Output SQL**:
   - Script SQL lengkap dengan:
     - `START TRANSACTION`
     - `UPDATE users ...`
     - `UPDATE perkara_banding ...`
     - `COMMIT`
   - Statistik: Total Changes, Users Affected, Perkara Affected

4. **Export**:
   - **Copy to Clipboard**: Copy SQL ke clipboard
   - **Download SQL**: Download sebagai file `.sql`

#### Format Nama Standar yang Direkomendasikan:
```
Pengadilan Negeri [Nama Kota]
```

**Contoh**:
- ✅ `Pengadilan Negeri Banjarbaru`
- ✅ `Pengadilan Negeri Banjarmasin`
- ❌ `PN Banjarbaru`
- ❌ `pengadilan negeri banjarbaru`

**Aturan Penulisan**:
- Huruf awal setiap kata **KAPITAL**
- Tidak menggunakan singkatan
- Konsisten untuk semua nama
- Hindari spasi ganda atau karakter khusus

---

### 4. Rename Pengadilan

**URL**: `/kelola_pengadilan/rename` (POST)

**Fungsi**: Mengubah nama satu pengadilan.

#### Cara Penggunaan:
1. Di dashboard, klik tombol **Rename** pada baris pengadilan
2. Modal popup akan muncul
3. Isi "Nama Pengadilan Baru"
4. Klik "Simpan Perubahan"
5. Sistem akan update:
   - Semua user dengan `pengadilan = nama_lama`
   - Semua perkara dengan `pengadilan = nama_lama`

#### Peringatan:
⚠️ Perubahan ini akan mempengaruhi **semua user dan perkara** yang terkait!

---

### 5. Export JSON

**URL**: `/kelola_pengadilan/export_json`

**Fungsi**: Mengekspor daftar pengadilan dalam format JSON.

#### Output JSON:
```json
[
  {
    "nama_pengadilan": "Pengadilan Negeri Banjarbaru",
    "jumlah_user": 10,
    "jumlah_perkara": 150
  },
  {
    "nama_pengadilan": "Pengadilan Negeri Banjarmasin",
    "jumlah_user": 8,
    "jumlah_perkara": 200
  }
]
```

**Kegunaan**:
- Backup data
- Analisis eksternal
- Import ke sistem lain
- Dokumentasi

---

## Workflow Standarisasi

### Skenario 1: Sistem Baru (Belum Ada Data)

1. **Tentukan Daftar Pengadilan Standar**:
   ```
   Pengadilan Negeri Banjarbaru
   Pengadilan Negeri Banjarmasin
   Pengadilan Negeri Martapura
   Pengadilan Negeri Pelaihari
   ```

2. **Buat Dokumentasi Internal**:
   - Simpan daftar nama standar
   - Edukasi user tentang format yang benar

3. **Validasi Berkala**:
   - Jalankan validasi konsistensi setiap bulan
   - Perbaiki segera jika ada inkonsistensi

---

### Skenario 2: Migrasi dari Sistem Lama

1. **Backup Database**:
   ```bash
   mysqldump -u root -p perkara_db > backup_before_standardization.sql
   ```

2. **Jalankan Migrasi**:
   ```bash
   mysql -u root -p perkara_db < migration_multi_instansi_SEDERHANA.sql
   ```

3. **Validasi Konsistensi**:
   - Akses `/kelola_pengadilan/validasi`
   - Review semua inkonsistensi

4. **Perbaiki**:
   - Gunakan "Perbaiki Semua Otomatis" atau manual per grup

5. **Generate SQL untuk Backup**:
   - Akses `/kelola_pengadilan/generate_sql`
   - Download SQL script
   - Simpan untuk dokumentasi

6. **Verifikasi**:
   - Cek kembali validasi konsistensi (harus 0 inkonsistensi)
   - Export JSON untuk dokumentasi

---

### Skenario 3: Maintenance Rutin

**Frekuensi**: Bulanan atau setelah import data baru

1. **Dashboard Check**:
   - Lihat statistik "Data Tanpa Pengadilan"
   - Jika > 0, assign pengadilan ke user/perkara

2. **Validasi Konsistensi**:
   - Jalankan validasi
   - Perbaiki jika ada inkonsistensi

3. **Generate SQL**:
   - Buat script SQL untuk perubahan
   - Simpan dalam version control

---

## Keamanan dan Validasi

### Access Control:
```php
// Di constructor Kelola_pengadilan
if ($this->session->userdata('role') !== 'super_admin') {
    show_error('Akses ditolak!', 403);
}
```

### Transaction Safety:
```php
$this->db->trans_start();

// Update users
$this->db->where('pengadilan', $pengadilan_lama);
$this->db->update('users', ['pengadilan' => $pengadilan_baru]);

// Update perkara_banding
$this->db->where('pengadilan', $pengadilan_lama);
$this->db->update('perkara_banding', ['pengadilan' => $pengadilan_baru]);

$this->db->trans_complete();
```

### SQL Injection Prevention:
- Semua input di-escape otomatis oleh CodeIgniter Query Builder
- Tidak ada raw SQL dengan user input langsung

---

## Troubleshooting

### 1. Halaman 403 Forbidden
**Penyebab**: Bukan super admin
**Solusi**: Login sebagai super admin

### 2. Validasi Tidak Mendeteksi Inkonsistensi
**Penyebab**: Nama sudah konsisten atau case-sensitive match
**Solusi**: Manual check dengan SQL:
```sql
SELECT DISTINCT pengadilan 
FROM (
    SELECT pengadilan FROM users WHERE pengadilan IS NOT NULL
    UNION
    SELECT pengadilan FROM perkara_banding WHERE pengadilan IS NOT NULL
) AS all_pengadilan
ORDER BY pengadilan;
```

### 3. Rename Gagal
**Penyebab**: Nama baru sudah ada
**Solusi**: Pilih nama yang belum digunakan atau gabungkan manual di database

### 4. SQL Script Tidak Generate
**Penyebab**: Tidak ada perubahan (nama lama = nama baru)
**Solusi**: Edit minimal satu nama di kolom "Nama Standar"

---

## Best Practices

### 1. Backup Sebelum Perubahan Massal
```bash
mysqldump -u root -p perkara_db > backup_$(date +%Y%m%d_%H%M%S).sql
```

### 2. Test di Development Dulu
- Clone database production ke development
- Test standarisasi di development
- Jika sukses, baru jalankan di production

### 3. Dokumentasi Setiap Perubahan
- Generate SQL sebelum eksekusi
- Simpan SQL script dalam version control
- Catat alasan perubahan

### 4. Validasi Berkala
- Schedule validasi konsistensi setiap bulan
- Setup alert jika ada data tanpa pengadilan
- Review statistik secara rutin

### 5. Edukasi User
- Buat dokumentasi format nama standar
- Training untuk admin yang menambah user baru
- Validasi input saat entry data (future enhancement)

---

## Integrasi dengan Fitur Lain

### 1. Login System
- Session menyimpan `pengadilan` string
- Filter data otomatis di `Perkara_model`

### 2. User Management
- Saat tambah user baru, pilih dari dropdown pengadilan standar
- Validasi agar nama konsisten

### 3. Perkara Management
- Saat tambah perkara, otomatis assign pengadilan dari session user
- Super admin bisa assign ke pengadilan mana saja

---

## FAQ

**Q: Apakah perubahan nama pengadilan mempengaruhi data lama?**
A: Ya, semua data user dan perkara dengan nama lama akan diupdate ke nama baru.

**Q: Apakah bisa mengembalikan perubahan?**
A: Ya, jika Anda punya backup SQL. Restore dari backup jika ada kesalahan.

**Q: Bagaimana jika ada 2 nama yang sama persis (case-sensitive)?**
A: Tidak akan terdeteksi sebagai inkonsistensi. Sistem hanya deteksi perbedaan case-insensitive.

**Q: Apakah super admin bisa melihat data semua pengadilan?**
A: Ya, super admin tidak ter-filter dan bisa melihat semua data.

**Q: Bagaimana cara menghapus pengadilan?**
A: Tidak ada fitur delete. Rename semua data ke pengadilan lain, lalu pengadilan yang kosong tidak akan muncul.

---

## Rencana Pengembangan (Future)

1. **Dropdown Validation**:
   - Saat tambah user, pilih dari dropdown pengadilan standar
   - Hindari typo manual

2. **Audit Log**:
   - Catat setiap perubahan nama pengadilan
   - Siapa, kapan, dari mana ke mana

3. **Approval Workflow**:
   - Rename butuh approval super admin kedua
   - Email notification untuk perubahan besar

4. **API Endpoint**:
   - REST API untuk get/update pengadilan
   - Integrasi dengan sistem eksternal

5. **Fuzzy Matching**:
   - Deteksi typo "Banajarbaru" vs "Banjarbaru"
   - Algoritma Levenshtein distance

---

## Kontak Support

Jika ada masalah atau pertanyaan:
- Email: support@example.com
- Phone: +62 XXX XXXX XXXX
- Ticket System: https://support.example.com

---

**Versi**: 1.0  
**Terakhir Update**: 2024  
**Author**: Development Team
