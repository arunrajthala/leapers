<?php 
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setting  extends PDODatabase
{
   
    private $id;
    private $prefix='set01';
    private $current_right;
    private $current_user;
	private $tbl='settings';
    //SELECT  `uin`,  `title`,  LEFT(`detail`, 256),  `shortDesc`,  `address`,  `phone`,  `url`,  `file`,  `cat01uin` FROM `poor`.`posts` LIMIT 1000;
    private $list_fields=array();
    
    //private $uploadUrl=  'newstype/';
    
	private $fields=array('uin','about','name','sologon','url','email','webmaster_email','banner','tel1','tel2','address','fax','address2','about');
    private $_uploadUrl=  'admin/';
    private $file_fields=array('file');
    //private $fields_update=array('title','detail','shortDesc','date','news01uin');
    private $update_fields=array('name','about','sologon','url','email','banner','tel1','tel2','address','fax','address2');
/**
 * Basic Function to get value from get/post method in a recursive way along with array_walk
 * */   
	public function __construct()
    {	
        
	    parent::__construct();
       $this->setMasterData($this->tbl,$this->fields,$this->prefix,$this->update_fields,$this->_uploadUrl,$this->file_fields);
       
	}
	
    
    
    public function getListField()
    {
        return $this->list_fields;
    }
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
	
	
	
    /**
 * Custom Function to get value from get/post useful for this specific module
 * */   
    public function getBycode($id)
    {
        $objRes=$this->get(array('code'=>$id));
        $objRes = $objRes->fetch();
        return $objRes;
    }
     public function getByType($id,$page=1,$per=1000)
    {
        return $this->get(array('cat01uin'=>$id),'',$per,$page);
    }   
    
    
    
}