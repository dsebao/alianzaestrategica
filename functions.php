<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

$theme_includes = array(
	//Main settings
	'/globalvar.php',
	'/utils.php',
	'/enqueue.php',
	'/shortcode.php',
	'/metaboxes.php',
	'/theme_settings.php',

	//Helpers
	'/wp_bootstrap_nav.php',
	'/pagination.php',
	'/hooks.php',

	//Metaboxes & Custom Posts
	'/customposts.php',
	'/metaboxes.php',
	'/app.php',
	'/classes/userClass.php',
	'/classes/empresaClass.php',
	'/post.php',
	'/ajax.php',
);

foreach ($theme_includes as $file) {

	require_once get_template_directory() . '/inc' . $file;
}
