<?php $this->start('meta'); ?>
<meta property="og:title" content="<?php echo $caso['Caso']['titulo']?>" />
<meta property="og:description" content="<?php echo $caso['Caso']['descripcion_corta']?>" />
<meta property="og:image"
    content="http://www.<?php echo $_SERVER['SERVER_NAME'] . '/' .$caso['Caso']['relativepath_imagen'] . $caso['Caso']['encname_imagen']?>" />
<meta property="og:url"
    content="http://www.<?php echo $_SERVER['SERVER_NAME'] . '/casos/detalle/' .$caso['Caso']['id']?>" />

<!-- <meta property="og:image:width" content="560">
	<meta property="og:image:height" content="300"> -->

<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="<?php echo $caso['Caso']['titulo']?>" />
<meta name="twitter:description" content="<?php echo $caso['Caso']['descripcion_corta']?>" />
<meta name="twitter:image"
    content="http://www.<?php echo $_SERVER['SERVER_NAME'] . '/' .$caso['Caso']['relativepath_imagen'] . $caso['Caso']['encname_imagen'] ?>" />
<?php $this->end(); ?>

<?php
	echo $this->Html->script('/front/js/jquery.validate');
?>

<style>
.btndonaslider {
	width: 100%;
    line-height: 55px;
    text-align: center;
    font-weight: 700;
    font-size: 15px;
    text-transform: uppercase;
    color: #fff;
    border-top: 1px solid #ededed;
}

.btndonaslider:hover {
    background: #0f808a;
	color: #fff;
}
.btndonasliderpaypal {
	width: 100%;
    line-height: 55px;
    text-align: center;
    font-weight: 700;
    font-size: 15px;
    text-transform: uppercase;
    color: #fff;
    border-top: 1px solid #ededed;
}

.btndonasliderpaypal:hover {
    background: #0f808a;
	color: #fff;
}
.donaAhora {
    width: 100%;
    line-height: 55px;
    text-align: center;
    font-weight: 700;
    font-size: 15px;
    text-transform: uppercase;
    color: #fff;
    border-top: 1px solid #ededed;
}

.donaAhora:hover {
    background: #0f808a;
	color: #fff;
}

.donaAhoraPaypal {
    width: 100%;
    line-height: 55px;
    text-align: center;
    font-weight: 700;
    font-size: 15px;
    text-transform: uppercase;
    color: #fff;
    border-top: 1px solid #ededed;
}

.donaAhoraPaypal:hover {
    background: #0f808a;
	color: #fff;
}

#btnModalDonar {
    text-align: center;
    text-transform: uppercase;
    color: #fff;
    border-top: 1px solid #ededed;
    background-color: #00c292;
    border: 1px solid #00c292;
}
#btnModalDonar:hover {
    background: #00c292;
    opacity: .8;
    border: 1px solid #00c292;
}

.radioDonate{
    width:25%; 
    float:right;
}

@media (max-width: 600px) {
    .radioDonate{
        width:50%; 
        float:right;
    }
}
</style>


<!-- 
=============================================
	Inner Banner
============================================== 
-->
<div class="theme-inner-banner">
    <div class="opacity">
        <div class="container">
            <!-- <h2>Detalle de la causa</h2> -->
            <ul>
                <li><a href="/casos" class="tran3s">CASOS</a></li>
                <li>/</li>
                <li>DETALLE DEL CASO
                    <!-- <?php echo $caso['Categoria']['nombre']?> -->
                </li>
            </ul>
        </div> <!-- /.container -->
    </div> <!-- /.opacity -->
</div> <!-- /.theme-inner-banner -->



<!-- 
=============================================
	Recent Cause Details
