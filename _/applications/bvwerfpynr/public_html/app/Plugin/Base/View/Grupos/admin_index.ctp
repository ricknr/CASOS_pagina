<div class="content-result">
	<div class="row">
		<div class="col-md-9">
			<h3>Grupos</h3>
		</div>

		<div class="col-md-3">
			<a href="/admin/base/grupos/add" class="btn btn-block btn-outline btn-success">
				+ Agregar Grupo
			</a>
		</div>
	</div>

	<br>
	<div class="row">
		<div class="col-sm-12">
	        <div class="table-responsive">
	            <table class="table table-hover">
	                <thead class="sorts">
	                    <tr>
							<th><?php echo $this->Paginator->sort('id'); ?></th>
							<th><?php echo $this->Paginator->sort('nombre'); ?></th>
							<th><?php echo $this->Paginator->sort('redirect'); ?></th>
							<th class="actions " style="width:20%"></th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<?php foreach ($grupos as $grupo): ?>
							<tr data-show="/admin/base/grupos/view/<?php echo $grupo['Grupo']['id']?>">
								<td><?php echo h($grupo['Grupo']['id']); ?></td>
								<td><?php echo h($grupo['Grupo']['nombre']); ?></td>
								<td><?php echo h($grupo['Grupo']['redirect']); ?></td>
								<td class="actions">										
										<?php echo $this->AclHtml->link('<i class="fa fa-pencil-square-o"></i>', array('action' => 'edit', $grupo['Grupo']['id']), array('class' => 'label label-info label-rouded', 'escape'=>false, 'title'=>"Editar") ); ?> 
										
										<?php											
											if(AuthComponent::user('grupo_id')==1){												
												echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('action' => 'delete', $grupo['Grupo']['id']), array('class'=>'label label-danger label-rouded', 'escape'=>false, 'title'=>"Borrar"), __('¿Estas seguro que quieres borrar # %s?', $grupo['Grupo']['id']));
											}
										?>									
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
	$("tbody").on('click', 'td', function (e) {
		if (!$(this).hasClass('actions')) {
            window.location.href = $(this).parent().data('show');
        }
    });
})
</script>