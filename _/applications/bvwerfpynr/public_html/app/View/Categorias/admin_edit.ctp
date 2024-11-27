<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?php echo __('Edit Categoria'); ?></h5>                               
        <div class="ibox-tools">
		<?php
			 echo $this->Html->link('<i class="fa fa-reply"></i> '.__('Regresar'), array('controller' => 'categorias',  'action' => 'index'), array('class'=>'btn btn-primary btn-xs', 'escape'=>false));
		?>
          
        </div>
    </div>
    <div class="ibox-content">
    	<div class="row">
<?php
	echo $this->Form->create('Categoria', array('novalidate' => true, 'inputDefaults'=>array('class' => 'form-control')) ); 
		echo $this->Form->input('id', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
		echo $this->Form->input('nombre', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
		echo $this->Form->input('descripcion', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
		echo $this->Form->input('activo', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
		echo $this->Form->input('creado_por', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
		echo $this->Form->input('modificado_por', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
	?>
    	</div>

    	<br>
	<?php
		echo $this->Form->submit( 'Guardar' , array('class'=>'btn btn-success', 'div'=>array() ));
		echo $this->Form->end();
	?>
	
    </div>
</div>

<?php
	 $this->Html->scriptBlock("$(function(){  	}); ",array("inline"=>false)); 
?>