============================================== 
-->
<div class="recent-cause-details" id="x">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="text-center azul"><?php echo $caso['Caso']['titulo']?></h2>
                <?php echo $this->Session->flash(); ?>
            </div>
            <div class="col-sm-8">
                <br>
                <div>
                    <?php if ($caso['Caso']['tipo'] == 'Video'){ 
						$url = $caso['Caso']['video'];
						parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
						$video_id = $my_array_of_vars['v'];
					?>
                    <iframe src="http://www.youtube.com/embed/<?php echo $video_id ?>" style="width:100%;height:450px;"
                        allowfullscreen></iframe>
                    <?php }else{
							if (file_exists($caso['Caso']['relativepath_imagen'].$caso['Caso']['encname_imagen'])){
								$img = '/'.$caso['Caso']['relativepath_imagen'] . $caso['Caso']['encname_imagen'];
							}else{
								$img = "/img/no-image.jpg";
							}
					?>

                    <img src="<?php echo $img; ?>" alt="Image">
                    <?php } ?>
                </div>

                <div class="text-wrapper clearfix">
                    <h3 class="azul"><?php echo $caso['Caso']['nombre']?></h3>
                    <br>
                    <div class="clearfix">
                        <table>
                            <tr>
                                <td>
                                    <h6 class="h6_detail">Edad: </h6>
                                </td>
                                <td><span><?php echo $caso['Caso']['edad']?></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <h6 class="h6_detail">Diagnóstico: </h6>
                                </td>
                                <td><span><?php echo $caso['Caso']['diagnostico']?></span></td>
                            </tr>
                            <tr>
                                <td style="width:190px">
                                    <h6 class="h6_detail">Folio: </h6>
                                </td>
                                <td><span><?php echo $caso['Caso']['folio']?></span></td>
                            </tr>
                        </table>
                        <br>

                        <p>
                            <?php if($caso['Caso']['total_recaudado'] >= $caso['Caso']['importe_meta']){
								echo $caso['Caso']['descripcion_resolucion'];
							} else{
								echo $caso['Caso']['descripcion'];
							} ?>

                        </p>
                    </div> <!-- /.clearfix -->
                </div> <!-- /.text-warpper -->
            </div>




            <div class="col-sm-4">
                <?php
					$porcentaje = 0;
					if ($caso['Caso']['total_recaudado'] > 0) {
						$porcentaje = ($caso['Caso']['total_recaudado'] * 100) / $caso['Caso']['importe_meta'];
					}
				?>
                <div class="clearfix">
                    <div class="skills-progress skills float-left" style="margin-top:40px;">
                        <h5>Total recaudado</h5>
                        <br>
                        <h3>$<?php echo number_format($caso['Caso']['total_recaudado'],2)?> <span
                                class="span_detail">MXN</span></h3>
                        <div class="codeconSkillbar">
                            <div class="skillBar ch-p-bg-color"
                                data-percent="<?php echo intval($caso['Caso']['porcentaje_recaudado'])?>%"></div>
                        </div> <!-- /.codeconSkills -->
                    </div> <!-- /.skills-progress -->

                </div> <!-- /.clearfix -->
                <span>
                    <strong>Meta:</strong> $<?php echo number_format($caso['Caso']['importe_meta'],2)?></span>
                </span>

                <h5 class="h5_detail">Donadores</h5>
                <h3><?php echo sizeof($caso['Aportacion']); ?></h3>

                <?php if($caso['Caso']['total_recaudado'] < $caso['Caso']['importe_meta']){?>
                <h5 class="h5_detail">Días restantes</h5>
                <?php
						$date1 = new DateTime(date('Y-m-d'));
						$date2 = new DateTime($caso['Caso']['fecha_fin']);
						$diff = $date1->diff($date2);
					?>
                <h3><?php echo $diff->days ?><span class="span_detail">días</span></h3>

                <br>
                <!--a href="/nueva_donacion/<?php echo $caso['Caso']['id']?>" class="button-two float-left">Quiero donar</a-->
                <a id="modalTest" data-id="<?php echo $caso['Caso']['id']?>" class="button-two float-left donacionTest">Quiero donar</a>
                <?php } 
				else{?>
                <h5 class="h5_detail">Finalizó</h5>
                <?php
						$date1 = new DateTime(date('Y-m-d'));
						$date2 = new DateTime($caso['Caso']['fecha_fin']);
						$diff = $date1->diff($date2);
					?>
                <h3><?php echo date('d/m/Y',strtotime($caso['Caso']['fecha_fin'])); ?><span class="span_detail"></span>
                </h3>

                <br>
                <a href="#" id="btnExitoso" class="button-two float-left">¡EXITOSO!</a>
                <?php } ?>
                <br><br>
                <div>
                    <img src="http://www.transparentpng.com/download/credit-card/8p4jX1-blank-credit-card-pic.png" style="width:60px; height:60px; margin:0px; display:inline;">
                    <img src="http://assets.stickpng.com/thumbs/580b57fcd9996e24bc43c530.png" style="width:75px; height:65px; margin:0px; display:inline; padding:0px;">
                    <img src="https://cdn-images-1.medium.com/max/1200/1*ERNNlUl6zEaJg7Sbjeci2g.png" style="width:55px; height:55px; margin:0px; display:inline;">
                    <img src="https://image.flaticon.com/icons/svg/1261/1261642.svg" style="width:50px; height:50px; margin:0px; display:inline;">
                </div>
                <p>
                    COMPARTE:
                </p>
                <p>
                    <div class="addthis_inline_share_toolbox_p9qm"
                        data-title="Apoya a <?php echo $caso['Caso']['nombre']?>"
                        style="display:inline-block;float:left"></div>
                    <a href="#" data-toggle="modal" data-target="#modalCausa"
                        style="width: 65px;background: #848484;color: #fff;font-size: 10px;padding: 0px 9px;float:left;">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        Email
                    </a>

                    <a href="whatsapp://send?text=http://<?php echo $_SERVER['HTTP_HOST'] ?>/casos/detalle/<?php echo $caso['Caso']['id']?>"
                        style="width: 75px;background: #24BFA6;color: #fff;font-size: 10px;padding: 0px 9px;float:left;margin-left: 4px;">
                        <i class="fa fa-whatsapp" aria-hidden="true"></i>
                        Whatsapp
                    </a>
                </p>
            </div>
        </div>
    </div> <!-- /.container -->
