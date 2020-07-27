<?php

/**
 * Template name: Empresas Listado
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
	$userClass = UserData::inst();

	$empresas = $userClass->empresas();

	$adhesion = $userClass->adhesion();

	$rol = $userClass->haveRol('editor');

	$exist = array();

	if (empty($empresas) && !$adhesion) : ?>

		<div class='alert alert-info p-4'>

			<h4>Bienvenido <?php echo $theuser->first_name; ?>!</h4>

			<div class="proyectoSelect">


				<p class="lead">En esta instancia podés agregarte como empleado en alguna empresa o crear un perfil de tu emprendimiento o empresa</p>

				<a href="" data-toggle="modal" data-target="#unirmeModal" class="btn btn-primary">Unirme a una empresa</a>
				<a href="<?php echo url(); ?>/dashboard/empresas/nuevo" class="btn btn-success">Crear empresa/emprendimiento</a>

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
	<?php

	endif;

	if (!empty($empresas)) :


		foreach ($empresas as $e) {


			$exist[] = $e->ID;

			get_template_part('partials/empresas/empresa', 'card');
		}

	endif;

	if (!empty($adhesion)) :
		foreach ($adhesion as $emp) {

			//Detecto si no esta previamente en los esquemas propios
			if (!in_array($emp['id'], $exist)) :

				$permiso = $userClass->permisosEmpresa($emp['id']);

				$e = get_post($emp['id']);

				if (in_array('activo', $permiso)) {
					$e = get_post($emp['id']);
					get_template_part('partials/empresas/empresa', 'card');
				} else {
					echo "<div class='mb-4 alert alert-info lead'>Tenés una solicitud pendiente de activación para el esquema <b>$e->post_title.</b> Contactate con algún administrador para que te pueda finalizar la adhesión.</div>";
				}

			endif;
		}
	endif;

	?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php

get_footer(); ?>