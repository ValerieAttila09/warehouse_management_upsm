## 🚀 SETUP GUIDE: Artikel Management dengan User Linking

### STEP 1: Database Migration

Jalankan query SQL di bawah di phpMyAdmin atau MySQL client Anda:

```sql
-- Step 1.1: Tambahkan kolom user_id ke tb_artikel
ALTER TABLE tb_artikel ADD COLUMN user_id INT UNSIGNED AFTER id_penulis;

-- Step 1.2: (OPTIONAL) Add Foreign Key untuk integrity
ALTER TABLE tb_artikel ADD CONSTRAINT fk_artikel_user
FOREIGN KEY (user_id) REFERENCES tb_user(id_user) ON DELETE SET NULL;

-- Step 1.3: (OPTIONAL) Link existing articles jika ada
-- Hanya jalankan jika Anda sudah punya artikel lama dan ingin link ke user
UPDATE tb_artikel a
JOIN tb_author_artikel p ON a.id_penulis = p.id
JOIN tb_user u ON u.email = p.email
SET a.user_id = u.id_user
WHERE a.user_id IS NULL;
```

✅ **Setelah migration selesai, artikel baru akan otomatis punya user_id!**

---

### STEP 2: Test Fitur

#### Test sebagai STAFF USER:

1. **Login dengan user staff**
   - Go to: `http://localhost/warehouse_management/pages/articles.php`

2. **Create Article (Test ADD)**
   - Klik `+ Add Article` button
   - Lihat: Author field tidak ada lagi, tapi ada info box yang bilang "Article akan dibuat dengan akun Anda"
   - Fill Title: "My First Article"
   - Fill Content: "Ini adalah artikel pertama saya"
   - Klik `Create Article`
   - ✅ Expected: Success message + artikel muncul di list

3. **Edit Own Article (Test EDIT Own)**
   - Click `Edit` pada artikel yang baru dibuat
   - Ubah title menjadi: "My Updated Article"
   - Ubah content sedikit
   - Klik `Update Article`
   - ✅ Expected: Success message + artikel terupdate

4. **Delete Own Article (Test DELETE Own)**
   - Click `Delete` pada artikel yang sama
   - Klik `Yes, delete`
   - ✅ Expected: Success message + artikel hilang dari list

---

#### Test sebagai ADMIN USER:

1. **Login dengan user admin**
   - Go to: `http://localhost/warehouse_management/pages/articles.php`

2. **Lihat Filter Dropdown**
   - Perhatikan di search bar area
   - Ada dropdown filter yang bilang "All Authors"
   - ✅ Expected: Dropdown muncul (hanya untuk admin)

3. **Create & Edit Artikel Admin**
   - Buat artikel baru sebagai admin (sama seperti staff)
   - Edit artikel tersebut (harus berhasil)

4. **Test Edit Artikel Milik Staff**
   - Buat artikel terlebih dahulu dengan staff account
   - Login sebagai admin
   - Di halaman artikel, admin harusnya bisa lihat artikel staff
   - Click `Edit` pada artikel staff tersebut
   - Ubah content
   - Klik `Update Article`
   - ✅ Expected: Success! Admin bisa edit artikel orang lain

5. **Test Delete Artikel Milik Staff**
   - Click `Delete` pada artikel staff
   - Klik `Yes, delete`
   - ✅ Expected: Success! Admin bisa delete artikel orang lain

6. **Test Filter by Author**
   - Di dropdown filter, pilih salah satu author
   - ✅ Expected: Hanya artikel dari author itu yang muncul
   - Pilih "All Authors" lagi
   - ✅ Expected: Semua artikel muncul lagi

7. **Test Search + Filter Kombinasi**
   - Search untuk "Article" (keyword)
   - Filter by Author tertentu
   - ✅ Expected: Artikel yang match kedua kriteria muncul

---

### STEP 3: Verify Database Structure

#### Check di phpMyAdmin:

1. **Buka table `tb_artikel`**
   - Lihat kolom `user_id` sudah ada
   - ✅ Kolom baru berhasil ditambahkan

2. **Insert artikel baru dari UI**
   - Di dalam database, check:
     - `judul` = apa yang diinput
     - `isi` = HTML content
     - `id_penulis` = ID dari author di tb_author_artikel
     - `user_id` = ID dari user yang login (baru!)
   - ✅ Semua data tersimpan dengan benar

