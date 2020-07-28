<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;


if (isset($_POST['action']) && $_POST['action'] == 'nuevoesquema_form' && wp_verify_nonce($_REQUEST['seguridad-form'], 'seguridad')) {

    global $theuser;

    $errores = array();

    $usuario = $theuser->ID;

    $razonsocial = (isset($_POST['razonsocial']) && $_POST['razonsocial'] != '') ? sanitize_text_field($_POST['razonsocial']) : $errores[] = "Ingresa una razon social";

    $esquema = (isset($_POST['esquema']) && $_POST['esquema'] != '') ? sanitize_text_field($_POST['esquema']) : $errores[] = "Ingresa un esquema";

    $direccion = (isset($_POST['direccion']) && $_POST['direccion'] != '') ? sanitize_text_field($_POST['direccion']) : $errores[] = "Ingresa una direccion";

    $cuit = (isset($_POST['cuit']) && $_POST['cuit'] != '') ? sanitize_text_field($_POST['cuit']) : $errores[] = "Ingresa una direccion";

    $bio = (isset($_POST['bio']) && $_POST['bio'] != '') ? sanitize_text_field($_POST['bio']) : $errores[] = "Ingresa una biografía";

    $email = (isset($_POST['email']) && $_POST['email'] != '') ? sanitize_email($_POST['email']) : $errores[] = "Ingresa un email válido";

    $tel = (isset($_POST['tel']) && $_POST['tel'] != '') ? sanitize_text_field($_POST['tel']) : $errores[] = "Ingresa un teléfono";

    $street = $_POST['street'];
    $street = (isset($_POST['street']) && $_POST['street'] != '') ? sanitize_text_field($_POST['street']) : "";
    $streetNumber = (isset($_POST['streetNumber']) && $_POST['streetNumber'] != '') ? sanitize_text_field($_POST['streetNumber']) : "";

    $ciudad = $_POST['ciudad'];
    $provincia = $_POST['provincia'];

    $rubro = $_POST['rubro'];

    $args = array(
        'post_type'     => 'empresas',
        'post_author'   => $usuario,
        'post_title'    => $razonsocial,
        'post_content'  => $bio,
        'post_status'   => 'publish',
        'meta_input'    => array(
            'empresa_cuit' => $cuit,
            'empresa_tipo' => $esquema,
            'empresa_email' => $email,
            'empresa_tel' => $tel,
            'empresa_provincia' => $provincia,
            'empresa_validacion' => '',
            'empresa_ciudad' => $ciudad,
            'empresa_geo' => wp_json_encode(array($_POST['lat'], $_POST['lng'])),
            'empresa_direccion' => $street . " " . $streetNumber,
            'empresa_data' => wp_json_encode(array()),
        )
    );

    if (detectUniqueCuit($cuit)) {
        $create = wp_insert_post($args);

        add_action('init', 'process_submit_part');
        function process_submit_part()
        {
            global $create, $rubro;
            wp_set_object_terms($create, intval($rubro), 'rubro');
        }

        //Obtenga la data de la empresa asociada al usuario
        $data = json_decode(get_user_meta($usuario, 'user_empresa', true), true);

        $data[] = array('id' => $create, 'estado' => 'activo', 'cargo' => '', 'rol' => 'administrador');

        update_user_meta($usuario, 'user_empresa', wp_json_encode($data));


        if (isset($_FILES['picturefile'])) {
            if (any_uploaded('picturefile')) {
                require_once ABSPATH . 'wp-admin/includes/file.php';
                $urlsfiles = array();
                $filesup = rearrange_files($_FILES['picturefile']);

                foreach ($filesup as $filesingle) {

                    $status = wp_handle_upload($filesingle, array('test_form' => false));

                    if (empty($status['error'])) {
                        $uploads = wp_upload_dir();
                        $theurl = $uploads['url'] . '/' . basename($status['file']);

                        //get the path of the file for resizing
                        $newurl = $uploads['path'] . '/' . basename($status['file']);
                        $image = wp_get_image_editor($newurl);

                        //If the file is handled resize it
                        if (!is_wp_error($image)) {
                            $image->resize(400, 400, true);
                            $image->save($newurl);
                        }

                        //TODO: Maybe in avatar folders?

                        //deleted urlsfiles array here, just single url
                        update_post_meta($create, 'empresa_logo', $theurl);
                    }
                }
            }
        }
    } else {
        $message = array('type' => 'error', 'message' => 'Esta empresa ya existe en nuestro registro');
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'nuevoitem_form' && wp_verify_nonce($_REQUEST['seguridad-form'], 'seguridad')) {

    global $theuser;

    $errores = array();

    $usuario = $theuser->ID;

    $tipo = (isset($_POST['tipo']) && $_POST['tipo'] != '') ? sanitize_text_field($_POST['tipo']) : $errores[] = "Ingresa un tipo de item";

    $esquema = (isset($_POST['esquema']) && $_POST['esquema'] != '') ? sanitize_text_field($_POST['esquema']) : $errores[] = "Ingresa un esquema";

    $nombre = (isset($_POST['nombre']) && $_POST['nombre'] != '') ? sanitize_text_field($_POST['nombre']) : $errores[] = "Ingresa un nombre";

    $rubro = (isset($_POST['rubro']) && $_POST['rubro'] != '') ? $_POST['rubro'] : $errores[] = "Ingresa un rubro";

    /*
    Categoria
    */
    $categoria = (isset($_POST['categoria']) && $_POST['categoria'] != '') ? $_POST['categoria'] : $errores[] = "Ingresa una categoria";

    $cat = explode(',', $categoria);

    array_filter($cat);

    $descripcion = (isset($_POST['descripcion']) && $_POST['descripcion'] != '') ? sanitize_textarea_field($_POST['descripcion']) : $errores[] = "Ingresa una descripción";

    $args = array(
        'post_type'     => 'servicios',
        'post_author'   => $usuario,
        'post_title'    => $nombre,
        'post_content'  => $descripcion,
        'post_status'   => 'publish',
        'meta_input'    => array(
            'servicio_tipo' => $tipo,
            'servicio_esquema' => $esquema,
            'servicio_esquema_nombre' => get_the_title($esquema),
        )
    );

    if (empty($errores)) {
        $idpost = wp_insert_post($args);

        //No se porque pero anda solo con esta forma
        add_action('init', 'process_submit_part');
        function process_submit_part()
        {
            global $idpost, $rubro, $cat;
            wp_set_object_terms($idpost, intval($rubro), 'rubro');
            wp_set_object_terms($idpost, $cat, 'categoria');
        }


        $data = json_decode(get_post_meta($esquema, 'empresa_data', true));
        $data[] = array('id' => $idpost, 'tipo' => $tipo, 'titulo' => $nombre);
        update_post_meta($esquema, 'empresa_data', wp_json_encode($data));

        if ($idpost)
            wp_redirect(home_url('dashboard/empresas/items/'));
        else
            $message = array('type' => 'error', 'message' => 'Ocurrio un error al crear el servicio');
    } else {
        $message = array('type' => 'error', 'message' => 'Error: Completa todos los campos');
    }
}
