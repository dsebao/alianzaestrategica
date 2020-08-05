<?php

//Obtengo las adhesiones de empresas del usuarios
$userClass = UserData::inst();

$propuestas = $userClass->propuestasListado();

$generateTable = createTableData(
    array('ID', 'PRESUPUESTO', 'PEDIDO POR', 'REVISION', 'ESTADO', 'ACCIONES'),
    $propuestas,
    'post'
);

?>


<div class="card">
    <div class="card-body">
        <?php echo $generateTable; ?>
    </div>
</div>