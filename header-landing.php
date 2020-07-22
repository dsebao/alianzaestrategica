<?php

global $theuser;

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php wp_head(); ?>
</head>

<body id="landing" <?php body_class(''); ?>>
    <?php do_action('after_body_open_tag'); ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-xl">
            <a class="navbar-brand" href="#">Alianza Estrategica</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07XL" aria-controls="navbarsExample07XL" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample07XL">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Acerca de </a>
                    </li>

                    <?php if (is_user_logged_in()) : ?>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/dashboard/'); ?>">Ir al Panel</a>
                        </li>

                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/ingresar'); ?>">Ingresar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo home_url('/registro'); ?>">Registrarme</a>
                        </li>
                    <?php endif; ?>
                </ul>

            </div>
        </div>
    </nav>