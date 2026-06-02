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
  <title>Sign In</title>

  <!-- Tailwind CDN untuk prototyping cepat -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&family=Lora:ital,wght@0,400..700;1,400..700&display=swap');

    .google-sans-thin {
      font-family: "Google Sans", sans-serif;
      font-optical-sizing: auto;
      font-weight: 300;
      font-style: normal;
      font-variation-settings:
        "GRAD" 0;
    }

    .google-sans-regular {
      font-family: "Google Sans", sans-serif;
      font-optical-sizing: auto;
      font-weight: 400;
      font-style: normal;
      font-variation-settings:
        "GRAD" 0;
    }

    .google-sans-medium {
      font-family: "Google Sans", sans-serif;
      font-optical-sizing: auto;
      font-weight: 500;
      font-style: normal;
      font-variation-settings:
        "GRAD" 0;
    }

    .google-sans-semibold {
      font-family: "Google Sans", sans-serif;
      font-optical-sizing: auto;
      font-weight: 600;
      font-style: normal;
      font-variation-settings:
        "GRAD" 0;
    }

    .google-sans-bold {
      font-family: "Google Sans", sans-serif;
      font-optical-sizing: auto;
      font-weight: 700;
      font-style: normal;
      font-variation-settings:
        "GRAD" 0;
    }


    .lora-regular {
      font-family: "Lora", serif;
      font-optical-sizing: auto;
      font-weight: 400;
      font-style: normal;
    }

    .input-focus:focus {
      outline: none;
      box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.12);
    }

    .file-input::-webkit-file-upload-button {
      visibility: hidden;
    }
  </style>
</head>

