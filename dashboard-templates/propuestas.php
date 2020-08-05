<?php

/**
 * Template name: Propuestas
 */


// Detect if user are not logued
protectedPage();

$idpresu = getparams('presupuesto');

$loadsingle = false;

if ($idpresu != '') {
    $mypresu = get_post($idpresu);
    if (!empty($mypresu)) {
        $loadsingle = true;
    }
}

get_header();

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Propuestas</h1>


    <?php
    if ($loadsingle) {
        get_template_part('partials/presupuestos/propuestas', 'single');
    } else {
        get_template_part('partials/presupuestos/propuestas', 'listado');
    }

    ?>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php

get_footer(); ?>