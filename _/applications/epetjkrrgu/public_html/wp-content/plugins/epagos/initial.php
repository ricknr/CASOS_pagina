<?php
/*
  Plugin Name: Epagos
  Plugin URI: 
  Version: 1.0.0
  Description: Payment Module by Epagos
  Author: Esoluciones 
  Author URI:  http://esonline.mx
  Text Domain: plugin-epagos
  Domain Path: 
  License: MIT
 */
require_once 'includes/utils.php';
require_once 'includes/epagos.php';
require_once 'includes/controls.php';
require_once 'includes/epagos-gateway.php';

/**
 * Initialize example plugin
 */

global $timezone;
$timezone = 'America/Mexico_City';
if(!defined('VERSION'))
{
  define('VERSION',0.8);
}

 
function plugin_epagos_init($epagosObj) {
	global $options_epagos;
	// Make plugin available for translation, you can change /languages/ to your .mo-files folder name
	load_plugin_textdomain( 'plugin-epagos', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	// Initialize Sunrise
	$epagosObj = new EpagosModule( array(
			// Sunrise file path
			'file'	=> __FILE__,
			// Plugin slug (should be equal to plugin directory name)
			'slug' => 'plugin-epagos',
			// Plugin prefix
			'prefix' => 'plugin_epagos_',
			// Plugin textdomain
			'textdomain' => 'plugin-epagos',
			// Custom CSS assets folder
			'css' => 'assets/css',			
			// Custom JS assets folder
			'js'  => 'assets/js',
			// Custom JS assets folder
			'assets'  => 'assets',
			//Plugin version
			'version' => VERSION
		) );

	

	// Add top-level menu (like Dashboard -> Comments)
	$epagosObj->add_menu( array(
			// Settings page <title>
			'page_title' => __( 'E-pagos Plugin', 'plugin-epagos' ),
			// Menu title, will be shown in left dashboard menu
			'menu_title' => __( 'E-pagos', 'plugin-epagos' ),
			// Minimal user capability to access this page
			'capability' => 'manage_options',
			// Unique page slug
			'slug' => 'plugin-epagos',
			// Add here your custom icon url, or use [dashicons](https://developer.wordpress.org/resource/dashicons/)
			// 'icon_url' => admin_url( 'images/wp-logo.png' ),
			'icon_url' => 'data:image/svg+xml;base64,' . base64_encode('<?xml version="1.0" encoding="utf-8"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" 	 width="20px" height="20px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve"><g><g id="XMLID_8_"><path id="XMLID_9_" fill="black" d="M8.739,14.737c-0.694,0-1.324-0.107-1.889-0.32c-0.566-0.213-1.052-0.523-1.459-0.93  c-0.407-0.407-0.722-0.905-0.945-1.494c-0.223-0.589-0.334-1.259-0.334-2.011c0-0.728,0.107-1.385,0.321-1.97  c0.214-0.585,0.518-1.081,0.912-1.488c0.394-0.407,0.861-0.719,1.401-0.936c0.54-0.217,1.139-0.325,1.799-0.325  c0.677,0,1.289,0.109,1.838,0.325c0.548,0.217,1.015,0.529,1.401,0.936c0.386,0.407,0.681,0.903,0.887,1.488  c0.206,0.585,0.308,1.246,0.308,1.982v0.209H5.141c0.051,0.612,0.175,1.143,0.373,1.592c0.197,0.45,0.454,0.824,0.771,1.122  c0.317,0.298,0.683,0.521,1.099,0.668c0.415,0.147,0.867,0.221,1.356,0.221c0.343,0,0.685-0.037,1.028-0.11  c0.342-0.074,0.653-0.184,0.932-0.331c0.278-0.147,0.512-0.329,0.7-0.546c0.188-0.217,0.3-0.465,0.334-0.744h1.015  c-0.094,0.426-0.262,0.804-0.501,1.133c-0.24,0.33-0.536,0.608-0.887,0.837c-0.351,0.229-0.75,0.401-1.195,0.517  C9.72,14.679,9.245,14.737,8.739,14.737z M11.939,9.273c-0.171-1.031-0.559-1.802-1.163-2.313  c-0.604-0.511-1.347-0.767-2.23-0.767c-0.437,0-0.844,0.062-1.221,0.186c-0.377,0.124-0.713,0.314-1.009,0.57  C6.021,7.204,5.773,7.526,5.572,7.913C5.37,8.301,5.227,8.754,5.141,9.273H11.939z"/></g><g id="XMLID_2_"><path id="XMLID_3_" fill="black" d="M16.014,10.449V9.551h3.926v0.897H16.014z"/></g><g><path fill="black" d="M8.765,17.831c-4.325,0-7.831-3.506-7.831-7.831c0-4.325,3.506-7.831,7.831-7.831  c3.233,0,6.008,1.96,7.203,4.756h1.006c-1.246-3.323-4.45-5.69-8.209-5.69C3.924,1.235,0,5.159,0,10s3.924,8.765,8.765,8.765  c3.729,0,6.912-2.33,8.179-5.613h-1.01C14.721,15.907,11.968,17.831,8.765,17.831z"/></g></g></svg>'),
			// Menu position from 80 to <infinity>, you can use decimals
			'position' => '91.1',
			// Array with options available on this page
			'options' => $options_epagos,
		) );
	
}

// Hook to plugins_loaded
add_action( 'plugins_loaded', 'plugin_epagos_init' );
add_action( 'init', 'epagos_processing', 10, 3 );

// poner en una pagina o entrada de blog [epagos-form-handler style="horizontal"] para que se muestre el formulario
//si se quieren mas estilos de formularios, copiar uno de los archivos en front_end que empiezen con epagos_form y renombrarlo con el parametro que se necesite
add_shortcode("epagos-form-handler", "epagos_form_handler");

function epagos_form_handler($args){
	$prefix = 'plugin_epagos_';
	$enabled = get_option( $prefix . 'epagos_enabled') === "on" ? true : false;
	$business_id = get_option( $prefix . 'epagos_business_id');
	$payment_id = get_option( $prefix . 'epagos_payment_id');
	$subscription = get_option( $prefix . 'epagos_subscription') === "on" ? true : false;
	$enable_customer_fields = get_option( $prefix . 'epagos_customer_fields') === "on" ? true : false;
	$is_ssl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on');
	$current_uri = ($is_ssl ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$plugin_dir_url = plugin_dir_url(__FILE__);
	$content = '';
	$epagos_template = 'front-end/epagos_form_' . $args['style'] . '.php';
	if($enabled && isset($args['style']) && file_exists(plugin_dir_path(__FILE__) . $epagos_template)){
		require($epagos_template);
	}
	else{
		require('front-end/epagos_form_disabled.php');
	}
	
	return $content;
}

//front-end process		
function epagos_processing(){
	$paymentClass = new Gateway_Epagos(
						array('version'=>VERSION)
					); 
}

function epagos_install() {
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
}

register_activation_hook( __FILE__, 'epagos_install' );

// plugin deactivation
register_deactivation_hook( __FILE__, 'epagos_deactivate' );
function epagos_deactivate() {}

// plugin uninstallation
register_uninstall_hook( __FILE__, 'epagos_uninstall' );

function epagos_uninstall() {
	global $options_epagos;
	foreach ( $options_epagos as $option ) {
		// Option must have an ID
		if ( !isset( $option['id'] ) ) continue;
		// Prepare value		
		delete_option( 'plugin_epagos_' . $option['id'] );
	}
}

