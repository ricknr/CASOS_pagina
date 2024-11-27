<?php
	global $wpdb;
    $wpdb->show_errors();
    $table_name=$wpdb->prefix.'donation_emails';    
    $emailSet = $wpdb->get_results("SELECT * FROM $table_name");
?>
<div class="donation_emails_container"style="display:block;">
	<div style="float:left;width:50%">	
		<form id="donation_email_form" name="donation_email_form"  action="" onsubmit="return false;">
			<table id="donation_emails" class="display stripe" style="width:100%">    
				<?php foreach ($emailSet as $key => $emails) {?>
									
			        <tr>
				        <td width="30%" colspan="3"><h3><?php echo $emails->name; ?></h3></td>
				    </tr>   	 
				    <tr>
				        <td width="10%"><b>Subject</b></td><td width="2%">:</td><td width="60%"><input width="100%" type="text" name="<?php echo 'data['.$emails->id.'][subject]';?>" id="<?php echo 'data['.$emails->id.'][subject]';?>" value="<?php echo $emails->subject; ?>" /></td>
				    </tr>    
				    <tr><td colspan="3">&nbsp;</tr>
				    <tr>
				        <td width="10%"><b>Message</b></td><td width="2%">:</td><td width="60%"><textarea type="text" name="<?php echo 'data['.$emails->id.'][message]';?>" id="<?php echo 'data['.$emails->id.'][message]';?>"><?php echo stripslashes($emails->message); ?></textarea></td>
				    </tr>

				<?php } ?>
					<tr>
				        <td width="10%"></td><td width="2%"></td><td width="60%">
				        	<button class="button" id="save_donation_button" name="save_donation_button">Save Emails</button></td>
				    </tr>
				</tfoot>	
			</table>
		</form>
	</div>
	<div style="width:10%;float:left;">
		&nbsp;
	</div>
	<div style="float:right;width:40%;">
		<div style="width:100%;margin:10px;padding:10px;">
			<h3>Email Field</h3>
			<br/>
			<i>- Use to set in mail Message area.</i>
		</div>
		<div style="width:80%;margin:10px;padding:10px;display: inline-flex;background-color:#ffffff;">
			<div style="width:100%;display: inline-flex;text-align: center;">
				<table id="donation_emails" class="display stripe" style="width:100%;text-align: left;"> 
					<tr><td width="30%">{{name}}</td><td width="30%">{{email}}</td><td width="30%">{{amount}}</td></tr>
					<tr><td></td></tr>
					<tr><td width="30%">{{order_id}}</td><td width="30%">{{date}}</td><td width="30%">{{cancel_date}}</td></tr>
					<tr><td></td></tr>
					<tr><td width="30%">{{next_payment_date}}</td><td width="30%">{{error_message}}</td><td width="30%"></td></tr>
					
				</table>   
				
			</div>
		</div>		
	</div>
</div>
<style type="text/css">
	.donation_emails_container textarea,.donation_emails_container input
	{
		width: 100%;
	}
	.donation_emails_container textarea
	{
		height: 200px;
	}
</style>

