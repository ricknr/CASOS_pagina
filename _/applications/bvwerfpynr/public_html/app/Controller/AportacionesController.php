<?php
App::uses('AppController', 'Controller');
/**
 * Aportaciones Controller
 *
 * @property Aportacion $Aportacion
 * @property PaginatorComponent $Paginator
 */
class AportacionesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');



	 public function beforeFilter() {
		 parent::beforeFilter();
		$this->Auth->allow('email_data');
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->layout = 'public';
		$this->Aportacion->recursive = 0;
		$conditions=array();
		$this->Paginator->settings = array(
			'conditions' => $conditions,
			//'contain' => array(),
			'order'=>array('Aportacion.'.$this->Aportacion->primaryKey => 'desc')
		);
		$aportaciones = $this->Paginator->paginate('Aportacion');				
		$this->set(compact('aportaciones'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Aportacion->exists($id)) {
			throw new NotFoundException(__('Invalid aportacion'));
		}
		$options = array('conditions' => array('Aportacion.' . $this->Aportacion->primaryKey => $id));
		$this->set('aportacion', $this->Aportacion->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Aportacion->create();
			if ($this->Aportacion->save($this->request->data)) {
				$this->Session->setFlash(__('El aportacion se ha guardado.'), 'Base.flash_success' );
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'),'Base.flash_error' );
			}
		}
		$casos = $this->Aportacion->Caso->find('list');
		$this->set(compact('casos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Aportacion->exists($id)) {
			throw new NotFoundException(__('Invalid aportacion'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Aportacion->save($this->request->data)) {
				$this->Session->setFlash(__('El aportacion  se ha guardado.'), 'Base.flash_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error' );
			}
		} else {
			$options = array('conditions' => array('Aportacion.' . $this->Aportacion->primaryKey => $id));
			$this->request->data = $this->Aportacion->find('first', $options);
		}
		$casos = $this->Aportacion->Caso->find('list');
		$this->set(compact('casos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Aportacion->id = $id;
		if (!$this->Aportacion->exists()) {
			throw new NotFoundException(__('Invalid aportacion'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Aportacion->delete()) {
			$this->Session->setFlash(__('El aportacion se ha borrado.'), 'Base.flash_success');
		} else {
			$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error');
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Aportacion->recursive = 0;		
		$conditions=array();		
		if ($this->request->is('post')) {
			// $conditions[] = array('Aportacion.field LIKE' => '%'. $this->request->data['field'] . '%');
			// $this->request->data['field'] = $this->request->data['field'];
		}		
		$this->Paginator->settings = array(
			'conditions' => $conditions,
			//'contain' => array(),
			'order'=>array('Aportacion.'.$this->Aportacion->primaryKey => 'desc')
		);
		$aportaciones = $this->Paginator->paginate('Aportacion');		
		/*
		$aportaciones = $this->Aportacion->find('all', 
			array(        
				'conditions' =>$conditions,
				'order'=>array('Aportacion.'.$this->Aportacion->primaryKey => 'desc')
			)
		);	
		*/		
		$this->set(compact('aportaciones'));
	 $this->layout = 'Base.admin';
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Aportacion->exists($id)) {
			throw new NotFoundException(__('Invalid aportacion'));
		}
		$options = array('conditions' => array('Aportacion.' . $this->Aportacion->primaryKey => $id));
		$this->set('aportacion', $this->Aportacion->find('first', $options));
	 $this->layout = 'Base.admin';
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Aportacion->create();
			if ($this->Aportacion->save($this->request->data)) {
				$this->Session->setFlash(__('La aportacion se ha guardado.'), 'Base.flash_success' );
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'),'Base.flash_error' );
			}
		}
		$casos = $this->Aportacion->Caso->find('list');
		$this->set(compact('casos'));
	 $this->layout = 'Base.admin';
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null,$caso_id = null) {
		if (!$this->Aportacion->exists($id)) {
			throw new NotFoundException(__('Invalid aportacion'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Aportacion->save($this->request->data)) {
				$this->Session->setFlash(__('La aportacion  se ha editado.'), 'Base.flash_success');
				if (isset($caso_id) && $caso_id > 0) {
					return $this->redirect(array('action' => 'view','controller'=>'casos','admin'=>true,$caso_id));	
				}
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error' );
			}
		} else {
			$options = array('conditions' => array('Aportacion.' . $this->Aportacion->primaryKey => $id));
			$this->request->data = $this->Aportacion->find('first', $options);
		}
		$casos = $this->Aportacion->Caso->find('list');
		$this->set(compact('casos'));
	 $this->layout = 'Base.admin';
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null,$caso_id = null) {
		$this->Aportacion->id = $id;
		if (!$this->Aportacion->exists()) {
			throw new NotFoundException(__('Invalid aportacion'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Aportacion->delete()) {
			$this->Session->setFlash(__('La aportacion se ha borrado.'), 'Base.flash_success');
		} else {
			$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error');
		}

		if (isset($caso_id) && $caso_id > 0) {
			return $this->redirect(array('controller'=>'casos','action' => 'view','admin'=>true,$caso_id));	
		}
		return $this->redirect(array('action' => 'index'));
	 $this->layout = 'Base.admin';
	}

	public function email_data(){
		if( $this->request->is('ajax') ) {
			//die(json_encode($this->request->data('email')));
			// Get address user from contributions,
			// this data autoload all the inputs.
			$sql = "select calle_y_numero, colonia, estado, municipio, ciudad, pais, cp,rfc
					from aportaciones 
					where mail_donador = ".json_encode($this->request->data('email'))." AND rfc != '' limit 1;";
			// Get the result of the query. 
			$resultadoQuery = $this->Aportacion->query($sql);
			// Parse the information of the result.
			$JsonEncode = json_encode($resultadoQuery);
			// Send the informacion to ajax.
			die($JsonEncode);						
		}  
		
	}

}
