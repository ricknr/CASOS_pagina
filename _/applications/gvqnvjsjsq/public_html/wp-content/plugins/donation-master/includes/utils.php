<?php

if (!defined('ABSPATH')) {
    exit;
}

trait Utils
{	
	var $logging = true;
	public function date_formatter($date='',$format='d/m/Y')
	{
		global $timezone;

	    if($date)
	    {
	      $date = str_replace(' ' , '', $date);
	      $date = new DateTime($date, new DateTimeZone($timezone));
	      return  $date->format($format);         
	    }

	    return;
	}    	

	public function handleRequestError($responseCode) {

        switch ($responseCode) {

            case "1000":
                $msg = "Se produjo un error en el servidor interno de Openpay..";
                break;

            case "1003":
                $msg = "La operación no se pudo procesar porque uno o más parámetros son incorrectos.";
                break;

            case "1001":
                $msg = "La solicitud no es un formato válido de JSON, los campos no tienen el formato correcto o la solicitud no tiene los campos obligatorios.";
                break;

            case "1004":
                $msg = "Un servicio requerido no está disponible.";
                break;

            case "1005":
                $msg = "Un recurso requerido no existe.";
                break;

            case "2004":
                $msg = "El dígito verificador del número de tarjeta es inválido de acuerdo al algoritmo Luhn.";
                break;

            case "2005":
                $msg = "La fecha de expiración de la tarjeta es anterior a la fecha actual.";
                break;

            case "2006":
                $msg = "El código de seguridad de la tarjeta (CVV2) no fue proporcionado.";
                break;

            case "3001":
                $msg = "La tarjeta fue rechazada.";
                break;

            case "3002":
                $msg = "La tarjeta ha expirado.";
                break;

            case "3003":
                $msg = "La tarjeta no tiene fondos suficientes.";
                break;

            case "3004":
                $msg = "Por razones de seguridad llame a su BANCO/EMISOR de la tarjeta para confirmar su identidad y transacción, bloqueo temporal. Por favor, no reintente este cargo hasta que su tarjeta esté desbloqueada.";
                break;

            case "3005":
                $msg = "La tarjeta ha sido identificada como fraudulenta.";
                break;

            case "3006":
                $msg = "La operación no esta permitida para este cliente o esta transacción.";
                break;

            case "3007":
                $msg = "Deprecado. La tarjeta fue declinada.";
                break;

            case "3008":
                $msg = "La tarjeta no es soportada en transacciones en línea.";
                break;

            case "3009":
                $msg = "La tarjeta fue reportada como perdida.";
                break;

            case "3010":
                $msg = "El banco ha restringido la tarjeta.";
                break;

            case "3011":
                $msg = "El banco ha solicitado que la tarjeta sea retenida. Contacte al banco.";
                break;
            
            case "3012":
                $msg = "Se requiere solicitar al banco autorización para realizar este pago.";
                break;

            case "1002":
                $msg = "La solicitud no está autenticada o es incorrecta.";
                break;

            case "1006":
                $msg = "Ya hay una transacción con el mismo orden de ID.";
                break;
    
            case "1007":
                $msg = "La transferencia de fondos entre la cuenta bancaria o la tarjeta y la cuenta de Openpay fue rechazada.";
                break;

            case "1008":
                $msg = "Una de las cuentas requeridas está desactivada.";
                break;

            case "1009":
                $msg = "El cuerpo de la solicitud es demasiado grande.";
                break;

            case "1010":
                $msg = "La clave pública se está utilizando para realizar una solicitud que requiere la clave privada, o la clave privada se está utilizando desde Javascript.";
                break;

            case "1011":
                $msg = "El recurso fue eliminado previamente.";
                break;

            case "1012":
                $msg = "El monto de la transacción está fuera de los límites.";
                break;

            case "1013":
                $msg = "La operación no está permitida en el recurso.";
                break;

            case "1014":
                $msg = "La cuenta está inactiva.";
                break;

            case "1015":
                $msg = "No se pudo obtener ninguna respuesta de la puerta de enlace.";
                break;

            case "1016":
                $msg = "El correo electrónico del comerciante ya se ha procesado.";
                break;

            case "1017":
                $msg = "La pasarela de pago no está disponible en este momento, intente de nuevo más tarde.";
                break;

            case "1018":
                $msg = "El número de reintentos de carga es mayor de lo permitido.";
                break;

            default: //Demás errores 400 
                $msg = "La petición no pudo ser procesada.";
                break;
        }

        return $msg;
    }