</div> <!-- /.recent-cause-details -->



<!-- 
=============================================
	Similer Cause Slider
============================================== 
-->
<div class="similer-cause recent-cause">
    <div class="container">
        <div class="charity-title">
            <h2 class="azul">Casos Similares</h2>
        </div> <!-- /.charity-title -->

        <div class="row">
            <div class="similer-casue-slider">

                <?php foreach ($relacionados as $k => $relacionado): ?>
                <div class="item">
                    <div class="single-cause">
                        <div class="img">
                            <a href="/casos/detalle/<?php echo $relacionado['Caso']['id']?>">
                                <?php
										if ($relacionado['Caso']['tipo'] == 'Video') {
											//youtube
											$url = $relacionado['Caso']['video'];
											parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
											$img = "https://img.youtube.com/vi/".$my_array_of_vars['v']."/sddefault.jpg";
										}else{
											if (file_exists($relacionado['Caso']['relativepath_imagen'].$relacionado['Caso']['encname_imagen'])){
												$img = '/'.$relacionado['Caso']['relativepath_imagen'] . $relacionado['Caso']['encname_imagen'];
											}else{
												$img = "/img/no-image.jpg";
											}
										}
									?>

                                <img src="<?php echo $img; ?>" alt="Image" class="img-responsive"
                                    style="height: 200px;">
                            </a>
                        </div>
                        <div class="title text-center" style="margin-top:-10px">
                            <div class="donate-piechart tran3s">
                                <div class="piechart" data-border-color="rgba(19,155,167,1)"
                                    data-value="<?php echo ($relacionado['Caso']['porcentaje_recaudado'] == 0)?'.001':($relacionado['Caso']['porcentaje_recaudado'] / 100); ?>">
                                    <span>.<?php echo intval($relacionado['Caso']['porcentaje_recaudado'])?></span>
                                </div>
                            </div>

                            <h5><?php echo $relacionado['Caso']['titulo']?></h5>
                            <br><br>
                            <div class="clearfix">
								<?php //NOTA: HERE ?>
                                <!--a href="/nueva_donacion/<?php echo $relacionado['Caso']['id']?>" class="tran3s float-left ch-p-bg-color donate">Quiero donar</a-->
                                <a id="btndonaslider" data-dr="<?php echo $relacionado['Caso']['id']?>" class="tran3s float-left ch-p-bg-color donate">Quiero donar</a>
                                <a href="/casos/detalle/<?php echo $relacionado['Caso']['id']?>"
                                    class="tran3s float-left more">Detalles</a>
                            </div>
                        </div> <!-- /.title -->
                    </div> <!-- /.single-cause -->
                </div> <!-- /.col- -->
                <?php endforeach ?>

            </div>


        </div>
    </div> <!-- /.container -->
</div> <!-- /.similer-cause -->

<!-- 
=============================================
	Volunteer banner
============================================== 
-->
<div class="volunteer-banner">
    <div class="opacity">
        <div class="container">
            <h2>Conviértete en un voluntario</h2>
            <p>¿QUIERES SER VOLUNTARIO O REALIZAR TU SERVICIO SOCIAL? <br> Contáctanos al teléfono (81) 1340 2090 o
                déjanos un mensaje </p>
            <a href="/contacto" class="button-four ch-p-bg-color">únete</a>
        </div>
    </div> <!-- /.opacity -->
