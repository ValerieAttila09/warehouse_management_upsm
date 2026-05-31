<?php
// Simple ACL helpers
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once dirname(__DIR__) . '/config/koneksi.php';

function is_logged_in()
{
  return !empty($_SESSION['user_id']);
}

function get_user_role()
{
  return $_SESSION['role'] ?? null;
}

function require_login()
{
  if (!is_logged_in()) {
    header('Location: ' . dirname($_SERVER['PHP_SELF']) . '/../auth/simple_login.php');
    exit;
  }
}

function require_role($roles)
{
  require_login();
  $roles = (array) $roles;
  $role = get_user_role();
  if (!in_array($role, $roles, true)) {
    header('HTTP/1.1 403 Forbidden');
    echo '<h1>403 Forbidden</h1><p>You do not have permission to access this resource.</p>';
    exit;
  }
}

function verify_admin_password($password)
{
  if (!is_logged_in()) return false;
  global $koneksi;
  $userId = $_SESSION['user_id'];
  $hashed = md5($password);

  $stmt = $koneksi->prepare('SELECT password FROM tb_user WHERE id_user = ? LIMIT 1');
  if (!$stmt) return false;
  $stmt->bind_param('i', $userId);
  $stmt->execute();
  $stmt->bind_result($dbPass);
  $ok = false;
  if ($stmt->fetch()) {
    if ($dbPass === $hashed) $ok = true;
  }
  $stmt->close();
  return $ok;
}

function is_admin_confirmed($ttl = 300)
{
  if (!is_logged_in()) return false;
  if (get_user_role() !== 'admin') return false;
  if (empty($_SESSION['admin_confirmed_at'])) return false;
  return (time() - (int) $_SESSION['admin_confirmed_at']) <= $ttl;
}

// Use this to protect high-risk admin actions server-side. Example usage:
// require_role('admin');
// if (!verify_admin_password($_POST['admin_password'])) { abort or request confirmation }
