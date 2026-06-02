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
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Akun</title>

  <!-- Tailwind CDN untuk prototyping cepat -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    .input-focus:focus {
      outline: none;
      box-shadow: 0 0 0 4px rgba(34,197,94,0.12);
    }
    .file-input::-webkit-file-upload-button {
      visibility: hidden;
    }
  </style>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center py-10 px-4">
  <main class="w-full max-w-6xl">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden grid grid-cols-1 md:grid-cols-2">
      <!-- Left: Form -->
      <section class="p-8 md:p-12">
        <div class="max-w-lg mx-auto">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-green-600 rounded flex items-center justify-center text-white font-bold">S</div>
            <div>
              <h1 class="text-2xl font-semibold text-gray-800">Buat akun baru</h1>
              <p class="text-sm text-gray-500">Daftar untuk mengakses dashboard dan fitur lainnya</p>
            </div>
          </div>

          <?php if ($message): ?>
            <div role="alert" aria-live="polite" class="mb-4">
              <?php if ($messageType === 'error'): ?>
                <div class="rounded-md bg-red-50 border border-red-100 p-3 text-red-700 text-sm">
                  <?php echo htmlspecialchars($message); ?>
                </div>
              <?php else: ?>
                <div class="rounded-md bg-green-50 border border-green-100 p-3 text-green-700 text-sm">
                  <?php echo htmlspecialchars($message); ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <form method="POST" enctype="multipart/form-data" class="space-y-4" id="registerForm" novalidate>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Depan</label>
                <input id="first_name" name="first_name" type="text" required value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>"
                  class="input-focus block w-full rounded-md border border-gray-200 px-4 py-2 text-gray-700 placeholder-gray-400 focus:border-green-500" placeholder="Nama depan" />
              </div>

              <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Belakang</label>
                <input id="last_name" name="last_name" type="text" required value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>"
                  class="input-focus block w-full rounded-md border border-gray-200 px-4 py-2 text-gray-700 placeholder-gray-400 focus:border-green-500" placeholder="Nama belakang" />
              </div>
            </div>

            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input id="email" name="email" type="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                class="input-focus block w-full rounded-md border border-gray-200 px-4 py-2 text-gray-700 placeholder-gray-400 focus:border-green-500" placeholder="you@example.com" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password" name="password" type="password" required
                  class="input-focus block w-full rounded-md border border-gray-200 px-4 py-2 text-gray-700 placeholder-gray-400 focus:border-green-500" placeholder="Minimal 8 karakter" />
              </div>

              <div>
                <label for="password_verify" class="block text-sm font-medium text-gray-700 mb-1">Verifikasi Password</label>
                <input id="password_verify" name="password_verify" type="password" required
                  class="input-focus block w-full rounded-md border border-gray-200 px-4 py-2 text-gray-700 placeholder-gray-400 focus:border-green-500" placeholder="Ketik ulang password" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                <input id="country" name="country" type="text" value="<?php echo htmlspecialchars($_POST['country'] ?? ''); ?>"
                  class="input-focus block w-full rounded-md border border-gray-200 px-4 py-2 text-gray-700 placeholder-gray-400 focus:border-green-500" placeholder="Indonesia" />
              </div>

              <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                <input id="city" name="city" type="text" value="<?php echo htmlspecialchars($_POST['city'] ?? ''); ?>"
                  class="input-focus block w-full rounded-md border border-gray-200 px-4 py-2 text-gray-700 placeholder-gray-400 focus:border-green-500" placeholder="Kota" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input id="phone" name="phone" type="text" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                  class="input-focus block w-full rounded-md border border-gray-200 px-4 py-2 text-gray-700 placeholder-gray-400 focus:border-green-500" placeholder="+62 812..." />
              </div>

              <div>
                <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-1">Zip Code</label>
                <input id="zip_code" name="zip_code" type="text" value="<?php echo htmlspecialchars($_POST['zip_code'] ?? ''); ?>"
                  class="input-focus block w-full rounded-md border border-gray-200 px-4 py-2 text-gray-700 placeholder-gray-400 focus:border-green-500" placeholder="Kode pos" />
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
              <div class="flex items-center gap-4">
                <div class="w-20 h-20 bg-gray-100 rounded-full overflow-hidden flex items-center justify-center">
                  <img id="avatarPreview" src="https://via.placeholder.com/80" alt="preview" class="w-full h-full object-cover" />
                </div>
                <div class="flex-1">
                  <input id="profile_photo" name="profile_photo" type="file" accept="image/*"
                    class="file-input text-sm text-gray-600" />
                  <p class="text-xs text-gray-400 mt-1">Maks 2MB. Format JPG/PNG.</p>
                </div>
              </div>
            </div>

            <div>
              <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-md bg-green-600 hover:bg-green-700 text-white px-4 py-2 font-medium shadow-sm">
                Daftar
              </button>
            </div>

            <div class="text-center text-sm text-gray-500">
              Sudah punya akun?
              <a href="login.php" class="text-green-600 hover:underline">Masuk</a>
            </div>

            <div class="text-xs text-gray-400 text-center mt-2">
              Dengan mendaftar, Anda menyetujui Ketentuan Layanan dan Kebijakan Privasi.
            </div>
          </form>
        </div>
      </section>

      <!-- Right: Testimonial / Visual -->
      <aside class="hidden md:flex items-center justify-center bg-gradient-to-br from-green-50 to-white p-8">
        <div class="max-w-sm">
          <blockquote class="text-gray-800 italic text-lg leading-relaxed mb-4">
            “Supabase is the best product experience I’ve had in years. Not just tech - taste. From docs to latency to the URL structure that makes you think ‘oh, that’s obvious’.”
          </blockquote>
          <div class="flex items-center gap-3">
            <img src="https://via.placeholder.com/40" alt="avatar" class="w-10 h-10 rounded-full object-cover" />
            <div>
              <div class="text-sm font-medium text-gray-900">@yatsiv_yuriy</div>
              <div class="text-xs text-gray-500">Product Designer</div>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </main>

  <script>
    // Preview foto profil
    const inputFile = document.getElementById('profile_photo');
    const avatarPreview = document.getElementById('avatarPreview');

    if (inputFile) {
      inputFile.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) {
          alert('Silakan pilih file gambar.');
          inputFile.value = '';
          return;
        }
        const reader = new FileReader();
        reader.onload = function (ev) {
          avatarPreview.src = ev.target.result;
        };
        reader.readAsDataURL(file);
      });
    }

    // Simple client-side validation before submit
    const form = document.getElementById('registerForm');
    form.addEventListener('submit', function (e) {
      const pw = document.getElementById('password').value;
      const pwv = document.getElementById('password_verify').value;
      if (pw.length < 8) {
        e.preventDefault();
        alert('Password minimal 8 karakter.');
        return;
      }
      if (pw !== pwv) {
        e.preventDefault();
        alert('Password dan verifikasi tidak cocok.');
        return;
      }
    });
  </script>
</body>
</html>
