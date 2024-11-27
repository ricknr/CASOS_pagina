 <div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?php echo __('Aco'); ?></h5>                               

        <div class="ibox-tools">
		<?php
			 echo $this->Html->link('<i class="fa fa-reply"></i> '.__('Regresar'), array('controller' => 'acos',  'action' => 'index'), array('class'=>'btn btn-primary btn-xs', 'escape'=>false));
		?>
          
        </div>
    </div>
 
	<div class="ibox-content">

		<div class="row">
			<div class="col-md-9">
				<div class="panel panel-primary acos view">
					<div class="panel-heading">
						  <p class="h6"><?php echo __('Admin View Aco'); ?></p>
					</div>  
					<div class="panel-body ">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover table-condensed" > 
								<tbody>
										<tr>
			<th><?php echo __('Id'); ?></th>
			<td>
			<?php echo h($aco['Aco']['id']); ?>
			</td>
		</tr>
		<tr>
			<th class='col-sm-2'><?php echo __('Parent Aco'); ?></th>
			<td>
			<?php echo $this->Html->link($aco['ParentAco']['alias'], array('controller' => 'acos', 'action' => 'view', $aco['ParentAco']['id'])); ?>
			</td>
		</tr>
		<tr>
			<th><?php echo __('Model'); ?></th>
			<td>
			<?php echo h($aco['Aco']['model']); ?>
			</td>
		</tr>
		<tr>
			<th><?php echo __('Foreign Key'); ?></th>
			<td>
			<?php echo h($aco['Aco']['foreign_key']); ?>
			</td>
		</tr>
		<tr>
			<th><?php echo __('Alias'); ?></th>
			<td>
			<?php echo h($aco['Aco']['alias']); ?>
			</td>
		</tr>
		<tr>
			<th><?php echo __('Lft'); ?></th>
			<td>
			<?php echo h($aco['Aco']['lft']); ?>
			</td>
		</tr>
		<tr>
			<th><?php echo __('Rght'); ?></th>
			<td>
			<?php echo h($aco['Aco']['rght']); ?>
			</td>
		</tr>
								</tbody>
							</table>
						</div>
						<!-- /.table-responsive -->
					</div>

				</div>
				<!-- /.panel -->
			</div>
			<!-- /.col-md-9 -->
			<div class="col-md-3">
				<div class="list-group">
				  <span class="list-group-item disabled"><?php echo __('Acciones'); ?></span>

							<?php 
		 echo $this->Html->link(__('Editar Aco'), array('action' => 'edit', $aco['Aco']['id']), array('class' => 'list-group-item'));  
		 echo $this->Form->postLink(__('Borrar Aco'), array('action' => 'delete', $aco['Aco']['id']), array('class' => 'list-group-item'), __('¿Estas seguro que quieres borrar # %s?', $aco['Aco']['id'])); 
		 echo $this->Html->link(__('Acos'), array('action' => 'index'), array('class' => 'list-group-item'));  
		 echo $this->Html->link(__('Nuev@ Aco'), array('action' => 'add'), array('class' => 'list-group-item') ); 
		 echo $this->Html->link(__(' Acos'), array('controller' => 'acos', 'action' => 'index'), array('class' => 'list-group-item'));  
		 echo $this->Html->link(__('Nuev@ Parent Aco'), array('controller' => 'acos', 'action' => 'add'), array('class' => 'list-group-item'));  
		 echo $this->Html->link(__(' Aros'), array('controller' => 'aros', 'action' => 'index'), array('class' => 'list-group-item'));  
		 echo $this->Html->link(__('Nuev@ Aro'), array('controller' => 'aros', 'action' => 'add'), array('class' => 'list-group-item'));  
		 ?> 

				</div>
			</div>
			<!-- /.col-md-3 -->
		</div>




				<div class="row">
			<div class="col-md-12">
				<ul class="nav nav-tabs">
				<?php echo   '<li class=" ">  <a data-toggle="tab" href="#childAco"> '  . __(' Acos  ' ) . '</a></li>'  
 ?>  
