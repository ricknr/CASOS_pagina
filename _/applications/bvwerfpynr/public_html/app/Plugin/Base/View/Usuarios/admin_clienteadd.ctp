<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?php echo __('Agregar usuario al cliente: ').$cliente['Cliente']['nombre']; ?></h5>                               
        <div class="ibox-tools">
		<?php
			 echo $this->AclHtml->link('<i class="fa fa-reply"></i> '.__('Regresar'), array( 'admin'=>false, 'plugin'=>false ,'controller' => 'clientes',  'action' => 'view', $cliente['Cliente']['id'] ), array('class'=>'btn btn-primary btn-xs', 'escape'=>false));
		?>
          
        </div>
    </div>
    <div class="ibox-content">
    	<div class="row">
		<?php
			echo $this->Form->create('Usuario', array('novalidate' => true, 'inputDefaults'=>array('class' => 'form-control')) ); 
			
			echo $this->Form->input('nombre', array( /*label'=> '' ,*/'placeholder'=>'Ej: Luis Lozano',  'div'=>array('class'=>'col-sm-4 ' )) );		
			echo $this->Form->input('usuario', array( /*label'=> '', */'placeholder'=>'Ej: luis84',  'div'=>array('class'=>'col-sm-4 ' )) );
			echo $this->Form->input('correo', array( /*label'=> '' ,*/ 'placeholder'=>'Ej: luis@bisso.mx',  'div'=>array('class'=>'col-sm-4 ' )) );
		?>
    	</div>
    	<div class="row">
		<?php
			echo $this->Form->input('password', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
			echo $this->Form->input('password_confirma', array( /*label'=> '' ,'placeholder'=>'', */ 'type'=>'password', 'div'=>array('class'=>'col-sm-4 ' )) );
			
		?>
    	</div>
       <div >
			<br>
			<?php echo $this->Form->submit( 'Guardar' , array('class'=>'btn btn-success', 'div'=>false )); ?>
			<?php echo $this->AclHtml->link('Cancelar',array('action'=>'index'),array('class'=>'btn btn-danger')); ?>			
	   </div>		
	<?php 	echo $this->Form->end(); ?>
	
    </div>
</div>

<?php
	 $this->Html->scriptBlock("$(function(){  	}); ",array("inline"=>false)); 
?>
