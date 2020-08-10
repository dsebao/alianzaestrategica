<?php

global $e;
$empresa = new Empresa($e->ID);

$u = UserData::inst();
$permiso = $u->permisosEmpresa($e->ID);

?>

<div class="card card-empresa shadow mb-5">
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                <?php if ($empresa->printdata('empresa_logo') != '') {
                    echo "<img class='w-100' src='" . $empresa->printdata('empresa_logo') . "'>";
                } ?>
            </div>
            <div class="col-md-10">

                <h3 class='text-primary'><?php echo $e->post_title; ?></h3>

                <span class="badge badge-info"><?php echo $empresa->printdata('empresa_tipo'); ?></span><br>

                <hr>

                <p class="lead"><?php echo $e->post_content; ?></p>

                <p class='card-metadata'>
                    <i class="fas fa-map-marker-alt"></i> <?php echo $empresa->printdata('empresa_direccion'); ?><br>
                    <i class="fas fa-mobile-alt"></i> <?php echo $empresa->printdata('empresa_tel'); ?></br>
                </p>

                <?php if ($empresa->detectOperations()) {

                    echo $empresa->serviciosList();

                    echo "<p>Para editar servicio o productos podes realizarlo en la seccion de <a href='" . get_bloginfo('url') . "/dashboard/empresas/items'>items</a></p>";
                } else {

                    echo '<p class="alert alert-info">Agrega <a href="' . get_bloginfo('url') . '/dashboard/empresas/items">servicios y productos</a> a tu actual esquema.</p>';
                } ?>

            </div>
        </div>
    </div>
    <?php if ($permiso != 'colaborador') { ?>
        <div class="card-footer text-right">
            <a href="<?php url(); ?>/dashboard/empresas/edicion/?esquema=<?php echo $e->ID; ?>" class="btn btn-primary">Editar esquema</a>
        </div>
    <?php } ?>
</div>