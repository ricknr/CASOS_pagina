<div class="row">
	<div class="col-md-9">
		<h4>Agregar Grupo</h4>
	</div>
	
</div>
<br>
<?php echo $this->Form->create('Grupo', array('type' => 'file', 'inputDefaults'=>array('class' => 'form-control')) ); ?>
<div class="row">
	<?php
		echo $this->Form->input('nombre', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-6' )) );
		echo $this->Form->input('redirect', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-6' )) );
	?>

		
	<div class="col-md-12">
		<?php echo $this->Form->submit( 'Agregar' , array('class'=>'btn btn-success pull-bottom','style'=>'margin-top:25px', 'div'=>false ));?>
		<?php echo $this->AclHtml->link('Cancelar',array('action'=>'index'),array('class'=>'btn btn-default btn-outline pull-bottom','style'=>'margin-top:25px','div'=>false)); ?>
	</div>
	<?php echo $this->Form->end() ?>
</div>