// inicializar varieble $ con jquery para e-pagos
// TODO: ver deque manera inicializar el jquery de e-pagos sin necesidad de declarar $
var $ = jQuery.noConflict();
jQuery(document).ready(function() {

    if(!epagos_params.epagos_enabled){
		return false;
	}
	jQuery('#payment_form').attr('action', epagos_params.form_action);
	jQuery('#business_key').val(epagos_params.business_id);
	jQuery('#payment_module_id').val(epagos_params.payment_id);
	jQuery('.payment_status').hide();
    
	jQuery("#payment_form").on("submit", function(e){
		var _form = jQuery(this);
		e.preventDefault();
		jQuery("#pay-button, #return_url").prop('disabled', true);

		/* Validación plan y suscripción */
		epagos_set_subscription();
		var error_ = 0;
		if(!jQuery("#token_mp_id").val() &&  ! error_){
			if (typeof(validateMercadopago) !== "undefined"){
				validateMercadopago();
			}
			else{
				alert('error: validateMercadopago not defined');
			}
		}
		else{
			jQuery.ajax({
				type: 'post',
				url: _form.attr('action'),
				data: _form.serialize(),
				beforeSend:function(){
					jQuery('#payment-loader-container').modal('show');
				},
				success: function(data) {
					if(data.response.status == "completed" || data.response.status == "in_progress"){
						jQuery('.epagos-error').hide();
						jQuery('.epagos-success').show();
						jQuery('.epagos-completed').toggle(data.response.status == "completed");
						jQuery('.epagos-in_progress').toggle(data.response.status == "in_progress");
						if(data.response.authorization){
							jQuery('.epagos-authorization')
								.html(jQuery('.epagos-authorization').html().replace(/%s/g, data.response.authorization))
								.show();
						}
						if(data.response.order_id){
							jQuery('.epagos-order_id')
								.html(jQuery('.epagos-order_id').html().replace(/%s/g, data.response.order_id))
								.show();
						}
						if(data.response.request_id){
							jQuery('.epagos-request_id')
								.html(jQuery('.epagos-request_id').html().replace(/%s/g, data.response.request_id))
								.show();
						}
					}
					// si entra aqui, asumimos que hay un error
					else{
						jQuery('.epagos-success').hide();
						jQuery('[class^="epagos-"]', '.epagos-success').hide();
						jQuery('.epagos-error').show();
						jQuery('.epagos-error-description').text(data.response.error_code + ' - ' + data.response.error_description);
					}
					// mostramos el resultado en el componente featherlight
					if(typeof (jQuery.featherlight) !== "undefined"){
						jQuery.featherlight('#donation_confirmation_box');
					}
					else{
						jQuery('#donation_confirmation_box').show();
					}
				},
				complete:function(){
					jQuery("#pay-button, #return_url").prop('disabled', false);
					jQuery('#payment-loader-container').modal('hide');
				},
				error:function(data){
					jQuery('.epagos-success').hide();
					jQuery('[class^="epagos-"]', '.epagos-success').hide();
					jQuery('.epagos-error').show();
					jQuery('.epagos-error-description').text('Ocurrió un error inesperado al procesar el pago');
				}
			});
		}
	});
	
	jQuery('.confirm-button').on('click', closeFeatherBox);
});

function mercadopagoCompleteCallback(data){
	jQuery("#payment_form").submit();
}

function epagos_set_subscription(){
	var set_subscription = jQuery('#set_subscription').is(':checked');
	var amount = parseInt(jQuery('#amount').val());
	jQuery('#subscription_id').prop('disabled', !set_subscription);
	if(set_subscription){
		subscription_obj = jQuery.grep(epagos_params.subscriptions.response.subscriptions, function(obj) {
			return parseInt(obj.subscription_amount) === amount;
		});
		jQuery('#subscription_id').val(subscription_obj[0].subscription_id);
	}
}

function mercadopagoErrorCallback(data){
	jQuery("#pay-button, #return_url").prop('disabled', false);
	alert(data.error_description);
}

function closeFeatherBox(){
	jQuery('.epagos-success, .epagos-error').hide();
	jQuery('[class^="epagos-"]', '.epagos-success').hide();
	if(typeof jQuery.featherlight !== "undefined"){
		var current = jQuery.featherlight.current();
		current.close();    
	}
	else{
		jQuery('#donation_confirmation_box').hide();
	}
	// al cerrar el mensaje, se abre la url de retorno:
	// TODO: se hace por que se debe de recargar la libreria 
	// para que se actualize el token y de momento no se puede
	window.location.replace(jQuery("#return_url").val());
}
