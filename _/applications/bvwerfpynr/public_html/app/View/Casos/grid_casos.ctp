
	<?php if (empty($casos)){ ?>
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-info">No se encontraron casos en esta categoría o critetio de búsqueda.</div>
			</div>		
		</div>	
	<?php }else{ ?> 
		<div class="row">
			<div class="col-md-12">
				<br>
				<h4 class="center">Categoría: <?php echo $categoria; ?></h4>
				<br><br>
			</div>
			<?php
				$i = 1;
				foreach ($casos as $k => $caso):
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
					                    <div class="piechart"  data-border-color="rgba(19,155,167,1)" data-value="<?php echo ($caso['Caso']['porcentaje_recaudado'] == 0)?'.001':( $caso['Caso']['porcentaje_recaudado'] / 100); ?>">
										  <span><?php echo intval($caso['Caso']['porcentaje_recaudado'])?></span>
										</div>
					                </div>

									<h5><a href="/casos/detalle/<?php echo $caso['Caso']['id']?>" class="tran3s"><?php echo $caso['Caso']['titulo']?></a></h5>
									<p><?php echo $caso['Caso']['descripcion_corta'] ?></p>
									<span><strong>Donation :</strong> $<?php echo number_format($caso['Caso']['total_recaudado'],2)?> / <span class="ch-p-color">$<?php echo number_format($caso['Caso']['importe_meta'],2)?></span></span>
									<div class="clearfix">										
										<a id="modalTest" data-id="<?php echo $caso['Caso']['id']?>" class="tran3s float-left ch-p-bg-color donate donacionTest">quiero donar</a>
										<a href="/casos/detalle/<?php echo $caso['Caso']['id']?>" class="tran3s float-left more">detalles</a>
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

		<ul class="text-center charity-pagination">
			<?php
			echo $this->Paginator->prev('«', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag'=>'a'));
			echo $this->Paginator->numbers(array('currentClass' => 'active', 'currentTag' => 'a', 'tag' => 'li', 'separator' => null));
			echo $this->Paginator->next('»', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag'=>'a'));
			?>
		</ul>

<?php } ?>