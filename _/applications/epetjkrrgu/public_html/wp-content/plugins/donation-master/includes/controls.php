<?php

// Prepare array with options
	global $options;
	$options = array(
		// Open tab: Subscription
		array(
			'type' => 'opentab',
			'id'=>'subscription',
			'name' => __( 'Subscription', 'plugin-donation' ),
		),
		// Open tab: One time
		array(
			'type' => 'opentab',
			'id'=>'onetime',
			'name' => __( 'One Time', 'plugin-donation' ),
		),	

		// Open tab: Settings 
		array(
			'type' => 'opentab',
			'id'=>'settings',
			'name' => __( 'Settings', 'plugin-donation' ),
		),

		// Checkbox
		array(
			'id'      => 'openpay_enabled',
			'type'    => 'checkbox',
			'default' => 'on',
			'name'    => __( 'Enable / Disable', 'plugin-donation' ),
			'desc'    => __( 'Enable Openpay', 'plugin-donation' ),
			'label'   => __( 'Enable / Disable', 'plugin-donation' ),
		),

		// Checkbox
		array(
			'id'      => 'openpay_testmode',
			'type'    => 'checkbox',
			'default' => 'on',
			'name'    => __( 'Sandbox mode', 'plugin-donation' ),
			'desc'    => __( 'Enable test mode', 'plugin-donation' ),
			'label'   => __( 'Sandbox mode', 'plugin-donation' ),
		),

		// Text field
		array(
			'id'      => 'openpay_merchant_id',
			'type'    => 'text',
			'default' => '',
			'name'    => __( 'Production Merchant ID', 'plugin-donation' ),
			'desc'    => __( 'Get your API keys from your openpay account.', 'plugin-donation' ),
			'placeholder'=>__('Production Merchant ID','plugin-donation'),
		),

		// Text field
		array(
			'id'      => 'openpay_secret_key',
			'type'    => 'text',
			'default' => '',
			'name'    => __( 'Production Secret Key', 'plugin-donation' ),
			'desc'    => __( 'Get your API keys from your openpay account.', 'plugin-donation' ),
			'placeholder'=>__('Production Secret Key','plugin-donation'),
		),

		// Text field
		array(
			'id'      => 'openpay_publishable_key',
			'type'    => 'text',
			'default' => '',
			'name'    => __( 'Production Public Key', 'plugin-donation' ),
			'desc'    => __( 'Get your API keys from your openpay account.', 'plugin-donation' ),
			'placeholder'=>__('Production Public Key','plugin-donation'),
		),

		// Text field
		array(
			'id'      => 'openpay_test_merchant_id',
			'type'    => 'text',
			'default' => '',
			'name'    => __( 'Sandbox Merchant ID', 'plugin-donation' ),
			'desc'    => __( 'Get your API keys from your openpay account.', 'plugin-donation' ),
			'placeholder'=>__('Sandbox Merchant ID','plugin-donation'),
		),

		// Text field
		array(
			'id'      => 'openpay_test_secret_key',
			'type'    => 'text',
			'default' => '',
			'name'    => __( 'Sandbox Secret Key', 'plugin-donation' ),
			'desc'    => __( 'Get your API keys from your openpay account.', 'plugin-donation' ),
			'placeholder'=>__('Sandbox Secret Key','plugin-donation'),
		),

		// Text field
		array(
			'id'      => 'openpay_test_publishable_key',
			'type'    => 'text',
			'default' => '',
			'name'    => __( 'Sandbox Public Key', 'plugin-donation' ),
			'desc'    => __( 'Get your API keys from your openpay account.', 'plugin-donation' ),
			'placeholder'=>__('Sandbox Public Key','plugin-donation'),
		),

		// Text field
		array(
			'id'      => 'openpay_plan_100',
			'type'    => 'text',
			'default' => '',
			'name'    => __( 'Openpay Subscription Plan 100 MXN', 'plugin-donation' ),
			'desc'    => __( 'Get your plan id from your openpay account.', 'plugin-donation' ),
			'placeholder'=>__('Openpay Subscription Plan 1','plugin-donation'),
		),

		// Text field
		array(
			'id'      => 'openpay_plan_300',
			'type'    => 'text',
			'default' => '',
			'name'    => __( 'Openpay Subscription Plan 300 MXN', 'plugin-donation' ),
			'desc'    => __( 'Get your plan id from your openpay account.', 'plugin-donation' ),
			'placeholder'=>__('Openpay Subscription Plan 2','plugin-donation'),
		),

		// Text field
		array(
			'id'      => 'openpay_plan_500',
			'type'    => 'text',
			'default' => '',
			'name'    => __( 'Openpay Subscription Plan 500 MXN', 'plugin-donation' ),
			'desc'    => __( 'Get your plan id from your openpay account.', 'plugin-donation' ),
			'placeholder'=>__('Openpay Subscription Plan 3','plugin-donation'),
		),

		// Text field
		array(
			'id'      => 'openpay_3d_secure_redirect_url',
			'type'    => 'text',
			'default' => '',
			'name'    => __( 'Openpay 3d Secure Rediect URL', 'plugin-donation' ),
			'desc'    => __( 'Set 3d Secure Rediect URL.', 'plugin-donation' ),
			'placeholder'=>__('3d Secure Rediect URL','plugin-donation'),
		),

		// Text field
		array(
			'id'      => 'openpay_payment_limit',
			'type'    => 'text',
			'default' => '',
			'name'    => __( 'Openpay Payment Limit', 'plugin-donation' ),
			'desc'    => __( 'Set Openpay Payment Limit.', 'plugin-donation' ),
			'placeholder'=>__('Openpay Payment Limit','plugin-donation'),
		),



		// Open tab: Regular fields
		// array(
		// 	'type' => 'opentab',
		// 	'id'=>'onetime',
		// 	'name' => __( 'Onetime', 'plugin-donation' ),
		// ),
		// array(
		// 	'type' => 'opentab',
		// 	'id'=>'subscription',
		// 	'name' => __( 'Subscription', 'plugin-donation' ),
		// ),
		

		// Close tab: Regular fields
		// array(
		// 	'type' => 'closetab',
		// ),

		// Open tab: Extra fields
		// array(
		// 	'type' => 'opentab',
		// 	'name' => __( 'Subscription', 'plugin-donation' ),
		// ),

		// Media (text field with Media library button)
		// array(
		// 	'id'      => 'media_field_id',
		// 	'type'    => 'media',
		// 	'default' => '',
		// 	'name'    => __( 'Media', 'plugin-donation' ),
		// 	'desc'    => __( 'Media field description', 'plugin-donation' ),
		// ),

		// Color picker
		// array(
		// 	'id'      => 'color_field_id',
		// 	'type'    => 'color',
		// 	'default' => '#0099ff',
		// 	'name'    => __( 'Color', 'plugin-donation' ),
		// 	'desc'    => __( 'Color field description', 'plugin-donation' ),
		// ),

		// Size picker
		// array(
		// 	'id'      => 'size_field_id',
		// 	'type'    => 'size',
		// 	'default' => array( 0 => '20', 1 => 'px' ),
		// 	'name'    => __( 'Size', 'plugin-donation' ),
		// 	'desc'    => __( 'Size field description', 'plugin-donation' ),
		// 	'units'   => array( 'px', 'em', '%' ),
		// 	'min'     => 0,
		// 	'max'     => 200,
		// 	'step'    => 10,
		// ),

		// Checkbox group
	// 	array(
	// 		'id'      => 'checkbox_group_id',
	// 		'type'    => 'checkbox_group',
	// 		'default' => array(
	// 			'checkbox-1' => 'on',
	// 			'checkbox-2' => 'on',
	// 		),
	// 		'name'    => __( 'Checkbox group', 'plugin-donation' ),
	// 		'desc'    => __( 'Checkbox group description', 'plugin-donation' ),
	// 		'options' => array(
	// 			array(
	// 				'id'    => 'checkbox-1',
	// 				'label' => __( 'Checkbox 1', 'plugin-donation' ),
	// 			),
	// 			array(
	// 				'id'    => 'checkbox-2',
	// 				'label' => __( 'Checkbox 2', 'plugin-donation' ),
	// 			),
	// 			array(
	// 				'id'    => 'checkbox-3',
	// 				'label' => __( 'Checkbox 3', 'plugin-donation' ),
	// 			)
	// 		),
	// 		'multiple' => true,
	// 		'size' => 4,
	// 	),

	// 	// Custom HTML content
	// 	array(
	// 		'type'    => 'html',
	// 		'content' => '<h3>HTML field type</h3><p>Paragraph tag</p>',
	// 	),

	// 	// Custom title
	// 	array(
	// 		'type' => 'title',
	// 		'name' => __( 'Title field', 'plugin-donation' ),
	// 	),

	// 	// Image radio
	// 	array(
	// 		'id'      => 'image_radio_id',
	// 		'type'    => 'image_radio',
	// 		'default' => 'option-1',
	// 		'name'    => __( 'Image radio', 'plugin-donation' ),
	// 		'desc'    => __( 'Image radio description', 'plugin-donation' ),
	// 		'options' => array(
	// 			array(
	// 				'value' => 'option-1',
	// 				'label' => __( 'Option 1', 'plugin-donation' ),
	// 				'image' => '',
	// 			),
	// 			array(
	// 				'value' => 'option-2',
	// 				'label' => __( 'Option 2', 'plugin-donation' ),
	// 				'image' => '',
	// 			),
	// 			array(
	// 				'value' => 'option-3',
	// 				'label' => __( 'Option 3', 'plugin-donation' ),
	// 				'image' => '',
	// 			),
	// 		),
	// 	),

	//Close tab: Extra fields
	array(
	 		'type' => 'closetab',
	 	)
	 );