<?php echo   '<li class=" ">  <a data-toggle="tab" href="#aro"> '  . __(' Aros  ' ) . '</a></li>'  
 ?>  
				</ul>
				<br>
				<div class="tab-content">
										<div id="childAco" class="tab-pane  ">
							<div class="table-responsive">
								<?php if (!empty($aco['ChildAco'])): ?>
								<table class="table table-striped table-hover table-condensed " id=""> 
									<thead>
										<tr>
													<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th><?php echo __('Model'); ?></th>
		<th><?php echo __('Foreign Key'); ?></th>
		<th><?php echo __('Alias'); ?></th>
		<th><?php echo __('Lft'); ?></th>
		<th><?php echo __('Rght'); ?></th>
											<th class="actions"></th>
										</tr>
									</thead>
									<tbody>
									<?php foreach ($aco['ChildAco'] as $childAco): ?>
	<tr>
			<td><?php echo $childAco['id']; ?></td>
			<td><?php echo $childAco['parent_id']; ?></td>
			<td><?php echo $childAco['model']; ?></td>
			<td><?php echo $childAco['foreign_key']; ?></td>
			<td><?php echo $childAco['alias']; ?></td>
			<td><?php echo $childAco['lft']; ?></td>
			<td><?php echo $childAco['rght']; ?></td>
		<td class="actions text-right">
	<div class='btn-group'>
		<?php 
		echo $this->Html->link(__('Ver'), array( 'controller' => 'acos', 'action' => 'view', $childAco['id'] ), array('class'=>'btn btn-primary btn-xs')); 
		echo $this->Html->link(__('Editar'), array( 'controller' => 'acos', 'action' => 'edit', $childAco['id'] ), array('class'=>'btn btn-warning btn-xs')); 
		echo $this->Form->postLink(__('Borrar'), array( 'controller' => 'acos', 'action' => 'delete', $childAco['id']), array('class'=>'btn btn-danger btn-xs'), __('¿Estas seguro que quieres borrar # %s?',  $childAco['id']   ));
	?>
		</td>
	</div>
	</tr>
<?php endforeach; ?>
									</tbody>
								</table>
								<?php endif; ?>

							</div>
						</div>			
											<div id="aro" class="tab-pane  ">
							<div class="table-responsive">
								<?php if (!empty($aco['Aro'])): ?>
								<table class="table table-striped table-hover table-condensed " id=""> 
									<thead>
										<tr>
													<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th><?php echo __('Model'); ?></th>
		<th><?php echo __('Foreign Key'); ?></th>
		<th><?php echo __('Alias'); ?></th>
		<th><?php echo __('Lft'); ?></th>
		<th><?php echo __('Rght'); ?></th>
											<th class="actions"></th>
										</tr>
									</thead>
									<tbody>
									<?php foreach ($aco['Aro'] as $aro): ?>
	<tr>
			<td><?php echo $aro['id']; ?></td>
			<td><?php echo $aro['parent_id']; ?></td>
			<td><?php echo $aro['model']; ?></td>
			<td><?php echo $aro['foreign_key']; ?></td>
			<td><?php echo $aro['alias']; ?></td>
			<td><?php echo $aro['lft']; ?></td>
			<td><?php echo $aro['rght']; ?></td>
		<td class="actions text-right">
	<div class='btn-group'>
		<?php 
		echo $this->Html->link(__('Ver'), array( 'controller' => 'aros', 'action' => 'view', $aro['id'] ), array('class'=>'btn btn-primary btn-xs')); 
		echo $this->Html->link(__('Editar'), array( 'controller' => 'aros', 'action' => 'edit', $aro['id'] ), array('class'=>'btn btn-warning btn-xs')); 
		echo $this->Form->postLink(__('Borrar'), array( 'controller' => 'aros', 'action' => 'delete', $aro['id']), array('class'=>'btn btn-danger btn-xs'), __('¿Estas seguro que quieres borrar # %s?',  $aro['id']   ));
	?>
		</td>
	</div>
	</tr>
<?php endforeach; ?>
									</tbody>
								</table>
								<?php endif; ?>

							</div>
						</div>			
									</div> <!--tab-content-->
			</div> <!--col-md-12-->
		</div><!--row-->

	
	</div><!--ibox-content-->
</div><!--ibox float-e-margins-->

<?php
	 $this->Html->scriptBlock("$(function(){  	}); ",array("inline"=>false)); 
?>
