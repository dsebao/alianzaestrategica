<?php 

global $theuser;

$usermeta = get_user_meta($theuser->ID);

?>
<form class="user needs-validation js-ajaxform-media" method="post" novalidate enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" name="nombre" value="<?php echo $theuser->first_name;?>" required>
                        <div class="invalid-feedback">Ingresá tu nombre</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" name="apellido" value="<?php echo $theuser->last_name;?>" required>
                        <div class="invalid-feedback">Ingresá tu apellido</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $theuser->user_email;?>" required>
                        <div class="invalid-feedback">Ingresá un email válido</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tel">Teléfono</label>
                        <input type="number" class="form-control" name="tel" value="<?php echo (isset($usermeta['user_tel'][0])) ? $usermeta['user_tel'][0] : "";?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cuit">CUIT</label>
                        <input type="number" class="form-control" name="cuit" value="<?php echo (isset($usermeta['user_cuit'][0])) ? $usermeta['user_cuit'][0] : "";?>" required>
                        <div class="invalid-feedback">Ingresá un cuit válido</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="perfil">Tipo de perfil</label>
                        <input type="number" class="form-control" name="tel" value="<?php echo (isset($usermeta['user_tel'][0])) ? $usermeta['user_tel'][0] : "";?>">
                    </div>
                </div>
            </div>

            <div class="my-4">
                <input type="hidden" name="action" value="userform">
                <input type="hidden" name="typeform" value="updateprofile_form">
                <button class="btn btn-primary">Guardar información</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="avatarthumb text-center mb-3">
                <img class="img-profile rounded-circle" width="120px" src="<?php echo get_the_avatar_url(get_avatar($theuser->ID, 96,'','',array('scheme' => 'https')));?>">
            </div>
            <label for="picturefile">IMAGEN DE PERFIL</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="picturefile" name="picturefile[]" lang="es">
                <label class="custom-file-label" for="picturefile">Seleccionar Archivo</label>
            </div>
        </div>
    </div>
</form>