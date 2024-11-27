<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">

jQuery(document).ready(function () {

	callback_secure ();

	var int_callback_secure = setInterval(function(){ callback_secure(); }, 20000);

	function callback_secure (){        

		jQuery.ajax({
		  type: "POST",
		  url: '<?php echo admin_url('admin-ajax.php'); ?>',
		  data: {'id':'<?php echo $_GET['id'];?>','action':'processing_secure_callback'},
		  async:false,
		  cache:false,		  
		  success: function(result){
		  	//console.log(result);
		     	var res_json_obj = JSON.parse(result);		     	
		     	if(res_json_obj.status=='success' || res_json_obj.status=='error')
		     	{	
		     		clearInterval(int_callback_secure);
		     		window.location.href=res_json_obj.redirect;
		     	}


		  }
		});

	}
	
});

</script>