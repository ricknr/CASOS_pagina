<?php //debug($acos); die; ?>
<div class="ibox float-e-margins">
    <div class="ibox-title row">
       <h1>
		<?php
		 echo __('Acos');
		 echo $this->Html->link(__('Agregar Aco'), array('controller' => 'acos',  'action' => 'add'), array('class'=>'btn btn-primary pull-right'));
		?>
      </h1>
	</div>
    <div class="ibox-content row">
		<div class="col-md-12">
		
			<div class="table-responsive">
				<table class="table table-striped table-hover table-condensed">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('id'); ?></th>
							<th><?php echo $this->Paginator->sort('parent_id'); ?></th>
							<th><?php echo $this->Paginator->sort('model'); ?></th>
							<th><?php echo $this->Paginator->sort('foreign_key'); ?></th>
							<th><?php echo $this->Paginator->sort('alias'); ?></th>
							<th><?php echo $this->Paginator->sort('lft'); ?></th>
							<th><?php echo $this->Paginator->sort('rght'); ?></th>
							<th class="actions"><?php echo __('Acciones'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($acos as $aco): ?>
						<tr class='tr_dbl_click' data-href="<?php echo $this->Html->url(array( 'controller'=>'Template','action'=>'view', $aco['Aco']['id'])); ?>">
							<td><?php echo h($aco['Aco']['id']); ?></td>
							<td>
								<?php echo $aco['Aco']['parent_id']; ?>
							</td>
							<td><?php echo h($aco['Aco']['model']); ?></td>
							<td><?php echo h($aco['Aco']['foreign_key']); ?></td>
							<td><?php echo h($aco['Aco']['alias']); ?></td>
							<td><?php echo h($aco['Aco']['lft']); ?></td>
							<td><?php echo h($aco['Aco']['rght']); ?></td>
							<td class="actions">
								<div class=" pull-right">
									<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $aco['Aco']['id']), array('class' => 'btn btn-default btn-xs', 'title'=>"Ver") ); ?> 
									<?php //echo $this->Html->link(__('Editar'), array('action' => 'edit', $aco['Aco']['id']), array('class' => 'btn btn-warning btn-xs') ); ?> 
									<?php //echo $this->Form->postLink(__('Borrar'), array('action' => 'delete', $aco['Aco']['id']), array('class'=>'acciones btn btn-danger btn-xs'), __('¿Estas seguro que quieres borrar # %s?', $aco['Aco']['id']));  ?>
									
									<?php echo $this->Html->link('<i class="fa fa-pencil-square-o"></i>', array('action' => 'edit', $aco['Aco']['id']), array('class' => 'btn btn-warning btn-xs' , 'escape'=>false, 'title'=>'Editar' ) ); ?> 
									<?php echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('action' => 'delete', $aco['Aco']['id']), array('class'=>'acciones btn btn-danger btn-xs',  'escape'=>false, 'title'=>'Borrar'), __('¿Estas seguro que quieres borrar # %s?', $aco['Aco']['id']));  ?>
								</div>
							</td>
						</tr>
						 <?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<div class="clearfix paginatorResults">
				<div class="wp-pager-info pull-left">
					<?php echo $this->Paginator->counter(array( 'format' => __('Mostrando registros {:start} al {:end}, de {:count} totales') )); ?>
				</div> 
				<ul class="pagination" style="margin-top:-7px;margin-left:20px;">
					<?php
						echo $this->Paginator->prev('« ', array('tag' => 'li') , null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag'=>'a'));
						echo $this->Paginator->numbers(array('currentClass' => 'active', 'currentTag' => 'a', 'tag' => 'li', 'separator' => null));
						echo $this->Paginator->next('»', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag'=>'a'));
					?>
				</ul>
			</div>
			
		</div>
	</div>    
</div>


<?php
	 $this->Html->scriptBlock("$(function(){  	}); ",array("inline"=>false)); 
?>
