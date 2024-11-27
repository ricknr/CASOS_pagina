<?php

if (!defined('ABSPATH')) {
    exit;
}

trait EpagosUtils
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
    
	  /*
	   * Crea la estructura basica de curl para la ejecución de los diferentes webservices
	   * */
	  public function curl_sender($url, $headers = null, $postData = '', $ssl_verify = 0){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);	 // URL API

		if (is_array($headers)){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  // Cabeceras API
		}
		if ($postData != ''){
			curl_setopt($ch, CURLOPT_POST, 1);				 // Peticiones POST
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);	 // Mandamos el Json
		}
 		curl_setopt($ch, CURLOPT_HEADER,0);  			 //Retornar cabeceras
 		curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);    //Retornar datos de llamada
 		// Se ignora verificacion de ssl del servidor
 		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $ssl_verify);
 		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $ssl_verify);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	  }

}
