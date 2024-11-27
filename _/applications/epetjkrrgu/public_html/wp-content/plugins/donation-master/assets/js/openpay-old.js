
jQuery(function() {

    OpenPay.setId(wc_openpay_params.merchant_id);
    OpenPay.setApiKey(wc_openpay_params.public_key);
    OpenPay.setSandboxMode(wc_openpay_params.sandbox_mode);

    $(document).on("submit", "#donaciones", function(event){
        event.preventDefault();
        console.log('before');

        if (jQuery('#terms').is(':checked')) {
            if (!jQuery('#openpay_token').val()) {
                var $form = $(this);
                var holder_name = jQuery($form).find('#holder_name').val();
                var card = jQuery($form).find('#card_number').val();
                var ccv = jQuery($form).find('#ccv').val();
                var expires = jQuery($form).find('#expiry').val().split('/');                         
                
                var data = {
                    card_number: card.replace(/ /g,''),
                    cvv2: ccv,
                    expiration_month: expires[0] || 0,
                    expiration_year: expires[1] || 0,                
                    holder_name :holder_name
                };

                jQuery(".btn-special").prop("disabled", true);
                OpenPay.token.create(data, function(response){
                    var  token= response.data.id;
                    var deviceSessionId = OpenPay.deviceData.setup();

                    var $form = $("#donaciones");
                    $form.off("submit");
                    $form.append('<input type="hidden" id="openpay_token" name="openpay_token" value="' + escape(token) + '" />');
                    $form.append('<input type="hidden" id="device_session_id" name="device_session_id" value="' + escape(deviceSessionId) + '" />');    
                    $form.submit();

                }, 
                    error_callbak
                );
            }

            

        }


        console.log('after');
    })


    
    /* Checkout Form */
    // jQuery('form.donaciones').on('terms', function(event) {
    //     return openpayFormHandler();
    // });

    /* Both Forms */
    // jQuery("form.checkout, form#order_review").on('change', '#openpay-card-number, #openpay-card-expiry, #openpay-card-cvc, input[name=openpay_card_id]', function(event) {
    //     //jQuery('#openpay_token').val("");
    //     jQuery('#openpay_token').remove();
    //     jQuery('#device_session_id').remove();        
    //     jQuery('.woocommerce_error, .woocommerce-error, .woocommerce-message, .woocommerce_message').remove();
    // });

});

function openpayFormHandler() {

    if (jQuery('#terms').is(':checked')) {

       var flag =false; 
        alert('1');
        if (!jQuery('#openpay_token').val()) {
            alert('2');

            var $form = jQuery("form#donaciones");
            var holder_name = jQuery($form).find('#holder_name').val();
            var card = jQuery($form).find('#card_number').val();
            var ccv = jQuery($form).find('#ccv').val();
            var expires = jQuery($form).find('#expiry').val().split('/');                         
            
            var data = {
                card_number: card.replace(/ /g,''),
                cvv2: ccv,
                expiration_month: expires[0] || 0,
                expiration_year: expires[1] || 0,                
                holder_name :holder_name
            };            
            
            alert('3');

            jQuery(".btn-special").prop("disabled", true); 
            console.log(data);
            flag= OpenPay.token.create(data, success_callbak, error_callbak);
            alert('4.1');
            
        }

        alert(flag);

    }
    alert('4');
    return false;    
}


function success_callbak(response) {
    alert('5');
    var $form = jQuery("form#donaciones");
    var  token= response.data.id;
    var deviceSessionId = OpenPay.deviceData.setup();

    $form.append('<input type="hidden" id="openpay_token" name="openpay_token" value="' + escape(token) + '" />');
    $form.append('<input type="hidden" id="device_session_id" name="device_session_id" value="' + escape(deviceSessionId) + '" />');    
    $form.submit();
};


function error_callbak(response) {
    alert('6');
    //var $form = jQuery("form.checkout");
    var msg = "";
    switch(response.data.error_code){
        case 1000:
            msg = "Servicio no disponible.";
            break;

        case 1001:
            msg = "Los campos no tienen el formato correcto, o la petición no tiene campos que son requeridos.";
            break;

        case 1004:
            msg = "Servicio no disponible.";
            break;

        case 1005:
            msg = "Servicio no disponible.";
            break;

        case 2004:
            msg = "El dígito verificador del número de tarjeta es inválido de acuerdo al algoritmo Luhn.";
            break;    

        case 2005:
            msg = "La fecha de expiración de la tarjeta es anterior a la fecha actual.";
            break;

        case 2006:
            msg = "El código de seguridad de la tarjeta (CVV2) no fue proporcionado.";
            break;

        case 3005:
            msg = "La tarjeta fue rechazada por un sistema de fraude.";
            break;



        default: //Demás errores 400 
            msg = "La petición no pudo ser procesada.";
            break;

        alert("ERROR [" + msg + "] "); 
        jQuery(".btn-special").prop("disabled", false); 
    }

    // show the errors on the form
   // jQuery('.woocommerce_error, .woocommerce-error, .woocommerce-message, .woocommerce_message').remove();
    //jQuery('#openpay-card-number').closest('p').before('<ul style="background-color: #e2401c; color: #fff;" class="woocommerce_error woocommerce-error"><li> ERROR ' + response.data.error_code + '. '+msg+'</li></ul>');
    $form.unblock();
    return false;
    
};
