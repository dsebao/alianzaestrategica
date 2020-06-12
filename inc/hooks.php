<?php


/**
 * Adding general nonce to all ajax requests
 */
function add_general_nonce() {
    $nonce = wp_create_nonce( 'securitynonce' );
    echo "<meta name='csrf-token' content='$nonce'>";
}
// To add to front-end pages
add_action( 'wp_head', 'add_general_nonce' );


/**
 * Verify the submitted nonce
 *
 * @return  void
 */
function verify_general_nonce() {
    $nonce = isset( $_SERVER['HTTP_X_CSRF_TOKEN'] )
        ? $_SERVER['HTTP_X_CSRF_TOKEN']
       : '';
    if ( !wp_verify_nonce( $nonce, 'my_general_nonce' ) ) {
        die();
    }
}



/**
 * Create a loading page in ajax calls
 */

function after_body() {
    echo '<div class="globalcover"><div class="globalcover-pad"></div><svg version="1.1" id="loader" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="60px" height="60px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve"> <path opacity="1" fill="#5320FF" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/> <path fill="#fff" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 C22.32,8.481,24.301,9.057,26.013,10.047z"> <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite"/></path> </svg> </div>';
}
add_action('after_body_open_tag', 'after_body');


/**
 * Hide WordPress update nag to all but admins
 */
 
function hide_update_notice_to_all_but_admin() {
    if ( !current_user_can( 'update_core' ) ) {
        remove_action( 'admin_notices', 'update_nag', 3 );
    }
}
add_action( 'admin_head', 'hide_update_notice_to_all_but_admin', 1 );
