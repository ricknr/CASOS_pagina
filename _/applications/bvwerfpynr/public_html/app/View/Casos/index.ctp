<style type="text/css">
.active {
    color: #1E9CA7 !important;
}

.nav-tabs {
    border-bottom: inherit !important;
}
.btnDonarAhora {
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

.btnDonarAhora:hover {
    background: #0f808a !important;
}

#btnDonarAhora{
    width: 100%;
    line-height: 55px;
    text-align: center;
    font-weight: 700;
    font-size: 15px;
    text-transform: uppercase;
    color: #fff;
    border-top: 1px solid #ededed;
}
#btnDonarAhora:hover{
	background: #0f808a;
}
#btnModalDonar{
    
    text-align: center;
    text-transform: uppercase;
    color: #fff;
	border-top: 1px solid #ededed;
	background-color: #00c292;
    border: 1px solid #00c292;
}
#btnModalDonar:hover{
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
<div class="theme-inner-banner" style="position: relative; margin-bottom:0px;">
    <div class="opacity">
        <div class="container">
            <!-- <h2>CASOS PRIORITARIOS</h2> -->
            <ul>
                <li>CASOS PRIORITARIOS</li>
            </ul>
        </div> <!-- /.container -->
        <div style="text-align: left;position: absolute;bottom: 30px;left: 25px;">
            <p style="color:#fff;font-family: 'Roboto', sans-serif; margin-right:10px; display:inline;">"Es en dar que recibimos" <span style="font-weight:300"> - San Francisco de Asis -</span></p>
        </div>
    </div> <!-- /.opacity -->
</div> <!-- /.theme-inner-banner -->

<div style="margin-bottom:90px; background:#a6a1a1cc;">
    <div class="container">
        <div class="col-md-12 center">
            <h5 class="center" style="display:inline; margin-right:10px;">FORMAS DE DONAR:</h5> 
            <img src="http://www.transparentpng.com/download/credit-card/8p4jX1-blank-credit-card-pic.png" style="width:50px; height:50px; margin:0px 20px 0px 20px; display:inline;">
            <img src="http://assets.stickpng.com/thumbs/580b57fcd9996e24bc43c530.png" style="width:65px; height:54px; margin:0px 20px 0px 20px; display:inline; padding:0px;">
            <img src="https://cdn-images-1.medium.com/max/1200/1*ERNNlUl6zEaJg7Sbjeci2g.png" style="width:45px; height:45px; margin:0px 20px 0px 20px; display:inline;">
            <img src="https://image.flaticon.com/icons/svg/1261/1261642.svg" style="width:40px; height:40px; margin:0px 20px 0px 20px; display:inline;">
        </div>
    </div>
</div>

<!-- 
=============================================
	Recent Cause