</div> <!-- /.volunteer-banner -->

<div class="modal fade" tabindex="-1" role="dialog" id="modalCausa">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button id="btnclose" type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Comparte esto con un amigo.</h4>
            </div>
            <form action="/casos/mail_caso/<?php echo $caso['Caso']['id']?>" method="post" id="contactForm">
                <div class="modal-body">

                    <p>
                        Comparte esto con un amigo.
                    </p>

                    <label>Correo electrónico</label>
                    <input class="form-control" required type="email" name="email">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal static" data-target="#flexModal" tabindex="-2" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content" style="width:100%">
            <div class="modal-header">
                <button id="btnclose" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Elige tu forma de donación</h4>
            </div>
            <div class="modal-body">
                <div style="width: 100%; max-width: 617px; display: inline-block;">
                    <div class="radioDonate">
                        <label class="radio-inline">
                            <input type="radio" name="radioDonar" value="1">Transferencia Electrónica
                        </label>
                    </div>
                    <div class="radioDonate">
                        <label class="radio-inline">
                            <input type="radio" name="radioDonar" value="0">MoneyPool
                        </label>
                    </div>
                    <div class="radioDonate">
                        <label class="radio-inline">
                            <input type="radio" name="radioDonar" value="3">Paypal
                        </label>
                    </div>
                    <div class="radioDonate">
                        <label class="radio-inline">
                            <input type="radio" name="radioDonar" value="2" checked>Tarjeta
                        </label>
                    </div>
                </div>
                <div>
                    <div class="donation-method">
                        <div class="clearfix">
                            <a id="btnDonarAhora" class="tran3s float-left ch-p-bg-color donate donaAhora">
                                Dona ahora con tarjeta
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnModalDonar" type="button" class="btn btn-success" data-dismiss="modal"><strong>Entiendo</strong></button>
            </div>
        </div>
    </div>
</div>

<div class="modal slider" data-target="#flexModal" tabindex="-3" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content" style="width:100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Elige tu forma de donación</h4>
            </div>
            <div class="modal-body">
                <div style="width: 100%; display: inline-block;">
                    <div class="radioDonate">
                        <label class="radio-inline">
                            <input type="radio" name="radioDonarSlider" value="1">Transferencia Electrónica
                        </label>
                    </div>
                    <div class="radioDonate">
                        <label class="radio-inline">
                            <input type="radio" name="radioDonarSlider" value="0">MoneyPool
                        </label>
                    </div>
                    <div class="radioDonate">
                        <label class="radio-inline">
                            <input type="radio" name="radioDonarSlider" value="3">Paypal
                        </label>
                    </div>
                    <div class="radioDonate">
                        <label class="radio-inline">
                            <input type="radio" name="radioDonarSlider" value="2" checked>Tarjeta
                        </label>
                    </div>
                </div>
                <div>
                    <div class="donation-method">
                        <div class="clearfix">
                            <a id="btnDonarAhoraSlider" class="tran3s float-left ch-p-bg-color btndonaslider">
                                Dona ahora con tarjeta
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnModalDonar" type="button" class="btn btn-success"
                    data-dismiss="modal"><strong>Entiendo</strong></button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a3c0f1b0379c3b9"></script>

