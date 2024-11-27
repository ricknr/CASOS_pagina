<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns#">
	<head>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-KMH8ZS3');</script>
		<!-- End Google Tag Manager -->
		<meta charset="UTF-8">
		<!-- For IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!-- For Resposive Device -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>Cáritas de Monterrey, A.B.P.</title>

		<!-- Favicon -->
		<link rel="icon" type="image/png" sizes="16x16" href="/img/icon.png">


		<!-- Main style sheet -->
		<!-- responsive style sheet -->
		<?php 
			echo $this->Html->css('/front/css/style.css');
			echo $this->Html->css('/front/css/responsive.css');

			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');

			#//<!-- jQuery -->
			echo $this->Html->script('/front/vendor/jquery.2.2.3.min.js');
			// echo $this->Html->script('http://code.jquery.com/jquery-3.2.1.min.js');

			echo " <!-- toast-master -->   ";
        	echo $this->Html->css('/toast-master/css/jquery.toast.css');
        	echo $this->Html->script('plugins/bower_components/toast-master/js/jquery.toast.js');
		?>
		
		





		<!-- Fix Internet Explorer ______________________________________-->

		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
			<script src="/front/vendor/html5shiv.js"></script>
			<script src="/front/vendor/respond.js"></script>
		<![endif]-->
			
	</head>

	<body class="charity-theme">
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KMH8ZS3"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
		
		<div class="main-page-wrapper">

			<!-- ===================================================
				Loading Transition
			==================================================== -->
			<div id="loader-wrapper">
				<div id="loader"></div>
			</div>


			<!-- 
			=============================================
				Theme Header
			============================================== 
			-->
			<header class="charity-header">
				<!-- ============================ Theme Menu ========================= -->
				<div class="theme-main-menu">
				   <div class="container">
				   		<div class="main-container clearfix">
				   			<div class="logo float-left">
				   				<a href="https://www.caritas.org.mx/"><img src="/img/logo_caritas_blanco.png" style="width:140px" alt="Logo"></a>
				   			</div>

				   			<div class="right-content float-right">				   				
				   				<button class="search ch-p-bg-color round-border tran3s" id="search-button"><i class="fa fa-search" aria-hidden="true"></i></button>
				   				<div class="search-box tran5s" id="searchWrapper">
				   					<button id="close-button" class="ch-p-color"><i class="flaticon-cross"></i></button>
				   					<div class="container">
				   						<img src="/img/caritas_azul.png" style="width:190px" alt="Logo">
				   						<form action="/casos" method="post">
				   							<input type="text" placeholder="Busca una causa" name="data[texto]">
				   							<button class="ch-p-bg-color"><i class="fa fa-search" aria-hidden="true"></i></button>
				   						</form>
				   					</div>
				   				</div> <!-- /.search-box -->
				   			</div> <!-- /.right-content -->

				   			<!-- ============== Menu Warpper ================ -->
				   			<div class="menu-wrapper float-right">
				   				<nav id="mega-menu-holder" class="clearfix">
								   <ul class="clearfix">
								      <li><a href="/">Inicio</a></li>
								      <li><a href="/casos">Casos Prioritarios</a></li>
								      <li><a href="/casos_resueltos">Casos resueltos</a></li>
								      <li><a href="/contacto">Contacto</a></li>								      
								   </ul>
								</nav> <!-- /#mega-menu-holder -->
				   			</div> <!-- /.menu-wrapper -->

				   		</div> <!-- /.main-container -->
				   </div> <!-- /.container -->
				</div> <!-- /.theme-main-menu -->
			</header> <!-- /.charity-header -->
			
			


			<div>
				<?php #echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
			</div>

			
		


			<!-- 
			=============================================
				Footer
			============================================== 
			-->
			<footer class="default-footer charity-footer">
				<div class="container">
					<div class="top-footer row">
						<div class="col-md-3 col-sm-6 footer-logo">
							<a href="https://www.caritas.org.mx/"><img src="/img/logo_caritas_blanco.png" style="width:120px" alt="Logo"></a>
							<p>
								Francisco G. Sada #2810 Pte.<br>
								Col. Deportivo Obispado,<br>
								Monterrey, N.L. C.P. 64040<br>
								Tel. (81) 1340-2000
							</p>
						</div> <!-- /.footer-logo -->

						<div class="col-md-2 col-sm-6  col-md-offset-1 footer-list">
							<h6>Información</h6>
							<ul>
								<li><a href="/" class="tran3s">Inicio</a></li>
								<li><a href="/causas" class="tran3s">Casos prioritarios</a></li>
								<li><a href="/casos_resueltos" class="tran3s">Casos resueltos</a></li>
								<li><a href="/contacto" class="tran3s">Contacto</a></li>
							</ul>
						</div> <!-- /.footer-list -->
					
						<div class="col-md-4 col-sm-6 col-md-offset-2 footer-subscribe">
							<h6>Suscríbete</h6>
							<p>Para recibir nuestro boletín con las últimas noticias y eventos.</p>
							<form action="#" id="formNews">
								<input type="text" placeholder="Correo electrónico" name="mail" id="mailNewsletter">
								<button class="tran3s ch-p-bg-color"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
							</form>
						</div> <!-- /.footer-subscribe -->
					</div> <!-- /.top-footer -->
				</div> <!-- /.container -->

				<div class="bottom-footer">
					<div class="container">
						<div class="wrapper clearfix">
							<p class="float-left">
								2017 Powered by <a href="http://bisso.mx/" target="_blank" style="color:#1E9CA7;">Bisso.</a>
								|
								<a href="/files/AVISO_PRIVACIDAD_GENERAL.pdf" target="_blank" style="color:#1E9CA7;">Aviso de privacidad</a>
							</p>
							<ul class="float-right">
								<li><a href="https://www.facebook.com/caritasdemonterrey" target="_blank" class="tran3s round-border"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li><a href="https://twitter.com/caritasmty" class="tran3s round-border" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>					
								<li><a href="https://www.instagram.com/caritasmty/" class="tran3s round-border" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>	
								<li><a href="https://www.youtube.com/user/caritasdemonterrey" class="tran3s round-border" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>								
							</ul>
						</div> <!-- /.wrapper -->
					</div> <!-- /.container -->
				</div> <!-- /.bottom-footer -->
			</footer>



	        <!-- Scroll Top Button -->
			<button class="scroll-top tran3s hvr-shutter-out-horizontal">
				<i class="fa fa-angle-up" aria-hidden="true"></i>
			</button>
		<!-- Js File_________________________________ -->

		<script type="text/javascript" src="/js/jquery.confetti.js"></script>
		<?php
			
			#//<!-- Bootstrap JS -->
			echo $this->Html->script('/front/vendor/bootstrap/bootstrap.min.js');

			#//<!-- Vendor js _________ -->
			#//<!-- revolution -->
			echo $this->Html->script('/front/vendor/revolution/jquery.themepunch.tools.min.js');
			echo $this->Html->script('/front/vendor/revolution/jquery.themepunch.revolution.min.js');
			echo $this->Html->script('/front/vendor/revolution/revolution.extension.slideanims.min.js');
			echo $this->Html->script('/front/vendor/revolution/revolution.extension.layeranimation.min.js');
			echo $this->Html->script('/front/vendor/revolution/revolution.extension.navigation.min.js');
			echo $this->Html->script('/front/vendor/revolution/revolution.extension.kenburn.min.js');
			
			#//<!-- menu  -->
			echo $this->Html->script('/front/vendor/menu/src/js/jquery.slimmenu.js');
			echo $this->Html->script('/front/vendor/jquery.easing.1.3.js');


			#//<!-- Bootstrap Select JS -->
			echo $this->Html->script('/front/vendor/bootstrap-select/dist/js/bootstrap-select.js');
			#//<!-- fancy box -->
			echo $this->Html->script('/front/vendor/fancy-box/jquery.fancybox.pack.js');

			#<!-- WOW js -->
			echo $this->Html->script('/front/vendor/WOW-master/dist/wow.min.js');
			#<!-- owl.carousel -->
			echo $this->Html->script('/front/vendor/owl-carousel/owl.carousel.min.js');
			
			#//<!-- js count to -->
			echo $this->Html->script('/front/vendor/jquery.appear.js');
			echo $this->Html->script('/front/vendor/jquery.countTo.js');
			#<!-- Circle Progress -->
			echo $this->Html->script('/front/vendor/circle-progress.js');

			#<!-- Progress Bar js -->
			
			echo $this->Html->script('/front/vendor/skills-master/jquery.skills.js');

			#<!-- Theme js -->
			echo $this->Html->script('/front/js/theme.js');			
		?>

		<script type="text/javascript">
			$(function(){
				$('#formNews').submit(function(e){
					e.preventDefault();

					var mail = $('#mailNewsletter').val();
					$.ajax({
					   cache:false,
			           type: "POST",
			           dataType: "json",
			           contentType: "application/x-www-form-urlencoded",
			           url:'/casos/newsletter',
			           data:{
			           		mail:mail,
			           		bot:'bisso'
			           },
			           success:function(data){
							if(data.code == 100){
								alert('Tu dirección de correo electrónico se ha guardado correctamente.');
								$('#mailNewsletter').val('');
							}else{
								alert(data.msj);
							}
			           },
			           error:function(data){
			           	//alert('error');
			           }
			         });

				});
			})
		</script>
		</div> <!-- /.main-page-wrapper -->
	</body>
</html>