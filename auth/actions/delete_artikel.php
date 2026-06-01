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

if ($id_artikel <= 0) {
  header('Location: ../../pages/articles.php?error=1');
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
