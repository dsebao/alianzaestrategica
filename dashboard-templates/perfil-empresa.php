<?php

/**
 * Template name: Perfil Empresas
 */


// Detect if user are not logued
protectedPage();

get_header();

?>
				<!-- Begin Page Content -->
				<div class="container-fluid">

					<!-- Page Heading -->
					<h1 class="h3 mb-4 text-gray-900">Esquemas</h1>

					<?php
					
					//Obtengo las adhesiones de empresas del usuarios
					$empresas = UserData::inst()->empresas();
					$adhesion = UserData::inst()->adhesion();

					if(empty($empresas) && !$adhesion):?>

					<div class='alert alert-info p-4'>

						<h4>Bienvenido <?php echo $theuser->first_name;?>!</h4>

						<div class="proyectoSelect">


							<p class="lead">En esta instancia podés agregarte como empleado en alguna empresa o crear un perfil de tu emprendimiento o empresa</p>
							
							<a href="" data-toggle="modal" data-target="#unirmeModal" class="btn btn-primary">Unirme a una empresa</a>
							<a href="<?php echo url();?>/dashboard/empresas/nuevo" class="btn btn-success">Crear empresa/emprendimiento</a>
							
						</div>

						<!-- Modal -->
						<div class="modal fade" id="unirmeModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Unirme a una empresa</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<p>Para agregarte a una empresa existente comprueba si existe ingresando el CUIT:</p>
										<form action="" class="js-consultacuit needs-validation">
											<div class="form-group">
												<input type="number" class="form-control" name="cuit" value="" required>
												<div class="invalid-feedback">Ingresá un cuit válido</div>
											</div>
											<input type="hidden" name="action" value="userform">
											<input type="hidden" name="typeform" value="consultacuit_form">
											<button type="submit" class="btn btn-primary">Consultar</button>
											<div class="js-return">
											</div>
										</form>
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php endif;?>

					<?php if(!empty($empresas)) : ?>

					<div class="card shadow mb-4">
						<div class="card-header card-header py-3 d-flex flex-row align-items-center justify-content-between">
							<h6 class="text-primary">Esquemas</h6>
						</div>
						<div class="card-body">
							<?php get_template_part('partials/forms/proyecto','form');?>
					  	</div>
					</div>

					<?php endif; ?>

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->
<?php

get_footer();?>