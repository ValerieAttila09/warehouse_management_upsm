<?php
session_start();
require_once dirname(__DIR__) . '/config/koneksi.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $first_name = trim($_POST['first_name'] ?? '');
  $last_name = trim($_POST['last_name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $password_verify = $_POST['password_verify'] ?? '';

  if ($first_name === '' || $last_name === '' || $email === '' || $password === '' || $password_verify === '') {
    $message = 'Semua field wajib diisi.';
    $messageType = 'error';
  } elseif ($password !== $password_verify) {
    $message = 'Password tidak sama.';
    $messageType = 'error';
  } else {
    $uploadDir = dirname(__DIR__) . '/uploads/';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $profile_picture = '';
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
      $filename = uniqid() . '_' . basename($_FILES['profile_photo']['name']);
      $targetFile = $uploadDir . $filename;

      if (!move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetFile)) {
        $message = 'Upload foto gagal.';
        $messageType = 'error';
      } else {
        $profile_picture = $filename;
      }
    }

    if ($message === '') {
      $hashed = md5($password);
      $role = 'staff';
      $status = 1;

      $stmt = $koneksi->prepare('INSERT INTO tb_user (first_name, last_name, email, password, country, city, phone_number, zip_code, profile_picture, role, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
      if (!$stmt) {
        $message = 'Prepare gagal: ' . $koneksi->error;
        $messageType = 'error';
      } else {
        $country = trim($_POST['country'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $zip_code = trim($_POST['zip_code'] ?? '');

        $stmt->bind_param('ssssssssssi', $first_name, $last_name, $email, $hashed, $country, $city, $phone, $zip_code, $profile_picture, $role, $status);

        if ($stmt->execute()) {
          $message = 'Registrasi berhasil.';
          $messageType = 'success';
        } else {
          $message = 'Registrasi gagal: ' . $stmt->error;
          $messageType = 'error';
        }

        $stmt->close();
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simple Register</title>
</head>

<body>
  <h1>Simple Register</h1>

  <?php if ($message): ?>
    <p style="color: <?php echo $messageType === 'success' ? 'green' : 'red'; ?>;">
      <?php echo htmlspecialchars($message); ?>
    </p>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <div>
      <label>First Name</label><br>
      <input type="text" name="first_name" value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>">
    </div>
    <div>
      <label>Last Name</label><br>
      <input type="text" name="last_name" value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>">
    </div>
    <div>
      <label>Email</label><br>
      <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
    </div>
    <div>
      <label>Password</label><br>
      <input type="password" name="password">
    </div>
    <div>
      <label>Verify Password</label><br>
      <input type="password" name="password_verify">
    </div>
    <div>
      <label>Country</label><br>
      <input type="text" name="country" value="<?php echo htmlspecialchars($_POST['country'] ?? ''); ?>">
    </div>
    <div>
      <label>City</label><br>
      <input type="text" name="city" value="<?php echo htmlspecialchars($_POST['city'] ?? ''); ?>">
    </div>
    <div>
      <label>Phone</label><br>
      <input type="text" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
    </div>
    <div>
      <label>Zip Code</label><br>
      <input type="text" name="zip_code" value="<?php echo htmlspecialchars($_POST['zip_code'] ?? ''); ?>">
    </div>
    <div>
      <label>Profile Photo</label><br>
      <input type="file" name="profile_photo">
    </div>
    <div>
      <button type="submit">Register</button>
    </div>
  </form>
</body>

</html>