<?php
if (!defined('ABSPATH')) {
    exit;
}

session_start();

/**
 * Donation_Gateway_Openpay class.
 * 
 */
class Donation_Gateway_Openpay
{
    use Utils;
    protected $currencies = array('MXN', 'USD');
    var $config = array();

    /**
     * Constructor
     */
    public function __construct( $args = array() ) {


        $args = wp_parse_args($args, array(
                    'file'        => __FILE__,
                    'slug'        => 'plugin-donation',
                    'prefix'      => 'plugin_donation_',
                    'order_prefix'      => 'web',
                    'textdomain'  => 'plugin-donation',
                    'payment_type'  => array('One Time','Subscription'),
                    'url'         => '',
                    'version'     => '',
                    'options'     => array(),
                    'menus'       => array(),
                    'pages'       => array(),                    
                    'css'         => 'assets/css',
                    'js'          => 'assets/js',                    
                    'assets'      => 'assets',
                    'id'          => 'openpay',
                    'subscription_plan'=>array('Plan 100'=>'openpay_plan_100','Plan 300'=>'openpay_plan_300','Plan 500'=>'openpay_plan_500'),
                    'timezone'    =>'America/Mexico_City',        
                    'plugin_dir_path'=> plugin_dir_path( __DIR__ ) 
                ) );
        // Check required settings
        if ( !$args['file'] ) wp_die( 'donation: please specify plugin __FILE__' );
        if ( !$args['slug'] ) $args['slug'] = sanitize_key( plugin_basename( basename( $args['file'] , '.php' ) ) );
        if ( !$args['prefix'] ) $args['prefix'] = 'donation_' . sanitize_key( $args['slug'] ) . '_';
        if ( !$args['textdomain'] ) $args['textdomain'] = sanitize_key( $args['slug'] );   

        // Setup config
        $this->config = $args;                
        
        $this->method_title = __('onetime', 'subscription');
        $this->method_description = __('Openpay works by adding credit card fields on the checkout and then sending the details to Openpay for verification.', 'openpay-subscription');
        $this->has_fields = true;
        $apiEndpoint = 'https://api.openpay.mx/v1';
        $apiSandboxEndpoint = 'https://sandbox-api.openpay.mx/v1';
        $this->supports = array(
            'subscriptions',
            'products',
            'subscription_cancellation',
            'subscription_reactivation',
            'subscription_suspension',
            'subscription_amount_changes',
            'subscription_payment_method_change',
            'subscription_date_changes',
        );

        // Icon
        $icon = 'credit_cards.png';
        $this->icon = apply_filters('wc_openpay_icon', plugins_url('/assets/images/'.$icon, dirname(__FILE__)));
        $this->loader = apply_filters('wc_openpay_icon', plugins_url('/assets/images/loader.gif', dirname(__FILE__)));

        // Load the form fields
        //$this->init_form_fields();

        // Load the settings.
       // $this->init_settings();

        // Get setting values
        //$this->title = $this->get_option('title');
        //$this->description = $this->get_option('description');
        $this->enabled = $this->get_option($this->config['prefix'].'openpay_enabled');
        $this->testmode = $this->get_option($this->config['prefix'].'openpay_testmode') === "on" ? true : false;
        $this->openpay_enabled = $this->get_option($this->config['prefix'].'openpay_enabled') === "on" ? true : false;
                

        $this->merchant_id = $this->testmode ? $this->get_option($this->config['prefix'].'openpay_test_merchant_id') : $this->get_option($this->config['prefix'].'openpay_merchant_id');
        
        $this->secret_key = $this->testmode ? $this->get_option($this->config['prefix'].'openpay_test_secret_key') : $this->get_option($this->config['prefix'].'openpay_secret_key');        

        $this->publishable_key = $this->testmode ? $this->get_option($this->config['prefix'].'openpay_test_publishable_key') : $this->get_option($this->config['prefix'].'openpay_publishable_key');
        $this->api_endpoint = $this->testmode ? $apiSandboxEndpoint : $apiEndpoint;

        if ($this->testmode) {
            $this->description .= ' '.__('SANDBOX MODE ENABLED. In test mode, you can use the card number 4111111111111111 with any CVC and a valid expiration date.', 'openpay-subscription');
            $this->description = trim($this->description);
        }

        // Hooks
        add_action('wp_enqueue_scripts', array($this, 'payment_scripts'));
        
    }

    public function payment_loader() {
            echo '<div align="center" id="payment-loader-container" style="background-color:#cbedf2;width:100%;height:100%; padding:10% 0;">
                    <div class="payment-loader">
                         <div><img src="'.$this->loader.'"/></div> 
                    </div>
                   <div style="color:red"><h3>No cierre ni haga clic en el botón Atrás. <br/>El sistema está procesando su solicitud. Gracias por su paciencia.</h3></div>
                   </div>';
    }
    

