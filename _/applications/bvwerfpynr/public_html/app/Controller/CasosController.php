<?php
App::uses('AppController', 'Controller');
/**
 * Casos Controller
 *
 * @property Caso $Caso
 * @property PaginatorComponent $Paginator
 */
class CasosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','Notificacion');	


	 public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index','detalle','nueva_donacion', 'nueva_donacion_p','donar', 'donar_p','respuesta','respuestapay','admin_export_donaciones','gracias','test','mail_caso','resueltos','newsletter','admin_export_newsletter', 'encuesta', 'admin_updateImage');
	}
/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Caso->recursive = 0;
		$conditions=array();

		if ($this->request->is('ajax') || $this->request->is('post')) {
			if ($this->request->is('ajax')) {
				$this->layout = 'ajax';				
			}

			
			if (!empty($this->request->data['titulo'])) {								
				$conditions['AND']['OR'][] = array('Caso.titulo LIKE' => '%'. $this->request->data['titulo'] . '%');
				$conditions['AND']['OR'][] = array('Caso.descripcion LIKE' => '%'. $this->request->data['titulo'] . '%');
				$this->request->data['Caso']['titulo'] = $this->request->data['titulo'];
			}

			if (!empty($this->request->data['folio'])) {								
				$conditions['AND']['OR'][] = array('Caso.folio LIKE ' =>'%'.$this->request->data['folio'].'%');
				$this->request->data['Caso']['folio'] = $this->request->data['folio'];
			}

			if (!empty($this->request->data['categoria_id'])) {				
				$conditions['AND'][] = array('Caso.categoria_id' =>$this->request->data['categoria_id']);				
				$this->request->data['Caso']['categoria_id'] = $this->request->data['categoria_id'];
			}
		}		
		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'order'=>array('Caso.'.$this->Caso->primaryKey => 'desc'),
			'getRecaudado'=>true
		);
		

		$casos = $this->Paginator->paginate('Caso');
		

		$categorias = $this->Caso->Categoria->find('list',array(
			// 'conditions'=>array('Categoria.activo'=>1),
			'order'=>'nombre asc'
		));

		
		$this->set(compact('casos','categorias'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Caso->exists($id)) {
			throw new NotFoundException(__('Invalid caso'));
		}
		$options = array('conditions' => array('Caso.' . $this->Caso->primaryKey => $id));
		$this->Caso->Behaviors->load('Containable');
		$caso = $this->Caso->find('first', array(
			'conditions' => array(
				'Caso.' . $this->Caso->primaryKey => $id,
			),
			'contain'=>array(
				'Categoria','Creador','Modificador',
				'Aportacion'=>array('conditions'=>array('aprobada'=>1))
			),
			'getRecaudado'=>true
		));
		// debug($caso);die;		

		$this->set('caso', $caso);

		// debug($this->Caso->find('first', $options));die;
	}
