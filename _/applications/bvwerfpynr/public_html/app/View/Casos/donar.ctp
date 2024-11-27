<style type="text/css">
iframe {
    border: 0;
}

strong {
    margin-top: 15px !important;
    display: block;
    color: #1E9CA7;
    font-size: 22px;
}

p {
    font-size: 20px;
}

input {
    width: 100%;
    height: 60px;
    border: 1px solid #ebebeb;
    border-radius: 5px;
    padding: 0 20px;
}

select {
    width: 100%;
    height: 60px;
    border: 1px solid #ebebeb;
    border-radius: 5px;
    padding: 0 20px;
}

#btn_donar {
    width: 133px;
    line-height: 45px;
    border-radius: 30px;
    text-align: center;
    font-size: 15px;
    text-transform: uppercase;
    color: #fff;
    font-weight: 700;
}

.visa{background-image:url(https://library.kissclipart.com/20180831/oe/kissclipart-generic-credit-card-icon-clipart-credit-card-bank-f8f22ac554234f69.jpg);}
.mastercard{background-image:url(https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_74x46.jpg);}

.cc-selector-2 input:active +.drinkcard-cc, .cc-selector input:active +.drinkcard-cc{opacity: .9;}
.cc-selector-2 input:checked +.drinkcard-cc, .cc-selector input:checked +.drinkcard-cc{
    -webkit-filter: none;
       -moz-filter: none;
            filter: none;
}
.drinkcard-cc{
    cursor:pointer;
    background-size:contain;
    background-repeat:no-repeat;
    display:inline-block;
    width:100px;height:70px;
    -webkit-transition: all 100ms ease-in;
       -moz-transition: all 100ms ease-in;
            transition: all 100ms ease-in;
    -webkit-filter: brightness(1.8) grayscale(1) opacity(.7);
       -moz-filter: brightness(1.8) grayscale(1) opacity(.7);
            filter: brightness(1.8) grayscale(1) opacity(.7);
}
.drinkcard-cc:hover{
    -webkit-filter: brightness(1.2) grayscale(.5) opacity(.9);
       -moz-filter: brightness(1.2) grayscale(.5) opacity(.9);
            filter: brightness(1.2) grayscale(.5) opacity(.9);
}

/* Extras */
a:visited{color:#888}
a{color:#444;text-decoration:none;}
p{margin-bottom:.3em;}
* { font-family:monospace; }
.cc-selector-2 input{ margin: 5px 0 0 12px; }
.cc-selector-2 label{ margin-left: 7px; }
span.cc{ color:#6d84b4 }

#btn_paypal {
    margin-top:40px;
    width: 200px ;
    line-height: 45px ;
    border-radius: 30px ;
    text-align: center ;
    font-size: 15px ;
    text-transform: uppercase ;
    color: #fff;
    background: #139BA7;
    font-weight: 700;
}

#btn_paypal:hover {
    background: #0f808a !important;
}
</style>

<?php
    echo " <!-- toast-master -->   ";
    echo $this->Html->css('/toast-master/css/jquery.toast.css');

    echo "<!-- jQuery -->";
    echo $this->Html->script('plugins/bower_components/jquery/dist/jquery.min.js');   
    echo $this->Html->script('plugins/bower_components/toast-master/js/jquery.toast.js');
?>
<!-- 
=============================================
	Inner Banner
============================================== 
-->
<div class="theme-inner-banner2">
    <div class="opacity">
        <div class="container">
            <h2>Donar</h2>
            <ul>
                <li><span><?php echo $aportacion['Caso']['titulo']?></span></li>
            </ul>
        </div> <!-- /.container -->
    </div> <!-- /.opacity -->
</div> <!-- /.theme-inner-banner -->
<!-- 
=============================================
    Recent Cause Details
============================================== 
-->

<div class="recent-cause-details">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 style="margin-top:90px;color:#4d4d4d">PASO 2 DE 2</h4>
                <h3 style="margin-top:30px;color:#4d4d4d">Detalle</h3>
            </div>

            <div class="col-md-12">
                <?php echo $this->Session->flash();?>
            </div>


            <div class="col-sm-6">
                <strong>Importe</strong>
                <p>$<?php echo number_format($aportacion['Aportacion']['importe'],2)?></p>
            </div>
            <div class="col-sm-6">
                <strong>Nombre</strong>
                <p><?php echo $aportacion['Aportacion']['nombre_donador']?></p>
            </div>
            <div class="col-sm-6">
                <strong>Correo electrónico</strong>
                <p><?php echo $aportacion['Aportacion']['mail_donador']?></p>
            </div>
            <div class="col-sm-6">
                <strong>Teléfono</strong>
                <p><?php echo $aportacion['Aportacion']['telefono_donador']?></p>
            </div>

            <?php if ($aportacion['Aportacion']['requiere_factura']): ?>
            <div class="col-sm-12">
                <br>
                <h6 style="color:#4d4d4d">Dirección</h6>
            </div>

            <div class="col-sm-6">
                <strong>Calle y número</strong>
                <p><?php echo $aportacion['Aportacion']['calle_y_numero']?></p>
            </div>
            <div class="col-sm-6">
                <strong>Colonia</strong>
                <p><?php echo $aportacion['Aportacion']['colonia']?></p>
            </div>
            <div class="col-sm-6">
                <strong>Ciudad</strong>
                <p><?php echo $aportacion['Aportacion']['ciudad']?></p>
            </div>
            <div class="col-sm-6">
                <strong>Estado</strong>
                <p><?php echo $aportacion['Aportacion']['estado']?></p>
            </div>
            <div class="col-sm-6">
                <strong>País</strong>
                <p><?php echo $aportacion['Aportacion']['pais']?></p>
            </div>
            <div class="col-sm-6">
                <strong>Código postal</strong>
                <p><?php echo $aportacion['Aportacion']['cp']?></p>
            </div>

            <div class="col-sm-6">
                <strong>Tipo de tarjeta</strong>
                <?php if ($aportacion['Aportacion']['tipo_tarjeta'] == 'credito'){ ?>
                <p>Crédito</p>
                <?php }else{ ?>
                <p>Débito</p>
                <?php } ?>

            </div>
            <?php endif ?>

        </div>

        <div style="display:block;" class="row credit">
            <div class="col-md-12">
                <br>
                <h4>Datos de la tarjeta</h4>
            </div>
            <form method="post" action="https://colecto.banregio.com/tds/vistas/recepcion3ds.zul" id="form_donar">
                <input type="hidden" name="BNRG_ID_MEDIO" value="Fyt7qx0I">
                <input type="hidden" name="BNRG_FECHA_EXP" id="fecha_vencimiento" value="">
                <input type="hidden" name="BNRG_URL_RESPUESTA"
                    value="https://<?php echo $_SERVER['HTTP_HOST']?>/respuesta">
                <input type="hidden" name="BNRG_MODO_TRANS" value="PRD">

                <input type="hidden" name="BNRG_REF_CLIENTE1"
                    value="Caso: <?php echo $aportacion['Caso']['referencia_bancaria']?>">
                <input type="hidden" name="BNRG_MONTO_TRANS" value="<?php echo $aportacion['Aportacion']['importe']?>">
                <input type="hidden" name="BNRG_MONTO" value="<?php echo $aportacion['Aportacion']['importe']?>">

                <div class="col-sm-4">
                    <strong>Número de tarjeta</strong>
                    <p><input class="form-contro" name="BNRG_NUMERO_TARJETA" required maxlength="16"></p>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-6">
                    <strong>Fecha de expiración</strong>
                    <div class="row">
                        <?php 
                            $meses = array();
                            $meses['01'] = 'Enero';
                            $meses['02'] = 'Febrero';
                            $meses['03'] = 'Marzo';
                            $meses['04'] = 'Abril';
                            $meses['05'] = 'Mayo';
                            $meses['06'] = 'Junio';
                            $meses['07'] = 'Julio';
                            $meses['08'] = 'Agosto';
                            $meses['09'] = 'Septiembre';
                            $meses['10'] = 'Octubre';
                            $meses['11'] = 'Noviembre';
                            $meses['12'] = 'Diciembre';
                        ?>
                        <div class="col-md-6">
                            <p>
                                <?php echo $this->Form->input('mes', array('div'=>false,'label'=>false,'options'=>$meses,'class'=>false) );?>
                            </p>
                        </div>

                        <?php 
                            $anio_actual = date('Y');
                            $anio_actual = substr($anio_actual, 2);
                            $anios = array();
                            for ($i=$anio_actual; $i < ($anio_actual + 11); $i++) { 
                                $anios [$i] ='20'.$i;
                            }
                        ?>
                        <div class="col-md-6">
                            <p>
                                <?php echo $this->Form->input('anio', array('div'=>false,'label'=>false,'options'=>$anios,'class'=>false) );?>
                            </p>
                            <!-- <p ><input id="anio" class="form-contro" maxlength="2" required></p> -->
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="col-md-4">
                    <strong>Codigo de Seguridad</strong>
                    <p><input name="BNRG_CODIGO_SEGURIDAD" maxlength="4" class="form-contro" type="password" required>
                    </p>
                </div>

                <div class="col-md-4">
                    <p style="margin-top:15px"><b>Tarjetas aceptadas</b></p>
                    <img src="/img/MasterCard_logo.png" style="display: inline-block;width:80px">
                    <img src="/img/Visa_Logo.png" style="display: inline-block;width:80px">
                </div>

                <div class="clearfix"></div>
                <div class="col-md-12">
                    <br>
                    <p>
                        Proporcione su información de pago. <br> <span style="color:red">Esta información se encuentra
                            protegida por los mecanismos de seguridad de nuestro proveedor de pagos electrónicos y bajo
                            ningún motivo es almacenada por Cáritas. </span>
                    </p>


                </div>

                <div class="clearfix"></div>
                <div class="col-md-3">
                    <br>
                    <button id="btn_donar" type="submit" class="tran3s ch-p-bg-color">Donar</button>

                </div>

            </form>
        </div>
        <br><br><br><br><br><br>
    </div>
</div> <!-- /.container -->
</div> <!-- /.recent-cause-details -->

<script type="text/javascript">
$(function() {
    $('#form_donar').submit(function() {
        var fecha_vencimiento = $('#mes').val() + $('#anio').val();
        $('#fecha_vencimiento').val(fecha_vencimiento);
    })
})
</script>