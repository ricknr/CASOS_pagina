<?php

class UsuariosController extends BaseAppController{

/**
 * Components
 *
 * @var array
 */
	public $uses = array('Base.Usuario');
	public $components = array('Paginator',  'Base.AclManager');


	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('recover', 'code', 'login', 'logout','createsessionbar','admin_change_password'));
		#$this->Auth->allow();
	}
	 
/**
 * login method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */



	public function login(){
		App::import('Model','Cliente');
		
		$this->set('title_for_layout', 'Login');		
		if(AuthComponent::user('id')) return $this->redirect(AuthComponent::user('Grupo.redirect'));	
		
		if ($this->request->is('post')) {			
			App::Import('Utility', 'Validation');			
			if( isset($this->data['Usuario']['usuario']) && Validation::email($this->data['Usuario']['usuario'])) {
			  $this->request->data['Usuario']['correo'] = $this->data['Usuario']['usuario'];
			  $this->Auth->authenticate['Form']['fields'] = array('username' => 'correo');
			}
			
			if ($this->Auth->login()){				
				$this->AclManager->set_session_permissions();
				$lastURL=$this->Auth->redirect();
				// if( isset($lastURL) && !empty($lastURL) &&  $lastURL != "/"){
				// 	return $this->redirect($lastURL);
				// }
				return $this->redirect(AuthComponent::user('Grupo.redirect'));
			} else {
				$this->Session->setFlash(__("El usuario o la contraseña estan incorrectos"), 'Base.flash_warning' );
			}
		}
		$this->layout = 'Base.login';
	}
	
	public function logout(){        
		$this->Auth->logout();
		$this->Session->destroy();
		$this->Session->setFlash("Ha salido del sistema.", 'Base.flash_warning');    // Set Flash message
		$this->redirect('/login');
	}	
/**
 * code method
 * 
  * @param string $code
 * @return void
 */	
	public function code($code = null){	
		
		if(!$code)  $this->redirect('/recover');
		$this->loadModel('Recover');
		$ticket = $this->Recover->find('first', array(
			'conditions'=> array(
				'Recover.code' => $code,
			)
		));

		if($ticket){
			if(strtotime($ticket['Recover']['created']) >= strtotime('-30 minutes')){
				# Ticket valido
				if($this->request->is('post')){
					 //debug($this->request->data);die;

						$data = array(
							'id' => $ticket['Recover']['usuario_id'],
							'password' => $this->request->data['Usuario']['password'],
							'password_confirma' => $this->request->data['Usuario']['password_confirma']
						);
						if($this->Usuario->save($data)){
							$this->Session->setFlash('Se ha cambiado la contraseña correctamente, favor de iniciar sesión.', 'Base.flash_success');
							$this->loadModel('Recover');
							$this->Recover->delete($ticket['Recover']['id']);
							$usuarioRecover = $this->Usuario->find('first',array(
								'conditions' => array(
									'Usuario.id' => $ticket['Recover']['usuario_id']
									)
								));
							
							$this->redirect('/login');							

						}else{
							$this->Session->setFlash('No se pudo guardar la contraseña. Por favor reintente.', 'Base.flash_error');
						}
					
				}
			}else{
				$this->Recover->delete($ticket['Usuario']['id']);
				$this->Session->setFlash('El código de recuperación ya caducó', 'Base.flash_error');
				$this->redirect('/login');
			}
		}else{
			$this->Session->setFlash('No existe el código de recuperación proporcionado', 'Base.flash_error');
			$this->redirect('/login');
		}
		$this->layout = 'Base.login';
	}	

