<div class="content-result">
	<div class="row">
		<div class="col-md-6">
			<h3>Casos</h3>
		</div>

		<div class="col-md-6">
			<a href="/admin/casos/add" class="btn btn-outline btn-success pull-right ml-1" >
				+ Agregar Caso
			</a>

			<div class="btn-group m-r-10 pull-right">
                <button aria-expanded="false" data-toggle="dropdown" class="btn btn-outline btn-success dropdown-toggle waves-effect waves-light" type="button">Exportar <span class="caret"></span></button>
                <ul role="menu" class="dropdown-menu">
                    <li><a href="/admin/casos/export_donaciones">Donaciones</a></li>
                    <li><a href="/admin/casos/export_newsletter">Newsletter</a></li>
                </ul>
            </div>
		</div>
	</div>

	<br>
	<div class="row">
		<div class="col-md-12">
			<?php echo $this->Form->create('Caso',  array('novalidate' => true,'class'=>'row') );?>
		            <?php
		            	echo $this->Form->input('categoria_id',array('class'=>'form-control','placeholder'=>'Categoría','label'=>'Categoría', 'empty'=>'Todos','div'=>array('class'=>'col-sm-3')));	
		            	echo $this->Form->input('titulo',array('class'=>'form-control','label'=>false,'placeholder'=>'Título/Descripción','style'=>'margin-top:25px','div'=>array('class'=>'col-sm-3')));
		            	echo $this->Form->input('folio',array('class'=>'form-control','placeholder'=>'Folio','label'=>'Folio', 'empty'=>'Todos','div'=>array('class'=>'col-sm-3')));	
		            ?>
	        	<?php echo $this->Form->submit( 'Filtrar' , array('class'=>'btn btn-info pull-bottom','style'=>'margin-top:25px', 'div'=>array('class'=>'col-sm-2 ' ) ));?>
	        <?php echo $this->Form->end();?>
	        <br>
		</div>

		<div class="col-sm-12">
	        <div class="table-responsive">
	            <table class="table table-hover">
	                <thead class="sorts">
	                    <tr>
							<th><?php echo $this->Paginator->sort('titulo'); ?></th>
							<th><?php echo $this->Paginator->sort('categoria_id'); ?></th>
							<th><?php echo $this->Paginator->sort('folio'); ?></th>
							<th><?php echo $this->Paginator->sort('fecha_inicio'); ?></th>
							<th><?php echo $this->Paginator->sort('fecha_fin'); ?></th>
							<th><?php echo $this->Paginator->sort('activo'); ?></th>
							<th><?php echo $this->Paginator->sort('importe_meta'); ?></th>
							<th><?php echo $this->Paginator->sort('total_recaudado'); ?></th>							
							<th class="actions " style="width:20%"></th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<?php foreach ($casos as $caso): ?>
	                		<tr data-show="/admin/casos/view/<?php echo $caso['Caso']['id']?>">
								<td><?php echo h($caso['Caso']['titulo']); ?></td>
								<td><?php echo $caso['Categoria']['nombre']?></td>
								<td><?php echo h($caso['Caso']['folio']); ?></td>
								<td><?php echo h($caso['Caso']['fecha_inicio']); ?></td>
								<td><?php echo h($caso['Caso']['fecha_fin']); ?></td>
								<td><?php echo ($caso['Caso']['activo'])?"<label class='label label-success'>Activo</label>":"<label class='label label-default'>Inactivo</label>"; ?></td>
								<td><p class="pull-right">$<?php echo number_format($caso['Caso']['importe_meta'],2); ?></p> </td>
								<td><p class="pull-right"> $<?php echo number_format($caso['Caso']['total_recaudado'],2); ?> </p></td>
								<td class="actions">
									<?php 
										echo $this->AclHtml->link('<i class="fa fa-pencil-square-o"></i>', array('action' => 'edit', $caso['Caso']['id']),array('class' => 'label label-info label-rouded', 'escape'=>false, 'title'=>"Editar" ));
									?>

									<?php echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('admin'=>true,'action' => 'delete', $caso['Caso']['id']), array('class'=>'acciones label label-danger label-rouded',  'escape'=>false, 'title'=>'Borrar'), __('¿Estas seguro que quieres borrar # %s?', $caso['Caso']['id']));  ?>
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


<script type="text/javascript">
$(function(){
	
	bindClickTd();
    $(document).on('click','.pagination a',function(event){
		event.preventDefault();
		url = $(this).attr('href');
		getData(url); return false;
	});


	$(document).on('submit','form#CasoAdminIndexForm',function(event){
		event.preventDefault();
		theurl = '<?php echo $this->Html->url(array("admin"=>true,"controller"=>"casos","action"=>"index")) ?>';
		getData(theurl);
	})

	function getData(url){
		var categoria_id = $('#CasoCategoriaId').val();
		var titulo = $('#CasoTitulo').val();
		var folio = $('#CasoFolio').val();
		
		$.ajax({
		   cache:false,
           type: "POST",
           dataType: "html",
           contentType: "application/x-www-form-urlencoded",
           url:url,
           data:{
           		categoria_id:categoria_id,
           		titulo:titulo,
           		folio:folio
           },
           success:function(data){
           		$('.content-result').html(data);
           		bindClickTd()
           },
           error:function(data){
           	//alert('error');
           }
         }); 
	}
})

function bindClickTd(){
	$("tbody").on('click', 'td', function (e) {
		if (!$(this).hasClass('actions')) {
            window.location.href = $(this).parent().data('show');
        }
    });
}
</script>