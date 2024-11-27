<?php
App::uses('Component', 'Controller');


class NotificacionComponent extends Component{


  /**
   * Array con la repsuesta al controlador
   * @var string
  */
  	public $response = array();


	public function __construct( ComponentCollection $collection , array $settings = array() ){

  	}

  	/**
  	*	Recibe un array. Los indices que se necesitan son los siguientes.
  	*
	*	to => array: Recibe las direcciones de correo a las que se notifica (Obligatorio)
	*	subjet => string: Subject del mail (Obligatorio)
	*	body => string: Contenido del mail  //TODO Revisar si este parametro aun va a aplicar
	*	html => boolean: Sirve para especificar si el mail que se envia es con formato HTML
	*	template => string: Template con el que se mandara el mail en caso de que se establesca
	*	config => string: Configuracion con la que se enviara el mail, si no recibe nada, sale con DEFAULT
  * var => array: Variables que se establecen en el template. array('variable1'=>true,'variable2'=>array(x=>y,x=>y),'variable3'=>$variableX);
	*/
  	public function notifica($parameters = array()){
  		if (empty($parameters)) {
  			$this->response['error'] = true;
  			$this->response['msj'] = 'No se establecieron parametros.';
  			return $this->response;
  		}

  		if (empty($parameters['to']) || !isset($parameters['to'])) {
  			$this->response['error'] = true;
  			$this->response['msj'] = 'No hay destinatarios asignados';
  			return $this->response;
  		}

  		if (empty($parameters['subject']) || !isset($parameters['subject'])) {
  			$this->response['error'] = true;
  			$this->response['msj'] = 'No hay un subject asignado';
  			return $this->response;
  		}

  		$email = new CakeEmail('default');
  		if (isset($parameters['config']) && !empty($parameters['config'])) {
  			$email = new CakeEmail($parameters['config']);
  		}

  		$to = array();
		  $email->to($parameters['to']);
		  $email->subject($parameters['subject']);
		// $mensaje = $parameters['body'];

		#//Si tiene un template, se asigna
		if (!empty($parameters['template']) && isset($parameters['template'])) {
			$email->template($parameters['template']);
		}

		if (isset($parameters['html']) && $parameters['html']) {
		    $email->emailFormat('html');
		}

    if (isset($parameters['var']) && !empty($parameters['var'])) {
      // $email->viewVars(compact('client', 'data'));
      $vars = array();
      foreach ($parameters['var'] as $key => $value) {
        $vars[$key] = $value;
      }
      $email->viewVars($vars);
    }

    if (isset($parameters['bcc']) && $parameters['bcc']) {        
        $email->bcc($parameters['bcc']);
    }

    if (isset($parameters['cc']) && $parameters['cc']) {
        $email->cc($parameters['cc']);
    }

    $logo_path = WWW_ROOT.'img/'."logo_verde_chico.png";
    $embeds = array();
    $embeds['logo_verde_chico.png'] = array(
        'file' => $logo_path,
        'mimetype' => 'image/png',
        'contentId' => 'logo_verde'
    );  

    if (isset($parameters['embeds']) && $parameters['embeds']) {
        foreach ($parameters['embeds'] as $k => $attach) {
            $embeds[$k] = array(
                'file' => $attach['file'],
                'mimetype' => $attach['mimetype'],
                'contentId' => $attach['contentId']
            );  
        }
    }

    // debug($embeds);die;    

    #// Atacch de imagen para header del layout
    $email->attachments($embeds);

		try {
			// $email->send($mensaje);
      $email->send();
      // die(); 
			$this->response['error'] = false;
  			$this->response['msj'] = 'ok';
		} catch (SocketException $e) {
			$this->response['error'] = true;
  			$this->response['msj'] = $e->getMessage();
  			$this->response['errorCode'] = $e->getCode();
		}
  		return $this->response;
  	}

}
?>