<script type="text/javascript">
$(function() {

	var getCasoId = 0
	var getCasoIdSlider = 0

	$('input:radio[name=radioDonar]').change(function() {
        if (this.value == 0) {
            $('.donation-method').empty();
            $('.donation-method').append(`
						<p style="font-weight: bold;">Fácil y rápido</p>
						<p>Usted puede hacer su donativo por MoneyPool, favor de solicitar una liga al teléfono <strong>8182871320</strong> o al correo <strong>moneypool@caritas.org.mx</strong>.</p>
						<br>
						<p>Los donativos realizados por este medio, no se puede extender recibo deducible.</p>
			`);
        } else if (this.value == 1) {
            $('.donation-method').empty();
            $('.donation-method').append(`
						<p style="font-weight: bold;">Banco Banregio</p>
						<p>Cuenta: <strong>003090170014</strong>.</p>
						<p>Clabe:<strong>058580030901700145</strong>.</p>
						<p>Envíe su comprobante o notificación al correo <strong>portal@caritas.org.mx</strong> o al WhatsApp <strong>8182871320</strong>.</p>
						<p>Agregar número de caso apoyado y datos fiscales.</p>
			`);
        } else if (this.value == 2) {
            $('.donation-method').empty();
            $('.donation-method').append(`
				<div class="clearfix">
                    <a id="btnDonarAhora" class="tran3s float-left ch-p-bg-color donate donaAhora">
                        Dona ahora con tarjeta
					</a>
				</div>
			`);
        } else if(this.value == 3){
            $('.donation-method').empty();
            $('.donation-method').append(`
				<div class="clearfix">
                    <a id="btnDonarAhora" class="tran3s float-left ch-p-bg-color donate donaAhoraPaypal">
                        Dona ahora con paypal
					</a>
				</div>
			`);
        }
    });

	$('input:radio[name=radioDonarSlider]').change(function() {
        if (this.value == 0) {
            $('.donation-method').empty();
            $('.donation-method').append(`
						<p style="font-weight: bold;">Fácil y rápido</p>
						<p>Usted puede hacer su donativo por MoneyPool, favor de solicitar una liga al teléfono <strong>8182871320</strong> o al correo <strong>moneypool@caritas.org.mx</strong>.</p>
						<br>
						<p>Los donativos realizados por este medio, no se puede extender recibo deducible.</p>
			`);
        } else if (this.value == 1) {
            $('.donation-method').empty();
            $('.donation-method').append(`
						<p style="font-weight: bold;">Banco Banregio</p>
						<p>Cuenta: <strong>003090170014</strong>.</p>
						<p>Clabe:<strong>058580030901700145</strong>.</p>
						<p>Envíe su comprobante o notificación al correo <strong>portal@caritas.org.mx</strong> o al WhatsApp <strong>8182871320</strong>.</p>
						<p>Agregar número de caso apoyado y datos fiscales.</p>
			`);
        } else if (this.value == 2) {
            $('.donation-method').empty();
            $('.donation-method').append(`
				<div class="clearfix">
                    <a id="btnDonarAhoraSlider" class="tran3s float-left ch-p-bg-color btndonaslider">
                        Dona con tarjeta
					</a>
				</div>
			`);
        } else if (this.value == 3) {
            $('.donation-method').empty();
            $('.donation-method').append(`
				<div class="clearfix">
                    <a id="btnDonarAhoraSlider" class="tran3s float-left ch-p-bg-color btndonasliderpaypal">
                        Dona con paypal
					</a>
				</div>
			`);
        }
    });


    $(document).on('click', '#btnclose', function() {
        $('.modal').css('display', 'none');
        $('#modalTest').modal('hide');
        $('#modalTest').css('display', 'block');
    });

	// MODAL BTN
    $(document).on('click', '#modalTest', function() {
        $('.modal.static').css('display', 'block');
        $('#modalTest').modal('show');
    });

    $(document).on('click', '.modal-footer button', function() {
        $('.modal').css('display', 'none');
        $('#modalTest').modal('hide');
        $('#modalTest').css('display', 'block');
    });

	$(document).on('click', '.donacionTest', function() {
        getCasoId = $(this).data('id');
    });

	$(document).on('click', '.donaAhora', function() {
        window.location.replace("/nueva_donacion/" + getCasoId);
    });
    
	$(document).on('click', '.donaAhoraPaypal', function() {
        window.location.replace("/nueva_donacion_p/" + getCasoId);
    });


	// MODAL SLIDER
	$(document).on('click', '#btndonaslider', function(){
		$('.modal.slider').css('display', 'block');
    	$('#modalTest').modal('show');
	});

	$(document).on('click', '.modal-footer button', function() {
        $('.modal').css('display', 'none');
        $('#modalTest').modal('hide');
        $('#modalTest').css('display', 'block');
    });

	$(document).on('click', '.donate', function() {
        getCasoIdSlider = $(this).data('dr');
		console.log("llego a .donate: "+getCasoIdSlider);
    });
	$(document).on('click', '.btndonaslider', function() {
		console.log('llego a .btnDonarAhoraSlider: ' + getCasoIdSlider);
        window.location.replace("/nueva_donacion/" + getCasoIdSlider);
    });
	$(document).on('click', '.btndonasliderpaypal', function() {
		console.log('llego a .btnDonarAhoraSlider: ' + getCasoIdSlider);
        window.location.replace("/nueva_donacion_p/" + getCasoIdSlider);
    });

    $([document.documentElement, document.body]).animate({
        scrollTop: ($("#x").offset().top - 200)
    }, 2000);

    $("#contactForm").validate();

    $('#btnExitoso').click(function() {
        return false;
    })
})
</script>