<?php

session_start();

require_once '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: ../pages/stocks.php');
  exit;
}

if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/logout.php");
  exit;
}

$owner_user_id = (int) $_SESSION['user_id'];

$sku         = trim($_POST['sku']);
$nama        = trim($_POST['nama']);
$harga       = (int) $_POST['harga'];
$id_kategori = (int) $_POST['id_kategori'];
$stok        = (int) $_POST['stok'];
$deskripsi   = trim($_POST['deskripsi']);

$stmt = $koneksi->prepare("
    INSERT INTO tb_produk
    (
        owner_user_id,
        sku,
        nama,
        harga,
        id_kategori,
        deskripsi,
        stok
    )
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "issiisi",
    $owner_user_id,
    $sku,
    $nama,
    $harga,
    $id_kategori,
    $deskripsi,
    $stok
);

$stmt->execute();

header('Location: ../../pages/stocks.php');
exit;

?>