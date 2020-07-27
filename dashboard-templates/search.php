<?php

/**
 * Template name: Dashboard Search
 */


// Detect if user are not logued
protectedPage();

get_header();

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php wp_title(''); ?></h1>

    <div class="row">
        <div class="col-md-7 mb-5">
            <?php

            if (getparams('search') != '' && strlen(getparams('search')) > 3) {

                echo "<h5 class='mb-4 font-weight-normal'>Estas buscando " . getparams('search') . "</h5>";

                $results = searchQuery($_GET);

                if (!empty($results->posts)) {

                    foreach ($results->posts as $item) {
                        if (getparams('tipo') == 'servicios')
                            get_template_part('partials/empresas/servicios', 'minicard');
                        elseif (getparams('tipo') == 'productos')
                            get_template_part('partials/empresas/servicios', 'minicard');
                        else
                            get_template_part('partials/empresas/empresa', 'minicard');
                    }
                }
            } else {
                echo "<h5>Por favor ingresa algun parametro para realizar una búsqueda.</h5>";
            }

            ?>
        </div>
        <div class="col-md-5">
            Loading widgets
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php
get_footer(); ?>