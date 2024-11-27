<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?php echo __('Admin Add Aco'); ?></h5>                               
        <div class="ibox-tools">
		<?php
			 echo $this->Html->link('<i class="fa fa-reply"></i> '.__('Regresar'), array('controller' => 'acos',  'action' => 'index'), array('class'=>'btn btn-primary btn-xs', 'escape'=>false));
		?>
          
        </div>
    </div>
    <div class="ibox-content">
    	<div class="row">
<?php
	echo $this->Form->create('Aco', array('novalidate' => true, 'inputDefaults'=>array('class' => 'form-control')) ); 
		echo $this->Form->input('parent_id', array( /*label'=> '' ,'placeholder'=>'', */'options'=>$parentAcos,  'div'=>array('class'=>'col-sm-4 ' )) );
		echo $this->Form->input('model', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
		echo $this->Form->input('foreign_key', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
		echo $this->Form->input('alias', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
		//echo $this->Form->input('lft', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
		//echo $this->Form->input('rght', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
		//echo $this->Form->input('Aro');
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
