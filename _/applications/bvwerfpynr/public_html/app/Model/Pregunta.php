<?php
App::uses('AppModel', 'Model');
/**
 * Pregunta Model
 *
 */
class Pregunta extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
    public $useTable = 'preguntas';
    
    public $belongsTo = array(	
        		
	);

    public $hasMany = array(		
		'Pregunta_Encuesta' => array(
			'className' => 'Pregunta_Encuesta',
			'foreignKey' => 'pregunta_id',
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
