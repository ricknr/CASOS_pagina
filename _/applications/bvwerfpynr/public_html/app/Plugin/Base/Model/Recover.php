<?php

class Recover extends BaseAppModel{
	public $name = 'Recover';
	// public $useTable = 'usuarios';
	public $useTable = 'Base.recover';

	public $belongsTo = array(
		'Base.Usuario' => array(
			//'className' => 'Base.Usuario',
			'foreignKey' => 'user_id'
		),		
	);
}

?>