<div class="row">
    <div class="col-md-9">
        <ol class="breadcrumb btn btn-default btn-rounded btn-outline" style="margin-top:10px;">
            <li class="active"><a href="/admin/casos">Casos</a></li>
        </ol>

        <h3 class="m-b-0" style="display:inline-block">
            <?php echo $caso['Caso']['nombre']?> - <?php echo $caso['Caso']['titulo']; ?>
        </h3>
        <?php if ($caso['Caso']['activo']){ ?>
        <label class="label label-success ">Activo</label>
        <?php }else{ ?>
        <label class="label label-default ">Inactivo</label>
        <?php } ?>



    </div>

    <div class="col-md-3">
        <a href="/admin/casos/edit/<?php echo $caso['Caso']['id']?>" class="btn btn-block btn-outline btn-success">
            Editar
        </a>
    </div>

    <div class="col-md-12">
        <hr>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="white-box">

            <div class="row">
                <div class="col-md-8">

                    <div class="row text-center m-t-10">
                        <div class="col-md-4 ">
                            <strong>Categoría</strong>
                            <p><?php echo $caso['Categoria']['nombre']?></p>
                        </div>

                        <div class="col-md-4 b-r b-l">
                            <strong>Referencia Bancaria</strong>
                            <p><?php echo $caso['Caso']['referencia_bancaria']?></p>
                        </div>

                        <div class="col-md-4 ">
                            <strong>Folio</strong>
                            <p><?php echo $caso['Caso']['folio']?></p>
                        </div>
                    </div>
                    <hr>

                    <div class="row text-center m-t-10">
                        <div class="col-md-6 b-r">
                            <strong>Fecha Inicio</strong>
                            <p><?php echo $caso['Caso']['fecha_inicio']?></p>
                        </div>

                        <div class="col-md-6">
                            <strong>Fecha Fin</strong>
                            <p><?php echo $caso['Caso']['fecha_fin']?></p>
                        </div>
                    </div>
                    <hr>

                    <div class="row text-center m-t-10">
                        <div class="col-md-12">
                            <strong>Descripción</strong>
                            <p><?php echo $caso['Caso']['descripcion']?></p>
                        </div>
                    </div>
                    <hr>

                    <div class="row text-center m-t-10">
                        <div class="col-md-12">
                            <strong>Descripción corta</strong>
                            <p><?php echo $caso['Caso']['descripcion_corta']?></p>
                        </div>
                    </div>
                    <hr>

                    <div class="row text-center m-t-10">
                        <div class="col-md-12">
                            <strong>Descripción de la resolución</strong>
                            <p><?php echo $caso['Caso']['descripcion_resolucion']?></p>
                        </div>
                    </div>
                    <hr>


                    <div class="row text-center m-t-10">
                        <div class="col-md-6 "><strong>Creado </strong>
                            <p><?php echo $caso['Creador']['nombre']?> ( <?php echo $caso['Caso']['created']?>)</p>
                        </div>

                        <div class="col-md-6  b-l"><strong>Modificado </strong>
                            <p><?php echo $caso['Modificador']['nombre']?> ( <?php echo $caso['Caso']['modified']?>)</p>
                        </div>
                    </div>
                    <hr>
                </div>



                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12" style="width:321px;">

                            <?php if ($caso['Caso']['tipo'] == 'Video'){ 

	        					$url = $caso['Caso']['video'];
								parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
								$video_id = $my_array_of_vars['v'];
        					?>
                            <iframe src="http://www.youtube.com/embed/<?php echo $video_id ?>"
                                style="width:100%;height:210px;" allowfullscreen></iframe>
                            <?php }else{ ?>
                            <?php if (file_exists($caso['Caso']['relativepath_imagen'].$caso['Caso']['encname_imagen'])){ ?>
                            <img src="/<?php echo $caso['Caso']['relativepath_imagen'].$caso['Caso']['encname_imagen']?>"
                                class="img-responsive">
                            <a id="btnDeleteImage" style="float:right;" href="#"
                                class="acciones label label-danger label-rouded" title="Borrar"><i
                                    class="fa fa-trash-o"></i></a>
                            <?php }else{ ?>
                            <img src="/img/no-image.jpg" class="img-responsive">
                            <?php } ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="white-box">
                                <?php 
	                        		$pendiente = $caso['Caso']['importe_meta'] - $caso['Caso']['total_recaudado'];
	                        		$porcentaje = ($caso['Caso']['total_recaudado'] * 100) / $caso['Caso']['importe_meta'];
	                        		$porcentaje = number_format($porcentaje,2);
	                        	?>
                                <h3 class="box-title">Meta $<?php echo number_format($caso['Caso']['importe_meta'],2)?>
                                </h3>
                                <div class="text-right"> <span class="text-muted">Pendiente
                                        $<?php echo number_format($pendiente,2)?></span>
                                    <h1><sup><i class="ti-arrow-up text-success"></i></sup>
                                        $<?php echo number_format($caso['Caso']['total_recaudado'],2)?></h1>
                                </div> <span class="text-success"><?php echo $porcentaje?>%</span>
                                <div class="progress m-b-0">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50"
                                        aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $porcentaje?>%;">
                                        <span class="sr-only"><?php echo $porcentaje?>% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class="active"> <a data-toggle="tab" href="#fideicomisos">Aportaciones</a></li>
        </ul>
        <br>
        <div class="tab-content">
            <div id="permiso" class="tab-pane active">
                <a href="#" class="btn btn-outline btn-success pull-right" data-target="#modal_addAportacion"
                    data-toggle="modal">
                    + Agregar Aportación
                </a>
                <br><br><br>

                <?php if (!empty($caso['Aportacion'])){ ?>
                <table class="table">
                    <tr>
                        <th>Importe</th>
                        <th>Tipo</th>
                        <th>Donador</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th>Creada</th>
                        <th></th>
                    </tr>
                    <?php foreach ($caso['Aportacion'] as $k => $aportacion): ?>
                    <tr>
                        <td>$<?php echo number_format($aportacion['importe'],2)?></td>
                        <td><?php echo $aportacion['tipo']?></td>
                        <td><?php echo $aportacion['nombre_donador']?></td>
                        <td><?php echo $aportacion['descripcion']?></td>
                        <td><?php echo $aportacion['fecha']?></td>
                        <td><?php echo $aportacion['created']?></td>
                        <td>
                            <?php if($aportacion['tipo'] == 'especie'){ ?>
                                <a href="#" class="btn_edit label label-info label-rouded"
                                data-target="#modal_editAportacion" data-toggle="modal"
                                data-id="<?php echo $aportacion['id']?>"
                                data-caso_id="<?php echo $aportacion['caso_id']?>"
                                data-importe="<?php echo $aportacion['importe']?>"
                                data-fecha="<?php echo $aportacion['fecha']?>"
                                data-descripcion="<?php echo $aportacion['descripcion']?>"
                                data-url="/admin/aportaciones/edit/<?php echo $aportacion['id']?>/<?php echo $caso['Caso']['id']?>">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>


                                <?php echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('admin'=>true,'controller'=>'aportaciones','action' => 'delete', $aportacion['id'],$caso['Caso']['id']), array('class'=>'acciones label label-danger label-rouded',  'escape'=>false, 'title'=>'Borrar'), __('¿Estas seguro que quieres borrar la aportación?', $aportacion['id']));  ?>
                            
                            <?php }else { ?>
                                <a href="#" class="btn_edit label label-info label-rouded invisible">
                                    <i class="fa fa-pencil-square-o"></i>
                                </a>


                                <?php echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('admin'=>true,'controller'=>'aportaciones','action' => 'delete', $aportacion['id'],$caso['Caso']['id']), array('class'=>'acciones label label-danger label-rouded',  'escape'=>false, 'title'=>'Borrar'), __('¿Estas seguro que quieres borrar la aportación?', $aportacion['id']));  ?>
                            
                            <?php } ?>
                            
                        </td>
                    </tr>
                    <?php endforeach ?>
                </table>
                <?php }else{ ?>
                <div class="alert alert-info2">Esta causa no ha recibido ninguna aportación hasta el momento.</div>
                <?php } ?>
                <br><br>
            </div>
        </div>
    </div>
    <!--col-md-12-->
