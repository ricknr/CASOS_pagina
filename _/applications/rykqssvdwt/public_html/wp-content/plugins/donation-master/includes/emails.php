<?php

if (!defined('ABSPATH')) {
    exit;
}

if ( !class_exists( 'Newsletters' ) ) {	

	/**
	 * donors
	 *
	 * @author  Vladimir Anokhin <http://gndev.info/>
	 * @license MIT
	 */
	class Emails{
		use Utils;
		/** @var array Class config */
		var $config = array();

		/**
		 * Constructor
		 *
		 * @param array Class settings
		 */
		function __construct( ) {}

		public function get_newsletters_list ()
		{
			header("Content-Type: application/json");
			$request= $_GET; 

			 $columns = array( 
		        0 => 'name', 
		        1 => 'type',
		        1 => 'created_at',
		        
		    );

			$orderby = ''; 
			if (isset($request['order'][0]['column'])) {         
		        $orderby = $columns[$request['order'][0]['column']];         
		    }

		    if(isset($request['order'][0]['dir'])) {
		    	$orderby =" ORDER BY ".$orderby.' '.$request['order'][0]['dir'];	
		    }

			$recordsFiltered ='';
		    if(isset($request['length'])) {
		    	$recordsFiltered = $request['length'];
		    }

			$search =' 1=1 ';			
		    if( !empty($request['search']['value']) )
		    { // When datatables search is used
		            $search .= " And ( name like '%".sanitize_text_field($request['search']['value'])."%'";
		            $search .= "OR subject like '%".sanitize_text_field($request['search']['value'])."%'";        
		            $search .= "OR message like '%".sanitize_text_field($request['search']['value'])."%') ";        
		    }

		    if($_GET['id'])
		  	{		  		
		  		$search .= ' And id ='. $_GET['id'];		  			
		  	}
		  	

			global $wpdb;

		  	$table_name=$wpdb->prefix.'donation_emails';
		  	$query="SELECT * FROM $table_name ";

		  	if($search)
		  	{
		  		$query .= ' Where '.$search;   				  	
		  	}

		  	if($orderby)
		  	{
		  		$query .=$orderby;	
		  	}		

		  	$newsLettesSet = $wpdb->get_results($query);        
		  	
			$output=array();
		  	foreach ($newsLettesSet as $key => $news)
		  	{

		  		$created_at = $this->date_formatter($news->created_at);
		  		$modified_at = $this->date_formatter($news->modified_at);
		  		$name="<span data-id=\"{$news->id}\" data-name=\"{$news->name}\" data-link=\"{$data_link}\" ></span>";
			  	$output[] = array($news->name,$news->type,$news->status,$news->created_at,$news->modified_at);
		  		
		  	}		  	
			
			$json_data = array(
		            "draw" => intval($request['draw']),
		            "recordsTotal" => intval(count($paymentsSubsSet)),
		            "recordsFiltered" =>($recordsFiltered!='')?$recordsFiltered:intval(10),
		            "data" => $output
		        );

			
			echo json_encode($json_data);
			wp_die();


		}

		public function email_save_data ()
		{		
			global $wpdb;
			if(isset($_POST))
			{	$status='';
				foreach ($_POST['data'] as $key => $value)
				{					
					$table_name = $wpdb->prefix.'donation_emails';
			        $time = current_time( 'mysql' );
			        $format =  array();
			        $message = htmlentities($value['message']);
			        $wpdb->update($table_name,array('subject'=>$value['subject'],'message'=>$message,'modified_at'=>$time),array('id'=>$key),$format);

			        
			        if($wpdb->last_error !== '')
			        {            
			            $msg = $wpdb->print_error();				            
			            $status = 'error';
			            break;
			        }			        

				}
			}

		  	if($status=='error')
		  	{
		  		$return_data = array('status'=>'error','msg'=>'Emails could not be saved.');	
		  	}
		  	else
		  	{
		  		$return_data = array('status'=>'success','msg'=>'Emails have been saved.');	
		  	}			

			echo json_encode($return_data);
			wp_die();

		}

	}	

}