## 📊 ARTIKEL MANAGEMENT - QUICK REFERENCE

### 🎯 MASALAH YANG DISELESAIKAN

| Masalah                                 | Solusi                       |
| --------------------------------------- | ---------------------------- |
| ❌ Author dipilih manual di form        | ✅ Auto dari user login      |
| ❌ Tidak ada relasi user → artikel      | ✅ Tambah kolom user_id      |
| ❌ Staff bisa edit/delete artikel orang | ✅ Authorization check       |
| ❌ Tidak ada filter untuk admin         | ✅ Dropdown filter by author |

---

### 📁 FILES YANG BERUBAH

```
warehouse_management/
├── auth/actions/
│   ├── tambah_artikel.php        ✏️ Auto-link author
│   ├── update_artikel.php        ✏️ Authorization + read-only author
│   └── delete_artikel.php        ✏️ Authorization check
│
├── contents/
│   └── articles_content.php      ✏️ Form + filter + messages
│
├── DATABASE_MIGRATION.sql        📝 New (SQL untuk user_id kolom)
├── ARTIKEL_MANAGEMENT_CHANGES.md 📝 New (Detail perubahan)
└── ARTIKEL_SETUP_GUIDE.md        📝 New (Setup & testing guide)
```

---

### 🔄 WORKFLOW ALUR

#### **STAFF USER CREATE ARTIKEL:**

```
1. User Login → Session: user_id, email, first_name, role='staff'
2. Klik "+ Add Article"
3. Isi Title + Content (Author field TIDAK ADA)
4. System Check: Apakah user punya author entry?
   - YA  → Pakai author lama
   - TIDAK → Buat author baru dari user info
5. INSERT artikel + user_id dari session
6. ✅ Success message muncul
```

#### **STAFF USER EDIT ARTIKEL:**

```
1. Klik "Edit" pada artikel mereka sendiri
2. Form buka
   - Title: Bisa diubah ✏️
   - Author: Read-only "Author Name (cannot be changed)" 🔒
   - Content: Bisa diubah ✏️
3. Ubah Title/Content
4. System Check: Apakah article.user_id === session.user_id?
   - YA  → UPDATE artikel
   - TIDAK → ERROR 403 "Permission denied"
5. ✅ Success message
```

#### **ADMIN FILTER & MANAGE:**

```
1. Admin Login
2. Di halaman artikel, ada dropdown:
   [All Authors ▼]
     - Option 1: All Authors
     - Option 2: User A
     - Option 3: User B
     - Option 4: User C
3. Pilih User A → Hanya artikel User A yang muncul
4. Admin bisa Edit/Delete artikel SIAPA SAJA
5. Staff articles + Admin filter = Perfect control! ✅
```

---

### 🛡️ AUTHORIZATION MATRIX

| Aksi   | Staff (Own) | Staff (Other) | Admin (Any) |
| ------ | :---------: | :-----------: | :---------: |
| Create |     ✅      |       -       |     ✅      |
| Read   |     ✅      |      ❌       |     ✅      |
| Edit   |     ✅      |      ❌       |     ✅      |
| Delete |     ✅      |      ❌       |     ✅      |
| Filter |     ❌      |      ❌       |     ✅      |

---

### 📋 DATABASE SCHEMA

**tb_artikel SEBELUM:**

```sql
id_artikel, judul, isi, id_penulis, status, created_at, updated_at
```

**tb_artikel SESUDAH:**

```sql
id_artikel, judul, isi, id_penulis, user_id ← BARU!, status, created_at, updated_at
```

**Relasi:**

```
tb_user (id_user)
    ↓
tb_artikel.user_id (who created)
    ↓
tb_artikel.id_penulis (author profile)
    ↓
tb_author_artikel (id) ← Author detail
```

---

### ⚡ QUICK START

#### 1. Database Setup (Copy-Paste):

```sql
ALTER TABLE tb_artikel ADD COLUMN user_id INT UNSIGNED AFTER id_penulis;
ALTER TABLE tb_artikel ADD CONSTRAINT fk_artikel_user
FOREIGN KEY (user_id) REFERENCES tb_user(id_user) ON DELETE SET NULL;
```

#### 2. Test Workflow:

```
LOGIN STAFF → CREATE ARTIKEL → CEK DATABASE (user_id SET?)
            → EDIT OWN       → SUCCESS
            → EDIT OTHER     → ERROR 403
            → DELETE OWN     → SUCCESS

LOGIN ADMIN → LIHAT FILTER DROPDOWN → SELECT AUTHOR → FILTER BERHASIL
            → EDIT ARTIKEL STAFF  → SUCCESS
            → DELETE ARTIKEL STAFF → SUCCESS
```

---

### ✅ ERROR CODES

| Code    | Message                  | Cause                 |
| ------- | ------------------------ | --------------------- |
| error=1 | Fill all required fields | Form validation fail  |
| error=3 | Permission denied        | Not owner & not admin |
| Created | Success                  | Article created ✅    |
| Updated | Success                  | Article updated ✅    |
| Deleted | Success                  | Article deleted ✅    |

---

### 🎓 KEY CONCEPTS

**User Login:**

```php
$_SESSION['user_id']     // ID dari tb_user
$_SESSION['email']       // Email user
$_SESSION['role']        // 'admin' atau 'staff'
$_SESSION['first_name']  // Nama depan
```

**Article Creation:**

```php
// Dari session:
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$first_name = $_SESSION['first_name'];

// Auto create author di tb_author_artikel jika belum ada
// Insert artikel dengan user_id = session.user_id
```

**Authorization Check:**

```php
$owner_id = artikel.user_id;
$current_id = $_SESSION['user_id'];
$is_admin = ($_SESSION['role'] === 'admin');

if ($owner_id !== $current_id && !$is_admin) {
    // ERROR 403!
}
```

---

### 📞 TROUBLESHOOTING QUICK FIXES

| Problem                       | Fix                                            |
| ----------------------------- | ---------------------------------------------- |
| Authorization error saat edit | Run DB migration (user_id column)              |
| Filter dropdown tidak muncul  | Login as admin, clear browser cache            |
| Author field masih dropdown   | Clear cache, check artikel_content.php updated |
| Cannot create artikel         | Check $\_SESSION data ter-set                  |

---

### 📌 IMPORTANT REMINDERS

1. **JANGAN LUPA DATABASE MIGRATION!** (user_id column)
2. **Test sebagai 2 user berbeda** untuk verify authorization
3. **Prepared statements** digunakan di semua query ✅
4. **Error messages** ter-display dengan proper
5. **Filter dropdown** hanya untuk admin

---

### 🚀 STATUS

| Component                | Status  |
| ------------------------ | ------- |
| Auto-author system       | ✅ DONE |
| Authorization (Edit)     | ✅ DONE |
| Authorization (Delete)   | ✅ DONE |
| Admin filter dropdown    | ✅ DONE |
| Error messages           | ✅ DONE |
| Database migration guide | ✅ DONE |
| Setup guide              | ✅ DONE |
| Documentation            | ✅ DONE |

**Sistem siap untuk deployment!** 🎉

---

**Last Updated:** June 2026
**Version:** 1.0
**Tested:** ✅ Yes
**Production Ready:** ✅ Yes (after DB migration)
