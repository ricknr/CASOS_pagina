<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
 <div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><?php echo "<?php echo __('{$singularHumanName}'); ?>"; ?></h5>                               

        <div class="ibox-tools">
<?php 
		echo "\t\t<?php\n";
			echo "\t\t\t echo \$this->Html->link('<i class=\"fa fa-reply\"></i> '.__('Regresar'), array('controller' => '".$pluralVar."',  'action' => 'index'), array('class'=>'btn btn-primary btn-xs', 'escape'=>false));\n";			
		echo "\t\t?>\n"; 
?>          
        </div>
    </div>
 
	<div class="ibox-content">

		<div class="row">
			<div class="col-md-9">
				<div class="panel panel-primary <?php echo $pluralVar; ?> view">
					<div class="panel-heading">
						  <p class="h6"><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></p>
					</div>  
					<div class="panel-body ">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover table-condensed" > 
								<tbody>
<?php
	foreach ($fields as $field) {
		$isKey = false;
		if (!empty($associations['belongsTo'])) {
			foreach ($associations['belongsTo'] as $alias => $details) {
				if ($field === $details['foreignKey']) {
					$isKey = true;
					echo "\t\t\t\t \t\t\t\t \t<tr>\n";
						echo "\t\t\t\t \t\t\t\t \t\t<th class='col-sm-2'><?php echo __('" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></th>\n";
						echo "\t\t\t\t \t\t\t\t \t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t\t</td>\n";
					echo "\t\t\t\t \t\t\t\t \t</tr>\n";
					break;
				}
			}
		}
		if ($isKey !== true) {
			echo "\t\t\t\t \t\t\t\t \t<tr>\n";
				echo "\t\t\t\t \t\t\t\t \t\t<th><?php echo __('" . Inflector::humanize($field) . "'); ?></th>\n";
				echo "\t\t\t\t \t\t\t\t \t\t<td>\n\t\t\t<?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>\n\t\t\t</td>\n";
			echo "\t\t\t\t \t\t\t\t \t</tr>\n";
		}
	}
?>
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
				  <span class="list-group-item disabled"><?php echo "<?php echo __('Acciones'); ?>"; ?></span>

<?php
	echo "\t\t<?php \n";
	echo "\t\t\t echo \$this->Html->link(__('Editar " . $singularHumanName ."'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'list-group-item'));  \n";
	echo "\t\t\t echo \$this->Form->postLink(__('Borrar " . $singularHumanName . "'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'list-group-item'), __('¿Estas seguro que quieres borrar # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); \n";
	echo "\t\t\t echo \$this->Html->link(__('" . $pluralHumanName . "'), array('action' => 'index'), array('class' => 'list-group-item'));  \n";
	echo "\t\t\t echo \$this->Html->link(__('Nuev@ " . $singularHumanName . "'), array('action' => 'add'), array('class' => 'list-group-item') ); \n";

	$done = array();
	foreach ($associations as $type => $data) {
		foreach ($data as $alias => $details) {
			if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
				echo "\t\t\t echo \$this->Html->link(__(' " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index'), array('class' => 'list-group-item'));  \n";
				echo "\t\t\t echo \$this->Html->link(__('Nuev@ " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'), array('class' => 'list-group-item'));  \n";
				$done[] = $details['controller'];
			}
		}
	}
	echo "\t\t ?> \n";
?>

				</div>
			</div>
			<!-- /.col-md-3 -->
		</div>




<?php
	if (!empty($associations['hasOne'])) :
		foreach ($associations['hasOne'] as $alias => $details): 
		$thisPluralHumanName = Inflector::humanize($details['controller']);
?>


			<div class="row">
				<div class="col-md-9">
					<div class="panel panel-default">
						<div class="panel-heading">
							<?php echo "<?php echo __('" . Inflector::humanize($details['controller']) . " relacionad@'); ?>"; ?>
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n"; ?>
							<div class="dataTable_wrapper table-responsive related">
								<table class="table table-striped table-bordered table-hover table-condensed dataTables-related" id=""> 
									<tbody>
										
<?php
foreach ($details['fields'] as $field) {
		echo "\t\t<tr>\n";
		echo "\t\t<th class='col-sm-2'><?php echo __('" . Inflector::humanize($field) . "'); ?></th>\n";
		echo "\t\t<td><?php echo \${$singularVar}['{$alias}']['{$field}']; ?></td>\n";
		echo "\t\t</tr>\n";

}		
		echo "\t\t<tr>\n";
		echo "\t\t<th class='col-sm-2'>Acciones</th>\n";
		echo "\t\t<td class=\"actions text-right\">\n";
			echo "\t<div class='btn-group'>\n";
			echo "\t\t<?php \n";

					echo "\t\techo \$this->Html->link(__('Ver'), array( 'controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'] ), array('class'=>'btn btn-primary btn-xs')); \n";
					echo "\t\techo \$this->Html->link(__('Editar'), array( 'controller' => '{$details['controller']}', 'action' => 'edit', \${$singularVar}['{$alias}']['{$details['primaryKey']}'] ), array('class'=>'btn btn-warning btn-xs')); \n"; 
					echo "\t\techo \$this->Form->postLink(__('Borrar'), array( 'controller' => '{$details['controller']}', 'action' => 'delete', \${$singularVar}['{$alias}']['{$details['primaryKey']}']), array('class'=>'btn btn-danger btn-xs'), __('¿Estas seguro que quieres borrar # %s?',  \${$singularVar}['{$alias}']['{$details['primaryKey']}']   ));\n";
				
			echo "\t?>\n";
			echo "\t\t</td>\n";
			echo "\t</div>\n";
			echo "\t\t</tr>\n";
