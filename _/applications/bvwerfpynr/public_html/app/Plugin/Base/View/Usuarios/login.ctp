
<form class="form-horizontal form-material" id="loginform" action="<?php echo $this->Html->url('login'); ?>" method="post">
  <a href="javascript:void(0)" class="text-center db">
    <br><br>
    <img src="/img/images_template/logo_caritas.jpg" alt="Home" style="width:100px" />    
  </a>  
  
  <div class="form-group m-t-40">
    <div class="col-xs-12">
      <input class="form-control" type="text" required="" placeholder="Usuario" name="data[Usuario][usuario]">
    </div>
  </div>
  <div class="form-group">
    <div class="col-xs-12">
      <input class="form-control" type="password" required="" placeholder="Contraseña" name="data[Usuario][password]">
    </div>
  </div>
  <div class="form-group">
    <div class="col-md-12">
      
      <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> ¿Olvidaste tu contraseña?</a> </div>
  </div>
  
  <div class="form-group text-center m-t-20">
    <div class="col-xs-12">
      <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Entrar</button>
    </div>
  </div>
</form>


<form class="form-horizontal" id="recoverform" method="post" action="<?php echo $this->Html->url('recover'); ?>">
  <div class="form-group ">
    <div class="col-xs-12">
      <h3>Recuperar Password</h3>
      <p class="text-muted">
        Ingresa tu dirección de email registrada en el sistema para recuperar tu contraseña.        
      </p>
    </div>
  </div>
  <div class="form-group ">
    <div class="col-xs-12">
      <input class="form-control" type="text" required="" placeholder="Email" name="data[recover]">
    </div>
  </div>
  <div class="form-group">
    <div class="col-md-12">
      
      <a href="#" id="to-login" class="text-dark pull-right"> Regresar</a> </div>
  </div>
  <div class="form-group text-center m-t-20">
    <div class="col-xs-12">
      <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Enviar</button>
    </div>
  </div>
</form>

<script type="text/javascript">
  $(function(){
    $('#to-login').on("click", function (e) {
        e.preventDefault();
        $("#recoverform").slideUp(function(){
          $("#loginform").fadeIn();
        });
    });
    
  })
</script>