<?php

/**
 * Template name: Perfil
 */

get_header();

if (have_posts()) : while (have_posts()) : the_post();

?>
				<!-- Begin Page Content -->
				<div class="container-fluid">

					<!-- Page Heading -->
					<h1 class="h3 mb-4 text-gray-800"><?php wp_title('');?></h1>

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->
<?php

endwhile; endif;

get_footer();?>