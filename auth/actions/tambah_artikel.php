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
$slug = trim($_POST['slug'] ?? '');
$ringkasan = trim($_POST['ringkasan'] ?? '');
$thumbnail = trim($_POST['thumbnail'] ?? '');
$id_kategori = isset($_POST['id_kategori']) && $_POST['id_kategori'] !== '' ? (int) $_POST['id_kategori'] : null;
$status = trim($_POST['status'] ?? 'terbit');
$tanggal_terbit = trim($_POST['tanggal_terbit'] ?? '');
$current_user_id = (int) $_SESSION['user_id'];

if ($judul === '' || $isi === '') {
  header('Location: ../../pages/articles.php?error=1');
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
  $slug = slugify($judul);
} else {
  $slug = slugify($slug);
}

$original_slug = $slug;
$slug_check = $koneksi->prepare("SELECT COUNT(*) AS count FROM tb_artikel WHERE slug = ?");
$slug_check->bind_param('s', $slug);
$slug_check->execute();
$slug_result = $slug_check->get_result();
$slug_row = $slug_result->fetch_assoc();
$slug_check->close();
$counter = 1;
while ($slug_row['count'] > 0) {
  $slug = $original_slug . '-' . $counter;
  $slug_check = $koneksi->prepare("SELECT COUNT(*) AS count FROM tb_artikel WHERE slug = ?");
  $slug_check->bind_param('s', $slug);
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
} elseif ($status === 'terbit') {
  $tanggal_terbit = date('Y-m-d H:i:s');
} else {
  $tanggal_terbit = null;
}

// Get user info dari tb_user
$user_stmt = $koneksi->prepare("SELECT first_name, last_name, email FROM tb_user WHERE id_user = ? LIMIT 1");
$user_stmt->bind_param('i', $current_user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

if ($user_result->num_rows === 0) {
  header('Location: ../../pages/articles.php?error=1');
  exit;
}

$user_data = $user_result->fetch_assoc();
$user_stmt->close();

// Cek apakah user sudah punya author entry di tb_author_artikel
$check_stmt = $koneksi->prepare("SELECT id FROM tb_author_artikel WHERE nama = ? AND email = ? LIMIT 1");
$check_stmt->bind_param('ss', $user_data['first_name'], $user_data['email']);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
  $author_row = $check_result->fetch_assoc();
  $id_penulis = $author_row['id'];
} else {
  // Buat author entry baru untuk user ini
  $author_name = $user_data['first_name'] . ' ' . $user_data['last_name'];
  $insert_author = $koneksi->prepare("INSERT INTO tb_author_artikel (nama, email) VALUES (?, ?)");
  $insert_author->bind_param('ss', $author_name, $user_data['email']);
  $insert_author->execute();
  $id_penulis = $koneksi->insert_id;
  $insert_author->close();
}
$check_stmt->close();

// Insert artikel dengan author yang sudah ditentukan
$stmt = $koneksi->prepare(
  "INSERT INTO tb_artikel (judul, slug, ringkasan, isi, thumbnail, id_kategori, id_penulis, status, tanggal_terbit, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);
if (!$stmt) {
  header('Location: ../../pages/articles.php?error=1');
  exit;
}
$stmt->bind_param(
  'sssssisssi',
  $judul,
  $slug,
  $ringkasan,
  $isi,
  $thumbnail,
  $id_kategori,
  $id_penulis,
  $status,
  $tanggal_terbit,
  $current_user_id
);
$stmt->execute();
$stmt->close();

header('Location: ../../pages/articles.php?created=1');
exit;