/**
 * recover method
 * 
 * @return void
 */
	public function recover(){
		if($this->request->is('post')){
			if($this->request->data['recover']){
				$this->Usuario->recursive= -1;
				$usuario = $this->Usuario->find('first',array(
						'conditions'=>array(
								'Usuario.correo'=>$this->request->data['recover']
							)
					));
						
				if($usuario){
					$data = array();
					$data = array(
						'code' => md5(uniqid().$usuario['Usuario']['id']),
						'usuario_id' => $usuario['Usuario']['id']
					);
					
					$this->loadModel('Recover');
					$this->Recover->create();
					
					if($this->Recover->save($data)){
						App::uses('CakeEmail', 'Network/Email');
						$email = new CakeEmail('sendgrid');
						$email->to(array($usuario['Usuario']['correo'] => $usuario['Usuario']['nombre']));
						//$email->from(array('plugin@mail.com' => 'Contacto'));
						//$email->sender(array('plugin@mail.com' => 'Contacto'));
						$email->viewVars(compact('client', 'data'));
						$email->subject('Recuperación de contraseña');                
						$email->emailFormat('html');
						$email->template('Base.recover');
						if($email->send()){
							$this->Session->setFlash('Se le ha enviado el código de recuperación al correo registrado.', 'Base.flash_success');
							$this->redirect('/login');							
						}
												
					}else{						
						$this->Session->setFlash('No se pudo generar el código de recuperación', 'Base.flash_error');
						$this->redirect('/login');							
					}
				}else{					
					$this->Session->setFlash('No se encontro el mail proporcionado', 'Base.flash_warning');
					$this->redirect('/login');							
				}
			}
		}
		$this->layout = 'Base.login';
	}	
	
/**
 * view method
 * @throws NotFoundException
 * @param string $id
 * 
 * @return void
 */
	public function view($id = null){
		if (!$this->Usuario->exists($id)) {
			#throw new NotFoundException(__('Invalid usuario'));
			$this->Session->setFlash(__('Usuario invalido.'),'Base.flash_error' );
			$this->redirect(array('action'=>'index'));
		}
		
		if ( (AuthComponent::user('grupo_id') != 1 && AuthComponent::user('grupo_id') != 2) &&  AuthComponent::user('id') != $id) {
			$this->Session->setFlash(__('No tienes acceso a esta información'),'Base.flash_error' );
			$this->redirect('/');
		}

		$options = array('conditions' => array('Usuario.' . $this->Usuario->primaryKey => $id));
		$this->set('usuario', $this->Usuario->find('first', $options));
	}	
/**
 * edit_password method
 * @throws Invalid Usuario
 * @param string $id
 * 
 * @return void
 */
	public function edit_password($id = null){
		$this->Usuario->id = $id;
		if (!$this->Usuario->exists()) {
			#throw new NotFoundException(__('Invalid Usuario'));
			$this->Session->setFlash(__('Usuario invalido.'),'Base.flash_error' );
			$this->redirect(array('action'=>'index'));
		}

		if ( (AuthComponent::user('grupo_id') != 1 && AuthComponent::user('grupo_id') != 2) ||  AuthComponent::user('id') != $id) {
			$this->Session->setFlash(__('No tienes acceso a esta información'),'Base.flash_error' );
			$this->redirect('/');
		}

		if($this->request->is('post')){			
			

			if ($this->request->data['Usuario']['password'] != $this->request->data['Usuario']['password_confirma']) {
				$this->Session->setFlash(__('Las contraseñas no coinciden.'), 'Base.flash_error');
				$this->redirect(array('action' => 'view',$id));
			}


			if($this->Usuario->save($this->request->data)){
				$this->Session->setFlash(__('La contraseña fue actualizada.'), 'Base.flash_success');
				$this->redirect(array('action' => 'view',$id));
			}else{
				$this->Session->setFlash(__('La contraseña no pude ser actualizada.'), 'Base.flash_error');
				$this->redirect(array('action' => 'view',$id));
			}

		}

		// $usuario = $this->Usuario->find('first',array('conditions'=>array('Usuario.id'=>AuthComponent::user('id'))));
		// $this->set('usuario',$usuario);		
		// $this->set(compact('usuario'));
	}


	#FUNCION PARA EDITAR LA CONTRASEÑA DE UN USUARIO	
	public function admin_change_password($usuario_id = null){
		if(empty($usuario_id) ){
			$this->Session->setFlash(__('Usuario incorrecto. Intentelo de nuevo.'), 'Base.flash_error');
			return $this->redirect(array('action'=>'index'));
		}

		if ( (AuthComponent::user('grupo_id') != 1 && AuthComponent::user('grupo_id') != 2) &&  AuthComponent::user('id') != $id) {
			$this->Session->setFlash(__('No tienes acceso a esta información'),'Base.flash_error' );
			$this->redirect('/');
		}
		$this->Usuario->id = $usuario_id;
		if (!$this->Usuario->exists()) {

			$this->Session->setFlash(__('Usuario invalido.'),'Base.flash_error' );
			$this->redirect(array('action'=>'index'));
		}
		if($this->request->is('post')){

			if($this->Usuario->save($this->request->data)){
				$this->Session->setFlash(__('La contraseña fue actualizada.'), 'Base.flash_success');
				$this->redirect(array('admin'=>true, 'action' => 'index'));
			}else{
				$this->Session->setFlash(__('La contraseña no pude ser actualizada.'), 'Base.flash_error');
				$this->redirect(array('admin'=>true, 'action' => 'index'));
			}

		}
		$usuario = $this->Usuario->find('first',array('conditions'=>array('Usuario.id'=>$usuario_id)));

		$this->set('usuario',$usuario);
		$this->render('edit_password');
	}
	
