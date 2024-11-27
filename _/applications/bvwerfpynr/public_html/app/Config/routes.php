<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	//Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/', array('admin'=>false, 'plugin'=>false, 'controller' => 'casos', 'action' => 'index'));
	Router::connect('/contacto', array('admin'=>false, 'plugin'=>false, 'controller' => 'pages', 'action' => 'contacto'));
	Router::connect('/nueva_donacion/*', array('admin'=>false, 'plugin'=>false, 'controller' => 'casos', 'action' => 'nueva_donacion'));
	Router::connect('/nueva_donacion_p/*', array('admin'=>false, 'plugin'=>false, 'controller' => 'casos', 'action' => 'nueva_donacion_p'));
	Router::connect('/casos_resueltos', array('admin'=>false, 'plugin'=>false, 'controller' => 'casos', 'action' => 'resueltos'));
	Router::connect('/donar', array('admin'=>false, 'plugin'=>false, 'controller' => 'casos', 'action' => 'donar'));
	Router::connect('/donar_p', array('admin'=>false, 'plugin'=>false, 'controller' => 'casos', 'action' => 'donar_p'));
	Router::connect('/respuesta', array('admin'=>false, 'plugin'=>false, 'controller' => 'casos', 'action' => 'respuesta'));
	Router::connect('/respuestapay/*', array('admin'=>false, 'plugin'=>false, 'controller' => 'casos', 'action' => 'respuestapay'));
	Router::connect('/gracias/*', array('admin'=>false, 'plugin'=>false, 'controller' => 'casos', 'action' => 'gracias'));
	
	Router::connect('/login', array('admin'=>false, 'plugin'=>'base', 'controller' => 'usuarios', 'action' => 'login'));
	Router::connect('/admin', array('admin'=>false, 'plugin'=>'base', 'controller' => 'usuarios', 'action' => 'login'));
	
/**
 *
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
	


/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
