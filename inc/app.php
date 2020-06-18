<?php


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




