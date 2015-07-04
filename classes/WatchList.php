<?php

//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class WatchList extends PDODatabase
{

	public $db;
	private $id;
	private $prefix = 'log01';
	private $current_right;
	private $current_user;
	private $tbl = 'watchlist';
//SELECT  `uin`,  `title`,  LEFT(`detail`, 256),  `shortDesc`,  `address`,  `phone`,  `url`,  `file`,  `cat01uin` FROM `poor`.`posts` LIMIT 1000;
	private $list_fields = array('UIN' => 'uin', 'Table' => 'table');
	private $upload_fields = array();
//private $uploadUrl=  'newstype/';

	private $fields = array('uin', 'table', 'create', 'update', 'delete', 'updatedBy', 'updatedOn');
	private $_uploadUrl = '';
//private $field_values=array();
//private $fields_update=array('title','detail','shortDesc','date','news01uin');
	private $update_fields = array('table', 'create', 'update', 'delete');
	private $file_fields = array('');

	/**
	 * Basic Function to get value from get/post method in a recursive way along with array_walk
	 * */
	public function __construct()
	{

		parent::__construct();
		$this->setMasterData($this->tbl, $this->fields, $this->prefix, $this->update_fields, $this->_uploadUrl, $this->file_fields);
	}

	public function getHighlights($per = 5, $page = 1)
	{
		return $this->get(array('highlight' => 1), '', $per, $page);
	}

	public function getLatest($per = 4, $page = 1)
	{
		return $this->get('', '', $per, $page);
	}

	public function getListField()
	{
		return $this->list_fields;
	}

	public function getFields()
	{
		return $this->fields;
	}

	public function getUpdateFields()
	{
		return $this->update_fields;
	}

	public function getPrefix()
	{
		return $this->prefix;
	}

	public function update($id, $arr)
	{
//var_dump($_SESSION);
//$objUser= new Users();
		global $objUser, $objDb;

		$user = $objUser->getCurrentUser();
		$row = $this->getByID($arr['uin']);

		if ($arr['create']) {

			$action = 'INSERT';
			$qryFields = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . DB_NAME . "' AND TABLE_NAME = '" . $row['log01table'] . "'";

			$targeFields = $this->Query($qryFields);
			$qryCheck = "select trigger_name from information_schema.triggers where event_object_table='" . $row['log01table'] . "';";
			$triggerList = $this->Query($qryCheck);

			if (!$triggerList) {
				$sqlTrigger = "CREATE TRIGGER  `trigger" . date('Y-m-d H:i:s') . "` AFTER " . $action . " ON `" . $row['log01table'] . "`
FOR EACH ROW
BEGIN ";
				foreach ($targeFields as $field) {

					$sqlTrigger .= "IF( NEW." . $field['COLUMN_NAME'] . " ) THEN
INSERT INTO log02log( `log02action` , `log02tablename` ,`log02field` , `log02before` , `log02after` ) VALUES ( 'insert', '" . $row['log01table'] . "', '" . $field['COLUMN_NAME'] . "', NEW." . $field['COLUMN_NAME'] . " );END IF ;";
				}
				$sqlTrigger .= "END;";
				$this->Query($sqlTrigger);
			}
			foreach ($triggerList as $trigger) {
				$triggerName = $trigger['trigger_name'];
				$sqlTriggerType = "select TRIGGER_NAME from information_schema.triggers where event_object_table='" . $row['log01table'] . "' and event_manipulation in('" . $action . "');";
				$triggerType = $this->Query($sqlTriggerType);
				if (!$triggerType) {

					$arr['updatedBy'] = $user['us01uin'];
					$arr['updatedOn'] = date('Y-m-d H:i:s');
					$sqlTrigger = "CREATE TRIGGER  `trigger" . date('Y-m-d H:i:s') . "` AFTER " . $action . " ON `" . $row['log01table'] . "`
FOR EACH ROW
BEGIN ";
					foreach ($targeFields as $field) {

						$sqlTrigger .= "IF( NEW." . $field['COLUMN_NAME'] . " ) THEN
INSERT INTO log02log( `log02action` , `log02tablename` ,`log02field` , `log02before` , `log02after` ) VALUES ( 'insert', '" . $row['log01table'] . "', '" . $field['COLUMN_NAME'] . "', NEW." . $field['COLUMN_NAME'] . " );END IF ;";
					}
					$sqlTrigger .= "END;";
					$this->Query($sqlTrigger);
				}
			}
		} elseif (!isset($arr['create'])) {

			$action = 'INSERT';
			$qryCheck = "select trigger_name from information_schema.triggers where event_object_table='" . $row['log01table'] . "';";
			$triggerList = $this->Query($qryCheck);

			foreach ($triggerList as $trigger) {
				$triggerName = $trigger['trigger_name'];
				$sqlTriggerType = "select TRIGGER_NAME from information_schema.triggers where event_object_table='" . $row['log01table'] . "' and event_manipulation in('" . $action . "');";
				$triggerType = $this->Query($sqlTriggerType);

				if ($triggerType) {

					$sqlDropTrigger = "Drop trigger `" . $triggerName . "`";

					$result = $this->Query($sqlDropTrigger);
				}
			}
			$arr['create'] = '0';
		}

		if ($arr['update']) {
			$action = 'UPDATE';

			$qryCheck = "select trigger_name from information_schema.triggers where event_object_table='" . $row['log01table'] . "';";
			$triggerList = $this->Query($qryCheck);
			if (!$triggerList) {
				$sqlTrigger = "CREATE TRIGGER  `trigger" . date('Y-m-d H:i:s') . "` AFTER " . $action . " ON `" . $row['log01table'] . "`
FOR EACH ROW
BEGIN ";
				foreach ($targeFields as $field) {

					$sqlTrigger .= "IF( NEW." . $field['COLUMN_NAME'] . " ) THEN
INSERT INTO log02log( `log02action` , `log02tablename` ,`log02field` , `log02before` , `log02after` ) VALUES ( 'insert', '" . $row['log01table'] . "', '" . $field['COLUMN_NAME'] . "', NEW." . $field['COLUMN_NAME'] . " );END IF ;";
				}
				$sqlTrigger .= "END;";
				$this->Query($sqlTrigger);
			}
			foreach ($triggerList as $trigger) {
				$triggerName = $trigger['trigger_name'];
				$sqlTriggerType = "select TRIGGER_NAME from information_schema.triggers where event_object_table='" . $row['log01table'] . "' and event_manipulation in('" . $action . "');";
				$triggerType = $this->Query($sqlTriggerType);
				var_dump('inserting update trigger', $triggerType);
				if (!$triggerType) {
					$qryFields = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . DB_NAME . "' AND TABLE_NAME = '" . $row['log01table'] . "'";

					$targeFields = $this->Query($qryFields);
					$arr['updatedBy'] = $user['us01uin'];
					$arr['updatedOn'] = date('Y-m-d H:i:s');
					$sqlTrigger = "CREATE TRIGGER  `trigger" . date('Y-m-d H:i:s') . "` AFTER " . $action . " ON `" . $row['log01table'] . "`
FOR EACH ROW
BEGIN ";
					foreach ($targeFields as $field) {

						$sqlTrigger .= "IF( NEW." . $field['COLUMN_NAME'] . " ) THEN
INSERT INTO log02log( `log02action` , `log02tablename` ,`log02field` , `log02before` , `log02after` ) VALUES ( 'insert', '" . $row['log01table'] . "', '" . $field['COLUMN_NAME'] . "', NEW." . $field['COLUMN_NAME'] . " );END IF ;";
					}
					$sqlTrigger .= "END;";
					$this->Query($sqlTrigger);
				}
			}
		} elseif (!isset($arr['udpate'])) {

			$action = 'UPDATE';
			$qryCheck = "select trigger_name from information_schema.triggers where event_object_table='" . $row['log01table'] . "';";
			$triggerList = $this->Query($qryCheck);
			//var_dump('here', $triggerList, $arr);
			foreach ($triggerList as $trigger) {
				$triggerName = $trigger['trigger_name'];
				$sqlTriggerType = "select TRIGGER_NAME from information_schema.triggers where event_object_table='" . $row['log01table'] . "' and event_manipulation in('" . $action . "');";
				$triggerType = $this->Query($sqlTriggerType);

				if ($triggerType) {

					$sqlDropTrigger = "Drop trigger `" . $triggerName . "`";

					$result = $this->Query($sqlDropTrigger);
				}
			}
			$arr['update'] = '0';
		}




		return parent::update($id, $arr);
	}

	public function validate($type)
	{
		if ($type == VALIDATE_INSERT)
			return $this->validate_insert;
		elseif ($type = VALIDATE_UPDATE)
			return $this->validate_update;
	}

	/**
	 * Custom Function to get value from get/post useful for this specific module
	 * */
	public function getByTableName($tableName, $page = 1, $per = 1000)
	{
		$data = $this->get(array('table' => $tableName), '', $per, $page);
//var_dump($data);
		return $data;
	}

}
