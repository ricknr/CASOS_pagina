<div class="row">
	<div class="col-md-9">
		<h4>Agregar Categoría</h4>
	</div>
	
</div>
<br>
<?php echo $this->Form->create('Categoria', array('novalidate' => true, 'inputDefaults'=>array('class' => 'form-control')) ); ?>
<div class="row">
	<?php
		echo $this->Form->input('nombre', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-6' )) );
		echo $this->Form->input('descripcion', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-6 ' )) );
		echo '<div class="col-md-4"><label>Activo <br>'.$this->Form->input('activo', array('checked'=>true,'div'=>false,'class'=>'js-switch','label'=>false)).'<label></div>';		
	?>
	<div class="col-md-12">
		<?php echo $this->Form->submit( 'Guardar' , array('class'=>'btn btn-success pull-bottom','style'=>'margin-top:25px', 'div'=>false ));?>
		<?php echo $this->AclHtml->link('Cancelar',array('action'=>'index'),array('class'=>'btn btn-default btn-outline pull-bottom','style'=>'margin-top:25px','div'=>false)); ?>
	</div>
	<?php echo $this->Form->end() ?>
</div>

