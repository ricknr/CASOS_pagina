<?php
App::uses('AppController', 'Controller');
/**
 * PreguntasEncuestas Controller
 *
 * @property PreguntaEncuesta $PreguntaEncuesta
 * @property PaginatorComponent $Paginator
 */
class PreguntasEncuestasController extends AppController {

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
		$this->PreguntaEncuesta->recursive = 0;		
		$conditions=array();
		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'order'=>array('Pregunta_Encuesta.'.$this->PreguntaEncuesta->primaryKey => 'desc')
		);
		$preguntasencuestas = $this->Paginator->paginate('Pregunta_Encuesta');		
		/*
		$categorias = $this->Categoria->find('all', 
			array(        
				'conditions' =>$conditions,
				'order'=>array('Categoria.'.$this->Categoria->primaryKey => 'desc')
			)
		);	
		*/		
		$this->set(compact('preguntasencuestas'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		
	}
}
