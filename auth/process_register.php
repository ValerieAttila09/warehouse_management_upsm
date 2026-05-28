<?php
require_once __DIR__ . '/auth_controller.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = $_POST;
  // Untuk file upload (profile_photo)
  if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }
    $filename = uniqid() . '_' . basename($_FILES['profile_photo']['name']);
    $targetFile = $uploadDir . $filename;
    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetFile)) {
      $data['profile_photo'] = $filename;
    } else {
      $data['profile_photo'] = '';
    }
  } else {
    $data['profile_photo'] = '';
  }
  $result = register_user($data);
  if ($result['success']) {
    $_SESSION['register_success'] = $result['message'];
    header('Location: login.php');
    exit;
  } else {
    $_SESSION['register_error'] = $result['message'];
    header('Location: register.php');
    exit;
  }
} else {
  header('Location: register.php');
  exit;
}
