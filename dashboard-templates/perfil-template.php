<?php

/**
 * Template name: Perfil
 */


// Detect if user are not logued
protectedPage();

get_header();

if (have_posts()) : while (have_posts()) : the_post();

?>
				<!-- Begin Page Content -->
				<div class="container-fluid">

					<!-- Page Heading -->
					<h1 class="h3 mb-4 text-gray-900"><?php wp_title('');?></h1>

					<div class='alert alert-info p-4'>
						<h4>Bienvenido <?php echo $theuser->first_name;?>!</h4>

						<div class="prevSelect">
							<p class="lead">Para poder realizar crear tu perfil de proyecto/emprendimiento podes elegir de estos perfiles.</p>

							<a href="" data-action="js-select-business" data-val="Personal" class="btn btn-primary">Personal</a>
							<a href="" data-action="js-select-business" data-val="Emprendimiento" class="btn btn-success">Emprendimiento</a>
							<a href="" data-action="js-select-business" data-val="Gran Empresa" class="btn btn-warning">Gran Empresa</a>
						</div>
					</div>

					<div class="card shadow mb-4">
						<div class="card-header card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="text-primary">Perfil</h6>
						</div>
						<div class="card-body">
							<?php get_template_part('partials/forms/profile','form');?>
					  	</div>
					</div>

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->
<?php

endwhile; endif;

get_footer();?>