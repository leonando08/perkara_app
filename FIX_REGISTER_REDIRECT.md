# Fix: Register Page Redirect Issue

## Masalah
Link "Belum punya akun? Daftar" di halaman login langsung redirect kembali ke halaman login (seperti "kepental balik").

## Root Cause
Controller `Auth_simple::register()` memiliki logic yang memeriksa apakah tabel `pengadilan` memiliki data. Jika kosong, akan langsung redirect ke halaman login dengan flash message error.

```php
// Line 156-159 di Auth_simple.php
if (empty($data['pengadilan_list'])) {
    $this->session->set_flashdata('error', 'Belum ada data pengadilan...');
    redirect('auth_simple/login');
    return;
}
```

Pada saat testing, tabel `pengadilan` kosong (tidak ada data), sehingga setiap kali user klik "Daftar", langsung redirect kembali ke login.

## Solusi

### 1. Insert Data Pengadilan
Data 13 Pengadilan Negeri di Kalimantan Selatan telah diinsert ke database:

```sql
-- Via Docker command
docker exec perkara_app_db mysql -uroot -proot perkara_db < insert_pengadilan_kalsel.sql
```

### 2. Perbaikan Controller
Menambahkan error logging dan pesan yang lebih jelas:

```php
public function register()
{
    // Get pengadilan list
    $data['pengadilan_list'] = [];
    
    try {
        $data['pengadilan_list'] = $this->Pengadilan_model->get_all(false);
    } catch (Exception $e) {
        try {
            $query = $this->db->get('pengadilan');
            $data['pengadilan_list'] = $query->result();
        } catch (Exception $e2) {
            log_message('error', 'Failed to get pengadilan list: ' . $e2->getMessage());
        }
    }

    // Redirect ke login jika tidak ada data pengadilan
    if (empty($data['pengadilan_list'])) {
        $this->session->set_flashdata('error', 'Belum ada data pengadilan...');
        log_message('error', 'Register failed: No pengadilan data found');
        redirect('auth_simple/login');
        return;
    }

    $this->load->view('login/register', $data);
}
```

## Data Pengadilan yang Diinsert

Total: **13 Pengadilan Negeri**

1. PN Banjarmasin (PN-BJM)
2. PN Kandangan (PN-KDG)
3. PN Martapura (PN-MTP)
4. PN Kotabaru (PN-KTB)
5. PN Barabai (PN-BRB)
6. PN Amuntai (PN-AMT)
7. PN Tanjung (PN-TJG)
8. PN Rantau (PN-RTU)
9. PN Pelaihari (PN-PLH)
10. PN Marabahan (PN-MRH)
11. PN Banjarbaru (PN-BJB)
12. PN Batulicin (PN-BTL)
13. PN Paringin (PN-PRG)

## Verifikasi

### Check data pengadilan:
```bash
docker exec perkara_app_db mysql -uroot -proot -e "USE perkara_db; SELECT COUNT(*) as total FROM pengadilan;"
```

### Test register page:
```
http://localhost:8080/index.php/auth_simple/register
```

## Files Modified
1. `application/controllers/Auth_simple.php` - Menambahkan error logging
2. `insert_pengadilan_kalsel.sql` - File SQL untuk insert data pengadilan

## Testing
✅ Sekarang halaman register dapat diakses dengan normal
✅ Dropdown "Asal Pengadilan" menampilkan 13 pilihan PN
✅ Link "Belum punya akun? Daftar" berfungsi dengan baik

## Catatan
Jika terjadi masalah serupa di masa depan, periksa:
1. Apakah tabel `pengadilan` memiliki data
2. Check error log di `application/logs/log-YYYY-MM-DD.php`
3. Pastikan `Pengadilan_model` dapat mengakses database dengan benar
