<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Solusi Warehouse Management terpadu dengan teknologi terkini">
	<meta name="author" content="Warehouse Solutions">

	<title>Warehouse Solutions - Tailored Fulfillment for E-Commerce</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

	<!-- Tailwind CSS via CDN -->
	<script src="https://cdn.tailwindcss.com"></script>

	<!-- Custom CSS -->
	<link rel="stylesheet" href="../style/global.css">
	<!-- <link rel="stylesheet" href="../style/landing.css"> -->

	<!-- Feather Icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.css">

	<!-- GSAP for animations -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollToPlugin.min.js"></script>

	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		html,
		body {
			scroll-behavior: smooth;
		}

		.input-focus:focus {
      outline: none;
      box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.12);
    }
	</style>

	<script>
		const prefersDark = localStorage.getItem('color-theme') === 'dark' ||
			(!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);

		if (prefersDark) {
			document.documentElement.classList.add('dark');
		} else {
			document.documentElement.classList.remove('dark');
		}

		document.addEventListener('DOMContentLoaded', () => {
			const themeToggleBtn = document.getElementById('theme-toggle');
			const darkIcon = document.getElementById('theme-toggle-dark-icon');
			const lightIcon = document.getElementById('theme-toggle-light-icon');

			const updateThemeIcons = () => {
				if (document.documentElement.classList.contains('dark')) {
					darkIcon?.classList.add('hidden');
					lightIcon?.classList.remove('hidden');
				} else {
					lightIcon?.classList.add('hidden');
					darkIcon?.classList.remove('hidden');
				}
			};

			if (!themeToggleBtn || !darkIcon || !lightIcon) {
				return;
			}

			updateThemeIcons();

			themeToggleBtn.addEventListener('click', () => {
				const isDark = document.documentElement.classList.contains('dark');
				if (isDark) {
					document.documentElement.classList.remove('dark');
					localStorage.setItem('color-theme', 'light');
				} else {
					document.documentElement.classList.add('dark');
					localStorage.setItem('color-theme', 'dark');
				}
				updateThemeIcons();
			});
		});
	</script>
</head>