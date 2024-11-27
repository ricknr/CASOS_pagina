<?php
App::uses('AppModel', 'Model');
/**
 * Categoria Model
 *
 */
class Categoria extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'nombre';

	public function beforeSave($options = array()) {
		if (!isset($this->data[$this->alias]['id'])) {
			#es un create
			$this->data[$this->alias]['creado_por']=AuthComponent::user('id');
		}
		$this->data[$this->alias]['modificado_por']=AuthComponent::user('id');
		return true;
	}
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'nombre' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'El nombre de la categoría es necesario',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $belongsTo = array(		
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
		'Caso' => array(
			'className' => 'Caso',
			'foreignKey' => 'categoria_id',
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
