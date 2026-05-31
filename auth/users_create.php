<?php
require_once __DIR__ . '/acl.php';
require_once dirname(__DIR__) . '/config/koneksi.php';

// Only admin can create users
require_role('admin');
if (!is_admin_confirmed()) {
  // require admin confirmation
  header('HTTP/1.1 403 Forbidden');
  echo 'Admin confirmation required';
  exit;
}

$isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
  } else {
    header('Location: ../pages/users.php');
  }
  exit;
}

$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$country = trim($_POST['country'] ?? '');
$city = trim($_POST['city'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$zip_code = trim($_POST['zip_code'] ?? '');
$role = $_POST['role'] ?? 'staff';
$status = isset($_POST['status']) ? (int)$_POST['status'] : 1;

if ($first_name === '' || $email === '' || $password === '') {
  $msg = 'First name, email and password wajib diisi.';
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $msg]);
  } else {
    header('Location: ../pages/users.php?msg=' . urlencode($msg));
  }
  exit;
}

$hashed = md5($password);

$stmt = $koneksi->prepare('INSERT INTO tb_user (first_name, last_name, email, password, country, city, phone_number, zip_code, profile_picture, role, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
if (!$stmt) {
  $msg = 'Prepare gagal: ' . $koneksi->error;
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $msg]);
  } else {
    header('Location: ../pages/users.php?msg=' . urlencode($msg));
  }
  exit;
}

$profile_picture = '';
$stmt->bind_param('ssssssssssi', $first_name, $last_name, $email, $hashed, $country, $city, $phone, $zip_code, $profile_picture, $role, $status);

if ($stmt->execute()) {
  $msg = 'User berhasil dibuat.';
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => $msg]);
  } else {
    header('Location: ../pages/users.php?msg=' . urlencode($msg));
  }
} else {
  $msg = 'Gagal membuat user: ' . $stmt->error;
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $msg]);
  } else {
    header('Location: ../pages/users.php?msg=' . urlencode($msg));
  }
}

$stmt->close();
exit;
