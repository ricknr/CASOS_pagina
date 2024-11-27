
<?php
	echo $this->Html->script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBZ8VrXgGZ3QSC-0XubNhuB2uKKCwqVaD0&callback=googleMap');
	echo $this->Html->script('/front/vendor/gmaps.min.js');
	echo $this->Html->script('/front/js/map-script.js');
	echo $this->Html->script('/front/js/jquery.validate');
?>

<style type="text/css">
	.icon2{
		color:#139BA7 !important ;
	}	
</style>


<!-- 
=============================================
	Inner Banner
============================================== 
-->
<div class="theme-inner-banner" style='background: url("/front/images/contacto.jpg")no-repeat center !important;'>
	<div class="opacity">
		<div class="container">
			<h2 style="margin-bottom:150px;">Contáctanos</h2>			
		</div>
	</div> 
</div>

<!-- 
=============================================
	Contact Form
============================================== 
-->
<div class="container contact-us-page theme-contact-page-styleOne">
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12 wow fadeInLeft">
			<div class="contact-us-form">
				<h4 class="azul">Envíanos un mensaje</h4>
				<?php echo $this->Session->flash(); ?>
				<form action="/contacto" id="contactForm" class="form-validation" autocomplete="off" method="post">
					<div class="row">
						<div class="col-xs-12">
							<div class="single-input">
								<input type="text" placeholder="Nombre*" name="nombre" required>
								<input type="hidden" name="other">
							</div> <!-- /.single-input -->
						</div> <!-- /.col- -->
						<div class="col-sm-12 col-xs-12">
							<div class="single-input">
								<input type="email" placeholder="Correo electrónico*" name="email" required>
							</div> <!-- /.single-input -->
						</div> <!-- /.col- -->						
						<div class="col-xs-12">
							<div class="single-input">
								<textarea placeholder="Mensaje" name="mensaje"></textarea>
							</div> <!-- /.single-input -->
						</div> <!-- /.col- -->
					</div> <!-- /.row -->
					<button class="button-one ch-p-bg-color">Enviar</button>
				</form>
				
			</div> <!-- /.contact-us-form -->
		</div> <!-- /.col- -->

		<div class="col-md-6 col-sm-12 col-xs-12 wow fadeInRight">
			<div class="contactUs-address">
				<h4 class="azul">Información de contacto</h4>
        		<div class="single-address clearfix">
        			<div class="icon round-border float-left"><i class="flaticon-placeholder"></i></div>
        			<div class="text float-left">
        				<h6>Dirección</h6>
        				<span>Francisco G. Sada No. 2810 Pte. <br>Col. Deportivo Obispado <br>Monterrey N.L., México, C.P. 64040</span>
        			</div>
        		</div> <!-- End of .single-address -->
        		<div class="single-address clearfix">
        			<div class="icon round-border float-left"><i class="flaticon-envelope"></i></div>
        			<div class="text float-left">
        				<h6>Email</h6>
        				<span>caritas@caritas.org.mx</span>
        			</div>
        		</div> <!-- End of .single-address -->
        		<div class="single-address clearfix">
        			<div class="icon round-border float-left"><i class="flaticon-phone-call"></i></div>
        			<div class="text float-left">
        				<h6>Teléfono</h6>
        				<span>(81) 1340-2000</span>
        			</div>
        		</div> <!-- End of .single-address -->

        		
        		<div class="single-address clearfix">
        			<div class="icon float-left" style="border:none"></div>
        			<div class="text float-left">
        				<h6>Redes sociales</h6>
	        			<div class="icon round-border float-left">
	        				<a href="https://www.facebook.com/caritasdemonterrey" target="_blank" class="icon2">
	        					<i class="fa fa-facebook"></i>
	        				</a>
	        			</div>
	        			<div class="icon round-border float-left" style="margin-left:10px">
	        				<a href="https://twitter.com/caritasmty" target="_blank" class="icon2">
	        					<i class="fa fa-twitter"></i>
	        				</a>
	        			</div>
	        			<div class="icon round-border float-left" style="margin-left:10px">
	        				<a href="https://www.instagram.com/caritasmty/" target="_blank" class="icon2">
	        					<i class="fa fa-instagram"></i>
	        				</a>
	        			</div>
	        			<div class="icon round-border float-left" style="margin-left:10px">
	        				<a href="https://www.youtube.com/user/caritasdemonterrey" target="_blank" class="icon2">
	        					<i class="fa fa-youtube"></i>
	        				</a>
	        			</div>
	        		</div>
        		</div>
			</div> <!-- /.our-address -->
		</div>


	</div>
</div>





<!-- 
=============================================
	Goolge-map
============================================== 
-->
<div>
	<div id="google-map-area">
		<div class="google-map-three" id="contact-google-map" data-map-lat="25.679208" data-map-lng="-100.340543" data-icon-path="front/images/map3.png" data-map-title="Find Map" data-map-zoom="15"></div>
	</div>
</div>


<script type="text/javascript">
$(function(){
	$("#contactForm").validate();
})
</script>