/*
 * index function
 * @return void
 */
	public function admin_index(){
		//debug($this->Usuario->plugin);
		$estatus='todos';
		$limit = 20;
		$this->Usuario->Grupo->recursive = -1;
		$grupos = $this->Usuario->Grupo->find('list',array('order'=>'nombre'));
		$conditions = "";
		$grupo = 0;
		$nombre = '';
		$tipo_registro = '';

		if($this->request->is('ajax')){
			$this->layout = 'ajax';
			$estatus = $this->request->data['estatus'];
			$limit	 = $this->request->data['limit'];
			$grupo 	 = $this->request->data['grupo'];
			$nombre  = $this->request->data['nombre'];
			$tipo_registro = $this->request->data['tipo_registro'];
			if($grupo >0){
				$conditions = array('Usuario.grupo_id'=>$grupo);
			}
			if($estatus!='todos'){
				$conditions['AND'][] = array('Usuario.activo'=>$estatus);
			}

			if (!empty($nombre)) {				
				$conditions['AND'][] = array('Usuario.nombre LIKE' => '%'. $nombre . '%');
			}

			if (!empty($tipo_registro)) {
				if ($tipo_registro == 'fb') {
					$conditions['AND'][] = array('Usuario.facebook_id !=' =>'');
				}else{
					$conditions['AND'][] = array('Usuario.facebook_id is null');
				}
			}


		}

		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'limit'=>$limit,
			'order'=>'Usuario.created DESC'
		);
		$this->set('grupos',$grupos);
		$this->set('grupo',$grupo);
		$this->set('limit',$limit);
		$this->set('estatus',$estatus);
		$this->set('nombre',$nombre);
		$this->set('tipo_registro',$tipo_registro);
		$this->set('usuarios', $this->Paginator->paginate());

	}



/*
 * add function
 * @return void
 */
	public function admin_add(){
		if($this->request->is('post')){
			
			#debug($this->request->data);die;
			
			#Validamos que no exista el correo 
			$existe_mail = $this->Usuario->find('first',array(
				'conditions'=>array('Usuario.correo'=>$this->request->data['Usuario']['correo'],
									'Usuario.grupo_id !=' => 4), //grupo usuario app movil
				'recursive'=>-1
			));
			if (!empty($existe_mail)) {
				$this->Session->setFlash(__('Ya existe un usuario registrado con esa dirección de correo.'), 'Base.flash_error');
			}
			else{
				$this->Usuario->create();
				if($this->Usuario->save($this->request->data)){
					$this->Session->setFlash(__('El usuario fue agregado con éxito.'), 'Base.flash_success');
					$this->redirect(array('action' => 'index'));
				}
				else{
					$this->Session->setFlash(__('El usuario no pudo ser agregado.'), 'Base.flash_error');
				}
			}
		}
		#//Socios se crean cuando agregas un nuevo cliente
		$grupos = $this->Usuario->Grupo->find('list',array(			
			'fields'=>array('nombre'),
			'order'=>array('Grupo.nombre'=>'asc')) 
		);		
		$this->set(compact('grupos'));
		// $this->layout = 'Base.admin';
	}
