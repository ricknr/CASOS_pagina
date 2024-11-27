<?php 
if($enable_customer_fields){
	$customer_fields = '
	<div class="clearfix"></div>
	<div class="col-sm-12" id="customer_fields_container">
		<div class="form-horizontal">
			<div class="form-group row">
				<label class="col-sm-3 col-md-2 control-label col-form-label" for="name">Nombre *</label>
				<div class="col-sm-9 col-md-4">
					<input type="text" class="form-control input-sm" pattern="^[a-zA-Z,-.\u00C0-\u017E ]{1,}$" title="Acepta letras de la A a la Z, letras con acento(áéíóú) y el caracter especial: punto(.)" maxlength="32" name="name" id="name" value="" required="">
				</div>
				<div class="clearfix form-group-bottom-buffer hidden-md hidden-lg"></div>
				<label class="col-sm-3 col-md-2 control-label col-form-label" for="lastname">Apellidos *</label>
				<div class="col-sm-9 col-md-4">
					<input type="text" class="form-control input-sm" pattern="^[a-zA-Z,-.\u00C0-\u017E ]{1,}$" title="Acepta letras de la A a la Z, letras con acento(áéíóú) y el caracter especial: punto(.)" maxlength="32" name="lastname" id="lastname" value="" required="">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-md-2 control-label col-form-label" for="country_id">País *</label>
				<div class="col-sm-9 col-md-4">
					<input type="text" class="form-control input-sm" maxlength="32" name="country_id" id="country_id" value="Mexico" required>
				</div>
				<div class="clearfix form-group-bottom-buffer hidden-md hidden-lg"></div>
				<label class="col-sm-3 col-md-2 control-label col-form-label" for="street">Calle *</label>
				<div class="col-sm-9 col-md-4">
					<input type="text" class=" form-control input-sm" maxlength="64" pattern="^[a-zA-Z0-9,-.:_\u00C0-\u017E ]{1,}$" title="Acepta letras de la A a la Z. Números enteros del 0-9. Caracteres especiales punto(.), coma(,), guión medio, guión bajo(_), dos puntos(:)" name="street" id="street" value="" required="">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-md-2 control-label col-form-label" for="street_number_ext">Num. Exterior</label>
				<div class="col-sm-9 col-md-4">
					<input type="text" class=" form-control input-sm" pattern="^[a-zA-Z0-9_-s]{0,}$" maxlength="7" title="Acepta letras de la A a la Z. Números enteros del 0-9. Guión medio ( - ), guión bajo ( _ ) y espacios." name="street_number_ext" id="street_number_ext" value="">
				</div>
				<div class="clearfix form-group-bottom-buffer hidden-md hidden-lg"></div>
				<label class="col-sm-3 col-md-2 control-label col-form-label" for="street_number_int">Num. Interior </label>
				<div class="col-sm-9 col-md-4">
					<input type="text" class=" form-control input-sm" pattern="^[a-zA-Z0-9_\-]{0,}$" maxlength="7" title="Acepta letras de la A a la Z. Números enteros del 0-9. Guión medio ( - ) y guión bajo ( _ )" name="street_number_int" id="street_number_int" value="">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-md-2 control-label col-form-label" for="neighborhood">Colonia *</label>
				<div class="col-sm-9 col-md-4">
					<input type="text" class=" form-control input-sm" maxlength="64" pattern="^[a-zA-Z0-9,-.:_\u00C0-\u017E ]{1,}$" title="Acepta letras de la A a la Z, letras con acento(áéíóú). Números enteros del 0-9. Caracteres especiales punto(.), coma(,), guión medio, guión bajo(_), dos puntos(:)." name="neighborhood" id="neighborhood" value="" required="">
				</div>
				<div class="clearfix form-group-bottom-buffer hidden-md hidden-lg"></div>
				<label class="col-sm-3 col-md-2 control-label col-form-label" for="state_name">Estado *</label>
				<div class="col-sm-9 col-md-4 state_class">
					<input type="text" class="form-control input-sm" maxlength="32" name="state_name" id="state_name" value="Nuevo León" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-md-2 control-label col-form-label" for="city_id_name">Ciudad *</label>
				<div class="col-sm-9 col-md-4 city_class">
					<input type="text" class="form-control input-sm" maxlength="32" name="city_id_name" id="city_id_name" value="Monterrey" required>
				</div>
				<div class="clearfix form-group-bottom-buffer hidden-md hidden-lg"></div>
				<label class="col-sm-3 col-md-2 control-label col-form-label" for="zip_code">Código Postal *</label>
				<div class="col-sm-9 col-md-4">
					<input type="text" class="form-control input-sm" maxlength="10" pattern="^[0-9a-zA-Z-_]{1,10}$" title="El campo es requerido, acepta hasta 10 caracteres alfanuméricos. Ej: 64010" name="zip_code" id="zip_code" value="" required="">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-3 col-md-2 control-label col-form-label" for="telephone">Teléfono *</label>
				<div class="col-sm-9 col-md-4">
					<input type="text" class=" form-control input-sm" maxlength="10" pattern="^[0-9]{10,}$" title="Solo acepta un número de 10 dígitos con números enteros del 0 al 9." name="telephone" id="telephone" value="" required="">
				</div>
			</div>
		</div>
	</div>';
}
else{
	$customer_fields = '
		<input type="hidden" name="name" id="name" value="Donativo">
		<input type="hidden" name="last_name" id="last_name" value="Caritas">
		<input type="hidden" name="phone_number" id="phone_number" value="">
		<input type="hidden" name="description" id="description" value="Donativo Caritas.">
		<input type="hidden" name="state_name" id="state_name" value="Nuevo Leon">
		<input type="hidden" name="city_name" id="city_name" value="Monterrey">
		<input type="hidden" name="postal_code" id="postal_code" value="00012">
		<input type="hidden" name="country_code" id="country_code" value="MX">
		<input type="hidden" name="street" id="street" value="Calle">
		<input type="hidden" name="number_int" id="number_int" value="A3">
		<input type="hidden" name="suburb" id="suburb" value="Colonias">
		<input type="hidden" name="number_ext" id="number_ext" value="683">
	';
}

