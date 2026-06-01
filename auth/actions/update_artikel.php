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
$judul = trim($_POST['judul'] ?? '');
$isi = trim($_POST['isi'] ?? '');
$id_penulis = (int) ($_POST['id_penulis'] ?? 0);

if ($id_artikel <= 0 || $judul === '' || $isi === '' || $id_penulis <= 0) {
  header('Location: ../../pages/articles.php?error=1');
  exit;
}

$stmt = $koneksi->prepare("UPDATE tb_artikel SET judul = ?, isi = ?, id_penulis = ? WHERE id_artikel = ?");
if ($stmt) {
  $stmt->bind_param('ssii', $judul, $isi, $id_penulis, $id_artikel);
  $stmt->execute();
  $stmt->close();
}

header('Location: ../../pages/articles.php?updated=1');
exit;
