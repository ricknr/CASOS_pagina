<?php

if($_GET['donor_id'])
{
	global $wpdb;
    $wpdb->show_errors();
    $table_name=$wpdb->prefix.'donation_donors';    
    $donorSet = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE id = '%d'",$_GET['donor_id']));

?>   
<div class="pri_container">
	<div class="pri_left" >
		<h2>Primary Information:</h2>
		<div class="pri_info_box">
			<table cellspacing="5" cellpadding="10" style="border-collapse: collapse;" >
				<tr><td><b>Name</b></td><td>:</td><td><?php echo $donorSet[0]->name;?></td></tr>
				<tr><td><b>Email</b></td><td>:</td><td><?php echo $donorSet[0]->email;?></td></tr>
				<tr><td><b>Status</b></td><td>:</td><td><?php echo $donorSet[0]->status;?></td></tr>
				<tr><td><b>Created At</b></td><td>:</td><td><?php echo date('d/m/Y',strtotime($donorSet[0]->created_at));?></td></tr>				
			</table>
		</div>	
	</div>	
	<div class="pri_right">	
		<button align="right" id="cancel_subscription" name="cancel_subscription" class="button action btn_cancel hidden" value="Cancel Subscription" onclick="cancel_subscription(<?php echo $donorSet[0]->id;?>,'sngc8xaj2agnjepapjq9');">Cancel Subscription</button>	
	</div>	
</div>
<br/>
<?php } ?>
 
<h2>Donor's Subscriptions:</h2>
<table id="donor_subscription_table" class="display stripe" style="width:100%">
	<thead>
	    <tr>
	        <th>Subscription Plan</th>
	        <th>Plan Id</th>
	        <th>Subscription Id</th>
	        <th>Amount</th>		                
	        <th>Status</th>
	        <th>Created At</th>
	        <th>Cancellation</th>
	    </tr>
	</thead>	
</table>
<br/>
<h2>Donation Transactions:</h2>
<table id="donor_table" class="display stripe" style="width:100%">
	<thead>
	    <tr>
	        <th>Full Name</th>
	        <th>Email</th>		                
	        <th>Donation Ref. No</th>
	        <th>Amount</th>		                
	        <th>Payment Date</th>		                
	        <th>Subscription Plan</th>
            <th>Next Payment Date</th>
            <th>Status </th>
	        <th>Donation From Page</th>
	    </tr>
	</thead>
	<tfoot>
    <tr>
        <th>Full Name</th>
        <th>Email</th>		                
        <th>Donation Ref. No</th>
        <th>Amount</th>		                
        <th>Payment Date</th>		                
        <th>Subscription Plan</th>
        <th>Next Payment Date</th>
        <th>Status</th>
        <th>Donation From Page</th>
    </tr>
	</tfoot>
</table>

		    			
