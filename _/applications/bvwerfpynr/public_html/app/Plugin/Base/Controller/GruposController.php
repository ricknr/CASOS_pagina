<?php
//App::uses('AppController', 'Controller');
App::uses('AclComponent', 'Controller/Component');
/**
 * Grupos Controller
 *   
 * @property Grupo $Grupo
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class GruposController extends BaseAppController {

/**
 * Components
 *
 * @var array
 */
	public $uses = array('Base.Grupo');
	public $components = array('Paginator', 'Session');



	 public function beforeFilter() {
		 parent::beforeFilter();
		 #$this->Auth->allow();
	}
/**
 * admin_index method
 *
 * @return void
 */
 
	public function admin_index() {
		$this->Grupo->recursive = 0;
		//debug($this->Grupo->plugin);
		$conditions=array();		
		if ($this->request->is('post')) {
			// $conditions[] = array('Grupo.field LIKE' => '%'. $this->request->data['field'] . '%');
			// $this->request->data['field'] = $this->request->data['field'];
		}		
		$this->Paginator->settings = array(
			'conditions' => $conditions,
			//'contain' => array(),
			'order'=>array('Grupo.'.$this->Grupo->primaryKey => 'desc')
		);
		$grupos = $this->Paginator->paginate('Grupo');		
		/*
		$grupos = $this->Grupo->find('all', 
			array(        
				'conditions' =>$conditions,
				'order'=>array('Grupo.'.$this->Grupo->primaryKey => 'desc')
			)
		);	
		*/		
		$this->set(compact('grupos'));
		#$this->layout = 'Base.admin';
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Grupo->recursive = 1;	
		//debug($this->Grupo->plugin);
		if (!$this->Grupo->exists($id)) {
			throw new NotFoundException(__('Invalid grupo'));
		}
		$options = array('conditions' => array('Grupo.' . $this->Grupo->primaryKey => $id));
		$this->set('grupo', $this->Grupo->find('first', $options));

		$this->loadModel('Base.Aco');
		$this->Aco->displayField = 'alias';
		//$this->Aco->reorder(array());
		$acos = $this->Aco->find('all', 	array('recursive'=>0  ) 	);
		
		#deberiamos poder pasar esto al modelo ====================
		//debug($this->Aco->plugin);
		//acosd=$this->Aco->getAcosUrls($acos);		
		$i=0;
		foreach ($acos as $aco){
			$parents = $this->Aco->getPath($aco['Aco']['id']);
			$url='';
			foreach($parents as $parent){  
				$url=$url.'-'.$parent['Aco']['alias'];	
			}
			$url= ltrim ($url, '-');
			$acos[$i]['Aco']['url']=$url;
			$acos[$i]['Aco']['permiso']=$this->Acl->check( array('model' => 'Grupo', 'foreign_key' => $id) , str_replace('-', '/', $url) );
			$i++;			
			//debug($acl->check('Grupo::1', $parent['Aco']['alias'], '*'));
		}
		//debug($acos);
		#deberiamos poder pasar esto al modelo ====================	
		$this->set('acos',$acos);
		#$this->layout = 'Base.admin';
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Grupo->create();
			if ($this->Grupo->save($this->request->data)) {
				$this->Session->setFlash(__('El grupo se ha guardado.'), 'Base.flash_success' );
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'),'Base.flash_error' );
			}
		}
		#$this->layout = 'Base.admin';
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Grupo->exists($id)) {
			throw new NotFoundException(__('Invalid grupo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Grupo->save($this->request->data)) {
				$this->Session->setFlash(__('El grupo  se ha guardado.'), 'Base.flash_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error' );
			}
		} else {
			$options = array('conditions' => array('Grupo.' . $this->Grupo->primaryKey => $id));
			$this->request->data = $this->Grupo->find('first', $options);
		}
		#$this->layout = 'Base.admin';
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Grupo->id = $id;
		if (!$this->Grupo->exists()) {
			throw new NotFoundException(__('Invalid grupo'));
		}
		//debug($this->Grupo);die;
		$this->request->allowMethod('post', 'delete');
		if ($this->Grupo->delete()) {
			$this->Session->setFlash(__('El grupo se ha borrado.'), 'Base.flash_success');
		} else {
			$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error');
		}
		return $this->redirect(array('action' => 'index'));
		#$this->layout = 'Base.admin';
	}
	
/**
 * admin_permitir method
 *
 * @param string $grupo_id
  * @param string $url
 * @return void
 */
	public function admin_permitir( $grupo_id = null, $url=null) {
		
		$this->request->allowMethod('post');
		$this->Grupo->id = $grupo_id;
		
		$url=str_replace('-', '/', $url);
		
		if ($this->Acl->allow($this->Grupo , $url)) {
			$this->Session->setFlash(__('Se han actualizado los permisos.'), 'Base.flash_success');
		} else {
			$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error');
		}
		return $this->redirect($this->referer());
		#$this->layout = 'Base.admin';
	}	
/**
 * admin_denegar method
 *
 * @param string $grupo_id
  * @param string $url
 * @return void
 */
	public function admin_denegar( $grupo_id = null, $url=null) {
		
		$this->request->allowMethod('post');
		$this->Grupo->id = $grupo_id;		
		$url=str_replace('-', '/', $url);
		
		if ($this->Acl->deny($this->Grupo , $url)) {
			$this->Session->setFlash(__('Se han actualizado los permisos.'), 'Base.flash_success');
		} else {
			$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error');
		}
		return $this->redirect($this->referer());
		#$this->layout = 'Base.admin';
	}		
	
	
}
