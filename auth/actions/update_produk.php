<?php

session_start();

require_once "../../config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../pages/stocks.php');
  exit;
}

if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/logout.php");
  exit;
}

$id_produk   = (int) $_POST['id_produk'];
$nama        = trim($_POST['nama']);
$sku         = trim($_POST['sku']);
$harga       = (int) $_POST['harga'];
$id_kategori = (int) $_POST['id_kategori'];
$stok        = (int) $_POST['stok'];
$deskripsi   = trim($_POST['deskripsi']);

$current_user_id = (int) $_SESSION['user_id'];

if ($_SESSION['role'] === 'admin') {
  $stmt = $koneksi->prepare("UPDATE tb_produk
        SET
            nama = ?,
            sku = ?,
            harga = ?,
            id_kategori = ?,
            stok = ?,
            deskripsi = ?
        WHERE id_produk = ?
    ");

  $stmt->bind_param(
    "ssiiisi",
    $nama,
    $sku,
    $harga,
    $id_kategori,
    $stok,
    $deskripsi,
    $id_produk
  );
} else {
  $stmt = $koneksi->prepare("UPDATE tb_produk
        SET
            nama = ?,
            sku = ?,
            harga = ?,
            id_kategori = ?,
            stok = ?,
            deskripsi = ?
        WHERE id_produk = ?
        AND owner_user_id = ?
    ");
}

$stmt->bind_param(
  "ssiiisii",
  $nama,
  $sku,
  $harga,
  $id_kategori,
  $stok,
  $deskripsi,
  $id_produk,
  $current_user_id
);

if ($stmt->execute()) {
  header("Location: ../../pages/stocks.php?updated=1");
  exit;
}


echo "Update gagal";
