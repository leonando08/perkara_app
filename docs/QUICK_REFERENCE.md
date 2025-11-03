# 🚀 Quick Reference - Global Table CSS

## 📦 Basic Structure

```html
<div class="content-wrapper">
    <div class="page-header">
        <div>
            <h2 class="page-title">Title</h2>
        </div>
        <div class="action-buttons">
            <button class="btn btn-success">Button</button>
        </div>
    </div>

    <div class="content-card p-0">
        <div class="table-wrapper">
            <div class="table-responsive-custom">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="number-column">No</th>
                            <th class="text-column">Text</th>
                            <th class="action-column">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Data</td>
                            <td>
                                <button class="btn btn-warning btn-sm">Edit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
```

## 🎨 Column Classes

```
.number-column    → 50-70px   (No urut)
.text-column      → 150-250px (Text panjang)
.date-column      → 100-120px (Tanggal)
.status-column    → 90-100px  (Status)
.action-column    → 100-120px (Buttons)
```

## 🎯 Button Colors

```html
<button class="btn btn-primary">Primary</button>
<button class="btn btn-success">Success</button>
<button class="btn btn-warning">Warning</button>
<button class="btn btn-danger">Danger</button>
```

## 🏷️ Badge Colors

```html
<span class="badge bg-success">Success</span>
<span class="badge bg-warning">Warning</span>
<span class="badge bg-danger">Danger</span>
```

## 📊 Stats Cards

```html
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">100</div>
        <div class="stat-label">Label</div>
    </div>
</div>
```

## 🔍 Search/Filter

```html
<div class="search-card">
    <form>
        <label class="form-label">Label</label>
        <input class="form-control" type="text">
        <button class="btn btn-success">Search</button>
    </form>
</div>
```

## ⚡ Quick Tips

1. **Hapus CSS lokal** yang mendefinisikan `.table`, `.btn`, dll
2. **Gunakan class global** yang sudah ada
3. **Test responsive** di mobile dan desktop
4. **Hard refresh** (Ctrl+Shift+R) setelah perubahan
5. **Jangan inline style** - gunakan class

## 📱 Responsive Breakpoints

- Mobile: < 576px
- Tablet: 577-992px
- Desktop: > 993px

## 🎉 One File = All Pages!

Update `assets/css/table-style.css` → Semua halaman berubah!
