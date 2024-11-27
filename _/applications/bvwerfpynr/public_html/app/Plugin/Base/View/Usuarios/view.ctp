<div class="row">
    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" style="display: flex; align-items: center;"> 
        <!-- <ol class="breadcrumb btn btn-default btn-rounded btn-outline" style="margin-top:22px;">
            <li class="active"><a href="/admin/base/usuarios">Usuarios</a></li>
        </ol> -->

        <h3 class="m-b-0" style="display:inline-block">
            <?php if(AuthComponent::user('id') != $usuario['Usuario']['id']){ ?>
                    Usuario
                 <?php } else {?>
                    Mi Cuenta
            <?php  }?>  
        </h3>      
    </div> 
</div>

<div class="row">
        <div class="col-md-4">
            <div class="white-box">
                <div class="">
                    <img class="img-responsive" alt="user" src="http://dev.waben.mx/assets/plugins/images/avatar-default.png">
                </div>
                
                <div class="user-btm-box">
                    <!-- .row -->
                    <div class="row text-center m-t-10">
                        <div class="col-md-12 b-r">
                            <strong>Nombre</strong>
                            <p><?php echo $usuario['Usuario']['nombre']; ?></p>
                        </div>                                                        
                    </div>
                    <hr>
                    <div class="row text-center m-t-10">                        
                        <div class="col-md-12">
                            <strong>Correo</strong>
                            <p><?php echo $usuario['Usuario']['correo']; ?></p>
                        </div>
                    </div>
                    <!-- /.row -->
                    <hr>
                    <!-- .row -->
                    <div class="row text-center m-t-10">
                        <div class="col-md-6 b-r">
                            <strong>Usuario</strong>
                            <p><?php echo $usuario['Usuario']['usuario']; ?></p>
                        </div>
                        <div class="col-md-6"><strong>Estatus</strong>
                            <p>
                                <?php echo ($usuario['Usuario']['activo'])?"<label class='label label-success'>Activo</label>":"<label class='label label-default'>Inactivo</label>"; ?>
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-xs-12">
            <div class="white-box">
                <!-- .tabs -->
                <ul class="nav nav-tabs tabs customtab">

                    <li role="presentation" class="nav-item"><a href="#update" class="nav-link active" aria-controls="update" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="fa fa-home"></i></span><span class="hidden-xs"> Informacion personal</span></a></li>
                    

                    <li role="presentation" class="nav-item"><a href="#password" class="nav-link" aria-controls="password" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="fa fa-envelope-o"></i></span> <span class="hidden-xs">Contraseña</span></a></li>

                </ul>
                <!-- /.tabs -->
                <div class="tab-content">
                    <div class="tab-pane active" id="update" aria-expanded="true">                        
                        <?php echo $this->Form->create('Usuario', array('class'=>'form-material form-horizontal','method'=>'post','url'=>'/admin/base/usuarios/edit/'.$usuario["Usuario"]["id"])) ?>    
                            <div class="form-group">
                                <div class="col-md-6">
                                <label for="name" class="col-md-6">Nombre</label>
                                    <?php echo $this->Form->input('id', array( 'type'=>'hidden','value'=>$usuario['Usuario']['id'] ) );?>
                                    <?php echo $this->Form->input('nombre', array( 'class'=>'form-control','div'=>false,'required'=>true,'label'=>false,'value'=>$usuario['Usuario']['nombre'] ) );?>
                                    <!-- <input placeholder="Ingresa el nombre" class="form-control" name="name" type="text" value="Admin" id="name"> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                <label for="email">Correo electrónico</label>
                                    <?php echo $this->Form->input('correo', array( 'class'=>'form-control','div'=>false,'required'=>true,'label'=>false,'value'=>$usuario['Usuario']['correo'] ) );?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Actualizar</button>
                        </form>
                    </div>


                    <div class="tab-pane" id="password" aria-expanded="false">
                        <?php echo $this->Form->create('Usuario', array('class'=>'form-material form-horizontal','method'=>'post','url'=>'/base/usuarios/edit_password/'.$usuario["Usuario"]["id"])) ?>
                            <div class="form-group">
                                <label for="password" class="col-md-12">Contraseña</label>
                                <div class="col-md-6    ">
                                    <?php echo $this->Form->input('id', array( 'type'=>'hidden','value'=>$usuario['Usuario']['id'] ) );?>                               
                                    <?php echo $this->Form->input('password', array( 'type'=>'password','class'=>'form-control','required'=>true,'div'=>false,'label'=>false,'placeholder'=>'Contraseña' ) );?>
                                </div>
                                <div class="col-md-6">                                    
                                    <?php echo $this->Form->input('password_confirma', array('type'=>'password' ,'class'=>'form-control','required'=>true,'div'=>false,'label'=>false,'placeholder'=>'Confirmar contraseña' ) );?>
                                    <div class="help-block with-errors"></div>
                                </div>     
                            </div>
                            <button type="submit" class="btn btn-info waves-effect waves-light m-r-10">Actualizar</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
