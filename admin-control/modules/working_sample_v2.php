<?php
    /***************** these fields are required ************************************/
    $prefix='org01';
    $data['prefix']=$prefix;
    $module_Title='Organization';  
    $data['module_Title']=$module_Title;
    $table=$prefix.'organization';
    $data['table']=$table;
    $message='';
    $data['message']='';
    $_id=$prefix.'uin';
    $data['_id']=$_id;
    $id=0;
    $data['MyModules']=$MyModules ;
    /**  
     *  $field_list :: This list is the list of all fields to be used for various puropse 
    **/
    $field_list=array('uin','title','file','detail',);
    $obj=PrepareModule($prefix,$table,$field_list);
    $data['field_list']=$field_list;
    if(isset($_GET['_Id']))
    {
        $id=$_GET['_Id'];
        $data['_data']=$obj->getByID_v2($id);
    }
    else
    {
        $data['_data']=$obj->get_v2('',$_id.' desc');
        $data['list_fields']=array('UIN'=>'uin','Title'=>'title');
    }
    $_data=$obj->getByID_v2($id);
    $upload_dir=UPLOADS_DIR.'Organization/';
    $data['upload_dir']=$upload_dir;
    $data['uploadUrl']='../uploads/Organization/';
/***************** END of these fields are required ************************************/
    /**  
     *  $fields_post :: This list is the list of all fields which are affected while inserting in database 
    **/
    $fields_post=array('title','detail');
    /**  
     *  $fields_edit :: This list is the list of all fields which are affected while updating database 
    **/
    $fields_edit=$fields_post;
    /**  
     *  generalprocess :: This will handle CRUD model
    **/
    include_once(ADMIN_TPL_MODULE.'includes/generalprocess_v2.php');
    /**  
     *  other Process :: You can add code here for further Special  processing
    **/
?>