<?php

//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Option extends PDODatabase
{
    
    private $id;
    private $prefix = 'set01';
    private $current_right;
    private $current_user;
    private $tbl = 'settings';
    
    private $fields = array(
        'uin',
        'name',
        'sologon',
        'url',
        'email',
        'webmaster_email',
        'banner',
        'tel1',
        'tel2',
        'address',
        'fax',
        'address2',
        'map_code',
        'app_code',
        'admin_perpage',
        'site_perpage',
        'thumb_w',
        'thumb_h',
        'img_w',
        'img_h',
        'fb_id',
        'about');
    private $update_fields = array(
        'name',
        'sologon',
        'url',
        'email',
        'tel1',
        'tel2',
        'address',
        'fax',
        'address2',
        'map_code',
        'admin_perpage',
        'site_perpage',
        'thumb_w',
        'thumb_h',
        'img_w',
        'img_h',
        'fb_id',
        'about');
    private $uploadUrl = 'Admin/';
    
    private $file_fields = array('banner');

    public function __construct()
    {

        //$this->db = new PDODatabase();
        parent::__construct();
        $this->setMasterData_v2($this->tbl, $this->fields, $this->prefix, $this->uploadUrl, $this->file_fields);
        $x=$this->getById(1);
        //$x=$this->getFieldValues();
        //var_dump($this->db);
        //$x = ($this->getData());
        //var_dump($x);
        if (empty($x))
        {
            die('Application Error');
        }

    }

    /*public function get($where='', $strOrder = '',$intRecords=100, $intPage = 1,$_id = 0 )
    {
    $datas=$this->db->get($where, $strOrder ,$intRecords, $intPage,$_id);
    $this->data=$datas;
    return $datas;
    }*/
    public function getStatic()
    {
        return $this->fieldValues;
    }
    


    //'ID',  'user_login',  'user_pass',  'user_address',  'user_right',  'user_nicename',  'user_email',  'user_url',  'user_registered',  'user_activation_key',  'user_status',  'display_name',  'user_type'
    public function getFields()
    {
        return $this->fields;
    }
    public function getUploadURL()
    {
        return $this->uploadUrl;
    }

    public function validate($type)
    {
        if ($type == VALIDATE_INSERT)
            return $this->validate_insert;
        elseif ($type = VALIDATE_UPDATE)
            return $this->validate_update;
    }
    public function setFieldValues($fname, $value)
    {
        $this->fieldValues[$fname] = $value;
    }
    
    public function getPrefix()
    {
        return $this->prefix;
    }
    public function delete($id)
    {
        return $this->db->delete($id);
    }
    public function deleteFiles($arrFields)
    {
        //echo $this->id;
        $this->getById($this->id);
        $currVals = $this->db->getFieldValues();
        //var_dump($arrFields);
        //die();
        foreach ($arrFields as $f)
        {
            global $objMsg;

            //echo 'deleting file';
            //var_dump($this->db->getFieldValues());
            if ($currVals[$this->prefix . $f] != '')
            {
                if (file_exists(UPLOADS_DIR . $this->uploadUrl . DS . $currVals[$this->prefix .
                    $f]))
                {
                    $upload_result = unlink(UPLOADS_DIR . $this->uploadUrl . DS . $currVals[$this->
                        prefix . $f]);
                    if ($upload_result)
                    {
                        $this->db->setFieldValues($f, '');
                    } else
                    {
                        $objMsg->set('file not deleted');
                    }
                } else
                {
                    $objMsg->set(' no file');
                    $this->db->setFieldValues($f, '');
                }
            }

            //var_dump($arrFields);


        }
        return $this->db->update(1);
    }
    public function delete1($id)
    {
        //check for data
        //$this->db->where(array('uin' =>$user_id));
        //var_dump($mydate);die();
        $result = $this->db->delete($user_id);
        if ($result)
        {
            if (file_exists(UPLOADS_DIR . $this->uploadUrl . $mydate[$this->prefix . 'file']))
            {
                if (!unlink(UPLOADS_DIR . $this->uploadUrl . $mydate[$this->prefix . 'file']))
                    die('Cannot delete file');
                else
                {
                    if (file_exists(UPLOADS_DIR . $this->uploadUrl . 'thumb/' . $mydate[$this->
                        prefix . 'file']))
                    {
                        if (!unlink(UPLOADS_DIR . $this->uploadUrl . 'thumb/' . $mydate[$this->prefix .
                            'file']))
                            die('Cannot delete thumb');
                    }

                }
            }
        }
        return $result;
    }

    /*public function insert()
    {
        //$this->id=$sid;
        return $this->db->insert();
    }*/
    private function _get($where = '', $strOrder = '', $intRecords = 1000, $intPage =
        1, $_id = 0)
    {
        return $this->db->get($where = '', $strOrder = '', $intRecords = 1000, $intPage =
            1, $_id = 0);
    }
    public function getSecondLevelCat()
    {
        $eligible = $this->get($this->prefix . 'parent >0', $this->prefix . 'title asc');
        /*$result=array();
        foreach($eligible as $row)
        {
        $parent=$this->getParentByChild($row[$this->prefix.'uin']);
        if($parent[$this->prefix.'parent']!=0)
        {
        $result[]=$row;
        }
        }*/
        return $eligible;
    }


}
