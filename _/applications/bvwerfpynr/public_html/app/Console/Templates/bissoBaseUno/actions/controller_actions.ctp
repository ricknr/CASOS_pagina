<?php
/**
 * Bake Template for Controller action generation.
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
 * @package       Cake.Console.Templates.default.actions
 * @since         CakePHP(tm) v 1.3
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

/**
 * <?php echo $admin ?>index method
 *
 * @return void
 */
	public function <?php echo $admin ?>index() {
		$this-><?php echo $currentModelName ?>->recursive = 0;		
		$conditions=array();		
		if ($this->request->is('post')) {
			// $conditions[] = array('<?php echo $currentModelName ?>.field LIKE' => '%'. $this->request->data['field'] . '%');
			// $this->request->data['field'] = $this->request->data['field'];
		}		
		$this->Paginator->settings = array(
			'conditions' => $conditions,
			//'contain' => array(),
			'order'=>array('<?php echo $currentModelName ?>.'.$this-><?php echo $currentModelName ?>->primaryKey => 'desc')
		);
		<?php echo '$'.$pluralName ?> = $this->Paginator->paginate('<?php echo $currentModelName ?>');		
		/*
		<?php echo '$'.$pluralName ?> = $this-><?php echo $currentModelName ?>->find('all', 
			array(        
				'conditions' =>$conditions,
				'order'=>array('<?php echo $currentModelName ?>.'.$this-><?php echo $currentModelName ?>->primaryKey => 'desc')
			)
		);	
		*/		
		$this->set(compact('<?php echo $pluralName ?>'));
<?php if (!empty($admin)) echo "\t \$this->layout = 'Base.admin';\n"; else '\n'; ?>
	}

/**
 * <?php echo $admin ?>view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function <?php echo $admin ?>view($id = null) {
		if (!$this-><?php echo $currentModelName; ?>->exists($id)) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		$options = array('conditions' => array('<?php echo $currentModelName; ?>.' . $this-><?php echo $currentModelName; ?>->primaryKey => $id));
		$this->set('<?php echo $singularName; ?>', $this-><?php echo $currentModelName; ?>->find('first', $options));
<?php if (!empty($admin)) echo "\t \$this->layout = 'Base.admin';\n"; else '\n';  ?>
	}

<?php $compact = array(); ?>
/**
 * <?php echo $admin ?>add method
 *
 * @return void
 */
	public function <?php echo $admin ?>add() {
		if ($this->request->is('post')) {
			$this-><?php echo $currentModelName; ?>->create();
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('El <?php echo strtolower($singularHumanName); ?> se ha guardado.'), 'Base.flash_success' );
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'),'Base.flash_error' );
<?php else: ?>
				return $this->flash(__('El <?php echo strtolower($singularHumanName); ?> se ha guardado.'), 'Base.flash_success', array('action' => 'index'));
<?php endif; ?>
			}
		}
<?php
	foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
		foreach ($modelObj->{$assoc} as $associationName => $relation):
			if (!empty($associationName)):
				$otherModelName = $this->_modelName($associationName);
				$otherPluralName = $this->_pluralName($associationName);
				echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
				$compact[] = "'{$otherPluralName}'";
			endif;
		endforeach;
	endforeach;
	if (!empty($compact)):
		echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
	endif;
?>
<?php if (!empty($admin)) echo "\t \$this->layout = 'Base.admin';\n"; else '\n';  ?>
	}

<?php $compact = array(); ?>
/**
 * <?php echo $admin ?>edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function <?php echo $admin; ?>edit($id = null) {
		if (!$this-><?php echo $currentModelName; ?>->exists($id)) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('El <?php echo strtolower($singularHumanName); ?>  se ha guardado.'), 'Base.flash_success');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error' );
<?php else: ?>
				return $this->flash(__('El <?php echo strtolower($singularHumanName); ?>  se ha guardado.'), 'Base.flash_success', array('action' => 'index'));
<?php endif; ?>
			}
		} else {
			$options = array('conditions' => array('<?php echo $currentModelName; ?>.' . $this-><?php echo $currentModelName; ?>->primaryKey => $id));
			$this->request->data = $this-><?php echo $currentModelName; ?>->find('first', $options);
		}
<?php
		foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
			foreach ($modelObj->{$assoc} as $associationName => $relation):
				if (!empty($associationName)):
					$otherModelName = $this->_modelName($associationName);
					$otherPluralName = $this->_pluralName($associationName);
					echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
					$compact[] = "'{$otherPluralName}'";
				endif;
			endforeach;
		endforeach;
		if (!empty($compact)):
			echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
		endif;
	?>
<?php if (!empty($admin)) echo "\t \$this->layout = 'Base.admin';\n"; else '\n';  ?>
	}

/**
 * <?php echo $admin ?>delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function <?php echo $admin; ?>delete($id = null) {
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this-><?php echo $currentModelName; ?>->delete()) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash(__('El <?php echo strtolower($singularHumanName); ?> se ha borrado.'), 'Base.flash_success');
		} else {
			$this->Session->setFlash(__('Ocurrio un error, intentalo de nuevo por favor.'), 'Base.flash_error');
		}
		return $this->redirect(array('action' => 'index'));
<?php else: ?>
			return $this->flash(__('El <?php echo strtolower($singularHumanName); ?> se ha borrado.'), 'Base.flash_success' , array('action' => 'index'));
		} else {
			return $this->flash(__('Ocurrio un error, intentalo de nuevo por favor.' ), 'Base.flash_error', array('action' => 'index'));
		}
<?php endif; ?>
<?php if (!empty($admin)) echo "\t \$this->layout = 'Base.admin';\n"; else '\n';  ?>
	}