</div>
<!--row-->




<div class="modal fade" tabindex="-1" role="dialog" id="modal_editAportacion" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <?php echo $this->Form->create('Aportacion', array('id'=>'editAportacionForm','url'=>'/admin/aportaciones/edit/','inputDefaults'=>array('class' => 'form-control')) ); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Editar aportación</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
								echo $this->Form->input('id', array('type'=>'hidden'));
								echo $this->Form->input('caso_id', array('type'=>'hidden','value'=>$caso['Caso']['id']));
								// echo $this->Form->input('importe', array( 'required'=>true,'type'=>'text','div'=>array('class'=>'col-sm-12' )) );
							?>
                    <div class="col-sm-12 required">
                        <label for="AportacionImporte">Importe</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo $this->Form->input('importe', array( 'required'=>true,'type'=>'text','div'=>false,'label'=>false) );?>
                        </div>
                    </div>
                    <?php
								echo $this->Form->input('fecha', array( 'class'=>'datepicker2 form-control','readonly'=>true,'type'=>'text','div'=>array('class'=>'col-sm-12' )) );
								echo $this->Form->input('descripcion', array( 'required'=>true,'type'=>'textarea', 'div'=>array('class'=>'col-sm-12 ' )) );
							?>
                </div>
            </div>
            <div class="modal-footer">
                <?php echo $this->Form->submit( 'Guardar' , array('class'=>'btn btn-success pull-bottom', 'div'=>false ));?>
                <button type="button" class="btn btn-default waves-effect text-left"
                    data-dismiss="modal">Cancelar</button>
            </div>
            <?php echo $this->Form->end() ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="modal_addAportacion" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <?php echo $this->Form->create('Aportacion', array('id'=>'addForm','url'=>'/admin/casos/addAportacion/'.$caso['Caso']['id'],'inputDefaults'=>array('class' => 'form-control')) ); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Agregar aportación</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
								echo $this->Form->input('caso_id', array('type'=>'hidden','value'=>$caso['Caso']['id']));								
							?>
                    <div class="col-sm-12 required">
                        <label for="AportacionImporte">Importe</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <?php echo $this->Form->input('importe', array( 'required'=>true,'type'=>'text','div'=>false,'label'=>false) );?>
                        </div>
                    </div>
                    <?php
								echo $this->Form->input('tipo', array( 'options'=>array('especie'=>'Especie','efectivo'=>'Efectivo'),/*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-12' )) );
								echo $this->Form->input('fecha', array( 'class'=>'datepicker form-control','readonly'=>true,'type'=>'text','div'=>array('class'=>'col-sm-12' )) );
								echo $this->Form->input('descripcion', array( 'required'=>true,'required'=>true,'type'=>'textarea', 'div'=>array('class'=>'col-sm-12 ' )) );
							?>
                </div>
            </div>
            <div class="modal-footer">
                <?php echo $this->Form->submit( 'Guardar' , array('class'=>'btn btn-success pull-bottom', 'div'=>false ));?>
                <button type="button" class="btn btn-default waves-effect text-left"
                    data-dismiss="modal">Cancelar</button>
            </div>
            <?php echo $this->Form->end() ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>




<script type="text/javascript">
$(function() {

    $('#btnDeleteImage').on('click', function() {
		let imagePath = "<?php echo $caso['Caso']['imagen']?>";
		let imageEnc = "<?php echo $caso['Caso']['encname_imagen']?>";
		//console.log(imagePath);
		var requestUrl  = '<?php echo Router::url( array('admin'=>true, 'plugin'=>false, 'controller' => 'casos', 'action' => 'updateImage') ) . '/' .$caso['Caso']['id']; ?>';
		console.log(requestUrl);
        $.ajax({
            type: "POST",
            data: {
				'imagen': "no-image.jpg",
                'encname_imagen': imageEnc
            },
            dataType: "html",
            contentType: "application/x-www-form-urlencoded",
            url: requestUrl,
            success: function(data) {
				$('.img-responsive').attr("src", "/img/no-image.jpg");
				$('#btnDeleteImage').css("display", "none");
            },
            error: function() {
                alert("Error al cargar la información.");
            }
        });
    });

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        defaultDate: '2017-12-20'
    });

    $(".datepicker").datepicker().datepicker("setDate", new Date());


    $('.datepicker2').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    $('.btn_edit').click(function(e) {
        var url = $(this).data('url');
        var id = $(this).data('id');
        var importe = $(this).data('importe');
        var descripcion = $(this).data('descripcion');
        var fecha = $(this).data('fecha');

        $('.datepicker2').datepicker('update', fecha);

        $('#editAportacionForm  #AportacionId').val(id);
        $('#editAportacionForm  #AportacionCasoId').val(<?php echo $caso['Caso']['id']?>);
        $('#editAportacionForm  #AportacionImporte').val(importe);
        $('#editAportacionForm  #AportacionFecha').val(fecha);
        $('#editAportacionForm  #AportacionDescripcion').val(descripcion);
        $('#editAportacionForm').attr('action', url);
    })
})
</script>