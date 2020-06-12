<?php

/**
 * Enqueue Scripts and styles
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'theme_scripts' ) ) {
	/**
	 * Load theme's JavaScript and CSS sources.
	 */
	function theme_scripts() {
		
		wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/vendor/fontawesome-free/css/all.min.css');

		wp_enqueue_style( 'theme-styles', get_template_directory_uri() . '/css/sb-admin-2.min.css');

		//Add jQuery
		if (!is_admin()){

			wp_deregister_script('jquery');

			wp_register_script('jquery', get_template_directory_uri() . '/vendor/jquery/jquery.min.js',array(),false,true);

			wp_enqueue_script('jquery');

		}

		wp_enqueue_script( 'validator', get_template_directory_uri() . '/vendor/validation/jquery.validate.min.js',array('jquery'),false,true);

		wp_enqueue_script( 'bs', get_template_directory_uri() . '/vendor/bootstrap/js/bootstrap.bundle.min.js',array(),false,true);

		wp_enqueue_script( 'jquery-easing', get_template_directory_uri() . '/vendor/jquery-easing/jquery.easing.min.js',array(),false,true);

		//Register the main js, enqueue and localize for the ajax url variable
		wp_register_script( 'app', get_template_directory_uri() . '/js/app-admin.min.js',array(),false,true);

		wp_enqueue_script( 'app' );

		$paramsLogin = array(
			'ajaxurl' => admin_url('admin-ajax.php'),
		);

		wp_localize_script( 'app' ,'jsvar',$paramsLogin);
	
        //If comments are using
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
} // End of if function_exists( 'theme_scripts' ).

add_action( 'wp_enqueue_scripts', 'theme_scripts' );