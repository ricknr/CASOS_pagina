<?php
/*
  Plugin Name: Donation Openpay
  Plugin URI: -
  Version: 7.0.0
  Description: Pay donation by Openpay
  Author: - 
  Author URI:  -
  Text Domain: plugin-donation
  Domain Path: 
  License: MIT
 */
require_once 'includes/utils.php';
require_once 'includes/donation.php';
require_once 'includes/controls.php';
require_once 'includes/gateway-openpay.php';
require_once 'includes/donors.php';
require_once 'includes/emails.php';

/**
 * Initialize example plugin
 */

global $timezone;
$timezone = 'America/Mexico_City';
if(!defined('VERSION'))
{
  define('VERSION',0.8);
}

global $donation_db_version;
$donation_db_version = '1.1';
 
function plugin_donation_init($donationObj) {
	global $options;
	// Make plugin available for translation, you can change /languages/ to your .mo-files folder name
	load_plugin_textdomain( 'plugin-donation', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	// Initialize Sunrise
	$donationObj = new Donation( array(
			// Sunrise file path
			'file'	=> __FILE__,
			// Plugin slug (should be equal to plugin directory name)
			'slug' => 'plugin-donation',
			// Plugin prefix
			'prefix' => 'plugin_donation_',
			// Plugin textdomain
			'textdomain' => 'plugin-donation',
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
	$donationObj->add_menu( array(
			// Settings page <title>
			'page_title' => __( 'Donations', 'plugin-donation' ),
			// Menu title, will be shown in left dashboard menu
			'menu_title' => __( 'Donations', 'plugin-donation' ),
			// Minimal user capability to access this page
			'capability' => 'manage_options',
			// Unique page slug
			'slug' => 'plugin-donation',
			// Add here your custom icon url, or use [dashicons](https://developer.wordpress.org/resource/dashicons/)
			// 'icon_url' => admin_url( 'images/wp-logo.png' ),
			'icon_url' => 'dashicons-thumbs-up',
			// Menu position from 80 to <infinity>, you can use decimals
			'position' => '91.1',
			// Array with options available on this page
			'options' => $options,
		) );	

	//Add sub-menu (like Dashboard -> Settings -> Permalinks)
	$donationObj->add_submenu( array(
			// Settings page <title>
			'page_title' => __( 'Donation Email ', 'plugin-donation' ),
			// Menu title, will be shown in left dashboard menu
			'menu_title' => __( 'Email Templates', 'plugin-donation' ),
			// Unique page slug, you can use here the slug of parent page, which you've already created
			'slug' => 'plugin-donation-emails',
			// Slug of the parent page (see above)
			'parent_slug' => 'plugin-donation',
			// Array with options available on this page
			'options' => '',
		) );
	
}


add_action( 'wp_ajax_nopriv_processing_secure_callback','donation_processing_secure_callback');
add_action( 'wp_ajax_processing_secure_callback','donation_processing_secure_callback');

// Hook to plugins_loaded
add_action( 'plugins_loaded', 'plugin_donation_init' );

add_action( 'wp_ajax_nopriv_onetime_payment','datatables_onetime_callback');
add_action( 'wp_ajax_onetime_payment','datatables_onetime_callback');

add_action( 'wp_ajax_nopriv_subscription_payment','datatables_subscription_callback');
add_action( 'wp_ajax_subscription_payment','datatables_subscription_callback');

add_action( 'wp_ajax_donors_transaction','datatables_donors_callback');


//add_action( 'wp_ajax_emails_action','datatables_emails_callback');
add_action( 'wp_ajax_save_emails','email_save_data');
add_action( 'init', 'donation_processing', 10, 3 );

//add_action('phpmailer_init', 'mailtrap');

// function mailtrap($phpmailer) {
//   $phpmailer->isSMTP();
//   $phpmailer->Host = 'smtp.mailtrap.io';
//   $phpmailer->SMTPAuth = true;
//   $phpmailer->Port = 2525;
//   $phpmailer->Username = '8249c8b300e1da';
//   $phpmailer->Password = '72491d482daff1';
// }


add_action( 'wp_ajax_nopriv_onetime_payment_delete','datatables_onetime_delete');
add_action( 'wp_ajax_onetime_payment_delete','datatables_onetime_delete');

//front-end process		
function donation_processing()
{	
	$paymentClass = new Donation_Gateway_Openpay(
						array('version'=>VERSION)
					); 
	if(isset($_POST) && $_POST['donation_action']=='donation_processing' )
	{
		$paymentClass->payment_loader();				

		$response = $paymentClass->process_payment();				
		
		if(is_array($response) && ($response['status'] =='success')){
			wp_redirect( $response['redirect']);
		}
		else
		{		
		
			if($response->errors['error'][0]!='')
			{

				$error=urlencode($response->errors['error'][0]);
			}
			else if($response['status']=='error')
			{
				$error=urlencode($response['result']);
			}
				
			//wp_redirect($paymentClass->get_page_url() . '?payment_status=fail&error='.$error.'#donation-section');
			wp_redirect($paymentClass->get_page_referer_url() . '?payment_status=fail&error='.$error.'#donation-section');
		}

		exit;		
	}
	else if(isset($_REQUEST) && $_REQUEST['donation_action']=='donation_webhook_processing' )
	{			
		//to initialize open pay  hook, get verification_code from plugin *includes\logs\openpay_hook_xxxxxxx.log*		
		//$response = $paymentClass->process_log_openpay_hook();		
		$response = $paymentClass->process_webhook_payment();
		exit;
		
	}
	else if(isset($_REQUEST) && $_REQUEST['donation_action']=='donation_processing_secure' )
	{	

		$paymentClass->payment_loader();
		$response = $paymentClass->donation_processing_secure();
		exit;

	}
	else{
		return;
	}	

 }


function donation_processing_secure_callback(){		

		$paymentClass = new Donation_Gateway_Openpay(); 

		$response = $paymentClass->donation_processing_secure_callback();

		if(is_array($response) && ($response['status'] =='success')){
			
			wp_redirect( $response['redirect']);
		}
		else
		{		
		
			if($response->errors['error'][0]!='')
			{

				$error=urlencode($response->errors['error'][0]);
			}
			else if($response['status']=='error')
			{
				$error=urlencode($response['result']);
			}
				
			wp_redirect($paymentClass->get_page_url() . '?payment_status=fail&error='.$error.'#donation-section');
		}
		exit;		
}



function datatables_onetime_callback()
{	
	header("Content-Type: application/json");
	$request= $_GET; 

	 $columns = array( 
        0 => 'name', 
        1 => 'email',
        2 => 'order_id',
        3 => 'amount',
        4 => 'payment_date',
        5 => 'status'
    );

	$orderby = ''; 	
	if (isset($request['order'][0]['column'])) {         
        $orderby = $columns[$request['order'][0]['column']];         
    }

    if(isset($request['order'][0]['dir'])) {
    	$orderby =" ORDER BY ".$orderby.' '.$request['order'][0]['dir'];	
    }
    

    $limit = ''; 	
	if (isset($request['start']) && $request['length'] > 0)
	{         
        $limit = ' limit '.$request['start'].' , '.$request['length'];
    }
	
	$search = " 1=1 and type='One Time' ";        
    if( !empty($request['search']['value']) ) { // When datatables search is used
            $search .= " and ( name like '%".sanitize_text_field($request['search']['value'])."%'";
            $search .= "OR email like '%".sanitize_text_field($request['search']['value'])."%'";        
            $search .= "OR amount like '%".sanitize_text_field($request['search']['value'])."%') ";        
    }

    if(isset($request['columns'][4]['search']['value']) && $request['columns'][4]['search']['value']!='') {
    	  $search .= " and ( dph.status = '".sanitize_text_field($request['columns'][4]['search']['value'])."' )";
    }    

	global $wpdb;

  	$table_name=$wpdb->prefix.'donation_payment_history';
  	$table_name1=$wpdb->prefix.'donation_donors';

  	$query = "SELECT COUNT(*) FROM $table_name as dph left join $table_name1  as dd on dd.id=dph.donor_id";

	if($search)
  	{
  		$query .= ' Where '.$search;   				  	
  	} 
	
  	$paymentsSetTotal = $wpdb->get_var($query);	
	

  	$query="SELECT name,email,subscription_plan,amount,payment_date,dph.status,dph.order_id FROM $table_name as dph left join $table_name1  as dd on dd.id=dph.donor_id";
	
	if($search)
  	{
  		$query .= ' Where '.$search;   				  	
  	}


  	if($orderby)
  	{
  		$query .=$orderby;	
  	}

  	
  	if($limit)
  	{
  		$query .=$limit;
  	}  	

	$donorClass = new Donors();

  	$paymentsSet = $wpdb->get_results($query);
	$output=array();
  	foreach ($paymentsSet as $key => $payment) {
  		$payment_date = date('d/m/Y',strtotime($payment->payment_date));  		  		  		
		$donor_id = $donorClass->get_donor_id_by_email($payment->email);			  				  		
  		$data_link = get_admin_url().'admin.php?page=plugin-donation&donor_id='.$donor_id;
  		$name="<span data-id=\"{$donor_id}\" data-name=\"{$payment->name}\" data-link=\"{$data_link}\" ></span>";
  		//$name = $payment->name;
  		if($payment->status=='completed'){$payment->status='Completed';}
	  	$output[] = array($name,$payment->email,$payment->order_id,$payment->amount,$payment_date,$payment->status);
  		
  	}  	
	
	$json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => intval($paymentsSetTotal),
            "recordsFiltered" => intval($paymentsSetTotal),
            "data" => $output
        );

	
	echo json_encode($json_data);
	wp_die();
}

function datatables_subscription_callback()
{	
	header("Content-Type: application/json");
	$request= $_GET; 

	 $columns = array( 
        0 => 'name', 
        1 => 'email', 
        2 => 'order_id',
        3 => 'amount',
        4 => 'subscription_plan',
        5 => 'payment_date',
        6 => 'next_payment_date',
        7 => 'status'
    );

	$orderby = ''; 
	if (isset($request['order'][0]['column'])) {         
        $orderby = $columns[$request['order'][0]['column']];         
    }

    if(isset($request['order'][0]['dir'])) {
    	$orderby =" ORDER BY ".$orderby.' '.$request['order'][0]['dir'];	
    }

    $limit = ''; 	
	if (isset($request['start']) && $request['length'] > 0)
	{         
        $limit = ' limit '.$request['start'].' , '.$request['length'];
    }
	
	$search = " 1=1 and type='Subscription' ";        
    if( !empty($request['search']['value']) ) { // When datatables search is used
            $search .= " And ( name like '%".sanitize_text_field($request['search']['value'])."%'";
            $search .= " OR email like '%".sanitize_text_field($request['search']['value'])."%'";        
            $search .= " OR amount like '%".sanitize_text_field($request['search']['value'])."%') ";        
    }

    if(isset($request['columns'][6]['search']['value']) && $request['columns'][6]['search']['value']!='') {
    	  $search .= " and ( dph.status = '".sanitize_text_field($request['columns'][6]['search']['value'])."' )";
    }    

	global $wpdb;

  	$table_name=$wpdb->prefix.'donation_payment_history';
  	$table_name1=$wpdb->prefix.'donation_donors';

  	$query="SELECT count(*) FROM $table_name as dph left join $table_name1  as dd on dd.id=dph.donor_id";

  	if($search)
  	{
  		$query .= ' Where '.$search;   				  	
  	}  	

  	$paymentsSetTotal = $wpdb->get_var($query);	
	

  	$query="SELECT donor_id,name,email,subscription_plan,amount,payment_date,next_payment_date,dph.status ,dph.order_id FROM $table_name as dph left join $table_name1  as dd on dd.id=dph.donor_id";

	if($search)
  	{
  		$query .= ' Where '.$search;   				  	
  	}

  	if($orderby)
  	{
  		$query .= $orderby;	
  	}

  	if($limit)
  	{
  		$query .=$limit;
  	}
    
  	$paymentsSet = $wpdb->get_results($query);
	$output=array();
  	foreach ($paymentsSet as $key => $payment) {
  		$payment_date = date('d/m/Y',strtotime($payment->payment_date));
  		$next_payment_date = date('d/m/Y',strtotime($payment->next_payment_date));
  		$donor_id = $payment->donor_id;
  		$data_link = get_admin_url().'admin.php?page=plugin-donation&donor_id='.$donor_id;
  		$name="<span data-id=\"{$donor_id}\" data-name=\"{$payment->name}\" data-link=\"{$data_link}\" ></span>";
  		if($payment->status=='completed'){$payment->status='Completed';}
	  	$output[] = array($name,$payment->email,$payment->order_id,$payment->amount,$payment->subscription_plan,$payment_date,$next_payment_date,$payment->status);
  		
  	}
  	
	
	$json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => intval($paymentsSetTotal),
            "recordsFiltered" => intval($paymentsSetTotal),
            "data" => $output
        );

	
echo json_encode($json_data);
	wp_die();
}

function datatables_donors_callback()
{		
	$donorClass = new Donors();
	if($_GET['task']=='get_transaction_list')
	{
		$donorClass->get_transaction_list();	
	}		
	else if($_GET['task']=='cancel_subscription')
	{	
		$donorClass->cancel_subscription();	
	}
	else if($_GET['task']=='get_subscription_list')
	{	
		$donorClass->get_subscription_list();	
	}
	else if($_GET['task']=='donor_unsubscribe')
	{	
		$donorClass->donor_unsubscribe();	
	}
	else if($_GET['task']=='plugin_donation_donors')
	{	
		$donorClass->plugin_donation_donors();	
	}


}

function email_save_data()
{	
	$newsClass = new Emails();
	$newsClass->email_save_data();
}

function donation_install() {
	global $wpdb;
	global $donation_db_version;	
	
	$charset_collate = $wpdb->get_charset_collate();

	$table_name = $wpdb->prefix . 'donation_donors';

	$sql_1 = " CREATE TABLE IF NOT EXISTS `$table_name`(			
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
				`email` varchar(150) COLLATE utf8mb4_unicode_520_ci NOT NULL,
				`status` enum('Active','Deactive') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'Active',
				`customer_id` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
				`created_at` datetime DEFAULT NULL,
				`modified_at` datetime DEFAULT NULL,
				  PRIMARY KEY (`id`),
				  INDEX `idx_name_email` (`name`, `email`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=0;";


	$table_name = $wpdb->prefix . 'donation_payment_history';

	$sql_2 = " CREATE TABLE IF NOT EXISTS `$table_name` (				
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`order_id` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
				`donor_id` int(11) NOT NULL,
				`type` enum('Subscription','One Time') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'One Time',
				`subscription_plan` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
				`amount` decimal(10,2) DEFAULT NULL,
				`payment_date` datetime DEFAULT NULL,
				`next_payment_date` datetime DEFAULT NULL,
				`status` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
				`created_at` datetime DEFAULT NULL,
				`modified_at` datetime DEFAULT NULL,
				PRIMARY KEY (`id`),
				KEY `idx_donor_id` (`donor_id`),
				KEY `idx_subscription_id` (`subscription_plan`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=0;";

	$table_name = $wpdb->prefix . 'donation_subscriptions';

	$sql_3 =" CREATE TABLE IF NOT EXISTS `$table_name`  (

				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `donor_id` int(11) DEFAULT NULL,
				  `customer_id` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
				  `subscription_id` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
				  `plan_id` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
				  `amount` decimal(10,2) DEFAULT NULL,
				  `status` varchar(50) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
				  `cancel_at` datetime DEFAULT NULL,
				  `created_at` datetime DEFAULT NULL,
				  `modified_at` datetime DEFAULT NULL,
				  PRIMARY KEY (`id`),
				  KEY `idx_donor_id` (`donor_id`),
				  KEY `idx_subscription_id` (`subscription_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=0;";

	$table_name = $wpdb->prefix . 'donation_payment_log';

	$sql_4 =" CREATE TABLE IF NOT EXISTS `$table_name` (			
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`order_id` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT '0',
			`donor_id` int(11) NOT NULL,
			`subscription_id` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
			`transaction_id` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
			`request_id` varchar(150) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
			`description` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
			`subscription_plan` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
			`amount` decimal(10,2) DEFAULT NULL,
			`status` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
			`log` text COLLATE utf8mb4_unicode_520_ci,
			`created_at` datetime DEFAULT NULL,
			`modified_at` datetime DEFAULT NULL,
			PRIMARY KEY (`id`),
			KEY `idx_donor_id` (`donor_id`),
			KEY `idx_subscription_id` (`subscription_id`),
			KEY `idx_payment_history_id` (`order_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci AUTO_INCREMENT=0;";

	$table_name = $wpdb->prefix . 'donation_emails';

	$sql_5 =" CREATE TABLE IF NOT EXISTS `$table_name` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`name` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
				`subject` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
				`message` text COLLATE utf8mb4_unicode_520_ci,
				`type` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
				`status` enum('Active','Deactive') COLLATE utf8mb4_unicode_520_ci DEFAULT 'Active',
				`created_at` datetime DEFAULT NULL,
				`modified_at` datetime DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;";
	
	$sql_5_1 =" INSERT INTO `w0lap_donation_emails` (`id`, `name`, `subject`, `message`, `type`, `status`, `created_at`, `modified_at`) VALUES
		(1, 'Payment Failure', 'Donation is failure. - Cáritas de Monterrey', 'Dear {{name}} <br/> ,\r\nYour donation could not be done.<br/>Here is Donation Ref. No:{{order_id}}<br/>Donation Amount:{{amount}} MXN<br/>Date:{{date}}<br/>Sorry for incovenience, You can try it again.<br/>Error Message:{{error_message}}<br/>Feel free to talk with Us.<br/>- Thanks and Regards<br/>  Cáritas de Monterrey', 'payment_failure', 'Active', '2018-06-29 17:23:34', '2018-07-01 20:18:56'),

		(2, 'Payment Success', 'Your donation is successfully done. - Cáritas de Monterrey', 'Dear {{name}} <br/> ,\r\nYour donation is successfully done.<br/>Here is Donation Ref. No:{{order_id}}<br/>Donation Amount:{{amount}} MXN<br/>Date:{{date}}<br/>Feel free to talk with Us.<br/>- Thanks and Regards<br/>  Cáritas de Monterrey', 'payment_success', 'Active', '2018-06-29 17:23:34', '2018-07-01 20:18:56'),

		(3, 'Payment Subscription', 'Thank you for kind support. - Cáritas de Monterrey', 'Dear {{name}} <br/> ,\r\nYour donation is successfully done.<br/>Here is Donation Ref. No:{{order_id}}<br/>Donation Amount:{{amount}} MXN<br/>Date:{{date}}<br/>Donation Type : Subscription<br/>Next Payment Date:{{next_payment_date}}<br/>Feel free to talk with Us.<br/>- Thanks and Regards<br/>  Cáritas de Monterrey', 'payment_subscription', 'Active', '2018-06-29 17:26:51', '2018-07-01 20:18:56'),

		(4, 'Payment Subscription Cancel', 'Cancel subscription. - Cáritas de Monterrey', 'Dear {{name}} <br/> ,\r\nYour donation subscription is cancelled successfully.<br/>Donation Amount:{{amount}} MXN<br/>Cancel Date:{{cancel_date}}<br/>Feel free to talk with Us.<br/>- Thanks and Regards<br/>  Cáritas de Monterrey', 'payment_subscription_cancel', 'Active', '2018-06-29 17:27:58', '2018-07-01 20:18:56'),

		(5, 'Payment Subscription Cancel Request', 'Request for cancel subscription. - Cáritas de Monterrey', 'Dear Admin <br/> ,\r\nYou have new cancel subscription request.<br/>Donor Email:{{email}} <br/>Request Date:{{date}}<br/>Please look into this asap.<br/>- Thanks and Regards<br/>  Cáritas de Monterrey', 'payment_subscription_cancel_request', 'Active', '2018-07-01 01:47:15', '2018-07-01 20:18:56');";
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql_1 );
	dbDelta( $sql_2 );
	dbDelta( $sql_3 );
	dbDelta( $sql_4 );
	dbDelta( $sql_5 );
	dbDelta( $sql_5_1 );

	add_option( 'donation_db_version', $donation_db_version );
}

register_activation_hook( __FILE__, 'donation_install' );

// plugin deactivation
register_deactivation_hook( __FILE__, 'donation_deactivate' );
function donation_deactivate() {}

// plugin uninstallation
register_uninstall_hook( __FILE__, 'donation_uninstall' );

function donation_uninstall($options=array()) {
	global $wpdb, $options;
	
	
	$table_name = $wpdb->prefix . 'donation_donors';
	$sql_1 = " DROP TABLE IF EXISTS `$table_name`; ";

	$table_name = $wpdb->prefix . 'donation_payment_history';	
	$sql_2 = " DROP TABLE IF EXISTS `$table_name`; ";

	$table_name = $wpdb->prefix . 'donation_subscriptions';	
	$sql_3 = " DROP TABLE IF EXISTS `$table_name`; ";

	$table_name = $wpdb->prefix . 'donation_payment_log';
    $sql_4 = " DROP TABLE IF EXISTS `$table_name`; ";

    $table_name = $wpdb->prefix . 'donation_emails';
    $sql_5 = " DROP TABLE IF EXISTS `$table_name`; ";
    
    $wpdb->query($sql_1);
    $wpdb->query($sql_2);
    $wpdb->query($sql_3);
    $wpdb->query($sql_4);
    $wpdb->query($sql_5);

    delete_option("donation_db_version");

	foreach ( $options as $option ) {
		// Option must have an ID
		if ( !isset( $option['id'] ) ) continue;
		// Prepare value		
		delete_option( 'plugin_donation_' . $option['id'] );
	}
    
}

/*
 To remove test data ajax-call from admin donation plugin.
*/

function datatables_onetime_delete() {
	global $wpdb;	
	return;
	
	$table_name = $wpdb->prefix . 'donation_donors';
	$sql_1 = " Delete from `$table_name` where  created_at > '2018-09-25 00:00:00' ;  ";

	$table_name = $wpdb->prefix . 'donation_payment_history';	
	$sql_2 = " Delete from `$table_name` where  created_at > '2018-09-25 00:00:00' ; ";

	$table_name = $wpdb->prefix . 'donation_payment_log';
 	$sql_3 = " Delete from `$table_name` where  created_at > '2018-09-25 00:00:00' ;  ";  
    
 	$wpdb->query($sql_1);
 	$wpdb->query($sql_2);
 	$wpdb->query($sql_3);    
    
}