<?php

/**
 * Template name: Presupuestos Nuevo
 */


// Detect if user are not logued
protectedPage();


get_header();

?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-900">Nuevo presupuesto</h1>

    <?php

    //Obtengo las adhesiones de empresas del usuarios
    $userClass = UserData::inst();
    ?>

    <div class="card">
        <div class="card-body">
            <form action="" method="post" id="js-form-presupuestos">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="titulo">TITULO</label>
                            <input type="text" name="titulo" class="form-control" placeholder="Ingresa el titulo del prespuesto" required>
                            <div class="invalid-feedback">Ingresá el titulo</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tipo">TIPO DE SOLICITUD</label>
                            <select name="tipo" class="form-control">
                                <option value="servicio">Servicio</option>
                                <option value="producto">Producto</option>
                            </select>
                            <div class="invalid-feedback">Ingresá el titulo</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha">FECHA LIMITE</label>
                            <input type="date" name="fecha" class="form-control" placeholder="Ingresa la fecha" required value="">
                            <div class="invalid-feedback">Ingresá el titulo</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="esquema">Esquema</label>
                            <select name="esquema" id="esquema" class="form-control" required>
                                <?php
                                echo $userClass->empresasSelect();
                                ?>
                            </select>
                            <div class="invalid-feedback">Ingresá el tipo</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rubro">Rubro</label>
                            <select name="rubro" id="rubro" class="customselect form-control" required>
                                <?php getOptionsCategory('rubro'); ?>
                            </select>
                            <div class="invalid-feedback">Ingresá el rubro</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select name="estado" class="form-control" required>
                                <option value="publish" selected>Publicado</option>
                                <option value="draft">Borrador</option>
                            </select>
                            <div class="invalid-feedback">Ingresá el rubro</div>
                        </div>
                    </div>
                </div>



                <hr>

                <div class="form-presupuestos--productos my-4">
                    <h6 class="mb-3">LISTADO DE ITEMS</h6>
                    <div id="js-wrap-items">

                    </div>
                    <a href="" class="btn btn-success" data-action="js-clone" data-whereclone="#js-wrap-items" data-idclone="#model-to-copy">+ Agregar item</a>

                    <div id="model-to-copy" class="d-none">
                        <div class="item-single p-md-3 p-0 bg-light mb-3 border">
                            <div class="row">
                                <div class="col-md-8"><input type="text" name="items[nombre][]" class="form-control js-productos-items" placeholder="Productos o servicios solicitados"></div>
                                <div class="col-md-3"><input type="text" name="items[cantidad][]" class="form-control js-productos-items" placeholder="Cantidad"></div>
                                <div class="col-md-1"><a href="" class="btn btn-dark" data-action="js-remove-clone" data-elementremove=".item-single">-</a></div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label for="comentarios">COMENTARIOS ADICIONALES</label>
                    <textarea name="comentarios" id="" rows="3" class="form-control" placeholder="Ingresa algun comentario adicional para ayudar en la elaboración del prespuesto"></textarea>
                </div>

                <p>
                    <input type="hidden" name="action" value="nuevopresupuesto_form">
                    <?php wp_nonce_field('seguridad', 'seguridad-form'); ?>
                    <button class="btn btn-primary">Enviar presupuesto</button>
                </p>

            </form>
        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php

get_footer(); ?>