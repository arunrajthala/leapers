<?php 
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class NewsType extends PDODatabase
{
    public $db;
    private $id;
    private $prefix='news01';
    private $current_right;
    private $current_user;
	private $tbl='newstype';
	private $fields=array('uin','title','shortdesc','detail','sortOrder','backend','module','hasChild','url','isDefault','parent','file','menu','image');
    private $list_fields=array('UIN' => 'uin', 'Title' => 'title');
    private $update_fields=array('title','shortdesc','detail','sortOrder','backend','module','hasChild','url','isDefault','parent','menu');
    private $_uploadUrl=  'newstype/';
    private $formBuilder=array(
            'uin'=>         array('name'=>'uin', 'type'=>'hidden','label'=>'ID'),
            'title'=>       array('name'=>'title','type'=>'text','label'=>'Category Title'),
            'detail'=>      array('name'=>'detail','type'=>'textarea','label'=>'Detals','class'=>'ckeditor'),
            'sortOrder'=>   array('name'=>'sortOrder','type'=>'number','label'=>'Sort Order'),
            'hasChild'=>    array('name'=>'hasChild','type'=>'check','label'=>'Has Child'),
            'module'=>       array('name'=>'module','type'=>'text','label'=>'Unique Module Name'),
            'backend'=>     array('name'=>'backend','type'=>'check','label'=>'Visible in Backend','key'=>'ID','val'=>'title'),
            'url'=>         array('name'=>'url','type'=>'text','label'=>'URL'),
            'isDefault'=>    array('name'=>'isDefault','type'=>'check','label'=>'Default'),
            'parent'=>      array('name'=>'parent','type'=>'dropdown','label'=>'Category','key'=>'ID','val'=>'title'),
            'file'=>        array('name'=>'file','type'=>'file','label'=>'Icon'),
            'image'=>        array('name'=>'image','type'=>'file','label'=>'Image')
            );
    //private $field_values=array();
    private $file_fields=array('file','image');
    
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
	/*public function update($id,$arr_filedvalues)
    {
        $this->getByID($id);
        //var_dump($arr_filedvalues);
        
        foreach($this->update_fields as $_field)
        {
            
            $f=0;
            if(isset($arr_filedvalues[$_field]))
            {
                
                $f=$arr_filedvalues[$_field];
                if($f=='on')
                {
                    $f=1;
                }
                //var_dump( $f);
                $this->setFieldValues($_field,str_replace("'", "\"", $f));
                //var_dump( $f);
            }
            else
            {
                if($_field=='hasChild')
                {
                    $this->setFieldValues('hasChild',0);
                }
                if($_field=='backend')
                {
                    $this->setFieldValues('backend',0);
                }
                if($_field=='menu')
                {
                    $this->setFieldValues('menu',0);
                }
                //echo $_field; backend menu
            }
        }
        //var_dump($arr_filedvalues);die();
        //var_dump($this->field_values);
        $this->uploadFiles($this->file_fields);
        //echo 'hellow ';die();
        return $this->update_core($id);
    }*/
    
	private function _get($where='', $strOrder = '',$intRecords=1000, $intPage = 1,$_id = 0 )
	{
        return $this->get($where='', $strOrder = '',$intRecords=1000, $intPage = 1,$_id = 0 );
	}
    
    public function getByParent($id)
    {
        return $this->get(array('parent'=>$id));
    }
    
    public function getByModuleName($module)
    {
        $y= $this->get(array('module'=>$module));
        if(is_array($y))
        {
            
            return $y[0];
        }
        else
        {
            return array();
        }
    }
    
    
}