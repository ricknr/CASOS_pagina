<div class="ibox float-e-margins">
    <div class="ibox-title row">
       <h1>
<?php 
		echo "\t\t<?php\n";
			echo "\t\t echo __('{$pluralHumanName}');\n";
			echo "\t\t echo \$this->Html->link(__('Agregar " . $singularHumanName . "'), array('controller' => '".$pluralVar."',  'action' => 'add'), array('class'=>'btn btn-primary pull-right'));\n";			
		echo "\t\t?>\n"; 
?>
      </h1>
	</div>
    <div class="ibox-content row">
		<div class="col-md-12">
		
			<div class="table-responsive">
				<table class="table table-striped table-hover table-condensed">
					<thead>
						<tr>
<?php foreach ($fields as $field): ?>
							<th><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>"; ?></th>
<?php endforeach; ?>
							<th class="actions"><?php echo "<?php echo __('Acciones'); ?>"; ?></th>
						</tr>
					</thead>
					<tbody>
					<?php
					echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
					echo "\t\t\t\t\t\t<tr class='tr_dbl_click' data-href=\"<?php echo \$this->Html->url(array( 'controller'=>'$this->name','action'=>'view', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\">\n";
						foreach ($fields as $field) {
							$isKey = false;
							if (!empty($associations['belongsTo'])) {
								foreach ($associations['belongsTo'] as $alias => $details) {
									if ($field === $details['foreignKey']) {
										$isKey = true;
										echo "\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t\t\t\t\t\t</td>\n";
										break;
									}
								}
							}
							if ($isKey !== true) {
								echo "\t\t\t\t\t\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?></td>\n";
							}
						}

						echo "\t\t\t\t\t\t\t<td class=\"actions\">\n";
							echo "\t\t\t\t\t\t\t\t<div class=\" pull-right\">\n";

							echo "\t\t\t\t\t \t\t\t\t\t<?php //echo \$this->Html->link(__('Ver'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-default btn-xs', 'title'=>'Ver') ); ?> \n";
							echo "\t\t\t\t\t \t\t\t\t\t<?php //echo \$this->Html->link('<i class=\"fa fa-pencil-square-o\"></i>', array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-warning btn-xs' , 'escape'=>false, 'title'=>'Editar') ); ?> \n";

							echo "\t\t\t\t\t \t\t\t\t\t<?php echo \$this->AclHtml->link(__('Ver'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-default btn-xs', 'title'=>'Ver') ); ?> \n";
							echo "\t\t\t\t\t \t\t\t\t\t<?php echo \$this->AclHtml->link('<i class=\"fa fa-pencil-square-o\"></i>', array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn btn-warning btn-xs' , 'escape'=>false, 'title'=>'Editar') ); ?> \n";
							
							echo "\t\t\t\t\t  \t\t\t\t\t<?php echo \$this->Form->postLink('<i class=\"fa fa-trash-o\"></i>', array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class'=>'acciones btn btn-danger btn-xs',  'escape'=>false, 'title'=>'Borrar'), __('¿Estas seguro que quieres borrar # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}']));  ?> \n";			
							
							echo "\t\t\t\t\t\t\t\t</div>\n";
						echo "\t\t\t\t\t\t\t</td>\n";
					echo "\t\t\t\t\t\t</tr>\n";

					echo "\t\t\t\t\t\t <?php endforeach; ?>\n";
					?>
					</tbody>
				</table>
			</div>

			<div class="clearfix paginatorResults">
				<div class="wp-pager-info pull-left">
					<?php echo "<?php echo \$this->Paginator->counter(array( 'format' => __('Mostrando registros {:start} al {:end}, de {:count} totales') )); ?>\n"; ?>
				</div> 
				<ul class="pagination" style="margin-top:-7px;margin-left:20px;">
					<?php
						echo "<?php\n";
						echo "\t\t\t\t\t\techo \$this->Paginator->prev('« ', array('tag' => 'li') , null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag'=>'a'));\n";
						echo "\t\t\t\t\t\techo \$this->Paginator->numbers(array('currentClass' => 'active', 'currentTag' => 'a', 'tag' => 'li', 'separator' => null));\n";
						echo "\t\t\t\t\t\techo \$this->Paginator->next('»', array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag'=>'a'));\n";
						echo "\t\t\t\t\t?>\n";
					?>
				</ul>
			</div>
			
		</div>
	</div>    
</div>


<?php
	echo "<?php\n";
		echo "\t \$this->Html->scriptBlock(\"$(function(){  	}); \",array(\"inline\"=>false)); \n";
	echo "?>\n";
?>
