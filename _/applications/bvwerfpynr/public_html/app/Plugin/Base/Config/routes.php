<?php

	Router::connect('/login', array('admin'=>false, 'plugin'=>'base', 'controller' => 'usuarios', 'action' => 'login'));
	Router::connect('/logout', array('admin'=>false, 'plugin'=>'base', 'controller' => 'usuarios', 'action' => 'logout'));
	Router::connect('/recover', array('admin'=>false, 'plugin'=>'base', 'controller' => 'usuarios', 'action' => 'recover'));
	Router::connect('/code/*', array('admin'=>false, 'plugin'=>'base', 'controller' => 'usuarios', 'action' => 'code'));


	
