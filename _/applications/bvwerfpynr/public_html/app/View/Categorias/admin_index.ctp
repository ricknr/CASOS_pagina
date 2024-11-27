<div class="content-result">
	<div class="row">
		<div class="col-md-9">
			<h3>Categorías</h3>
		</div>

		<div class="col-md-3">
			<a href="/admin/categorias/add" class="btn btn-block btn-outline btn-success" data-target="#modal_add" data-toggle="modal">			
				+ Agregar Categoría
			</a>
		</div>
	</div>

	<br>
	<div class="row">
		<!-- <div class="col-md-12">
			<?php #echo $this->Form->create('Credito',  array('novalidate' => true,'class'=>'row') );?>
		            <?php
		            	#echo $this->Form->input('credito_acreditado',array('class'=>'form-control','placeholder'=>'Número de crédito o Acreditado','label'=>'Nombre', 'div'=>array('class'=>'col-sm-4')));
		            	#echo $this->Form->input('creditos_estatus_id',array('class'=>'form-control','label'=>'Estatus','options'=>$estatus ,'empty'=>'Todos','div'=>array('class'=>'col-sm-4')));
		            ?>
	        	<?php #echo $this->Form->submit( 'Filtrar' , array('class'=>'btn btn-info pull-bottom','style'=>'margin-top:25px', 'div'=>array('class'=>'col-sm-4 ' ) ));?>
	        <?php #echo $this->Form->end();?>
	        <br>
		</div> -->

		<div class="col-sm-12">
	        <div class="table-responsive">
	            <table class="table table-hover">
	                <thead class="sorts">
	                    <tr>
							<th><?php echo $this->Paginator->sort('id'); ?></th>
							<th><?php echo $this->Paginator->sort('nombre'); ?></th>
							<th><?php echo $this->Paginator->sort('descripcion'); ?></th>
							<th><?php echo $this->Paginator->sort('activo'); ?></th>
							<th><?php echo $this->Paginator->sort('creado_por'); ?></th>
							<th class="actions " style="width:20%"></th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<?php foreach ($categorias as $categoria): ?>
	                		<tr>
								<td><?php echo h($categoria['Categoria']['id']); ?></td>
								<td><?php echo h($categoria['Categoria']['nombre']); ?></td>
								<td><?php echo h($categoria['Categoria']['descripcion']); ?></td>
								<td><?php echo ($categoria['Categoria']['activo'])?"<label class='label label-success'>Activo</label>":"<label class='label label-default'>Inactivo</label>"; ?></td>
								
								<td><?php echo $categoria['Creador']['nombre'] . '('.$categoria['Categoria']['created'].')'; ?></td>
								<td class="actions">
									<a href="#" class="btn_edit label label-info label-rouded"
										data-id="<?php echo $categoria['Categoria']['id'] ?>"
										data-nombre="<?php echo $categoria['Categoria']['nombre'] ?>"
										data-descripcion="<?php echo $categoria['Categoria']['descripcion'] ?>"
										data-activo="<?php echo $categoria['Categoria']['activo']?>"										
										data-url="/admin/categorias/edit/<?php echo $categoria['Categoria']['id']?>"
										data-target="#modal_edit"
										data-toggle="modal"
									>
										<i class="fa fa-pencil-square-o"></i>										
									</a>						 					
						  			<?php echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('admin'=>true,'action' => 'delete', $categoria['Categoria']['id']), array('class'=>'acciones label label-danger label-rouded',  'escape'=>false, 'title'=>'Borrar'), __('¿Estas seguro que quieres borrar # %s?', $categoria['Categoria']['id']));  ?>
								</td>
							</tr>
						 <?php endforeach; ?>
	                </tbody>
	            </table>
	        </div>

		</div>
		<div class="col-md-12">
				<ul class="pagination">
					<?php
					echo $this->Paginator->prev('«', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag'=>'a'));
					echo $this->Paginator->numbers(array('currentClass' => 'active', 'currentTag' => 'a', 'tag' => 'li', 'separator' => null));
					echo $this->Paginator->next('»', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag'=>'a'));
					?>
				</ul>
	        	<div class="">
				    <?php echo $this->Paginator->counter(array('format' => __('Mostrando registros {:start} al {:end}, de {:count} totales'))); ?>
				</div> 
	    </div>
	</div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="modal_add" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
	        <?php echo $this->Form->create('Categoria', array('id'=>'formAdd','novalidate' => true,'url'=>'/admin/categorias/add','inputDefaults'=>array('class' => 'form-control')) ); ?>
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                <h4 class="modal-title" id="myLargeModalLabel">Agregar Categoría</h4>
	            </div>
	            <div class="modal-body">
						<div class="row">
							<?php
								echo $this->Form->input('nombre', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-12' )) );
								echo $this->Form->input('descripcion', array( 'type'=>'textarea', 'div'=>array('class'=>'col-sm-12 ' )) );
								echo '<div class="col-md-4"><label>Activo <br>'.$this->Form->input('activo', array('checked'=>true,'div'=>false,'class'=>'js-switch','label'=>false)).'<label></div>';		
							?>
						</div>
	            </div>
	            <div class="modal-footer">
	            	<?php echo $this->Form->submit( 'Guardar' , array('class'=>'btn btn-success pull-bottom', 'div'=>false ));?>
					<button type="button" class="btn btn-default waves-effect text-left" data-dismiss="modal">Cancelar</button>
	            </div>
			<?php echo $this->Form->end() ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog ">
        <div class="modal-content">
	        <?php echo $this->Form->create('Categoria', array('id'=>'editForm','novalidate' => true,'url'=>'#','inputDefaults'=>array('class' => 'form-control')) ); ?>
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	                <h4 class="modal-title" id="myLargeModalLabel">Editar Categoría</h4>
	            </div>
	            <div class="modal-body">
						<div class="row">
							<?php
								echo $this->Form->input('id', array('type'=>'hidden') );
								echo $this->Form->input('nombre', array( /*label'=> '' ,'placeholder'=>'', */ 'div'=>array('class'=>'col-sm-12' )) );
								echo $this->Form->input('descripcion', array( 'type'=>'textarea', 'div'=>array('class'=>'col-sm-12 ' )) );
								echo '<div class="col-md-4"><label>Activo <br>'.$this->Form->input('activo', array('checked'=>true,'div'=>false,'class'=>'js-switch','label'=>false)).'<label></div>';		
							?>
						</div>
	            </div>
	            <div class="modal-footer">
	            	<?php echo $this->Form->submit( 'Guardar' , array('class'=>'btn btn-success pull-bottom', 'div'=>false ));?>
					<button type="button" class="btn btn-default waves-effect text-left" data-dismiss="modal">Cancelar</button>
	            </div>
			<?php echo $this->Form->end() ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script type="text/javascript">
$(".btn_edit").on('click', function (e) {		
	var id = $(this).data('id');	
	var nombre = $(this).data('nombre');
	var descripcion = $(this).data('descripcion');	
	var activo = $(this).data('activo');
	var url = $(this).data('url');
	
	$('#editForm').attr('action',url);
	$('#editForm #CategoriaId').val(id);	
	$('#editForm #CategoriaNombre').val(nombre);
	$('#editForm #CategoriaDescripcion').val(descripcion);	
	var chkActivo = document.querySelector('#editForm #CategoriaActivo');
	setCheck(chkActivo,activo);
});	

function setCheck(chk,value){
	var state = chk.checked;
	if (state != value) {
		chk.click();
	}
}
</script>