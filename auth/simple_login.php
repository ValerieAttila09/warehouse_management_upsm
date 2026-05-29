<?php
session_start();
require_once dirname(__DIR__) . '/config/koneksi.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($email === '' || $password === '') {
    $message = 'Email dan password wajib diisi.';
    $messageType = 'error';
  } else {
    $hashed = md5($password);
    $stmt = $koneksi->prepare('SELECT id_user, email, role FROM tb_user WHERE email = ? AND password = ? AND status = 1');
    if (!$stmt) {
      $message = 'Prepare gagal: ' . $koneksi->error;
      $messageType = 'error';
    } else {
      $stmt->bind_param('ss', $email, $hashed);
      $stmt->execute();
      $stmt->bind_result($id_user, $db_email, $role);

      if ($stmt->fetch()) {
        $_SESSION['user_id'] = $id_user;
        $_SESSION['email'] = $db_email;
        $_SESSION['role'] = $role;
        header('Location: ../pages/dashboard.php');
        exit;
      } else {
        $message = 'Email atau password salah.';
        $messageType = 'error';
      }

      $stmt->close();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simple Login</title>
</head>

<body>
  <h1>Simple Login</h1>

  <?php if ($message): ?>
    <p style="color: <?php echo $messageType === 'error' ? 'red' : 'green'; ?>;">
      <?php echo htmlspecialchars($message); ?>
    </p>
  <?php endif; ?>

  <form method="POST">
    <div>
      <label>Email</label><br>
      <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
    </div>
    <div>
      <label>Password</label><br>
      <input type="password" name="password">
    </div>
    <div>
      <button type="submit">Login</button>
    </div>
  </form>
</body>

</html>