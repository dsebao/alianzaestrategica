<?php

/**
 * Template name: Perfil
 */


// Detect if user are not logued
protectedPage();

get_header();

?>
<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-900"><?php wp_title(''); ?></h1>


	<div class="card shadow mb-4">
		<div class="card-header card-header py-3 d-flex flex-row align-items-center justify-content-between">
			<h6 class="text-primary">Perfil</h6>
		</div>
		<div class="card-body">
			<?php get_template_part('partials/forms/profile', 'form'); ?>
		</div>
	</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php

get_footer(); ?>