$content .= '
<style>
	.lightbox, 
	.epagos-success, .epagos-error,
	.epagos-in_progress, epagos-completed,
	.epagos-order_id, .epagos-request_id, .epagos-authorization
	{display:none}
	.form-group-bottom-buffer {
		margin-bottom: 15px;
	}
	#payment-loader-container{
		text-align: center;
		position: fixed;
	}
	#customer_fields_container{
		margin-top: 15px;
	}
	.epagos-success{
		padding:10px;
		text-align:left;
	}
	.epagos-error{
		padding: 5px;
		margin-bottom: 20px;
		color:#dc3545;
		text-align: center;
	}
</style>
<div class="donations horizontal col-sm-12 pb-4">
	<form action="" method="POST" id="payment_form" name="payment_form">
		<input type="hidden" name="version" id="version" value="1.1" >
		<input type="hidden" name="payment_id" id="payment_id" value="4">
		<input type="hidden" name="payment_module_id" id="payment_module_id" value="" >
		<input type="hidden" name="action" id="action" value="charge" >
		<input type="hidden" name="business_key" id="business_key" value="">
		<input type="hidden" name="reference_business" id="reference_business" value="' . wp_create_nonce( 'reference_business' ) . '">
		<input type="hidden" name="token_business" id="token_business" value="' . wp_create_nonce( 'token_business' ) . '">
		<input type="hidden" name="token_id" id="token_mp_id" value="">
		<input type="hidden" name="method" id="method" value="card">
		<input type="hidden" name="amount" id="amount" value="300">
		<input type="hidden" name="subscription_id" id="subscription_id" value="" disabled>
		<input type="hidden" name="currency" id="currency" value="MXN">
		<input type="hidden" name="customer_id" id="customer_id" value="' . wp_create_nonce(  date("Ymdhis") ) . '">
		<input type="hidden" name="return_url" id="return_url" value="' . $current_uri . '">
		<div class="row">
		<div class="col-sm-12 col-lg-4">
			<div class="step mb-2">
				<h4><span>1</span> Selecciona la cantidad que deseas donar</h4>
				<ul class="quantity_select">
					<li data-qty="100" class="qty"><i class="fa fa-heart"></i> <strong>$100</strong></li>
					<li data-qty="300" class="qty selected"><i class="fa fa-heart"></i> <strong>$300</strong></li>
					<li data-qty="500" class="qty"><i class="fa fa-heart"></i> <strong>$500</strong></li>
				</ul>';
				/*
		$content .='
			 <div class="customqty mb-3">
			 	<label>Otra cantidad</label>
			 	<div class="input-group input-group-lg">
					<div class="input-group-prepend">
						<span class="input-group-text">$</span>
					</div>
					<input type="number" name="customqty" class="customqty-input form-control" placeholder="1,000" min="50" max="9999">
				</div>
			 </div>';
			 */
			
	if($subscription){
		$content .='
		<p class="text-center">
			<label for="set_subscription">
				<input type="checkbox"  name="set_subscription" id="set_subscription" > Quiero que mi donación sea mensual
			</label>
			<span data-toggle="tooltip" data-placement="top" title="Las donaciones recurrentes se hacen cada mes, por la cantidad elegida en el indicador de la parte superior."><i class="fa fa-question-circle-o" ></i></span>
		</p>';
	}
	$content .='</div>
	</div>
	<div class="col-sm-12 col-lg-8">
		<div class="step mb-2">
			<h4><span>2</span> Ingresa tus datos de contacto</h4>
			<div class="row">
				<div class="col-sm-12 col-md-6">
					<label>Nombre completo</label>
					<input type="text" autocomplete="off" id="holder_name" data-checkout="cardholderName" class="form-control" placeholder="Como aparece en la tarjeta">
				</div>
				<div class="col-sm-12 col-md-6">
					<label>Correo electrónico</label>
					<input type="email" name="email"  id="email" class="form-control" autocomplete="off" required >
				</div>
			</div>
		</div>
		<div class="step mb-2">
			<h4><span>3</span> Ingresa los datos de tu tarjeta de crédito o débito</h4>
			<div class="row card-js">
				<div class="col-sm-12 col-md-6 col-lg-7">
					<label>Número de tarjeta de débito o crédito</label>
					<ul class="paypment-options list-inline">
						<li class="list-inline-item"><img alt="Visa" src="'.$plugin_dir_url.'assets/images/payment-visa.png"></li>
						<li class="list-inline-item"><img alt="Mastercard" src="'.$plugin_dir_url.'assets/images/payment-mastercard.png"></li>
						<li class="list-inline-item"><img alt="Amex" src="'.$plugin_dir_url.'assets/images/payment-amex.png"></li>
					</ul>
					<input type="text" autocomplete="off" id="card_number" data-checkout="cardNumber" class="form-control" placeholder="XXXX XXXX XXXX XXXX" maxlength="16">
				</div>
				<div class="col-xs-6 col-6 col-md-4 col-lg-3">
					<label>Fecha vencimiento</label>
					<div class="row">
						<div class="col-xs-6 col-6" style="padding-right:2px">
							<input type="text" maxlength="2" class="form-control" placeholder="Mes" id="expiration_month" data-checkout="cardExpirationMonth">
						</div>
						<div class="col-xs-6 col-6" style="padding-left:2px">
							<input type="text" maxlength="2" class="form-control" placeholder="Año" id="expiration_year" data-checkout="cardExpirationYear">
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-6 col-md-2">
					<label>CCV <span data-toggle="tooltip" data-placement="top" title="El número de autorización se encuentra en la parte posterior de tu tarjeta, justo al lado de la barra de la firma."><i class="fa fa-question-circle-o" ></i></span></label>
					<input type="tel" maxlength="4" id="ccv" class="form-control" autocomplete="off" required placeholder="3 dígitos" data-checkout="securityCode">
				</div>';
				$content .= $customer_fields;
				$content .='
				<div class="clearfix"></div>
				<div class="col-sm-12">
					<p>
					<label>
					<input type="checkbox" name="terms" id="terms" value="1" required> Acepto los <a href="/terminos.html" data-featherlight="ajax" data-featherlight-other-close="a.read.btn" >Términos y condiciones</a> de esta donación.
					</label>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-12 text-center">
		<button id="pay-button" name="pay-button" class="btn btn-special btn-lg"><i class="fa fa-heart"></i> Quiero ayudar</button>';
	if(false){
		$content .='
		<div class="text-center" style="padding-top:5px">			
		 	<a id="donation_unsubscribe_link" href="#donation_unsubscribe_box">Cancelar la donación</a>
		</div>';
	}
	$content .='</div>	
	</div>
	
