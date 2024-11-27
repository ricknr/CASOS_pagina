jQuery(document).ready(function() {

    if(donation_openpay_params.openpay_enabled)
    {
        jQuery('#openpay_status').hide();

        OpenPay.setId(donation_openpay_params.merchant_id);
        OpenPay.setApiKey(donation_openpay_params.public_key);

        if(donation_openpay_params.sandbox_mode)
        {
            OpenPay.setSandboxMode(true);    
        }
        else
        {
            OpenPay.setSandboxMode(false);    
        }        
        
        //Se genera el id de dispositivo
        var deviceSessionId = OpenPay.deviceData.setup("donaciones_form", "device_session_id");

    }else
    {
        jQuery('#openpay_status').show();
        jQuery('#pay-button').prop('disabled',true);
    }
    
    jQuery('#pay-button').on('click', function(event) {        

        if(!donation_openpay_params.openpay_enabled)
        {
            return;
        }

        event.preventDefault();
        if (jQuery('#donaciones_form #amount').val()=="") {

            alert("ERROR [ Por favor seleccione el monto de la donación. ]");
            return false;
        }

        if (jQuery('#donaciones_form #terms').is(':checked')) {

            if(!isEmail(jQuery('#donaciones_form #email').val()))
            {
                alert("ERROR [ El correo no es válido. ]");
                return false;
            }
        
            if (jQuery('#recurring').is(':checked')) {
                jQuery('#recurring').attr('value','1');
                jQuery('#subscription_plan').attr('value','Plan '+jQuery('#amount').val());
            }

            jQuery('#pay-button').prop( 'disabled', true);
            //OpenPay.token.extractFormAndCreate('donaciones_form', sucess_callbak, error_callbak);                

            var formObj = jQuery('#donaciones_form');
            if(formObj.find('#card_number').val() && formObj.find('#holder_name').val() && formObj.find('#expiration_year').val() && formObj.find('#expiration_month').val())
            {
                OpenPay.token.create({
                  "card_number":formObj.find('#card_number').val(),
                  "holder_name":formObj.find('#holder_name').val(),
                  "expiration_year":formObj.find('#expiration_year').val(),
                  "expiration_month":formObj.find('#expiration_month').val(),
                  "cvv2":formObj.find('#ccv').val()
                }, sucess_callbak, error_callbak);
            }
            else
            {
               alert("ERROR [ El formulario no se envía. Inténtalo de nuevo. ]");     
               return false;
            }

        }
        else
        {
            alert("ERROR [ Acepto los Términos y condiciones de esta donación ]");
            return false;
        }

    });

    var sucess_callbak = function(response) {

      var token_id = response.data.id;
      jQuery('#donaciones_form #token_id').val(token_id);        
      jQuery('#donaciones_form').submit();

    };

    var error_callbak = function(response) {

        var desc = response.data.description != undefined ? response.data.description : response.message;
        alert("ERROR [" + response.status + "] " + desc);
        jQuery('#pay-button').prop('disabled', false);
    };

    jQuery('#donation_unsubscribe').on('click',function(){

            var emailObj = jQuery(".featherlight-content #donation_unsubscribe_div #email_unsubscribe");
            if(emailObj.val()===""){
                jQuery(".featherlight-content #donation_unsubscribe_div #error_msg").html('Por favor ingrese un correo electrónico.').css({'color':'red','padding':'1px'});
                return;
            }
            else if(!isEmail(emailObj.val()))
            {
               jQuery(".featherlight-content #donation_unsubscribe_div #error_msg").html('El correo no es válido.').css({'color':'red','padding':'1px'});            
               return;
            }

        jQuery('.featherlight-content #donation_unsubscribe').html('Processing ...');

        jQuery.ajax({
          type: "GET",
          url: donation_openpay_params.ajax_url+'?action=donors_transaction&task=donor_unsubscribe',
          data: {'email':emailObj.val()},
          cache: false,
          success: function(result){                
                var res_json_obj = result;                
                if(res_json_obj.status=='success')
                {   jQuery(".featherlight-content #donation_unsubscribe_div #error_msg").html(res_json_obj.msg).css({'color':'green','padding':'1px'});
                    jQuery('.featherlight-content #donation_unsubscribe').html('Unsubscribe'); 
                }                
          }
        });


        return;
    });

    jQuery('#donation_unsubscribe_link').click(function() {
       
        jQuery.featherlight('#donation_unsubscribe_box');

    });

    var res = param('payment_status');
    if(res!="" && (res==='fail' || res==='success' || res==='pending' ))
    {
        setTimeout(function(){ 

            jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
            jQuery.featherlight('#donation_confirmation_box');

        },3000);
        
    }


});


function param(name) {
    return (location.search.split(name + '=')[1] || '').split('&')[0];
}

function isEmail(email) {    

  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;  
  return regex.test(email);
  
}

function closeFeatherBox(){
    var current = jQuery.featherlight.current();
    current.close();    
}



// function error_callbak(response) {
//     alert('6');
//     //var jQueryform = jQuery("form.checkout");
//     var msg = "";
//     switch(response.data.error_code){
//         case 1000:
//             msg = "Servicio no disponible.";
//             break;

//         case 1001:
//             msg = "Los campos no tienen el formato correcto, o la petición no tiene campos que son requeridos.";
//             break;

//         case 1004:
//             msg = "Servicio no disponible.";
//             break;

//         case 1005:
//             msg = "Servicio no disponible.";
//             break;

//         case 2004:
//             msg = "El dígito verificador del número de tarjeta es inválido de acuerdo al algoritmo Luhn.";
//             break;    

//         case 2005:
//             msg = "La fecha de expiración de la tarjeta es anterior a la fecha actual.";
//             break;

//         case 2006:
//             msg = "El código de seguridad de la tarjeta (CVV2) no fue proporcionado.";
//             break;

//         case 3005:
//             msg = "La tarjeta fue rechazada por un sistema de fraude.";
//             break;



//         default: //Demás errores 400 
//             msg = "La petición no pudo ser procesada.";
//             break;

//         alert("ERROR [" + msg + "] "); 
//         jQuery(".btn-special").prop("disabled", false); 
//     }

//     // show the errors on the form
//    // jQuery('.woocommerce_error, .woocommerce-error, .woocommerce-message, .woocommerce_message').remove();
//     //jQuery('#openpay-card-number').closest('p').before('<ul style="background-color: #e2401c; color: #fff;" class="woocommerce_error woocommerce-error"><li> ERROR ' + response.data.error_code + '. '+msg+'</li></ul>');
//     jQueryform.unblock();
//     return false;
    
// };