<body class="min-h-screen bg-neutral-900 google-sans-regular">
  <main class="h-full w-full">
    <div class="w-full min-h-screen grid grid-cols-12">
      <!-- Left: Form -->
      <section class="w-full h-full flex items-center justify-center bg-neutral-900 col-span-5 p-8 md:p-12 border-r border-neutral-800">
        <div class="max-w-lg mx-auto">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-green-900 border border-green-700 rounded-full flex items-center justify-center text-white google-sans-bold">S</div>
            <div>
              <h1 class="text-2xl google-sans-semibold text-white">Create new account</h1>
              <p class="text-sm text-neutral-300">Sign up to access the Dashboard and our features.</p>
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
                <label for="first_name" class="block text-sm google-sans-medium text-neutral-400 mb-1">Nama Depan</label>
                <input id="first_name" name="first_name" type="text" required value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>"
                  class="input-focus text-sm bg-neutral-800 block w-full rounded-md border border-neutral-700 px-4 py-1.5 text-neutral-200 placeholder-neutral-500 focus:border-green-700" placeholder="Nama depan" />
              </div>

              <div>
                <label for="last_name" class="block text-sm google-sans-medium text-neutral-400 mb-1">Nama Belakang</label>
                <input id="last_name" name="last_name" type="text" required value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>"
                  class="input-focus text-sm bg-neutral-800 block w-full rounded-md border border-neutral-700 px-4 py-1.5 text-neutral-200 placeholder-neutral-500 focus:border-green-700" placeholder="Nama belakang" />
              </div>
            </div>

            <div>
              <label for="email" class="block text-sm google-sans-medium text-neutral-400 mb-1">Email</label>
              <input id="email" name="email" type="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                class="input-focus text-sm bg-neutral-800 block w-full rounded-md border border-neutral-700 px-4 py-1.5 text-neutral-200 placeholder-neutral-500 focus:border-green-700" placeholder="you@example.com" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="password" class="block text-sm google-sans-medium text-neutral-400 mb-1">Password</label>
                <input id="password" name="password" type="password" required
                  class="input-focus text-sm bg-neutral-800 block w-full rounded-md border border-neutral-700 px-4 py-1.5 text-neutral-200 placeholder-neutral-500 focus:border-green-700" placeholder="Minimal 8 karakter" />
              </div>

              <div>
                <label for="password_verify" class="block text-sm google-sans-medium text-neutral-400 mb-1">Verifikasi Password</label>
                <input id="password_verify" name="password_verify" type="password" required
                  class="input-focus text-sm bg-neutral-800 block w-full rounded-md border border-neutral-700 px-4 py-1.5 text-neutral-200 placeholder-neutral-500 focus:border-green-700" placeholder="Ketik ulang password" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="country" class="block text-sm google-sans-medium text-neutral-400 mb-1">Country</label>
                <input id="country" name="country" type="text" value="<?php echo htmlspecialchars($_POST['country'] ?? ''); ?>"
                  class="input-focus text-sm bg-neutral-800 block w-full rounded-md border border-neutral-700 px-4 py-1.5 text-neutral-200 placeholder-neutral-500 focus:border-green-700" placeholder="Indonesia" />
              </div>

              <div>
                <label for="city" class="block text-sm google-sans-medium text-neutral-400 mb-1">City</label>
                <input id="city" name="city" type="text" value="<?php echo htmlspecialchars($_POST['city'] ?? ''); ?>"
                  class="input-focus text-sm bg-neutral-800 block w-full rounded-md border border-neutral-700 px-4 py-1.5 text-neutral-200 placeholder-neutral-500 focus:border-green-700" placeholder="Kota" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label for="phone" class="block text-sm google-sans-medium text-neutral-400 mb-1">Phone</label>
                <input id="phone" name="phone" type="text" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                  class="input-focus text-sm bg-neutral-800 block w-full rounded-md border border-neutral-700 px-4 py-1.5 text-neutral-200 placeholder-neutral-500 focus:border-green-700" placeholder="+62 812..." />
              </div>

              <div>
                <label for="zip_code" class="block text-sm google-sans-medium text-neutral-400 mb-1">Zip Code</label>
                <input id="zip_code" name="zip_code" type="text" value="<?php echo htmlspecialchars($_POST['zip_code'] ?? ''); ?>"
                  class="input-focus text-sm bg-neutral-800 block w-full rounded-md border border-neutral-700 px-4 py-1.5 text-neutral-200 placeholder-neutral-500 focus:border-green-700" placeholder="Kode pos" />
              </div>
            </div>

            <div class="pb-5 pt-2">
              <label class="block text-sm google-sans-medium text-neutral-400 mb-2">Foto Profil</label>
              <div class="flex items-center justify-center gap-4 p-3 border border-neutral-700 rounded-md bg-neutral-800">
                <div class="w-20 h-20 bg-neutral-100 rounded-full overflow-hidden flex items-center justify-center">
                  <img id="avatarPreview" src="https://via.placeholder.com/80" alt="preview" class="w-full h-full object-cover" />
                </div>
                <div class="rounded-md bg-neutral-900/50 py-3 border border-neutral-700">
                  <input id="profile_photo" name="profile_photo" type="file" accept="image/*"
                    class="file-input text-sm text-neutral-600" />
                  <p class="text-xs text-center text-neutral-400 mt-1">Maks 2MB. Format JPG/PNG.</p>
                </div>
              </div>
            </div>

            <div class="">
              <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-md bg-green-800 border border-green-700 hover:bg-green-700 text-white px-4 py-1 google-sans-medium shadow-sm">
                Sign Up
              </button>
            </div>

            <div class="text-center text-sm text-neutral-500">
              Already have an account?
              <a href="./simple_login.php" class="text-green-600 hover:underline">Sign in</a>
            </div>

            <div class="text-xs text-neutral-400 text-center mt-2">
              By signing up, you agree to our Terms of Service and Privacy Policy.
            </div>
          </form>
        </div>
      </section>

      <!-- Right: Testimonial / Visual -->
      <aside class="col-span-7 hidden md:flex items-center justify-center bg-neutral-950">
        <div class="max-w-lg">
          <blockquote class="text-white lora-regular italic text-2xl leading-relaxed mb-4">
            “We need technology in every classroom and in every student and teacher's hand, because it is the pen and paper of our time, and it is the lens through which we experience much of our world.”
          </blockquote>
          <div class="flex items-center gap-3">
            <div>
              <div class="text-sm google-sans-medium text-neutral-400">- David Warlick</div>
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
      inputFile.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) {
          alert('Silakan pilih file gambar.');
          inputFile.value = '';
          return;
        }
        const reader = new FileReader();
        reader.onload = function(ev) {
          avatarPreview.src = ev.target.result;
        };
        reader.readAsDataURL(file);
      });
    }

    // Simple client-side validation before submit
    const form = document.getElementById('registerForm');
    form.addEventListener('submit', function(e) {
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