    /**
     * payment_scripts function.
     *
     * Outputs scripts used for openpay payment
     *
     * @access public
     */
    public function payment_scripts() {

        wp_enqueue_script('openpay'.$this->config['version'], 'https://openpay.s3.amazonaws.com/openpay.v1.min.js', '', $this->config['version'], true);
        wp_enqueue_script('openpay_fraud'.$this->config['version'], 'https://openpay.s3.amazonaws.com/openpay-data.v1.min.js', '', $this->config['version'], true);
        wp_enqueue_script('donation_openpay'.$this->config['version'], plugins_url('assets/js/openpay.js', dirname(__FILE__)), array(), $this->config['version'], true);

        $openpay_params = array(
            'merchant_id' => $this->merchant_id,
            'public_key' => $this->publishable_key,
            'sandbox_mode' => $this->testmode,
            'openpay_enabled' => $this->openpay_enabled,
            'ajax_url' => admin_url('admin-ajax.php'),                   
            'i18n_terms' => __('Please accept the terms and conditions first', 'openpay-subscription'),
            'i18n_required_fields' => __('Please fill in required checkout fields first', 'openpay-subscription'),
        );        

        wp_localize_script('donation_openpay'.$this->config['version'],'donation_openpay_params', $openpay_params);
    }

    // public function payment_styles() {
    //     echo plugins_url('assets/css/donation.css', dirname(__FILE__)); exit;
    //     wp_register_style( 'donation_css', plugins_url('assets/css/donation.css', dirname(__FILE__)), array('donation'), '1.0', true);
    //     wp_enqueue_style( 'donation_css' );
    // }

