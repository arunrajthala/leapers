<?php 
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users  extends PDODatabase
{
       private $id;
    private $prefix='us01';
    private $current_right;
    private $current_user;
	private $tbl='users';
	private $fields=array('uin','username','password','email','status','us00uin');
    private $list_fields=array('UIN' => 'uin', 'Title' => 'username');
    private $update_fields=array('username','password','email','us00uin','status');
    private $_uploadUrl=  '../uploads/Organization/';
    private $file_fields=array('file');
    
    private $validate_update=  array(
               array(
                     'field'   => 'username',
                     'label'   => 'User Name',
                     'rules'   => 'required'
                  ),
                  
               array(
                     'field'   => 'email',
                     'label'   => 'Email',
                     'rules'   => 'required|email'
                  ),   
               array(
                     'field'   => 'display_name',
                     'label'   => 'Disaplay Name',
                     'rules'   => 'required'
                  )
            );
    private $validate_insert=array(
                               array(
                                     'field'   => 'user_login',
                                     'label'   => 'username',
                                     'rules'   => 'required|is_unique[users.user_login]'
                                  ),
                               array(
                                     'field'   => 'user_pass',
                                     'label'   => 'New Password',
                                     'rules'   => 'required'
                                  ),
                               array(
                                     'field'   => 'user_pass2',
                                     'label'   => 'Confirmation Password',
                                     'rules'   => 'required|matches[user_pass]'
                                  ),   
                               array(
                                     'field'   => 'user_email',
                                     'label'   => 'Email',
                                     'rules'   => 'required|valid_email|is_unique[users.user_email]'
                                  ),   
                               array(
                                     'field'   => 'display_name',
                                     'label'   => 'Disaplay Name',
                                     'rules'   => 'required'
                                  )
                            );
    
	public function __construct()
    {	
	   parent::__construct();
       $this->setMasterData($this->tbl,$this->fields,$this->prefix,$this->update_fields,$this->_uploadUrl,$this->file_fields);
	   
       //var_dump($this->current_user);// $this->current_user;//die();
       
	}
    
	private function getRight($uid)
    {
        $data=$this->getByID(array('ID'=>$uid));
        //var_dump($data);
        $this->$current_right=$data['us01us00uin'];
    }
    
    public function getCurrentUser()
    {
        if(isset($_SESSION['LOGIN_ID']))
        {
            return $this->GetByUsername($_SESSION['LOGIN_ID']);
        }
            
        
           return false; 
        
            
        
    }
    public function getCurrentRight()
    {
        $data=$this->getByID($_SESSION['LOGIN_ID']);
        //var_dump($data);
        //$this->getRight($_SESSION['LOGIN_ID']);
        return $data['us01us00uin'];
    }
	//'ID',  'user_login',  'user_pass',  'user_address',  'user_right',  'user_nicename',  'user_email',  'user_url',  'user_registered',  'user_activation_key',  'user_status',  'display_name',  'user_type'
	public function getFields()
    {
        return $this->fields;
    }
    public function getListField()
    {
        return $this->list_fields;
    }
    
    public function getUpdateFields()
    {
        return $this->update_fields;
    }
    
    public function getPrefix()
    {
        return $this->prefix;
    }
    public function getUploadURL()
    {
        return $this->uploadUrl;
    }
    
    public function validate($type)
    {
            if($type==VALIDATE_INSERT)
                return $this->validate_insert;
            elseif($type=VALIDATE_UPDATE)
                return $this->validate_update;
    }
	
    public function update_user($id)
    {
        return $this->update($id);
    }
    
	public function edit($sid,$username)
	{
		//var_dump( $username);die();
        
        if($this->current_right < $this->fieldValues['user_right'])
            return false;
        
        $this->id=$sid;
        
        $this->select('*');
        //$this->from($this->tbl);
        $where = array("uin"=>$this->id,'user_login'=>$username,'user_right <='=>$this->current_right);
        $this->where($where);
        
        $query=$this->get($this->tbl);
        
        //echo 'i am here';
        
        
        $datarow=$query->row(0);
        if($datarow->user_login!=$this->fieldValues['user_login'])
            return false;
        //var_dump($datarow);die();
        $data= array();
        /*$this->where(array());
        $where = array("uin"=>$this->id);*/
        $this->where($where);
        //var_dump($this);die();
        if($this->fieldValues['user_pass']=='')
            $this->fieldValues['user_pass']=$datarow->user_pass;
        //var_dump($this->field_values);die();
        foreach ($this->fields as $field)
        {
            $data[$field]=$this->fieldValues[$field];
        }
        
		$result = $this->update($this->tbl, $data);
        if($result)
        {
            if(isset($_FILES['file']))
            {
                //echo 'uploading file';
                $upload_result=AR_UploadImage('file',$upload_dir,array(960,960),$prefix,$_data[$prefix.'file'],'','',1);
                //var_dump($upload_result);
                if(! $upload_result[0] )
                {
                    $message =$upload_result[1];
                }
                else
                {
                    if($upload_result[1]!=$_data[$prefix.'file'])
                    {
                        $obj->setFieldValues("file",$upload_result[1] );
                        $id = $obj->update($_POST['uin']);
                    }
                }
            }
        } 
        //var_dump($result);die();
		return $result;
        
	}
    public function delete($user_id)
	{
	   //check for data
       //die();
		if($user_id==$_SESSION['LOGIN_ID'])
            return false;
        $mydate=$this->getById($user_id);
        //$this->where(array('uin' =>$user_id));
        //var_dump($mydate);die();
        //$result=$this->db->delete($user_id);
        $this->id=$user_id;
		//$where=''
        $strSQL="DELETE FROM $this->prefix"."$this->tbl WHERE  $this->id_field=$this->id ";
        //echo $strSQL;die();
        $statement = $this->db->prepare($strSQL);
        $result= $this->db->query($strSQL); 
        //var_dump($strSQL,$result);die();
        if($result)
        {
            if(file_exists($this->uploadUrl.$mydate[$this->prefix.'file']))
            {
                if( !unlink($this->uploadUrl.$mydate[$this->prefix.'file']))
                    die('Cannot delete file');
                else
                {
                    if(file_exists($this->uploadUrl.'thumb/'.$mydate[$this->prefix.'file']))
                    {
                        if( !unlink($this->uploadUrl.'thumb/'.$mydate[$this->prefix.'file']))
                        die('Cannot delete thumb');
                    }
                    
                }
            }
        }
		return $result ;
	}
	
	private function _get($where='', $strOrder = '',$intRecords=1000, $intPage = 1,$_id = 0 )
	{
        return $this->get($where='', $strOrder = '',$intRecords=1000, $intPage = 1,$_id = 0 );
	}
    
    public function changePassword($opass,$pass1,$pass2)
    {
        $data=$this->getByID($_SESSION['LOGIN_ID']);
        //$this->where(array('uin'=>$this->session->userdata('user_id')));
        $datas= array();
        if(! $data)
        {
            return false;
        }
        else
        {
            $datas['user_pass']=$pass1;
        }
        $this->setFieldValues('password',sha1(md5(sha1(str_replace("'", "\\'", $f)))));
        $result = $this->update($data[$this->prefix.'uin']); 
        //var_dump($result);die();
		return $result;
    }
    public function GetByUsername($username)
    {
        $data=$this->get(array("username"=>$username));
        if(count($data)>0)
        {
            return $data[0];    
        }
        return array();
        
    }
    public function reset_Password($id)
    {
        //$data=$this->_get(array('uin'=>$id));
        $newPass=false;
        $datas=$this->get(array('uin'=>$id));
        $data= array();
        if(! $datas)
        {
            return false;
        }
        else
        {
            foreach($datas as $row)
            {
                $data=$row;
            }
            $newPass=generateRandomString();
            $this->setFieldValues('password',sha1(md5(sha1($newPass))));
            $data['user_pass']=$newPass;
            
        }
        $result = $this->update_core($id); 
        if($result)
        {
            $email= new Mail();
            $email->sendMail($data['us01email'],'Password Reset from '.APP_NAME,'Your password has been reset. Your new password is'.$newPass,'System','hanchyguy@yahoo.com') ;
            //
    		return $newPass;
        }
        else
        {
            return false;
        }
        
        
    }
    
    
}