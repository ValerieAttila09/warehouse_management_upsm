<?php
require_once dirname(__DIR__) . '/auth/acl.php';
// dashboard available to both staff and admin
require_role(['staff', 'admin']);
?>
<!doctype html>
<html lang="en" class="dark">

<?php
include "../contents/header.php";
?>

<body class="bg-neutral-50 dark:bg-neutral-800">

	<?php
	include "../contents/widgets/navbar.php";
	?>

	<div class="flex pt-16 overflow-hidden bg-neutral-50 dark:bg-neutral-900">
		<?php
		include "../contents/widgets/sidebar.php";
		?>

		<div class="fixed inset-0 z-10 hidden bg-neutral-900/50 dark:bg-neutral-900/90" id="sidebarBackdrop"></div>

		<?php
		include "../contents/dashboard_content.php";
		?>

	</div>


	<script async defer src="https://buttons.github.io/buttons.js"></script>
	<script src="https://flowbite-admin-dashboard.vercel.app//app.bundle.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.2/datepicker.min.js"></script>
</body>

</html>