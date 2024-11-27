<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon.png">
    <title>Caritas - Admin casos</title>
    <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('/bootstrap/dist/css/bootstrap.min.css');
        echo $this->Html->css('/js/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css');
        echo $this->Html->css('/js/plugins/bower_components/bootstrap-table/dist/bootstrap-table.min.css');
        echo $this->Html->css('/js/plugins/bower_components/switchery/dist/switchery.min.css');
        echo $this->Html->css('/js/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css');

        echo $this->Html->css('/js/plugins/bower_components/bootstrap-select/bootstrap-select.min.css');
        echo $this->Html->css('/js/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css');
        echo $this->Html->css('jquery.loading.css');
    ?>

    <?php 
        echo $this->Html->css('/js/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css');
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
        

        // echo $this->Html->script('plugins/bower_components/switchery/dist/switchery.min.css');


    ?>    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="">
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>

    <div id="wrapper">
        <!-- Top Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <!-- Responsive -->
                <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse">
                    <i class="ti-menu"></i>
                </a>
                
                <!-- Logo -->
                <div class="top-left-part" style="text-align:center">
                    <a class="logo" href="<?php echo AuthComponent::user('Grupo.redirect')?>">
                        <b><img src="/img/paloma.png" alt="home" style="width:90%"></b>
                        <!-- <span class="hidden-xs" style="display: inline;">
                            <img src="/img/logo_caritas_blanco.png" style="width:90px">
                        </span> -->
                    </a>
                </div>
                
                <!-- Search -->
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li>
                        <a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light">
                            <i class="icon-arrow-left-circle ti-menu"></i>
                        </a>
                    </li>
                    <li>
                        <form role="search" class="app-search hidden-xs" action="/admin/casos/index" method="post">
                            <input type="text" placeholder="Buscar caso..." class="form-control" name="data[titulo]">
                            <a href=""><i class="fa fa-search"></i></a>
                        </form>
                    </li>
                </ul>

                <!-- Menu superior -->
                

                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false"> 
                            <b class="hidden-xs"><?php  echo AuthComponent::user('nombre'); ?></b> 
                        </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li><a href="/base/usuarios/view/<?php  echo AuthComponent::user('id'); ?>"><i class="ti-user"></i>  Mi Perfil</a></li>
                            <li><a href="/base/usuarios/logout"><i class="fa fa-power-off"></i>  Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>

            </div>            
        </nav>        
        <!-- End Top Navigation -->

        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <!-- <li class="sidebar-search hidden-sm hidden-md hidden-lg">                        
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search..."> 
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"> <i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                    </li> -->
                    <?php echo $this->element('Base.sidebar'); ?>
                    
                </ul>
            </div>
        </div>        
        <!-- Left navbar-header end -->


        <!-- Page Content -->
        <div id="page-wrapper">
            
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <?php
                                echo $this->Session->flash();
                                echo $this->fetch('content');
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <footer class="footer text-center"> <a href="http://bisso.mx/" target="_blank">2017 Powered by Bisso</a></footer>
        </div>
        
    </div>    


<?php 
    

    echo "<!-- Bootstrap Core JavaScript -->";
    echo $this->Html->script('/bootstrap/dist/js/tether.min.js');
    echo $this->Html->script('/bootstrap/dist/js/bootstrap.min.js');
    echo $this->Html->script('plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js');

    echo "<!-- Menu Plugin JavaScript -->";
    echo $this->Html->script('plugins/bower_components/sidebar-nav/dist/sidebar-nav.js');

    echo "<!--slimscroll JavaScript -->";
    echo $this->Html->script('jquery.slimscroll.js');
    echo $this->Html->script('waves.js');
    echo $this->Html->script('custom.min.js');

    echo $this->Html->script('plugins/bower_components/bootstrap-table/dist/bootstrap-table.min.js');
    echo $this->Html->script('plugins/bower_components/bootstrap-table/dist/bootstrap-table.ints.js');

    

    echo $this->Html->script('plugins/bower_components/styleswitcher/jQuery.style.switcher.js');
    echo $this->Html->script('plugins/bower_components/switchery/dist/switchery.min.js');
    echo $this->Html->script('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js');
    echo $this->Html->script('plugins/bower_components/bootstrap-select/bootstrap-select.min.js');
    echo $this->Html->script('plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js');

    echo $this->Html->script('jquery.loading.js');
    


    echo $this->fetch('script'); 
    echo $this->Js->writeBuffer();
?>



<script type="text/javascript">
$(function(){
    initSwitchery();    
})

function initSwitchery(){
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    $('.js-switch').each(function() {
        new Switchery($(this)[0], $(this).data());
    });
}
</script>
</body>

</html>