    /**
     * Process the DIRECT payment 
     */
    public function process_payment()
    {
        $amount_limit = get_option( $this->config['prefix'].'openpay_payment_limit');
        if($_POST['amount'] > $amount_limit)
        {
            $error_msg = 'Límite de pago excedido a,'. $_POST['amount'];
            $this->write_log($_POST['email'],$error_msg); 
            
            return array(
                'status' => 'error',
                'result' => $error_msg
            );  

        }

        if ( empty($_POST['donation_action'] ) || empty( $_POST['page'] ) ) return;

        // Check nonce
        if ( empty( $_POST['donation_nonce'] ) || !wp_verify_nonce( $_POST['donation_nonce'], 'donation' ) ) return;        

        if ( !$this->is_donation() ) return;        

        $log = "Start: ". date('Y-m-d H:i:s');
        $this->write_log($_POST['email'],$log);   

        $log = 'Initalize Payment';
        $this->write_log($_POST['email'],$log);        
        
        $device_session_id = isset($_POST['device_session_id']) ? $_POST['device_session_id'] : '';
        $openpay_token = isset($_POST['token_id']) ? $_POST['token_id'] : '';        

        if (!$transactionId || !is_string($transactionId)) {
            $transactionId = 0;
        }

        // Use Openpay CURL API for payment
        try {

            $post_data = array();
            $email_data = array();
            $email_data['email'] = $_POST["email"];
            $email_data['name'] = $_POST["holder_name"];

            // Check amount
            if (!$_POST['amount']) {
                    $error_msg  = __('Lo sentimos, el total mínimo del pedido permitido es de 100 MXN para usar este método de pago.', $this->config['textdomain']);
            }
            
            // Pay using a saved card!
            if (empty($openpay_token)) { // If not using a saved card, we need a token
                    $error_msg = __('Asegúrese de que los datos de su tarjeta se hayan ingresado correctamente y que su navegador admita JavaScript.',$this->config['textdomain']);

                if ($this->testmode) {
                    $error_msg .= __('Desarrolladores: asegúrese de incluir jQuery y no hay errores de JavaScript en la página.', $this->config['textdomain']);
                }

            }

            if($error_msg)
            {                   
                $this->write_log($_POST['email'],$error_msg);        

                return array(
                'status' => 'error',
                'result' => $error_msg
                );
            }
            
            $donor_id = $this->add_customer();            

            if($donor_id)
            {
                $log = 'Donor added';
                $this->write_log($_POST['email'],$log);      
            }

            if (!$transactionId) {                

                $order_id = $this->add_payment( $donor_id );                                

                if (!$order_id) {
                    $error_msg = __('Lo sentimos, pago no agregado debido a algún error interno.', $this->config['textdomain']);

                    $log = 'Order is not created';
                    $this->write_log($_POST['email'],$error_msg);        

                    return array(
                        'status' => 'error',
                        'result' => $error_msg
                    );
                }
            }


            $customer = array(
                 'name' => $_POST["holder_name"],                 
                 'email' => $_POST["email"]
                );
            
            $post_data['amount'] = $_POST['amount'];
            $post_data['currency'] = strtolower($this->currencies[0]);            
            $post_data['method'] = 'card';
            $post_data['device_session_id'] = $device_session_id;
            $post_data['order_id'] = $order_id;
            $post_data['customer'] = $customer;
            
            $payment_desc='One Time';
            
            $customer_id = '';           
            if($this->is_subscription())
            {   

                $customer_id = $this->add_customer_openpay( $donor_id );                         
                $log = 'Customer is created: '.$customer_id;
                $this->write_log($_POST['email'],$log);        
                //for testing purpose commented

                $response = $this->add_card($customer_id, $openpay_token, $device_session_id);
                $card_id = '';                 
                if($response->error_code)
                {
                    $log = 'Source is not validated';
                    $this->write_log($_POST['email'],$log);            
                    
                    $this->add_payment_failure_log($donor_id, $post_data,$response); 

                    $this->update_payment_history($order_id,$response);                    

                    $msg = $this->handleRequestError($response->error_code);

                    $email_data['order_id'] = $order_id;
                    $email_data['amount'] = $_POST['amount'];
                    $email_data['msg'] = $msg;
                    $email_data['email'] = $_POST['email'];
                    $email_data['name'] = $_POST['holder_name'];
                    $this->send_mail('payment_failure',$email_data);
                
                    return new WP_Error('error', __($response->error_code.' '.$msg, 'openpay-subscription'));
                }
                else
                {
                    if (isset($response->id))
                    {   
                        $card_id = $response->id; 
                        $log = 'Source is validated';
                        $this->write_log($_POST['email'],$log);            
                    }
                }   
                //End of for testing purpose commented

                $post_data['source_id'] = $card_id; 
          
                $plan_id=$this->getSubscriptionPlanid();                

                $payment_desc='Subscription';

                $add_action="customers/{$customer_id}/subscriptions";

                $post_data['plan_id']=$plan_id;
                
                $mail_action = 'payment_subscription';

                $log = 'Got Subscription plan id';
                $this->write_log($_POST['email'],$log); 
             
            }
            else
            {   
                $add_action ="charges";
                //$post_data['source_id'] = $card_id;
                $post_data['source_id'] = $openpay_token;
                $mail_action = 'payment_success';
                //for testing purpose commented
                $post_data['use_3d_secure'] = true;
                $redirect_url = get_option( $this->config['prefix'].'openpay_3d_secure_redirect_url');
                
                $_SESSION['order_data']=array('order_id'=>$order_id,'notify_url'=>$current_url = $this->get_page_referer_url());
                if($redirect_url)
                {
                    $post_data['redirect_url'] = $redirect_url;
                }
                else
                {
                    $error_msg = 'Redirect url no está configurado para 3d Secure';
                    $this->write_log($_POST['email'],$error_msg); 
                    
                    return array(
                        'status' => 'error',
                        'result' => $error_msg
                    );  
                }
                //End of for testing purpose commented
            }


            $post_data['description'] = sprintf(__('%s - Order - '.$order_id), wp_specialchars_decode($payment_desc, ENT_QUOTES));

            $response = $this->openpay_request($post_data, $add_action);
            
            if (isset($response->error_code))
            {                                   
                
                $log = 'Openpay request is failed due to:'.$response->error_code;
                $this->write_log($_POST['email'],$log);            

                $this->add_payment_failure_log($donor_id, $post_data,$response);

                $this->update_payment_history($order_id,$response);                
                $msg = $this->handleRequestError($response->error_code);
                if($response->description){
                       $msg .' or ' . $response->description;
                }
                $this->write_log($_POST['email'],$msg);            

                $email_data['order_id'] = $order_id;
                $email_data['amount'] = $_POST['amount'];
                $email_data['msg'] = $msg;
                $email_data['email'] = $_POST['email'];
                $email_data['name'] = $_POST['holder_name'];
                $this->send_mail('payment_failure',$email_data);                

                return new WP_Error('error', __($response->error_code.' '.$msg, 'openpay-subscription'));
            }            

            $redirect_params ='&order_id=' . $order_id;
            if($response->transaction->subscription_id)
            {   
                $response->order_id = $order_id;
                $this->add_subscription_data($donor_id,$response);                
                $next_payment_date = $this->date_formatter($response->charge_date);              
                $redirect_params.='&next_payment_date='.$next_payment_date;
                $email_data['next_payment_date'] = $next_payment_date;

                $log = 'Added subscription data';
                $this->write_log($_POST['email'],$log);            
            }
            
                $redirect_params.='&amount='.$_POST['amount'];
                $log = 'Updated Payment history';
                $this->write_log($_POST['email'],$log);   

                $this->update_payment_history($response->order_id,$response);

                $this->add_payment_success_log($donor_id,$order_id,$response);               

                $log = 'Added payment log';
                $this->write_log($_POST['email'],$log);                   

            if($response->transaction->subscription_id ||  $response->status == 'completed' )
            {   
                $email_data['order_id'] = $order_id;
                $email_data['amount'] = $_POST['amount'];
                $email_data['email'] = $_POST['email'];
                $email_data['name'] = $_POST['holder_name'];
                $this->send_mail($mail_action,$email_data);            

                $log = "End: ". date('Y-m-d H:i:s');
                $this->write_log($_POST['email'],$log);                  

                return array(
                    'status' => 'success',
                    'redirect' => $this->get_page_referer_url() . '?payment_status=success'.$redirect_params
                );
            }
            else
            {
                $msg = 'Payment processing with 3D secure. redirect';
                $this->write_log($_POST['email'],$msg);
                if($response->payment_method->type == 'redirect')
                {
                       wp_redirect($response->payment_method->url);
                       exit; 
                }
            }
        } catch (Exception $e) {
            wc_add_notice($e->getMessage(), 'error');
            return;
        }
    }


