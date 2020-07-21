<?php

/**
 * Template name: Empresas Usuarios
 */


// Detect if user are not logued
protectedPage();

$userClass = UserData::inst();

$empresas = $userClass->empresas();
$adhesiones = $userClass->adhesion();


get_header();

?>
<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-900">Gestión de usuarios</h1>

	<?php

	if (is_array($empresas) && !empty($empresas)) :

		foreach ($empresas as $e) {

			$userEmpresa = getUsersEmpresas($e->ID);

			get_template_part('partials/empresas/usuarios', 'tabla');
		}

	elseif (is_array($adhesiones) && !empty($adhesiones)) :

		foreach ($adhesiones as $emp) :

			$permiso = $userClass->permisosEmpresa($emp['id']);

			$userEmpresa = getUsersEmpresas($emp['id']);

			$e = get_post($emp['id']);

			if (in_array('administrador', $permiso)) {
				get_template_part('partials/empresas/usuarios', 'tabla');
			} else {
				echo "No posees permisos de administrador gestionar usuarios";
			}

		endforeach;
	endif;

	?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php

get_footer(); ?>