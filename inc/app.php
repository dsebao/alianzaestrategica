<?php

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



