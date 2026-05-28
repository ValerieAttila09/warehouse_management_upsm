<?php
// auth_controller.php
// Proses utama autentikasi: register, login, dsb
require_once __DIR__ . '/config/koneksi.php';
require_once __DIR__ . '/auth_helper.php';

function register_user($data)
{
  global $conn;
  $first_name = trim($data['first_name'] ?? '');
  $last_name = trim($data['last_name'] ?? '');
  $email = trim($data['email'] ?? '');
  $password = $data['password'] ?? '';
  $password_verify = $data['password_verify'] ?? '';
  // Validasi dasar
  if (!$first_name || !$last_name || !$email || !$password || !$password_verify) {
    return ['success' => false, 'message' => 'All fields are required.'];
  }
  if ($password !== $password_verify) {
    return ['success' => false, 'message' => 'Passwords do not match.'];
  }
  // Cek email sudah terdaftar
  $stmt = $conn->prepare('SELECT id_user FROM tb_user WHERE email = ?');
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
    return ['success' => false, 'message' => 'Email already registered.'];
  }
  $stmt->close();
  // Hash password
  $hashed = hash_password($password);
  // Simpan user baru (tambah field lain jika perlu)
  $stmt = $conn->prepare('INSERT INTO tb_user (first_name, last_name, email, password, country, city, phone_number, zip_code, profile_picture, role, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)');
  $country = $data['country'] ?? '';
  $city = $data['city'] ?? '';
  $phone = $data['phone'] ?? '';
  $zip = $data['zip_code'] ?? '';
  $profile = $data['profile_photo'] ?? '';
  $role = 'staff';
  $stmt->bind_param('ssssssssss', $first_name, $last_name, $email, $hashed, $country, $city, $phone, $zip, $profile, $role);
  $success = $stmt->execute();
  $stmt->close();
  if ($success) {
    return ['success' => true, 'message' => 'Registration successful.'];
  } else {
    return ['success' => false, 'message' => 'Registration failed.'];
  }
}

function login_user_auth($email, $password)
{
  global $conn;
  $stmt = $conn->prepare('SELECT id_user, password FROM tb_user WHERE email = ? AND status = 1');
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $stmt->bind_result($id_user, $hashed);
  if ($stmt->fetch()) {
    if (verify_password($password, $hashed)) {
      login_user($id_user);
      $stmt->close();
      return ['success' => true, 'message' => 'Login successful.'];
    }
  }
  $stmt->close();
  return ['success' => false, 'message' => 'Invalid email or password.'];
}
