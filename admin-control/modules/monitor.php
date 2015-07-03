<?php

$obj = new WatchList();
$objDb = new PDODatabase();
$tables = $objDb->Query('SHOW TABLES FROM ' . DB_NAME);
$data['module_Title'] = 'List of tables';
foreach ($tables as $table) {
	$tableData = $obj->getByTableName($table['Tables_in_db_hacker']);
	//var_dump('<pre>', $tableData, $table);
	if (empty($tableData)) {
		$result = $obj->insert(array('table' => $table['Tables_in_db_hacker']));
		//var_dump($result);
	}
}
/* * *************** these fields are required *********************************** */
//die();
//var_dump($MyModules);
$id = 0;
$message = '';
$data['module_Title'] = 'List of table';
$data['message'] = '';


if (isset($_GET['_Id'])) {
	$id = $_GET['_Id'];
	$data['_data'] = $obj->getByID($id);
} else {
	$data['_data'] = $obj->get();
	$data['list_fields'] = $obj->getListField();
}
//var_dump($data);
//$data['_extraModule'] = array(array('Commitments', 'Commit&action = Commitlist'));
$data['prefix'] = $obj->getPrefix();
$field_list = $obj->getUpdateFields();
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
