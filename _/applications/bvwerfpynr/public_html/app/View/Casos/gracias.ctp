<?php
	echo $this->Html->script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBZ8VrXgGZ3QSC-0XubNhuB2uKKCwqVaD0&callback=googleMap');
	echo $this->Html->script('/front/vendor/gmaps.min.js');
	echo $this->Html->script('/front/js/map-script.js');
	echo $this->Html->script('/front/js/jquery.validate');
?>

<style type="text/css">
.icon2 {
    color: #139BA7 !important;
}

.buttonThanks {
    width: 133px;
    line-height: 45px;
    border-radius: 30px;
    text-align: center;
    font-size: 15px;
    text-transform: uppercase;
    color: #fff;
    background: #139BA7;
    font-weight: 700;
}

.buttonThanks:hover {
    background: #0f808a !important;
}
</style>


<!-- 
=============================================
	Inner Banner
============================================== 
-->
<div class="theme-inner-banner2">
    <div class="opacity">
        <div class="container">
            <h2 id="txtThanks" style="margin-bottom:150px;">Gracias</h2>
        </div>
    </div>
</div>
<!-- 
=============================================
	Contact Form
============================================== 
-->
<br><br>
<div class="container contact-us-page theme-contact-page-styleOne">
    <div id="wrapper-agradecimiento" class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 wow fadeInLeft">
            <div class="contact-us-form">
                <h4 class="azul">Te agradecemos el haberte unido a esta cadena de amor</h4>
                <p style="font-size:22px;">
                    Con tu aportación podremos ayudar a cubrir las necesidades más urgentes de
                    <b><?php echo $aportacion['Caso']['nombre']; ?></b> y
                    brindarle la oportunidad para salir adelante.
                    Dios te bendiga y recompense al ciento por uno tu valiosa ayuda.
                </p>
            </div>
        </div>
    </div>
    <div id="wrapper-encuesta" class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 wow fadeInLeft">
            <div class="contact-us-form">
                <form class="flaoting-labels" action="" method="post" id="encuestaForm">
					<?php foreach ($preguntas as $pregunta): ?>

						<?php if($pregunta['Pregunta']['tipo_respuesta'] == 0){ ?>

							<div class="form-group m-b-5">
								<div style="display:block;">
									<input id="pregunta<?php echo $pregunta['Pregunta']['id'];?>" type="hidden" value="<?php echo $pregunta['Pregunta']['id'];?>">
									<label for=""><?php echo $pregunta['Pregunta']['pregunta']; ?></label>
								</div>
								<div class="col-lg-12">
								<div id="califica<?php echo $pregunta['Pregunta']['id'];?>" class="star-rating">
										<span id="rating1" class="fa fa-star-o" data-rating="1"></span>
										<span id="rating2" class="fa fa-star-o" data-rating="2"></span>
										<span id="rating3" class="fa fa-star-o" data-rating="3"></span>
										<span id="rating4" class="fa fa-star-o" data-rating="4"></span>
										<span id="rating5" class="fa fa-star-o" data-rating="5"></span>
										<input id="inputCalifica<?php echo $pregunta['Pregunta']['id'];?>" type="hidden" name="whatever1" class="rating-value" value="">
									</div>
								</div>
							</div>
							
						<?php }elseif($pregunta['Pregunta']['tipo_respuesta'] == 1){ ?>

							<div class="form-group">
								<input id="pregunta<?php echo $pregunta['Pregunta']['id'];?>" type="hidden" value="<?php echo $pregunta['Pregunta']['id'];?>">
								<label class="d-block" style="display:block;" for=""><?php echo $pregunta['Pregunta']['pregunta'];?></label>
								<label class="radio-inline">
									<input style="height: 21px;" type="radio" value="1" name="caritasSabia<?php echo $pregunta['Pregunta']['id'];?>">Si
								</label>
								<label class="radio-inline">
									<input style="height: 21px;" type="radio" value="0" name="caritasSabia<?php echo $pregunta['Pregunta']['id'];?>">No
								</label>
							</div>

						<?php }elseif($pregunta['Pregunta']['tipo_respuesta'] == 2){ ?>

							<div class="form-group">
								<input id="pregunta<?php echo $pregunta['Pregunta']['id'];?>" type="hidden" value="<?php echo $pregunta['Pregunta']['id'];?>">
								<label class="d-block" style="display:block;" for=""><?php echo $pregunta['Pregunta']['pregunta']; ?></label>
								<div class="single-input">
									<textarea id="textareaEncuesta" style="height:71px;" placeholder="¿Alguna sugerencia?" name="message"></textarea>
								</div>
							</div>

						<?php }  ?>

					<?php endforeach; ?>
                    <button type= "button" id="btnThanks" class="buttonThanks">Enviar</button>
				</form>
				
            </div>
        </div>
    </div>
    <br><br><br>
</div>

<script type="text/javascript">
$(function() {
	$.confetti.start();
	$("#wrapper-agradecimiento").css('display','block');
	$("#wrapper-encuesta").css('display','none');
    setTimeout(function() {
        $.confetti.stop();
        $('.opacity').css('padding', '0px !important;');

        $("#txtThanks").fadeOut(3000, function() {
			$('.opacity').css('padding-top','94px');
			$('.opacity').css('padding-bottom','0px');

			$("#txtThanks").fadeIn(500).text("Breve encuesta");
			$("#txtThanks").css('margin-bottom','40px');
			$("#txtThanks").css('margin-top','60px');
			$("#wrapper-agradecimiento").fadeOut(1500, function(){
				$("#wrapper-encuesta").fadeIn(500).css('display','block');
			});
        });
    }, 3000);

})

