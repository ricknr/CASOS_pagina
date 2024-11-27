 <div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?php echo __('Categoria'); ?></h5>                               

        <div class="ibox-tools">
		<?php
			 echo $this->Html->link('<i class="fa fa-reply"></i> '.__('Regresar'), array('controller' => 'categorias',  'action' => 'index'), array('class'=>'btn btn-primary btn-xs', 'escape'=>false));
		?>
          
        </div>
    </div>
 
	<div class="ibox-content">

		<div class="row">
			<div class="col-md-9">
				<div class="panel panel-primary categorias view">
					<div class="panel-heading">
						  <p class="h6"><?php echo __('View Categoria'); ?></p>
					</div>  
					<div class="panel-body ">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover table-condensed" > 
								<tbody>
				 				 	<tr>
				 				 		<th><?php echo __('Id'); ?></th>
				 				 		<td>
			<?php echo h($categoria['Categoria']['id']); ?>
			</td>
				 				 	</tr>
				 				 	<tr>
				 				 		<th><?php echo __('Nombre'); ?></th>
				 				 		<td>
			<?php echo h($categoria['Categoria']['nombre']); ?>
			</td>
				 				 	</tr>
				 				 	<tr>
				 				 		<th><?php echo __('Descripcion'); ?></th>
				 				 		<td>
			<?php echo h($categoria['Categoria']['descripcion']); ?>
			</td>
				 				 	</tr>
				 				 	<tr>
				 				 		<th><?php echo __('Activo'); ?></th>
				 				 		<td>
			<?php echo h($categoria['Categoria']['activo']); ?>
			</td>
				 				 	</tr>
				 				 	<tr>
				 				 		<th><?php echo __('Created'); ?></th>
				 				 		<td>
			<?php echo h($categoria['Categoria']['created']); ?>
			</td>
				 				 	</tr>
				 				 	<tr>
				 				 		<th><?php echo __('Creado Por'); ?></th>
				 				 		<td>
			<?php echo h($categoria['Categoria']['creado_por']); ?>
			</td>
				 				 	</tr>
				 				 	<tr>
				 				 		<th><?php echo __('Modified'); ?></th>
				 				 		<td>
			<?php echo h($categoria['Categoria']['modified']); ?>
			</td>
				 				 	</tr>
				 				 	<tr>
				 				 		<th><?php echo __('Modificado Por'); ?></th>
				 				 		<td>
			<?php echo h($categoria['Categoria']['modificado_por']); ?>
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
			 echo $this->Html->link(__('Editar Categoria'), array('action' => 'edit', $categoria['Categoria']['id']), array('class' => 'list-group-item'));  
			 echo $this->Form->postLink(__('Borrar Categoria'), array('action' => 'delete', $categoria['Categoria']['id']), array('class' => 'list-group-item'), __('¿Estas seguro que quieres borrar # %s?', $categoria['Categoria']['id'])); 
			 echo $this->Html->link(__('Categorias'), array('action' => 'index'), array('class' => 'list-group-item'));  
			 echo $this->Html->link(__('Nuev@ Categoria'), array('action' => 'add'), array('class' => 'list-group-item') ); 
		 ?> 

				</div>
			</div>
			<!-- /.col-md-3 -->
		</div>




		<div class="row">
			<div class="col-md-12">
				<ul class="nav nav-tabs">
								</ul>
				<br>
				<div class="tab-content">
								</div> <!--tab-content-->
			</div> <!--col-md-12-->
		</div><!--row-->

	
	</div><!--ibox-content-->
</div><!--ibox float-e-margins-->

<?php
	 $this->Html->scriptBlock("$(function(){  	}); ",array("inline"=>false)); 
?>
