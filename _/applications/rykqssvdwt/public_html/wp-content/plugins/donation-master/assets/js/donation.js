// Wait DOM
jQuery(document).ready(function ($) {

	// ########## Tabs ##########

	// Nav tab click
	$('#donation-tabs span').click(function (event) {
		// Hide tips
		$('.donation-spin, .donation-success-tip').hide();
		// Remove active class from all tabs
		$('#donation-tabs span').removeClass('nav-tab-active');
		// Hide all panes
		$('.donation-pane').hide();
		// Add active class to current tab
		$(this).addClass('nav-tab-active');
		// Show current pane				
		//$('.donation-pane:eq(' + $(this).index() + ')').fadeIn(300);		
		//console.log(jQuery(this).data('id'));

		$('#'+jQuery(this).data('id')).fadeIn(300);		
 			
 			if(jQuery(this).data('id')=='onetime'){
 				
			$('#'+jQuery(this).data('id')+'_table').dataTable( {
					'processing': true,
					'serverSide': true,
					'destroy': true,
					'paging': true,
					'info':true,
					'stateSave':false,										
					'regex':false,
					'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],					
					'order': [[4, 'desc']],
					'ajax': donation.ajax_url+'?action=onetime_payment',
					"columnDefs": [ // Defines column for the output table
	                    { "targets": 0,  // Attribute of item in collection                    
	                        "orderable": false,
	                        "searchable": false,
	                        "render": function(data,type,row,meta) { // render event defines the markup of the cell text 
							 var _data = data;
                                 _donor_id = $(_data).data('id');
                                 _donor_name = $(_data).data('name');
                                 _donor_link = $(_data).data('link');	                            
	                            return "<a href=\""+ decodeURIComponent(_donor_link) + "\">" + _donor_name + "</a>";
	                        }
	                    }
            		],            		
             		initComplete: function () {

             				var filter_1 = '<div class="dataTables_filter_status" id="dataTables_filter_status"><label><font style="vertical-align: inherit;">Status:</font>&nbsp;&nbsp;<select name="onetime_table_filter_status" id="onetime_table_filter_status" aria-controls="onetime_table" class=""><option value="" data-column="4" ></option><option value="Pending" data-column="4" >Pending</option><option value="failed" data-column="4">Failed</option><option value="completed" data-column="4">Completed</option><option value="charge_pending" data-column="4">Charge Pending</option><option value="cancelled" data-column="4">Cancelled</option><option value="in_progress" data-column="4">In Progress</option></select></label></div>';
             				$('#onetime_table_filter').append(filter_1);
             				$('#onetime_table_filter_status').on( 'change', function () {   
	     						var i= $(this).find('option:selected').attr('data-column');
	     						var v= $(this).find('option:selected').val();	     					
	     						filterColumn('onetime_table', i, v );
					         
					     });


             		 }
				    
				});



 			}
 			else if(jQuery(this).data('id')=='subscription'){
 				
	 			$('#'+jQuery(this).data('id')+'_table').dataTable( {
					'processing': true,
					'serverSide': true,
					'destroy': true,
					'paging': true,
					'info':true,
					'stateSave':false,										
					'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],					
					'order': [[5, 'desc']],
					'ajax': donation.ajax_url+'?action=subscription_payment',
					"columnDefs": [ // Defines column for the output table
	                    { "targets": 0,  // Attribute of item in collection                    
	                        "orderable": false,
	                        "searchable": false,
	                        "render": function(data,type,row,meta) { // render event defines the markup of the cell text 
							 var _data = data;
                                 _donor_id = $(_data).data('id');
                                 _donor_name = $(_data).data('name');
                                 _donor_link = $(_data).data('link');
	                            
	                            return "<a href=\""+ decodeURIComponent(_donor_link) + "\">" + _donor_name + "</a>";
	                        }
	                    }
            		],
        			initComplete: function (){         				
         				var filter_1 = '<div class="dataTables_filter_status" id="dataTables_filter_status"><label><font style="vertical-align: inherit;">Status:</font>&nbsp;&nbsp;<select name="subscription_table_filter_status" id="subscription_table_filter_status" aria-controls="onetime_table" class=""><option value="" data-column="6" ></option><option value="Pending" data-column="6" >Pending</option><option value="failed" data-column="6">Failed</option><option value="completed" data-column="6">Completed</option><option value="charge_pending" data-column="6">Charge Pending</option><option value="cancelled" data-column="6">Cancelled</option><option value="in_progress" data-column="6">In Progress</option></select></label></div>';
         				$('#subscription_table_filter').append(filter_1);
         				$('#subscription_table_filter_status').on( 'change', function () {         					
     						var i= $(this).find('option:selected').attr('data-column');
     						var v= $(this).find('option:selected').val();	     					
     						filterColumn('subscription_table', i, v );
				         
				     });


         		 }
					
				});
				
 			}
 				

		// Save tab to cookies
		createCookie(pagenow + '_last_tab', $(this).index(), 365);
	});


	if($('#donor_table').length)
	{	

		var urlParams = new URLSearchParams(window.location.search);
		var donor_id = urlParams.get('donor_id');

		$('#donor_table').dataTable( {
			'processing': true,
			'serverSide': true,
			'destroy': true,
			'paging': true,
			'info':true,
			'stateSave':true,										
			'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],					
			'ajax': donation.ajax_url+'?action=donors_transaction&task=get_transaction_list&donor_id='+donor_id
		});

	}

	if($('#donor_subscription_table').length)
	{	

		var urlParams = new URLSearchParams(window.location.search);
		var donor_id = urlParams.get('donor_id');

		$('#donor_subscription_table').dataTable( {
			'processing': true,
			'serverSide': true,
			'destroy': true,
			'paging': true,
			'info':true,
			'stateSave':true,										
			'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],					
			'ajax': donation.ajax_url+'?action=donors_transaction&task=get_subscription_list&donor_id='+donor_id,
			"columnDefs": [ // Defines column for the output table
	                    { "targets": 6,  // Attribute of item in collection                    
	                        "orderable": false,
	                        "searchable": false	                        
	                    }
            		]
		});

	}

	// Auto-open tab by link with hash
	if (strpos(document.location.hash, '#tab-') !== false) $('#donation-tabs span:eq(' + document.location.hash.replace('#tab-', '') + ')').trigger('click');
	// Auto-open tab by cookies
	else if (readCookie(pagenow + '_last_tab') != null) $('#donation-tabs span:eq(' + readCookie(pagenow + '_last_tab') + ')').trigger('click');
	// Open first tab by default
	else $('#donation-tabs span:eq(0)').trigger('click');


	// ########## Ajaxed form ##########

	$('#donation-form').ajaxForm({
		beforeSubmit: function() {
			$('.donation-success-tip').hide();
			$('.donation-spin').fadeIn(200);
			$('.donation-submit').attr('disabled', true);
			$('.donation-notice').fadeOut(400);
		},
		success: function() {
			$('.donation-spin').hide();
			$('.donation-success-tip').show();
			setTimeout(function() {
				$('.donation-success-tip').fadeOut(200);
			}, 2000);
			$('.donation-submit').attr('disabled', false);
		}
	});


	// ########## Reset settings confirmation ##########

	$('.donation-reset').click(function () {
		if (!confirm($(this).attr('title'))) return false;
		else return true;
	});

	// ########## Color picker ##########

	$('.donation-color-picker').each(function (i) {
		$(this).find('.donation-color-picker-wheel').filter(':first').farbtastic('.donation-color-picker-value:eq(' +
			i + ')');
		$(this).find('.donation-color-picker-value').focus(function () {
			$('.donation-color-picker-wheel:eq(' + i + ')').show();
		});
		$(this).find('.donation-color-picker-value').blur(function () {
			$('.donation-color-picker-wheel:eq(' + i + ')').hide();
		});
		$(this).find('.donation-color-picker-button').click(function (e) {
			$('.donation-color-picker-value:eq(' + i + ')').focus();
			e.preventDefault();
		});
	});

	// ########## Media manager ##########

	// $('.donation-media-button').each(function () {
	// 	var $button = $(this),
	// 		$val = $(this).parents('.donation-media').find('input:text'),
	// 		file;
	// 		$button.on('click', function (e) {
	// 			e.preventDefault();
	// 			// If the frame already exists, reopen it
	// 			if (typeof (file) !== 'undefined') file.close();
	// 			// Create WP media frame.
	// 			file = wp.media.frames.customHeader = wp.media({
	// 				// Title of media manager frame
	// 				title: donation.media_title,
	// 				button: {
	// 					//Button text
	// 					text: donation.media_insert
	// 				},
	// 				// Do not allow multiple files, if you want multiple, set true
	// 				multiple: false
	// 			});
	// 			//callback for selected image
	// 			file.on('select', function () {
	// 				var attachment = file.state().get('selection').first().toJSON();
	// 				$val.val(attachment.url).trigger('change');
	// 			});
	// 		// Open modal
	// 		file.open();
	// 	});
	// });

	// ########## Image radio ##########

	// $('.donation-image-radio').each(function () {
	// 	var $this = $(this),
	// 		$options = $this.find('a'),
	// 		$value = $this.find('input');
	// 	// Image click
	// 	$options.on('click', function (e) {
	// 		// Remove selected class from all options
	// 		$options.removeClass('donation-image-radio-selected');
	// 		// Add selected class to the current option
	// 		$(this).addClass('donation-image-radio-selected');
	// 		// Set new value
	// 		$value.val($(this).data('value'));
	// 		e.preventDefault();
	// 	});
	// 	// Activate selected image
	// 	$options.filter('[data-value="' + $value.val() + '"]').addClass('donation-image-radio-selected');
	// });

	// ########## Cookie utilities ##########

	function createCookie(name, value, days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			var expires = "; expires=" + date.toGMTString()
		} else var expires = "";
		document.cookie = name + "=" + value + expires + "; path=/"
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') c = c.substring(1, c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length)
		}
		return null
	}

	// ########## Strpos tool ##########

	function strpos(haystack, needle, offset) {
		var i = haystack.indexOf(needle, offset);
		return i >= 0 ? i : false;
	}

	$('#save_donation_button').on('click', function(event) {
       
        event.preventDefault();

		$(this).html('Processing ...');
		$.ajax({
		  type: "POST",
		  url: donation.ajax_url+'?action=save_emails',
		  data: $('#donation_email_form').serialize(),
		  cache: false,
		  success: function(result){		     	
		     	var res_json_obj = JSON.parse(result);		     	
		     	alert(res_json_obj.msg);		     	
		     	if(res_json_obj.status=='success')
		     	{		     
		     		$('#save_donation_button').html('Save Emails');		     		
		     	}
		     	
		  }
		});

		return false;

	});

});


function cancel_subscription(donor_id,subscription_id){
		$('#cancel_subs_'+subscription_id).html('Processing ...');
		$.ajax({
		  type: "GET",
		  url: donation.ajax_url+'?action=donors_transaction&task=cancel_subscription',
		  data: {'donor_id':donor_id,'subscription_id':subscription_id},
		  cache: false,
		  success: function(result){		     	
		     	var res_json_obj = JSON.parse(result);		     	
		     	alert(res_json_obj.msg);
		     	$('#cancel_subs_'+subscription_id).html('Cancel');
		     	if(res_json_obj.status=='success')
		     	{
		     		$('#cancel_subs_'+subscription_id).remove();	
		     	}
		     	
		  }
		});

}

function filterColumn (table,i,v) {	
	
    $('#'+table).DataTable().column( i ).search(v,true,true).draw();
}



//uncomment return statement from inital file.
// function remove_test_data() {

// 		jQuery.ajax({

// 			  type: "GET",
// 			  url: donation.ajax_url+'?action=onetime_payment_delete',
// 			  data: {},
// 			  cache: false,
// 			  success: function(result)
// 			  {

// 			  }
		  
// 		})

// }


