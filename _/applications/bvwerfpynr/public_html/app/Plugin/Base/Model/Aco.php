<?php
App::uses('AppModel', 'Model');
/**
 * Aco Model
 *
 * @property Aco $ParentAco
 * @property Aco $ChildAco
 * @property Aro $Aro
 */
class Aco extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	
	public $actsAs = array('Tree');
	public $displayField = 'alias';
	//public $actsAs = array('Acl' => array('type' => 'controlled'));
	


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ParentAco' => array(
			'className' => 'Base.Aco',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ChildAco' => array(
			'className' => 'Base.Aco',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Aro' => array(
			'className' => 'Base.Aro',
			'joinTable' => 'aros_acos',
			'foreignKey' => 'aco_id',
			'associationForeignKey' => 'aro_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

	
	
	/**
 * Custom validation method to ensure that the two entered passwords match
 *
 * @param string $password Password
 * @return boolean Success
 */
	public function getAcosUrls($acos) {
		debug('dentro');die;
		foreach ($acos as $aco){
			//$parents = $this->Aco->getPath($aco['Aco']['id']);
			//debug($parents);			
		}
		return true;
	}
	
}
