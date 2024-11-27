<?php	
	echo $this->Html->script('/front/js/jquery.validate');
?>
<style type="text/css">
.charity-theme .theme-inner-banner{
	margin-bottom: 0px;
}

.error{
	/*border-color: red !important;*/
	/*outline:red !important;*/
    border: 1px solid #f00 !important;
	color:red !important;
}


#importe-error{
    display: block;
    margin-top: -10px;
}

select{
    width: 100%;
    height: 60px;
    border: 1px solid #ebebeb;
    border-radius: 5px;
    padding: 0 20px;
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
			<h2>Donar</h2>
			<ul>
				<li><span><?php echo $caso['Caso']['titulo']?></span></li>
			</ul>
		</div> <!-- /.container -->
	</div> <!-- /.opacity -->
</div> <!-- /.theme-inner-banner -->



<!-- 
=============================================
	Recent Cause
============================================== 
-->
<div class="donation-page" id="x">
	<div class="container">
		<h2>Apoya a <?php echo $caso['Caso']['nombre']?></h2>
		<form action="/nueva_donacion/<?php echo $caso['Caso']['id']?>"  id="donateForm" class="" autocomplete="off" method="post">
            <h4>PASO 1 DE 2</h4>   
            <p>Por favor proporcione la información que se solicita a continuación. </p>
            <br>
			<h4>Cantidad a donar</h4>            
			<ul class="donate-amount clearfix">			    			
                <li class="float-left"><span class="donate-price tran3s">$100</span></li>
                <li class="float-left"><span class="donate-price tran3s">$250</span></li>
                <li class="float-left"><span class="donate-price tran3s">$500</span></li>
                <li class="float-left"><span class="donate-price tran3s">$1000</span></li>
                <li class="float-left"><span class="donate-price tran3s">$2000</span></li>
                <li class="float-left"><span class="donate-price tran3s">$5000</span></li>                
                <li class="float-left">u</li>
    			<li class="float-left" style="line-height:30px;">
    			     <input type="text" placeholder="otro importe" name="importe" class="donate-amount-handelar float-left" >                    
    			</li>
    		</ul> <!-- /.donate-amount -->
    		<div class="billing-information">
    			<h4>Información de contacto</h4>
    			<div class="row">
    				<div class="col-sm-6 ">
    					<p>
	    					<label for="nombre_donador">Nombre Completo<span>*</span></label>
	    					<input type="text" placeholder="Nombre" id="nombre_donador" name="nombre_donador">
    					</p>
    				</div>
    				<div class="col-sm-6">
    					<label for=>Correo electrónico<span>*</span></label>
    					<input id="email_donador" type="email" placeholder="Correo electrónico" name="mail_donador" >
                        Este correo se usará exclusivamente para enviarte tu confirmación de donativo e informarte cuando se haya llegado a la meta. 
    				</div>			    				
    				<div class="col-sm-6">
    					<label>Teléfono </label>
    					<input type="text" placeholder="Teléfono" name="telefono_donador">
    				</div>

					<div class="col-sm-12">
                        <p>
                            <b>¿Requieres recibo deducible?</b>
                            <input type="checkbox" id="chkFactura" name="requiere_factura" value="1" style="width: inherit !important;height: inherit !important;">
                        </p>
                    </div>


                    <div id="requiere_factura" style="display:none">
                        <div class="col-sm-12">
        					<h4>Domicilio<span>*</span></h4>
                        </div>
                        <div class="col-sm-6">
                            <label>RFC<span>*</span></label>
                            <input type="text" placeholder="RFC" name="rfc" id="rfc">
                        </div>

        				<div class="col-sm-6">
        					<label>Calle y número<span>*</span></label>
        					<input type="text" placeholder="Calle y número" name="calle_y_numero" id="calle_y_numero">
        				</div>
        				<div class="col-sm-6">
        					<label>Colonia<span>*</span></label>
        					<input type="text" placeholder="Colonia" name="colonia" id="colonia">
        				</div>

                        <div class="col-sm-6">
                            <label>Estado<span>*</span></label>
                            <input type="text" placeholder="Estado" name="estado" id="estado">
                        </div>
                        
                        <div class="col-sm-6">
                            <label>Municipio<span>*</span></label>
                            <input type="text" placeholder="Municipio" name="municipio" id="municipio">
                        </div>

        				<div class="col-sm-6">
        					<label>Ciudad<span>*</span></label>
        					<input type="text" placeholder="Ciudad" name="ciudad" id="ciudad">
        				</div>

        				<div class="col-sm-6">
        					<label>País<span>*</span></label>
        					<input type="text" placeholder="País" name="pais" id="pais">
        				</div>

        				<div class="col-sm-6">
        					<label>Código postal<span>*</span></label>
        					<input type="text" placeholder="Código postal" name="cp" id="cp">
        				</div>

                        <div class="col-sm-6">
                            <label>Tipo de Tarjeta<span>*</span></label>
                            <select name="tipo_tarjeta" id="tipo_tarjeta">
                                <option value="credito">Crédito</option>
                                <option value="debito">Débito</option>
                            </select>                        
                        </div>

                        
                    </div>

                    <div class="col-md-12">
                        <label>
                            Los campos marcados con el (<span>*</span>) son obligatorios.
                        </label>
                    </div>
    			</div> <!-- /.row -->
    		</div> <!-- /.billing-information -->
    		
            <p>Recuerde que su donativo es deducible de impuestos, si lo desea puede solicitar su comprobante una vez que haya efectuado su pago. </p>
            <br><br>

    		<button class="tran3s ch-p-bg-color">Continuar</button>
		</form>
	</div> <!-- /.container -->
</div> <!-- /.donation-page -->



<script type="text/javascript">
$(function(){
    $([document.documentElement, document.body]).animate({
        scrollTop: ($("#x").offset().top - 90)
    }, 2000);

    $(document).ready(function(){
        $('input').on('click', function(){
            if( $('#chkFactura').is(':checked') && $("#email_donador").val() != "" ){
                var email = $("#email_donador").val();

                var requestUrl  = '<?php echo Router::url( array('admin'=>false, 'plugin'=>false, 'controller' => 'aportaciones', 'action' => 'email_data') ); ?>';
                //console.log(requestUrl);
                $.ajax({
                    type:"POST",
                    data:{'email':email}, 
                    dataType: "html",
                    contentType: "application/x-www-form-urlencoded",
                    url: requestUrl,
                    success : function(data) {

                        var json = $.parseJSON(data);
                        if( json && json.length){ 
                            $('#rfc').val(json[0]['aportaciones']['rfc']);
                            $('#calle_y_numero').val(json[0]['aportaciones']['calle_y_numero']);
                            $('#colonia').val(json[0]['aportaciones']['colonia']);
                            $('#estado').val(json[0]['aportaciones']['estado']);
                            $('#municipio').val(json[0]['aportaciones']['municipio']);
                            $('#ciudad').val(json[0]['aportaciones']['ciudad']);
                            $('#pais').val(json[0]['aportaciones']['pais']);
                            $('#cp').val(json[0]['aportaciones']['cp']);
                        }
                    },
                    error : function() {
                        alert("Error al cargar la información.");
                    }
                });
            }
        });
    });


	$("#donateForm").validate({
		rules:{
			nombre_donador:"required",
			mail_donador:"required",
			importe:{
				required: true,
      			number: true
			},
            calle_y_numero:{ required: "#chkFactura:checked" },
            colonia:{ required: "#chkFactura:checked" },
            estado:{ required: "#chkFactura:checked" },
            municipio:{ required: "#chkFactura:checked" },
            ciudad:{ required: "#chkFactura:checked" },
            pais:{ required: "#chkFactura:checked" },
            cp:{ required: "#chkFactura:checked" },
            rfc:{ required: "#chkFactura:checked" },
		},
		messages:{
			nombre_donador:"Campo requerido",
			mail_donador:"Campo requerido",
			importe:"Campo requerido",
            calle_y_numero:"Campo requerido",
            colonia:"Campo requerido",
            estado:"Campo requerido",
            municipio:"Campo requerido",
            ciudad:"Campo requerido",
            pais:"Campo requerido",
            cp:"Campo requerido",
		},
        errorPlacement: function(){
            return false;  // suppresses error message text
        },
        submitHandler:function(){
            if (confirm("Favor de validar sus datos antes de continuar.")) {
                return true;
            }
            return false;
        }


	});


    $('#chkFactura').click(function(){
        if( $('#chkFactura').prop('checked') ) {
            $('#requiere_factura').show();
        }else{
            $('#requiere_factura').hide();
        }
    })

})
</script>