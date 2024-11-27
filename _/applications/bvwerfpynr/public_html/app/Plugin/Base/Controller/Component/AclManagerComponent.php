<?php
/**
 * @property AclReflectorComponent $AclReflector
 */
class AclManagerComponent extends Component{
    
	var $components = array('Auth', 'Acl' , 'Base.AclReflector', 'Session');  


	/**
	 * Set the permissions of the authenticated user in Session
	 * The session permissions are then used for instance by the AclHtmlHelper->link() function
	 */
	public function set_session_permissions(){
        if(!$this->Session->check('Base.Acl.permissions')){
            $actions = $this->AclReflector->get_all_actions();            
            $user = $this->Auth->user();			           
            if(!empty($user)){                
                $permissions = array();            
                foreach($actions as $action){
                    $aco_path = 'controllers/' . $action;
                    
                    #$permissions[$aco_path] = $this->Acl->check($user, $aco_path);
					#validacion por grupos.
					$permissions[$aco_path] = $this->Acl->check(array('model' => 'Grupo', 'foreign_key' => $user['grupo_id']) , $aco_path);
                }
                
                $this->Session->write('Base.Acl.permissions', $permissions);
            }
        }
    }
}