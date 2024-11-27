<?php

// Prepare array with options
	global $options_epagos;
	$options_epagos = array(

		// Open tab: Settings 
		array(
			'type' => 'opentab',
			'id'=>'settings',
			'name' => __( 'Configuración', 'plugin-epagos' ),
		),

		// Checkbox
		array(
			'id'      => 'epagos_enabled',
			'type'    => 'checkbox',
			'default' => 'on',
			'name'    => __( 'Estatus', 'plugin-epagos' ),
			'desc'    => __( 'Activar motor de pagos de e-pagos', 'plugin-epagos' ),
			'label'   => __( 'Activo / Inactivo', 'plugin-epagos' ),
		),

		// Checkbox
		//~ array(
			//~ 'id'      => 'epagos_testmode',
			//~ 'type'    => 'checkbox',
			//~ 'default' => 'on',
			//~ 'name'    => __( 'Sandbox mode', 'plugin-epagos' ),
			//~ 'desc'    => __( 'Activo test mode', 'plugin-epagos' ),
			//~ 'label'   => __( 'Sandbox mode', 'plugin-epagos' ),
		//~ ),

		// Text field
		array(
			'id'      => 'epagos_business_id',
			'type'    => 'text',
			'default' => '',
			'name'    => __( 'Id de negocio', 'plugin-epagos' ),
			'desc'    => __( 'Id de negocio proporcionado por e-pagos.', 'plugin-epagos' ),
			'placeholder'=>__('Id de negocio','plugin-epagos'),
		),

		// Text field
		array(
			'id'      => 'epagos_payment_id',
			'type'    => 'text',
			'default' => '',
			'name'    => __( 'Id de motor de pago', 'plugin-epagos' ),
			'desc'    => __( 'Id de motor de pago proporcionado por e-pagos.', 'plugin-epagos' ),
			'placeholder'=>__('Id de motor de pago','plugin-epagos'),
		),

		// Text field
		array(
			'id'      => 'epagos_app_domain',
			'type'    => 'text',
			'default' => 'https://epagos.mx',
			'name'    => __( 'Url de e-pagos', 'plugin-epagos' ),
			'desc'    => __( 'Url de e-pagos a la cual se conectará el servicio.', 'plugin-epagos' ),
			'placeholder'=>__('Url de e-pagos','plugin-epagos'),
		),

		// Checkbox
		array(
			'id'      => 'epagos_subscription',
			'type'    => 'checkbox',
			'default' => '',
			'name'    => __( 'Suscripciones', 'plugin-epagos' ),
			'desc'    => __( 'Habilitar seleccionar el pagar a travez de una suscripción. Las suscripciones deben de darse de alta en e-pagos', 'plugin-epagos' ),
			'label'   => __( 'Activo / Inactivo', 'plugin-epagos' ),
		),

		// Checkbox
		array(
			'id'      => 'epagos_customer_fields',
			'type'    => 'checkbox',
			'default' => '',
			'name'    => __( 'Mostrar campos para prevencion de fraude', 'plugin-epagos' ),
			'desc'    => __( 'Habilitar campos adicionales de contacto de usuario para prevención de fraudes', 'plugin-epagos' ),
			'label'   => __( 'Activo / Inactivo', 'plugin-epagos' ),
		),

	//Close tab: Extra fields
	array(
	 		'type' => 'closetab',
	 	)
	 );
