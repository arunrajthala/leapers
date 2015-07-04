<?php

/**
 * Created by PhpStorm.
 * User: walker
 * Date: 7/3/15
 * Time: 10:43 PM
 */
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Log extends PDODatabase
{

	public $db;
	private $id;
	private $prefix = 'log02';
	private $current_right;
	private $current_user;
	private $tbl = 'log';
	//SELECT  `uin`,  `title`,  LEFT(`detail`, 256),  `shortDesc`,  `address`,  `phone`,  `url`,  `file`,  `cat01uin` FROM `poor`.`posts` LIMIT 1000;
	private $list_fields = array('UIN' => 'uin', 'Tablename' => 'tablename');
	private $upload_fields = array();
	//private $uploadUrl=  'newstype/';

	private $fields = array('uin', 'tablename', 'field', 'action', 'before', 'after', 'updatedBy', 'updatedOn');
	private $_uploadUrl = '';
	//private $field_values=array();
	//private $fields_update=array('title','detail','shortDesc','date','news01uin');
	private $update_fields = array('tablename', 'field', 'action', 'before', 'after', 'updatedBy', 'updatedOn');
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

//    public function update($id, $arr)
//    {
//        //var_dump($_SESSION);
//        //$objUser= new Users();
//        global $objUser;
//        $user = $objUser->getCurrentUser();
//        $arr['updatedBy'] = $user['us01uin'];
//        $arr['updatedOn'] = date('Y-m-d H:i:s');
//
////        var_dump(parent::update($id, $arr)); exit();
//
//        //var_dump('arr',$arr);
//        $status = parent::update($id, $arr);
//
//        if ($status !== false) {
//            $sql = "CREATE TRIGGER " . "MysqlTrigger " . " BEFORE " . " UPDATE " . " ON " . " have_fun FOR EACH ROW SET NEW.title=UPPER(NEW.title);";
//        }
//        return parent::update($id, $arr);
//        //$this->update_core($id);
//    }

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
