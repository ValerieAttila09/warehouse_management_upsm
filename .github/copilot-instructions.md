# Copilot Instructions for Warehouse Management System

## Project Overview

This is a **warehouse management web application** built with PHP, MySQL, and Tailwind CSS. It features:

- **Two-tier architecture**: 
  - Public landing page (Tailwind + GSAP animations)
  - Authenticated dashboard system (role-based access control)
- **Two user roles**: `admin` and `staff` (both access dashboard, distinct permissions)
- **Database-driven**: MySQL with prepared statements throughout
- **Frontend stack**: Vanilla JavaScript, Tailwind CSS, GSAP animations, Flowbite components

## Architecture & Key Patterns

### Directory Structure

```
├── index.php                 # Redirect to landing_page.php
├── landing_page.php          # Public-facing marketing page
├── config/
│   └── koneksi.php           # Database connection (mysqli)
├── auth/
│   ├── acl.php               # Authorization helpers (session-based)
│   ├── simple_login.php      # Login form/handler
│   ├── simple_register.php   # Registration form/handler
│   ├── logout.php            # Session destroyer
│   ├── users_*.php           # User CRUD operations
│   └── admin_confirm.php     # Admin password confirmation
├── pages/                    # Protected page entry points
│   ├── dashboard.php
│   ├── stocks.php
│   ├── users.php
│   └── profile.php
├── contents/                 # Template fragments (included by pages/*)
│   ├── header.php            # <head> element with CDN links
│   ├── dashboard_content.php # Main dashboard grid
│   ├── widgets/
│   │   ├── navbar.php        # Top navigation bar
│   │   └── sidebar.php       # Side navigation (sidebar)
│   └── *_content.php         # Page-specific content
├── js/
│   ├── landing-animations.js # GSAP animations for landing page
│   └── index.js              # Dashboard/app JavaScript
├── style/
│   ├── global.css            # Base styles
│   └── landing.css           # Landing page-specific styles
└── uploads/                  # User-uploaded files
```

### Authentication & Authorization Flow

1. **Session-based auth** via `auth/acl.php`:
   - `require_login()` → Check if user_id exists in $_SESSION
   - `require_role($roles)` → Check if user role is in allowed list
   - `verify_admin_password($password)` → Compare md5 hash (used for sensitive actions)
   - `is_admin_confirmed($ttl)` → Check if admin recently re-confirmed via password

2. **Database schema**:
   - `tb_user` table: `id_user`, `email`, `password` (md5), `role` ('admin'|'staff'), `status` (1=active)
   - Passwords stored as MD5 (legacy; consider migration to bcrypt)

3. **Protected pages pattern**:
   ```php
   require_once dirname(__DIR__) . '/auth/acl.php';
   require_role(['staff', 'admin']);  // or specific role
   ```

### Template Composition Pattern

Pages are composed from multiple fragments:

```php
<?php include "../contents/header.php"; ?>  <!-- <head> with CDN -->
<?php include "../contents/widgets/navbar.php"; ?>  <!-- Top nav -->
<?php include "../contents/widgets/sidebar.php"; ?>  <!-- Sidebar -->
<?php include "../contents/{feature}_content.php"; ?>  <!-- Page content -->
```

This pattern allows consistent layout across all dashboard pages. **Key decision**: Fragments use relative includes (`../contents/`), so always maintain the correct directory depth when adding new pages.

### Database Connection

- Located: `config/koneksi.php`
- **Connection details hardcoded**: localhost, root (no password), database: `upsm_xirpl2`
- All queries use **prepared statements** (`$koneksi->prepare()`) with `bind_param()` to prevent SQL injection
- **Important**: Always use prepared statements for user input

### Frontend Styles & Animations

