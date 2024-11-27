<?php
//App::uses('AppController', 'Controller');

/**
 * Acos Controller
 *
 * @property Aco $Aco
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AcosController extends BaseAppController {

/**
 * Components
 *
 * @var array
 */
	public $uses = array('Base.Aco'); 
	public $components = array('Paginator', 'Session');
	



	 public function beforeFilter() {
		 parent::beforeFilter();
		 # $this->Auth->allow();
	}
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Aco->recursive = 0;		
		$conditions=array();		
		if ($this->request->is('post')) {
			// $conditions[] = array('Aco.field LIKE' => '%'. $this->request->data['field'] . '%');
			// $this->request->data['field'] = $this->request->data['field'];
		}		
		$this->Paginator->settings = array(
			'conditions' => $conditions,
			//'contain' => array(),
			'order'=>array('Aco.id'=> 'asc')
		);
		$acos = $this->Paginator->paginate('Aco');
	
		/*
		$acos = $this->Aco->find('all', 
			array(        
				'conditions' =>$conditions,
				'order'=>array('Aco.'.$this->Aco->primaryKey => 'desc')
			)
		);	
		*/		
		$this->set(compact('acos'));
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
		if (!$this->Aco->exists($id)) {
			throw new NotFoundException(__('Invalid aco'));
		}
		$options = array('conditions' => array('Aco.' . $this->Aco->primaryKey => $id));
		$this->set('aco', $this->Aco->find('first', $options));
	 $this->layout = 'Base.admin';
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Aco->create();
			if ($this->Aco->save($this->request->data)) {
				$this->Aco->id = null;
				$this->Aco->reorder();
				$this->Session->setFlash(__('El aco se ha guardado.'), 'Base.flash_success' );
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'),'Base.flash_error' );
			}
		}
		//debug($this->Aco->plugin);
		$this->Aco->displayField = 'alias';
		//$parentAcos = $this->Aco->find('list',array('fields'=>array('id','alias')));
		$parentAcos = $this->Aco->generateTreeList();
		$aros = $this->Aco->Aro->find('list');
		$this->set(compact('parentAcos', 'aros'));
	 $this->layout = 'Base.admin';
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Aco->exists($id)) {
			throw new NotFoundException(__('Invalid aco'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Aco->save($this->request->data)) {
				$this->Aco->id = null;
				$this->Aco->reorder();
				$this->Session->setFlash(__('El aco  se ha guardado.'), 'Base.flash_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error' );
			}
		} else {
			$options = array('conditions' => array('Aco.' . $this->Aco->primaryKey => $id));
			$this->request->data = $this->Aco->find('first', $options);
		}
		$this->Aco->displayField = 'alias';
		//$parentAcos = $this->Aco->ParentAco->find('list');
		$parentAcos = $this->Aco->generateTreeList();
		$aros = $this->Aco->Aro->find('list');
		$this->set(compact('parentAcos', 'aros'));
	 $this->layout = 'Base.admin';
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Aco->id = $id;
		if (!$this->Aco->exists()) {
			throw new NotFoundException(__('Invalid aco'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Aco->delete()) {
				$this->Aco->id = null;
				$this->Aco->reorder();
			$this->Session->setFlash(__('El aco se ha borrado.'), 'Base.flash_success');
		} else {
			$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error');
		}
		return $this->redirect(array('action' => 'index'));
	 $this->layout = 'Base.admin';
	}
	

	
	
	
}
