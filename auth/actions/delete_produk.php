<?php

session_start();

require_once dirname(__DIR__) . '/config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: ../auth/logout.php");
  exit;
}

$id_produk = (int) ($_POST['id_produk'] ?? 0);

$current_user_id = (int) $_SESSION['user_id'];

if ($_SESSION['role'] === 'admin') {

    $stmt = $koneksi->prepare("
        DELETE FROM tb_produk
        WHERE id_produk = ?
    ");

    $stmt->bind_param("i", $id_produk);

} else {

    $stmt = $koneksi->prepare("
        DELETE FROM tb_produk
        WHERE id_produk = ?
        AND owner_user_id = ?
    ");

    $stmt->bind_param(
        "ii",
        $id_produk,
        $current_user_id
    );
}

$stmt->execute();

header('Location: ../pages/stocks.php');
exit;