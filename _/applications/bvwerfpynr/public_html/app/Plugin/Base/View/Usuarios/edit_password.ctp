<h4>Cambiar contraseña</h4>
<div class="row">
	<div class="col-md-12">
       Usuario: <?php echo $usuario['Usuario']['nombre']?>
    </div>
    <?php echo $this->Form->create('Usuario', array('class'=>'row')) ?>
	<?php 
		echo $this->Form->input('password',array('class'=>'form-control', 'label'=>'Contraseña Nueva','value'=>'','placeholder'=>'', 'div'=>array('class'=>'col-sm-4')));
		echo $this->Form->input('password_confirma',array('class'=>'form-control', 'label'=>'Confirma la nueva Contraseña','value'=>'','placeholder'=>'', 'div'=>array('class'=>'col-sm-4')));
	?>
	<?php echo $this->Form->submit( 'Cambiar contraseña' , array('class'=>'btn btn-success pull-bottom','style'=>'margin-top:25px', 'div'=>array('class'=>'col-sm-4 ' ) ));?>
	<?php echo $this->Form->end() ?>
</div>









<!-- 

 <div class="ibox float-e-margins">
      <div class="ibox-title">
	  <h5>Cambiar contraseña</h5>                               
      </div>
      <div class="ibox-content">
	 <?php echo $this->Form->create('Usuario', array('role' => 'form')) ?>
	 <div class="row">
	    <div class="col-md-6">
	       Usuario: <?php echo $usuario['Usuario']['nombre']?>
	    </div>
	 </div>    
	 <div class="row">
	    <div class="col-md-3">
	       <?php 
		  #echo $this->Form->hidden('id', array('value' => $this->Session->read('Usuario.id')));
		  echo $this->Form->hidden('id', array('value' => $usuario['Usuario']['id']));
		  echo $this->Form->input('password', array('class' => 'form-control','label'=>'Contraseña Nueva')) 
	       ?>
	    </div>
	    <div class="col-md-4">
	       <?php echo $this->Form->input('password_confirma', array('class' => 'form-control','label'=>'Confirma la nueva Contraseña','type'=>'password')) ?>
	    </div>		   
	    <div class="col-md-3">
	       <br><br>		        
	       <input type="submit" value="Cambiar contraseña" class="btn btn-success">  			
	    </div>		      
	 </div>    	
	 <?php echo $this->Form->end() ?>
      </div>
</div> -->