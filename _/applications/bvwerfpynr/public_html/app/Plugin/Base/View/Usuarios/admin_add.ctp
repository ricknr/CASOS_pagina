<div class="row">
	<div class="col-md-9">
		<h4>Agregar Usuario</h4>
	</div>
</div>
<br>
<?php echo $this->Form->create('Usuario', array('type' => 'file', 'inputDefaults'=>array('class' => 'form-control')) ); ?>
<div class="row">
	<?php
		echo $this->Form->input('nombre', array('placeholder'=>'Ej: Luis Lozano',  'div'=>array('class'=>'col-sm-6 ' )) );		
		echo $this->Form->input('usuario', array('placeholder'=>'Ej: luis84',  'div'=>array('class'=>'col-sm-6' )) );
		echo $this->Form->input('grupo_id', array('label'=> 'Perfil', 'div'=>array('class'=>'col-sm-6' )) );


		echo $this->Form->input('correo', array('placeholder'=>'Ej: luis@bisso.mx',  'div'=>array('class'=>'col-sm-6' )) );
		echo $this->Form->input('password', array('label'=>'Contraseña','div'=>array('class'=>'col-sm-6' )) );
		echo $this->Form->input('password_confirma', array( 'label'=>'Confirmar Contraseña','type'=>'password', 'div'=>array('class'=>'col-sm-6' )) );
	?>
		
	<div class="col-md-12">
		<?php echo $this->Form->submit( 'Guardar' , array('class'=>'btn btn-success pull-bottom','style'=>'margin-top:25px', 'div'=>false ));?>
		<?php echo $this->AclHtml->link('Cancelar',array('action'=>'index'),array('class'=>'btn btn-default btn-outline pull-bottom','style'=>'margin-top:25px','div'=>false)); ?>
	</div>
	<?php echo $this->Form->end() ?>
</div>