1. **Landing page** (`landing_page.php`):
   - Tailwind CSS utility classes (via CDN)
   - GSAP animations in `js/landing-animations.js`
   - Custom CSS in `style/landing.css` for overrides
   - Color scheme: Emerald (#10b981), Cyan (#06b6d4), Dark slate backgrounds

2. **Dashboard** (`pages/dashboard.php` and others):
   - Flowbite admin template components (loaded via CDN in `header.php`)
   - Dark mode support via Tailwind's `dark:` prefix
   - Responsive grid layouts

3. **CSS files**:
   - `style/global.css` → Base reset and global rules
   - `style/landing.css` → Landing-page overrides (color vars, custom animations)
   - Tailwind CSS applied inline via class attributes (no build step)

## Conventions & Patterns

### Variable Naming

- PHP: Snake case (`$user_id`, `$is_logged_in`, `$db_email`)
- JavaScript: Camel case (`userId`, `isLoggedIn`, `dbEmail`)
- HTML/CSS: Kebab case classes (`main-content`, `sidebarBackdrop`)

### Database Queries

- All user input → prepared statements
- Session variables (`$_SESSION['user_id']`, `$_SESSION['role']`) set after login verification
- Result binding pattern:
  ```php
  $stmt->bind_result($id_user, $db_email, $role);
  if ($stmt->fetch()) { /* row found */ }
  $stmt->close();
  ```

### File Includes

- Always use relative paths from the calling file:
  ```php
  require_once dirname(__DIR__) . '/config/koneksi.php';  // Go up 1 level
  include "../contents/header.php";  // Relative to current dir
  ```
- Prefer `require_once` for config/helpers to prevent duplicates
- Use `include` for template fragments

### Redirects & Navigation

- Post-login redirect: `../pages/dashboard.php`
- Failed auth: Redirect to `auth/simple_login.php` or show 403
- Always use `exit;` after `header()` to stop execution

## Running & Testing

### Local Development Setup

1. **Prerequisites**:
   - XAMPP (Apache + PHP + MySQL)
   - MySQL database: `upsm_xirpl2` (create if not exists)
   - Apache document root pointing to `C:\xampp\htdocs\warehouse_management`

2. **Start services**:
   - Open XAMPP Control Panel
   - Click "Start" for Apache and MySQL
   - Verify at `http://localhost/warehouse_management`

3. **First-time setup**:
   - Ensure `upsm_xirpl2` database exists in MySQL
   - Create `tb_user` table with columns: `id_user`, `email`, `password`, `role`, `status`
   - Insert seed admin user (if needed)

### Accessing the Application

- **Landing page**: `http://localhost/warehouse_management` or `http://localhost/warehouse_management/landing_page.php`
- **Dashboard**: `http://localhost/warehouse_management/pages/dashboard.php` (redirects to login if not authenticated)
- **Login**: `http://localhost/warehouse_management/auth/simple_login.php`

### Testing Database Queries

- Use prepared statements in all new queries
- Test with both admin and staff roles
- Verify `require_role()` guards work by attempting unauthorized access

### Browser Testing

- Test landing page animations in Chrome, Firefox, Safari, Edge (GSAP should run in all)
- Test responsive design: resize to mobile (< 768px), tablet (768-1024px), desktop (> 1024px)
- Check dark mode toggle if implemented

## Important Notes

### Security Considerations

- **Password hashing**: Currently MD5 (weak). Consider migrating to bcrypt.
- **Admin confirmation**: `is_admin_confirmed()` should be checked before dangerous operations (DELETE user, etc.)
- **Session variables**: Validated on each page load via `require_role()`; no token expiration currently

### Common Pitfalls

1. **File path confusion**: Each page type has different depths (pages/ vs contents/). Use `dirname(__DIR__)` to go up consistently.
2. **Template fragments**: Must be included in correct order to access required variables (e.g., header must be first).
3. **Relative paths**: JavaScript CDN links in `header.php` use relative paths (`./style/`, `./js/`). Changing directory structure breaks includes.
4. **Database**: Connection fails silently if `upsm_xirpl2` doesn't exist; check PHP error logs.

## User Management System

### Architecture

User management is **admin-only** and follows a strict pattern of request routing to backend handlers:

1. **Entry Point**: `pages/users.php`
   - Requires role: `admin`
   - Includes template fragments (navbar, sidebar, users_content.php)
   - No business logic here; purely layout composition

2. **Content Template**: `contents/users_content.php`
   - Renders user list table with search, add button, export button
   - Modal dialogs for add/edit forms (data-modal-target hooks)
   - Checkboxes for bulk operations

3. **API Handlers** (backend):
   - `auth/users_create.php` — POST to create new user
   - `auth/users_update.php` — POST to update existing user
   - `auth/users_delete.php` — POST/GET to soft or hard delete user

### Database Schema: `tb_user`

```
Columns:
  id_user (INT, PRIMARY KEY, AUTO_INCREMENT)
  first_name (VARCHAR)
  last_name (VARCHAR)
  email (VARCHAR, UNIQUE)
  password (VARCHAR 32, MD5 hashed)
  country (VARCHAR)
  city (VARCHAR)
  phone_number (VARCHAR)
  zip_code (VARCHAR)
  profile_picture (VARCHAR, path/URL)
  role (ENUM 'admin', 'staff', default 'staff')
  status (INT, 1=active 0=inactive)
```

### Key Patterns

#### 1. Admin Confirmation on Sensitive Operations

All CRUD operations require **admin password confirmation**:

```php
require_role('admin');
if (!is_admin_confirmed()) {
  header('HTTP/1.1 403 Forbidden');
  echo 'Admin confirmation required';
  exit;
}
```

The `is_admin_confirmed()` function checks if `$_SESSION['admin_confirmed_at']` is within 300 seconds (5 minutes) of current time. This is set by `auth/admin_confirm.php` after verifying password.

#### 2. Dual-Mode Response (Form + AJAX)

All handlers detect AJAX requests and respond accordingly:

```php
$isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

if ($isAjax) {
  header('Content-Type: application/json');
  echo json_encode(['success' => true/false, 'message' => $msg]);
} else {
  header('Location: ../pages/users.php?msg=' . urlencode($msg));
}
exit;
```

This allows both form submissions (redirect) and JavaScript AJAX (JSON response).

#### 3. Dynamic Prepared Statements for Updates

`users_update.php` builds queries dynamically based on which fields are provided (supports partial updates):

```php
$fields = [];
$params = [];
$types = '';

if ($first_name !== '') {
  $fields[] = 'first_name = ?';
  $types .= 's';
  $params[] = $first_name;
}
// ... repeat for each field

$sql = 'UPDATE tb_user SET ' . implode(', ', $fields) . ' WHERE id_user = ? LIMIT 1';
$types .= 'i';
$params[] = $id;

$stmt = $koneksi->prepare($sql);
call_user_func_array([$stmt, 'bind_param'], array_merge([$types], $params));
```

This pattern allows clients to update only changed fields without resending unchanged data.

#### 4. Password Reset Handling

- Password is optional in updates (can be null in POST)
- If provided, it's hashed with MD5: `md5($password)`
- Create uses hashed password; update checks `$password !== null && $password !== ''`

#### 5. Email-Based Lookup Fallback

`users_delete.php` accepts either `id_user` or `email`:

```php
if ($id <= 0) {
  $email = trim($_POST['email'] ?? $_GET['email'] ?? '');
  if ($email !== '') {
    // Query to find id_user by email
  }
}
```

This is useful for clients that can't easily pass numeric IDs.

#### 6. Self-Delete Prevention

Users cannot delete their own account:

```php
if ($id === ($_SESSION['user_id'] ?? 0)) {
  echo 'Anda tidak bisa menghapus akun Anda sendiri.';
  exit;
}
```

### User Form Fields

When adding/editing users, the following fields are collected:

| Field | Type | Notes |
|-------|------|-------|
| `first_name` | string | Required on create; optional on update |
| `last_name` | string | Optional |
| `email` | string | Required on create; optional on update; should be unique |
| `password` | string | Required on create; optional on update (can leave blank to keep existing) |
| `country` | string | Optional |
| `city` | string | Optional |
| `phone` | string | Maps to `phone_number` column |
| `zip_code` | string | Optional |
| `profile_picture` | string | URL or path to image |
| `role` | enum | `'admin'` or `'staff'` (defaults to `'staff'`) |
| `status` | int | `1` (active) or `0` (inactive); defaults to 1 on create |

### UI Components

The user list (`contents/users_content.php`) includes:

- **Search bar** — filters by email via GET query
- **Add User button** — opens modal to add new user (targets `#add-user-modal`)
- **Export button** — exports user list (not fully implemented; wired up but no backend)
- **User table** — list of all users with columns: checkbox, name, email, role, status, actions
- **Bulk operations** — checkboxes for future multi-select delete (UI ready)
- **Edit modal** — populated dynamically by JavaScript in `js/index.js`
- **Delete confirmation** — before hard delete

### Common Issues & Solutions

1. **"Admin confirmation required" on create/update/delete**
   - User must have confirmed admin password within the last 5 minutes
   - Check `is_admin_confirmed()` logic or call `auth/admin_confirm.php` first

2. **Partial updates not working**
   - Ensure POST body only includes fields to be updated (empty strings for unchanged)
   - Backend skips empty fields in the `if ($field !== '')` checks

3. **Email not unique error from database**
   - MySQL rejects duplicate emails if UNIQUE constraint exists on email column
   - Validate email uniqueness on client before submit

4. **Password not changing on update**
   - If password field is empty in POST, update skips it (by design)
   - Always include password if you want to change it

### Future Improvements

- Migrate password hashing to bcrypt
- Add CSRF tokens to forms
- Implement session timeout
- Use environment variables for database credentials
- Build and minify CSS/JS (currently relying on CDN)
- Add email validation and duplicate email detection
- Implement soft deletes (mark inactive instead of hard delete)
