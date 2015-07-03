<?php
    /***************** these fields are required ************************************/
    $id=0;
    
    $prefix='us00';
    $data['prefix']=$prefix;
    $module_Title='User Type';  
    $data['module_Title']=$module_Title;
    $table=$prefix.'userType';
    $data['table']=$table;
    $message='';
    $data['message']='';
    $_id=$prefix.'uin';
    $data['_id']=$_id;
    $objUserModule= new userModule();
    //echo $userObj->getCurrentRight()+1;
    //var_dump($userObj->getCurrentRight());die();
    //$data['MyModules']=$MyModules;
    /**  
     *  $field_list :: This list is the list of all fields to be used for various puropse 
    **/
    $field_list=array('uin','title','rights');
    $obj=PrepareModule($prefix,$table,$field_list);
    $data['field_list']=$field_list;
    if(isset($_GET['_Id']))
    {
        $id=$_GET['_Id'];
        $data['_data']=$obj->getByID_v2($id);
    }
    else
    {
        $data['_data']=$obj->get_v2($prefix.'rights < '.$objUserModule->getCurrentRight(),$_id.' desc');
        $data['list_fields']=array('UIN'=>'uin','Title'=>'title','User Rights'=>'rights');
    }
    //var_dump($data);
    //$data['_extraModule']=array(array('User Module','userModule'));
    $_data=$obj->getByID_v2($id);
    //var_dump($_data);
    $upload_dir=UPLOADS_DIR.'Organization/';
    $data['upload_dir']=$upload_dir;
    $data['uploadUrl']='../uploads/Organization/';
/***************** END of these fields are required ************************************/
    /**  
     *  $fields_post :: This list is the list of all fields which are affected while inserting in database 
    **/
    $fields_post=array('title','rights');
    /**  
     *  $fields_edit :: This list is the list of all fields which are affected while updating database 
    **/
    $fields_edit=$fields_post;
    /**  
     *  generalprocess :: This will handle CRUD model
    **/
    if(isset($_POST['rights']))
    {
        $objUserModule= new userModule();
        #var_dump($objUserModule->getCurrentRight());
        #var_dump($_POST);
        if($_POST['rights']>$objUserModule->getCurrentRight()|| $_POST['rights']>100 )
        {
            $_POST['rights']=0;
        }
        //var_dump($_POST);
    }
    include_once(ADMIN_TPL_MODULE.'includes/generalprocess_v2.php');
    /**  
     *  other Process :: You can add code here for further Special  processing
    **/
?>