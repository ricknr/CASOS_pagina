<?php 
	// echo $this->Html->css('/bootstrap/dist/css/bootstrap.min.css');
	// if ($datos['bnrgCodigoProc'] == 'A') {
	// 	echo "<div class='alert alert-success' role='alert'>Tu transacción fue procesada correctamente. El folio de tu transacción es ". $datos['folio'] ."</div>";
	// }elseif($datos['bnrgCodigoProc'] == 'R'){
	// 	echo "<div class='alert alert-danger' role='alert'>Tu transacción fue rechazada. <br> Detalle: ". $datos['bnrgTexto'] ."</div>";
	// }
	// // debug($datos);
?>


<?php if ($datos['bnrgCodigoProc'] == 'A'){ ?>
	<?php #echo $this->Html->script('http://code.jquery.com/jquery-3.2.1.min.js'); ?>
	<script type="text/javascript">
		window.top.location.href = "http://caritas.local/gracias/<?php echo $aportacion['Aportacion']['id'];?>"; 
	</script>	
<?php }elseif($datos['bnrgCodigoProc'] == 'R'){ ?> 
	<?php
		echo $this->Html->css('/bootstrap/dist/css/bootstrap.min.css');
		echo "<div class='alert alert-danger' role='alert'>Tu transacción fue rechazada. <br> Detalle: ". $datos['bnrgTexto'] ."</div>";
	?>
<?php } ?>