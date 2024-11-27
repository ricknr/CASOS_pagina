<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></h5>                               
        <div class="ibox-tools">
<?php 
		echo "\t\t<?php\n";
			echo "\t\t\t echo \$this->Html->link('<i class=\"fa fa-reply\"></i> '.__('Regresar'), array('controller' => '".$pluralVar."',  'action' => 'index'), array('class'=>'btn btn-primary btn-xs', 'escape'=>false));\n";			
		echo "\t\t?>\n"; 
?>          
        </div>
    </div>
    <div class="ibox-content">
    	<div class="row">
<?php
		
		echo "<?php\n";
		echo "\techo \$this->Form->create('{$modelClass}', array('novalidate' => true, 'inputDefaults'=>array('class' => 'form-control')) ); \n";
		foreach ($fields as $field) {
			if (strpos($action, 'add') !== false && $field === $primaryKey) {
				continue;
			} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
				echo "\t\techo \$this->Form->input('{$field}', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );\n";
			}
		}
		if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
				echo "\t\techo \$this->Form->input('{$assocName}');\n";
			}
		}
		echo "\t?>\n";
?>
    	</div>

    	<br>
<?php
	echo "\t<?php\n";
		echo "\t\techo \$this->Form->submit( 'Guardar' , array('class'=>'btn btn-success', 'div'=>array() ));\n";
		echo "\t\techo \$this->Form->end();\n";
	echo "\t?>\n";
?>	
    </div>
</div>

<?php
	echo "<?php\n";
		echo "\t \$this->Html->scriptBlock(\"$(function(){  	}); \",array(\"inline\"=>false)); \n";
	echo "?>\n";
?>
