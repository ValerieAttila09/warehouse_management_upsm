<?php
require_once __DIR__ . '/auth_controller.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $result = login_user_auth($email, $password);
  if ($result['success']) {
    header('Location: ../pages/dashboard.php');
    exit;
  } else {
    $_SESSION['login_error'] = $result['message'];
    header('Location: login.php');
    exit;
  }
} else {
  header('Location: login.php');
  exit;
}
