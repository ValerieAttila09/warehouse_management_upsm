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
$slug = trim($_POST['slug'] ?? '');
$ringkasan = trim($_POST['ringkasan'] ?? '');
$thumbnail = trim($_POST['thumbnail'] ?? '');
$id_kategori = isset($_POST['id_kategori']) && $_POST['id_kategori'] !== '' ? (int) $_POST['id_kategori'] : null;
$status = trim($_POST['status'] ?? 'draft');
$tanggal_terbit = trim($_POST['tanggal_terbit'] ?? '');
$current_user_id = (int) $_SESSION['user_id'];
$current_role = $_SESSION['role'] ?? '';

if ($id_artikel <= 0 || $judul === '' || $isi === '') {
  header('Location: ../../pages/articles.php?error=1');
  exit;
}

// Check apakah artikel ada dan siapa yang punya
$check_stmt = $koneksi->prepare("SELECT user_id, slug, tanggal_terbit FROM tb_artikel WHERE id_artikel = ? LIMIT 1");
$check_stmt->bind_param('i', $id_artikel);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows === 0) {
  header('Location: ../../pages/articles.php?error=1');
  exit;
}

$article = $check_result->fetch_assoc();
$check_stmt->close();

// Authorization: hanya owner atau admin yang bisa edit
if ($article['user_id'] !== $current_user_id && $current_role !== 'admin') {
  header('Location: ../../pages/articles.php?error=3');
  exit;
}

function slugify($text)
{
  $text = preg_replace('~[^
	
a-zA-Z0-9\-\_]+~u', '-', $text);
  $text = trim($text, '-');
  $text = preg_replace('~-+~', '-', $text);
  return strtolower($text) ?: 'artikel-' . time();
}

if ($slug === '') {
  $slug = $article['slug'] ?: slugify($judul);
} else {
  $slug = slugify($slug);
}

$original_slug = $slug;
$slug_check = $koneksi->prepare("SELECT COUNT(*) AS count FROM tb_artikel WHERE slug = ? AND id_artikel <> ?");
$slug_check->bind_param('si', $slug, $id_artikel);
$slug_check->execute();
$slug_result = $slug_check->get_result();
$slug_row = $slug_result->fetch_assoc();
$slug_check->close();
$counter = 1;
while ($slug_row['count'] > 0) {
  $slug = $original_slug . '-' . $counter;
  $slug_check = $koneksi->prepare("SELECT COUNT(*) AS count FROM tb_artikel WHERE slug = ? AND id_artikel <> ?");
  $slug_check->bind_param('si', $slug, $id_artikel);
  $slug_check->execute();
  $slug_result = $slug_check->get_result();
  $slug_row = $slug_result->fetch_assoc();
  $slug_check->close();
  $counter++;
}

if ($ringkasan === '') {
  $plain_text = strip_tags($isi);
  $ringkasan = mb_substr(trim($plain_text), 0, 220);
}

$allowed_status = ['draft', 'terbit', 'arsip'];
if (!in_array($status, $allowed_status, true)) {
  $status = 'draft';
}

if ($tanggal_terbit !== '' && strtotime($tanggal_terbit) !== false) {
  $tanggal_terbit = date('Y-m-d H:i:s', strtotime($tanggal_terbit));
} elseif (!empty($article['tanggal_terbit'])) {
  $tanggal_terbit = $article['tanggal_terbit'];
} elseif ($status === 'terbit') {
  $tanggal_terbit = date('Y-m-d H:i:s');
} else {
  $tanggal_terbit = null;
}

$stmt = $koneksi->prepare(
  "UPDATE tb_artikel SET judul = ?, slug = ?, ringkasan = ?, isi = ?, thumbnail = ?, id_kategori = ?, status = ?, tanggal_terbit = ? WHERE id_artikel = ?"
);
if ($stmt) {
  $stmt->bind_param('sssssissi', $judul, $slug, $ringkasan, $isi, $thumbnail, $id_kategori, $status, $tanggal_terbit, $id_artikel);
  $stmt->execute();
  $stmt->close();
}

header('Location: ../../pages/articles.php?updated=1');
exit;
