
<div class="box">
    <div class="content-wrap">
        <h6></h6>
        <form action="<?php echo $this->Html->url('recover'); ?>" method="post" name="forma" class="form-horizontal">
            <?php echo $this->Form->input('recover', array('label'=>'Introduce tu cuenta de email para iniciar el proceso de recuperación de contraseña', 'type'=>'email', 'class'=>'form-control')); ?>
            <br>
            <?php echo $this->Form->input('Recuperar', array('type' => 'submit', 'label' => false, 'class' => 'btn-new btn danger login', 'label' => false));?>
            
        </form>
    </div>
</div>