</form>
</div>';
if(false){
	$content .='
	<div class="lightbox" id="donation_unsubscribe_box">
		<div id="donation_unsubscribe_div" style="padding:10px;text-align:center;">
		  <p>Por favor ingrese el correo electrónico para cancelar la donación.</p>
		  <p><input type="text" class="" style="width:100%;padding:5px;" placeholder="correo electrónico" name="email" id="email_unsubscribe"/></p>
		  <p><span id="error_msg"></span></p>
		  <p><button name="donation_unsubscribe" class="btn btn-secondary btn-center" id="donation_unsubscribe">Unsubscribe</button>
		  </p>
		</div>
	</div>';
}
$content .='
<div id="payment-loader-container" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="payment-loader">
		 <div><img alt="loader" src="'.$plugin_dir_url.'assets/images/loader.gif"/></div> 
		</div>
	    <div style="color:red"><h3>No cierre ni haga clic en el botón Atrás. <br/>El sistema está procesando su solicitud. Gracias por su paciencia.</h3></div>
      </div>
    </div>
  </div>
</div>';
$content .='<div class="lightbox" id="donation_confirmation_box">
				<div class="epagos-success">
					<div><b><span class="epagos-in_progress">Tu donación está siendo procesada. Gracias por su apoyo.</span></b></div>		
					<div><b><span class="epagos-completed">Su donación se procesa con éxito. Gracias por su apoyo.</span></b></div>		
					<br/>
					<div class="epagos-order_id">Número de orden de donación: <b>%s</b></div>
					<div class="epagos-request_id">Número de referencia: <b>%s</b></div>
					<div class="epagos-authorization">Número de autorización: <b>%s</b></div>
					<br/>
					<div><i>Recibirá un correo electrónico para obtener más información.</i></div>

					<div style="margin-top:20px;"><button name="confirm-button" align="center" class="btn btn-special btn-lg confirm-button"><i class="fa fa-heart"></i>&nbsp;Aceptar</button></div>
				</div>
				<div class="epagos-error">
					<div><b>Disculpe las molestias.</b></div> 
					<div>Hay algún problema durante el pago, Por favor, inténtelo de nuevo después de un tiempo o verifique el problema.</div>

					<div>Mensaje de error: <span class="epagos-error-description"></span></div>

					<div style="margin-top:20px;"><button name="confirm-button" align="center" class="btn btn-special btn-lg confirm-button"><i class="fa fa-plus-circle"></i>&nbsp;Aceptar</button></div>
				</div>
			</div>';
