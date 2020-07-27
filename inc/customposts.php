<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;


// Register Custom Post Type
function custom_post_type()
{
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
		'taxonomies'            => array('rubro'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_icon'             => 'dashicons-tide',
		'supports'              => array('title', 'editor', 'page-attributes'),
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
	register_post_type('empresas', $args);

	$labels = array(
		'name'                  => 'Servicios',
		'singular_name'         => 'Servicio',
		'menu_name'             => 'Servicios',
		'name_admin_bar'        => 'Servicios',
	);
	$args = array(
		'label'                 => 'Servicios',
		'description'           => 'Servicios creadas',
		'labels'                => $labels,
		'taxonomies'            => array('rubro'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_icon'             => 'dashicons-rest-api',
		'supports'              => array('title', 'editor', 'page-attributes'),
		'menu_position'         => 6,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'rewrite' => array(
			'slug' => 'servicios',
			'with_front' => false
		),
		'has_archive' => 'servicios',
	);
	register_post_type('servicios', $args);

	$labels = array(
		'name'                  => 'Presupuestos',
		'singular_name'         => 'Presupuesto',
		'menu_name'             => 'Presupuestos',
		'name_admin_bar'        => 'Presupuestos',
	);
	$args = array(
		'label'                 => 'Presupuestos',
		'description'           => 'Presupuestos creados',
		'labels'                => $labels,
		'taxonomies'            => array('rubro', 'categorias'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_icon'             => 'dashicons-excerpt-view',
		'supports'              => array('title', 'editor', 'page-attributes'),
		'menu_position'         => 6,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
		'rewrite' => array(
			'slug' => 'presupuestos',
			'with_front' => false
		),
		'has_archive' => 'presupuestos',
	);
	register_post_type('presupuestos', $args);
}
add_action('init', 'custom_post_type', 0);


function register_taxonomy_rubro()
{
	$labels = [
		'name'              => 'Rubros',
		'singular_name'     => 'Rubro',
		'search_items'      => 'Buscar',
		'all_items'         => 'Todos los items',
		'parent_item'       => 'Item Padre',
		'parent_item_colon' => 'Item Padre',
		'edit_item'         => 'Editar',
		'update_item'       => 'Actualizar',
		'add_new_item'      => 'Agregar nuevo',
		'new_item_name'     => 'Nombre item nuevo',
		'menu_name'         => 'Rubros',
	];
	$args = [
		'hierarchical'      => true, // make it hierarchical (like categories)
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => ['slug' => 'rubro'],
	];
	register_taxonomy('rubro', ['servicios', 'empresas', 'presupuestos'], $args);
}
add_action('init', 'register_taxonomy_rubro');

function register_taxonomy_categoria()
{
	$labels = [
		'name'              => 'Categoria',
		'singular_name'     => 'Categoria',
		'search_items'      => 'Buscar',
		'all_items'         => 'Todos los items',
		'parent_item'       => 'Item Padre',
		'parent_item_colon' => 'Item Padre',
		'edit_item'         => 'Editar',
		'update_item'       => 'Actualizar',
		'add_new_item'      => 'Agregar nuevo',
		'new_item_name'     => 'Nombre item nuevo',
		'menu_name'         => 'Categorias',
	];
	$args = [
		'hierarchical'      => false, // make it hierarchical (like categories)
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => ['slug' => 'categoria'],
	];
	register_taxonomy('categoria', ['servicios', 'empresas', 'presupuestos'], $args);
}
add_action('init', 'register_taxonomy_categoria');
