<?php
App::uses('AppModel', 'Model');
/**
 * Encuesta Model
 *
 */
class Encuesta extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
    public $useTable = 'encuesta';
    
    public $belongsTo = array(
		'Aportacion' => array(
			'className' => 'Aportacion',
			'foreignKey' => 'aportacion_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'Pregunta_Encuesta' => array(
			'className' => 'Pregunta_Encuesta',
			'foreignKey' => 'encuesta_id',
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
