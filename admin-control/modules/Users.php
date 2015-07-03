<?php

/* * *************** these fields are required *********************************** */
$id = 0;

$prefix = 'us01';
$data['prefix'] = $prefix;
$module_Title = 'Sytstem users';
$data['module_Title'] = $module_Title;
$table = $prefix . 'users';
$data['table'] = $table;
$message = '';
$data['message'] = '';
$_id = $prefix . 'uin';
$data['_id'] = $_id;
$data['list'] = array();
$objUserModule = new userModule();

/**
 *  $field_list :: This list is the list of all fields to be used for various puropse
 * */
$field_list = array('uin', 'username', 'password', 'email', 'status', 'us00uin');
$obj = new Users();
$data['field_list'] = $field_list;
if (isset($_GET['_Id'])) {
	$id = $_GET['_Id'];
	$data['_data'] = $obj->getById($id);
} else {
	$data['_data'] = $obj->get($prefix . 'us00uin < ' . $objUserModule->getCurrentRight(), $_id . ' desc');
	//var_dump($data);
	$data['list_fields'] = array('UIN' => 'uin', 'User' => 'username');
	$data['lists'] = $data['list_fields'];
}

//var_dump($data);
$data['_extraModule'] = array(array('User Module', 'userModule'), array('ResetPassword', 'resetPass'));
$_data = $obj->getById($id);
$upload_dir = UPLOADS_DIR . 'Organization/';
$data['upload_dir'] = $upload_dir;
$data['uploadUrl'] = '../uploads/Organization/';
/* * *************** END of these fields are required *********************************** */
/**
 *  $fields_post :: This list is the list of all fields which are affected while inserting in database
 * */
$fields_post = array('username', 'email', 'us00uin');
/**
 *  $fields_edit :: This list is the list of all fields which are affected while updating database
 * */
$fields_edit = $fields_post;
/**
 *  generalprocess :: This will handle CRUD model
 * */
if (isset($_POST['us00uin'])) {
	$objUserModule = new userModule();
	#var_dump($objUserModule->getCurrentRight());
	#var_dump($_POST);
	if ($_POST['us00uin'] > $objUserModule->getCurrentRight()) {
		$_POST['us00uin'] = 0;
	}
	//var_dump($_POST);
}
include_once(ADMIN_TPL_MODULE . 'includes/generalprocess_v3.php');
/**
 *  other Process :: You can add code here for further Special  processing
 * */
?>