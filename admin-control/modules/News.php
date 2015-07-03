<?php
/***************** these fields are required ************************************/
//die();
//var_dump($MyModules);
$id = 0;
$Type=getREQUEST('Type');
$message='';

$data['message'] = '';

if(! $Type)
{
    forceRedirect('home.php');
}
$obj = new News();
$objCat= new NewsType();
$newsType=$objCat->getById($Type);
$data['module_Title'] = $newsType['news01title'];
if (isset($_GET['_Id']))
{
	$id = $_GET['_Id'];
	$data['_data'] = $obj->getByID($id);
}
else
{
	$data['_data'] = $obj->get(array('news01uin'=>$Type));
	$data['list_fields'] = $obj->getListField();
}
//$data['_extraModule'] = array(array('Commitments', 'Commit&action=Commitlist'));
$data['prefix']=$obj->getPrefix();
$field_list=$obj->getUpdateFields();
$_data = $obj->getByID($id);
//$data['obj']=$obj;
$data['lists']=$obj->getListField();
$upload_dir = UPLOADS_DIR . $obj->getUploadURL();
$data['upload_dir'] = $upload_dir;
$data['uploadUrl'] = '../uploads/'.$obj->getUploadURL();
/***************** END of these fields are required ************************************/
/**
 *  $fields_post :: This list is the list of all fields which are affected while inserting in database 
 **/

/**
 *  $fields_edit :: This list is the list of all fields which are affected while updating database 
 **/

/**
 *  generalprocess :: This will handle CRUD model
 **/
include_once (ADMIN_TPL_MODULE . 'includes/generalprocess_v3.php');
/**
 *  other Process :: You can add code here for further Special  processing
 **/
?>