3. **Check `tb_author_artikel`**
   - Lihat ada entry baru untuk setiap user yang membuat artikel
   - Email dan nama match dengan user profile
   - ✅ Author entry otomatis tercreate

---

### STEP 4: Error Handling Test

#### Test Authorization Error:

1. **Login dengan Staff User A**
   - Buat artikel baru (Article A)
   - Catat artikel ID

2. **Logout dan Login dengan Staff User B**
   - Pergi ke halaman artikel
   - Lihat Article A milik Staff A

3. **Coba Edit Article A (dari user B)**
   - Click Edit pada Article A
   - Ubah content
   - Klik `Update Article`
   - ❌ Expected: Error message "You do not have permission to perform this action"
   - ✅ Ini berarti authorization protection bekerja!

4. **Coba Delete Article A (dari user B)**
   - Click Delete pada Article A
   - Klik `Yes, delete`
   - ❌ Expected: Error message "You do not have permission..."
   - ✅ Protection bekerja!

5. **Login sebagai Admin**
   - Bisa edit dan delete Article A tanpa masalah
   - ✅ Admin override berhasil!

---

### STEP 5: Troubleshooting

#### Problem: Authorization error padahal seharusnya bisa edit

**Solusi:**

- Check: Artikel punya `user_id` tidak?
  - Artikel lama mungkin kosong `user_id`
  - Jalankan migrasi data: `UPDATE tb_artikel ... WHERE a.user_id IS NULL`
- Check: `$_SESSION['user_id']` ter-set tidak?
  - Login ulang untuk update session

#### Problem: Filter dropdown tidak muncul untuk admin

**Solusi:**

- Check: `$_SESSION['role']` = 'admin' tidak?
- Clear browser cache
- Check `articles_content.php` di baris filter

#### Problem: "Cannot edit your own article" error

**Solusi:**

- Pastikan database migration sudah dijalankan (kolom `user_id` ada)
- Check database: apakah `user_id` ter-set untuk artikel?
- Buat artikel baru (guaranteed ada `user_id`)

---

### STEP 6: Files Modified

Berikut files yang telah diubah (untuk referensi):

1. **`auth/actions/tambah_artikel.php`** ✅
   - Auto-link author dari user login
   - Create author entry jika belum ada
   - Set user_id

2. **`auth/actions/update_artikel.php`** ✅
   - Authorization check (staff hanya bisa edit sendiri)
   - Remove id_penulis dari update (author tidak bisa diubah)

3. **`auth/actions/delete_artikel.php`** ✅
   - Authorization check (staff hanya bisa delete sendiri)

4. **`contents/articles_content.php`** ✅
   - Remove author dropdown dari Add form
   - Add info box untuk auto-author
   - Make author read-only di Edit form
   - Add alert messages (success/error)
   - Filter dropdown untuk admin

---

### 📋 Checklist Sebelum Production

- [ ] Database migration sudah dijalankan
- [ ] User_id column ada di tb_artikel
- [ ] Test create artikel sebagai staff ✅ berhasil
- [ ] Test edit artikel sendiri ✅ berhasil
- [ ] Test edit artikel orang (error) ✅ error muncul
- [ ] Test delete artikel sendiri ✅ berhasil
- [ ] Test admin bisa edit/delete artikel orang ✅ berhasil
- [ ] Filter dropdown muncul untuk admin ✅ muncul
- [ ] Search + filter kombinasi ✅ bekerja
- [ ] Error messages display dengan baik ✅ tampil
- [ ] Tidak ada SQL error di PHP logs ✅ clean

---

### 🎓 Architecture Overview

```
tb_user (user yang login)
   ↓ (id_user)
   └─→ tb_artikel.user_id (siapa yang create artikel)
       ↓ (id_penulis)
       └─→ tb_author_artikel (author profile)
```

**Hubungan:**

- Satu user bisa create banyak artikel
- Satu user = satu author profile (auto created)
- Satu artikel hanya punya satu author
- Satu artikel hanya punya satu creator (user_id)

---

### 📞 Support

Jika ada masalah:

1. Check files sudah diupdate dengan benar
2. Check database migration sudah jalan
3. Check session data ter-set `user_id` dan `role`
4. Check PHP error logs untuk debug

**Sekarang siap untuk production!** 🚀
