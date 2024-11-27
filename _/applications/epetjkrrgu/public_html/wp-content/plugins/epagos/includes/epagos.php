<?php

if (!defined('ABSPATH')) {
    exit;
}

if ( !class_exists( 'EpagosModule' ) ) {

	require_once 'epagos_views.php';

	/**
	 * epagos
	 *
	 * @license MIT
	 */
	class EpagosModule {

		/** @var array Class config */
		var $config = array();

		/**
		 * Constructor
		 *
		 * @param array Class settings
		 */
		function __construct( $args = array() ) {
			// Parse config
			$args = wp_parse_args( $args, array(
					'file'        => '',
					'slug'        => '',
					'prefix'      => '',
					'textdomain'  => '',
					'url'         => '',
					'version'     => '',
					'options'     => array(),
					'menus'       => array(),
					'pages'       => array(),
					'slugs'       => array(),
					'css'         => 'assets/css',
					'js'          => 'assets/js',
					'views_class' => 'EpagosModule_Views',
					'assets'          => 'assets',
					'plugin_dir_path'=> plugin_dir_path( __DIR__) 
				) );
			// Check required settings
			if ( !$args['file'] ) wp_die( 'epagos: please specify plugin __FILE__' );
			if ( !$args['slug'] ) $args['slug'] = sanitize_key( plugin_basename( basename( $args['file'] , '.php' ) ) );
			if ( !$args['prefix'] ) $args['prefix'] = 'epagos_' . sanitize_key( $args['slug'] ) . '_';
			if ( !$args['textdomain'] ) $args['textdomain'] = sanitize_key( $args['slug'] );
			// Setup config
			$this->config = $args;

			// Register hooks
			if ( is_admin() ){ // admin actions
				add_action( 'admin_menu', array( &$this, 'register' ) );
				add_action( 'admin_init', array( &$this, 'assets' ), 10 );
				add_action( 'admin_init', array( &$this, 'enqueue' ), 20 );
				add_action( 'admin_init', array( &$this, 'defaults' ) );
				add_action( 'admin_init', array( &$this, 'submit' ) );
				add_action( 'admin_init', array( &$this, 'submit' ) );
				
			}
		}

		/**
		 * Helper to get config
		 *
		 * @param mixed   $option Option ID
		 * @return mixed Option value
		 */
		public function config( $option = false ) {
			if ( $option ) $data = ( isset( $this->config[$option] ) ) ? $this->config[$option] : false;
			else $data = $this->config;
			return $data;
		}

		/**
		 * Register options pages
		 */
		public function register() {

			if ( isset( $this->config['menus'] ) && count( $this->config['menus'] ) )
			{

				foreach ( $this->config['menus'] as $menu ) {
					add_menu_page( $menu['page_title'], $menu['menu_title'], $menu['capability'], $menu['slug'], array( &$this, 'render' ), $menu['icon_url'], $menu['position'] );
				}
			}
				
			if ( isset( $this->config['pages'] ) && count( $this->config['pages'] ) )
			{
				foreach ( $this->config['pages'] as $page ) {
					
					add_submenu_page( $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['slug'], array( &$this, 'render' ) );
				}
			}		
		}

		/**
		 * Add top-level menu
		 *
		 * @param array   $args Page config and options
		 */
		public function add_menu( $args ) {
			// Prepare default config
			$args = wp_parse_args( $args, array(
					'page_title'  => __( 'Plugin Settings', $this->config['textdomain'] ),
					'menu_title'  => __( 'Plugin Settings', $this->config['textdomain'] ),
					'capability'  => 'manage_options',
					'slug'        => $this->config['slug'],
					'icon_url'    => '',
					'position'    => '81.' . rand( 0, 99 ),
					'url'         => '',
					'options'     => array()
				) );
			// Define page url
			if ( !$args['url'] ) $args['url'] = admin_url( 'admin.php?page=' . $args['slug'] );
			// Save url to global config
			if ( !$this->config['url'] ) $this->config['url'] = $args['url'];
			// Save options to global config
			if ( is_array( $args['options'] ) && count( $args['options'] ) ) foreach ( $args['options'] as $option ) {
					$this->config['options'][] = $option;
				}
			// Save menu slug to the global config
			$this->config['slugs'][] = $args['slug'];
			// Add page to global config
			$this->config['menus'][$args['slug']] = $args;
		}

		/**
		 * Add sub-menu
		 *
		 * @param array   $args Page config and options
		 */
		public function add_submenu( $args ) {
			// Prepare default config
			$args = wp_parse_args( $args, array(
					'parent_slug' => 'options-general.php',
					'page_title'  => __( 'Plugin Settings', $this->config['textdomain'] ),
					'menu_title'  => __( 'Plugin Settings', $this->config['textdomain'] ),
					'capability'  => 'manage_options',
					'slug'        => $this->config['slug'],
					'url'         => '',
					'options'     => array()
				) );
			// Define page url
			if ( !$args['url'] ) {
				if ( strpos( $args['parent_slug'], '.php' ) !== false && strpos( $args['parent_slug'], '?' ) !== false ) $args['url'] = admin_url( $args['parent_slug'] . '&page=' . $args['slug'] );
				elseif ( strpos( $args['parent_slug'], '.php' ) !== false ) $args['url'] = admin_url( $args['parent_slug'] . '?page=' . $args['slug'] );
				else $args['url'] = ( isset( $this->config['menus'][$args['parent_slug']] ) ) ? admin_url( 'admin.php?page=' . $args['slug'] ) : '';
			}
			// Save url to global config
			if ( !$this->config['url'] ) $this->config['url'] = $args['url'];
			// Save options to global config
			if ( is_array( $args['options'] ) && count( $args['options'] ) && !in_array( $args['slug'], array_keys( (array) $this->config['menus'] ) ) ) foreach ( $args['options'] as $option ) {
					$this->config['options'][] = $option;
				}
			// Save page slug to the global config
			$this->config['slugs'][] = $args['slug'];
			// Add page to global config
			$this->config['pages'][$args['slug']] = $args;
		}

		/**
		 * Display options page
		 */

		public function render()
		{
			$page = sanitize_key( $_GET['page'] );

			if($page=='plugin-epagos')
			{
				$this->plugin_epagos_settings();
			}
		}

		public function plugin_epagos_settings()
		{
			// Prepare page options
			$options = $this->get_page_options();

			// Get current page slug
			$page = sanitize_key( $_GET['page'] );
			// Hook before page output
			do_action( 'donation/page/before' );
			do_action( 'donation/page/' . $page . '/before' );
			echo '<div id="donation-settings" class="wrap">';
			echo call_user_func( array( $this->config['views_class'], 'options_page_tabs' ), $options, $this->config );			
			echo call_user_func( array( $this->config['views_class'], 'options_page_notices' ), $options, $this->config );
			echo call_user_func( array( $this->config['views_class'], 'others_page_panes' ), $options, $this->config );			
			echo '<div id="settings" class="donation-pane"><form action="" method="post" id="donation-form">';
			echo '<input type="hidden" name="donation_action" value="save" />';
			echo '<input type="hidden" name="donation_nonce" value="' . wp_create_nonce( 'donation' ) . '" />';			
			echo call_user_func( array( $this->config['views_class'], 'options_page_panes' ), $options, $this->config );
			do_action( 'donation/page/form' );
			echo '</form></div>';
			
			echo '</div>';
			// Hook after page output
			do_action( 'donation/page/after' );
			do_action( 'donation/page/' . $page . '/after' );
		}

		/**
		 * Register class assets
		 */
		public function assets() {
			
			// Register styles
			wp_register_style(  'donation-' . $this->config['version'], plugins_url( $this->config['css'], $this->config['file'] ) . '/epagos-admin.css', false, $this->config['version'], 'all' );
			
			// Register scripts
			wp_register_script( 'donation-' . $this->config['version'], plugins_url( $this->config['js'],  $this->config['file'] ) . '/epagos-admin.js', array( 'jquery', 'jquery-form' ), $this->config['version'], true );
			
			// Add some l10n to JS
			wp_localize_script( 'donation-' . $this->config['version'], 'donation', array(
					'media_title'  => __( 'Choose file', $this->config['textdomain'] ),
					'media_insert' => __( 'Use selected file', $this->config['textdomain'] ),
					'ajax_url' => admin_url('admin-ajax.php')					
				) );
			
			// Hook to add/remove custom files
			do_action( 'donation/assets/register' );
		}

		/**
		 * Enqueue class assets
		 */
		public function enqueue() {
			// Check there is an options page
			if ( !$this->is_donation() ) return;
			// Enqueue styles
			foreach ( array( 'farbtastic', 'donation-' . $this->config['version'],'donation-tab' ) as $style ) wp_enqueue_style( $style );
			// Enqueue scripts
			foreach ( array( 'jquery', 'jquery-form', 'farbtastic', 'donation-' . $this->config['version'],'donation-tab','donation_datatable_params' ) as $script ) wp_enqueue_script( $script );
			// Hook to add/remove files

			do_action( 'donation/assets/enqueue' );
		}

		/**
		 * Hook to insert default settings
		 */
		public function defaults() {
			// Check defaults isn't set
			if ( get_option( 'donation_defaults_' . $this->config['slug'] ) ) return;
			// Check config options
			if ( isset( $this->config['options'] ) && is_array( $this->config['options'] ) ) {
				// Insert default options
				foreach ( $this->config['options'] as $option ) {
					// Option id and option defaut value is present
					if ( isset( $option['id'] ) && isset( $option['default'] ) ) update_option( $this->config['prefix'] . $option['id'], $option['default'] );
					// Default value isn't set bacause there is an multiple options array
					elseif ( isset( $option['id'] ) && isset( $option['options'] ) && is_array( $option['options'] ) ) {
						$options = array();
						foreach ( $option['options'] as $item ) {
							if ( isset( $item['id'] ) && isset( $item['default'] ) ) $options[$item['id']] = $item['default'];
						}
						update_option( $this->config['prefix'] . $option['id'], $options );
					}
				}
				// Defaults is set
				update_option( 'donation_defaults_' . $this->config['slug'], true );
			}
		}

		/**
		 * Hook to process submitted data
		 */
		public function submit() {
			// Check request
			if ( empty( $_REQUEST['donation_action'] ) || empty( $_REQUEST['page'] ) ) return;
			// Check nonce
			if ( empty( $_REQUEST['donation_nonce'] ) || !wp_verify_nonce( $_REQUEST['donation_nonce'], 'donation' ) ) return;
			// Check page
			if ( !$this->is_donation() ) return;
			// Prepare page slug
			$page = sanitize_key( $_GET['page'] );
			// Submit hooks
			do_action( 'donation/submit', $this );
			do_action( 'donation/submit/' . $page, $this );
			// Parse incoming data
			$action  = sanitize_key( $_REQUEST['donation_action'] );
			$request = ( isset( $_REQUEST['donation'] ) ) ? (array) $_REQUEST['donation'] : array();
			// Run actions
			// Save options
			if ( $action === 'save' ) {
				// Loop through current page options
				foreach ( (array) $this->get_page_options() as $option ) {
					// Option must have an ID
					if ( !isset( $option['id'] ) ) continue;
					// Prepare value
					$val = ( isset( $request[$option['id']] ) ) ? $request[$option['id']] : '';
					// Save options value
					echo '<br/>'. $option['id']; 
					update_option( $this->config['prefix'] . $option['id'], $val );
				}

				// Save hooks
				do_action( 'donation/save', $this );
				do_action( 'donation/save/' . $page, $this );
				// Set message
				$message = 1;
			}
			// Reset options
			elseif ( $action === 'reset' ) {
				// Loop through current page options
				foreach ( (array) $this->get_page_options() as $option ) {
					// Option must have an ID
					if ( !isset( $option['id'] ) ) continue;
					// Reset option with multiple values
					if ( !isset( $option['default'] ) && isset( $option['options'] ) ) {
						// Prepare variable for default value
						$option['default'] = array();
						// Loop through multiple values
						foreach ( (array) $option['options'] as $item ) {
							if ( isset( $item['id'] ) && isset( $item['default'] ) ) $option['default'][$item['id']] = $item['default'];
						}
					}
					// Save option value
					if ( isset( $option['default'] ) ) update_option( $this->config['prefix'] . $option['id'], $option['default'] );
				}
				// Reset hooks
				do_action( 'donation/reset', $this );
				do_action( 'donation/reset/' . $page, $this );
				// Set message
				$message = 2;
			}
			// Other actions
			else {
				// Set message var to "Something went wrong..."
				$message = 3;
			}
			// Go to page with specified message
			wp_redirect( $this->get_page_url() . '&message=' . $message );
			exit;
		}

		/**
		 * Get current page data
		 */
		public function get_page() {
			$slug = sanitize_key( $_REQUEST['page'] );
			// This page is added to the top-level menus
			if ( in_array( $slug, array_keys( (array) $this->config['menus'] ) ) ) return $this->config['menus'][$slug];
			// This page is added to the sub-menus
			else if ( in_array( $slug, array_keys( (array) $this->config['pages'] ) ) ) return $this->config['pages'][$slug];
				// Return an empty array by default
				return array();
		}

		/**
		 * Get current page options
		 */
		public function get_page_options() {
			// Get current page data
			$page = $this->get_page();
			// Prepare array for options
			$options = array();
			// This page have some options
			if ( isset( $page['options'] ) && is_array( $page['options'] ) )
				// Loop through page options
				foreach ( $page['options'] as $option ) {
					// Add option to resulting array
					$options[] = $option;
				}
			// Return options
			return $options;
		}

		/**
		 * Get current page URL
		 *
		 * @param mixed   $slug Page slug (optional). This parameter can be automatically retrieved from $_GET['page']
		 * @return string  Page URL
		 */
		public function get_page_url( $slug = false ) {
			// Get slug from $_GET['page']
			if ( !$slug && isset( $_REQUEST['page'] ) ) $slug = sanitize_key( $_REQUEST['page'] );
			// Serach for URL in registered top-level menus
			if ( isset( $this->config['menus'][$slug] ) && isset( $this->config['menus'][$slug]['url'] ) ) return $this->config['menus'][$slug]['url'];
			// Serach for URL in registered sub-menus
			elseif ( isset( $this->config['pages'][$slug] ) && isset( $this->config['pages'][$slug]['url'] ) ) return $this->config['pages'][$slug]['url'];
			// Return empty string if URL doesn't found
			return '';
		}

		/**
		 * Conditional check for donation options page
		 *
		 * @return boolean true/false - there is an page created by donation
		 */
		public function is_donation() {
			return isset( $_GET['page'] ) && in_array( $_GET['page'], $this->config['slugs'] );
		}

	}
}

