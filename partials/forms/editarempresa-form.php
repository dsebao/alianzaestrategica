<?php

global $empresaClass;

$emp = $empresaClass->info();

$geo = geoCode($empresaClass->printdata('empresa_geo'));

?>
<form class="user needs-validation simpleform" method="post" novalidate enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="razonsocial">Razón social</label>
                <input type="text" class="form-control" name="razonsocial" value="<?php echo $emp->post_title; ?>" required>
                <div class=" invalid-feedback">Ingresá tu nombre</div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="esquema">Tipo de esquema</label>
                        <select name="esquema" id="" class="form-control customselect" required>
                            <option value="">Selecciona el tipo</option>
                            <?php echo getOptionsCustom($GLOBALS['tiposesquema'], $empresaClass->printdata('empresa_tipo')); ?>
                        </select>
                        <div class="invalid-feedback">Ingresá el tipo</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cuit">CUIT</label>
                        <input type="number" class="form-control" name="cuit" value="<?php echo $empresaClass->printdata('empresa_cuit'); ?>" required>
                        <div class="invalid-feedback">Ingresá un cuit válido</div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="hidden" class='lat' name="lat" value="<?php echo $geo['geo']['lat']; ?>">
                <input type="hidden" class='lng' name="lng" value="<?php echo $geo['geo']['lng']; ?>">
                <input type="hidden" name="street" value="<?php echo $geo['complete']->address_components[1]->long_name; ?>" required>
                <input type="hidden" name="ciudad" value="<?php echo $geo['complete']->address_components[2]->long_name; ?>" required>
                <input type="hidden" name="provincia" value="<?php echo $geo['complete']->address_components[4]->long_name; ?>" required>
                <input type="hidden" name="streetNumber" value="<?php echo $geo['complete']->address_components[0]->long_name; ?>">
                <input type="text" id="form-direccion" class="form-control js-places-autocomplete" name="direccion" value="<?php echo $geo['complete']->formatted_address; ?>" required>
                <div class="invalid-feedback">Ingresá una dirección</div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email central</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $empresaClass->printdata('empresa_email'); ?>" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tel">Teléfono</label>
                        <input type="number" class="form-control" name="tel" value="<?php echo $empresaClass->printdata('empresa_tel'); ?>" required>
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
                <textarea name="bio" row="3" class="form-control" required><?php echo $emp->post_content; ?></textarea>
            </div>

            <div class="avatar-wrap">
                <div class="row">
                    <div class="col-md-2 col-4">
                        <div class="avatarthumb text-center">
                            <?php
                            if ($empresaClass->printdata('empresa_logo') != '')
                                echo "<img width='' src='" . $empresaClass->printdata('empresa_logo') . "' class='w-100 border'>";
                            ?>
                        </div>
                    </div>
                    <div class="col-md-10 col-8">
                        <label for="picturefile">LOGO EMPRESA</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="picturefile" name="picturefile[]" lang="es">
                            <label class="custom-file-label" for="picturefile">Seleccionar Archivo</label>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="mt-4">
        <input type="hidden" name="action" value="editarsquema_form">
        <?php wp_nonce_field('seguridad', 'seguridad-form'); ?>
        <button class="btn btn-primary">Guardar información</button>
    </div>
</form>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBpndlYb94xRz0qbu1gx2CUkMwqrHn1CCs&libraries=places" async defer></script>
<script src="<?php echo urlt(); ?>/node_modules/google-address-autocomplete/dist/google-address-autocomplete.min.js"></script>