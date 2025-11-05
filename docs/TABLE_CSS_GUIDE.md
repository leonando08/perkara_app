# 📋 Panduan Penggunaan Global Table CSS

## 🎯 Tujuan
File `table-style.css` adalah file CSS global yang menyediakan styling konsisten untuk **semua tabel dan komponen UI** di aplikasi Sistem Informasi Perkara, baik untuk halaman Admin maupun User.

---

## 📁 Lokasi File
```
c:\laragon\www\Perkara_app\assets\css\table-style.css
```

---

## ✅ File yang Sudah Menggunakan Global CSS

File CSS global ini sudah **otomatis ter-include** di semua halaman karena dipanggil di `header.php`:

```php
<!-- Global Table Styling - Konsisten untuk semua halaman -->
<link href="<?= base_url('assets/css/table-style.css'); ?>" rel="stylesheet" />
```

### Halaman yang Otomatis Mendapat Styling:
✅ **Admin Pages:**
- dashboard_admin.php
- edit_perkara.php
- kelola_user.php
- tambah_user.php
- edit_user.php

✅ **User Pages:**
- dashboard_user.php
- edit_perkara.php (user)
- tambah_perkara.php

✅ **Laporan Pages:**
- laporan.php
- laporan_data.php
- rekap.php
- rekapitulasi.php

---

## 🎨 Komponen yang Tersedia

### 1. **Container & Wrapper**
```html
<div class="content-wrapper">
    <!-- Content here -->
</div>
```

### 2. **Page Header**
```html
<div class="page-header">
    <div>
        <h2 class="page-title">Judul Halaman</h2>
        <p class="text-muted mb-0">Deskripsi halaman</p>
    </div>
    <div class="action-buttons">
        <button class="btn btn-success">Tombol</button>
    </div>
</div>
```

### 3. **Search/Filter Card**
```html
<div class="search-card">
    <h5 class="mb-3">Filter Data</h5>
    <form>
        <!-- Form elements -->
    </form>
</div>
```

### 4. **Table dengan Styling Konsisten**
```html
<div class="content-card p-0">
    <div class="table-wrapper">
        <div class="table-responsive-custom">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="number-column">No</th>
                        <th class="text-column">Nama</th>
                        <th class="date-column">Tanggal</th>
                        <th class="status-column">Status</th>
                        <th class="action-column">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data rows -->
                </tbody>
            </table>
        </div>
    </div>
</div>
```

### 5. **Stats Cards**
```html
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">150</div>
        <div class="stat-label">Total Perkara</div>
    </div>
    <!-- More stat cards -->
</div>
```

### 6. **Buttons**
```html
<button class="btn btn-primary">Primary</button>
<button class="btn btn-success">Success</button>
<button class="btn btn-warning">Warning</button>
<button class="btn btn-danger">Danger</button>
<button class="btn btn-info">Info</button>
<button class="btn btn-secondary">Secondary</button>
```

### 7. **Badges**
```html
<span class="badge bg-success">Selesai</span>
<span class="badge bg-warning">Proses</span>
<span class="badge bg-danger">Ditolak</span>
```

### 8. **Form Elements**
```html
<label class="form-label">Label</label>
<input type="text" class="form-control" placeholder="Input">
<select class="form-select">
    <option>Option 1</option>
</select>
```

---

## 🔧 Class-Class yang Tersedia

### **Table Columns (Column Widths)**
| Class | Width | Alignment | Use Case |
|-------|-------|-----------|----------|
| `.number-column` | 50-70px | Center | Nomor urut |
| `.text-column` | 150-250px | Left | Teks panjang |
| `.parent-column` | 120-150px | Center | Kategori |
| `.date-column` | 100-120px | Center | Tanggal |
| `.status-column` | 90-100px | Center | Status badge |
| `.action-column` | 100-120px | Center | Tombol aksi |
| `.lama-column` | 70-80px | Center | Duration |

### **Button Sizes**
- `.btn` - Default size
- `.btn-group-sm > .btn` - Small buttons untuk action column

### **Utility Classes**
- `.text-center`, `.text-left`, `.text-right` - Text alignment
- `.mb-0` sampai `.mb-4` - Margin bottom (0, 0.25rem, 0.5rem, 1rem, 1.5rem)
- `.py-4` - Padding vertical
- `.d-flex`, `.flex-column` - Flexbox
- `.align-items-center`, `.justify-content-between` - Flex alignment
- `.gap-2`, `.w-100` - Gap dan width

---

## 🎯 Cara Menggunakan di Halaman Baru

### **Langkah 1: Struktur HTML Dasar**
```php
<?php $this->load->view('navbar/header'); ?>

<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="page-title">Judul Halaman</h2>
            <p class="text-muted mb-0">Deskripsi</p>
        </div>
    </div>

    <!-- Your content here -->
    
</div>

<?php $this->load->view('navbar/footer'); ?>
```

