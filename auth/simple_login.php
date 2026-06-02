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

        if ($role === 'admin') {
          $_SESSION['admin_confirmed_at'] = time();
        }

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
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>

  <!-- Tailwind CDN untuk prototyping cepat -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* Custom kecil untuk efek fokus */
    .input-focus:focus {
      outline: none;
      box-shadow: 0 0 0 4px rgba(34,197,94,0.12);
    }
  </style>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
  <main class="w-full max-w-5xl">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden grid grid-cols-1 md:grid-cols-2">
      <!-- Left: Form -->
      <section class="p-8 md:p-12">
        <div class="max-w-md mx-auto">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-green-600 rounded flex items-center justify-center text-white font-bold">S</div>
            <div>
              <h1 class="text-2xl font-semibold text-gray-800">Selamat datang</h1>
              <p class="text-sm text-gray-500">Masuk ke akun Anda untuk melanjutkan</p>
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

          <form method="POST" class="space-y-4" novalidate>
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input
                id="email"
                name="email"
                type="email"
                required
                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                class="input-focus block w-full rounded-md border border-gray-200 px-4 py-2 text-gray-700 placeholder-gray-400 focus:border-green-500"
                placeholder="you@example.com"
                aria-required="true"
              />
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
              <input
                id="password"
                name="password"
                type="password"
                required
                class="input-focus block w-full rounded-md border border-gray-200 px-4 py-2 text-gray-700 placeholder-gray-400 focus:border-green-500"
                placeholder="Masukkan password"
                aria-required="true"
              />
            </div>

            <div class="flex items-center justify-between text-sm">
              <div></div>
              <a href="#" class="text-green-600 hover:underline">Lupa password?</a>
            </div>

            <div>
              <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-md bg-green-600 hover:bg-green-700 text-white px-4 py-2 font-medium shadow-sm">
                Masuk
              </button>
            </div>

            <div class="text-center text-sm text-gray-500">
              Belum punya akun?
              <a href="#" class="text-green-600 hover:underline">Daftar</a>
            </div>

            <div class="text-xs text-gray-400 text-center mt-2">
              Dengan masuk, Anda menyetujui Ketentuan Layanan dan Kebijakan Privasi kami.
            </div>
          </form>
        </div>
      </section>

      <!-- Right: Testimonial / Visual -->
      <aside class="hidden md:flex items-center justify-center bg-gradient-to-br from-green-50 to-white p-8">
        <div class="max-w-sm">
          <blockquote class="text-gray-800 italic text-lg leading-relaxed mb-4">
            “Supabase is the best product experience I’ve had in years. Not just tech - taste. From docs to latency to the URL structure that makes you think ‘oh, that’s obvious’ Feels like every other platform should study how they built it.”
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
</body>
</html>