============================================== 
-->
<div class="recent-cause">
    <div class="container">
        <div class="col-md-12">
            <input name="data[categoria_id]" id="input_categoria_id" style="display:none">
            <input name="data[filtro]" id="input_filtro" style="display:none">

            <ul class="nav nav-tabs">

                <li>
                    <a href="#">
                        Filtrar por:
                    </a>
                </li>
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false">
                        Categoría<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="link_categoria" data-categoria_id="">Todas</a></li>
                        <?php foreach ($categorias as $k => $cat): ?>
                        <li><a href="#" class="link_categoria"
                                data-categoria_id="<?php echo $k; ?>"><?php echo $cat; ?></a></li>
                        <?php endforeach ?>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        Ordenar por:
                    </a>
                </li>
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false">
                        Fecha de finalización<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="filtro" data-val="fecha_fin ASC">Por terminar</a></li>
                        <li><a href="#" class="filtro" data-val="fecha_fin DESC">Agregados recientemente</a></li>
                    </ul>
                </li>

                <!-- <li role="presentation" class="dropdown">
			    	<a class="dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
			      	Monto recaudado<span class="caret"></span>
			    	</a>
			    	<ul class="dropdown-menu">
			      		<li><a href="#" class="filtro" data-val="total_recaudado DESC">Más recaudado</a></li>
			      		<li><a href="#" class="filtro" data-val="total_recaudado ASC">Menos recaudado</a></li>
			    	</ul>
			  	</li> -->
            </ul>

        </div>
        <div class="row">


            <div class="col-md-12">
                <?php echo $this->Session->flash(); ?>
                <div class="content_casos">
                    <div class="col-md-12">
                        <br>
                        <h4 class="center">Categoría: <?php echo $categoria; ?></h4>
                        <br><br>
                    </div>

                    <?php if (!empty($texto)): ?>
                    <p style="padding:12px">
                        Resultados para <span class="azul">"<?php echo $texto; ?>"</span>
                    </p>
                    <?php endif ?>

                    <?php if (empty($casos)){ ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">No se encontraron casos en esta categoría o critetio de
                                búsqueda.</div>
                        </div>
                    </div>
                    <?php }else{ ?>
                    <div class="row">


                        <?php
								$i = 1;
								foreach ($casos as $k => $caso):
								$porcentaje = 0;
								if ($caso['Caso']['total_recaudado'] > 0) {
									$porcentaje = ($caso['Caso']['total_recaudado'] * 100) / $caso['Caso']['importe_meta'];							
								}
							?>
                        <div class="col-md-4 col-sm-6 col-xs-12 wow fadeInUp">
                            <div class="single-cause">

                                <?php
											if ($caso['Caso']['tipo'] == 'Video') {
												//youtube
												$url = $caso['Caso']['video'];
												parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
												$img = "https://img.youtube.com/vi/".$my_array_of_vars['v']."/sddefault.jpg";
											}else{
												if (file_exists($caso['Caso']['relativepath_imagen'].$caso['Caso']['encname_imagen'])){
													$img = '/'.$caso['Caso']['relativepath_imagen'] . $caso['Caso']['encname_imagen'];
												}else{
													$img = "/img/no-image.jpg";
												}
											}
										?>
                                <div class="img"
                                    style="height: 200px;background:url(<?php echo $img?>);background-size:cover;">
                                    <a href="/casos/detalle/<?php echo $caso['Caso']['id']?>"
                                        style="display: inline-block;width: 100%;height: 100%;color: transparent;">.</a>
                                </div>



                                <div class="title text-center">
                                    <div class="donate-piechart tran3s">
                                        <div class="piechart" data-border-color="rgba(19,155,167,1)"
                                            data-value="<?php echo ($caso['Caso']['porcentaje_recaudado'] == 0)?'.001':($caso['Caso']['porcentaje_recaudado'] / 100); ?>">
                                            <span><?php echo $caso['Caso']['porcentaje_recaudado']?></span>
                                        </div>
                                    </div>

                                    <h5> <a href="/casos/detalle/<?php echo $caso['Caso']['id']?>"
                                            class="tran3s"><?php echo $caso['Caso']['titulo']?></a></h5>
                                    <p><?php echo $caso['Caso']['descripcion_corta'] ?></p>
                                    <span><strong>Donación:<br></strong>
                                        $<?php echo number_format($caso['Caso']['total_recaudado'],2)?> / <span
                                            class="ch-p-color">$<?php echo number_format($caso['Caso']['importe_meta'],2)?></span></span>
                                    <div class="clearfix">
                                        <a id="modalTest" data-id="<?php echo $caso['Caso']['id']?>"
                                            class="tran3s float-left ch-p-bg-color donate donacionTest">
                                            quiero donar
                                        </a>
                                        <a href="/casos/detalle/<?php echo $caso['Caso']['id']?>"
                                            class="tran3s float-left more">detalles</a>
                                    </div>
                                </div> <!-- /.title -->
                            </div> <!-- /.single-cause -->
                        </div> <!-- /.col- -->
                        <?php 
								if ($i % 3 == 0) {
									echo '<div class="clearfix"></div>';
								}
								$i++;
								endforeach 
							?>

                    </div>
                    <?php } ?>


                    <ul class="text-center charity-pagination">
                        <?php
						echo $this->Paginator->prev('«', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag'=>'a'));
						echo $this->Paginator->numbers(array('currentClass' => 'active', 'currentTag' => 'a', 'tag' => 'li', 'separator' => null));
						echo $this->Paginator->next('»', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag'=>'a'));
						?>
                    </ul>
                </div>

            </div>
        </div>

        <!-- /.row -->

    </div> <!-- /.container -->
</div> <!-- /.recent-cause -->


<div class="modal" data-target="#flexModal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content" style="width:100%;">
            <div class="modal-header">
                <button id="btnclose" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Elige tu forma de donación</h4>
            </div>
            <div class="modal-body">
				<div style="width: 100%; display: inline-block;">
				<div>
                    <div class="radioDonate" >
                        <label class="radio-inline">
                            <input type="radio" name="radioDonar" value="1">Transferencia Electrónica
                        </label>
                    </div>
                    <div class="radioDonate" >
                        <label class="radio-inline">
                            <input type="radio" name="radioDonar" value="0">MoneyPool
                        </label>
                    </div>
                    <div class="radioDonate" >
                        <label class="radio-inline">
                            <input type="radio" name="radioDonar" value="3">Paypal
                        </label>
                    </div>
                    <div class="radioDonate" >
                        <label class="radio-inline">
                            <input type="radio" name="radioDonar" value="2" checked>Tarjeta
                        </label>
                    </div>
                </div>
                <div style="padding-top:80px;">
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
</div>


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



<script type="text/javascript">
$(function() {
	var test = 0;

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
        } else if (this.value == 3){
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

    $(document).on('click', '#modalTest', function() {
        $('.modal').css('display', 'block');
        $('#modalTest').modal('show');
    });

    $(document).on('click', '.modal-footer button', function() {
        $('.modal').css('display', 'none');
        $('#modalTest').modal('hide');
        $('#modalTest').css('display', 'block');
    });

    $(document).on('click', '#btnclose', function() {
        $('.modal').css('display', 'none');
        $('#modalTest').modal('hide');
        $('#modalTest').css('display', 'block');
    });

    $(document).on('click', '.donacionTest', function() {
        test = $(this).data('id');
    });
    $(document).on('click', '.donaAhora', function() {
		console.log(test);
        window.location.replace("/nueva_donacion/" + test);
    });
    $(document).on('click', '.donaAhoraPaypal', function() {
		console.log(test);
        window.location.replace("/nueva_donacion_p/" + test);
    });

    $(document).on('click', '.link_categoria', function(event) {
        event.preventDefault();
        var id = $(this).data('categoria_id');
        $('#input_categoria_id').val(id);

        $('.link_categoria').removeClass('active');
        $(this).addClass('active');
        getData("/casos");
    });


    $(document).on('click', '.filtro', function(event) {
        event.preventDefault();
        $('#input_filtro').val($(this).data('val'));
        getData("/casos");
    });

    $(document).on('click', '.charity-pagination a', function(event) {
        event.preventDefault();
        url = $(this).attr('href');
        getData(url);
        return false;
    });
});

function getData(url) {
    var categoria_id = $('#input_categoria_id').val();
    var texto = $('#input_texto').val();
    var filtro = $('#input_filtro').val();
    $.ajax({
        cache: false,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url: url,
        data: {
            texto: texto,
            categoria_id: categoria_id,
            filtro: filtro,
        },
        success: function(data) {
            $('.content_casos').html(data);
            $('html, body').animate({
                scrollTop: 330
            }, 'slow');
            roundCircleProgress();

        },
        error: function(data) {
            //alert('error');
        }
    });
}
</script>