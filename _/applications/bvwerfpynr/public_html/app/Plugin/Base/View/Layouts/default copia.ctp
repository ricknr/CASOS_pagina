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
                    <a href="/" class="">
                       <?php echo $this->Html->image('/base/img/logo-negro.png',array('style'=>'margin-top:17px','width'=>'230px')); ?>
                    </a>
                        
                </div>
                <!--logo end-->
                <ul class="nav navbar-nav navbar-left">
                    <li class="toggle-navigation toggle-left">
                        <!-- <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a> -->

                        <button class="navbar-minimalize minimalize-styl-2 btn btn-primary" id="toggle-left">
                            <i class="fa fa-bars"></i>
                        </button>
                    </li>
                    
                    <!--<li class="hidden-xs hidden-sm">
                        <form method="post" action="/clientes">
                            <input class="search" name="data[nombre]" placeholder="Buscar" type="text">
                            <button type="submit" class="btn btn-sm btn-search"><i class="fa fa-search"></i>
                            </button>
                        </form>
                    </li>-->
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown profile hidden-xs">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="meta">                                
                            <span class="text"><?php echo AuthComponent::user('nombre'); ?></span>
                            <span class="caret"></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight" role="menu">                                                    
                            <li></li>
                             <?php 	if(AuthComponent::user('grupo_id') == 6 ): ?>
							<li>
                                <a href="/admin/sociosComerciales/view/<?php  echo AuthComponent::user('socio_comercial_id'); ?>">
                                    <span class="icon"><i class="fa fa-user"></i>
                                    </span>Socio Comercial</a>
                            </li> 							
							<?php 	endif; ?>
                           <li>
                                <a href="/base/usuarios/view/<?php  echo AuthComponent::user('id'); ?>">
                                    <span class="icon"><i class="fa fa-user"></i>
                                    </span>Mi Cuenta</a>
                            </li>                                                        
                            <li>
                                <a href="/logout">
                                    <span class="icon"><i class="fa fa-sign-out"></i>
                                    </span>Logout</a>
                            </li>
                        </ul>
                    </li>
                     <!--<li class="toggle-fullscreen hidden-xs">
                        <button type="button" class="btn btn-default expand" id="toggle-fullscreen">
                            <i class="fa fa-expand"></i>
                        </button>
                    </li>   -->                 
                </ul>
            </header>

            <!-- Menu -->
            <nav class="navbar-default navbar-static-side" role="navigation" style="margin-top:60px">
                <?php echo $this->element('Base.sidebar'); ?>        
   
            </nav>

            <div id="page-wrapper" class="gray-bg" style="margin-top:60px;background:#F5F7FA">
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-md-12">
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