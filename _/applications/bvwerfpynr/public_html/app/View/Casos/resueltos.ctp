<!-- 
=============================================
	Inner Banner
============================================== 
-->
<div class="theme-inner-banner">
	<div class="opacity">
		<div class="container">
			<!-- <h2>Casos resueltos</h2> -->
			<ul>				
				<!-- <li><a href="/casos" class="tran3s">Causas</a></li>
				<li>/</li> -->
				<li>CASOS RESUELTOS</li>
			</ul>	
		</div> <!-- /.container -->
	</div> <!-- /.opacity -->
</div> <!-- /.theme-inner-banner -->



<!-- 
=============================================
	Cause 
============================================== 
-->
<div class="recent-cause">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->Session->flash(); ?>
				<div class="content_casos">
					<?php if (!empty($texto)): ?>
								<p style="padding:12px">
									Resultados para <span class="azul">"<?php echo $texto; ?>"</span>
								</p>
							<?php endif ?>

					<?php if (empty($casos)){ ?>
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-info">No se encontraron casos en esta categoría o critetio de búsqueda.</div>
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
										<div class="img" style="height: 200px;background:url(<?php echo $img?>);background-size:cover;">
											<a href="/casos/detalle/<?php echo $caso['Caso']['id']?>" style="display: inline-block;width: 100%;height: 100%;color: transparent;">.</a>
										</div>

									
									<div class="title text-center">
										<div class="donate-piechart tran3s">
						                    <div class="piechart"  data-border-color="rgba(19,155,167,1)" data-value="<?php echo ($caso['Caso']['porcentaje_recaudado'] == 0)?'.001':($caso['Caso']['porcentaje_recaudado'] / 100); ?>">
											  <span><?php echo $caso['Caso']['porcentaje_recaudado']?></span>
											</div>
						                </div>

										<h5><a href="/casos/detalle/<?php echo $caso['Caso']['id']?>" class="tran3s"><?php echo $caso['Caso']['titulo']?></a></h5>
										<p><?php echo $caso['Caso']['descripcion_resolucion']; ?></p>
										<span>
											<strong>Donación :</strong> $<?php echo number_format($caso['Caso']['total_recaudado'],2)?> / <span class="ch-p-color">$<?php echo number_format($caso['Caso']['importe_meta'],2)?></span>
										</span>
										<div class="clearfix">
											<a href="/casos/detalle/<?php echo $caso['Caso']['id']?>" class="tran3s float-left ch-p-bg-color donate" style="width:100%">Detalles</a>
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
			<p>¿QUIERES SER VOLUNTARIO O REALIZAR TU SERVICIO SOCIAL? <br> Contáctanos al teléfono (81) 1340 2090 o déjanos un mensaje </p>
			<a href="/contacto" class="button-four ch-p-bg-color">únete</a>
		</div>
	</div> <!-- /.opacity -->
</div> <!-- /.volunteer-banner -->

	<div class="modal fade" tabindex="-1" role="dialog" id="modalCausa">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
