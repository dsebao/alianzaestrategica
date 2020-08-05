<?php

/**
 * Template name: Presupuestos Recibidos
 */


// Detect if user are not logued
protectedPage();


get_header();

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Presupuestos recibidos</h1>

    <?php

    //Obtengo las adhesiones de empresas del usuarios
    $userClass = UserData::inst();

    $presupuestos = $userClass->presupuestosRecibidos();

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