var $star_rating = $('#califica1 .fa');
var $star_rating2 = $('#califica2 .fa');
var $star_rating3 = $('#califica3 .fa');

var SetRatingStar = function() {
	return $star_rating.each(function() {
        if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data(
                'rating'))) {
            return $(this).removeClass('fa-star-o').addClass('fa-star');
        } else {
            return $(this).removeClass('fa-star').addClass('fa-star-o');
        }
    });
};

var SetRatingStar2 = function() {
	return $star_rating2.each(function() {
        if (parseInt($star_rating2.siblings('#inputCalifica2').val()) >= parseInt($(this).data(
                'rating'))) {
					return $(this).removeClass('fa-star-o').addClass('fa-star');
				} else {
            return $(this).removeClass('fa-star').addClass('fa-star-o');
        }
    });
};
var SetRatingStar3 = function() {
	return $star_rating3.each(function() {
        if (parseInt($star_rating3.siblings('#inputCalifica3').val()) >= parseInt($(this).data(
                'rating'))) {
					return $(this).removeClass('fa-star-o').addClass('fa-star');
				} else {
            return $(this).removeClass('fa-star').addClass('fa-star-o');
        }
    });
};

$star_rating.on('click', function() {
    $star_rating.siblings('input.rating-value').val($(this).data('rating'));
    return SetRatingStar();
});
$star_rating2.on('click', function() {
    $star_rating2.siblings('#inputCalifica2').val($(this).data('rating'));
    return SetRatingStar2();
});
$star_rating3.on('click', function() {
    $star_rating3.siblings('#inputCalifica3').val($(this).data('rating'));
    return SetRatingStar3();
});

SetRatingStar();
SetRatingStar2();
SetRatingStar3();

$(document).ready(function() {
	$( "#pregunta1" ).prop( "disabled", true );
	$( "#pregunta2" ).prop( "disabled", true );
	$( "#pregunta3" ).prop( "disabled", true );
	$( "#pregunta4" ).prop( "disabled", true );
	$( "#pregunta5" ).prop( "disabled", true );
	$( "#pregunta6" ).prop( "disabled", true );

	$('#btnThanks').click(function(e){

		var califica1,califica2, califica3  = 0;
		if($('#inputCalifica1').val() == ""){
			califica1 = 0;
		}else {
			califica1 = $('#inputCalifica1').val();
		}
		if($('#inputCalifica2').val() == ""){
			califica2 = 0;
		}else {
			califica2 = $('#inputCalifica2').val();
		}
		if($('#inputCalifica3').val() == ""){
			califica3 = 0;
		}else {
			califica3 = $('#inputCalifica3').val();
		}

		var radioValue1, radioValue2 = 0;
		if(typeof $('input[name=caritasSabia4]:checked').val() === "undefined"){
			radioValue1 = 0;
		}else{
			radioValue1 = $('input[name=caritasSabia4]:checked').val();
		}
		if(typeof $('input[name=caritasSabia5]:checked').val() === "undefined"){
			radioValue2 = 0;
		}else{
			radioValue2 = $('input[name=caritasSabia5]:checked').val();
		}

		if($('#inputCalifica1').val() == "" || $('#inputCalifica2').val() == "" || $('#inputCalifica3').val() == ""){
			alert("Faltan llenar campos");
		} else if(typeof $('input[name=caritasSabia4]:checked').val() === "undefined"){
			alert("Faltan llenar campos");
		} else if (typeof $('input[name=caritasSabia5]:checked').val() === "undefined"){
			alert("Faltan llenar campos");
		} else{
			var json = {
				Encuesta: {
					aportacion_id: <?php echo $aportacion['Aportacion']['id']; ?>,
					created: "<?php echo $aportacion['Aportacion']['created']; ?>",
					created_id: <?php echo $aportacion['Caso']['id']; ?>,
				}
			}

			var json_respuestas = {
				Pregunta_Encuesta:{
					0: {
						pregunta_id: $('#pregunta1').val(),
						respuesta_numero: califica1
					},
					1:{
						pregunta_id: $('#pregunta2').val(),
						respuesta_numero: califica2
					},
					2: {
						pregunta_id: $('#pregunta3').val(),
						respuesta_numero: califica3
					},
					3:{
						pregunta_id: $('#pregunta4').val(),
						respuesta_numero: radioValue1
					},
					4:{
						pregunta_id: $('#pregunta5').val(),
						respuesta_numero: radioValue2
					},
					5:{
						pregunta_id: $('#pregunta6').val(),
						respuesta_text: $('#textareaEncuesta').val()
					}
				}
			}
			
			var data = Object.assign({}, json, json_respuestas);

			var requestUrl  = '<?php echo Router::url( array('admin'=>false, 'plugin'=>false, 'controller' => 'casos', 'action' => 'encuesta') ); ?>';
			//console.log(data);
			$.ajax({
				type:"POST",
				url: requestUrl,
				dataType: "html",
				contentType: "application/x-www-form-urlencoded",
				data: data,
				success: function(data){
					var json = JSON.parse(data);
					if(json["saveSuccess"]){
						window.location.replace("<?php echo $this->Html->url( array('action' => 'index') ); ?>casos");
					}
				},
				error : function() {
					alert("Error al cargar la información.");
				}
			});
		}
	});
});
</script>