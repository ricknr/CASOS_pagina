<?php
App::uses('AppController', 'Controller');
/**
 * Preguntas Controller
 *
 * @property Pregunta $Pregunta
 * @property PaginatorComponent $Paginator
 */
class PreguntasController extends AppController {
    var $name = 'Preguntas';
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');



	 public function beforeFilter() {
		 parent::beforeFilter();
		//$this->Auth->allow('email_data');
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->set( 'preguntas', $this->Pregunta->find('all') );
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null,$caso_id = null) {
		
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null,$caso_id = null) {
		
	}

	public function email_data(){
	
	}

}
