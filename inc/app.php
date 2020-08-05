<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

//Simple function to avoid accesing if user are not logued
function protectedPage()
{
    if (!is_user_logged_in()) {
        wp_redirect(home_url('/'));
    }
}

//Get the current user data
if (is_user_logged_in()) {
    global $theuser;
    $theuser = wp_get_current_user();

    $data = get_user_meta($theuser->ID);

    //Userdata
    if (isset($data['user_empresa'][0])) {
        $GLOBALS['userdata'] = json_decode($data['user_empresa'][0], true);
    } else {
        $GLOBALS['userdata'] = array();
    }
}

if (isset($_GET['_emailvalidation']) && $_GET['_emailvalidation'] != '' && isset($_GET['user']) && $_GET['user'] != '') {
    $d = get_user_meta(intval($_GET['user']), '_data_user_key', true);
    if ($d == $_GET['_emailvalidation']) {
        $ver = update_user_meta(intval($_GET['user']), '_data_user_key', '');
        wp_redirect(home_url('/ingresar'));
    }
}


if (isset($_GET['action']) && $_GET['action'] == 'resetpass' && isset($_GET['key']) && isset($_GET['useremail'])) {
    $u = get_user_by('email', $_GET['useremail']);
    if ($u) {
        global $wpdb;
        $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->users WHERE user_activation_key = %s AND user_email = %s", $_GET['key'], $_GET['useremail']));
        if (!empty($user)) {
            $userreset = $user;
        }
    }
}

add_filter('show_admin_bar', '__return_false');


/**
 * Avoid cache
 *
 */
function hook_nocache()
{ ?>
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
<?php }

add_action('wp_head', 'hook_nocache');



function getUsersEmpresas($ide)
{
    $args = array(
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key'     => 'user_empresa',
                'value'   => '"id":"' . $ide . '"',
                'compare' => 'LIKE'
            )
        )
    );
    $user_query = new WP_User_Query($args);

    return $user_query->results;
}

function getUserEmpresadata($user, $empresa)
{
    $data = get_user_meta($user);

    if (isset($data['user_empresa'][0])) {

        $empresadata = json_decode($data['user_empresa'][0], true);
        if ($empresadata) {
            $i = array_search($empresa, array_column($empresadata, 'id'));
            return $empresadata[$i];
        }
    }
}

function searchQuery($get, $pages = 30, $paged = 1)
{
    //Crear un query para empresas /servicios y productos

    $args = array();

    $args['s'] = $get['search'];
    if ($get['tipo'] == 'servicios') {
        $args['post_type'] = 'servicios';
        $args['meta_query']['relation'] = 'AND';
        $args['meta_query'][] = array(
            'key' => 'servicio_tipo',
            'value' => 'servicio',
            'compare' => '='
        );
    } elseif ($get['tipo'] == 'productos') {
        $args['post_type'] = 'servicios';

        $args['meta_query']['relation'] = 'AND';
        $args['meta_query'][] = array(
            'key' => 'servicio_tipo',
            'value' => 'producto',
            'compare' => '='
        );
    } else {
        $args['post_type'] = 'empresas';
    }

    $args['posts_per_page'] = $pages;

    $the_query = new WP_Query($args);
    return $the_query;
}

function taxTags($id, $tax)
{
    $terms = get_the_terms($id, $tax);
    $html = '<div class="timeline--smalltags">';
    if ($terms) :

        foreach ($terms as $t) {
            $html .= "<span class='timeline--smalltags--items'>$t->name</span>";
        }

    endif;
    $html .= '</div>';
    return $html;
}

function createTableData($th, $data, $type = 'post')
{
    $html = '<table class="table table-bordered dataTable" width="100%" cellspacing="0"><thead><tr>';
    if (is_array($th) && count($th) > 0) {
        foreach ($th as $t) {
            $html .= "<th>$t</th>";
        }
    }

    $html .= '</tr></thead><tbody>';

    if ($type == 'post') {
        foreach ($data as $d) {
            $html .= '<tr>';
            foreach ($d as $unit) {
                $html .= "<td>$unit</td>";
            }
            $html .= "</tr>";
        }
    } elseif ($type == 'array') {
        foreach ($data as $items) {
            $html .= '<tr>';
            foreach ($items as $item) :

                $html .= "<td>{$item}</td>";

            endforeach;
            $html .= "</tr>";
        }
    }

    $html .= '<tbody></tbody></table>';

    return $html;
}

//Function for budget actions
function createActionsButtonsPresupuestos($id, $link, $tipo)
{
    $html = '';
    if ($tipo == 'enviados') {
        $html = "<a href='" . get_bloginfo('url') . "/dashboard/propuestas/?presupuesto=$id' class='px-2'><i class='fa fa-file-alt text-gray-600'></i></a>";
        $html .= "<a href='" . get_bloginfo('url') . "/dashboard/presupuestos/enviados/editar/?presupuesto=$id' class='px-2'><i class='fa fa-edit text-gray-600'></i></a>";
        $html .= "<a href='' data-action='js-delete-presupuesto' data-id='$id' class='px-2'><i class='fa fa-trash text-gray-600'></i></a>";
    } elseif ($tipo == 'recibidos') {
        $html = "<a class='text-gray-600' href='" . get_bloginfo('url') . "/dashboard/propuestas/?presupuesto=$id' class='px-2'><i class='fas fa-file-import'></i> Enviar</a>";
    } elseif ($tipo == 'propuestas') {
        $html = "<a class='text-gray-600' href='" . get_bloginfo('url') . "/dashboard/propuestas/?presupuesto=$id' class='px-2'><i class='fas fa-eye'></i></a>";
        $html .= "<a href='' data-action='js-delete-presupuesto' data-id='$id' class='px-2'><i class='fa fa-trash text-gray-600'></i></a>";
    }
    return $html;
}
