<?php

/**
 * Template name: Empresas Edicion
 */


// Detect if user are not logued
protectedPage();

if (getparams('esquema') == '') :
    wp_redirect(home_url('dashboard/empresas/'));
endif;


$empresaClass = new Empresa(getparams('esquema'));

//Detecto si puede editar
$permisoEmpresa = $empresaClass->puedeEditar();


if ($permisoEmpresa) {
} else {
    wp_redirect(home_url('dashboard/empresas/'));
}

get_header();

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Editar esquema</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?php get_template_part('partials/forms/editarempresa', 'form'); ?>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<?php

get_footer(); ?>