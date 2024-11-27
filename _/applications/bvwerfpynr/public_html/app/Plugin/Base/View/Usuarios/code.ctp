
<div class="box">
    <div class="content-wrap">      
        <?php
		echo $this->Form->create(null, array('id'=>'recoverForm'));
		echo $this->Form->input('password', array('label'=>'Introduce tu nueva contraseña', 'id'=>'pw1','class'=>'form-control'));
		echo $this->Form->input('password_confirma', array('label'=>'Vuelve a introducir tu nueva contraseña', 'id'=>'pw2', 'type'=>'password','class'=>'form-control'));
		echo '<br>'.$this->Form->end(array('class'=> "btn btn-primary", 'label'=>'Recuperar'));
		?>
    </div>
</div>

