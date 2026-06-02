<?php

session_start();

require_once '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../../pages/articles.php');
  exit;
}

if (!isset($_SESSION['user_id'])) {
  header('Location: ../logout.php');
  exit;
}

$id_artikel = (int) ($_POST['id_artikel'] ?? 0);
$current_user_id = (int) $_SESSION['user_id'];
$current_role = $_SESSION['role'] ?? '';

if ($id_artikel <= 0) {
  header('Location: ../../pages/articles.php?error=1');
  exit;
}

// Check apakah artikel ada dan siapa yang punya
$check_stmt = $koneksi->prepare("SELECT user_id FROM tb_artikel WHERE id_artikel = ? LIMIT 1");
$check_stmt->bind_param('i', $id_artikel);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows === 0) {
  header('Location: ../../pages/articles.php?error=1');
  exit;
}

$article = $check_result->fetch_assoc();
$check_stmt->close();

// Authorization: hanya owner atau admin yang bisa delete
if ($article['user_id'] !== $current_user_id && $current_role !== 'admin') {
  header('Location: ../../pages/articles.php?error=3');
  exit;
}

$stmt = $koneksi->prepare("DELETE FROM tb_artikel WHERE id_artikel = ?");
if ($stmt) {
  $stmt->bind_param('i', $id_artikel);
  $stmt->execute();
  $stmt->close();
}

header('Location: ../../pages/articles.php?deleted=1');
exit;
