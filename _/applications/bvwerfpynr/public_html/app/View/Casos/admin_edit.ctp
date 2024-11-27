 <!-- Daterange picker plugins css -->
<link href="/js/plugins/bower_components/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
<link href="/js/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="/js/plugins/bower_components/timepicker/bootstrap-timepicker.min.js"></script>
<script src="/js/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>


<div class="row">
	<div class="col-md-9">
		<h4>Editar Caso</h4>
	</div>
	
</div>
<br>
<?php echo $this->Form->create('Caso', array('type' => 'file', 'inputDefaults'=>array('class' => 'form-control')) ); ?>
<div class="row">
	<?php if (empty($categorias)): ?>
		<div class="col-md-12">
			<div class="alert alert-info2">No hay categorías activas.</div>
		</div>		
	<?php endif ?>
	<?php
		echo $this->Form->input('id', array());
		echo $this->Form->input('titulo', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
		echo $this->Form->input('nombre', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
		echo $this->Form->input('edad', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );

		echo $this->Form->input('categoria_id', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
		echo $this->Form->input('folio', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );
	?>
		<div class="col-sm-4  required">
			<label for="CasoImporteMeta">Importe Meta</label>
			<div class="input-group">
			    <span class="input-group-addon">$</span>
			    <?php echo $this->Form->input('importe_meta', array( 'type'=>'text','class'=>'form-control','div'=>false,'label'=>false) );		?>
			</div>
		</div>
	<?php
		echo $this->Form->input('diagnostico', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4' )) );
		echo $this->Form->input('fecha', array('type'=>'text','class'=>'input-daterange-datepicker form-control', 'div'=>array('class'=>'col-sm-4 ' )) );
		echo $this->Form->input('referencia_bancaria', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-4 ' )) );	
		echo '<div class="col-md-4"><label>Activo <br>'.$this->Form->input('activo', array('checked'=>true,'div'=>false,'class'=>'js-switch','label'=>false)).'<label></div>';		

		echo $this->Form->input('tipo', array('type'=>'select' ,'options'=>array('Imagen'=>'Imagen','Video'=>'Video'),'div'=>array('class'=>'col-sm-4' )) );
		echo $this->Form->input('imagen', array( 'type'=>'file', 'div'=>array('class'=>'col-sm-4 ' )) );
		echo $this->Form->input('video', array( 'type'=>'text', 'label'=>'Vídeo (URL de YouTube)','div'=>array('class'=>'col-sm-4 ' )) );
		echo $this->Form->input('descripcion', array( /* ,'placeholder'=>'', */'label'=> 'Descripción general', 'div'=>array('class'=>'col-sm-12 ' )) );
		echo $this->Form->input('descripcion_corta', array( 'type'=>'textarea','label'=>'Descripción corta','maxlength'=>100,'div'=>array('class'=>'col-sm-12 ' )) );
	?>
	<div class="col-md-12">
		<p>Total de caracteres: <span id="total_char">100</span></p>
	</div>

	<?php echo $this->Form->input('descripcion_resolucion', array( 'type'=>'textarea','maxlength'=>100,'div'=>array('class'=>'col-sm-12 ' )) );?>
	<div class="col-md-12">
		<p>Total de caracteres: <span id="total_char2">100</span></p>
	</div>


	<div class="col-md-12">
		<?php echo $this->Form->submit('Guardar', array('class'=>'btn btn-success pull-bottom','style'=>'margin-top:25px', 'div'=>false ));?>
		<?php echo $this->AclHtml->link('Cancelar',array('action'=>'index'),array('class'=>'btn btn-default btn-outline pull-bottom','style'=>'margin-top:25px','div'=>false)); ?>
	</div>
	<?php echo $this->Form->end() ?>
</div>

<script type="text/javascript">
$(function(){
	// $('.datepicker').datepicker({
	// 	format: 'yyyy-mm-dd'
	// });
	revisaTipo();
	countChar();
	countChar2()
	$('#CasoTipo').change(function(){
    	revisaTipo();
    })


    $('#CasoDescripcionCorta').keyup(function(){
    	countChar()
    })

    $('#CasoDescripcionCorta').keydown(function(){
    	countChar()
    })

    $('#CasoDescripcionResolucion').keyup(function(){
    	countChar2()
    })

    $('#CasoDescripcionResolucion').keydown(function(){
    	countChar2()
    })

	$('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        autoApply: true,
        locale: {
	      format: 'YYYY/MM/DD'
	    }
    });
})


function countChar() {		
	var chars = parseInt($("#CasoDescripcionCorta").val().length)
	var total = 100 - chars;
  $("#total_char").html( total ); //Detectamos los Caracteres del Input  
}

function countChar2() {		
	var chars = parseInt($("#CasoDescripcionResolucion").val().length)
	var total = 100 - chars;
  $("#total_char2").html( total ); //Detectamos los Caracteres del Input  
}

function revisaTipo(){
	var tipo = $('#CasoTipo').val();

	if (tipo == 'Imagen') {
		$('#CasoImagen').parent().show();
		$('#CasoVideo').parent().hide();
		
	}else{
		$('#CasoImagen').parent().hide();
		$('#CasoVideo').parent().show();
	}
}
</script>