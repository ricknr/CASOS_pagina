<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title_for_layout; ?></title>
    <?php
	echo $this->Html->meta('icon');
	
	echo $this->Html->css('/base/css/bootstrap.min.css');
	echo $this->Html->css('/base/font-awesome/css/font-awesome.css');
	echo $this->Html->css('/base/css/plugins/iCheck/custom.css');
	echo $this->Html->css('/base/css/animate.css');
	echo $this->Html->css('/base/css/style.css');
	echo $this->Html->css('/base/css/header.css');
    echo $this->Html->css('/base/css/datepicker.css');
    echo $this->Html->css('/base/css/overwrite.css');
	
	echo $this->fetch('meta');
	echo $this->fetch('css');
	//echo $this->Html->script('jquery.min.js');
	/*echo $this->Html->script('http://code.jquery.com/jquery-latest.js');*/
    echo $this->Html->script('/base/js/jquery-2.1.1.js');
    echo $this->Html->script('/base/js/jquery-latest.js');
    echo $this->Html->script('/base/js/bootstrap.min.js'); 
    echo $this->Html->script('/base/js/bootstrap.datepicker.js');     
	/*echo $this->Html->script('http://underscorejs.org/underscore-min.js');*/ 
    echo $this->Html->script('/base/js/underscore-min.js'); 
    ?>
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
        
</head>
    <?php 
    if(!empty($_SESSION['mini-navbar']) ){
        $class = 'class="mini-navbar"';
    }else{
        $class='';
    }
    ?>
    <body <?php  echo $class; ?> >
        <div id="div_loading" class="hide" >
            <img src="/img/loading.gif" style="width:120px;top:50%;position:absolute;">                
        </div>
        <div id="wrapper" >
            <header id="header">
                <!--logo start-->
                <div class="brand" style="text-align: center">
                    <a href="/proveedores/registro" class="">
                       <?php echo $this->Html->image('/base/img/logo-negro.png',array('style'=>'margin-top:17px','width'=>'230px')); ?>
                    </a>
                        
                </div>
                <!--logo end-->
               
            </header>

            <div id="" class="gray-bg" style="margin-top:60px;background:#F5F7FA">
                <div class="wrapper wrapper-content">
                    <div class="row row-centered"> 
                        <div class="col-centered col-md-8 col-xs-10 col-sm-10">
                        <?php 
			    echo $this->Session->flash();
			    echo $this->fetch('content');
			?>
                        </div>                      
                    </div>
		     <div class="row" style="padding-top: 20px !important">
                        <div class="col-md-12" style="text-align: center; color: #ccc">
			    <p>Powered by <a href="http://bisso.mx" target="_blank" style="color: #999">Bisso</a></p>
                        </div>                      
                    </div>
                </div>
            </div>
        </div>   	
    <?php 
	echo $this->Html->script('/base/js/plugins/metisMenu/jquery.metisMenu.js');
	echo $this->Html->script('/base/js/plugins/slimscroll/jquery.slimscroll.min.js');
	echo $this->Html->script('/base/js/inspinia.js');
	echo $this->Html->script('/base/js/general.js');
	echo $this->fetch('script'); 
	echo $this->Js->writeBuffer();
    ?>
    <?php echo $this->element('sql_dump'); ?>
    </body>
   
    <script type="text/javascript">
        $(function(){
            $('input.datepicker').datepicker({
                format: 'yyyy-mm-dd',
            });     
        })
    </script>
</html>