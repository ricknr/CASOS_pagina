<div class="sidebar-collapse">
	<ul class="nav" id="side-menu"> 
		<?php 	
			echo '<li>'.$this->AclHtml->link(
				'<i class="fa fa-star" data-icon="v"></i> <span class="hide-menu"> Casos </span>', 
				array('plugin'=>false ,'admin'=>true, 'controller'=>'casos ','action' => 'index' ),
				array('escape'=>false, 'title'=>"Casos",'class'=>'waves-effect')
			).'</li>';
			echo '<li>'.$this->AclHtml->link(
				'<i class="fa fa-bars" data-icon="v"></i> <span class="hide-menu"> Categorías </span>', 
				array('plugin'=>false ,'admin'=>true, 'controller'=>'categorias ','action' => 'index' ),
				array('escape'=>false, 'title'=>"Categorías",'class'=>'waves-effect')
			).'</li>';
			echo '<li>'.$this->Html->link(
				'<i class="fa fa-th-list" data-icon="v"></i> <span class="hide-menu"> Encuesta </span>', 
				array('plugin'=>false ,'admin'=>true, 'controller'=>'encuestas','action' => 'index' ),
				array('escape'=>false, 'title'=>"Encuestas",'class'=>'waves-effect')
			).'</li>';
			echo '<li>'.$this->AclHtml->link(
				'<i class="fa fa-user" data-icon="v"></i> <span class="hide-menu"> Usuarios </span>', 
				array('plugin'=>'base' ,'admin'=>true, 'controller'=>'usuarios ','action' => 'index' ),
				array('escape'=>false, 'title'=>"Usuarios",'class'=>'waves-effect')
			).'</li>';

			echo '<li>'.$this->AclHtml->link(
				'<i class="fa fa-users"></i> <span class="hide-menu">Grupos</span>', 
				array('plugin'=>'base' ,'admin'=>true, 'controller'=>'grupos ','action' => 'index' ),
				array('escape'=>false, 'title'=>"Grupos",'class'=>'waves-effect')
			).'</li>';			
		?>
	</ul>                                   
</div>  