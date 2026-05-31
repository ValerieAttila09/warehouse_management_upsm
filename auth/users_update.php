<?php
require_once __DIR__ . '/acl.php';
require_once dirname(__DIR__) . '/config/koneksi.php';

// Only admin can update users
require_role('admin');
if (!is_admin_confirmed()) {
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

$id = (int)($_POST['id_user'] ?? 0);
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? null; // optional
$country = trim($_POST['country'] ?? '');
$city = trim($_POST['city'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$zip_code = trim($_POST['zip_code'] ?? '');
$role = $_POST['role'] ?? null;
$status = isset($_POST['status']) ? (int)$_POST['status'] : null;
$profile_picture = trim($_POST['profile_picture'] ?? '');

if ($id <= 0) {
  $msg = 'User id tidak valid.';
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $msg]);
  } else {
    header('Location: ../pages/users.php?msg=' . urlencode($msg));
  }
  exit;
}

$fields = [];
$params = [];
$types = '';

if ($first_name !== '') {
  $fields[] = 'first_name = ?';
  $types .= 's';
  $params[] = $first_name;
}
if ($last_name !== '') {
  $fields[] = 'last_name = ?';
  $types .= 's';
  $params[] = $last_name;
}
if ($email !== '') {
  $fields[] = 'email = ?';
  $types .= 's';
  $params[] = $email;
}
if ($password !== null && $password !== '') {
  $fields[] = 'password = ?';
  $types .= 's';
  $params[] = md5($password);
}
if ($country !== '') {
  $fields[] = 'country = ?';
  $types .= 's';
  $params[] = $country;
}
if ($city !== '') {
  $fields[] = 'city = ?';
  $types .= 's';
  $params[] = $city;
}
if ($phone !== '') {
  $fields[] = 'phone_number = ?';
  $types .= 's';
  $params[] = $phone;
}
if ($zip_code !== '') {
  $fields[] = 'zip_code = ?';
  $types .= 's';
  $params[] = $zip_code;
}
if ($role !== null) {
  $fields[] = 'role = ?';
  $types .= 's';
  $params[] = $role;
}
if ($status !== null) {
  $fields[] = 'status = ?';
  $types .= 'i';
  $params[] = $status;
}
if ($profile_picture !== '') {
  $fields[] = 'profile_picture = ?';
  $types .= 's';
  $params[] = $profile_picture;
}

if (empty($fields)) {
  $msg = 'Tidak ada perubahan.';
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $msg]);
  } else {
    header('Location: ../pages/users.php?msg=' . urlencode($msg));
  }
  exit;
}

$sql = 'UPDATE tb_user SET ' . implode(', ', $fields) . ' WHERE id_user = ? LIMIT 1';
$types .= 'i';
$params[] = $id;

$stmt = $koneksi->prepare($sql);
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

// bind params dynamically
$bind_names[] = $types;
for ($i = 0; $i < count($params); $i++) {
  $bind_name = 'bind' . $i;
  $$bind_name = $params[$i];
  $bind_names[] = &$$bind_name;
}
call_user_func_array([$stmt, 'bind_param'], $bind_names);

if ($stmt->execute()) {
  $msg = 'User berhasil diperbarui.';
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => $msg]);
  } else {
    header('Location: ../pages/users.php?msg=' . urlencode($msg));
  }
} else {
  $msg = 'Gagal memperbarui user: ' . $stmt->error;
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $msg]);
  } else {
    header('Location: ../pages/users.php?msg=' . urlencode($msg));
  }
}

$stmt->close();
exit;