    public function process_webhook_payment(){
        $response = @file_get_contents('php://input');
        //$response = $this->dry_test_subscriptin_openpay_hook();
        //$response = $this->dry_test_3d_secure_openpay_hook();
        $response = json_decode($response);
        if ($response->transaction->id && $response->transaction->subscription_id)
        {  
            $this->_wh_process_subscription_payment($response);
        }
        else if($response->type=='charge.succeeded')
        {
            $this->_wh_process_3d_secure_payment($response);
        }
        else{
            
            $return_data=array('status'=>'error','msg'=>'no response.'); 
            echo json_encode($return_data);
            exit;  
        }


    }

    public function _wh_process_subscription_payment($response) {        

        $retun_data=array();
        $email_data = array();

        if ( empty($response->transaction->id) )
        { 
            $retun_data=array('status'=>'error','msg'=>'Not found transaction_id.'); 
            echo json_encode($retun_data);
            exit;
        }        
        
        $transactionId = $response->transaction->id;        

        if (!$transactionId || !is_string($transactionId)) {
            $transactionId = 0;
        }

        // Use Openpay CURL API for payment
        try {

            $response->transaction->subscription_id;
            $get_donor_data = $this->get_donor_data($response);


            if (!$get_donor_data)
            {
                $msg = 'Sorry, Donor not found.';
                $retun_data=array('status'=>'error','msg'=>$msg); 
                echo json_encode($retun_data);
                exit;
            }

            $post_data = array();            
            
            if ($transactionId)
            {
                $order_id = $this->add_payment( $get_donor_data->donor_id , $response);
                
                if (!$order_id)
                {
                    $msg = 'Lo sentimos, pago no agregado debido a algún error interno.';
                    $retun_data=array('status'=>'error','msg'=>$msg); 
                    echo json_encode($retun_data);
                    exit;
                }
            }                        
            
            if($response->transaction->subscription_id)
            {
                $response->order_id = $order_id;                 
            }     
                        
            $flag = $this->update_payment_history($response->order_id,$response);
            if(!$flag)
            {
               $retun_data=array('status'=>'error','msg'=>'No se puede actualizar el historial de pagos.');
               echo json_encode($retun_data);
               exit;    
            }
            

            $flag = $this->add_payment_success_log($get_donor_data->donor_id,$order_id,$response);
            if(!$flag)
            {
               $retun_data=array('status'=>'error','msg'=>'No se puede agregar el registro de éxito de pago.');
               echo json_encode($retun_data);
               exit;    
            }

            if(empty($retun_data))
            {   

                $email_data['email'] = $get_donor_data->email;
                $email_data['name'] = $get_donor_data->name;
                $email_data['order_id'] = $order_id;
                $email_data['amount'] = $response->transaction->amount;
                $this->send_mail($mail_action,$email_data);            

                $retun_data=array('status'=>'success','msg'=>"La suscripción se registra con éxito. Donación Ref. No:$order_id");
               echo json_encode($retun_data);
               exit;    

            }

           
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $retun_data=array('status'=>'error','msg'=>$msg);
            echo json_encode($retun_data);
            exit;
           
        }
    }

    public function add_subscription_data($donor_id='',$response)
    {  
        global $wpdb;
        $wpdb->show_errors();

        $table_name=$wpdb->prefix.'donation_subscriptions';
        $time = current_time( 'mysql' );        
        $subscription_id = $response->transaction->subscription_id;
        $amount = $response->transaction->amount;
        $plan_id=$response->plan_id;
        $customer_id=$response->customer_id;

        $creation_date = $this->date_formatter($response->creation_date,'Y-m-d H:i:s');
        
        $data = array('donor_id'=>$donor_id,'subscription_id'=>$subscription_id,'customer_id'=>$customer_id,'plan_id'=>$plan_id,'amount'=>$amount,'status'=>$response->status,'created_at'=>$creation_date,'modified_at'=>$creation_date);
        
        $format =  array();

        $wpdb->insert($table_name,$data,$format);
        $insert_id = $wpdb->insert_id;      

        if($wpdb->last_error !== '')
        {            
            $wpdb->print_error();
            wp_die();
        }    
        else
        {
            return $insert_id;
        }

    }

