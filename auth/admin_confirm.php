<?php
require_once __DIR__ . '/acl.php';

// Only logged in admins should reach here
require_role('admin');

$message = '';
$return = $_GET['return'] ?? ($_POST['return'] ?? '../pages/users.php');

$isAjax = (
  !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $password = $_POST['admin_password'] ?? '';
  if ($password === '') {
    $message = 'Password wajib diisi.';
    if ($isAjax) {
      header('Content-Type: application/json');
      echo json_encode(['success' => false, 'message' => $message]);
      exit;
    }
  } else {
    if (verify_admin_password($password)) {
      // mark admin confirmation for 5 minutes
      $_SESSION['admin_confirmed_at'] = time();
      if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
      } else {
        header('Location: ' . $return);
        exit;
      }
    } else {
      $message = 'Password tidak cocok.';
      if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $message]);
        exit;
      }
    }
  }
}
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Admin confirmation</title>
</head>

<body>
  <h1>Admin confirmation</h1>
  <?php if ($message): ?>
    <p style="color:red"><?php echo htmlspecialchars($message); ?></p>
  <?php endif; ?>
  <form method="POST">
    <label>Enter your password to continue</label><br>
    <input type="password" name="admin_password" autocomplete="current-password"><br>
    <input type="hidden" name="return" value="<?php echo htmlspecialchars($return); ?>">
    <button type="submit">Confirm</button>
  </form>
</body>

</html>