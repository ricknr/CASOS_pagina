<?php

App::uses('ModelBehavior', 'Model');

/**
 * Upload Model Behavior
 * Handles all upload, update, delete & createThumb logic for a file field in a model
 * @subpackage UploadBehavior
 * @version 1.1
 * @author Christian VC
 **/
class UploadBehavior extends ModelBehavior {

/**
 * @var array $errorCodes
 **/
	public $errorCodes = array(
		1 => 'The file is too large (server).',
		2 => 'The file is too large (form).',
		3 => 'The file was only partially uploaded.',
		4 => 'No file was uploaded.',
		5 => 'The servers temporary folder is missing.',
		6 => 'Failed to write to the temporary folder.'
	);

/**
 * @var array $uploadedImages contains all the uploaded images in a batch model save call
 **/
	public $uploadedImages = array();

/**
 * @var array $deleteQueue contains all the deleted images in a batch model delete call
 **/
	public $deleteQueue = array();

/**
 * changeSetting method
 * Changes an upload setting
 * @param instance $Model Model Class Intance (automatically set by Behavior parent class)
 * @param string $field Setting to change
 * @param mixed $value Setting's value
 * @return void
 **/
	public function changeSetting(Model $Model, $field = null, $value = null){
		
		if($field && $value){
			$this->settings[$Model->alias][$field] = $value;
		}
	}

/**
 * getUploadedImages method
 * Returns all the uploaded files
 * @return array
 **/
	public function getUploadedImages(Model $Model){
		
		return $this->uploadedImages[$Model->alias];
	}

