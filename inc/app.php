<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

//Simple function to avoid accesing if user are not logued
function protectedPage(){
    if(!is_user_logged_in()){
        wp_redirect(home_url('/'));
    }
}

//Get the current user data
if(is_user_logged_in()){
    global $theuser;
    $theuser = wp_get_current_user();

    $data = get_user_meta($theuser->ID);

    //Userdata
    if($data['user_data'][0]){
        $GLOBALS['userdata'] = json_decode($data['user_data'][0],true);
    } else {
        $GLOBALS['userdata'] = array();
    }
}

if(isset($_GET['_emailvalidation']) && $_GET['_emailvalidation']!= '' && isset($_GET['user']) && $_GET['user'] != ''){
    $d = get_user_meta(intval($_GET['user']),'_data_user_key',true);
	if($d == $_GET['_emailvalidation']){
        $ver = update_user_meta(intval($_GET['user']),'_data_user_key','');
        wp_redirect(home_url('/ingresar'));
    }
}


if(isset($_GET['action']) && $_GET['action'] == 'resetpass' && isset($_GET['key']) && isset($_GET['useremail'])){
    $u = get_user_by('email',$_GET['useremail']);
    if($u){
        global $wpdb;
        $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->users WHERE user_activation_key = %s AND user_email = %s", $_GET['key'], $_GET['useremail']));
        if (!empty($user)){
            $userreset = $user;
        }
    }
}

add_filter('show_admin_bar', '__return_false');


/**
 * Avoid cache
 *
 */
function hook_nocache() {?>
	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
	<meta http-equiv="pragma" content="no-cache" />
<?php }

add_action('wp_head', 'hook_nocache');

/**
 * Main Class for User Actions
 */

class UserData{

    private $user;

    protected static $instance = null;

    function __construct($user){
        $this->user = $user;
    }

    public static function inst() {
        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
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
    public function empresas(){

        $posts = get_posts("post_type=empresas&author=$this->user");
        return $posts;

    }

    private function getallmeta(){

        $data = get_user_meta($this->user);
        return $data;

    }

    /**
     * Obtiene un los datos de un key almacenados en un user meta
     *
     * @param [string] $key El nombre del meta
     * @return mixed
     */
    public function getUserData($key){

        $d = $this->getallmeta();

        if(isset($d[$key][0])){
            $data = json_decode($d[$key][0],true);
            if(!empty($data)){
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
    public function getUserdataRow($key,$row){

        $data = json_decode(get_user_meta($this->user,$key,true),true);

        if(!empty($data)){
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
    public function updateUserData($key,$data){

        $update = update_user_meta($this->user, $key, wp_json_encode($data));

        if($update)
            return true;
        else
            return false;
    }

    /**
     * Detecta si hay proyectos creados por el usuario
     *
     * @return array
     */
    public function adhesion(){

        $data = $this->getUserData('user_empresa');
        
        if(!empty($data))
            return $data;
        else
            return false;
    }
}








