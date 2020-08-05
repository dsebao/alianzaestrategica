<?php

global $mypresu;

$data = get_post_meta($mypresu->ID);
$items = json_decode($data['presupuesto_items'][0], true);

$data

?>
<div class="card shadow propuesta-card">
    <div class="card-body">
        <h4>#<?php echo $mypresu->ID; ?> <?php echo $mypresu->post_title; ?></h4>

        <div class="meta">
            <p>
                <span>Empresa:</span> <?php echo $data['presupuesto_esquemanombre'][0]; ?><br>
                <span>Fecha creado:</span> <?php echo the_time('d-m-Y'); ?><br>
                <span>Fecha limite:</span> <?php echo date('d-m-Y', strtotime($data['presupuesto_fechalimite'][0])); ?><br>
                <span>Descripción adicional:</span><br>
                <?php echo $mypresu->post_content; ?>
            </p>
        </div>
        <hr>
        <div class="productos">
            <?php

            $generateTable = createTableData(
                array('PRODUCTO', 'CANTIDAD'),
                $items,
                'array'
            );

            echo $generateTable;
            ?>
        </div>
    </div>
</div>

<section id="propuestas-empresas">
    <?php

    $userpropuesta = UserData::propuestaView($mypresu->ID);

    //printr($userpropuesta);

    ?>
</section>