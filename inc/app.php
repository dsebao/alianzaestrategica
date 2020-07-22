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

    $posttype = array();

    if ($get['tipo'] == 'empresas') {
        $posttype[] = 'empresas';
    } elseif ($get['tipo'] == 'servicios') {
        $posttype[] = 'servicios';
    }


    $args = array(
        's' => $get['search'],
        'post_type' => $posttype,
        'posts_per_page' => $pages,
        //'paged' => $paged
    );

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

/**
 * Main Class for User Actions
 */

class UserData
{

    private $user;

    protected static $instance = null;

    function __construct($user)
    {
        $this->user = $user;
    }

    public static function inst()
    {
        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            global $theuser;
            self::$instance = new self($theuser->ID);
        }
        return self::$instance;
    }

    /**
     * Detecta si hay proyectos creados por el usuario
     *
     * @param int $user
     * @return array
     */
    public function empresas()
    {

        $posts = get_posts("post_type=empresas&author=$this->user");
        return $posts;
    }


    /**
     * Crea un select con el istado de empresas del usuario
     *
     * @param int $user
     * @return array
     */
    public function empresasSelect()
    {

        $posts = get_posts("post_type=empresas&author=$this->user");
        $empresas = array();

        if (is_array($posts)) {
            $empresas = '';
            foreach ($posts as $p) {
                $empresas .= "<option value='{$p->ID}'>{$p->post_title}</option>";
            }
            return $empresas;
        } else {
            $empresas;
        }
    }

    private function getallmeta()
    {

        $data = get_user_meta($this->user);
        return $data;
    }

    /**
     * Obtiene un los datos de un key almacenados en un user meta
     *
     * @param [string] $key El nombre del meta
     * @return mixed
     */
    public function getUserData($key)
    {

        $d = $this->getallmeta();

        if (isset($d[$key][0])) {
            $data = json_decode($d[$key][0], true);
            if (!empty($data)) {
                return $data;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Obtiene un dato dentro de un meta key especifico
     *
     * @param [string] $key Meta Key
     * @param [string] $row Index del dato
     * @return mixed
     */
    public function getUserdataRow($key, $row)
    {

        $data = json_decode(get_user_meta($this->user, $key, true), true);

        if (!empty($data)) {
            return (isset($data[$row])) ? $data[$row] : NULL;
        } else {
            return "";
        }
    }

    /**
     * Actualiza data dentro de un user meta
     *
     * @param [string] $key Key del meta
     * @param [string] $data Index del dato a almacenar
     * @return bool
     */
    public function updateUserData($key, $data)
    {

        $update = update_user_meta($this->user, $key, wp_json_encode($data));

        if ($update)
            return $update;
        else
            return false;
    }

    /**
     * Detecta si hay proyectos creados por el usuario
     *
     * @return array
     */
    public function adhesion()
    {

        $data = $this->getUserData('user_empresa');

        if (!empty($data))
            return $data;
        else
            return false;
    }

    public function haveRol($rol)
    {

        $data = $this->adhesion();

        if ($data) {

            $i = array_search($rol, array_column($data, 'rol'));
            if ($i !== false) {
                return $data[$i];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function permisosEmpresa($empresa)
    {

        $data = $this->adhesion();

        $i = array_search($empresa, array_column($data, 'id'));
        if ($i !== false) {
            return $data[$i];
        } else {
            return false;
        }
    }
}

class Empresa
{

    private $id;

    function __construct($id)
    {
        $this->id = $id;
    }

    public function data()
    {
        $data = get_post_meta($this->id);
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function printdata($key)
    {
        $data = $this->data();
        if (isset($data[$key])) {
            return $data[$key][0];
        } else {
            return false;
        }
    }

    public function detectOperations()
    {
        $data = $this->printdata('empresa_data');

        if ($data) {
            $data = json_decode($this->printdata('empresa_data'), true);
            if (!empty($data)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function servicios()
    {
        $posts = get_posts("post_type=servicios&meta_key=servicio_esquema&meta_value=$this->id");
        return $posts;
    }

    public function serviciosCard()
    {

        $posts = get_posts("post_type=servicios&meta_key=servicio_esquema&meta_value=$this->id");

        $html = '';
        foreach ($posts as $service) {
            $meta = get_post_meta($service->ID);

            $terms = get_the_terms($service->ID, 'categoria');

            $cat = '';
            foreach ($terms as $t) {
                $cat .= "<span class='breadcrumb-item text-xs text-uppercase font-weight-normal text-gray-600'>$t->name</span>";
            }

            $html .= "<div class='card card-items mb-4'>";
            $html .= "<div class='card-header py-3 d-flex flex-row align-items-center justify-content-between' data-meta=''>
                <h6 class='m-0 font-weight-bold text-primary'>$service->post_title</h6>
                <div class='dropdown no-arrow'>
                    <a class='dropdown-toggle' href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fas fa-ellipsis-v fa-sm fa-fw text-gray-600'></i>
                    </a>
                    <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in' aria-labelledby='dropdownMenuLink' style=''>
                            <a class='dropdown-item' href='#'>Editar</a>
                            <a class='dropdown-item' data-action='js-delete-item' href='#' data-id='$service->ID' data-empresa='$this->id'>Eliminar</a>
                        </div>
                    </div>
                </div>";

            $html .= "<div class='card-body py-2'>";
            $html .= "<div class='card-metatag'>$cat</div>";
            $html .= "<p class='card-contenido my-2'>$service->post_content</p>";
            $html .= "<div class='card-metatag mb-2'><span class='badge badge-primary font-weight-normal text-white mr-2'>{$meta['servicio_esquema_nombre'][0]}</span><span class='badge badge-warning font-weight-normal text-dark'>{$meta['servicio_tipo'][0]}</span></div>";

            $html .= '</div></div>';
        }
        return $html;
    }

    public function serviciosList()
    {

        $posts = get_posts("post_type=servicios&meta_key=servicio_esquema&meta_value=$this->id");

        if (!empty($posts)) {

            $html = '';
            $html .= "<h6 class='text-primary text-uppercase small'>Servicios adjuntos</h6>";

            foreach ($posts as $servicio) {
                $meta = get_post_meta($servicio->ID);
                $html .= "<div class='alert alert-info mb-3'><h6 class='mb-0'>$servicio->post_title</h6><span class='badge badge-primary'>{$meta['servicio_tipo'][0]}</span></div>";
            }
            return $html;
        }
    }
}
