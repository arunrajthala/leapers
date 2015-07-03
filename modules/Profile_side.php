<?php
    $prefix='pro01';
    $data['prefix']=$prefix;
    $module_Title='Profile';  
    $data['module_Title']=$module_Title;
    //$data['_module']='NewsType';
    $table='pro01profile';
    $data['table']=$table;
    $message='';
    $data['message']='';
    $_id=$prefix.'uin';
    $data['_id']=$_id;
    $id=0;
    $field_list=array($prefix.'uin',$prefix.'title',$prefix.'title_np',$prefix.'url',
                $prefix.'ad01uin',$prefix.'file',$prefix.'designation',$prefix.'designation_np');
    $obj=PrepareModule($prefix,$table,$field_list);
    
    $data['field_list']=$field_list;
    //$obj->setFieldValues()
    if(isset($_GET['_Id']))
    {
        $id=$_GET['_Id'];
        $data['_data']=$obj->getByID($id);
        //if(isset($_GET['']))
    }
    else
    {
        $data['_data']=$obj->get('',$_id.' desc');
        $data['list_fields']=array('UIN'=>$prefix.'uin','Title'=>$prefix.'title');
    }
        
    //var_dump($data['_data']);die();
    $_data=$obj->getByID($id);
    $data['upload_dir']=UPLOADS_DIR.'Profile/';
    $upload_dir=UPLOADS_DIR.'Profile/';
    $data['uploadUrl']='uploads/Profile/';
/***************** END of these fields are required ************************************/

    echo defaultModule( $strModuleName, $data );
?>