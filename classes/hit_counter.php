<?php 
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class HitCounter extends PDODatabase
{
    public $db;
    private $id;
    private $prefix='news03';
    private $current_right;
    private $current_user;
	private $tbl='hitcounter';
	private $fields=array('uin','news02uin','ip_add','agent');
    private $list_fields=array('UIN' => 'uin', 'Title' => 'title');
    private $update_fields=array('news02uin','ip_add','agent');
    private $file_Array=array('file');
    private $_uploadUrl=  'admin/';
    private $file_fields=array('file');
    
    
	public function __construct()
    {	
        
	   parent::__construct();
       $this->setMasterData($this->tbl,$this->fields,$this->prefix,$this->update_fields,$this->_uploadUrl,$this->file_fields);
       
	}
	
    
    public function getListField()
    {
        return $this->list_fields;
    }
	//'ID',  'user_login',  'user_pass',  'user_address',  'user_right',  'user_nicename',  'user_email',  'user_url',  'user_registered',  'user_activation_key',  'user_status',  'display_name',  'user_type'
	public function getFields()
    {
        return $this->fields;
    }
    public function getUpdateFields()
    {
        return $this->update_fields;
    }
    
    public function getPrefix()
    {
        return $this->prefix;
    }
    public function validate($type)
    {
            if($type==VALIDATE_INSERT)
                return $this->validate_insert;
            elseif($type=VALIDATE_UPDATE)
                return $this->validate_update;
    }
    public function getByIpPost($ip,$postId)
    {
        return $this->get(array('ip_add'=>$ip,'news02uin'=>$postId));
    }
    public function CheckHitsByIpPost($ip,$postId)
    {
        $result=true;
        $d= $this->get(array('ip_add'=>$ip,'news02uin'=>$postId));
        if(count($d)>0)
        {
            $result= false;
        }
        return $result;
    }
    
    
    
}