    public function handleResponseStatus($status=''){

        
        switch ($status) {
            case "in_progress":
                $msg = "La transacción está en progreso.";
                break;

            case "completed":
                $msg = "La transacción se completó con éxito.";
                break;

            case "refunded":
                $msg = "Transacción que ha sido reembolsada.";
                break;

            case "chargeback_pending":
                $msg = "Transacción que tiene un contracargo pendiente.";
                break;

            case "chargeback_accepted":
                $msg = "Transacción que tiene un contracargo aceptado.";
                break;

            case "chargeback_adjustment":
                $msg = "Transacción que tiene un ajuste para el contracargo.";
                break;

            case "charge_pending":
                $msg = "Transacción que está esperando ser pagada.";
                break;

            case "cancelled":
                $msg = "Transacción que no se pagó y se canceló.";
                break;

            case "failed":
                $msg = "La transacción ha fallado.";    
                break;

            case "payout_off":
                $msg = "La transacción ha fallado, debido a que el pago está desactivado.";    
                break;    

            default: //Demás errores 400 
                $msg = "La petición no pudo ser procesada.";
                break;    
            }

        return $msg;

    }


    public function send_mail($action,$option=array())
    {
    
    	if($action=='payment_success')
    	{    		
    		$this->process_email_template('payment_success',$option); 
    	}
    	else if($action=='payment_failure')
    	{    
    		$this->process_email_template('payment_failure',$option); 
    	}
    	else if($action=='payment_subscription')
    	{    	
    		$this->process_email_template('payment_subscription',$option); 
    	}
    	else if($action=='payment_subscription_cancel')
    	{
    		$this->process_email_template('payment_subscription_cancel',$option); 
    	}
    	else if($action=='payment_subscription_cancel_request')
    	{
    		$this->process_email_template('payment_subscription_cancel_request',$option); 
    	}   	

    }   

    public function process_email_template($type='',$option=array())
    {	    	
    	$message_data = $this->get_template_data($type);    	

		$message='';
    	if($message_data->message)
    	{
    		$message = $message_data->message;
    		$message = str_replace('{{order_id}}', $option['order_id'], $message);
    		$message = str_replace('{{name}}', $option['name'], $message);	
    		$message = str_replace('{{email}}', $option['email'], $message);	
    		$message = str_replace('{{amount}}', $option['amount'], $message);	
    		$message = str_replace('{{date}}', date('d/m/Y'), $message);	
    		$message = str_replace('{{error_message}}', $option['msg'], $message);	
    		$message = str_replace('{{next_payment_date}}', $option['next_payment_date'], $message);	
    		$message = str_replace('{{cancel_date}}', $option['cancel_at'], $message);	
    	}    	    		
        
        $headers = array(  'Content-Type: text/html; charset=UTF-8', 
                           'From: Administrator <atenciondonantes@caritas.org.mx>',
                           'Cc: Administrator <atenciondonantes@caritas.org.mx>');
            	
    	if($option['admin_mail']) 
    	{
    		$to_mail= $option['admin_mail'];
    	}
    	else
    	{
    		$to_mail= $option['email'];
    	}
        //echo $message; 

        //echo '************';

        $message = html_entity_decode($message, ENT_QUOTES, 'UTF-8');
        $message = stripslashes($message); 

    	wp_mail( $to_mail,$message_data->subject, $message, $headers, $attachments );
    }

    public function get_template_data($type='')
    {
    		global $wpdb;

    		$search =' 1=1 ';
    		if($type)
		  	{		  		
		  		$search .= " And type ='". $type."'";		  			
		  	}

		  	$orderby =' Order by name ASC';			

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
		    
		  	$emailSubsSet = $wpdb->get_results($query);
		  	
		  	if($emailSubsSet[0]->id)
		  	{
		  		return $emailSubsSet[0];	
		  	}
		  	else
		  	{
		  		return 0;
		  	}

    }

    public function write_log($email, $log)
    {
        if($this->logging==false)
        {
        	return;
        }

        $path = plugin_dir_path( __DIR__) ."includes/logs/";        
        if (!is_dir($path)) 
        {
            mkdir($path, 0777, true);
        }
        
        if($email)
		{

            if (is_array($log) || is_object($log))
            {
                $log = print_r($log, true);
                $log = ' : ' . $log . " \n ";
            }

        	$logfile = $path.$email."_".date("Ymd").".log";
        	file_put_contents($logfile, $log.PHP_EOL, FILE_APPEND | LOCK_EX);	
		}	
        
        return;
    }

}


// class MyHelloWorld{
//     use Utils;
// }

// $o = new MyHelloWorld();

// $option['to_mail'] = 'himanshu.u@crestinfosystems.com';
// $option['order_id'] = 'abc_123456';
// $option['amount'] = '100.00';
// $option['next_payment_date'] = '29/06/2018';
// $option['cancel_date'] = '29/06/2018';

//  $o->send_mail('payment_subscription_cancel_request',$option);

