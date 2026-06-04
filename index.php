<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Warehouse Management System</title>
  <meta name="description" content="Warehouse Management System — manage inventory, users, and deliveries with a modern, responsive dashboard." />
  <!-- Tailwind CSS (CDN) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#138253',
            accent: '#006239'
          }
        }
      }
    }
  </script>
  <!-- GSAP for subtle animations -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" defer></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&display=swap" rel="stylesheet">
  <style>
    /* Dark glass effect */
    .glass {
      background: rgba(15, 49, 24, 0.6);
      backdrop-filter: blur(6px);
      border: 1px solid #006239;
    }
    
    .card-bg {
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.03), rgba(255, 255, 255, 0.01));
      /* border: 1px solid #323232; */
    }


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

    /* Small form tweaks */
    input,
    textarea {
      background-color: rgba(255, 255, 255, 0.03);
    }
  </style>
</head>

<body class="antialiased google-sans-regular text-neutral-100 bg-[#121212]">
  <!-- NAV -->
  <header class="w-full bg-transparent fixed top-0 left-0 z-40">
    <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
      <a href="index.php" class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-primary to-accent flex items-center justify-center text-neutral-100 google-sans-bold">W</div>
        <span class="google-sans-semibold text-lg">Warehouse</span>
      </a>
      <nav class="hidden md:flex items-center gap-6">
        <a href="./index.php" class="text-neutral-300 hover:text-white">Home</a>
        <a href="./articles.php" class="text-neutral-300 hover:text-white">Articles</a>
        <a href="#features" class="text-neutral-300 hover:text-white">Features</a>
        <a href="#pricing" class="text-neutral-300 hover:text-white">Pricing</a>
        <div class="flex items-center gap-1.5">
          <a href="auth/simple_login.php" class="px-4 py-1.5 rounded-md bg-[#242424] border border-[#323232] hover:bg-neutral-800">Login</a>
          <a href="auth/simple_register.php" class="px-4 py-1.5 rounded-md bg-accent border border-primary text-neutral-100 hover:opacity-95">Get Started</a>
        </div>
      </nav>
      <button id="nav-toggle" class="md:hidden p-2 rounded-md border border-[#363636] bg-[#242424]">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-neutral-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
    <!-- Mobile menu -->
    <div id="mobile-menu" class="md:hidden hidden px-6 pb-6 bg-neutral-900/90 border-t border-[#323232]">
      <div class="flex flex-col gap-3">
        <a href="#features" class="block py-1.5 text-neutral-300">Features</a>
        <a href="#articles" class="block py-1.5 text-neutral-300">Articles</a>
        <a href="#integrations" class="block py-1.5 text-neutral-300">Integrations</a>
        <a href="#pricing" class="block py-1.5 text-neutral-300">Pricing</a>
        <div class="flex gap-2 pt-2">
          <a href="auth/simple_login.php" class="flex-1 text-center py-1.5 border border-[#323232] rounded text-neutral-300">Login</a>
          <a href="auth/simple_register.php" class="flex-1 text-center py-1.5 bg-accent border border-primary text-neutral-100 rounded">Get Started</a>
        </div>
      </div>
    </div>
  </header>

  <!-- HERO -->
  <main class="pt-28">
    <section class="max-w-7xl mx-auto px-6 py-20 grid lg:grid-cols-2 gap-12 items-center">
      <div class="space-y-6">
        <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight">Warehouse Management, reimagined for teams.</h1>
        <p class="text-neutral-300 max-w-xl">Powerful inventory, user and shipment workflows with a beautiful, fast dashboard and enterprise-ready controls. Designed for reliability and clarity.</p>
        <div class="flex flex-col sm:flex-row gap-3">
          <a href="auth/simple_register.php" class="inline-flex items-center gap-3 px-5 py-1.5 rounded-md bg-accent border border-primary text-neutral-100 google-sans-medium shadow">Start free trial</a>
          <a href="#features" class="inline-flex items-center gap-2 px-5 py-1.5 rounded-md border border-[#363636] bg-[#242424] text-neutral-200">Explore features</a>
        </div>

        <div class="mt-6 flex flex-wrap gap-4 text-sm text-neutral-400">
          <div class="flex items-center gap-3 rounded-lg px-4 py-3 bg-neutral-800/60">
            <strong class="text-white">99.9%</strong>
            <span>Uptime</span>
          </div>
          <div class="flex items-center gap-3 rounded-lg px-4 py-3 bg-neutral-800/60">
            <strong class="text-white">Role-based</strong>
            <span>Access control</span>
          </div>
          <div class="flex items-center gap-3 rounded-lg px-4 py-3 bg-neutral-800/60">
            <strong class="text-white">GDPR</strong>
            <span>Compliance-ready</span>
          </div>
        </div>
      </div>

      <div class="relative">
        <div class="rounded-2xl shadow-2xl overflow-hidden glass">
          <!-- Mock dashboard card -->
          <div class="p-6 card-bg">
            <div class="flex items-start justify-between">
              <div>
                <h3 class="text-lg google-sans-semibold text-white">Dashboard overview</h3>
                <p class="text-sm text-neutral-400">Realtime stock, orders, and alerts.</p>
              </div>
              <div class="text-sm text-neutral-400">Live</div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-4">
              <div class="p-4 bg-neutral-800 rounded-lg">
                <div class="text-xs text-neutral-400">Stock</div>
                <div class="mt-2 text-2xl google-sans-bold text-white">12,482</div>
              </div>
              <div class="p-4 bg-neutral-800 rounded-lg">
                <div class="text-xs text-neutral-400">Shipments</div>
                <div class="mt-2 text-2xl google-sans-bold text-white">1,204</div>
              </div>
            </div>

            <div class="mt-6">
              <div class="h-2 bg-neutral-700 rounded-full overflow-hidden">
                <div class="h-full bg-primary" style="width:72%"></div>
              </div>
              <div class="mt-2 text-xs text-neutral-400">Storage used — 72%</div>
            </div>
          </div>
        </div>
        <!-- Accent circles -->
        <div class="absolute -right-8 -bottom-10 w-48 h-48 bg-gradient-to-br from-primary/20 to-accent/20 rounded-full blur-3xl"></div>
      </div>
    </section>

    <!-- FEATURES -->
    <section id="features" class="max-w-7xl mx-auto px-6 py-16">
      <div class="text-center mb-12">
        <h2 class="text-2xl google-sans-bold text-white">Built for modern teams</h2>
        <p class="text-neutral-400 mt-2">Inventory control, user management, and integrations with the tools you already use.</p>
      </div>

      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="p-6 rounded-xl shadow bg-neutral-800/40 border border-[#323232]">
          <h3 class="google-sans-semibold text-white">Inventory & Stock</h3>
          <p class="text-sm text-neutral-400 mt-2">Track quantities, set reorder thresholds, and get low-stock alerts.</p>
        </div>
        <div class="p-6 rounded-xl shadow bg-neutral-800/40 border border-[#323232]">
          <h3 class="google-sans-semibold text-white">Orders & Shipments</h3>
          <p class="text-sm text-neutral-400 mt-2">Manage outbound and inbound shipments with proofs and statuses.</p>
        </div>
        <div class="p-6 rounded-xl shadow bg-neutral-800/40 border border-[#323232]">
          <h3 class="google-sans-semibold text-white">User Roles & Audit</h3>
          <p class="text-sm text-neutral-400 mt-2">Admin and staff roles, activity logs, and secure admin confirmations.</p>
        </div>
        <div class="p-6 rounded-xl shadow bg-neutral-800/40 border border-[#323232]">
          <h3 class="google-sans-semibold text-white">CSV Import & Export</h3>
          <p class="text-sm text-neutral-400 mt-2">Bulk upload and export inventories and reports.</p>
        </div>
        <div class="p-6 rounded-xl shadow bg-neutral-800/40 border border-[#323232]">
          <h3 class="google-sans-semibold text-white">Integrations</h3>
          <p class="text-sm text-neutral-400 mt-2">Connect with accounting, shipping providers, and BI tools.</p>
        </div>
        <div class="p-6 rounded-xl shadow bg-neutral-800/40 border border-[#323232]">
          <h3 class="google-sans-semibold text-white">Secure & Compliant</h3>
          <p class="text-sm text-neutral-400 mt-2">Role checks, prepared statements, and configurable retention policies.</p>
        </div>
      </div>
    </section>

    <!-- ARTICLES -->
    <section id="articles" class="max-w-7xl mx-auto px-6 py-12">
      <div class="text-center mb-8">
        <h2 class="text-2xl google-sans-bold text-white">Articles & Resources</h2>
        <p class="text-neutral-400 mt-2">Guides and best practices for managing warehouses and inventory.</p>
      </div>
      <div class="grid md:grid-cols-3 gap-6">
        <article class="p-6 bg-neutral-800/40 rounded-xl shadow border border-[#323232]">
          <h3 class="google-sans-semibold text-white">Getting started with Warehouse W</h3>
          <p class="text-neutral-400 text-sm mt-2">Set up your first warehouse, import inventory, and invite team members.</p>
          <a href="#" class="mt-4 inline-block text-primary">Read more →</a>
        </article>
        <article class="p-6 bg-neutral-800/40 rounded-xl shadow border border-[#323232]">
          <h3 class="google-sans-semibold text-white">Inventory best practices</h3>
          <p class="text-neutral-400 text-sm mt-2">Tips for stock rotation, reorder points, and minimizing shrinkage.</p>
          <a href="#" class="mt-4 inline-block text-primary">Read more →</a>
        </article>
        <article class="p-6 bg-neutral-800/40 rounded-xl shadow border border-[#323232]">
          <h3 class="google-sans-semibold text-white">Secure admin workflows</h3>
          <p class="text-neutral-400 text-sm mt-2">Implementing confirmations, audits, and role separation.</p>
          <a href="#" class="mt-4 inline-block text-primary">Read more →</a>
        </article>
      </div>
    </section>

    <!-- INTEGRATIONS -->
    <section id="integrations" class="max-w-7xl mx-auto px-6 py-12">
      <div class="bg-neutral-800/40 rounded-xl p-6 shadow flex flex-col sm:flex-row items-center justify-between gap-6">
        <div>
          <h3 class="text-lg google-sans-semibold text-white">Connect to the tools you use</h3>
          <p class="text-neutral-400 mt-1">Quickly export data or connect programmatically using prepared APIs.</p>
        </div>
        <div class="flex items-center gap-4">
          <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" alt="MySQL" class="h-8 opacity-80" />
          <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" alt="PHP" class="h-8 opacity-80" />
          <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" alt="JS" class="h-8 opacity-80" />
        </div>
      </div>
    </section>

    <!-- CONTACT -->
    <section id="contact" class="max-w-7xl mx-auto px-6 py-12">
      <div class="grid md:grid-cols-2 gap-6 items-center">
        <div>
          <h3 class="text-2xl google-sans-bold text-white">Contact us</h3>
          <p class="text-neutral-400 mt-2">Have questions or need a demo? Send a message and our team will reach out within one business day.</p>

          <div class="mt-6 text-sm text-neutral-400">
            <div><strong>Email:</strong> <a href="mailto:hello@warehouse.local" class="text-primary">hello@warehouse.local</a></div>
            <div class="mt-2"><strong>Phone:</strong> <span class="text-neutral-300">+62 812-3456-7890</span></div>
          </div>
        </div>
        <form id="contact-form" class="space-y-4 bg-neutral-800/40 p-6 rounded-xl shadow">
          <div>
            <label class="text-sm text-neutral-300">Name</label>
            <input name="name" required class="w-full mt-1 p-2 rounded border border-neutral-700 text-neutral-100" />
          </div>
          <div>
            <label class="text-sm text-neutral-300">Email</label>
            <input name="email" type="email" required class="w-full mt-1 p-2 rounded border border-neutral-700 text-neutral-100" />
          </div>
          <div>
            <label class="text-sm text-neutral-300">Message</label>
            <textarea name="message" rows="4" required class="w-full mt-1 p-2 rounded border border-neutral-700 text-neutral-100"></textarea>
          </div>
          <div class="flex items-center justify-between">
            <button type="submit" class="px-4 py-1.5 bg-accent border border-primary text-neutral-100 rounded">Send message</button>
            <div id="contact-status" class="text-sm text-neutral-400"></div>
          </div>
        </form>
      </div>
    </section>

    <!-- PRICING / CTA -->
    <section id="pricing" class="max-w-7xl mx-auto px-6 py-12">
      <div class="grid md:grid-cols-3 gap-6">
        <div class="p-6 rounded-xl shadow bg-neutral-800/40 border border-[#323232]">
          <h4 class="google-sans-semibold text-white">Free</h4>
          <div class="mt-4 text-3xl google-sans-bold text-white">$0</div>
          <p class="text-sm text-neutral-400 mt-2">Single warehouse, basic reports, community support.</p>
          <a href="auth/simple_register.php" class="mt-6 inline-block px-4 py-1.5 bg-accent border border-primary text-neutral-100 rounded">Start free</a>
        </div>
        <div class="p-6 rounded-xl shadow bg-neutral-800/40 border border-[#323232]">
          <h4 class="google-sans-semibold text-white">Team</h4>
          <div class="mt-4 text-3xl google-sans-bold text-white">$29<span class="text-sm google-sans-medium">/mo</span></div>
          <p class="text-sm text-neutral-400 mt-2">Multi-user, integrations, and priority support.</p>
          <a href="#" class="mt-6 inline-block px-4 py-1.5 border border-[#323232] rounded text-neutral-200">Contact sales</a>
        </div>
        <div class="p-6 rounded-xl shadow bg-neutral-800/40 border border-[#323232]">
          <h4 class="google-sans-semibold text-white">Enterprise</h4>
          <div class="mt-4 text-3xl google-sans-bold text-white">Custom</div>
          <p class="text-sm text-neutral-400 mt-2">SLA, dedicated support, on-prem options.</p>
          <a href="#" class="mt-6 inline-block px-4 py-1.5 border border-[#323232] rounded text-neutral-200">Contact sales</a>
        </div>
      </div>
    </section>

    <!-- FOOTER -->
    <footer class="mt-12 border-t border-neutral-800">
      <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-sm text-neutral-400">© "Warehouse" — Built with PHP, MySQL, and Tailwind</div>
        <div class="flex items-center gap-4 text-sm text-neutral-400">
          <a href="#">Privacy</a>
          <a href="#">Terms</a>
          <a href="pages/dashboard.php">Dashboard</a>
        </div>
      </div>
    </footer>
  </main>

  <script>
    // Mobile nav toggle
    const navToggle = document.getElementById('nav-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    navToggle && navToggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    // Hero entrance animation using GSAP when available
    window.addEventListener('load', () => {
      if (window.gsap) {
        gsap.from('h1', {
          y: 20,
          opacity: 0,
          duration: 0.8,
          ease: 'power3.out'
        });
        gsap.from('main > section div p', {
          y: 8,
          opacity: 0,
          duration: 0.8,
          delay: 0.1
        });
        gsap.from('.glass', {
          scale: 0.98,
          opacity: 0,
          duration: 0.9,
          delay: 0.15
        });
      }
    });

    // Contact form (AJAX placeholder)
    const contactForm = document.getElementById('contact-form');
    const contactStatus = document.getElementById('contact-status');
    contactForm && contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      contactStatus.textContent = 'Sending…';
      const form = new FormData(contactForm);
      try {
        // Try sending to a backend endpoint if available
        const res = await fetch('auth/contact.php', {
          method: 'POST',
          body: form
        });
        if (res.ok) {
          contactStatus.textContent = 'Message sent — thanks!';
          contactForm.reset();
        } else {
          contactStatus.textContent = 'Unable to send. Please email hello@warehouse.local';
        }
      } catch (err) {
        contactStatus.textContent = 'Unable to send. Please email hello@warehouse.local';
      }
    });

    // Small progressive enhancement: prefers-reduced-motion
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      document.querySelectorAll('[style*="transition"]').forEach(el => el.style.transition = 'none');
    }
  </script>
</body>

</html>