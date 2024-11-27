<style>#donation_unsubscribe_container , .lightbox {display: none;}</style>
<?php 

if($style == 'horizontal') { 
	$status='';
	if(($_GET['payment_status'] == 'fail'))
	{	

		$status .='<div id="payment_status" style="border: 1px solid #0098ae;padding: 5px;margin-bottom: 20px;color:#dc3545;" align="center">';
		$status .='<div><b>Disculpe las molestias.</b></div>'; 
		$status .='<div>Hay algún problema durante el pago, Por favor, inténtelo de nuevo después de un tiempo o verifique el problema.</div>';
		if($_REQUEST['error']!='')
		{
			$status .='<div>Mensaje de error : '.urldecode($_REQUEST['error']).'</div>';	
		}
		
		$status .='</div>';
	}
	

$content .= '

<div class="donations horizontal col-12 pb-4">
<div id="openpay_status" style="display:none;border: 1px solid #0098ae;padding: 5px;margin-bottom: 20px;color:#dc3545;" align="center">El pago está deshabilitado temporalmente. Póngase en contacto con el administrador.</div>
<a id="donation-section" name="donation-section"></a>
'.$status.'
	<form id="donaciones" name="donaciones" method="POST" action="">
		<input type="hidden" name="donation_action" id="donation_action" value="donation_processing">	
		<input type="hidden" name="page" id="page" value="plugin-donation">	
		<input type="hidden" name="donation_nonce" value="' . wp_create_nonce( 'donation' ) . '">
		<input type="hidden" name="amount" id="amount" data-openpay-card="amount" value="300">			
		<input type="hidden" name="token_id" id="token_id">
		<input type="hidden" name="subscription_plan" id="subscription_plan">
        <input type="hidden" name="donate_page_url" id="donate_page_url" value="'.site_url().$_SERVER['REQUEST_URI'].'">
		<div class="row">
		<div class="col-12 col-lg-4">
			<div class="step mb-2">
				<h4><span>1</span> Selecciona la cantidad que deseas donar</h4>
				<ul class="quantity_select">
					<li data-qty="100" class="qty"><i class="fa fa-heart"></i> <strong>$100</strong></li>
					<li data-qty="300" class="qty selected"><i class="fa fa-heart"></i> <strong>$300</strong></li>
					<li data-qty="500" class="qty"><i class="fa fa-heart"></i> <strong>$500</strong></li>
				</ul>';

				// <div class="customqty mb-3">
				// 	<label>Otra cantidad</label>
				// 	<div class="input-group input-group-lg">
				//    <div class="input-group-prepend">
				// 	<span class="input-group-text">$</span>
				//   </div>
	  	// 		   <input type="number" name="customqty" class="customqty-input form-control" placeholder="1,000" min="50" max="9999">
				// </div>
			 //    </div>
			    
			$content .='<div class="d-none">
					<input type="number" class="quantity" name="quantity" value="300">
				</div>';
				// <p class="text-center"><label><input type="checkbox"  name="recurring" id="recurring" checked > Quiero que mi donación sea mensual</label> <span href="#" data-toggle="tooltip" data-placement="top" title="Las donaciones recurrentes se hacen cada mes, por la cantidad elegida en el indicador de la parte superior."><i class="fa fa-question-circle-o" ></i></span>
				// </p>			

			$content .='</div>
		</div>
		<div class="col-12 col-lg-8">
			<div class="step mb-2">
				<h4><span>2</span> Ingresa tus datos de contacto</h4>
				<div class="row">
					<div class="col-12 col-md-6">
						<label>Nombre completo</label>
						<input type="text" name="holder_name" id="holder_name" placeholder="Como aparece en la tarjeta" autocomplete="off" id="holder_name" class="form-control" required data-openpay-card="holder_name">
					</div>
					<div class="col-12 col-md-6">
						<label>Correo electrónico</label>
						<input type="email" name="email"  id="email" class="form-control" autocomplete="off" data-openpay-card="email"  required >
					</div>
				</div>
			</div>
			<div class="step mb-2">
				<h4><span>3</span> Ingresa los datos de tu tarjeta de crédito o débito</h4>
				<div class="row card-js">
					<div class="col-12 col-md-6 col-xl-7">
						<label>Número de tarjeta de débito o crédito</label>
						<ul class="paypment-options list-inline">
							<li class="list-inline-item"><img src="'.get_stylesheet_directory_uri().'/images/payment-visa.png"></li>
							<li class="list-inline-item"><img src="'.get_stylesheet_directory_uri().'/images/payment-mastercard.png"></li>
							<li class="list-inline-item"><img src="'.get_stylesheet_directory_uri().'/images/payment-amex.png"></li>
						</ul>
						<input type="text" maxlength="16" id="card_number" name="card_number" class="form-control" autocomplete="off" placeholder="XXXX XXXX XXXX XXXX" required data-openpay-card="card_number">
					</div>
					<div class="col-6 col-md-4 col-xl-3">
						<label>Fecha vencimiento</label>
						<div class="sctn-col half l">
							<input type="text" maxlength="2" class="form-control" placeholder="Mes" data-openpay-card="expiration_month" id="expiration_month" >
						</div>
	                    <div class="sctn-col half l">
	                    	<input type="text" maxlength="2" class="form-control" placeholder="Año" data-openpay-card="expiration_year" id="expiration_year" >
	                    </div>

					</div>
					<div class="col-6 col-md-2">
						<label>CCV <span href="#" data-toggle="tooltip" data-placement="top" title="El número de autorización se encuentra en la parte posterior de tu tarjeta, justo al lado de la barra de la firma."><i class="fa fa-question-circle-o" ></i></span></label>
						<input type="text" name="ccv" name="ccv" maxlength="4" id="ccv" class="form-control" autocomplete="off" required placeholder="3 dígitos" data-openpay-card="cvv2">
					</div>
					<div class="col-12">
						<p><label><input type="checkbox" name="terms" id="terms" value="1" required> Acepto los <a href="/terminos.html .terminos" data-featherlight="ajax" data-featherlight-other-close="a.read.btn" >Términos y condiciones</a> de esta donación.</p>
					</div>
				</div>
			</div>
			
		</div>
		<div class="col-12 text-center">
			<button id="pay-button" name="pay-button" class="btn btn-special btn-lg"><i class="fa fa-heart"></i> Quiero ayudar</button>';
			// <div class="text-center" style="padding-top:5px">			
			// 	<a id="donation_unsubscribe_link" href="#donation_unsubscribe_box">Cancelar la donación</a>
			// </div>
		$content .='</div>	
		</div>
		
	</form>	

	<div class="lightbox" id="donation_unsubscribe_box">
	    <div id="donation_unsubscribe_div" style="padding:10px;text-align:center;">
	      <p>Por favor ingrese el correo electrónico para cancelar la donación.</p>
	      <p><input type="text" class="" style="width:100%;padding:5px;" placeholder="correo electrónico" name="email" id="email"/></p>
	      <p><span id="error_msg"></span></p>
	      <p><button name="donation_unsubscribe" class="btn btn-secondary btn-center" id="donation_unsubscribe">Unsubscribe</button>
	      </p>
	    </div>
	</div>';

	if(($_GET['payment_status'] == 'success' || $_GET['payment_status'] == 'pending') && $_GET['order_id'])
	{
		$content .='<div class="lightbox" id="donation_confirmation_box">
						<div id="donation_confirmation_div" style="padding:10px;text-align:left;">';

							if($_GET['payment_status'] == 'pending')
							{
								$content .='<div><b>Tu donación está siendo procesada. Gracias por su apoyo.</b></div>';		
							}							
							else{
								$content .='<div><b>Su donación se procesa con éxito. Gracias por su apoyo.</b></div>';		
							}		
								
							$content .='
								<br/>
								<div>Número de referencia de donación:<b>'.$_GET['order_id'].'</b></div>';

								if($_GET['next_payment_date'])
								{
									$content .='<div>Siguiente fecha de carga:<b>'.$_GET['next_payment_date'].'</b></div>';
								}

								if($_GET['amount'])
								{
									$content .='<div>Monto de donación:<b> $'.$_GET['amount'].'</b></div>';
								}
								if($_GET['msg'])
								{
									$content .='<div>Mensaje:<b> '.$_GET['msg'].'</b></div>';
								}		
								$content .='<br/><div><i>Recibirá un correo electrónico para obtener más información.</i></div>';

								$content.='<div style="margin-top:20px;"><button id="confirm-button" name="confirm-button" onclick="closeFeatherBox();" align="center" class="btn btn-special btn-lg"><i class="fa fa-heart"></i> Aceptar</button></div>';

		$content.='</div></div>';				

	}

	if(isset($_GET['payment_status']) && $_GET['payment_status'] == 'fail')
	{		

		$content .='<div class="lightbox" id="donation_confirmation_box"><div id="payment_status" style="padding: 5px;margin-bottom: 20px;color:#dc3545;" align="left">';
		$content .='<div><b>Disculpe las molestias.</b></div>'; 
		$content .='<div>Hay algún problema durante el pago, Por favor, inténtelo de nuevo después de un tiempo o verifique el problema.</div>';
		if($_REQUEST['error']!='')
		{
			$content .='<div>Mensaje de error : '.urldecode($_REQUEST['error']).'</div>';	
		}
		
		$content.='<div style="margin-top:20px;"><button id="confirm-button" name="confirm-button" onclick="closeFeatherBox();" align="center" class="btn btn-special btn-lg"><i class="fa fa-plus-circle"></i> Rever</button></div>';
		
		$content .='</div></div>';
	} 


$content .= '</div>';

 } else {
	 
	$status='';
	// if(($_GET['payment_status'] == 'success') && $_GET['order_id'])
	// {	
	// 	$status .='<div id="payment_status" style="border: 1px solid #0098ae;padding: 5px;margin-bottom: 20px;color:#0eca16;" align="center">';
	// 	$status .='<div><b>Gracias por tu apoyo.</b></div>'; 
	// 	$status .='<div>Su donación se procesa con éxito con el Número de referencia de donación. : <b>'.$_GET['order_id'].'</b></div>';

	// 	if($_GET['next_payment_date'])
	// 	{
	// 		$status .='<div>Su próxima donación será procesada en : <b>'.$_GET['next_payment_date'].'</b></div>';
	// 	}

	// if($_GET['amount'])
	// {
	// 	$content .='<div>Monto de donación:<b> $'.$_GET['amount'].'</b></div>';
	// }	

	// 	$status .='</div>';
	// }

	if(($_GET['payment_status'] == 'fail'))
	{	


		$status .='<div id="payment_status" style="border: 1px solid #0098ae;padding: 5px;margin-bottom: 20px;color:#dc3545;" align="center">';
		$status .='<div><b>Disculpe las molestias.</b></div>'; 
		$status .='<div>Hay algún problema durante el pago, Por favor, inténtelo de nuevo después de un tiempo o verifique el problema.</div>';
		if($_REQUEST['error']!='')
		{
			$status .='<div>Mensaje de error : '.urldecode($_REQUEST['error']).'</div>';	
		}
		
		$status .='</div>';
	}
	

$content .= '

<div class="donations vertical col-12 pb-4">
<div id="openpay_status" style="display:none;border: 1px solid #0098ae;padding: 5px;margin-bottom: 20px;color:#dc3545;" align="center">El pago está deshabilitado temporalmente. Póngase en contacto con el administrador.</div>
<a id="donation-section" name="donation-section"></a>
'.$status.'
	<form id="donaciones" name="donaciones" method="POST" action="">
		<input type="hidden" name="donation_action" id="donation_action" value="donation_processing">	
		<input type="hidden" name="page" id="page" value="plugin-donation">	
		<input type="hidden" name="donation_nonce" value="' . wp_create_nonce( 'donation' ) . '">
		<input type="hidden" name="amount" id="amount" value="" data-openpay-card=""amount>	
		
		<input type="hidden" name="token_id" id="token_id">
		<input type="hidden" name="subscription_plan" id="subscription_plan">
        <input type="hidden" name="donate_page_url" id="donate_page_url" value="'.site_url().$_SERVER['REQUEST_URI'].'">
		<div class="row">
		<div class="col-12">
			<div class="step mb-2">
				<h4><span>1</span> Selecciona la cantidad que deseas donar</h4>
				<ul class="quantity_select">
					<li data-qty="100" class="qty"><i class="fa fa-heart"></i> <strong>$100</strong></li>
					<li data-qty="300" class="qty selected"><i class="fa fa-heart"></i> <strong>$300</strong></li>
					<li data-qty="500" class="qty"><i class="fa fa-heart"></i> <strong>$500</strong></li>
				</ul>';

				// <div class="customqty mb-3">
				// 	<label>Otra cantidad</label>
				// 	<div class="input-group input-group-lg">
				//    <div class="input-group-prepend">
				// 	<span class="input-group-text">$</span>
				//   </div>
	  	// 		   <input type="number" name="customqty" class="customqty-input form-control" placeholder="1,000" min="50" max="9999">
				// </div>
			 //    </div>
			    
			$content .='<div class="d-none">
					<input type="number" class="quantity" name="quantity" value="300">
				</div>';
				// <p class="text-center"><label><input type="checkbox"  name="recurring" id="recurring" checked > Quiero que mi donación sea mensual</label> <span href="#" data-toggle="tooltip" data-placement="top" title="Las donaciones recurrentes se hacen cada mes, por la cantidad elegida en el indicador de la parte superior."><i class="fa fa-question-circle-o" ></i></span>
				// </p>			

			$content .='</div>
		</div>
		<div class="col-12">
			<div class="step mb-2">
				<h4><span>2</span> Ingresa tus datos de contacto</h4>
				<div class="row">
					<div class="col-12 col-md-6">
						<label>Nombre completo</label>
						<input type="text" name="holder_name" id="holder_name" placeholder="Como aparece en la tarjeta" autocomplete="off" id="holder_name" class="form-control" required data-openpay-card="holder_name">
					</div>
					<div class="col-12 col-md-6">
						<label>Correo electrónico</label>
						<input type="email" name="email"  id="email" class="form-control" autocomplete="off" data-openpay-card="email" required >
					</div>
				</div>
			</div>
			<div class="step mb-2">
				<h4><span>3</span> Ingresa los datos de tu tarjeta de crédito o débito</h4>
				<div class="row card-js">
					<div class="col-12">
						<label>Número de tarjeta de débito o crédito</label>
						<ul class="paypment-options list-inline">
							<li class="list-inline-item"><img src="'.get_stylesheet_directory_uri().'/images/payment-visa.png"></li>
							<li class="list-inline-item"><img src="'.get_stylesheet_directory_uri().'/images/payment-mastercard.png"></li>
							<li class="list-inline-item"><img src="'.get_stylesheet_directory_uri().'/images/payment-amex.png"></li>
						</ul>
						<input type="text" maxlength="16" id="card_number" name="card_number" class="form-control" autocomplete="off" placeholder="XXXX XXXX XXXX XXXX" required data-openpay-card="card_number">
					</div>
					<div class="col-6">
						<label>Fecha vencimiento</label>
						<div class="clearfix"></div>
						<div class="sctn-col half l" >
							<input type="text" maxlength="2" class="form-control" placeholder="Mes" data-openpay-card="expiration_month" >
						</div>
	                    <div class="sctn-col half l" >
	                    	<input type="text" maxlength="2" class="form-control" placeholder="Año" data-openpay-card="expiration_year" >
	                    </div>

					</div>
					<div class="col-6">
						<label>CCV <span href="#" data-toggle="tooltip" data-placement="top" title="El número de autorización se encuentra en la parte posterior de tu tarjeta, justo al lado de la barra de la firma."><i class="fa fa-question-circle-o" ></i></span></label>
						<input type="text" name="ccv" maxlength="4" id="ccv" class="form-control" autocomplete="off" required placeholder="3 dígitos" data-openpay-card="cvv2">
					</div>
					<div class="col-12">
						<p><label><input type="checkbox" name="terms" id="terms" value="1" required> Acepto los <a href="/terminos.html .terminos" data-featherlight="ajax" data-featherlight-other-close="a.read.btn" >Términos y condiciones</a> de esta donación.</p>
					</div>
				</div>
			</div>
			
		</div>
		<div class="col-12 text-center">
			<button id="pay-button" name="pay-button" class="btn btn-special btn-lg"><i class="fa fa-heart"></i> Quiero ayudar</button>';
			// <div class="text-center" style="padding-top:5px">			
			// 	<a id="donation_unsubscribe_link" href="#donation_unsubscribe_box">Cancelar la donación</a>
			// </div>
		$content .='</div>	
		</div>
		
	</form>	

	<div class="lightbox" id="donation_unsubscribe_box">
	    <div id="donation_unsubscribe_div" style="padding:10px;text-align:center;">
	      <p>Por favor ingrese el correo electrónico para cancelar la donación.</p>
	      <p><input type="text" class="" style="width:100%;padding:5px;" placeholder="correo electrónico" name="email" id="email"/></p>
	      <p><span id="error_msg"></span></p>
	      <p><button name="donation_unsubscribe" class="btn btn-secondary btn-center" id="donation_unsubscribe">Unsubscribe</button>
	      </p>
	    </div>
	</div>';

	if(($_GET['payment_status'] == 'success') && $_GET['order_id'])
	{
		$content .='<div class="lightbox" id="donation_confirmation_box">
						<div id="donation_confirmation_div" style="padding:10px;text-align:left;"><div><b>Su donación se procesa con éxito. Gracias por su apoyo.</b></div><br/><div>Número de referencia de donación:<b>'.$_GET['order_id'].'</b></div>';

								if($_GET['next_payment_date'])
								{
									$content .='<div>Siguiente fecha de carga:<b>'.$_GET['next_payment_date'].'</b></div>';
								}

								if($_GET['amount'])
								{
									$content .='<div>Monto de donación:<b> $'.$_GET['amount'].'</b></div>';
								}	
								
								if($_GET['msg'])
								{
									$content .='<div>Mensaje:<b> '.$_GET['msg'].'</b></div>';
								}		
								$content .='<br/><div><i>Recibirá un correo electrónico para obtener más información.</i></div>';

								$content.='<div style="margin-top:20px;"><button id="confirm-button" name="confirm-button" onclick="closeFeatherBox();" align="center" class="btn btn-special btn-lg"><i class="fa fa-heart"></i> Aceptar</button></div>';
								

		$content.='</div></div>';				

	}

 
} ?>