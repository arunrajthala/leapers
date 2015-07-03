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

	private $fields = array('uin', 'table', 'create', 'update', 'alter', 'delete', 'truncate', 'updatedBy', 'updatedOn');
	private $_uploadUrl = '';
//private $field_values=array();
//private $fields_update=array('title','detail','shortDesc','date','news01uin');
	private $update_fields = array('table', 'create', 'update', 'alter', 'delete', 'truncate');
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

		$qryFields = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . DB_NAME . "' AND TABLE_NAME = '" . $row['log01table'] . "'";

		$targeFields = $this->Query($qryFields);
		var_dump($targeFields);
		$arr['updatedBy'] = $user['us01uin'];
		$arr['updatedOn'] = date('Y-m-d H:i:s');
		$sqlTrigger = "CREATE TRIGGER `trig_update_test_add` AFTER UPDATE on `" . $row['log01table'] . "`
			FOR EACH ROW
			BEGIN
				DECLARE before_column_values varchar(255) DEFAULT '';
				DECLARE after_column_values varchar(255) DEFAULT ''; ";
		foreach ($targeFields as $field) {
			$sqlTrigger.="IF (NEW." . $field['COLUMN_NAME'] . " != OLD." . $field['COLUMN_NAME'] . ") THEN
before_column_values = concatenate(before_column_values, columnx, '=', OLD." . $field['COLUMN_NAME'] . ", '|');
after_column_values = concatenate(after_column_values, columnx, '=', NEW." . $field['COLUMN_NAME'] . ", '|');
END IF;";
		}

		$sqlTrigger.="INSERT INTO log02log(log02tablename, log02action, log02before, log02after)
VALUES
('xxx', 'yyy', before_column_values, after_column_values);
END";
		var_dump($sqlTrigger);
		die();
		//database independent cases
		return parent::update($id, $arr);
		//$this->update_core($id);
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
