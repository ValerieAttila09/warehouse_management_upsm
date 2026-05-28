<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Leveron - Sign Up</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="../js/index.js" defer></script>
  <link rel="stylesheet" href="../style/global.css">
</head>

<body class="bg-white google-sans-regular">
  <div class="min-h-screen w-full grid grid-cols-2 p-2 gap-2">
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

    <div class="w-full p-6 flex flex-col items-between justify-start gap-6">
      <div class="flex items-center justify-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-black">
          <path d="M12.378 1.602a.75.75 0 0 0-.756 0L3 6.632l9 5.25 9-5.25-8.622-5.03ZM21.75 7.93l-9 5.25v9l8.628-5.032a.75.75 0 0 0 .372-.648V7.93ZM11.25 22.18v-9l-9-5.25v8.57a.75.75 0 0 0 .372.648l8.628 5.033Z" />
        </svg>
        <span class="text-black text-xl google-sans-semibold">Leveron</span>
      </div>

      <div class="mx-auto w-full max-w-2xl flex flex-col justify-center flex-1">
        <div class="w-full flex flex-col items-center justify-center gap-2 text-center">
          <h1 class="text-3xl text-black google-sans-semibold">Welcome to Leveron</h1>
          <p class="text-neutral-700 text-center">Create your account with a smooth multi-step registration flow.</p>
        </div>

        <?php
        session_start();
        $register_error = $_SESSION['register_error'] ?? '';
        $register_success = $_SESSION['register_success'] ?? '';
        unset($_SESSION['register_error'], $_SESSION['register_success']);
        ?>
        <?php if ($register_error): ?>
          <div class="mb-4 w-full max-w-lg mx-auto bg-red-100 text-red-700 rounded-lg px-4 py-2 text-center text-sm"><?php echo htmlspecialchars($register_error); ?></div>
        <?php elseif ($register_success): ?>
          <div class="mb-4 w-full max-w-lg mx-auto bg-green-100 text-green-700 rounded-lg px-4 py-2 text-center text-sm"><?php echo htmlspecialchars($register_success); ?></div>
        <?php endif; ?>
        <div class="w-full my-6 relative min-h-[540px]">
          <div id="register-step-1" class="absolute inset-0 bg-white p-6">
            <form class="h-full flex flex-col justify-between gap-5" id="basic-register-form" method="POST" action="process_register.php" enctype="multipart/form-data">
              <div class="space-y-4">
                <div class="flex items-center gap-2">
                  <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-black text-white text-sm">1</span>
                  <div>
                    <p class="text-sm font-medium text-black">Basic account details</p>
                    <p class="text-xs text-neutral-500">Start with your personal identity and login information.</p>
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                  <div class="grid gap-1.5">
                    <label for="first_name" class="text-sm text-neutral-700">First name</label>
                    <input
                      class="p-2.5 rounded-xl border border-neutral-200 bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-300"
                      type="text"
                      placeholder="John"
                      name="first_name"
                      id="first_name"
                      required>
                  </div>
                  <div class="grid gap-1.5">
                    <label for="last_name" class="text-sm text-neutral-700">Last name</label>
                    <input
                      class="p-2.5 rounded-xl border border-neutral-200 bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-300"
                      type="text"
                      placeholder="Doe"
                      name="last_name"
                      id="last_name"
                      required>
                  </div>
                </div>

                <div class="grid gap-1.5">
                  <label for="email" class="text-sm text-neutral-700">Email</label>
                  <input
                    class="p-2.5 rounded-xl border border-neutral-200 bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-300"
                    type="email"
                    placeholder="Enter your email"
                    name="email"
                    id="email"
                    required>
                </div>

                <div class="grid gap-1.5">
                  <label for="password" class="text-sm text-neutral-700">Password</label>
                  <input
                    class="p-2.5 rounded-xl border border-neutral-200 bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-300"
                    type="password"
                    placeholder="Enter your password"
                    name="password"
                    id="password"
                    required>
                </div>

                <div class="grid gap-1.5">
                  <label for="password" class="text-sm text-neutral-700">Verify password</label>
                  <input
                    class="p-2.5 rounded-xl border border-neutral-200 bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-300"
                    type="password"
                    placeholder="Verify your password"
                    name="password_verify"
                    id="password_verify"
                    required>
                </div>
              </div>

              <div class="space-y-2">
                <button id="continue-btn" type="button" disabled class="flex items-center justify-center gap-3 cursor-not-allowed bg-neutral-800/70 hover:bg-neutral-800/70 shadow-none transition-all w-full mx-auto rounded-xl p-3 text-white text-center group disabled:opacity-70 disabled:cursor-not-allowed">
                  <span>Continue</span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-white group-hover:translate-x-1 transition-all">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                  </svg>
                </button>
                <p class="text-xs text-center text-neutral-500">Step 1 of 2</p>
              </div>
            </form>
          </div>

          <div id="register-step-2" class="absolute inset-0 bg-white p-6 opacity-0 pointer-events-none">
            <form class="h-full flex flex-col justify-between gap-5" id="business-register-form">
              <div class="space-y-4">
                <div class="flex items-center gap-2">
                  <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-neutral-900 text-white text-sm">2</span>
                  <div>
                    <p class="text-sm font-medium text-black">Additional profile details</p>
                    <p class="text-xs text-neutral-500">Complete your profile with contact and location details.</p>
                  </div>
                </div>

                <div class="grid gap-4 md:grid-cols-[1.1fr_0.9fr]">
                  <div class="space-y-3">
                    <div class="grid gap-1.5">
                      <label for="country" class="text-sm text-neutral-700">Country</label>
                      <select id="country" name="country" class="p-2.5 rounded-xl border border-neutral-200 bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-300">
                        <option value="Indonesia">Indonesia</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="United States">United States</option>
                        <option value="United Kingdom">United Kingdom</option>
                      </select>
                    </div>

                    <div class="grid gap-1.5">
                      <label for="phone" class="text-sm text-neutral-700">Phone number</label>
                      <input
                        type="tel"
                        id="phone"
                        name="phone"
                        placeholder="+62 812 3456 7890"
                        class="p-2.5 rounded-xl border border-neutral-200 bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-300">
                    </div>

                    <div class="grid gap-1.5">
                      <label for="zip_code" class="text-sm text-neutral-700">Zip code</label>
                      <input
                        type="text"
                        id="zip_code"
                        name="zip_code"
                        placeholder="10220"
                        class="p-2.5 rounded-xl border border-neutral-200 bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-300">
                    </div>
                  </div>

                  <div class="space-y-3">
                    <div class="grid gap-1.5">
                      <label for="profile_photo" class="text-sm text-neutral-700">Profile photo</label>
                      <label for="profile_photo" class="group flex h-40 cursor-pointer flex-col items-center justify-center rounded-2xl border border-dashed border-neutral-300 bg-neutral-50 p-4 text-center transition hover:border-neutral-500 hover:bg-neutral-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 text-neutral-500">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                        </svg>
                        <span class="mt-2 text-sm font-medium text-neutral-700">Upload profile image</span>
                        <span class="mt-1 text-xs text-neutral-500">PNG, JPG, or WEBP</span>
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="sr-only">
                      </label>
                    </div>

                    <div class="grid gap-1.5">
                      <label for="address" class="text-sm text-neutral-700">Address</label>
                      <textarea
                        id="address"
                        name="address"
                        rows="5"
                        placeholder="Street address, apartment, etc."
                        class="p-2.5 rounded-xl border border-neutral-200 bg-neutral-50 focus:outline-none focus:ring-2 focus:ring-neutral-300"></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="grid gap-2">
                <button type="submit" disabled class="flex items-center justify-center gap-3 cursor-not-allowed bg-neutral-800/70 hover:bg-neutral-800/70 shadow-none transition-all w-full mx-auto rounded-xl p-3 text-white text-center group disabled:opacity-70 disabled:cursor-not-allowed">
                  <span>Create account</span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-white group-hover:translate-x-1 transition-all">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                  </svg>
                </button>
                <button id="back-btn" type="button" class="w-full rounded-xl border border-neutral-300 px-3 py-2 text-sm text-neutral-700 hover:bg-neutral-100 transition">Back</button>
                <p class="text-xs text-center text-neutral-500">Step 2 of 2</p>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="flex items-center justify-center">
        <p class="text-neutral-600">Already have an account? <a href="./login.php" class="text-black font-medium">Sign In</a></p>
      </div>
    </div>
  </div>
</body>

</html>