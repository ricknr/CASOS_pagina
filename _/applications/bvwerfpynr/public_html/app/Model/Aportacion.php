<?php
App::uses('AppModel', 'Model');
/**
 * Aportacion Model
 *
 * @property Caso $Caso
 */
class Aportacion extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

	private $caso_id;
	private $importe;

	public function afterSave($created,$options = array()) {
   		$total_recaudado = 0;   		
   		// debug($this->data);die;		
   		$total_recaudado = $this->getTotalAportacionesByCaso($this->data[$this->alias]['caso_id']);
   		// debug($total_recaudado);die;		

		$sql = "UPDATE casos set total_recaudado = ". $total_recaudado ." where id = ". $this->data[$this->alias]['caso_id'] .";";
		$this->query($sql);
		return true;
	}

	public function beforeDelete($cascade = true) {
		$importe = $this->find('first',array(
			'conditions'=>array(
				'Aportacion.id'=>$this->id
			),
			'fields'=>array('caso_id','importe')
		));

		$this->caso_id = $importe['Aportacion']['caso_id'];
		$this->importe = $importe['Aportacion']['importe'];
		return true;
	}

	public function afterDelete() {
	    $total_recaudado = $this->getTotalAportacionesByCaso($this->caso_id);
	    $sql = "UPDATE casos set total_recaudado = ". $total_recaudado ." where id = ". $this->caso_id .";";
		$this->query($sql);
	    return true;
	}

	public function getTotalAportacionesByCaso($caso_id = null){
		$sql = "select IFNULL(SUM(importe),0) as total from aportaciones where aprobada = 1 and caso_id = ". $caso_id .";";
		$total_recaudado = $this->query($sql);
		return $total_recaudado[0][0]['total'];
	}

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Caso' => array(
			'className' => 'Caso',
			'foreignKey' => 'caso_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
}
