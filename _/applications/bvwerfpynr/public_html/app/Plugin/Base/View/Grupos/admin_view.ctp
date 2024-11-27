 <div class="ibox float-e-margins">
    <div class="ibox-title">
    	<ol class="breadcrumb btn btn-default btn-rounded btn-outline" style="margin-top:22px;">
            <li class="active"><a href="/admin/base/grupos">Grupos</a></li>
        </ol>

        <h3 class="m-b-0" style="display:inline-block">
        	<?php echo __('Grupo'); ?></h3>

        <div class="ibox-tools">
			<div class="row">
        		<div class="col-md-12">
        			
        			<div class="row text-center m-t-10">
        				<div class="col-md-6">
		                	<strong>ID</strong>
		                    <p><?php echo $grupo['Grupo']['id']?></p>
		                </div>

		                <div class="col-md-6 b-r b-l">
		                	<strong>Nombre</strong>
		                    <p><?php echo $grupo['Grupo']['nombre']?></p>
		                </div>		                
        			</div>
        			<hr>

		            
        		</div>        	
        	</div>
          
        </div>
    </div>
 
	<div class="ibox-content">
		

		<div class="row">
			<div class="col-md-12">
				<ul class="nav nav-tabs">
					<li class=""> <a data-toggle="tab"  href="#usuario">Usuarios</a></li>
					<li class="active"> <a data-toggle="tab" href="#permiso">Permisos</a></li>
				</ul>
				<br>
				<div class="tab-content">
					<div id="permiso" class="tab-pane active">
						<?php if (!empty($acos)): ?>
						<div class="table-responsive">
							<table class="table table-striped table-hover table-condensed " id=""> 
								<thead>
									<tr>
										<th><?php echo __('Id'); ?></th>										
										<th><?php echo __('Nombre'); ?></th>
										<th><?php echo __('Path'); ?></th>
										<th class='text-center'><?php echo __('Acceso'); ?></th>
										<th class="actions"></th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($acos as $aco):  ?>
									<tr>
										<td><?php echo $aco['Aco']['id']; ?></td>
										<td><?php echo $aco['Aco']['alias']; ?></td>
										<td><?php echo str_replace('-', '/', $aco['Aco']['url']); ?></td>
										<td class='text-center'><?php echo $boleano[$aco['Aco']['permiso']]; ?></td>

										<td class="actions text-right">
											<div class='btn-group'>
												<?php  													
													if(AuthComponent::user('grupo_id')==1){
														if($aco['Aco']['permiso']){														
															echo $this->Form->postLink(__('Denegar'), 
																array('admin'=>true, 'plugin'=>'base', 'controller' => 'grupos', 'action' => 'denegar', $grupo['Grupo']['id'], urlencode($aco['Aco']['url'])), 

																array('class'=>'label label-danger label-rouded'), __('¿Estas seguro que quieres denegar  "%s" al grupo: %s?',  $aco['Aco']['url'], $grupo['Grupo']['nombre']   )
															);														
														}else{
															echo $this->Form->postLink(__('Permitir'), 
																array('admin'=>true, 'plugin'=>'base', 'controller' => 'grupos', 'action' => 'permitir', $grupo['Grupo']['id'], urlencode($aco['Aco']['url'])), 
																array('class'=>'label label-info label-rouded'), __('¿Estas seguro que quieres permitir  "%s" al grupo: %s?',  $aco['Aco']['url'], $grupo['Grupo']['nombre']   )
															);														
														}
													}
												?>		
											</div>
										</td>
									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<?php endif; ?>
					</div>
					

					<div id="usuario" class="tab-pane  ">
						<div class="table-responsive">
							<?php if (!empty($grupo['Usuario'])): ?>
							<table class="table table-striped table-hover table-condensed " id=""> 
								<thead>
									<tr>
										<th><?php echo __('Id'); ?></th>
										<th><?php echo __('Grupo Id'); ?></th>
										<th><?php echo __('Nombre'); ?></th>
										<th><?php echo __('Usuario'); ?></th>
										<th><?php echo __('Correo'); ?></th>
										<th><?php echo __('Activo'); ?></th>
										<th class="actions"></th>
									</tr>
								</thead>
								<tbody>
								<?php foreach ($grupo['Usuario'] as $usuario): ?>
									<tr>
										<td><?php echo $usuario['id']; ?></td>
										<td><?php echo $usuario['grupo_id']; ?></td>
										<td><?php echo $usuario['nombre']; ?></td>
										<td><?php echo $usuario['usuario']; ?></td>
										<td><?php echo $usuario['correo']; ?></td>
										<td><?php echo $usuario['activo']; ?></td>
										<td class="actions text-right">
											<div class='btn-group'>
												<?php 
													echo $this->AclHtml->link('<i class="fa fa-pencil-square-o"></i>', array('controller' => 'usuarios','action' => 'edit', $usuario['id']), array('class' => 'label label-info label-rouded', 'escape'=>false, 'title'=>"Editar") ); 													

													
													echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('controller' => 'usuarios', 'action' => 'delete', $usuario['id']), array('class'=>'acciones label label-danger label-rouded',  'escape'=>false, 'title'=>'Borrar'), __('¿Estas seguro que quieres borrar # %s?', $usuario['id']));
												?>		
											</div>
										</td>
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
