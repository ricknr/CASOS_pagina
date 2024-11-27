<?php
App::uses('AppController', 'Controller');
/**
 * Encuestas Controller
 *
 * @property Encuesta $Encuesta
 * @property PaginatorComponent $Paginator
 */
class EncuestasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');



	 public function beforeFilter() {
		 parent::beforeFilter();
		  $this->Auth->allow('admin_index','admin_view');
	}
/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Encuesta->recursive = 0;
		$condiciones['AND'] = array(1 => 1);

		if ($this->request->is('ajax') || $this->request->is('post')) {
			if ($this->request->is('ajax')) {
				$this->layout = 'ajax';				
			}
			
			if (!empty($this->request->data['caso'])) {	
				$this->loadModel('Caso');
				$conditions = $this->Caso->find('all', array(
					'conditions' => array('Caso.titulo LIKE' => '%'. $this->request->data['caso'] . '%')
				));
				$this->loadModel('Aportacion');
				$QueryGetCaso = $this->Caso->query('SELECT DISTINCT aportaciones.id FROM casos,aportaciones WHERE aportaciones.caso_id = casos.id AND casos.titulo LIKE' . '"%' . $this->request->data['caso'] . '%"' . 'AND casos.activo = true;');
				
				for($i=0; $i<count($QueryGetCaso); $i++){
					$getArray[$i] = (int)$QueryGetCaso[$i]['aportaciones']['id'];
				}
				// Implode para agregar coma
				$condiciones['AND'] = array('Aportacion.id' => $getArray);
			}
			
		}
		$this->Encuesta->Behaviors->attach('Containable');
		$this->paginate = array( 
			'contain'=> array(
				'Pregunta_Encuesta'=>'Pregunta',
				'Aportacion'=> 'Caso'
			),
			'conditions' => array($condiciones),
		);
			
		$encuestas = $this->paginate();

		$this->set('encuestas', $encuestas);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Encuesta->exists($id)) {
			throw new NotFoundException(__('Invalid categoria'));
		}
		
		$this->Encuesta->Behaviors->load('Containable');
		$encuestasInfo = $this->Encuesta->find('first', array(
			'conditions' => array(
				'Encuesta.' . $this->Encuesta->primaryKey => $id),
			'contain'=> array(
				'Pregunta_Encuesta'=>array('Pregunta'), 
				'Aportacion'=>array('Caso')
			),
			'order' => 'Encuesta.id ASC'
		));

		//debug($encuestasInfo); die;

		$this->set('encuesta', $encuestasInfo);
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
				$this->Session->setFlash(__('El encuesta se ha guardado.'), 'Base.flash_success' );
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
				$this->Session->setFlash(__('El encuesta  se ha guardado.'), 'Base.flash_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error' );
			}
		} else {
			$options = array('conditions' => array('Encuesta.' . $this->Encuesta->primaryKey => $id));
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
		$this->Encuesta->id = $id;
		if (!$this->Encuesta->exists()) {
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
