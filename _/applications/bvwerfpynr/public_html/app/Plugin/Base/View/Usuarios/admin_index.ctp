<div class="content-result">
	<div class="row">
		<div class="col-md-9">
			<h3 class="box-title">Usuarios</h3>
		</div>

		<div class="col-md-3">
			<a href="/admin/base/usuarios/add" class="btn btn-block btn-outline btn-success">
				Agregar Usuario
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php echo $this->Form->create('Usuarios',  array('novalidate' => true,'class'=>'row') );?>
				
		            <?php
		            	echo $this->Form->input('nombre',array('class'=>'form-control', 'label'=>'Nombre','value'=>$nombre,'placeholder'=>'Nombre', 'div'=>array('class'=>'col-sm-4')));
		            	echo $this->Form->input('grupo_id',array('class'=>'form-control','selected'=>$grupo, 'label'=>'Perfil','empty'=>'Todos','div'=>array('class'=>'col-sm-4')));	
		            	echo $this->Form->input('estatus',array('class'=>'form-control','type'=>'select','div'=>array('class'=>'col-sm-2' ) ,'options'=>array('todos'=>'Todos' ,'1'=>'Activo', '0'=>'Inactivo' ) ,'selected'=>$estatus ));				
		            	// echo $this->Form->input('registros',array('class'=>'form-control','type'=>'select','div'=>array('class'=>'col-sm-4' ) ,'options'=>array('20'=>'20' ,'50'=>'50', '100'=>'100' ) ,'selected'=>$limit ));
		            ?>	            
	        	<?php echo $this->Form->submit( 'Filtrar' , array('class'=>'btn btn-info pull-bottom','style'=>'margin-top:25px', 'div'=>array('class'=>'col-sm-2' ) ));?>
	        <?php echo $this->Form->end();?>
		</div>
		<div class="col-sm-12">
	        <div class="white-box">            
	            <table class="table table-hover">
	                <thead>
	                    <tr>	                
							<th><?php echo $this->Paginator->sort('nombre', 'Nombre')?></th>
							<th><?php echo $this->Paginator->sort('usuario', 'Nombre de Usuario')?></th>
							<th><?php echo $this->Paginator->sort('correo', 'E-mail')?></th>
							<th><?php echo $this->Paginator->sort('grupo_id', 'Perfil')?></th>
							<th><?php echo $this->Paginator->sort('activo', 'Activo')?></th>
							<th class="actions text-right">Acciones</th>
	                    </tr>
	                </thead>
	                <tbody>
	                	<?php foreach($usuarios as $k => $usuario): ?>
							<tr data-show="/base/usuarios/view/<?php echo $usuario['Usuario']['id']?>">
								<td><?php echo $usuario['Usuario']['nombre']; ?></td>
								<td><?php echo $usuario['Usuario']['usuario']; ?></td>
								<td><?php echo $usuario['Usuario']['correo']; ?></td>
								<td><?php echo $usuario['Grupo']['nombre']; ?></td>
								<td><?php echo $boleano[$usuario['Usuario']['activo']]; ?> </td>
								<td class="actions">
									<?php
										echo $this->AclHtml->link('<i class="fa fa-pencil-square-o"></i>', array('action' => 'edit', $usuario['Usuario']['id']),array('class' => 'label label-info label-rouded', 'escape'=>false, 'title'=>"Editar" ));

										echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('action' => 'delete', 'controller'=>'personas',$usuario['Usuario']['id']), array('class'=>'label label-danger label-rouded', 'escape'=>false, 'title'=>"Borrar"), __('¿Estas seguro que quieres borrar # %s?', $usuario['Usuario']['id']));
									?>								    
								</td>
							</tr>
							<?php endforeach; ?>                    
	                </tbody>
	            </table>
	        </div>


		</div>

		<div class="col-md-12">
	        
				<ul class="pagination" style="margin-top:-7px;margin-left:20px;">
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
$(document).ready(function(){
	$(document).on('click','.pagination a',function(event){
		event.preventDefault();
		//alert('x'); return false;
		url = $(this).attr('href');
		getUsers(url); return false;
	});
	$(document).on('submit','form#UsuariosAdminIndexForm',function(event){
		event.preventDefault();				
		theurl = '<?php echo $this->Html->url(array("controller"=>"usuarios","action"=>"index")) ?>';
		getUsers(theurl);
		// alert(1);
	})
	function getUsers(url){
		var grupo     = $('#UsuariosGrupoId').val();
		var estatus   = $('#UsuariosEstatus').val();
		var limit = $('#UsuariosRegistros').val();
		var nombre = $('#UsuariosNombre').val();

		$.ajax({
		   cache:false,
           type: "POST",
           dataType: "html",
           contentType: "application/x-www-form-urlencoded",
           url:url,
           data:{"data[grupo]":grupo, "data[estatus]":estatus,"data[limit]":limit,"data[nombre]":nombre  },
           success:function(data){
           	$('.content-result').html(data);
           },
           error:function(data){
           	//alert('error');
           }
         }); 
	}

	$("tbody").on('click', 'td', function (e) {
        if (!$(this).hasClass('actions')) {
            window.location.href = $(this).parent().data('show');
        }
    });
		
})
</script>