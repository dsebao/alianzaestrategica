<?php

global $theuser;

?>
<form class="user needs-validation simpleform" method="post" novalidate enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="razonsocial">Razón social</label>
                <input type="text" class="form-control" name="razonsocial" value="" required>
                <div class="invalid-feedback">Ingresá tu nombre</div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="esquema">Tipo de esquema</label>
                        <select name="esquema" id="" class="form-control customselect" required>
                            <option value="">Selecciona el tipo</option>
                            <?php echo getOptionsCustom($GLOBALS['tiposesquema']); ?>
                        </select>
                        <div class="invalid-feedback">Ingresá el tipo</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cuit">CUIT</label>
                        <input type="number" class="form-control" name="cuit" value="" required>
                        <div class="invalid-feedback">Ingresá un cuit válido</div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="hidden" class='lat' name="lat" value="">
                <input type="hidden" class='lng' name="lng" value="">
                <input type="hidden" name="street" value="" required>
                <input type="hidden" name="ciudad" value="" required>
                <input type="hidden" name="provincia" value="" required>
                <input type="hidden" name="streetNumber" value="">
                <input type="text" id="form-direccion" class="form-control js-places-autocomplete" name="direccion" value="" required>
                <div class="invalid-feedback">Ingresá una dirección</div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email central</label>
                        <input type="email" class="form-control" name="email" value="" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tel">Teléfono</label>
                        <input type="number" class="form-control" name="tel" value="" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="categoria">Rubro</label>
                <select name="rubro" id="rubro" class="form-control customselect">
                    <?php getOptionsCategory('rubro'); ?>
                </select>
            </div>

            <div class="form-group">
                <label for="bio">Breve descripción</label>
                <textarea name="bio" row="3" class="form-control" required></textarea>
            </div>

        </div>

        <div class="col-md-4">
            <div class="avatarthumb text-center">

            </div>
            <label for="picturefile">LOGO EMPRESA</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="picturefile" name="picturefile[]" lang="es">
                <label class="custom-file-label" for="picturefile">Seleccionar Archivo</label>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <input type="hidden" name="action" value="nuevoesquema_form">
        <?php wp_nonce_field('seguridad', 'seguridad-form'); ?>
        <button class="btn btn-primary">Guardar información</button>
    </div>
</form>