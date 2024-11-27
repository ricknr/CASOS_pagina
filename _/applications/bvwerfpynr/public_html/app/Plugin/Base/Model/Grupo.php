<?php
//App::uses('AppModel', 'Model');
/**
 * Grupo Model
 */
class Grupo extends BaseAppModel {

	public $displayField = 'nombre';
	public $actsAs = array('Acl' => array('type' => 'requester'));
    
	public function parentNode() {
        return null;
    }
/*
 * hasMany array
 */
	public $hasMany = array(
		'Usuario' => array(
			'className' => 'Base.Usuario',
			'foreignKey' => 'grupo_id'
		),		
	);
	
}