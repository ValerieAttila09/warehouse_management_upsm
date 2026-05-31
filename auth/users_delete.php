<?php
require_once __DIR__ . '/acl.php';
require_once dirname(__DIR__) . '/config/koneksi.php';

// Only admin can delete users
require_role('admin');
if (!is_admin_confirmed()) {
  header('HTTP/1.1 403 Forbidden');
  echo 'Admin confirmation required';
  exit;
}

$isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

$id = (int)($_POST['id_user'] ?? $_GET['id_user'] ?? 0);
// fallback: accept email instead of id_user (useful for client that can't render ids)
if ($id <= 0) {
  $email = trim($_POST['email'] ?? $_GET['email'] ?? '');
  if ($email !== '') {
    $q = $koneksi->prepare('SELECT id_user FROM tb_user WHERE email = ? LIMIT 1');
    if ($q) {
      $q->bind_param('s', $email);
      $q->execute();
      $q->bind_result($foundId);
      if ($q->fetch()) {
        $id = (int)$foundId;
      }
      $q->close();
    }
  }
}

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

// prevent deleting self
if ($id === ($_SESSION['user_id'] ?? 0)) {
  $msg = 'Anda tidak bisa menghapus akun Anda sendiri.';
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $msg]);
  } else {
    header('Location: ../pages/users.php?msg=' . urlencode($msg));
  }
  exit;
}

$stmt = $koneksi->prepare('DELETE FROM tb_user WHERE id_user = ? LIMIT 1');
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
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
  $msg = 'User berhasil dihapus.';
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => $msg]);
  } else {
    header('Location: ../pages/users.php?msg=' . urlencode($msg));
  }
} else {
  $msg = 'Gagal menghapus user: ' . $stmt->error;
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $msg]);
  } else {
    header('Location: ../pages/users.php?msg=' . urlencode($msg));
  }
}

$stmt->close();
exit;
