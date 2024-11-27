<?php
App::uses('HtmlHelper', 'View/Helper');
class AclHtmlHelper extends HtmlHelper
{
    var $helpers = array('Session');
    
    function link($title, $url = null, $options = array(), $confirmMessage = false){
        $permissions = $this->Session->read('Base.Acl.permissions');
        if(!isset($permissions)){
            $permissions = array();
        }
        $aco_path = AclRouter :: aco_path($url);
        
        if(isset($permissions[$aco_path]) && $permissions[$aco_path] == 1)
        {
            return parent::link($title, $url, $options, $confirmMessage);
        }
        else
        {
            return null;
        }
    }
	
	function direccionUrl($url = null, $options = array()){
        $permissions = $this->Session->read('Base.Acl.permissions');
        if(!isset($permissions)){
            $permissions = array();
        }
        $aco_path = AclRouter :: aco_path($url);
        
        if(isset($permissions[$aco_path]) && $permissions[$aco_path] == 1){
            return true;
        }else{
            return null;
        }
    }
	
	
	
}