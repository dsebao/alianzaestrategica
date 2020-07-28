<?php

/**
 * Template name: Presupuestos Enviados
 */


// Detect if user are not logued
protectedPage();


get_header();

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-900">Presupuestos enviados</h1>
        <a href="<?php bloginfo('url'); ?>/dashboard/presupuestos/nuevo" class="d-none d-sm-inline-block btn btn-success shadow-sm"><i class="fas fa-fw fa-table text-white-50"></i> Nuevo Presupuesto</a>
    </div>

    <?php

    //Obtengo las adhesiones de empresas del usuarios
    $userClass = UserData::inst();

    $presupuestos = $userClass->presupuestosEnviados();

    $generateTable = createTableData(
        array('ID', 'FECHA', 'TITULO', 'PRODUCTOS', 'PEDIDO POR', 'FINALIZA', 'ACCIONES'),
        $presupuestos,
        'post'
    );
    ?>

    <div class="card">
        <div class="card-body">
            <?php echo $generateTable; ?>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php

get_footer(); ?>