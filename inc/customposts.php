<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


// Register Custom Post Type
function custom_post_type() {
	$labels = array(
		'name'                  => 'Empresas',
		'singular_name'         => 'Empresa',
		'menu_name'             => 'Empresa',
		'name_admin_bar'        => 'Empresas',
	);
	$args = array(
		'label'                 => 'Empresas',
		'description'           => 'Empresas creadas',
		'labels'                => $labels,
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-tide',
		'supports'              => array('title','editor','page-attributes'),
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	    'rewrite' => array(
	      'slug' => 'empresas',
	      'with_front' => false
	    ),
	    'has_archive' => 'empresas',
	);
	register_post_type( 'empresas', $args );

}
add_action( 'init', 'custom_post_type', 0 );