/**
 * edit method
 * @throws NotFoundException
 * @param string $id
 * 
 * @return void
 */
	public function admin_edit($id = null){
		$this->Usuario->id = $id;
		if (!$this->Usuario->exists()) {
			#throw new NotFoundException(__('Invalid Usuario'));
			$this->Session->setFlash(__('Usuario invalido.'),'Base.flash_error' );
			$this->redirect(array('action'=>'index'));
		}

		if ( (AuthComponent::user('grupo_id') != 1 && AuthComponent::user('grupo_id') != 2) &&  AuthComponent::user('id') != $id) {
			$this->Session->setFlash(__('No tienes acceso a esta información'),'Base.flash_error' );
			$this->redirect('/');
		}

		if($this->request->is(array('post', 'put'))){			
			if($this->Usuario->save($this->request->data)){
				$this->Session->setFlash(__('El usuario fue editado con éxito.'), 'Base.flash_success');

				if (AuthComponent::user('grupo_id') == 1 || AuthComponent::user('grupo_id') == 2) {					
					return $this->redirect(array('action' => 'index'));
				}else{
					return $this->redirect('/base/usuarios/view/'.$id);
				}
			}
			$this->Session->setFlash(__('El usuario no pudo ser editado.'), 'Base.flash_error');
		}
		$options = array('conditions' => array('Usuario.' . $this->Usuario->primaryKey => $id));
		$this->request->data = $this->Usuario->find('first', $options);
		$usuario = $this->request->data;

		$grupos = $this->Usuario->Grupo->find('list',array('fields'=>array('nombre'), 'order'=>'nombre') );		

		$this->set(compact('grupos', 'usuario','es_socio'));
		
	}

	


/**
 * delete method
 * @throws NotFoundException
 * @param string $id
 * 
 * @return void
 */
	//public function delete($id = null){
	//	$this->Usuario->id = $id;
	//	if (!$this->Usuario->exists()) {
	//		throw new NotFoundException(__('Invalid Usuario'));
	//	}
	//	$data = array(
	//			'Usuario'=>array(
	//					'id'=>$id,
	//					'activo'=>0
	//				)
	//		);
	//	if ($this->Usuario->save($data)) {
	//		$this->Session->setFlash(__('El usuario fue eliminado con éxito.'), 'base.flash_success');
	//	} else {
	//		$this->Session->setFlash(__('El usuario no pudo ser eliminado. Porfavor intente de nuevo'), 'base.flash_error');
	//	}
	//	return $this->redirect(array('action' => 'index'));
	//}
	
	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Usuario invalido.', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Usuario->delete($id)) {
			$this->Session->setFlash(__('El usuario fue eliminado con éxito.'), 'Base.flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('El usuario no pudo ser eliminado. Porfavor intente de nuevo'), 'Base.flash_error');
		$this->redirect(array('action' => 'index'));
		$this->layout = 'Base.admin';
	}
	
	#funcion para desplegar el menu de acuerdo a una sesion.
	function createsessionbar(){
		#echo "<pre>"; print_r( $_SESSION['mini-navbar'] ); echo "</pre>";die;
		if(!empty($_SESSION['mini-navbar'])){
			//session_unset($_SESSION['mini-navbar']);
			$this->Session->delete('mini-navbar');
			die('eliminada');
		}else{
			$_SESSION['mini-navbar']==1;
			$this->Session->write('mini-navbar','1');
			die('creada');
		}
	}


}
?>