	public function setup(Model $Model, $settings = array()) {		
		
		if (!isset($this->settings[$Model->alias])) {						
			$this->settings[$Model->alias] = array(
				'allowedMimeTypes' => array(
					'image/jpeg',
					'image/png',
					'image/gif',
					'image/x-jpeg',
					'image/x-png',
					'image/x-gif',
					'text/plain',
					'image/x-citrix-png',
					'image/x-citrix-jpeg',
					'application/zip',
					'application/x-rar-compressed',
					'audio/mpeg',
					'video/quicktime',
					'application/pdf',
					'image/vnd.adobe.photoshop',
					'application/postscript',
					'application/msword',
					'text/csv',
					'application/rtf',
					'application/vnd.ms-excel',
					'application/vnd.ms-powerpoint',
					'application/xml',
					'text/plain',
					'text/xml'
				),
				'fileNameField'=> 'filename',
				'randomFieldName' => 'encname',
				'relativeFilePathField'=> 'filepath',
				'maxFileSize' => 5242880, // 5MB
				'randomStoredFilename' => true,
				'thumbs_create' => false,
				'thumbs_sizes' => array(
					'small' => array('width' => 140, 'height' => 140),
					'medium' => array('width' => 280, 'height' => 280),
				),
				'thumbs_keepAspect' => false,
				'thumbs_folder' => 'files/',
				'uploadFolder' => 'files/',
			);
		}

		if (!isset($this->uploadedImages[$Model->alias]) ){
			$this->uploadedImages[$Model->alias] = array();
		}

		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], (array)$settings);

		
	}

	public function beforeSave(Model $Model, $options = array()){
		// debug($Model->data);
		if ( isset($Model->data[$Model->alias][$this->settings[$Model->alias]['fileNameField']]) && !empty($Model->data[$Model->alias][$this->settings[$Model->alias]['fileNameField']]) ) {
			if( is_array($Model->data[$Model->alias][$this->settings[$Model->alias]['fileNameField']]) ){
				if($Model->data[$Model->alias][$this->settings[$Model->alias]['fileNameField']]['error'] == 0){
					if( in_array($Model->data[$Model->alias][$this->settings[$Model->alias]['fileNameField']]['type'], $this->settings[$Model->alias]['allowedMimeTypes']) ){
						if( $Model->data[$Model->alias][$this->settings[$Model->alias]['fileNameField']]['size'] <= $this->settings[$Model->alias]['maxFileSize']){
							if(array_key_exists('id', $Model->data[$Model->alias])){
								$this->deleteQueue[$Model->alias] = $Model->findById($Model->data[$Model->alias]['id']);
							}
							$saveAs = '';
							if($this->settings[$Model->alias]['randomStoredFilename'] === false){
								$saveAs = $Model->data[$Model->alias][$this->settings[$Model->alias]['fileNameField']]['name'];
							}else{
								$ext = explode('.', $Model->data[$Model->alias][$this->settings[$Model->alias]['fileNameField']]['name']);
								$ext = end($ext);
								$ext = ($ext) ? $ext : 'jpg';
								$saveAsRandom = md5(uniqid()).'.'.$ext;
								$saveAs = $Model->data[$Model->alias][$this->settings[$Model->alias]['fileNameField']]['name'];

							}
							// if(!file_exists(WWW_ROOT.$this->settings[$Model->alias]['uploadFolder'])){							
							// 	mkdir(WWW_ROOT.$this->settings[$Model->alias]['uploadFolder'], 0777, true);
							// }


							App::uses('Folder', 'Utility');
						    $folder = new Folder(WWW_ROOT . $this->settings[$Model->alias]['uploadFolder']);

					       // Si no existe la carpeta para el usuario, la creamos
					       if(!$folder->path){  
					           $crea_dir = new Folder(WWW_ROOT . $this->settings[$Model->alias]['uploadFolder'], true, 0777);
					       }

							// debug($this->settings[$Model->alias]['uploadFolder']);die;
							if($this->settings[$Model->alias]['randomStoredFilename'] == true) {
								if(move_uploaded_file($Model->data[$Model->alias][$this->settings[$Model->alias]['fileNameField']]['tmp_name'], $this->settings[$Model->alias]['uploadFolder'].$saveAsRandom)){
										$Model->data[$Model->alias][$this->settings[$Model->alias]['randomFieldName']] = $saveAsRandom;
										$Model->data[$Model->alias][$this->settings[$Model->alias]['fileNameField']] = $saveAs;
										$Model->data[$Model->alias][$this->settings[$Model->alias]['relativeFilePathField']] = $this->settings[$Model->alias]['uploadFolder'];
								if ($this->settings[$Model->alias]['thumbs_create'] ){
									$this->_create_thumbs($Model, $saveAs);
								}

								return true;

								}else{
									
									return false;
								}
							}
							else {
							if(move_uploaded_file($Model->data[$Model->alias][$this->settings[$Model->alias]['fileNameField']]['tmp_name'], $this->settings[$Model->alias]['uploadFolder'].$saveAs)){
										$Model->data[$Model->alias][$this->settings[$Model->alias]['fileNameField']] = $saveAs;
								$Model->data[$Model->alias][$this->settings[$Model->alias]['relativeFilePathField']] = $this->settings[$Model->alias]['uploadFolder'];
								if ($this->settings[$Model->alias]['thumbs_create'] ){
									$this->_create_thumbs($Model, $saveAs);
								}

								return true;

							}else{
								
								return false;
							}
							}
						}else{
							
							return false;
						}

					}else{
						
						return false;
					}

				}else{
					if($Model->data[$Model->alias][$this->settings[$Model->alias]['fileNameField']]['error'] == 4){
						unset($Model->data[$Model->alias][$this->settings[$Model->alias]['fileNameField']]);
						return true;
					}
					
					return false;
				}
			}
		}
		return true;
	}

	public function afterSave(Model $Model, $created,$options = array()){
		
		$model = $Model->alias;
		$this->uploadedImages[$model][] = $Model->id;
		if(array_key_exists($model, $this->deleteQueue)){
			$this->afterDelete($Model);
		}
	}

	public function beforeDelete(Model $Model, $cascade = true){
		
		$model = $Model->alias;
		$this->deleteQueue[$model] = $Model->find('first', array(
			'conditions' => array(
				$model.'.id' => $Model->id
			),
			'recursive' => -1
		));
		return true;
	}

	public function afterDelete(Model $Model){
		
		$model = $Model->alias;
		if(array_key_exists($model, $this->deleteQueue) && !empty($this->deleteQueue[$model])){
			$filename = $this->deleteQueue[$model][$model][$this->settings[$model]['randomFieldName']];
			$filepath = WWW_ROOT.$this->deleteQueue[$model][$model][$this->settings[$model]['relativeFilePathField']];			
			if($filename){
				if(file_exists($filepath.$filename)){
					unlink($filepath.$filename);
					foreach($this->settings[$model]['thumbs_sizes'] as $kind => $size){
						if(file_exists($filepath.$kind.'_'.$filename)){
							unlink($filepath.$kind.'_'.$filename);
						}
					}
				}
			}
		}
	}

	private function _create_thumbs($Model, $image = '') {		
		$blend = true;
		$image_full_path = $this->settings[$Model->alias]['uploadFolder'].$image;

		if (file_exists($image_full_path)) {

			$source_size = getimagesize($image_full_path);

			if ($source_size !== false) {

				switch($source_size['mime']) {
					case 'image/jpeg':
						$source = imagecreatefromjpeg($image_full_path);
						$blend = false;
						break;

					case 'image/png':
						$source = imagecreatefrompng($image_full_path);
						break;

					case 'image/gif':
						$source = imagecreatefromgif($image_full_path);
						break;

					default:
						return;
						break;
				}

				$oem = array( $source_size[0], $source_size[1] );
				foreach( $this->settings[$Model->alias]['thumbs_sizes'] as $kind => $thumb){
					$source_size[0] = $oem[0];
					$source_size[1] = $oem[1];
					$source_pos = array(0, 0);
					
					if($this->settings[$Model->alias]['thumbs_keepAspect']){
						$ratio = ($source_size[0] > $source_size[1]) ? $source_size[0]/$thumb['width'] : $source_size[1]/$thumb['height'];
						$new_size = array(
							ceil($source_size[0]/$ratio),
							ceil($source_size[1]/$ratio)
						);

					}else{
						$new_size = array($thumb['width'], $thumb['height']);
						if($source_size[0] < $source_size[1]){
							$source_pos = array(0, ($source_size[1]-$source_size[0])/2 );
							$source_size[1] = $source_size[0];

						} else {
							$source_pos = array(($source_size[0]-$source_size[1])/2 , 0);
							$source_size[0] = $source_size[1];
						}
					}


					if ($new_size[0] < 1) $new_size[0] = 1;
					if ($new_size[1] < 1) $new_size[1] = 1;

					$thumbnail = imagecreatetruecolor($new_size[0], $new_size[1]);
					
					imagecopyresampled($thumbnail, $source, 0, 0, $source_pos[0], $source_pos[1], $new_size[0], $new_size[1], $source_size[0], $source_size[1]);
					if($blend){
						imagealphablending($thumbnail, false);
						imagesavealpha($thumbnail, true);
					}

					switch($source_size['mime']) {
						case 'image/jpeg':
							imagejpeg($thumbnail, $this->settings[$Model->alias]['thumbs_folder'].$kind.'_'.$image);
							break;

						case 'image/png':
							imagepng($thumbnail, $this->settings[$Model->alias]['thumbs_folder'].$kind.'_'.$image);
							break;

						case 'image/gif':
							imagegif($thumbnail, $this->settings[$Model->alias]['thumbs_folder'].$kind.'_'.$image);
							break;

						default:
							break;
					}
				}

			}

		}
	}

}
?>