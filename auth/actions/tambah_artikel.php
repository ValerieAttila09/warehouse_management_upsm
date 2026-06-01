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
$id_penulis = (int) ($_POST['id_penulis'] ?? 0);

if ($judul === '' || $isi === '' || $id_penulis <= 0) {
  header('Location: ../../pages/articles.php?error=1');
  exit;
}

$stmt = $koneksi->prepare("INSERT INTO tb_artikel (judul, isi, id_penulis, status) VALUES (?, ?, ?, 'terbit')");
if (!$stmt) {
  header('Location: ../../pages/articles.php?error=1');
  exit;
}
$stmt->bind_param('ssi', $judul, $isi, $id_penulis);
$stmt->execute();
$stmt->close();

header('Location: ../../pages/articles.php?created=1');
exit;
