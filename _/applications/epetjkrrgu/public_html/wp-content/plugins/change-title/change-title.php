<?php 
/*
	Plugin Name: Change Title
	Plugin URI: http://lampejos.com.br/plugins/change-title/
	Description: Changes the page title if the user leaves the page.
	Author: Lampejos
	Author URI: http://lampejos.com.br/
	Text Domain: change_title
	Domain Path: /languages
	Version: 2.4.1
*/

/* Translations */
load_plugin_textdomain('change_title', false, basename( dirname( __FILE__ ) ) . '/languages' );

class ct_settingspage {

	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Constroi o plugin
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'change_title_page' ) );
		add_action( 'admin_init', array( $this, 'change_title_init' ) );
	}

	/**
	 * Adiciona a opção ao menu lateral
	 */
	public function change_title_page() {
		add_options_page(
			__('Change Title', 'change_title'),                       // Título da página
			__('Change Title', 'change_title'),                       // Opção
			'manage_options',                                         // Capacidade
			'change_title_page',                                      // Slug
			array( $this, 'change_title_admin_page' )                 // Callback
		);
	}

	/**
	 * Constroi a página de opções
	 */
	public function change_title_admin_page() {
		$this->options = get_option( 'change_title' );
		?>
		<div class="wrap">
			<h1><?php _e('Change Title', 'change_title') ?></h1>
			<div class="lamp-plugin-wrap">
				<div class="lamp-plugin-content">		
					<form method="post" action="options.php">
					<?php
						settings_fields( 'change_title_group' );
						do_settings_sections( 'change_title_page' );
						submit_button();
					?>
					</form>
				</div>
				<div class="lamp-plugin-credits postbox">
					<div class="inside">
						<p><?php _e('The Change Title plugin was developed by Lampejos agency, if you like to share.', 'change_title'); ?></p>
						<p>
							<strong><?php _e('Dúvidas?', 'change_title'); ?></strong><br>
							- <a href="https://wordpress.org/support/plugin/change-title" target="_blank"><?php _e('Suporte', 'change_title'); ?></a>
						</p>
						<p>
							<strong><?php _e('Info:', 'change_title'); ?></strong><br>
							- <a href="https://wordpress.org/plugins/change-title/" target="_blank"><?php _e('Plugin Page', 'change_title'); ?></a><br>
							- <a href="http://lampejos.com.br/" target="_blank">Lampejos.com.br</a>
						</p>
						<p><a href="http://lampejos.com.br" class="lamp-logo" target="_blank">Lampejos</a></p>
					</div>
				</div>
			</div>
		</div>

		<style><?php include_once('change-title-admin.css'); ?></style>
		<?php
	}

	/**
	 * Registra e adiciona os campos
	 */
	public function change_title_init() {        
		register_setting(
			'change_title_group',                                     // Grupo
			'change_title',                                           // Nome
			array( $this, 'sanitize' )                                // Sanitizar
		);

		add_settings_section(
			'change_title_section',                                   // ID
			__('Setting', 'change_title'),                            // Título
			array( $this, 'print_section_info' ),                     // Callback
			'change_title_page'                                       // Página
		);

		add_settings_field(
			'active',                                                 // Nome do Field
			__('Active:', 'change_title'),                            // Label
			array( $this, 'active_callback' ),                        // Callback
			'change_title_page',                                      // Página
			'change_title_section'                                    // Seção
		);

		add_settings_field(
			'site_title',                                             // Nome do Field
			__('Site Title:', 'change_title'),                        // Label
			array( $this, 'message_callback' ),                       // Callback
			'change_title_page',                                      // Página
			'change_title_section'                                    // Seção
		);
	}

	/**
	 * Sanitiza os campos
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input ) {
		$new_input = array();

		if( isset( $input['active'] ) )
			$new_input['active'] = sanitize_text_field( $input['active'] );

		if( isset( $input['site_title'] ) )
			$new_input['site_title'] = sanitize_text_field( $input['site_title'] );

		return $new_input;
	}

	/** 
	 * Descrição da página de opções
	 */
	public function print_section_info() {
		print __('Active the plugin, enter the title to be set if the user leaves the page and save.', 'change_title');
	}

	/** 
	 * Callback para ativar o plugin
	 */
	public function active_callback() {
		echo '<input type="checkbox" id="active" name="change_title[active]" value="1"' . checked( 1, isset( $this->options['active'] ) ? esc_attr( $this->options['active']) : false, false ) . ' />';
	}

	/** 
	 * callback para gravar o titulo
	 */
	public function message_callback() {
		printf(
			'<input type="text" id="site_title" name="change_title[site_title]" value="%s" />',
			isset( $this->options['site_title'] ) ? esc_attr( $this->options['site_title']) : ''
		);
	}
}

if( is_admin() ) {
	$settingspage = new ct_settingspage();
}

$active = get_option('change_title');
if ( $GLOBALS['pagenow'] != 'wp-login.php' && !is_admin() && $active['active'] ) {
	function change_title_scripts() {
		wp_register_script( 'change_title_script', plugin_dir_url( __FILE__ ) . 'change-title.js', array(), 1.0, true );
		wp_enqueue_script( 'change_title_script' );

		$title = get_option('change_title');
		wp_localize_script( 'change_title_script', 'change_title', esc_html( $title['site_title']) );
	}
	add_action('wp_footer', 'change_title_scripts');
}