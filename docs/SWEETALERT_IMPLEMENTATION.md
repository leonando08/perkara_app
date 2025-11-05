# SweetAlert2 Implementation Guide

## 📋 Implementasi SweetAlert2 di Perkara App

SweetAlert2 telah diintegrasikan ke seluruh sistem untuk memberikan notifikasi yang lebih menarik dan user-friendly.

## 🚀 Fitur yang Telah Diimplementasikan

### 1. **Success Messages (Notifikasi Berhasil)**
```javascript
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: 'Data berhasil disimpan!',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    toast: true,
    position: 'top-end'
});
```

### 2. **Error Messages (Notifikasi Gagal)**
```javascript
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: 'Terjadi kesalahan dalam menyimpan data',
    confirmButtonText: 'OK',
    confirmButtonColor: '#dc3545'
});
```

### 3. **Confirmation Dialogs (Konfirmasi Hapus)**
```javascript
Swal.fire({
    title: 'Konfirmasi Hapus',
    text: 'Apakah Anda yakin ingin menghapus data ini?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#dc3545',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal',
    reverseButtons: true
}).then((result) => {
    if (result.isConfirmed) {
        // Aksi hapus
        window.location.href = deleteUrl;
    }
});
```

### 4. **Loading States**
```javascript
Swal.fire({
    title: 'Menyimpan...',
    text: 'Mohon tunggu sebentar',
    allowOutsideClick: false,
    allowEscapeKey: false,
    showConfirmButton: false,
    didOpen: () => {
        Swal.showLoading();
    }
});
```

### 5. **Form Validation Alerts**
```javascript
Swal.fire({
    icon: 'warning',
    title: 'Data Tidak Valid',
    text: 'Mohon lengkapi semua field yang diperlukan',
    confirmButtonColor: '#ffc107'
});
```

## 📁 File yang Telah Diupdate

### **Admin Module:**
- ✅ `admin/dashboard_admin.php` - Konfirmasi hapus perkara & notifikasi flashdata
- ✅ `admin/edit_perkara.php` - Success/error messages
- ✅ `admin/tambah_user.php` - Form validation & success/error messages
- ✅ `admin/edit_user.php` - Success/error messages  
- ✅ `admin/kelola_user.php` - Konfirmasi hapus user & flashdata

### **User Module:**
- ✅ `user/edit_perkara.php` - Success/error messages
- ✅ `perkara/tambah_perkara.php` - Success/error messages

### **Global Files:**
- ✅ `navbar/header.php` - SweetAlert2 CSS CDN
- ✅ `navbar/footer.php` - SweetAlert2 JS CDN

## 🎨 Tipe Notifikasi yang Tersedia

### **1. Toast Notifications (Pojok Kanan Atas)**
- Untuk success messages
- Auto-hide dengan timer
- Progress bar untuk visual feedback

### **2. Modal Dialogs (Tengah Layar)**
- Untuk error messages
- Konfirmasi actions (hapus, edit)
- Form validation warnings

### **3. Loading Overlays**
- Saat form submission
- Proses delete/update
- Mencegah multiple clicks

## 💡 Best Practices

### **1. Success Messages**
```php
// Controller
$this->session->set_flashdata('success', 'Data berhasil disimpan!');

// View
<?php if ($this->session->flashdata('success')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '<?= addslashes($this->session->flashdata('success')) ?>',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        toast: true,
        position: 'top-end'
    });
});
</script>
<?php endif; ?>
```

### **2. Error Messages**
```php
// Controller
$this->session->set_flashdata('error', 'Gagal menyimpan data!');

// View
<?php if ($this->session->flashdata('error')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '<?= addslashes($this->session->flashdata('error')) ?>',
        confirmButtonText: 'OK',
        confirmButtonColor: '#dc3545'
    });
});
</script>
<?php endif; ?>
```

### **3. Delete Confirmation**
```html
<!-- HTML Button -->
<a href="javascript:void(0)" 
   data-url="<?= site_url('admin/hapus_perkara/' . $id) ?>"
   class="btn btn-danger btn-hapus">
    <i class="fas fa-trash"></i> Hapus
</a>

<!-- JavaScript -->
<script>
document.querySelectorAll('.btn-hapus').forEach(function(button) {
    button.addEventListener('click', function() {
        const url = this.getAttribute('data-url');
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});
</script>
```

## 🎯 Benefits

### **User Experience:**
- ✅ Visual feedback yang menarik
- ✅ Consistent design patterns
- ✅ Prevent accidental deletions
- ✅ Clear success/error states
- ✅ Professional appearance

### **Developer Experience:**
- ✅ Easy to implement
- ✅ Consistent API
- ✅ Customizable themes
- ✅ Good browser support
- ✅ Mobile responsive

## 📚 SweetAlert2 CDN Links

### CSS (sudah ditambahkan di header.php):
```html
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css" rel="stylesheet">
```

### JavaScript (sudah ditambahkan di footer.php):
```html
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
```

## 🎨 Customization Options

### **Icons Available:**
- `success` - ✅ Hijau untuk berhasil
- `error` - ❌ Merah untuk gagal  
- `warning` - ⚠️ Kuning untuk peringatan
- `info` - ℹ️ Biru untuk informasi
- `question` - ❓ Untuk konfirmasi

### **Positions Available:**
- `top-end` - Pojok kanan atas (untuk toast)
- `center` - Tengah layar (untuk modal)
- `top-start` - Pojok kiri atas
- `bottom-end` - Pojok kanan bawah

### **Timer Options:**
- `timer: 3000` - Auto close dalam 3 detik
- `timerProgressBar: true` - Tampilkan progress bar
- `showConfirmButton: false` - Sembunyikan tombol OK

## 📱 Responsive Design

SweetAlert2 sudah responsive dan akan menyesuaikan dengan ukuran layar device, memberikan experience yang konsisten di desktop, tablet, dan mobile.

---

**✨ Semua notifikasi dalam aplikasi Perkara sekarang menggunakan SweetAlert2 untuk user experience yang lebih baik!**