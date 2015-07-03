<?php

/**
 * @author Arun Rajthala
 * @copyright 2011
 */
// configuration file.
@session_start();
define('CLIENT_FOLDER', '');
define('ADMIN_FOLDER', 'admin-control');
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_hacker');
define('DB_USER', 'root');
define('DB_PASS', '');

require_once('database.php');
require_once('functions.php');
require_once('Option.php');

$objSetting = new Option();
$setPrefix = $objSetting->getPrefix();
$settings = $objSetting->getStatic();
define('ADMIN_EMAIL', $settings[$setPrefix . 'email']);
define('DS', DIRECTORY_SEPARATOR);
define('APP_NAME', $settings['set01name']);
define('APP_EMAIL', ADMIN_EMAIL);
define('APP_ADDRESS', $settings['set01address']);
define('APP_ADDRESS_2', $settings['set01address2']);
define('APP_PHONE', $settings['set01tel1']);
define('APP_PHONE_2', $settings['set01tel2']);
define('APP_KEYWORDS', '');
define('APP_META_DESC', '');

define('APP_ROOT', dirname(dirname(__FILE__)));
define('ABS_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/' . CLIENT_FOLDER);
define('ADMIN_URL', ABS_URL . ADMIN_FOLDER);


define('MODULES', APP_ROOT . DS . 'modules' . DS);
define('CLASSES', APP_ROOT . DS . 'classes' . DS);
define('UPLOADS_DIR', APP_ROOT . DS . 'uploads' . DS);
define('ADMIN_MODULE', APP_ROOT . DS . ADMIN_FOLDER . DS);
define('ADMIN_TPL_MODULE', ADMIN_MODULE . 'tpl' . DS);
define('ALBUM_DIR', UPLOADS_DIR . 'gallery_photos' . DS);
define('PHOTO_DIR', ALBUM_DIR . 'photos' . DS);
define('TPL', APP_ROOT . DS . 'tpl' . DS);
define('RADIO_PORT', '8142');
define('BASE_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/' . CLIENT_FOLDER);
define('BASE_ADMIN_URL', BASE_URL . ADMIN_FOLDER);
define('UPLOADS', BASE_URL . 'uploads/');

define('NOT_FOUND', '404');
define('UNAUTHORIZED', 'unauthorized');
define('DEFAULT_VIEW', 'default');
/* * **************** images and thumbs ********************************** */
define('THUMB_W', $settings[$setPrefix . 'thumb_w']);
define('THUMB_H', $settings[$setPrefix . 'thumb_h']);
define('IMAGE_W', $settings[$setPrefix . 'img_w']);
define('IMAGE_H', $settings[$setPrefix . 'img_h']);

define('AD_HOME_AD', 1);
define('AD_INNER', 2);
define('NEWS_PER_PAGE', $settings[$setPrefix . 'site_perpage']);

/* * **************** for admin users ********************************** */
define('ACCESS_VIEW', 1);
define('ACCESS_ADD', 2);
define('ACCESS_DELETE', 3);

define('NEWS_SCROLLING', 1);
define('NEWS_HIGHLIGHT', 2);


/* * **************** for types of news  ********************************** */

define('SORT_UP', 0);
define('SORT_DOWN', 1);

define('RESOURCE_AUDIO', 1);
define('RESOURCE_VIDEO', 2);
define('RESOURCE_DOCS', 3);
require_once('phpmailer' . DS . 'class.phpmailer.php');
require('TemplateEngine.php');
require('mail.php');
foreach (glob(CLASSES . "*.php") as $filename) {
	if ($filename != CLASSES . 'index.php') {
		require_once $filename;
	}
}
include_once(ADMIN_MODULE . 'modules/nepali_calendar.php');
$objUser = new Users();
$objSetting = new Setting();
$objMsg = new Message();
date_default_timezone_set('Asia/Katmandu');
?>