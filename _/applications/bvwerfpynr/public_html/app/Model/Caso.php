<?php
App::uses('AppModel', 'Model');
/**
 * Caso Model
 *
 * @property Categoria $Categoria
 */
class Caso extends AppModel {


	public $getRecaudado = false;

	public function beforeSave($options = array()) {
		if (!isset($this->data[$this->alias]['id'])) {
			#es un create
			$this->data[$this->alias]['creado_por']=AuthComponent::user('id');
		}
		$this->data[$this->alias]['modificado_por']=AuthComponent::user('id');
		return true;
	}


	public function beforeFind($query = array()){
    	if (isset($query['getRecaudado']) && $query['getRecaudado']) {
    		$this->getRecaudado = true;
    	}    	
   		return true;
   	}


   	public function afterFind($results, $primary = false){
   		if ($this->getRecaudado) {
   			#//Obtenemos el total aportado por cada row 
   			foreach ($results as $key => $value) {   				
   				$porcentaje = 0;   				
   				if (isset($value['Caso']) && $value['Caso']['total_recaudado']>0) {
					$porcentaje = ($value['Caso']['total_recaudado'] * 100) / $value['Caso']['importe_meta'];   					
   				}
				$results[$key]['Caso']['porcentaje_recaudado'] = $porcentaje;
   			}
   		}
   		return $results;
   	}

	public $validate = array(
		'fecha_inicio' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'El campo es requerido.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'fecha_fin' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'El campo es requerido.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'importe_meta' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'El campo es requerido.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'titulo' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'El campo es requerido.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'descripcion' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'El campo es requerido.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'categoria_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'El campo es requerido.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $belongsTo = array(
		'Categoria' => array(
			'className' => 'Categoria',
			'foreignKey' => 'categoria_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Creador' => array(
			'className' => 'Base.Usuario',
			'foreignKey' => 'creado_por',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Modificador' => array(
			'className' => 'Base.Usuario',
			'foreignKey' => 'modificado_por',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'Aportacion' => array(
			'className' => 'Aportacion',
			'foreignKey' => 'caso_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),		
	);

	
}
