<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title_for_layout; ?></title> 
  <!-- Bootstrap Core CSS -->
  <?php
    echo $this->Html->meta('icon');
    echo $this->Html->css('/bootstrap/dist/css/bootstrap.min.css');
    echo $this->Html->css('/js/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css');
  ?>
  <!-- animation CSS -->
  <?php 
    echo $this->Html->css('animate.css');
    echo " <!-- Custom CSS -->   ";
    echo $this->Html->css('style.css');
    echo " <!-- toast-master -->   ";
    echo $this->Html->css('/toast-master/css/jquery.toast.css');
    echo "<!-- color CSS -->"  ;
    echo $this->Html->css('colors/megna.css');
    echo $this->fetch('meta');
    echo $this->fetch('css');   

    echo "<!-- jQuery -->";
    echo $this->Html->script('plugins/bower_components/jquery/dist/jquery.min.js'); 
    echo $this->Html->script('plugins/bower_components/toast-master/js/jquery.toast.js');
  ?>          
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>



<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>

<section id="wrapper" class="login-register">
  <div class="login-box login-sidebar">
    <div class="white-box content-login-center">
      <?php echo $this->Session->flash(); ?>
      <?php echo $this->fetch('content'); ?>
    </div>
  </div>
</section>


  <?php 
    

    echo "<!-- Bootstrap Core JavaScript -->";
    echo $this->Html->script('/bootstrap/dist/js/tether.min.js');
    echo $this->Html->script('/bootstrap/dist/js/bootstrap.min.js');
    echo $this->Html->script('plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js');

    echo "<!-- Menu Plugin JavaScript -->";
    echo $this->Html->script('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js');
    echo "<!--slimscroll JavaScript -->";
    echo $this->Html->script('jquery.slimscroll.js');
    echo $this->Html->script('waves.js');
    echo $this->Html->script('custom.min.js');

    // echo $this->Html->script('plugins/bower_components/styleswitcher/jQuery.style.switcher.js');
  ?>
  
  
</html>