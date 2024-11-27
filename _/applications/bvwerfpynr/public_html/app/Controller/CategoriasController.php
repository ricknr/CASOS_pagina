<?php
App::uses('AppController', 'Controller');
/**
 * Categorias Controller
 *
 * @property Categoria $Categoria
 * @property PaginatorComponent $Paginator
 */
class CategoriasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');



	 public function beforeFilter() {
		 parent::beforeFilter();
		  # $this->Auth->allow();
	}
/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Categoria->recursive = 0;		
		$conditions=array();		
		if ($this->request->is('post')) {
			// $conditions[] = array('Categoria.field LIKE' => '%'. $this->request->data['field'] . '%');
			// $this->request->data['field'] = $this->request->data['field'];
		}		
		$this->Paginator->settings = array(
			'conditions' => $conditions,
			//'contain' => array(),
			'order'=>array('Categoria.'.$this->Categoria->primaryKey => 'desc')
		);
		$categorias = $this->Paginator->paginate('Categoria');		
		/*
		$categorias = $this->Categoria->find('all', 
			array(        
				'conditions' =>$conditions,
				'order'=>array('Categoria.'.$this->Categoria->primaryKey => 'desc')
			)
		);	
		*/		
		$this->set(compact('categorias'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Categoria->exists($id)) {
			throw new NotFoundException(__('Invalid categoria'));
		}
		$options = array('conditions' => array('Categoria.' . $this->Categoria->primaryKey => $id));
		$this->set('categoria', $this->Categoria->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Categoria->create();
			if ($this->Categoria->save($this->request->data)) {
				$this->Session->setFlash(__('El categoria se ha guardado.'), 'Base.flash_success' );
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'),'Base.flash_error' );
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Categoria->exists($id)) {
			throw new NotFoundException(__('Invalid categoria'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Categoria->save($this->request->data)) {
				$this->Session->setFlash(__('El categoria  se ha guardado.'), 'Base.flash_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error' );
			}
		} else {
			$options = array('conditions' => array('Categoria.' . $this->Categoria->primaryKey => $id));
			$this->request->data = $this->Categoria->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Categoria->id = $id;
		if (!$this->Categoria->exists()) {
			throw new NotFoundException(__('Invalid categoria'));
		}

		$this->request->allowMethod('post', 'delete');
		#//Revisamos si la categoría tiene casos asignados
		$casos = $this->Categoria->Caso->find('count',array(
			'conditions'=>array('Caso.categoria_id'=>$id),
		));

		if ($casos == 0) {
			if ($this->Categoria->delete()) {
				$this->Session->setFlash(__('El categoria se ha borrado.'), 'Base.flash_success');
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error');
			}
		}else{
			#//Inactivamos la categoría
			$update = array();
			$update['Categoria']['id'] = $id;
			$update['Categoria']['activo'] = 0;
			if ($this->Categoria->save($update)) {
				$this->Session->setFlash(__('El categoria se ha inactivado. No se puede eiminar por tener casos asignados.'), 'Base.flash_success');
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error');
			}
		}
		return $this->redirect(array('action' => 'index'));
	}
}