?>

									</tbody>
								</table>
							</div>
							<!-- /.table-responsive -->
							<?php echo "<?php endif; ?>\n"; ?>
						</div>
						<!-- /.panel-body -->
					</div>
					<!-- /.panel -->
				</div>
				<!-- /.col-md-9 -->
				<div class="col-md-3">
					<div class="list-group">
					  <span class="list-group-item disabled"><?php echo "<?php echo __('Acciones'); ?>"; ?></span>
						<?php echo "<?php echo \$this->Html->link(__('Editar " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$singularVar}['{$alias}']['{$details['primaryKey']}']) , array('class' => 'list-group-item')); ?>\n"; ?>
					</div>
				</div>
				<!-- /.col-md-3 -->
			</div>

<?php
			endforeach;
		endif;

		if (empty($associations['hasMany'])) {
			$associations['hasMany'] = array();
		}
		if (empty($associations['hasAndBelongsToMany'])) {
			$associations['hasAndBelongsToMany'] = array();
		}
		$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
?>
		<div class="row">
			<div class="col-md-12">
				<ul class="nav nav-tabs">
				<?php		

				foreach($relations as $alias => $details){
					$otherSingularVar = Inflector::variable($alias);
					$otherPluralHumanName = Inflector::humanize($details['controller']);
					

					
					echo "<?php echo ";
						echo "  '<li class=\" \">  <a data-toggle=\"tab\" href=\"#$otherSingularVar\"> ' ";
						echo " . __(' $otherPluralHumanName  ' ) .";
						echo " '</a></li>'  \n";
					echo " ?>  \n"; 
				}
				?>
				</ul>
				<br>
				<div class="tab-content">
				<?php 

					foreach ($relations as $alias => $details):
						$otherSingularVar = Inflector::variable($alias);
						$otherPluralHumanName = Inflector::humanize($details['controller']);

				?>
						<div id="<?php echo  "$otherSingularVar";  ?>" class="tab-pane  ">
							<div class="table-responsive">
								<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n"; ?>
								<table class="table table-striped table-hover table-condensed " id=""> 
									<thead>
										<tr>
											<?php
													foreach ($details['fields'] as $field) {
														echo "\t\t<th><?php echo __('" . Inflector::humanize($field) . "'); ?></th>\n";
													}
											?>
											<th class="actions"></th>
										</tr>
									</thead>
									<tbody>
									<?php
									echo "<?php foreach (\${$singularVar}['{$alias}'] as \${$otherSingularVar}): ?>\n";
									echo "\t<tr>\n";
										foreach ($details['fields'] as $field) {
											echo "\t\t\t<td><?php echo \${$otherSingularVar}['{$field}']; ?></td>\n";
										}									
									echo "\t\t<td class=\"actions text-right\">\n";
										echo "\t<div class='btn-group'>\n";
										echo "\t\t<?php \n";
											echo "\t\techo \$this->Html->link(__('Ver'), array( 'controller' => '{$details['controller']}', 'action' => 'view', \${$otherSingularVar}['{$details['primaryKey']}'] ), array('class'=>'btn btn-primary btn-xs')); \n";
											echo "\t\techo \$this->Html->link(__('Editar'), array( 'controller' => '{$details['controller']}', 'action' => 'edit', \${$otherSingularVar}['{$details['primaryKey']}'] ), array('class'=>'btn btn-warning btn-xs')); \n";
											echo "\t\techo \$this->Form->postLink(__('Borrar'), array( 'controller' => '{$details['controller']}', 'action' => 'delete', \${$otherSingularVar}['{$details['primaryKey']}']), array('class'=>'btn btn-danger btn-xs'), __('¿Estas seguro que quieres borrar # %s?',  \${$otherSingularVar}['{$details['primaryKey']}']   ));\n";
										echo "\t?>\n";
										echo "\t\t</td>\n";
										echo "\t</div>\n";
									echo "\t</tr>\n";

									echo "<?php endforeach; ?>\n";
									?>
									</tbody>
								</table>
								<?php echo "<?php endif; ?>\n\n"; ?>
							</div>
						</div>			
					<?php endforeach; ?>
				</div> <!--tab-content-->
			</div> <!--col-md-12-->
		</div><!--row-->

	
	</div><!--ibox-content-->
</div><!--ibox float-e-margins-->

<?php
	echo "<?php\n";
		echo "\t \$this->Html->scriptBlock(\"$(function(){  	}); \",array(\"inline\"=>false)); \n";
	echo "?>\n";
?>
