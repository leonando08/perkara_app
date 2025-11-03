# MASTER LAYOUT CSS - DOKUMENTASI PENGGUNAAN
# Sistem Informasi Perkara - Single Layout Management System

## OVERVIEW
File `master-layout.css` adalah sistem layout tunggal yang mengatur semua tampilan di aplikasi Sistem Informasi Perkara. Dengan satu file ini, Anda dapat mengontrol layout seluruh aplikasi tanpa perlu edit banyak file.

## STRUKTUR FILE YANG DIATUR:
✅ Navbar positioning dan styling
✅ Sidebar layout dan responsiveness  
✅ Main content area dan spacing
✅ Page headers dan components
✅ Form layouts dan styling
✅ Table layouts dan responsiveness
✅ Button system dan variants
✅ Utility classes
✅ Responsive breakpoints (mobile, tablet, desktop)
✅ Print styles
✅ Accessibility features

## CARA MENGGUNAKAN:

### 1. SUDAH TERINTEGRASI
File sudah otomatis di-load di `header.php`:
```html
<link href="<?= base_url('assets/css/master-layout.css?v=' . time()); ?>" rel="stylesheet" />
```

### 2. HTML STRUCTURE YANG DIDUKUNG:

#### Page Layout:
```html
<div class="main-content">
    <div class="content-wrapper">
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2 class="page-title">Judul Halaman</h2>
                <p class="page-subtitle">Deskripsi halaman</p>
            </div>
            <div class="page-actions">
                <button class="btn btn-primary">Action</button>
            </div>
        </div>
        
        <!-- Content Cards -->
        <div class="content-card">
            <div class="content-card-header">Header</div>
            <div class="content-card-body">Content</div>
            <div class="content-card-footer">Footer</div>
        </div>
    </div>
</div>
```

#### Statistics Grid:
```html
<div class="stats-grid">
    <div class="stats-card">
        <div class="stats-number">123</div>
        <div class="stats-label">Total Data</div>
    </div>
</div>
```

#### Form Layout:
```html
<div class="form-grid">
    <div class="form-group">
        <label class="form-label">Label</label>
        <input type="text" class="form-control">
    </div>
</div>
```

#### Table Layout:
```html
<div class="table-container">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr><th>Header</th></tr>
            </thead>
            <tbody>
                <tr><td>Data</td></tr>
            </tbody>
        </table>
    </div>
</div>
```

### 3. BUTTON SYSTEM:
```html
<button class="btn btn-primary">Primary</button>
<button class="btn btn-secondary">Secondary</button>
<button class="btn btn-success">Success</button>
<button class="btn btn-danger">Danger</button>
<button class="btn btn-warning">Warning</button>
<button class="btn btn-info">Info</button>
```

### 4. UTILITY CLASSES:
```html
<!-- Spacing -->
<div class="mb-4">Margin bottom</div>
<div class="mt-3">Margin top</div>

<!-- Display -->
<div class="d-flex justify-content-between align-items-center">Flex container</div>

<!-- Text alignment -->
<div class="text-center">Centered text</div>
```

## RESPONSIVE BREAKPOINTS:

### Desktop (>1024px):
- Sidebar: 280px width
- Main content: 290px margin-left
- Full functionality

### Tablet (769px - 1024px):
- Sidebar: 250px width  
- Main content: 260px margin-left
- Adjusted spacing

### Mobile (≤768px):
- Sidebar: Hidden with overlay
- Main content: Full width (0px margin)
- Stacked layouts

## CUSTOMIZATION:

### Untuk mengubah warna theme:
Edit CSS variables di bagian `:root` dalam master-layout.css:
```css
:root {
    --bg-primary: #f8f9fa;        /* Background utama */
    --bg-secondary: #ffffff;      /* Background card */
    --text-primary: #2d3748;      /* Text utama */
    /* dst... */
}
```

### Untuk mengubah spacing:
```css
:root {
    --content-padding-desktop: 24px;  /* Padding content desktop */
    --content-margin-desktop: 290px;  /* Margin dari sidebar */
    /* dst... */
}
```