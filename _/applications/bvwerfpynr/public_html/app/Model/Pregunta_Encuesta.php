<?php
App::uses('AppModel', 'Model');
/**
 * Newsletter Model
 *
 */
class Pregunta_Encuesta extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'preguntas_encuestas';

    public $belongsTo = array(		
		'Encuesta' => array(
			'className' => 'Encuesta',
			'foreignKey' => 'encuesta_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
        ),
        'Pregunta' => array(
			'className' => 'Pregunta',
			'foreignKey' => 'pregunta_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
	);

}
