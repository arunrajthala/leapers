<?php

/**
 * @author HANCHYGUY
 * @author hanchyguy@yahoo.com
 * @copyright 2011
 * @license It can be used in any of your project at free of cost without removing this very comments
 * */
//require('system/functions.php');
//header('location: '.'admin-itech/');
error_reporting(1);

include_once 'system/config.php';

//forceRedirect(BASE_ADMIN_URL);
$myDb = new PDODatabase();

//getSiteLink('','');
if (!isset($_SESSION['page_id'])) {
	$_SESSION['page_id'] = 1;
}
if ($_GET) {
	//var_dump($_GET);
} else {
	$_SESSION['page_id'] = 1;
}
if (!isset($_SESSION['lang_type'])) {
	$_SESSION['lang_type'] = '';
}
#FrontEnd Modules and their templates. If no template is defined default template is taken. It can be referred as Controllers of Joomla
$arrFrontModules = array('Contact', 'Pages');
$arrFrontTemplate = array(
	'Home' => 'mainTemplate.inc',
	'Contact' => 'mainTemplate.inc',
	'Pages' => 'pagesTemplate.inc'
);
//var_dump($_GET);
$strModule = getREQUEST('module');
//
//
if (!in_array($strModule, $arrFrontModules))
	$strModule = 'Home';
//echo $strModule;die();
$strTemplate = array_key_exists($strModule, $arrFrontTemplate) ? $arrFrontTemplate[$strModule] : $arrFrontTemplate['Home'];
//echo $strTemplate;die();
ob_start();
include(TPL . $strTemplate);
//echo $strModule;die();
$strContent = ob_get_contents();
ob_end_clean();

echo $strContent;
?>
