# 📖 PANDUAN TESTING ARTIKEL EDITOR YANG SUDAH DIPERBAIKI

## ✅ Persiapan

1. **Pastikan database sudah running**
   ```
   - XAMPP Control Panel → Start MySQL
   - Database: upsm_xirpl2 sudah ada
   ```

2. **Pastikan Apache running**
   ```
   - XAMPP Control Panel → Start Apache
   - Akses: http://localhost/warehouse_management
   ```

## 🧪 Testing Steps

### Step 1: Login ke System
```
1. Buka: http://localhost/warehouse_management
2. Klik "Login" atau ke: http://localhost/warehouse_management/auth/simple_login.php
3. Login dengan credentials admin
   - Email: admin@example.com
   - Password: (sesuai database)
```

### Step 2: Navigasi ke Articles Page
```
1. Setelah login, klik menu "Articles" di sidebar
2. URL: http://localhost/warehouse_management/pages/articles.php
3. Seharusnya melihat:
   - Search bar di atas
   - "+ Add Article" button (biru)
   - Tabel list artikel (jika ada)
```

### Step 3: Test Add New Article (CREATE)
```
1. Klik "+ Add Article" button
2. Form modal akan muncul dengan fields:
   - Title (text input)
   - Author (dropdown select)
   - Content (WYSIWYG editor - Quill.js)

3. Isi form:
   Title: "Test Artikel Editor"
   Author: Pilih dari dropdown (harus ada minimal 1 author)
   Content: Ketik text dan coba formatting:
     - Pilih text → klik Bold (B)
     - Pilih text → klik Italic (I)
     - Buat Bullet List
     - Buat Ordered List
     - Tambah blockquote
     - Tambah link

4. Klik "Create Article" button
5. Seharusnya:
   - Modal tutup otomatis
   - Artikel muncul di table dengan status "terbit"
   - Tidak ada error di browser console
```

### Step 4: Test View Article (READ)
```
1. Di table artikel, cari artikel yang baru dibuat
2. Klik button "View" (hijau)
3. Modal view akan terbuka dan menampilkan:
   - Title artikel
   - Author name
   - Published date
   - Content dengan HTML formatting intact
     (bold, italic, lists, dll seharusnya terlihat)

4. Verifikasi:
   - Format text sesuai dengan yang diinput
   - Tidak ada tag HTML raw terlihat
   - Semua formatting terender dengan benar
```

### Step 5: Test Edit Article (UPDATE)
```
1. Di table, klik button "Edit" (biru muda)
2. Edit modal akan terbuka dengan form:
   - Title field terisi dengan judul lama
   - Author dropdown terisi dengan author lama
   - Content editor terisi dengan content lama (dalam HTML)

3. Edit content:
   - Tambah text baru
   - Ubah formatting
   - Hapus beberapa bagian
   - Tambah elemen baru

4. Klik "Update Article" button
5. Verifikasi:
   - Modal tutup
   - Table menampilkan updated content
   - Excerpt terupdate dengan benar
```

### Step 6: Verify Database
```
1. Buka phpMyAdmin: http://localhost/phpmyadmin
2. Database: upsm_xirpl2 → Table: tb_artikel
3. Lihat field 'isi' dari artikel yang baru dibuat/diedit
4. Seharusnya melihat HTML content seperti:
   <h2>Title</h2><p>Paragraph text dengan <strong>bold</strong>...</p>
```

### Step 7: Test Delete Article (DELETE)
```
1. Di table, klik button "Delete" (merah)
2. Confirmation modal akan muncul
3. Klik "Yes, delete" untuk confirm
4. Artikel akan hilang dari table
5. Verify di phpMyAdmin bahwa record dihapus dari database
```

## ✨ Expected Results

### Add Article - Success Criteria ✓
- [ ] Form modal appears with all fields
- [ ] Quill editor toolbar visible dengan semua tools
- [ ] Can type and format text
- [ ] Form submit tanpa error
- [ ] Artikel muncul di table
- [ ] Database menyimpan HTML content

### View Article - Success Criteria ✓
- [ ] Modal terbuka menampilkan artikel
- [ ] Semua formatting terender dengan benar
- [ ] No HTML tags visible (only rendered output)
- [ ] Layout responsive dan readable

### Edit Article - Success Criteria ✓
- [ ] Edit modal terbuka dengan data lama
- [ ] Editor menampilkan content dengan formatting preserved
- [ ] Bisa edit dan reformat
- [ ] Update berhasil tanpa error
- [ ] Changes terupdate di table dan database

### Delete Article - Success Criteria ✓
- [ ] Delete confirmation modal muncul
- [ ] Article dihapus dari table setelah confirm
- [ ] Article dihapus dari database

## 🔧 Troubleshooting

### Problem: Editor tidak muncul
**Solusi:**
- Buka DevTools (F12) → Console tab
- Check untuk error messages
- Refresh page (Ctrl+F5)
- Pastikan Quill CDN ter-load (Network tab → quill.js)

### Problem: Content tidak tersimpan
**Solusi:**
- Check DevTools → Network tab → form submission
- Look at response status (harus 302 redirect atau 200)
- Check PHP error log: `C:\xampp\apache\logs\error.log`
- Verify database connection di `config/koneksi.php`

### Problem: HTML tidak terender di view modal
**Solusi:**
- Verify content di phpMyAdmin - harus ada HTML tags
- Check DevTools → Inspect element view modal
- Pastikan tidak ada extra HTML encoding

### Problem: Author dropdown kosong
**Solusi:**
- Buka phpMyAdmin → tb_author_artikel table
- Harus ada minimal 1 author record
- Jika kosong, insert author baru:
  ```sql
  INSERT INTO tb_author_artikel (nama) VALUES ('Admin Author');
  ```

## 📝 Test Report Template

```
Test Date: __________
Tester: __________

CREATE Article:
  - Form opens: [PASS/FAIL]
  - Can edit content: [PASS/FAIL]
  - Submit works: [PASS/FAIL]
  - Saved to DB: [PASS/FAIL]
  Comments: ______________________

READ Article:
  - View modal opens: [PASS/FAIL]
  - HTML renders correctly: [PASS/FAIL]
  - All formatting visible: [PASS/FAIL]
  Comments: ______________________

UPDATE Article:
  - Edit modal opens: [PASS/FAIL]
  - Old content loads: [PASS/FAIL]
  - Can edit: [PASS/FAIL]
  - Update works: [PASS/FAIL]
  Comments: ______________________

DELETE Article:
  - Delete confirmation: [PASS/FAIL]
  - Article removed: [PASS/FAIL]
  Comments: ______________________

Overall: [PASS/FAIL]
```

## 📞 Support Info

File-file yang dimodifikasi:
- `contents/articles_content.php` - Main template & Quill editor
- `auth/actions/tambah_artikel.php` - Create handler
- `auth/actions/update_artikel.php` - Update handler (tidak ada perubahan)
- `auth/actions/delete_artikel.php` - Delete handler (tidak ada perubahan)

Jika ada issue, check:
1. Browser console (F12)
2. Network tab untuk form submissions
3. PHP error log di XAMPP
4. Database structure di phpMyAdmin
