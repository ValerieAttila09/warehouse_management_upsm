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

$judul = trim($_POST['judul'] ?? '');
$isi = trim($_POST['isi'] ?? '');

if ($judul === '' || $isi === '') {
  header('Location: ../../pages/articles.php?error=1');
  exit;
}

$current_user_id = (int) ($_SESSION['user_id'] ?? 0);

$stmt = $koneksi->prepare("INSERT INTO tb_artikel (judul, isi, id_penulis) VALUES (?, ?, ?)");
if (!$stmt) {
  header('Location: ../../pages/articles.php?error=1');
  exit;
}
$stmt->bind_param('ssi', $judul, $isi, $current_user_id);
$stmt->execute();
$stmt->close();

header('Location: ../../pages/articles.php?created=1');
exit;
