<?php
if (!defined('ABSPATH')) {
    exit;
}

session_start();

/**
 * Gateway_Epagos class.
 * 
 */
class Gateway_Epagos
{
    use EpagosUtils;
    var $config = array();

    /**
     * Constructor
     */
    public function __construct( $args = array() ) {


        $args = wp_parse_args($args, array(
                    'file'        => __FILE__,
                    'slug'        => 'plugin-epagos',
                    'prefix'      => 'plugin_epagos_',
                    'order_prefix'      => 'web',
                    'textdomain'  => 'plugin-epagos',
                    'url'         => '',
                    'version'     => '',
                    'options'     => array(),
                    'menus'       => array(),
                    'pages'       => array(),                    
                    'css'         => 'assets/css',
                    'js'          => 'assets/js',                    
                    'assets'      => 'assets',
                    'id'          => 'epagos',
                    'timezone'    =>'America/Mexico_City',        
                    'plugin_dir_path'=> plugin_dir_path( __DIR__ ) 
                ) );
        // Check required settings
        if ( !$args['file'] ) wp_die( 'epagos: please specify plugin __FILE__' );
        if ( !$args['slug'] ) $args['slug'] = sanitize_key( plugin_basename( basename( $args['file'] , '.php' ) ) );
        if ( !$args['prefix'] ) $args['prefix'] = 'epagos_' . sanitize_key( $args['slug'] ) . '_';
        if ( !$args['textdomain'] ) $args['textdomain'] = sanitize_key( $args['slug'] );   

        // Setup config
        $this->config = $args;                
        
        $this->has_fields = true;
        $apiEndpoint = $this->get_option($this->config['prefix'].'epagos_app_domain');
        $apiSandboxEndpoint = $this->get_option($this->config['prefix'].'epagos_app_domain');

        // Load the form fields
        //$this->init_form_fields();

        // Load the settings.
       // $this->init_settings();

        // Get setting values
        //$this->title = $this->get_option('title');
        //$this->description = $this->get_option('description');
        $this->testmode = $this->get_option($this->config['prefix'].'epagos_testmode') === "on" ? true : false;
        $this->epagos_enabled = $this->get_option($this->config['prefix'].'epagos_enabled') === "on" ? true : false;
        $this->business_id = $this->get_option($this->config['prefix'].'epagos_business_id');
        $this->payment_id = $this->get_option($this->config['prefix'].'epagos_payment_id');
        $this->api_endpoint = $this->testmode ? $apiSandboxEndpoint : $apiEndpoint;
        $this->subscription_enabled = $this->get_option($this->config['prefix'].'epagos_subscription') === "on" ? true : false;
        // fijo el modulo de mercadopago de momento
        $this->_module = 'MercadoPago';

        // Hooks
        add_action('wp_enqueue_scripts', array($this, 'payment_scripts'));
        
    }

    /**
     * payment_scripts function.
     *
     * Outputs scripts used for epagos payment
     *
     * @access public
     */
    public function payment_scripts() {
		
		$businessId = $this->business_id;
		$paymentId = $this->payment_id;
        wp_enqueue_script('epagos'.$this->config['version'], plugins_url('assets/js/epagos.js', dirname(__FILE__)), array(), $this->config['version'], true);
        if ($this->epagos_enabled){
			wp_enqueue_script('epagos', $this->api_endpoint . '/js/function.payment.v1.1.min.js', array( 'jquery' ), $this->config['version'], true);
			wp_enqueue_script('epagos_mercadopago', $this->api_endpoint . '/js/epagos.mercadopago.v1.2.js#params', array( 'jquery' ), $this->config['version'], true);
			// agregar atributos necesarios en el script de e-pagos
			add_filter( 'script_loader_tag', function ( $tag, $handle, $src ) use($businessId, $paymentId) {
				if ( 'epagos_mercadopago' != $handle ) {
					return $tag;
				}
				$mercadopago_js_url = "' id='epagos.script.mercadopago'" . 
					" data-key='" . $businessId . "'" .
					" data-module-payment-id='" . $paymentId . "'" .
					" data-success='mercadopagoCompleteCallback' data-error='mercadopagoErrorCallback'" .
					" data-form='payment_form" ;
				return str_replace( '#params', $mercadopago_js_url , $tag );
			}, 10, 3 );
		}
        $epagos_params = array(
            'business_id' => $this->business_id,
            'payment_id' => $this->payment_id,
            'sandbox_mode' => $this->testmode,
            'epagos_enabled' => $this->epagos_enabled,
            'form_action' => $this->api_endpoint . sprintf('/ProcessPayment.php?process=Payment&module=%s&version=1.1', $this->_module),
            'ajax_url' => admin_url('admin-ajax.php'),
        );
        if ($this->subscription_enabled){
			$epagos_params['subscriptions'] = json_decode($this->request_subscriptions());
		}
        wp_localize_script('epagos'.$this->config['version'],'epagos_params', $epagos_params);
    }
    
    /*
     * Obtiene las suscripciones de e-pagos
     * */
	public function request_subscriptions(){
		$url= $this->api_endpoint . sprintf('/ProcessPayment.php?process=Webservice&version=1.1&business_key=%s&module=%s&action=get_subscriptions', $this->business_id, $this->_module);
		return $this->curl_sender($url);
	 }

    public function payment_styles() {
         echo plugins_url('assets/css/epagos-admin.css', dirname(__FILE__)); exit;
         wp_register_style( 'donation_css', plugins_url('assets/css/epagos-admin.css', dirname(__FILE__)), array('donation'), '1.0', true);
         wp_enqueue_style( 'donation_css' );
    }
    
    public static function get_option( $option_name = '', $field_id = '', $default = false )
    {
            // Bailout.
            if ( empty( $option_name ) && empty( $field_id ) ) {
                return false;
            }

            if ( ! empty( $field_id ) && ! empty( $option_name ) ) {
                // Get field value if any.
                $option_value = get_option( $option_name );

                $option_value = ( is_array( $option_value ) && array_key_exists( $field_id, $option_value ) )
                    ? $option_value[ $field_id ]
                    : $default;
            } else {
                // If option name is empty but not field name then this means, setting is direct store to option table under there field name.
                $option_name = ! $option_name ? $field_id : $option_name;

                // Get option value if any.
                $option_value = get_option( $option_name, $default );
            }

            return $option_value;
    }

}
