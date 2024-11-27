<?php

if (!defined('ABSPATH')) {
    exit;
}

if ( !class_exists( 'Donors' ) ) {	

	/**
	 * donors
	 *
	 * @author  Vladimir Anokhin <http://gndev.info/>
	 * @license MIT
	 */
	class Donors{
		use Utils;
		/** @var array Class config */
		var $config = array();

		/**
		 * Constructor
		 *
		 * @param array Class settings
		 */
		function __construct( ) {}

		public function get_transaction_list ()
		{			
			header("Content-Type: application/json");
			$request= $_GET; 

			 $columns = array( 
		        0 => 'name', 
		        1 => 'email',
		        1 => 'order_id',
		        2 => 'amount',
		        3 => 'payment_date',
		        4 => 'subscription_plan',
		        5 => 'next_payment_date',
		        6 => 'status'
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

			$search =' 1=1 ';			
		    if( !empty($request['search']['value']) )
	    	{ 	// When datatables search is used
	            $search .= " And ( name like '%".sanitize_text_field($request['search']['value'])."%'";
	            $search .= " OR email like '%".sanitize_text_field($request['search']['value'])."%'";        
	            $search .= " OR amount like '%".sanitize_text_field($request['search']['value'])."%'";        
	            $search .= " OR subscription_plan like '%".sanitize_text_field($request['search']['value'])."%'";        
	            $search .= " OR order_id like '%".sanitize_text_field($request['search']['value'])."%'";        
	            $search .= " OR dph.status like '%".sanitize_text_field($request['search']['value'])."%') ";        
		    }

		    if($_GET['donor_id'])
		  	{		  		
		  		$search .= ' And dph.donor_id ='. $_GET['donor_id'];		  			
		  	}		  	

			global $wpdb;

		  	$table_name=$wpdb->prefix.'donation_payment_history';
		  	$table_name1=$wpdb->prefix.'donation_donors';

		  	$query="SELECT count(*) FROM $table_name as dph left join $table_name1  as dd on dd.id=dph.donor_id";

		  	if($search)
		  	{
		  		$query .= ' Where '.$search;   				  	
		  	}

		  	$donorSetTotal = $wpdb->get_var($query);


		  	$query="SELECT name,email,order_id,subscription_plan,amount,payment_date,next_payment_date,dph.status FROM $table_name as dph left join $table_name1  as dd on dd.id=dph.donor_id";

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
		    
		  	$donorsSubsSet = $wpdb->get_results($query);
			$output=array();
		  	foreach ($donorsSubsSet as $key => $donor) 
		  	{		  		
		  		
		  		$payment_date = $this->date_formatter($donor->payment_date);
		  		$next_payment_date = $this->date_formatter($donor->next_payment_date);		  	
		  		
		  		if($donor->subscription_plan=='')
		  		{
		  			$donor->subscription_plan='-';

		  		}	
		  		if($next_payment_date=='')
		  		{
		  			$next_payment_date='-';
		  		}

			  	$output[] = array($donor->name,$donor->email,$donor->order_id,$donor->amount,$payment_date,$donor->subscription_plan,$next_payment_date,$donor->status);
		  		
		  	}		  	
			
			$json_data = array(
		            "draw" => intval($request['draw']),
		            "recordsTotal" => intval($donorSetTotal),
		            "recordsFiltered" =>intval($donorSetTotal),
		            "data" => $output
		        );

			
			echo json_encode($json_data);
			wp_die();


		}

		public function get_subscription_list ()
		{		
			header("Content-Type: application/json");
			$request= $_GET; 

			 $columns = array( 
		        0 => 'subscription_plan', 
		        1 => 'subscription_id',
		        2 => 'amount',
		        3 => 'status',
		        4 => 'created_at'
		        
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

			
			$search =' 1=1 ';			
		    if( !empty($request['search']['value']) )
		    { // When datatables search is used
		            $search .= " And ( amount like '%".sanitize_text_field($request['search']['value'])."%'";
		            $search .= "OR status like '%".sanitize_text_field($request['search']['value'])."%'";        
		            $search .= "OR subscription_id like '%".sanitize_text_field($request['search']['value'])."%') ";
		                    
		    }

		    if($_GET['donor_id'])
		  	{		  		
		  		$search .= ' And donor_id ='. $_GET['donor_id'];		  			
		  	}
		  	

			global $wpdb;

		  	$table_name=$wpdb->prefix.'donation_subscriptions';		  	
		  	$query="SELECT count(*) FROM $table_name ";

		  	if($search)
		  	{
		  		$query .= ' Where '.$search;   				  	
		  	}


		  	$donorSubsSetTotal = $wpdb->get_var($query);

		  	$table_name=$wpdb->prefix.'donation_subscriptions';		  	
		  	$query="SELECT donor_id,subscription_id,plan_id,customer_id,''as subscription_plan,amount,status,cancel_at,created_at FROM $table_name ";


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

			$paymentClass = new Donation_Gateway_Openpay();			
			
		  	$donorsSubsSet = $wpdb->get_results($query);
			$output=array();
		  	foreach ($donorsSubsSet as $key => $donor) {		  		
		  		$payment_date = $this->date_formatter($donor->payment_date);

		  		$subscription_plan = $paymentClass->getSubscriptionPlan($donor->plan_id);	  		  	
		  		
		  		if($subscription_plan=='')
		  		{
		  			$subscription_plan='-';
		  		}	
		  		
		  		if($donor->status=='active')
		  		{
		  			$action='<button id="cancel_subs_'.$donor->subscription_id.'" class="button action btn_cancel" onclick="cancel_subscription('.$donor->donor_id.',\''.$donor->subscription_id.'\')">Cancel Subscription</button>';
		  		}
		  		else
		  		{
		  			$action=$this->date_formatter($donor->cancel_at);
		  		}

		  		$created_at = $this->date_formatter($donor->created_at);

			  	$output[] = array($subscription_plan,$donor->plan_id,$donor->subscription_id,$donor->amount,$donor->status,$created_at,$action);
		  		
		  	}		  	
			
			$json_data = array(
		            "draw" => intval($request['draw']),
		            "recordsTotal" => intval($donorSubsSetTotal),
		            "recordsFiltered" => intval($donorSubsSetTotal),
		            "data" => $output
		        );
			
			echo json_encode($json_data);
			wp_die();

		}


		public function get_donor_id_by_email( $email='' )
	    {
	        global $wpdb;

	        $wpdb->show_errors();
	        $table_name=$wpdb->prefix.'donation_donors';
	        
	        $donor_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM $table_name WHERE email = '%s'",$email));	        
			
	        if($donor_id)
	        {
	            return $donor_id;
	        }else{
	            return 0;
	        }
	   }
	   

	   public function cancel_subscription()
	   {	
			$paymentClass = new Donation_Gateway_Openpay();			
			global $wpdb;
	        $customerData = array();        
	        $return_data = array();
	        if(!$_GET['subscription_id']){
	        	$return_data = array('status'=>'error','msg'=>'Subscription is not found.'
						);
				echo json_encode($data);
				exit;
	        }
	        else
	        {
	        	$subscription_id = $_GET['subscription_id'];
	        	$donor_id = $_GET['donor_id'];
	        }	       	

	        $customer_id=$paymentClass->get_customer_id($donor_id,$subscription_id);	        

	        if($customer_id)
	        {
	        	$response = $paymentClass->openpay_request($customerData, "/customers/{$customer_id}/subscriptions/{$subscription_id}",'DELETE');        

				if (!isset($response->error_code))
				{

					 	$table_name=$wpdb->prefix.'donation_subscriptions';
				        $time = current_time( 'mysql' );
				        $format =  array();
				        $wpdb->update($table_name,array('status'=>'cancel','cancel_at'=>$time,'modified_at'=>$time),array('subscription_id'=>$subscription_id),$format);

				        
				        if($wpdb->last_error !== '')
				        {            
				            $msg = $wpdb->print_error();				            
				        }
				        else
				        {
				       	 	$msg = 'Subscription is cancelled, Successfully.'; 
				        }				        

				        $table_name1=$wpdb->prefix.'donation_donors';				        

				        $subscriptionSet = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name as ds left join $table_name1  as dd on dd.id=ds.donor_id WHERE subscription_id = '%s' ",$subscription_id));        
					        
				        if($subscriptionSet[0]->id)
				        {	
		        			$subscription_plan =  $paymentClass->getSubscriptionPlan($subscriptionSet[0]->plan_id);	
		       				
		       				$amount = $subscriptionSet[0]->amount;
					        $email_data['subscription_plan'] = $subscription_plan;
					        $email_data['amount'] = $amount;
					        $email_data['email'] = $subscriptionSet[0]->email;
					        $email_data['name'] = $subscriptionSet[0]->name;					        
					        $email_data['cancel_at'] = $this->date_formatter($subscriptionSet[0]->cancel_at);
						
					        $this->send_mail('payment_subscription_cancel',$email_data);				        
				    	}

						$return_data = array('status'=>'success','msg'=>$msg);					

				}

		   		if($response->error_code)
                {
                    $msg = "Subscription did not cancel or already cancelled, Please confirm.";                
               		$return_data = array('status'=>'error','msg'=>$msg);

                }                

	        }
	        else
	        {
	        	$return_data = array('status'=>'error','msg'=>'Customer does not exists.');
	        }

	        echo json_encode($return_data);
	        exit;
	        
		}

		public function donor_unsubscribe()
		{
			header("Content-Type: application/json");
			$email_data = array();
			$email_data['email'] = $_GET['email'];
			$email_data['admin_email'] = get_bloginfo('admin_email'); 
	        $this->send_mail('payment_subscription_cancel_request',$email_data);
	        $return_data = array('status'=>'success','msg'=>'La solicitud ha sido enviada al administrador.');
			echo json_encode($return_data);
		    exit;
		}	

	}
	
}