    /**
     * Add a customer to Openpay via the API.
     *
     * @param int $order
     * @param string $openpay_token
     * @return int|WP_ERROR
     */
    public function add_customer_openpay($donor_id='')
    {
        global $wpdb;
        $customerData = array(
            'name' => $_POST['holder_name'],            
            'email' => $_POST['email'],
            'requires_account' => false            
        );
                
        $response = $this->openpay_request($customerData, 'customers');        

        if (!isset($response->error_code)) {
            
            //Store the ID on the user account
            if ($donor_id && $response->id) {
                //update_user_meta(get_current_user_id(), '_openpay_customer_id', $response->id);
                $table_name=$wpdb->prefix.'donation_donors';
                $time = current_time( 'mysql' );
                $wpdb->update(
                        $table_name,
                        array( 'customer_id' => $response->id, 'modified_at' => $time ),
                        array( 'id' => $donor_id )
                );

                return $response->id;
            }

        } else {
            $msg = $this->handleRequestError($response->error_code);
            return new WP_Error('error', __($response->error_code.' '.$msg, 'openpay-subscription'));
        }
    }
    
    public function hasAddress($order)
    {
        if($order->billing_address_1 && $order->billing_state && $order->billing_postcode && $order->billing_country && $order->billing_city) {
            return true;
        }
        return false;    
    }

    public function getSubscriptionPlanid()
    {

        if($_POST['subscription_plan'])
        {
             $option_name =  $this->config['subscription_plan'][$_POST['subscription_plan']];
        }

        $plan_id = get_option( $this->config['prefix'].$option_name);
        if($plan_id)
        {
            return $plan_id;
        }
        else
        {
            return 0;
        }
        
    }

    public function getSubscriptionPlan($plan_id='')
    {
        
        foreach ($this->config['subscription_plan'] as $key => $value) 
        {            
            $opt_plan_id = get_option( $this->config['prefix'].$value);
            if( $plan_id == $opt_plan_id )
            {
                return $key;
            }
        }        
        
    }


    /**
     * Add a card to a customer via the API.
     *
     * @param int $order
     * @param string $openpay_token
     * @return int|WP_ERROR
     */
    public function add_card($customer_id='', $openpay_token='', $device_session_id='')
    {
        if ($openpay_token) {

            $cardDataRequest = array(
                'token_id' => $openpay_token,
                'device_session_id' => $device_session_id
            );

            if($this->is_subscription()){

                $log = 'Add card request for Subscription';
                $this->write_log($_POST['email'],$log );

                $response = $this->openpay_request($cardDataRequest, 'customers/'.$customer_id.'/cards');    
            }else{

                $log = 'Add card request for 3d secure';
                $this->write_log($_POST['email'],$log );
                $response = $this->openpay_request($cardDataRequest, 'cards');    
            }                        
            
            return $response;
            
        }
    }

    /**
     * Send the request to Openpay's API
     *
     * @param array $request
     * @param string $api
     * @return array|WP_Error
     */
    public function openpay_request($params=array(), $api='', $method = 'POST')
    {

        $absUrl = $this->api_endpoint.'/'.$this->merchant_id.'/';
        $absUrl .= $api;

        $username = $this->secret_key;
        $password = "";        

        $log = 'Secret_key:'.$username;        
        $this->write_log($params['email'],$log);

        $log = 'Curl request for action:'.$absUrl;        
        $this->write_log($params['email'],$log );

        $this->write_log($params['email'],$params);

        $data_string = json_encode($params);       
        $ch = curl_init();        
        curl_setopt($ch, CURLOPT_URL, $absUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: '.strlen($data_string))
        );

        $result = curl_exec($ch);        

        // Check if any error occurred
        if(curl_errno($ch))
        {
            echo 'Curl error: ' . curl_error($ch);
            wp_die();
        }

        curl_close($ch);             

        return json_decode($result);
    }

    

