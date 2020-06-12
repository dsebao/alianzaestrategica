<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$theme_includes = array(
	'/pagination.php',
	'/enqueue.php',
	'/utils.php',
	'/shortcode.php',
	'/metaboxes.php',
	'/theme_settings.php',
	'/wp_bootstrap_nav.php',
	'/ajax.php',
	'/hooks.php',
	'/app.php',
);

foreach ( $theme_includes as $file ) {

	require_once get_template_directory() . '/inc' . $file;
	
}
