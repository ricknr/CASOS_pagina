<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	public $components = array('Notificacion');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

/**
 * Displays a view
 *
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}

	public function contacto(){
		$this->layout = 'public';
		if ($this->request->is('post')) {

			if (empty($this->request->data["other"])) {
				$subject = 'Mensaje de forma de contacto del sitio Web';
				$parameters = array();
				$parameters['to'] = 'caritas@caritas.org.mx';
				$parameters['subject'] = 'Mensaje de forma de contacto.';
				$parameters['template'] = 'msj_simple';
				$parameters['config'] = 'sendgrid';

				$msj = 'Datos recibidos de la forma de contacto:<br><br>
					    <p> <b>Nombre:'. $this->request->data["nombre"] .'</b> </p>
						<p> <b>mail:</b> '. $this->request->data["email"] .'</p>
						<p> <b>Mensaje:</b> '. $this->request->data["mensaje"] .'</p>';
				$parameters['var']['msj'] = $msj;
				$parameters['var']['subject'] = $subject;

				$parameters['html'] = true;
				$response = $this->Notificacion->notifica($parameters);
				$this->Session->setFlash(__('Mail enviado correctamente.'), 'flash_success' );
			}
		}
	}
}
