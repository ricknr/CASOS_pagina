<?php
//App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
/**
 * Usuario Model
 */
class Usuario extends BaseAppModel {

	public $displayField = 'nombre';	
	
	#ACL stuff ===================================================
		public $actsAs = array('Acl' => array('type' => 'requester', 'enabled' => false));
		
		public function parentNode() {
			if (!$this->id && empty($this->data)) {
				return null;
			}
			if (isset($this->data['Usuario']['grupo_id'])) {
				$groupId = $this->data['User']['grupo_id'];
			} else {
				$groupId = $this->field('grupo_id');
			}
			if (!$groupId) {
				return null;
			}
			return array('Grupo' => array('id' => $groupId));
		}

		public function bindNode($user) {
			//debug($user);die;
			return array('model' => 'Grupo', 'foreign_key' => $user['Base.Usuario']['grupo_id']);
		}
	#ACL stuff ===================================================	
	
	
	// public $actsAs = array('Upload'=>array(
	// 	'fileNameField'=> 'foto',
	// 	'fullFilePathField'=> 'filepath',
	// 	'relativeFilePathField'=> 'relativepath',
	// 	'uploadFolder'=>'files/fotos/',
	// 	'maxFileSize' => 52428800,
	// 	'randomStoredFilename' => false
	// 	)
	// );


/*
 * validate Array
 */
	public $validate = array(
		'nombre' => array(
			'rule' => 'notBlank',
			'message' => 'Este campo es requerido.'
		),
		// 'usuario' => array(
		// 	'notEmpty'=>array(
		// 	'rule' => 'notEmpty',
		// 	'message' => 'Este campo es requerido.',
		// 	),			
  //           'slugged' => array(
  //               'rule'    => 'alphaNumericDashUnderscore',
  //               'message' => 'Nombre de usuario,solo puede contener letras, números, guíon o guíon bajo.'
  //           ),			
		// ),
		'password' => array(
			'rule'    => array('minLength', '8'),
			'message' => 'Mínimo 8 carateres'
		),
		'password_confirma' => array(
			'rule' => 'confirmPassword',
			'message' => 'Las contraseñas no son iguales'
		),
		'correo' => array(
			'email'=>array(
				'rule' => array('email', false),
				'message' => 'Este campo debe de ser un correo electrónico válido.'
			),
			//'isUnique'=>array(
			//	'rule'=> 'isUnique',
			//	'message' => 'El correo electrónico ya se encuentra registrado.'
			//)
		),
		'grupo_id' => array(
			'rule' => 'notBlank',
			'message' => 'Este campo es requerido.'
		),
	);
	
	/*
	 * belongsTo array
	 */
	public $belongsTo = array(
		'Grupo' => array(
			'className' => 'Base.Grupo',
			'foreignKey' => 'grupo_id',
		),		
	);
	public $hasMany = array(
		'Recover' => array(
			'className' => 'Recover',
			'foreignKey' => 'usuario_id',
			'dependent' => true
		),
	);

/**
 * Custom validation method to ensure that the two entered passwords match
 *
 * @param string $password Password
 * @return boolean Success
 */
	public function confirmPassword($password = null) {
		if ((isset($this->data[$this->alias]['password']) && isset($password['password_confirma']))
			&& !empty($password['password_confirma'])
			&& ($this->data[$this->alias]['password'] === $password['password_confirma'])) {
			return true;
		}
		return false;
	}

	public function alphaNumericDashUnderscore($check) {
	    // $data array is passed using the form field name as the key
	    // have to extract the value to make the function generic
	    $value = array_values($check);
	    $value = $value[0];
    
	    return preg_match('|^[0-9a-zA-Z_-]*$|', $value);
	}
	
	public function afterLogin() {		
		
		/*
		$user = $this->find('first', array(
			'conditions' => array($this->alias.'.id' => AuthComponent::user('id'))
		));		
		
		$data=array(
			'id'=>$user[$this->alias]['id'],
			'last_login'=>date("Y-m-d H:i:s"),
			'login_count'=>$user[$this->alias]['login_count']+1,
		);		
		$this->save($data);
		*/		
		return true;
	}

	public function beforeSave($options = array()) {
		if (!empty($this->data[$this->alias]['password'])) {
		$passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
		$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
		}
		
		return true;
	}
	
}