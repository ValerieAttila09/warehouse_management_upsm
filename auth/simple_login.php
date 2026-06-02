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

    /* Custom kecil untuk efek fokus */
    .input-focus:focus {
      outline: none;
      box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.12);
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
              <h1 class="text-2xl google-sans-semibold text-white">Welcome Back!</h1>
              <p class="text-sm text-neutral-300">Sign in to your account to continue</p>
            </div>
          </div>

          <?php if ($message): ?>
            <div role="alert" aria-live="polite" class="mb-4">
              <?php if ($messageType === 'error'): ?>
                <div class="rounded-md bg-red-800 border border-red-500 p-3 text-red-200 text-sm">
                  <?php echo htmlspecialchars($message); ?>
                </div>
              <?php else: ?>
                <div class="rounded-md bg-green-800 border border-green-500 p-3 text-green-200 text-sm">
                  <?php echo htmlspecialchars($message); ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <form method="POST" class="space-y-4" novalidate>
            <div>
              <label for="email" class="block text-sm google-sans-medium text-neutral-400 mb-1">Email</label>
              <input
                id="email"
                name="email"
                type="email"
                required
                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                class="input-focus text-sm bg-neutral-800 block w-full rounded-md border border-neutral-700 px-4 py-1.5 text-neutral-200 placeholder-neutral-500 focus:border-green-700"
                placeholder="you@example.com"
                aria-required="true" />
            </div>

            <div>
              <label for="password" class="block text-sm google-sans-medium text-neutral-400 mb-1">Password</label>
              <input
                id="password"
                name="password"
                type="password"
                required
                class="input-focus text-sm bg-neutral-800 block w-full rounded-md border border-neutral-700 px-4 py-1.5 text-neutral-200 placeholder-neutral-500 focus:border-green-700"
                placeholder="Enter your password"
                aria-required="true" />
            </div>

            <div class="flex items-center justify-between text-sm">
              <div></div>
              <a href="#" class="text-green-600 hover:underline">Lupa password?</a>
            </div>

            <div>
              <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-md bg-green-800 border border-green-700 hover:bg-green-700 text-white px-4 py-1 google-sans-medium shadow-sm">
                Sign In
              </button>
            </div>

            <div class="text-center text-sm text-neutral-300">
              Don't have an account?
              <a href="./simple_register.php" class="text-green-600 hover:underline">Daftar</a>
            </div>

            <div class="text-xs text-neutral-400 text-center mt-2">
              By signing in, you agree to our Terms of Service and Privacy Policy.
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
</body>

</html>