/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Caso->create();
			#Cargar el uploadBehavior

			$fechas = explode('-', $this->request->data['Caso']['fecha']);
			unset($this->request->data['Caso']['fecha']);
			$this->request->data['Caso']['fecha_inicio'] = date('Y-m-d',strtotime($fechas[0]));
			$this->request->data['Caso']['fecha_fin'] = date('Y-m-d',strtotime($fechas[1]));
			
			if ($this->request->data['Caso']['tipo'] == 'Imagen') {
				unset($this->request->data['Caso']['video']);
			}else{
				unset($this->request->data['Caso']['imagen']);
			}

			$this->request->data['Caso']['total_recaudado'] = 0;
			
			#Creamos path para carga del archivo xml de la factura
	  		$dir = 'files/casos/'. date('Y') .'/';
	  		$this->Caso->Behaviors->load('Upload',array(
				'fileNameField'=> 'imagen',
				'randomFieldName'=>'encname_imagen',
				'relativeFilePathField'=> 'relativepath_imagen',
				'uploadFolder'=>$dir,
				'maxFileSize' => 52428800,
				'randomStoredFilename' => true
			));

			if ($this->Caso->save($this->request->data)) {
				$this->Session->setFlash(__('El caso se ha guardado.'), 'Base.flash_success' );
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'),'Base.flash_error' );
			}
		}
		$categorias = $this->Caso->Categoria->find('list',array('conditions'=>array('activo'=>1),'order'=>'nombre'));
		$this->set(compact('categorias'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		
		if (!$this->Caso->exists($id)) {
			throw new NotFoundException(__('Invalid caso'));
		}
		if ($this->request->is(array('post', 'put'))) {
			
			if ($this->request->data['Caso']['tipo'] == 'Imagen') {
				$this->request->data['Caso']['video'] = '';
			}else{
				$this->request->data['Caso']['imagen'] = '';
			}

			#Creamos path para carga del archivo xml de la factura
	  		$dir = 'files/casos/'. date('Y') .'/';
	  		$this->Caso->Behaviors->load('Upload',array(
				'fileNameField'=> 'imagen',
				'randomFieldName'=>'encname_imagen',
				'relativeFilePathField'=> 'relativepath_imagen',
				'uploadFolder'=>$dir,
				'maxFileSize' => 52428800,
				'randomStoredFilename' => true
			));

			$fechas = explode('-', $this->request->data['Caso']['fecha']);
			unset($this->request->data['Caso']['fecha']);
			$this->request->data['Caso']['fecha_inicio'] = date('Y-m-d',strtotime($fechas[0]));
			$this->request->data['Caso']['fecha_fin'] = date('Y-m-d',strtotime($fechas[1]));

			
			if ($this->Caso->save($this->request->data)) {
				$this->Session->setFlash(__('El caso  se ha guardado.'), 'Base.flash_success');
				return $this->redirect(array('action' => 'view',$id));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error' );
			}
		} else {
			
			$options = array('conditions' => array('Caso.' . $this->Caso->primaryKey => $id));
			$this->request->data = $this->Caso->find('first', $options);
			//debug($this->request->data); die;
			$fecha = date('Y/m/d',strtotime($this->request->data['Caso']['fecha_inicio'])) . " - " . date('Y/m/d',strtotime($this->request->data['Caso']['fecha_fin']));
			$this->request->data['Caso']['fecha'] = $fecha;
			
		}
		$casos = $this->request->data['Caso'];
		$categorias = $this->Caso->Categoria->find('list',array('conditions'=>array('activo'=>1),'order'=>'nombre'));
		//debug($categorias); die;
		$this->set(compact('categorias', 'casos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Caso->id = $id;
		if (!$this->Caso->exists()) {
			throw new NotFoundException(__('Invalid caso'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Caso->delete()) {
			$this->Session->setFlash(__('El caso se ha borrado.'), 'Base.flash_success');
		} else {
			$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error');
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function admin_addAportacion($id = null){
		
		if (!$this->Caso->exists($id)) {
			throw new NotFoundException(__('Invalid caso'));
		}
		
		# $this->request->data['Aportacion']['tipo'] =  'especie'; 
		$this->request->data['Aportacion']['aprobada'] =  1; 
		$this->request->data['Aportacion']['creado_por'] = AuthComponent::user('id');
		$this->request->data['Aportacion']['modificado_por'] = AuthComponent::user('id');

		if ($this->Caso->Aportacion->save($this->request->data)) {
			$this->Session->setFlash(__('Aportación guardada correctamente.'), 'Base.flash_success' );
		}else{
			$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error' );
		}
		return $this->redirect(array('admin'=>true,'action' => 'view',$id));			
	}

	public function admin_export_donaciones(){
		$this->loadModel('Aportacion');
		$aportaciones = $this->Aportacion->find('all',array(
			'conditions'=>array('Aportacion.aprobada'=>true)
		));

		#debug($aportaciones); die;
		
		#//Crea Excel
		App::import('Vendor', 'PHPExcel/PHPExcel');
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('BISSO')
		->setLastModifiedBy('BISSO')
		->setTitle('Layout')
		->setSubject('Office 2007 XLSX')
		->setDescription('Layout');

		$row = 1;				
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$row,'Caso'); 
		$excel->setActiveSheetIndex(0)->setCellValue('B'.$row,'Folio');
		$excel->setActiveSheetIndex(0)->setCellValue('C'.$row,'Nombre');
		$excel->setActiveSheetIndex(0)->setCellValue('D'.$row,'Importe');
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$row,'Tarjeta');
		$excel->setActiveSheetIndex(0)->setCellValue('F'.$row,'Fecha');
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$row,'Descripción');
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$row,'Tipo');
		$excel->setActiveSheetIndex(0)->setCellValue('I'.$row,'Mail');
		$excel->setActiveSheetIndex(0)->setCellValue('J'.$row,'Telefono');
		$excel->setActiveSheetIndex(0)->setCellValue('K'.$row,'Requiere factura');
		$excel->setActiveSheetIndex(0)->setCellValue('L'.$row,'Referencia');
		$excel->setActiveSheetIndex(0)->setCellValue('M'.$row,'Donador');
		$excel->setActiveSheetIndex(0)->setCellValue('N'.$row,'RFC');
		$excel->setActiveSheetIndex(0)->setCellValue('O'.$row,'Calle y número');
		$excel->setActiveSheetIndex(0)->setCellValue('P'.$row,'Colonia');
		$excel->setActiveSheetIndex(0)->setCellValue('Q'.$row,'Estado');
		$excel->setActiveSheetIndex(0)->setCellValue('R'.$row,'Municipio');
		$excel->setActiveSheetIndex(0)->setCellValue('S'.$row,'Ciudad');
		$excel->setActiveSheetIndex(0)->setCellValue('T'.$row,'País');
		$excel->setActiveSheetIndex(0)->setCellValue('U'.$row,'Código postal');
		$row++;

		foreach ($aportaciones as $aportacion) {					
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$row,$aportacion['Caso']['titulo']); 
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$row, $aportacion['Caso']['folio']);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$row,$aportacion['Caso']['nombre']);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$row, $aportacion['Aportacion']['importe']);
			if(isset($aportacion['Aportacion']['tipo_tarjeta'])){
				if($aportacion['Aportacion']['tipo_tarjeta'] == 'paypal'){
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$row, 'Paypal');
				}else if($aportacion['Aportacion']['tipo_tarjeta'] == 'debito'){
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$row, 'Debito');
				}else{
					$excel->setActiveSheetIndex(0)->setCellValue('E'.$row, 'Credito');
				}
			}else{
				$excel->setActiveSheetIndex(0)->setCellValue('E'.$row, 'Credito/Debito');
			}
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$row, $aportacion['Aportacion']['fecha']);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$row, $aportacion['Aportacion']['descripcion']);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$row, $aportacion['Aportacion']['tipo']);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$row, $aportacion['Aportacion']['mail_donador']);
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$row, $aportacion['Aportacion']['telefono_donador']);
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$row, ($aportacion['Aportacion']['requiere_factura'])?'Si':'No');
			$excel->setActiveSheetIndex(0)->setCellValue('L'.$row, $aportacion['Caso']['referencia_bancaria']);
			$excel->setActiveSheetIndex(0)->setCellValue('M'.$row, $aportacion['Aportacion']['nombre_donador']);


			if ($aportacion['Aportacion']['requiere_factura']) {
				$excel->setActiveSheetIndex(0)->setCellValue('N'.$row, $aportacion['Aportacion']['rfc']);
				$excel->setActiveSheetIndex(0)->setCellValue('O'.$row, $aportacion['Aportacion']['calle_y_numero']);
				$excel->setActiveSheetIndex(0)->setCellValue('P'.$row, $aportacion['Aportacion']['colonia']);
				$excel->setActiveSheetIndex(0)->setCellValue('Q'.$row, $aportacion['Aportacion']['estado']);
				$excel->setActiveSheetIndex(0)->setCellValue('R'.$row, $aportacion['Aportacion']['municipio']);
				$excel->setActiveSheetIndex(0)->setCellValue('S'.$row, $aportacion['Aportacion']['ciudad']);
				$excel->setActiveSheetIndex(0)->setCellValue('T'.$row, $aportacion['Aportacion']['pais']);
				$excel->setActiveSheetIndex(0)->setCellValue('U'.$row, $aportacion['Aportacion']['cp']);
			}else{
				$excel->setActiveSheetIndex(0)->setCellValue('N'.$row, '-');
				$excel->setActiveSheetIndex(0)->setCellValue('O'.$row, '-');
				$excel->setActiveSheetIndex(0)->setCellValue('P'.$row, '-');
				$excel->setActiveSheetIndex(0)->setCellValue('Q'.$row, '-');
				$excel->setActiveSheetIndex(0)->setCellValue('R'.$row, '-');
				$excel->setActiveSheetIndex(0)->setCellValue('S'.$row, '-');
				$excel->setActiveSheetIndex(0)->setCellValue('T'.$row, '-');
				$excel->setActiveSheetIndex(0)->setCellValue('U'.$row, '-');
			}
		
			$row++;
		}

		$filename = "aportaciones.xlsx";
		#//Termina Excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWrite = PHPExcel_IOFactory::createWriter($excel,'Excel2007');
		$objWrite->save('php://output');
		exit;
	}

	public function index() {
		$this->layout = 'public';

		$conditions=array();
		// $order = 'rand()';
		$texto = "";
		$ids = "";

		$tiene_categoria = false;
		$categoria = 'Todas';
		if ($this->request->is('ajax')) {
			$this->layout = 'ajax';
			$this->view = 'grid_casos';

			if (!empty($this->request->data['categoria_id'])) {
				$conditions[] = array('Caso.categoria_id' => $this->request->data['categoria_id']);
				$tiene_categoria = true;
			}

			if (!empty($this->request->data['filtro'])) {
				$order = $this->request->data['filtro'];				
			}
		}elseif ($this->request->is('post')) {
			// debug($this->request->data);die;		

			if (!empty($this->request->data['texto'])) {								
				$conditions['AND']['OR'][] = array('Caso.titulo LIKE' => '%'. $this->request->data['texto'] . '%');
				$conditions['AND']['OR'][] = array('Caso.descripcion LIKE' => '%'. $this->request->data['texto'] . '%');
				$conditions['AND']['OR'][] = array('Caso.folio LIKE' => '%'. $this->request->data['texto'] . '%');

				$texto = $this->request->data['texto'];
			}			
		}
		
		$conditions['AND'][] = array('Caso.fecha_fin >=' => date('Y-m-d'));
		$conditions['AND'][] = array('Categoria.activo' => 1);
		$conditions['AND'][] = array('Caso.activo'=>true);
		$conditions['AND'][] = array('Caso.total_recaudado < Caso.importe_meta');
		// debug($conditions);
		
		$this->Caso->recursive = 0;
		$this->Paginator->settings = array(
			'conditions' => $conditions,
			// 'order'=>$order,
			'limit'=>21,
			'getRecaudado'=>true,
		);
		$casos = $this->Paginator->paginate('Caso');
		$casos = $this->shuffle_assoc($casos);
		

		$ids_actuales = "";
		foreach ($casos as $k => $c) {
			$ids_actuales .= ",". $c['Caso']['id'];
		}
		$ids_actuales = substr($ids_actuales, 1);

		
		if (empty($ids)) {
			$ids = $ids_actuales;
		}else{
			$ids = $ids . "," . $ids_actuales;
		}

		
		
		if ($tiene_categoria) {
			$categoria = @$casos[0]['Categoria']['nombre'];
		}

		// debug($casos);
		$categorias = $this->Caso->Categoria->find('list',array(
			'conditions'=>array('Categoria.activo'=>1),
			'order'=>'nombre asc',
		));

		$this->set(compact('casos','categorias','texto','categoria','ids'));
	}

	function shuffle_assoc($list) { 
	  if (!is_array($list)) return $list; 

	  $keys = array_keys($list); 
	  shuffle($keys); 
	  $random = array(); 
	  foreach ($keys as $key) { 
	    $random[$key] = $list[$key]; 
	  }
	  return $random; 
	}

	public function detalle($id = null) {
		$this->layout = 'public';
		if (!$this->Caso->exists($id)) {
			$this->redirect('/casos');
		}
		$options = array('conditions' => array('Caso.' . $this->Caso->primaryKey => $id));
		$this->Caso->Behaviors->load('Containable');
		$caso = $this->Caso->find('first', array(
			'conditions' => array(
				'Caso.' . $this->Caso->primaryKey => $id,				
			),
			'getRecaudado'=>true,
			'contain'=>array(
				'Categoria','Creador','Modificador',
				'Aportacion'=>array('conditions'=>array('aprobada'=>1))
			)
		));



		if ($caso['Caso']['fecha_fin'] < date('Y-m-d')) {
			$this->Session->setFlash(__('La causa seleccionada anteriormente ha llegado a su fecha límite.'), 'flash_success' );
			$this->redirect('/casos');
		}

		$relacionados = $this->Caso->find('all',array(
			'conditions'=>array(
				'Caso.categoria_id'=>$caso['Caso']['categoria_id'],
				'Caso.id !='=>$caso['Caso']['id'],
				'Caso.fecha_fin >=' => date('Y-m-d')
			),
			'limit'=>4,
			'order' => 'rand()',
			'getRecaudado'=>true
		));



		$this->set(compact('caso','relacionados'));
	}

	public function nueva_donacion($id = null){
		
		$this->layout = 'public';
		if (!$this->Caso->exists($id)) {
			$this->redirect('/casos');
		}

		$options = array('conditions' => array('Caso.' . $this->Caso->primaryKey => $id));
		$caso = $this->Caso->find('first', array(
			'conditions' => array('Caso.' . $this->Caso->primaryKey => $id),
			'recursive'=>-1
		));

		// debug($caso);
		if ($caso['Caso']['fecha_fin'] < date('Y-m-d')) {
			$this->Session->setFlash(__('La causa seleccionada anteriormente ha llegado a su fecha límite.'), 'flash_success' );
			$this->redirect('/casos');
		}

		if ($this->request->is('post')) {
			//debug($this->request->data['tipo_tarjeta']); die;
			$save['Aportacion'] = $this->request->data;
			$save['Aportacion']['fecha'] = date('Y-m-d');
			$save['Aportacion']['caso_id'] = $id;
			$save['Aportacion']['descripcion'] = 'Aportación desde web';
			$save['Aportacion']['tipo'] = 'efectivo';
			$save['Aportacion']['aprobada'] = 0;
			$save['Aportacion']['requiere_factura'] = 0;
			$save['Aportacion']['tipo_tarjeta'] = $this->request->data['tipo_tarjeta'];
			if (isset($this->request->data['requiere_factura'])) {
				$save['Aportacion']['requiere_factura'] = 1;
			}else{
				//unset($save['Aportacion']['tipo_tarjeta']);
			}
			// debug($save);die;		

			if ($this->Caso->Aportacion->save($save)) {
				$aportacion_id = $this->Caso->Aportacion->id;
				$this->Session->write('aportacion_id',$aportacion_id);
				// NOTA: Se puede descomentar el primer redirect para poder acceder al gracias.
				//$this->redirect('/gracias/'.$aportacion_id);
				$this->redirect('/donar');
			}
		}
		
		$this->set(compact('caso'));
	}
	public function nueva_donacion_p($id = null){
		
		$this->layout = 'public';
		if (!$this->Caso->exists($id)) {
			$this->redirect('/casos');
		}

		$options = array('conditions' => array('Caso.' . $this->Caso->primaryKey => $id));
		$caso = $this->Caso->find('first', array(
			'conditions' => array('Caso.' . $this->Caso->primaryKey => $id),
			'recursive'=>-1
		));

		// debug($caso);
		if ($caso['Caso']['fecha_fin'] < date('Y-m-d')) {
			$this->Session->setFlash(__('La causa seleccionada anteriormente ha llegado a su fecha límite.'), 'flash_success' );
			$this->redirect('/casos');
		}

		if ($this->request->is('post')) {
			//debug($this->request->data); die;

			$save['Aportacion'] = $this->request->data;
			$save['Aportacion']['fecha'] = date('Y-m-d');
			$save['Aportacion']['caso_id'] = $id;
			$save['Aportacion']['descripcion'] = 'Aportación desde web';
			$save['Aportacion']['tipo'] = 'efectivo';
			$save['Aportacion']['aprobada'] = 0;
			$save['Aportacion']['requiere_factura'] = 0;
			$save['Aportacion']['tipo_tarjeta'] = 'paypal';
			if (isset($this->request->data['requiere_factura'])) {
				$save['Aportacion']['requiere_factura'] = 1;
			}else{
				//unset($save['Aportacion']['tipo_tarjeta']);
			}
			//debug($save);die;		

			if ($this->Caso->Aportacion->save($save)) {
				$aportacion_id = $this->Caso->Aportacion->id;
				$this->Session->write('aportacion_id',$aportacion_id);
				// NOTA: Se puede descomentar el primer redirect para poder acceder al gracias.
				//$this->redirect('/gracias/'.$aportacion_id);
				$this->redirect('/donar_p');
			}
		}
		
		$this->set(compact('caso'));
	}

	public function donar(){
		$this->layout = 'public';
		if (!$this->Session->check('aportacion_id')) {
			// $this->Session->setFlash(__(''), 'flash_success' );
			$this->redirect('/casos');	
		}

		$aportacion_id = $this->Session->read('aportacion_id');
		$aportacion = $this->Caso->Aportacion->find('first',array(
			'conditions'=>array(
				'Aportacion.id'=> $aportacion_id
			)
		));	
		#debug($aportacion);die;
		$this->set(compact('aportacion'));
	}

	public function donar_p(){
		$this->layout = 'public';
		if (!$this->Session->check('aportacion_id')) {
			// $this->Session->setFlash(__(''), 'flash_success' );
			$this->redirect('/casos');	
		}

		$aportacion_id = $this->Session->read('aportacion_id');
		$aportacion = $this->Caso->Aportacion->find('first',array(
			'conditions'=>array(
				'Aportacion.id'=> $aportacion_id
			)
		));	
		#debug($aportacion);die;
		$this->set(compact('aportacion'));
	}

	public function respuesta(){
		$this->layout = 'ajax';		
		$datos = $this->request->data;
		if (!$this->Session->check('aportacion_id')) {
			// $this->Session->setFlash(__(''), 'flash_success' );
			$this->redirect('/casos');	
		}

		// debug($datos);die;		

		$aportacion_id = $this->Session->read('aportacion_id');
		#//Mail de agradecimiento
		$this->loadModel('Aportacion');
		$aportacion = $this->Aportacion->find('first',array(
			'conditions'=>array('Aportacion.id'=>$aportacion_id)
		));

		

		$update['Aportacion']['id'] = $aportacion_id;
		$update['Aportacion']['caso_id'] = $aportacion['Aportacion']['caso_id'];
		$update['Aportacion']['bnrgResponse'] = json_encode($datos);
		$update['Aportacion']['folio_respuesta'] = @$datos['BNRG_FOLIO'];
		$update['Aportacion']['bnrgTexto'] = $datos['BNRG_TEXTO'];
		$update['Aportacion']['bnrgCodigoProc'] = $datos['BNRG_CODIGO_PROC'];
		$update['Aportacion']['aprobada'] = 1;

		if ($datos['BNRG_CODIGO_PROC'] == 'A') {
			if ($this->Caso->Aportacion->save($update)) {
				#//Si es exitosa marcamos la transaccion como
				$subject = 'Gracias por tu donativo.';

				$parameters = array();
				$parameters['to'] = $aportacion['Aportacion']['mail_donador'];
				$parameters['bcc'] = array('soporte@bisso.mx','tmendoza@caritas.org.mx');


				$parameters['subject'] = $subject;
				$parameters['template'] = 'msj_simple';
				$parameters['config'] = 'sendgrid';

				$msj = '<p>Te agradecemos el haberte unido a esta cadena de amor.
					Con tu aportación podremos ayudar a cubrir las necesidades más urgentes de '. $aportacion["Caso"]["nombre"] .' y brindarle la oportunidad para salir adelante.
					Dios te bendiga y recompense al ciento por uno tu valiosa ayuda.</p>';

				$parameters['var']['msj'] = $msj;
				$parameters['var']['subject'] = $subject;

				$parameters['html'] = true;
				$response = $this->Notificacion->notifica($parameters);
				
				#//Revisar si ya se llego a la meta
				$total_recaudado =  $this->Caso->Aportacion->getTotalAportacionesByCaso($aportacion['Aportacion']['caso_id']);		
				if ($total_recaudado >= $aportacion['Caso']['importe_meta']) {
					#//Notificamos a todos los que aportaron en el caso
					#//Obtenemos cuentas de correo de los donadores
					$sql = "select DISTINCT(mail_donador)
							from aportaciones 
							where caso_id = ". $aportacion['Aportacion']['caso_id'] ." AND mail_donador != '';";
					$resultado = $this->Caso->query($sql);
					$mails_donadores = array();
					foreach ($resultado as $k => $res) {
						$mails_donadores[] = $res['aportaciones']['mail_donador'];
					}

					#//Notificacion
					$parameters = array();
					$subject = 'Gracias a tu ayuda ¡Lo logramos!';

					$parameters['to'] = 'caritas@caritas.org.mx';
					$parameters['bcc'] = $mails_donadores;
					$parameters['subject'] = $subject;
					$parameters['template'] = 'msj_simple';
					$parameters['config'] = 'sendgrid';

					$msj = "<p>¡Logramos la meta!</p>
							<p>Gracias por ser parte de esta cadena de generosidad  que permitió cambiar la vida de ". $aportacion['Caso']['nombre'] ."</p>
							<p>¡Bendiciones para ti y los tuyos!</p>";
					$parameters['var']['msj'] = $msj;
					$parameters['var']['subject'] = $subject;

					$parameters['html'] = true;
					$response = $this->Notificacion->notifica($parameters);
					$this->redirect('/gracias/'.$aportacion_id);
				}
			}
			
			$this->Session->delete('aportacion_id');
			$this->redirect('/gracias/'.$aportacion_id);
		}else{
			// $this->Session->setFlash(__($datos['BNRG_TEXTO']), 'Base.flash_error' );
			$this->Session->setFlash("Favor de verificar los datos de su tarjeta e intentar nuevamente", 'Base.flash_error' );
			$this->redirect('/donar');
		}
	}

	public function respuestapay($aportacion_id = null){

		$explodeJSON = "";
		$explodeValidate = "";

		$this->autoRender = false;
		$req = 'cmd=_notify-validate';

		foreach ($_POST as $key => $value) {
			$value = urlencode(stripslashes($value));
			$req .= "&$key=$value";
		}

		#$aportacion_id = $this->Session->read('aportacion_id');
		#//Mail de agradecimiento
		$this->loadModel('Aportacion');
		$aportacion = $this->Aportacion->find('first',array(
			'conditions'=>array('Aportacion.id'=>$aportacion_id)
		));

		$update['Aportacion']['id'] = $aportacion_id;
		$update['Aportacion']['caso_id'] = $aportacion['Aportacion']['caso_id'];
		$update['Aportacion']['aprobada'] = 1;


		try{
			$explodeJSON = explode('&', $req);
			$explodeValidate = explode('=',$explodeJSON[3]);

			if ($explodeValidate[1] == "VERIFIED") {
				// verified from paypal, processing...
				$subject = 'Gracias por tu donativo.';
				$parameters = array();
				$parameters['to'] = $aportacion['Aportacion']['mail_donador'];
				$parameters['bcc'] = array('soporte@bisso.mx','tmendoza@caritas.org.mx');


				$parameters['subject'] = $subject;
				$parameters['template'] = 'msj_simple';
				$parameters['config'] = 'sendgrid';

				$msj = '<p>Te agradecemos el haberte unido a esta cadena de amor.
					Con tu aportación podremos ayudar a cubrir las necesidades más urgentes de '. $aportacion["Caso"]["nombre"] .' y brindarle la oportunidad para salir adelante.
					Dios te bendiga y recompense al ciento por uno tu valiosa ayuda.</p>';

				$parameters['var']['msj'] = $msj;
				$parameters['var']['subject'] = $subject;

				$parameters['html'] = true;
				$response = $this->Notificacion->notifica($parameters);
				
				#//Revisar si ya se llego a la meta
				$total_recaudado =  $this->Caso->Aportacion->getTotalAportacionesByCaso($aportacion['Aportacion']['caso_id']);		
				if ($total_recaudado >= $aportacion['Caso']['importe_meta']) {
					#//Notificamos a todos los que aportaron en el caso
					#//Obtenemos cuentas de correo de los donadores
					$sql = "select DISTINCT(mail_donador)
							from aportaciones 
							where caso_id = ". $aportacion['Aportacion']['caso_id'] ." AND mail_donador != '';";
					$resultado = $this->Caso->query($sql);
					$mails_donadores = array();
					foreach ($resultado as $k => $res) {
						$mails_donadores[] = $res['aportaciones']['mail_donador'];
					}

					#//Notificacion usuarios
					$parameters = array();
					$subject = 'Gracias a tu ayuda ¡Lo logramos!';

					$parameters['to'] = 'caritas@caritas.org.mx';
					$parameters['bcc'] = $mails_donadores;
					$parameters['subject'] = $subject;
					$parameters['template'] = 'msj_simple';
					$parameters['config'] = 'sendgrid';

					$msj = "<p>¡Logramos la meta!</p>
							<p>Gracias por ser parte de esta cadena de generosidad  que permitió cambiar la vida de ". $aportacion['Caso']['nombre'] ."</p>
							<p>¡Bendiciones para ti y los tuyos!</p>";
					$parameters['var']['msj'] = $msj;
					$parameters['var']['subject'] = $subject;

					$parameters['html'] = true;
					$response = $this->Notificacion->notifica($parameters);

					#//Notificacion usuarios
					unset($parameters['bcc']);
					$parameters['bcc'] = array('soporte@bisso.mx','tmendoza@caritas.org.mx');
					$response = $this->Notificacion->notifica($parameters);

					$this->Caso->Aportacion->save($update);
					$this->redirect('/gracias/'.$aportacion_id);
				}
				$this->Caso->Aportacion->save($update);
				$this->redirect('/gracias/'.$aportacion_id);
			} else if($explodeValidate[1] == "UNVERIFIED"){
				// verified from paypal, processing...
				$subject = 'Gracias por tu donativo.';
				$parameters = array();
				$parameters['to'] = $aportacion['Aportacion']['mail_donador'];
				$parameters['bcc'] = array('soporte@bisso.mx','tmendoza@caritas.org.mx');

				$parameters['subject'] = $subject;
				$parameters['template'] = 'msj_simple';
				$parameters['config'] = 'sendgrid';

				$msj = '<p>Te agradecemos el haberte unido a esta cadena de amor.
					Con tu aportación podremos ayudar a cubrir las necesidades más urgentes de '. $aportacion["Caso"]["nombre"] .' y brindarle la oportunidad para salir adelante.
					Dios te bendiga y recompense al ciento por uno tu valiosa ayuda.</p>';

				$parameters['var']['msj'] = $msj;
				$parameters['var']['subject'] = $subject;

				$parameters['html'] = true;
				$response = $this->Notificacion->notifica($parameters);
				#//Revisar si ya se llego a la meta
				$total_recaudado =  $this->Caso->Aportacion->getTotalAportacionesByCaso($aportacion['Aportacion']['caso_id']);		
				
				if ($total_recaudado >= $aportacion['Caso']['importe_meta']) {
					#//Notificamos a todos los que aportaron en el caso
					#//Obtenemos cuentas de correo de los donadores
					$sql = "select DISTINCT(mail_donador)
							from aportaciones 
							where caso_id = ". $aportacion['Aportacion']['caso_id'] ." AND mail_donador != '';";
					$resultado = $this->Caso->query($sql);
					$mails_donadores = array();
					foreach ($resultado as $k => $res) {
						$mails_donadores[] = $res['aportaciones']['mail_donador'];
					}

					#//Notificacion para usuarios 
					$parameters = array();
					$subject = 'Gracias a tu ayuda ¡Lo logramos!';

					$parameters['to'] = 'caritas@caritas.org.mx';
					$parameters['bcc'] = $mails_donadores;
					$parameters['subject'] = $subject;
					$parameters['template'] = 'msj_simple';
					$parameters['config'] = 'sendgrid';

					$msj = "<p>¡Logramos la meta!</p>
							<p>Gracias por ser parte de esta cadena de generosidad  que permitió cambiar la vida de ". $aportacion['Caso']['nombre'] ."</p>
							<p>¡Bendiciones para ti y los tuyos!</p>";
					$parameters['var']['msj'] = $msj;
					$parameters['var']['subject'] = $subject;

					$parameters['html'] = true;
					$response = $this->Notificacion->notifica($parameters);

					#// Notificacion para admins
					unset($parameters['bcc']);
					$parameters['bcc'] = array('soporte@bisso.mx','tmendoza@caritas.org.mx');
					$response = $this->Notificacion->notifica($parameters);

					$this->Caso->Aportacion->save($update);
					$this->redirect('/gracias/'.$aportacion_id);
				}

				$this->Caso->Aportacion->save($update);
				$this->redirect('/gracias/'.$aportacion_id);
			}
			else if ($explodeJSON == "INVALID") {
				// oh no, someone is hijacking us...
			}	
		}catch(Exception $e){
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
		/*$this->Caso->Aportacion->save($update);
		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
		if (!$fp) {// HTTP ERROR, we should record the data still..?
		} else {
			fputs($fp, $header . $req);
			while (!feof($fp)) {
				$res = fgets($fp, 1024);
				if (strcmp($res, "VERIFIED") == 0) {
					// verified from paypal, processing...
				} else if (strcmp($res, "INVALID") == 0) {
					// oh no, someone is hijacking us...
				}
			}
			fclose($fp);
		}*/
	}

	public function gracias($aportacion_id = null){
		$respuestaExiste = array("Pregunta_Encuesta"=>null);
		$existeEncuesta = array();

		$this->loadModel('Encuesta');
		$existeEncuesta = $this->Encuesta->find('first',array(
			'conditions'=>array('aportacion_id'=>$aportacion_id)
		));

		#debug(empty($existeEncuesta['Encuesta'])
		#debug($respuestaExiste);
		if(empty($existeEncuesta['Encuesta']) == false){
			$this->redirect('/');
		} 
		
		$this->layout = 'public';
		$this->loadModel('Pregunta');
		$preguntas = $this->Pregunta->find('all', array('preguntas'=> array('id' => 'desc'),));
		
		$this->loadModel('Aportacion');
		$aportacion = $this->Aportacion->find('first',array(
			'conditions'=>array('Aportacion.id'=>$aportacion_id)
		));

		#debug($aportacion);

		// NOTA: Estos 2 if se pueden comentar para poder accessar al gracias.
		if (empty($aportacion)) {
			$this->redirect('/');
		}
		/*if (!$aportacion['Aportacion']['aprobada']) {
			$this->redirect('/');
		}*/

		$this->set(compact('aportacion', 'preguntas'));
	}


	public function mail_caso($caso_id = null){
		if ($this->request->is('post')) {

			$caso = $this->Caso->find('first',array(
				'conditions'=>array(
					'id'=>$caso_id
				),
				'recursive'=>-1
			));
				
			$parameters = array();
			$subject = 'Apoya esta causa.';
			$host = 'http://'.$_SERVER['HTTP_HOST'].'/nueva_donacion/'.$caso_id;


			$parameters['to'] = $this->request->data['email'];
			$parameters['subject'] = $subject;
			$parameters['template'] = 'caso';
			$parameters['config'] = 'sendgrid';

			$msj = "
			<p style='text-align:center'>
				<img src='cid:causa' style='width:190px'>
			</p>
			<p style='text-align:center'>				
				". $caso['Caso']['descripcion_corta']." <br><br><br>
				<a href='". $host ."' style='background-color:#1E9CA7;padding:10px 10px;margin-top:10px;color:#fff;text-decoration:none;border-radius:5px' >QUIERO DONAR</a>				
			</p>";
			
			if (file_exists($caso['Caso']['relativepath_imagen'].$caso['Caso']['encname_imagen'])){
				$img_causa = WWW_ROOT. $caso['Caso']['relativepath_imagen'] . $caso['Caso']['encname_imagen'];		
			}else{
				$img_causa = WWW_ROOT."img/no-image.jpg";
			}
			

			$parameters['embeds'] = array(
				$caso['Caso']['imagen']=>array(
					'file' => $img_causa,
			        'mimetype' => 'image/jpg',
			        'contentId' => 'causa'      
				)
			);


			$parameters['var']['msj'] = $msj;
			$parameters['var']['subject'] = $subject;

			$parameters['html'] = true;
			$response = $this->Notificacion->notifica($parameters);

			$this->Session->setFlash("Mail enviado correctamente.", 'Base.flash_success' );
			$this->redirect('/casos/detalle/'.$caso_id);
		}
	}

	public function resueltos(){
		$this->layout = 'public';

		$casos = $this->Caso->find('all',array(
			'conditions'=>array('total_recaudado >= importe_meta'),
			'getRecaudado'=>true,
			'recursive'=>-1
		));

		#debug($casos);
		$this->set(compact('casos'));
	}

	public function newsletter(){
		if ($this->request->is('post')) {
			$data = array();
			$data['msj'] = 'ok';
			$data['code'] = 200;
			if ($this->request->data['bot'] == 'bisso') {
				$mail = $this->request->data['mail'];
				if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
				    #//Validamos si existe o no el mail para guardarlo
				    $this->loadModel('Newsletter');
				    $existe = $this->Newsletter->find('count',array(
				    	'conditions'=>array('mail'=>$mail)
				    ));

				    $data['code'] = 100;
				    if ($existe == 0) {
				    	$save = array();
				    	$save['Newsletter']['mail'] = $mail;
				    	$this->Newsletter->create();
				    	$this->Newsletter->save($save);
				    }
					
				}else{
					$data['msj'] = 'El mail proporcionado no es válido';
				}
			}

			die(json_encode($data));
		}
	}

	public function admin_export_newsletter(){
		$this->loadModel('Newsletter');
		$mails = $this->Newsletter->find('all');

		

		App::import('Vendor', 'PHPExcel/PHPExcel');
		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('BISSO')
		->setLastModifiedBy('BISSO')
		->setTitle('Layout')
		->setSubject('Office 2007 XLSX')
		->setDescription('Layout');

		$row = 1;				
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$row,'Mail'); 
		$row++;

		foreach ($mails as $k => $mail) {
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$row,$mail['Newsletter']['mail']); 
			$row++;
		}

		$filename = "newsletter.xlsx";
		#//Termina Excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWrite = PHPExcel_IOFactory::createWriter($excel,'Excel2007');
		$objWrite->save('php://output');
		exit;
	}

	public function encuesta(){
		if( $this->request->is('ajax') ) {
			$encuesta = array();
			$encuesta['Encuesta']['aportacion_id'] = $this->request->data('aportacion_id');
			$encuesta['Encuesta']['created'] = $this->request->data('created');
			$encuesta['Encuesta']['created_id'] = $this->request->data('created_id');
			
			
			$this->loadModel('Encuesta');
			$this->Encuesta->create();
			if ($this->Encuesta->save( $this->request->data('Encuesta') )) {
				
				$encuesta_id = $this->Encuesta->id;

				$array_temp = $this->request->data('Pregunta_Encuesta');

				for($i=0; $i < count($array_temp) ; $i++){
					$array_temp[$i] = array_splice($array_temp[$i], 0, 0) + [ 'encuesta_id' => $encuesta_id] + $array_temp[$i];
				}

				$this->loadModel('Pregunta_Encuesta');
				$this->Pregunta_Encuesta->create();
				if( $this->Pregunta_Encuesta->saveMany( $array_temp ) ){
					die(json_encode(array('saveSuccess' => true)));
				}else{
					die("Ocurrio un error, intentalo de nuevo por favor.");
				}
			} else {
				die("Ocurrio un error, intentalo de nuevo por favor.");
			}
			die();
		}  
		die;
	}

	public function admin_updateImage($id = null){

		if (!$this->Caso->exists($id)) {
			throw new NotFoundException(__('Invalid caso'));
		}
		if( $this->request->is('ajax') ) {
			//die(json_encode($this->request->data));
			//die(json_encode(array('saveSuccess' => true)));
			
			$dir = 'files/casos/'. date('Y') .'/';
	  		$this->Caso->Behaviors->load('Upload',array(
				'fileNameField'=> 'imagen',
				'randomFieldName'=>'encname_imagen',
				'relativeFilePathField'=> 'img/',
				'maxFileSize' => 52428800,
				'randomStoredFilename' => true
			));

			$this->Caso->read(null, $id);
			$this->Caso->set(array(
				'imagen' => $this->request->data['imagen'],
				'encname_imagen' => $this->request->data['imagen'],
			));
			
			if ($this->Caso->save()) {
				$this->Session->setFlash(__('El caso  se ha guardado.'), 'Base.flash_success');
				return $this->redirect(array('action' => 'view',$id));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error' );
			}
		}
	}
}