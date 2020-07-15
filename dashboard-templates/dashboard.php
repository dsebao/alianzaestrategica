<?php

/**
 * Template name: Dashboard
 */


// Detect if user are not logued
protectedPage();

get_header();

if (have_posts()) : while (have_posts()) : the_post();

?>
		<!-- Begin Page Content -->
		<div class="container-fluid">

			<!-- Page Heading -->
			<h1 class="h3 mb-4 text-gray-800"><?php wp_title('');?></h1>

			<div class="row">
				<div class="col-md-7">
					<?php get_template_part('partials/dashboard/dashboard','timeline');?>
				</div>
				<div class="col-md-5">
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary">Mi perfil</h6>
						</div>
						<div class="card-body">
							<h4 class="small font-weight-bold">Mi empresa <span class="float-right">80%</span></h4>
							<div class="progress mb-4">
								<div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20"
									aria-valuemin="0" aria-valuemax="100"></div>
							</div>

							<h4 class="small font-weight-bold">Mi perfil <span class="float-right">Completo!</span></h4>
							<div class="progress">
								<div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100"
									aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<!-- /.container-fluid -->

	</div>
	<!-- End of Main Content -->
<?php

endwhile; endif;

get_footer();?>