### **Langkah 2: Hapus CSS Lokal yang Konflik**
Hapus atau comment style lokal yang mendefinisikan:
- `.content-wrapper`
- `.table`, `.table th`, `.table td`
- `.btn`, `.btn-*`
- `.badge`
- `.form-control`, `.form-select`

### **Langkah 3: Gunakan Class Global**
Ganti class lokal dengan class dari `table-style.css`

---

## 📝 Contoh Migrasi Halaman

### **SEBELUM (dengan CSS lokal):**
```php
<style>
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table th {
        background: #198754;
        color: white;
    }
    /* ... more styles */
</style>

<div style="padding: 1rem;">
    <table class="table">
        <!-- ... -->
    </table>
</div>
```

### **SESUDAH (menggunakan global CSS):**
```php
<!-- Tidak perlu <style> lokal -->

<div class="content-wrapper">
    <div class="content-card p-0">
        <div class="table-wrapper">
            <div class="table-responsive-custom">
                <table class="table table-bordered">
                    <!-- ... -->
                </table>
            </div>
        </div>
    </div>
</div>
```

---

## 🎨 Fitur Styling yang Tersedia

### ✨ **Gradient & Modern Design**
- Gradient backgrounds pada cards
- Gradient buttons dengan hover effects
- Smooth animations (fadeInUp)
- Shadow effects untuk depth

### 🎯 **Interactive Elements**
- Hover effects pada table rows
- Transform animations pada buttons
- Smooth transitions (0.3s cubic-bezier)
- Custom scrollbar dengan gradient

### 📱 **Fully Responsive**
- Mobile: < 576px
- Tablet: 577px - 992px
- Desktop: > 993px
- Large Desktop: > 1200px

### 🚀 **Performance**
- Smooth scrolling
- Hardware acceleration
- Optimized animations
- Lazy loading ready

---

## 🔄 Cara Update Styling Global

Jika ingin mengubah styling untuk **semua halaman**:

1. Buka file: `c:\laragon\www\Perkara_app\assets\css\table-style.css`
2. Edit class yang ingin diubah
3. Save file
4. Refresh browser (Ctrl+Shift+R untuk hard refresh)
5. Semua halaman otomatis menggunakan styling baru!

---

## ⚠️ Catatan Penting

### **DO's:**
✅ Gunakan class global yang sudah ada
✅ Ikuti naming convention yang konsisten  
✅ Test responsive di semua device
✅ Gunakan utility classes untuk spacing
✅ Hapus CSS lokal yang duplikat

### **DON'Ts:**
❌ Jangan override style global di file lokal
❌ Jangan buat style duplikat
❌ Jangan gunakan inline styles
❌ Jangan hardcode width/height
❌ Jangan lupa test di mobile

---

## 🐛 Troubleshooting

### **Problem: Style tidak berubah**
**Solution:**
1. Hard refresh browser (Ctrl+Shift+R)
2. Clear browser cache
3. Check file path di header.php
4. Pastikan file table-style.css ada

### **Problem: Table terlalu lebar**
**Solution:**
- Gunakan `.table-responsive-custom` wrapper
- Set `min-width` yang sesuai
- Test scrolling horizontal

### **Problem: Konflik dengan style lokal**
**Solution:**
- Hapus atau comment style lokal
- Gunakan `!important` hanya jika perlu
- Cek specificity CSS

---

## 📚 Resources

- **Main CSS File**: `/assets/css/table-style.css`
- **Include Location**: `/application/views/navbar/header.php`
- **Documentation**: `TABLE_CSS_GUIDE.md` (file ini)

---

## 💡 Tips Pro

1. **Consistency is Key**: Selalu gunakan class global
2. **Mobile First**: Test di mobile dulu, lalu desktop
3. **Use DevTools**: Inspect element untuk debug
4. **Comment Your Code**: Jika perlu override, tulis alasannya
5. **Performance**: Hindari nested selectors yang dalam

---

## 🎉 Keuntungan Menggunakan Global CSS

✅ **Konsistensi**: Semua halaman tampil sama  
✅ **Maintenance**: Update 1 file, semua halaman berubah  
✅ **File Size**: Lebih kecil, tidak ada duplikasi  
✅ **Performance**: Cached di browser  
✅ **Scalability**: Mudah dikembangkan  
✅ **Responsive**: Otomatis responsive di semua device  
✅ **Professional**: Design modern dan consistent  

---

**Dibuat oleh:** AI Assistant  
**Tanggal:** October 13, 2025  
**Versi:** 1.0  
**Status:** ✅ Production Ready
