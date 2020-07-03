<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Get the bootstrap!
 * (Update path to use cmb2 or CMB2, depending on the name of the folder.
 * Case-sensitive is important on some systems.)
 */

require_once __DIR__ . '/CMB2/init.php';

add_action( 'cmb2_admin_init', 'instancias_metaboxes' );
function instancias_metaboxes() {

    $prefix = 'empresa_';

    $cmb_demo = new_cmb2_box( array(
		'id'            => 'data',
		'title'         => 'Información de la empresa',
		'object_types'  => array( 'empresas' ),
    ) );
    
    $cmb_demo->add_field( array(
		'name'       => 'Tipo',
		'id'         => $prefix . 'tipo',
        'type'       => 'select',
        'show_option_none' => false,
		'options'          => array(
			'personal' => 'Personal',
            'emprendimiento'   => 'Emprendimiento',
            'empresa'   => 'Empresa',
		),
    ));

    $cmb_demo->add_field( array(
		'name'       => 'Empleados',
		'id'         => $prefix . 'empleados',
        'type'       => 'select',
        'show_option_none' => false,
		'options'          => array(
			'1-5' => 'Entre 1 y 5',
            '5-10'   => 'Entre 5 y 10',
            '10-50'   => 'Entre 10 y 50',
            '50-100'   => 'Entre 50 y 100',
            '+100'   => 'Más de 100',
		),
    ));

	$cmb_demo->add_field( array(
		'name'       => 'CUIT',
		'id'         => $prefix . 'cuit',
		'type'       => 'text',
    ));
    
    $cmb_demo->add_field( array(
		'name'       => 'Validacion',
		'id'         => $prefix . 'validacion',
		'type'       => 'checkbox',
    ));
    
    $cmb_demo->add_field( array(
		'name'       => 'Direccion',
		'id'         => $prefix . 'direccion',
		'type'       => 'text',
    ));
    
    $cmb_demo->add_field( array(
		'name'       => 'Ciudad',
		'id'         => $prefix . 'ciudad',
		'type'       => 'text',
    ));
    
    $cmb_demo->add_field( array(
		'name'       => 'Provincia',
		'id'         => $prefix . 'provincia',
		'type'       => 'text',
    ));
    
    $cmb_demo->add_field( array(
		'name'       => 'Condición IVA',
		'id'         => $prefix . 'iva',
		'type'       => 'text',
	));
}