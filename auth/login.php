<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Leveron - Sign In</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="../style/global.css">
</head>

<body class="bg-white google-sans-regular">
  <div class="min-h-screen w-full grid grid-cols-2 p-2">
    <div class="bg-neutral-900 rounded-2xl flex flex-col items-start justify-between p-8">
      <div class="w-full flex gap-6 items-center">
        <span class="w-auto text-nowrap text-white google-sans-medium">A WISE QUOTE</span>
        <div class="w-full h-px bg-white"></div>
      </div>
      <div class="max-w-md space-y-2">
        <h1 class="text-6xl text-white google-sans-semibold">GET EVERYTHING YOU WANT</h1>
        <h3 class="text-md text-white/80">You can get everything you want if you work hard, trust the process, and stick to the plan.</h3>
      </div>
    </div>
    <div class="w-full p-6 flex flex-col items-between justify-start">
      <div class="flex items-center justify-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-black">
          <path d="M12.378 1.602a.75.75 0 0 0-.756 0L3 6.632l9 5.25 9-5.25-8.622-5.03ZM21.75 7.93l-9 5.25v9l8.628-5.032a.75.75 0 0 0 .372-.648V7.93ZM11.25 22.18v-9l-9-5.25v8.57a.75.75 0 0 0 .372.648l8.628 5.033Z" 5 text-black />
        </svg>
        <span class="text-black text-xl google-sans-semibold">Leveron</span>
      </div>
      <div class="mx-auto w-3/5 h-full flex flex-col justify-center">
        <div class="w-full flex flex-col items-center justify-center gap-2">
          <h1 class="text-3xl text-black google-sans-semibold">Welcome Back</h1>
          <p class="text-neutral-700 text-center">Enter your email and password to access your account</p>
        </div>
        <?php
        session_start();
        $login_error = $_SESSION['login_error'] ?? '';
        unset($_SESSION['login_error']);
        ?>
        <?php if ($login_error): ?>
          <div class="mb-4 w-full max-w-lg mx-auto bg-red-100 text-red-700 rounded-lg px-4 py-2 text-center text-sm"><?php echo htmlspecialchars($login_error); ?></div>
        <?php endif; ?>
        <form method="POST" action="process_login.php" accept-charset="UTF-8" class="w-full space-y-6 my-12">
          <div class="grid gap-1">
            <label for="email">Email</label>
            <input
              class="p-2.5 rounded-xl border border-neutral-200 bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-300"
              type="text"
              placeholder="Enter your email"
              name="email"
              aria-label="email"
              required>
          </div>
          <div class="grid gap-1">
            <label for="password">Password</label>
            <input
              class="p-2.5 rounded-xl border border-neutral-200 bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-300"
              type="password"
              placeholder="Enter your password"
              name="password"
              aria-label="password"
              required>
          </div>
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <input type="checkbox" name="remember" id="remember">
              <span class="">Remember me</span>
            </div>
            <a href="#" class="text-black">Forgot Password</a>
          </div>
          <button class="my-6 cursor-pointer hover:bg-neutral-800 hover:shadow transition-all w-full mx-auto bg-black rounded-lg p-3 text-white text-center">Sign In</button>
        </form>
      </div>
      <div class="flex items-center justify-center">
        <p class="text-neutral-600">Don't have an account? <a href="./register.php" class="text-black">Sign Up</a></p>
      </div>
    </div>
  </div>
</body>

</html>