    public function validateCurrency() {
        return in_array(get_woocommerce_currency(), $this->currencies);
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


        /**
     * Add a customer to Openpay via the API.
     *
     * @param int $order
     * @param string $openpay_token
     * @return int|WP_ERROR
     */
    public function add_payment($donor_id='', $response = SomeObject::class)
    {
        
        global $wpdb;                
        $wpdb->show_errors();
        
        $table_name=$wpdb->prefix.'donation_payment_history';        

        $subscription_plan = ''; 
               
        $type='One Time';
        
        if(isset($_POST['subscription_plan']) && $_POST['subscription_plan']!='')
        {
            $subscription_plan = $_POST['subscription_plan'];            
            $type='Subscription';
        }
        else if($response->plan_id)
        {
            $subscription_plan = $this->getSubscriptionPlan($response->plan_id);          
            $type='Subscription';
        }


        $amount = ''; 
        if(isset($_POST['amount']))
        {
            $amount = $_POST['amount'];            
        }
        else
        {
            $amount = $response->transaction->amount;          
        }

        $time = ''; 
        if($response->transaction->creation_date)
        {   
            $time = $this->date_formatter($response->transaction->creation_date,'Y-m-d H:i:s');
        }
        else
        {
            $time = current_time( 'mysql' );
        }

        $order_id = $this->config['order_prefix']."_".date('YmdHis');
        
        $data = array('donor_id'=>$donor_id,'order_id'=>$order_id,'type'=>$type,'subscription_plan'=>$subscription_plan,'amount'=>$amount,'payment_date'=>$time,'status'=>'Pending','created_at'=>$time);    
        $format =  array();        

        $wpdb->insert($table_name,$data,$format);
        $transactionId = $wpdb->insert_id;      

        if($wpdb->last_error !== '')
        {            
            $wpdb->print_error();
            wp_die();
        }    
        else
        {
            return $order_id;
        }
        
    }

    public function update_payment_history($order_id='',$response = SomeObject::class)
    {

        global $wpdb;        
        $wpdb->show_errors();
        $data = array();
        
        if($response->transaction->subscription_id)
        {           
            $status = $response->transaction->status;
            $next_payment_date= $response->charge_date;
            $data=array('next_payment_date'=>$next_payment_date);
        }
        else if($response->error_code)
        {
            $status = 'failed'; 
        }
        else
        {
            $status = $response->status;            
        }


        $table_name=$wpdb->prefix.'donation_payment_history';
        $time = current_time( 'mysql' );
        $final_data = array_merge($data,array('status'=>$status,'modified_at'=>$time));    
        $format =  array();

        $wpdb->update($table_name,$final_data,array('order_id'=>$order_id),$format);        
        
        if($wpdb->last_error !== '')
        {            
            $wpdb->print_error();
            return false;
        }    
        else
        {
            return true;
        }
        
    }

    public function update_payment_log($order_id='',$response = SomeObject::class)
    {

        global $wpdb;        
        $wpdb->show_errors();
        $data = array();       
        
        if($response->error_code)
        {
            $status = 'failed'; 
        }
        else
        {
            $status = $response->status;            
        }


        $table_name=$wpdb->prefix.'donation_payment_log';
        $time = current_time( 'mysql' );
        $final_data = array_merge($data,array('status'=>$status,'modified_at'=>$time));    
        $format =  array();

        $wpdb->update($table_name,$final_data,array('order_id'=>$order_id),$format);        
        
        if($wpdb->last_error !== '')
        {            
            $wpdb->print_error();
            return false;
        }    
        else
        {
            return true;
        }
        
    }

    public function add_payment_success_log($donor_id='',$order_id='',$response = SomeObject::class)
    {

        global $wpdb;        

        $wpdb->show_errors();        

        $table_name=$wpdb->prefix.'donation_payment_log';        

        $log=json_encode($response);
        $subscription_id ='';
        $transaction_id='';
        if($response->transaction->subscription_id)
        {
            $subscription_id = $response->transaction->subscription_id;
            $transaction_id = $response->transaction->id;
        }else
        {
            $transaction_id = $response->id;
        }        

        if($response->transaction->amount)
        {
           $amount =  $response->transaction->amount;
        }else
        {
            $amount =  $response->amount;
        }


        $subscription_plan = ''; 
        if(isset($_POST['subscription_plan']))
        {
            $subscription_plan = $_POST['subscription_plan'];            
        }
        else
        {
            $subscription_plan = $this->getSubscriptionPlan($response->plan_id);          
        }
        
        $creation_date = $this->date_formatter($response->creation_date,'Y-m-d H:i:s');                 
        
        $data = array('order_id'=>$order_id,'donor_id'=>$donor_id,'transaction_id'=>$transaction_id,'subscription_id'=>$subscription_id,'subscription_plan'=>$subscription_plan,
                    'amount'=>$amount,'status'=>$response->status,'log'=>$log,'created_at'=>$creation_date,'modified_at'=>$creation_date);    
        $format =  array();

        $wpdb->insert($table_name,$data,$format);
        $inserted_id = $wpdb->insert_id;
        

        if($wpdb->last_error !== '')
        {            
            $wpdb->print_error();
            return false;
        }    
        else
        {
            return $inserted_id;
        }
        
    }

    public function add_payment_failure_log($donor_id ='', $post_data=array(),$response = SomeObject::class)
    {

        global $wpdb;        

        $wpdb->show_errors();        

        $table_name=$wpdb->prefix.'donation_payment_log';        

        $log=json_encode($response);        

        if(!$post_data['order_id'])
        {
            return;
        }

        $subscription_plan = ''; 
        if(isset($_POST['subscription_plan']))
        {
            $subscription_plan = $_POST['subscription_plan'];            
        }
        else
        {
            $subscription_plan = $this->getSubscriptionPlan($post_data['plan_id']);          
        }
        
        $time = current_time( 'mysql' );
        
        $data = array('order_id'=>$post_data['order_id'],'donor_id'=>$donor_id,'request_id'=>$response->request_id,'subscription_id'=>$post_data['plan_id'],'subscription_plan'=>$subscription_plan,
                    'amount'=>$post_data['amount'],'status'=>'failed','description'=>$response->description,'log'=>$log,'created_at'=>$time,'modified_at'=>$time);    
        $format =  array();

        $wpdb->insert($table_name,$data,$format);
        $inserted_id = $wpdb->insert_id; 

        if($wpdb->last_error !== '')
        {            
            $wpdb->print_error();
            wp_die();
        }    
        else
        {
            return $inserted_id;
        }
        
    }

    public function add_customer()
    {

        global $wpdb;


        $donor_id=$this->check_donor_exists_by_email();
        //$this->checkDuplicateSubscription();

        if($donor_id)
        {
            return $donor_id;
        }

        $table_name=$wpdb->prefix.'donation_donors';

        $time = current_time( 'mysql' );

        $subscription = 'One Time';
        if($_POST['subscription']){
            $subscription = 'Subscription'; 
        }

        $data = array('name'=>$_POST['holder_name'],'email'=>$_POST['email'],'created_at'=>$time,'modified_at'=>$time);    
        $format =  array();

        $wpdb->insert($table_name,$data,$format);
        $donor_id = $wpdb->insert_id;

        if($wpdb->last_error !== '')
        {
            $wpdb->print_error();
            wp_die();
        }    
        else
        {
            return $donor_id;
        }
        
    }


    function check_donor_exists_by_email()
    {    
        global $wpdb;
        $wpdb->show_errors();
        $table_name=$wpdb->prefix.'donation_donors';    
        $donor_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM $table_name WHERE email = '%s'",$_POST['email']));

        if($donor_id)
        {
            return $donor_id;
        }else{
            return 0;
        }

    }

    public function is_donation()
    {        
        return (isset( $_POST['page'])  && ($_POST['page'] == $this->config['slug']));
    }

    public function is_subscription()
    {                

        return (isset( $_POST['recurring'] )  && $_POST['recurring']);
    }

    public function get_page_url( $slug = false )
    {        
        $protocol = $_SERVER['SERVER_PROTOCOL'];
        $domain     = $_SERVER['HTTP_HOST'];
        $script   = $_SERVER['SCRIPT_NAME'];
        $parameters   = $_SERVER['QUERY_STRING'];
        $protocol=strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') 
                    === FALSE ? 'http' : 'https';
        $FinalUrl = $protocol . '://' . $domain. $script;

        if($slug=='home')
        {
            $FinalUrl = str_replace('/wp-admin/admin-ajax.php', '', $FinalUrl);            
        }

        return $FinalUrl;

    }
    

    public function process_log_openpay_hook()
    {
        $ipn_log = @file_get_contents('php://input');
        $ipn_log = json_decode($ipn_log,true);
        $log = ['ipn_response' => $ipn_log];
        array_push($log, PHP_EOL);
        array_push($log, PHP_EOL);       

        $path = $this->config['plugin_dir_path']."includes/logs/";      
        if (!is_dir($path)) 
        {
            mkdir($path, 0777, true);
        }
        $today = date("YmdHis");
        $logfile = $path."openpay_hook_$today.log";
        $fh = fopen($logfile, 'w+') or die("can't open file");
        fwrite($fh, json_encode($log));
        fclose($fh);        

        echo json_encode(array());
        exit;
    }


    public function dry_test_subscriptin_openpay_hook()
    {
        $path = $this->config['plugin_dir_path']."includes/logs/subscription_data.log";                  
        $ipn_log = @file_get_contents($path);
        if($ipn_log)
        {
            return $ipn_log;
        }
        //echo $ipn_log = json_decode($ipn_log);                
        exit;
    }

    public function dry_test_3d_secure_openpay_hook()
    {
        $path = $this->config['plugin_dir_path']."includes/logs/3d_secure_data.log";                  
        $ipn_log = @file_get_contents($path);
        if($ipn_log)
        {
            return $ipn_log;
        }
        //echo $ipn_log = json_decode($ipn_log);                
        exit;
    }


    public function get_donor_data( $response = SomeObject::class )
    {
        global $wpdb;
        $wpdb->show_errors();
        $table_name=$wpdb->prefix.'donation_subscriptions';
        $table_name1=$wpdb->prefix.'donation_donors';
        
        $donor_data = $wpdb->get_results($wpdb->prepare("SELECT ds.donor_id, dd.name, dd.email FROM $table_name as ds left join $table_name1 as dd on dd.id = ds.donor_id WHERE subscription_id = '%s' and plan_id = '%s' ",$response->transaction->subscription_id,$response->plan_id));

        if($donor_data)
        {
            return $donor_data[0];
        }else{
            return 0;
        }
   }

   public function get_customer_id($donor_id='',$subscription_id)
    {
        global $wpdb;
        $wpdb->show_errors();
        $table_name=$wpdb->prefix.'donation_subscriptions';
        $customer_id=''  ;
        if($donor_id && $subscription_id)
        {
            $customer_id = $wpdb->get_var($wpdb->prepare("SELECT customer_id FROM $table_name WHERE subscription_id = '%s' and donor_id = '%s' ",$_GET['subscription_id'],$_GET['donor_id']));
    
        }        
        
        if($customer_id)
        {
            return $customer_id;
        }else{
            return 0;
        }
   }

    public function get_payment_log($transaction_id='', $order_id='')
    {
        global $wpdb;
        $wpdb->show_errors();
        $table_name=$wpdb->prefix.'donation_payment_log';
        $table_name1=$wpdb->prefix.'donation_donors';
        
        $payment_data = $wpdb->get_results($wpdb->prepare("SELECT dpl.order_id, dpl.donor_id, dd.name, dd.email, dpl.amount ,dpl.status FROM $table_name as dpl left join $table_name1 as dd on dd.id = dpl.donor_id WHERE (transaction_id = '%s' or order_id = '%s') ",$transaction_id,$order_id));
        
        if($payment_data)
        {
            return $payment_data[0];
        }else{
            return 0;
        }
   }

   public function donation_processing_secure()
   {        

        include_once( $this->config['plugin_dir_path'] . 'templates/donation_processing_secure.php');  
   }

   public function donation_processing_secure_callback()
   {

       $output =array();
        if(isset($_REQUEST['id']) && $_REQUEST['id']!='')
        {   
            $starttime=time();
            $payment_data=array();

            do {                
                $payment_data = $this->get_payment_log($_REQUEST['id']); 
                sleep(1);                
            } while ( ($starttime-time()/60)==5 && $payment_data->status=='charge_pending');            
            
            $redirect_params ='&order_id=' . $payment_data->order_id;
            $redirect_params.='&amount='.$payment_data->amount;
            $redirect_url=$this->get_page_url('home');
            
            if(isset($_SESSION['order_data']))
            {
                $redirect_url = $_SESSION['order_data']['notify_url'];
                unset($_SESSION['order_data']);
            }

            if($payment_data->order_id && $payment_data->status=='completed' )
            {   
                
               $output= array(
                    'status' => 'success',
                    'redirect' => $redirect_url . '?payment_status=success'.$redirect_params
                );

            }
            else if($payment_data->status=='charge_pending')
            {  

                $msg = $this->handleResponseStatus($payment_data->status);
                $log = "Payment is pending due to :".$msg;           
                $this->write_log($payment_data->email,$log);                
                $redirect_params.='&msg='.$msg;

                $output =  array(
                    'status' => 'success',
                    'redirect' => $redirect_url . '?payment_status=pending'.$redirect_params
                );
                
            }else if($payment_data->status=='failed')
            {   

                $msg = $this->handleResponseStatus($payment_data->status);                
                $log = "Payment is failed due to :".$msg;           
                $this->write_log($payment_data->email,$log);              
                $redirect_params.='&msg='.$msg;

                $output =  array(
                    'status' => 'error',
                    'redirect' => $redirect_url . '?payment_status=error'.$redirect_params
                );
                
            }else
            {
                $error_msg = '3D Secure is not processed properly.';
                $output =  array(
                        'status' => 'error',
                        'result' => $error_msg
                    );


            }
        }
        else
        {   
            $error_msg = '3D Secure is not processed properly.';
            $output =  array(
                        'status' => 'error',
                        'result' => $error_msg
                    );
        }

        wp_die(json_encode($output));

   }

   public function _wh_process_3d_secure_payment($response)
   {    
        //header('Content-type:application/json;charset=utf-8');
        if(isset($response->transaction->id) && $response->transaction->id!='')
        {               
            
            $payment_data = $this->get_payment_log($response->transaction->id);            
            if($payment_data->order_id && $response->transaction->order_id)
            {

                $log = "Payment has been successfully made";           
                $this->write_log($payment_data->email,$log);   
                
                $email_data['order_id'] = $response->transaction->order_id;
                $email_data['amount'] = $response->transaction->amount;
                $email_data['email'] = $response->transaction->customer->email;
                $email_data['name'] = $response->transaction->customer->name;
                
                $this->send_mail('payment_success',$email_data);
                
                $response->status=$response->transaction->status;
                $this->update_payment_history($response->transaction->order_id,$response);

                $log = "hook update_payment_history after 3d secure processed";
                $this->write_log($payment_data->email,$log);  

                $this->update_payment_log($response->transaction->order_id,$response);

                $log = "hook update_payment_log after 3d secure processed";
                $this->write_log($payment_data->email,$log);  

                $log = "End: ". date('Y-m-d H:i:s');
                $this->write_log($payment_data->email,$log);  

                $return_data=array('status'=>'success','msg'=>"El pago se actualiza con éxito. No:".$response->transaction->order_id);
                echo json_encode($return_data);
                exit;
            }
        }
        else
        {
            $return_data=array('status'=>'error','msg'=>'3D Secure no se procesa.'); 
            echo json_encode($return_data);
            exit;   
        }

   }
   
   
   public function get_page_referer_url() 
    {        
        $url = explode('?' , $_SERVER['HTTP_REFERER']);
        return $url[0];

    }

}
