<?php

/**
 * Template name: Empresas Nueva
 */


// Detect if user are not logued
protectedPage();

get_header();

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900"><?php wp_title(''); ?></h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?php get_template_part('partials/forms/nuevaempresa', 'form'); ?>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
<?php

get_footer(); ?>