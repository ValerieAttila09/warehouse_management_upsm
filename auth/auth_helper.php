<?php
// auth_helper.php
// Helper untuk autentikasi user (hash, verifikasi, session, dsb)

function hash_password($password)
{
  // Hash password dengan md5 (catatan: untuk produksi, gunakan bcrypt/argon2)
  return md5($password);
}

function verify_password($input, $hashed)
{
  // Verifikasi password input dengan hash md5
  return md5($input) === $hashed;
}

function start_session_if_needed()
{
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
}

function is_logged_in()
{
  start_session_if_needed();
  return isset($_SESSION['user_id']);
}

function login_user($user_id)
{
  start_session_if_needed();
  $_SESSION['user_id'] = $user_id;
}

function logout_user()
{
  start_session_if_needed();
  session_destroy();
}
