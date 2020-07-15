<?php

/**
 * Template name: Items
 */


// Detect if user are not logued
protectedPage();

get_header();

?>
				<!-- Begin Page Content -->
				<div class="container-fluid">

					<!-- Page Heading -->
					<h1 class="h3 mb-4 text-gray-900">Listado de Items</h1>

						<?php
						
						//Obtengo las adhesiones de empresas del usuarios
						$empresas = UserData::inst()->empresas();
						

						if(!empty($empresas)) :

							foreach($empresas as $e){
								$empresaObject = new Empresa($e->ID);

								echo $empresaObject->serviciosCard();

							}

							echo "<p><a href='#' data-toggle='modal' data-target='#nuevoitem' class='btn btn-primary'>Agregar producto o servicio</a></p>";

						else :

							echo '<p class="alert alert-info">No has creado ninguna empresa aún.</p>';

						endif;

						get_template_part('partials/forms/nuevoitem','form');

						?>


				</div>
				<!-- /.container-fluid -->
				

			</div>
			<!-- End of Main Content -->
<?php

get_footer();?>