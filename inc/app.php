<?php

if (defined('WP_DEBUG_LOG') && WP_DEBUG_LOG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set( 'error_log', get_template_directory_uri() . '/log.txt' );
}

if(is_user_logged_in()){
    global $theuser;
    $theuser = wp_get_current_user();
}