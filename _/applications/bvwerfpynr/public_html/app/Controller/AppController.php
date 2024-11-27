<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('AuthComponent', 'Controller/Component');
App::uses('CakeTime', 'Utility');
App::uses('Sanitize', 'Utility');
App::uses('CakeEmail', 'Network/Email');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    public $helpers = array('Form', 'Html', 'Js', 'Session', 'Base.AclHtml');
    public $components = array(
        'Session', 
		'Acl',#ACL stuff ================================== 
		'Auth' => array(
			'loginAction' => '/login',
			'authError' => 'Did you really think you are allowed to see that?',
            #ACL stuff ==================================
			'authorize' => array(
                'Actions' => array('actionPath' => 'controllers', 'userModel' => 'Base.Usuario')
            ),
			#ACL stuff ==================================			
			'authenticate' => array(
				'all' => array ('scope' => array('Usuario.activo' => 1)),
				'Form' => array(
					'userModel' => 'Base.Usuario',
					'fields' => array('username' => 'usuario') ,					
					'passwordHasher' => array(
						'className' => 'Simple',
						'hashType' => 'sha256'
					)
					
				)
        	),
        )
    );	
	
	
	
	
	public function beforeFilter(){
		$this->layout = 'Base.default';
		
		if(0 === Configure::read('Auth.enabled')) {
			$this->Auth->allow();
		}
	}	
	
	public function beforeRender() {
		$boleano = array(0=>" <i class='fa fa-times-circle text-danger'></i> ",1=>" <i class='fa fa-check-circle text-success'></i> ", 2=>" <i class='fa fa-times-circle text-danger'></i> ");
		$banned = array(0=>" <i class='fa fa-check-circle text-success'></i> ",1=>" <i class='fa fa-times-circle text-danger'></i> ");
		$this->set(compact('banned', 'boleano'));
		
		if (!$this->Auth->loggedIn()) {
			//$this->Auth->authError = false;
		}	
	}



    public function _pdf_content($vars = array(), $header_file = ''){
        $this->autoRender = false;
        $view = new View($this, false);
        return $view->element($header_file, $vars);
    }
	
	
    
}
