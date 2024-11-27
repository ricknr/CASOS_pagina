<?php
class BaseAppController extends AppController {
	var $components = array('RequestHandler', 'Base.AclManager', 'Base.AclReflector');
	var $helpers = array('Base.AclHtml');
	
	function beforeFilter(){
	    parent :: beforeFilter();	    
		$this->AclManager->set_session_permissions();
		
		
	}
	
	
}

