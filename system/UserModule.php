<?php

/*$con = mysql_connect(DB_HOST,DB_USER,"");
mysql_select_db(DB_NAME, $con);*/
class userModule extends PDODatabase 
{
    private $objUser;
    private $objUserModule;
    private $id;
	private $userDetails;
    private $Rights=array();
    private $userType;
    private $prefix='us02';
    private $tbl='modules';
    private $fields=array('uin','set02uin','us01uin','view','add','delete');
    private $list_fields=array('UIN' => 'uin', 'Title' => 'username');
    private $update_fields=array('set02uin','us01uin','view','add','delete');
    private $_uploadUrl=  '../uploads/Organization/';
     
    public function __construct()
    {	
	   parent::__construct();
       $this->setMasterData($this->tbl,$this->fields,$this->prefix,$this->update_fields,$this->_uploadUrl);
	   $this->setUserData();
       //var_dump($this->current_user);// $this->current_user;//die();
       
	}
    
    public function userModule()
    {
        
    }
    public function setUserData()
    {
        if(! isset($_SESSION['LOGIN_ID']))
        {
            forceRedirect('index.php');
        }
        $this->objUser = new PDODatabase();
        $prefix='us01';    
        $table='users';
        
        $_id=$prefix.'uin';
        
        $field_list=array('uin','username','password','email','status','us00uin');
        $this->setMasterData($table,$field_list,$prefix,array(),'',array());
        
        //$this->objUser->setMasterData($table,$field_list,$prefix);
        //var_dump($this->objDb);
        //echo 'login id '.$_SESSION['LOGIN_ID'];
        $data=$this->get(array("username"=>$_SESSION['LOGIN_ID']));
        //var_dump($data);
        
            foreach($data as $row)
            {
                $this->userDetails=$row;
            }
        
        //var_dump($this->userDetails);
        $this->objUserModule = new PDODatabase();
        $prefix1='us02';    
        $table=$prefix1.'modules';
        $_id=$prefix1.'uin';
        
        $field_list=array($prefix1.'uin',$prefix1.'set02uin',$prefix1.'us01uin',$prefix1.'view',$prefix1.'add',$prefix1.'delete');
        $this->objUserModule->setMasterData($table,$field_list,$prefix1,array(),'',array());
        //var_dump($this->objDb);
        //echo 'login id '.$_SESSION['LOGIN_ID'];
        //echo $prefix1."set02uin='".$this->userDetails['us01uin']."'";
        $data=$this->objUserModule->get($prefix1."us01uin='".$this->userDetails['us01uin']."'");
        //var_dump($data);
        foreach($data as $row)
        {
            $QRY='SELECT S.*,M.* FROM set02modules S INNER JOIN us02modules M ON S.set02uin=M.us02set02uin;';
            //$QRY="select * from set02modules where set02uin=".$row[$prefix1.'set02uin'];
            $data=Query($QRY);
            foreach($data as $row)
            {
                $this->Rights[]=$row;
            }
            //echo $QRY;
        }
        //var_dump($this->Rights);
        //var_dump($this->userDetails);
    }
    public function CrossCheck($module)
    {
        if($this->userDetails['us01us00uin']>99)
        {
            return array(true,1,1,1);
        }
        $result_1=array(false,0,0,0);
        $doubleCheck=array('users','userModule','Report');
        $excludeModules=array(UNAUTHORIZED,'AdminChangePass','Commit');
        if(in_array($module,$excludeModules))
        {
            return array(true,1,0,0);
        }
        if(in_array($module,$doubleCheck))
        {
            $row_user=$this->objUser->getByID(getREQUEST('_Id'));
            //var_dump($row_user);
            if($row_user['us01us00uin']>$this->userDetails['us01us00uin'])
            {
                return array(false,0,0,0);
            }
            //var_dump($row_user);die();
        }
        //echo $this->userDetails['us01rights'];
        if($this->userDetails['us01us00uin']>99)
        {
            return array(true,1,1,1);
        }
        else
        {
            foreach($this->Rights as $row)
            {
                //var_dump($row);
                $result=array(false,0,0,0);
                if( in_array( $module, $row ) && $row['us02us01uin']==$this->userDetails['us01uin'])
                {
                    //var_dump($row);
                    $result[0]=true;
                    $result[ACCESS_VIEW]=$row['us02view'];
                    $result[ACCESS_ADD]=$row['us02add'];
                    $result[ACCESS_DELETE]=$row['us02delete'];
                    $result_1=$result;
                }
            }
        }
        //var_dump($result_1);
        //die();
        return $result_1;
    }
    public function getCurrentRight()
    {
        //var_dump($this->userDetails);die();
        return $this->userDetails['us01us00uin'];
    }
    public function getCurrentUser()
    {
        //var_dump($this->userDetails);die();
        return $this->userDetails['us01uin'];
    }
    public function resetFieldList()
    {
        $this->fieldValues=array();
        foreach($this->fields as $_field)
        {
            $this->fieldValues[$_field]=0;
        }
        //  $this->field_values[$fname]=0;
    }
    public function getFieldValues()
    {
        return $this->fieldValues;
    }
    
    
	
    
	
        

}