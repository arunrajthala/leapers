<?php

/* * *************** these fields are required *********************************** */
//die();
//var_dump($MyModules);
$id = 0;
$message = '';
$data['module_Title'] = 'Category';
$data['message'] = '';
$obj = new NewsType();
$allowed_module = array('About');

if (isset($_GET['_Id'])) {
	$id = $_GET['_Id'];
	$data['_data'] = $obj->getByID($id);
	if (!(in_array($data['_data'][$obj->getPrefix() . 'module'], $allowed_module))) {//$data['_data'][$obj->getPrefix().'module']!='about'&&$data['_data'][$obj->getPrefix().'module']!='syllabus')
		return;
	}
} else {
	forceRedirect(ADMIN_URL);
	return;
	//$data['_data'] = $obj->get('', $obj->getPrefix().'uin' . ' desc');
	//$data['list_fields'] = $obj->getListField();
}
//$data['_extraModule'] = array(array('Commitments', 'Commit&action=Commitlist'));
$data['prefix'] = $obj->getPrefix();
$field_list = array('detail');
;
$_data = $obj->getByID($id);
//$data['obj']=$obj;
$data['lists'] = $obj->getListField();
$upload_dir = UPLOADS_DIR . $obj->getUploadURL();
$data['upload_dir'] = $upload_dir;
$data['uploadUrl'] = '../uploads/' . $obj->getUploadURL();
/* * *************** END of these fields are required *********************************** */
/**
 *  $fields_post :: This list is the list of all fields which are affected while inserting in database
 * */
/**
 *  $fields_edit :: This list is the list of all fields which are affected while updating database
 * */
/**
 *  generalprocess :: This will handle CRUD model
 * */
include_once (ADMIN_TPL_MODULE . 'includes/generalprocess_v3.php');
/**
 *  other Process :: You can add code here for further Special  processing
 * */
?>