<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

global $theuser;

?>
<!DOCTYPE html>
<html lang="es">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<?php wp_head(); ?>
</head>

<body <?php body_class(''); ?>>
	<?php do_action('after_body_open_tag'); ?>

	<!-- Page Wrapper -->
	<div id="wrapper">

		<?php include('partials/left-sidebar.php'); ?>

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Topbar -->
				<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

					<!-- Sidebar Toggle (Topbar) -->
					<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
						<i class="fa fa-bars"></i>
					</button>

					<?php include('partials/top-navbar.php'); ?>

				</nav>
				<!-- End of Topbar -->