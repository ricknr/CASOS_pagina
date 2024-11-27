<?php 
/*
 * CSS menu helper.  
 * Author: Luis Trevino.
 */
class CssMenuHelper extends Helper{

    var $helpers = array('Html','Session','Javascript');

    /*
     * Genera un list apartir de las Reglas.
     */
    function menu($data=array(), $type='down'){
        $menu= $this->Session->read('Usuario.cacheMenu');
       
        $ma = '';
        $paso=0;

        // debug($menu);die;
        if($menu){
          foreach ($menu as $regla){
            // debug($regla);
              if ($regla['Regla']['padre']==1){
                      $data= array_merge($data,array($regla['Regla']['nombre'] => $regla['Regla']['accion']));

                      $padre=$regla['Regla']['nombre'];
                      // debug($data);
                      // debug($padre);
                      if($paso){$ma.="
                              </ul>";};
                      $paso=1;
                 
                      //Padre
                      $ma.='<li>
                              <a href="#">
                                <i class="'.$regla['Regla']['icono'].'"></i> 
                                <span>'. $regla['Regla']['nombre']. ' </span>
                                <span class="fa arrow"></span>
                              </a>
                          <ul class="nav nav-second-level">';
                      
              }elseif($regla['Regla']['padre']==0){
                  if(is_array(@$data[@$padre])){
                    // debug($regla);
                      //li's normales dentro de padre
                       $data[$padre][$regla['Regla']['nombre']]=$regla['Regla']['accion'];                       
                       $ma.=' <li><a href="'.$regla['Regla']['accion'] .'">'. $regla['Regla']['nombre'] .'</a></li>';
                  }else{
                    debug($regla);
                      //li's que no tienen
                      $data[@$padre]=array($regla['Regla']['nombre']=> $regla['Regla']['accion']);
                      $ma.='

                      <li>
                         <a href="'. $regla['Regla']['accion'] .'">
                                <i class="'. $regla['Regla']['icono'] .'"></i>
                                <span class="nav-label">'. $regla['Regla']['nombre'] .'</span> 
                            </a>
                      </li>';                       
                      }
                  }
          }
          
           $ma.='</ul>';

          return $this->output($ma);
        
        }else{
            return false;
        }
    }    


       
}
?>