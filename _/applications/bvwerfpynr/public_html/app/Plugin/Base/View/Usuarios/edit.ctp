<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?php echo __('Editar Usuario'); ?></h5>                               
        <div class="ibox-tools">
		<?php
			 echo $this->AclHtml->link('<i class="fa fa-reply"></i> '.__('Regresar'), array('controller' => 'usuarios',  'action' => 'index'), array('class'=>'btn btn-primary btn-xs', 'escape'=>false));
		?>
          
        </div>
    </div>
    <div class="ibox-content">
    	<div class="row">
		<?php
		    echo $this->Form->create('Usuario', array('novalidate' => true, 'inputDefaults'=>array('class' => 'form-control')) ); 
		    echo $this->Form->input('id', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
		    #echo $this->Form->input('nombre', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-6 ' )) );
		    echo $this->Form->input('usuario', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-6 ' )) );
		    #echo $this->Form->input('grupo_id', array( 'label'=> 'Perfil' ,/*'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-6 ' )) );
		    echo $this->Form->input('correo', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-6 ' )) );
		    #echo $this->Form->input('activo', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-12 ' ), 'class'=>'') );
		?>
    	</div>
       <div >
	    <br>
	    <?php echo $this->Form->submit( 'Guardar' , array('class'=>'btn btn-success', 'div'=>false )); ?>
	    <?php echo $this->AclHtml->link('Cancelar',array('action'=>'index'),array('class'=>'btn btn-default')); ?>			
	</div>		
	<?php 	echo $this->Form->end(); ?>
    </div>
</div>

<?php
    $this->Html->scriptBlock("$(function(){  	}); ",array("inline"=>false)); 
?>
