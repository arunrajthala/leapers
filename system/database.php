<?php

/* $con = mysql_connect(DB_HOST,DB_USER,"");
  mysql_select_db(DB_NAME, $con); */

class PDODatabase
{

	public $con;
	public $db;
	private $prefix;
	private $id;
	private $tbl;
	private $fields = array();
	private $uploadUrl = '';
	protected $_fileFields = array();
	public $fieldValues = array();
	private $updateFields = array();

	public function __construct()
	{
		try {
			$this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}

		return $this;
		//var_dump($this->con);
		//var_dump($this);
	}

	/* public function PDODatabase($prefix,$table,$field_Array)
	  {

	  $this->setMasterData($table,$field_Array,$prefix);
	  return self;
	  } */

	public function setMasterData($tbl_name, $field_list, $_prefix, $_update_fields, $_upload_URL, $file_fields = array())
	{
		$this->tbl = $_prefix . $tbl_name;
		$this->fields = $field_list;
		$this->fields = array_map('trim', $this->fields);
		$this->uploadUrl = $_upload_URL;
		$this->_fileFields = $file_fields;
		$this->updateFields = $_update_fields;
		//var_dump($this->fields);
		$this->prefix = $_prefix;
		$this->idField = $_prefix . 'uin';
	}

	public function setMasterData_v2($tbl_name, $field_list, $_prefix)
	{
		$this->tbl = $_prefix . $tbl_name;
		$this->fields = $field_list;
		$this->fields = array_map('trim', $this->fields);
		//var_dump($this->fields);
		$this->prefix = $_prefix;
		$this->idField = $_prefix . 'uin';
		//var_dump($this);
	}

	public function setFieldValues($fname, $value)
	{
		//echo $fname;
		//var_dump($this->field_values);
		$this->fieldValues[$this->prefix . trim($fname)] = addslashes(str_replace("'", "\"", $value));
	}

	public function resetFieldList()
	{
		$this->fieldValues = array();
		foreach ($this->fields as $_field) {
			$this->fieldValues[$this->prefix . $_field] = 0;
		}
		//  $this->field_values[$fname]=0;
	}

	public function resetFieldList_v2()
	{
		$this->fieldValues = array();
		foreach ($this->fields as $_field) {
			$this->fieldValues[$this->prefix . $_field] = 0;
		}
		//  $this->field_values[$fname]=0;
	}

	public function getData()
	{
		return self::$data;
	}

	/* public function setBulkFieldValues($_fieldValues)
	  {
	  $this->field_values=$_fieldValues;
	  } */

	/**
	 * select
	 * @param string $sql An SQL string
	 * @param array $array Paramters to bind
	 * @param constant $fetchMode A PDO Fetch mode
	 * @return mixed
	 */
	public function Query_AR($where = '', $strOrder = '', $intRecords = 100, $intPage = 1, $_id = 0)
	{
		//if(is_array($this))
		//$table=$this->fie;
		//var_dump($this);// $this->tbl;
		//echo $_id;
		$strWhere = $this->prefix . 'uin > 0 ';
		if ($this->tbl == '') {
			return false;
		}
		if ($_id > 0) {
			$strWhere.=' and ' . $this->prefix . 'uin =' . $_id;
		}
		if (is_array($this->fields)) {
			$strFields = implode(',', $this->fields);
		} else {
			return false;
		}
		if ($where != '') {
			$strWhere .= ' and ' . $where;
		}
		if ($strOrder != '') {
			$strOrder = 'order by ' . $strOrder;
		}
		$limit = sprintf(' limit %d, %d', ($intPage - 1) * $intRecords, $intRecords);


		$strSQL = "SELECT $strFields FROM $this->tbl where $strWhere $strOrder $limit";

		try {
			//connect as appropriate as above
			$statement = $this->db->prepare($strSQL);

			//$objRes = $statement->fetch();
			$objRes = $this->db->query($strSQL); //invalid query!
		} catch (PDOException $ex) {
			echo "An Error occured!"; //user friendly message
			some_logging_function($ex->getMessage());
		}
		//echo $strSQL;//die();
		//$objRes = mysql_query($strSQL) or die('Invalid SQL: '.mysql_error());
		//self::$data=$objRes;
		return $objRes;
	}

	public function update($id, $arr_filedvalues)
	{
		$this->getByID($id);
		var_dump($arr_filedvalues, $this->updateFields);
		//die();
		//var_dump($_POST);
		foreach ($this->updateFields as $_field) {
			if (isset($arr_filedvalues[$_field])) {
				$f = $arr_filedvalues[$_field];
				if (isset($arr_filedvalues[$_field])) {
					//var_dump($arr_filedvalues);die();
					//die();

					if ($f == 'on') {
						$f = 1;
					} else {
						$f = $arr_filedvalues[$_field];
					}
					$this->setFieldValues($_field, str_replace("'", "\\'", $f));
				}
			}
		}
		//var_dump($this->field_values);die();
		//var_dump($this->field_values);
		$this->uploadFiles($this->_fileFields);
		$result = $this->update_core($id);
		//die();
		return $result;
	}

	public function update_core($id)
	{
		//ksort($data);
		if ($id < 1) {
			return false;
		}
		$this->id = $id;
		$fieldDetails = NULL;

		$fieldDetails = $this->buildUpdateString($this->fieldValues);
		//var_dump($fieldDetails);
		$strSQL = "UPDATE $this->tbl SET $fieldDetails WHERE $this->idField=$this->id";
		//echo $strSQL;die();
		//die();mysql_error
		$statement = $this->db->prepare($strSQL);
		$objRes = $this->db->query($strSQL);
		//var_dump($objRes);die();
		return $objRes;
		/*
		  foreach ($data as $key => $value) {
		  $sth->bindValue(":$key", $value);
		  }

		  return $sth->execute();
		 */
	}

	public function get($where = '', $strOrder = '', $intRecords = 1000, $intPage = 1, $_id = 0)
	{
		$strWhere = $this->prefix . 'uin > 0 ';
		if ($this->tbl == '') {
			return false;
		}
		if ($_id > 0) {

			$strWhere.=' and ' . $this->prefix . 'uin =' . $_id;
		}
		if (is_array($this->fields)) {
			$strFields = $this->prefix . implode(',' . $this->prefix, $this->fields);
		} else {
			return false;
		}
		if ($where != '') {
			if (is_array($where)) {
				foreach ($where as $key => $value) {
					$where_arr[] = "$this->prefix" . "$key='$value'";
				}
				$strWhere .= ' and ' . implode(" and ", $where_arr);
				//echo $strWhere;
			} else {
				$strWhere .= ' and ' . $where;
			}
		}
		if ($strOrder != '') {

			$strOrder = 'order by ' . $strOrder;
		} else {
			if (in_array('sortOrder', $this->fields)) {
				$strOrder = 'order by ' . $this->prefix . 'sortOrder asc';
			} elseif (in_array('order', $this->fields)) {
				$strOrder = 'order by ' . $this->prefix . 'order asc';
			} else {
				$strOrder = 'order by ' . $this->prefix . 'uin desc';
			}
		}
		$limit = sprintf(' limit %d, %d', ($intPage - 1) * $intRecords, $intRecords);


		$strSQL = "SELECT $strFields FROM $this->tbl where $strWhere $strOrder $limit";
		//echo $strSQL;
		//$objRes = mysql_query($strSQL) or die('Invalid SQL: '.mysql_error());
		$statement = $this->db->prepare($strSQL);

		//$objRes = $statement->fetch();
		$objRes = $this->db->query($strSQL); //->execute();/
		//var_dump($objRes);
		if ($objRes)
			$objRes = $objRes->fetchAll(PDO::FETCH_ASSOC);
		else
			$objRes = array();
		return $objRes;
	}

	public function ArrangeOrder($id, $ArrangeType = 0)
	{
		$data = $this->getById($id);
		$order = $data[$this->prefix . 'order'];
		if ($ArrangeType == 0) {
			//sort up

			if ($data[$this->prefix . 'order'] != 0) {
				// process
				$finalOrder = $order - 1;
			} else {
				return false;
			}
		} else {
			//sort down
			$finalOrder = $order + 1;
		}
		$data1 = $this->getByOrder($finalOrder);
		foreach ($data1 as $row) {
			$datas_alt = $this->getById($row[$this->prefix . 'uin']);
			$this->update($row[$this->prefix . 'uin'], array('order' => $order));
		}
		$data = $this->getById($id);
		$this->setFieldValues('order', $finalOrder);
		return $this->update($id, array('order' => $finalOrder));
	}

	public function getByID($_id)
	{

		$strWhere = $this->prefix . 'uin > 0 ';
		if ($this->tbl == '') {
			return false;
		}
		if (is_array($this->fields)) {
			$strFields = $this->prefix . implode(',' . $this->prefix, $this->fields);
		} else {
			return false;
		}
		if ($_id > 0) {
			$strWhere.=' and ' . $this->prefix . 'uin =' . $_id;
		} else {
			return false;
		}

		$strSQL = "SELECT $strFields FROM $this->tbl where $strWhere limit 0,1";
		$statement = $this->db->prepare($strSQL);
		$objRes = $this->db->query($strSQL);
		if (!$objRes) {
			return array();
		}
		$objRes = $objRes->fetch(PDO::FETCH_ASSOC);
		foreach ($this->fields as $k) {
			$this->fieldValues[$this->prefix . $k] = $objRes[$this->prefix . $k];
		}
		return $objRes;
	}

	public function Fetch($resource)
	{
		if (is_resource($resource)) {
			return(mysql_fetch_assoc($resource));
		} else {
			if (is_array($resource))
				return $resource;
			else
				return false;
		}
	}

	public function QueryArray($strTable, $arFields = '*', $strWhere = '', $strOrder = '', $intRecords = 10, $intPage = 1)
	{
		$objRes = $this->db->query($strTable, $arFields, $strWhere, $strOrder, $intRecords, $intPage);
		return $this->MySQL_to_Array($objRes);
	}

	public function Query($sql)
	{
		return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * insert
	 * @param string $table A name of table to insert into
	 * @param string $data An associative array
	 */
	public function insert_core()
	{
		$fieldNames = implode('`, `', array_keys($this->fieldValues));
		$fieldValues = implode("', '", array_values($this->fieldValues));
		$strSQL = "INSERT INTO $this->tbl (`$fieldNames`) VALUES ('$fieldValues')";
		$statement = $this->db->prepare($strSQL);
		$objRes = $this->db->query($strSQL);
		$this->id = $this->db->lastInsertId($this->prefix . 'uin');
		return $this->id;
	}

	/* public function insert_v2()
	  {
	  $fieldNames = implode('`, `', array_keys($this->field_values));
	  $fieldValues = implode("', '", array_values($this->field_values));
	  $strSQL="INSERT INTO $this->tbl (`$fieldNames`) VALUES ('$fieldValues')";
	  //echo $strSQL;
	  $statement = $this->db->prepare($strSQL);
	  $objRes= $this->db->query($strSQL);
	  $this->id= $this->lastInsertId($this->prefix.'uin');
	  return $this->id;
	  //return mysql_insert_id();

	  } */

	public function getUploadURL()
	{
		return $this->uploadUrl;
	}

	/**
	 * update
	 * @param string $table A name of table to insert into
	 * @param string $data An associative array
	 * @param string $where the WHERE query part
	 */
	public function insert($arr_filedvalues)
	{

		$id = 0;
		foreach ($this->updateFields as $_field) {
			$f = 0;
			if (isset($arr_filedvalues[$_field])) {
				$f = $arr_filedvalues[$_field];
				if ($f == 'on') {
					$f = 1;
				}
				$this->setFieldValues($_field, str_replace("'", "\\'", $f));
			}
		}

		$id = $this->insert_core();

		$this->uploadFiles($this->_fileFields);
		return $id;
	}

	public function buildUpdateString($arrData, $strDelim = ', ')
	{
		$arrRows = array();
		foreach ($arrData as $key => $value) {
			$arrRows[] = "`$key`='$value'";
		}
		return implode($strDelim, $arrRows);
	}

	public function clearImage($id, $fields = array("file"))
	{
		global $objMsg;
		$prefix = $this->prefix;
		$mydate = $this->getById($id);
		foreach ($fields as $field) {
			if ($mydate[$prefix . $field] != '') {
				if (file_exists($upload_dir . $_data[$prefix . $field])) {
					if (!unlink($upload_dir . $_data[$prefix . $field]))
						die('Cannot delete file');
					else {

						if (file_exists($upload_dir . 'thumb/' . $_data[$prefix . $field])) {
							if (!unlink($upload_dir . 'thumb/' . $_data[$prefix . $field]))
								die('Cannot delete thumb');
						}
					}
				}
				$obj->db->setFieldValues($prefix . $field, '');
				$obj->db->update($this->id);
				$objMsg->set('File deleted');
				$data['_data'] = $obj->getByID($id);
				$strqry = '';
			}
		}
	}

	/**
	 * delete
	 *
	 * @param string $table
	 * @param string $where
	 * @param integer $limit
	 * @return integer Affected Rows
	 */
	public function delete($id)
	{
		$this->id = $id;
		$strSQL = "DELETE FROM $this->tbl WHERE  $this->idField=$this->id ";
		$statement = $this->db->prepare($strSQL);
		$objRes = $this->db->query($strSQL);
		return $objRes;
	}

	/**
	  Public function to make database query
	 */
	public function MySQL_to_Array($arResult, $arFields = '')
	{

		if (!is_array($arFields)) {
			$totFields = mysql_num_fields($arResult);
			$i = 0;
			while ($i < $totFields) {
				$arFields[] = mysql_field_name($arResult, $i++);
			}
		}

		$content = array();
		$i = 0;
		if (mysql_num_rows($arResult) > 0) {
			while ($row = mysql_fetch_assoc($arResult)) {
				foreach ($arFields as $field) {
					$content[$i][$field] = $row[$field];
					$content[$i][$field] = $content[$i][$field];
				}
				$i++;
			}
		} else {
			$content = false;
		}
		return $content;
	}

	/**
	 * Function to resize the image n copy to new location
	 */
	private function ImageResize($src, $dest, $thumbwidth, $thumbheight = 200, $force = 0)
	{
		$dimensions = GetImageSize($src);
		$w = $dimensions[0];
		$h = $dimensions[1];

		$nw = $thumbwidth;
		$nh = $thumbheight;
		//echo $dest;
		if (strtoupper(substr($dest, -3, 3)) == 'JPG' || strtoupper(substr($dest, -3, 3)) ==
			"PEG")
			$func = 'imagecreatefromjpeg';
		else
			$func = 'imagecreatefrom' . substr($dest, -3, 3);
		$img = $func($src);

		// icresampled (resource dst_image, resource src_image, int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h)

		if ($h < $nh && $w < $nw) {
			copy($src, $dest);
		} else {
			$factory = ($h / $nh);
			$factorx = ($w / $nw);
			$factor = max($factory, $factorx);
			$adjh = floor($h / $factor);
			$adjw = floor($w / $factor);
			$dsty = floor(($nh - $adjh) / 2);
			$dstx = floor(($nw - $adjw) / 2);
			// echo 'H: '.$h.', W: '.$w.', NH: '.$nh.', NW: '.$nw.', AdjH: '.$adjh.', AdjW: '.$adjw.', DstY: '.$dsty.', DstX: '.$dstx.'<br />'."\n";
			if ($force) {
				$adjw = $thumbwidth;
				$adjh = $thumbheight;
			}

			$thumb = imagecreatetruecolor($adjw, $adjh);
			if (strtoupper(substr($dest, -3, 3)) == 'PNG') {
				//$image = imagecreatefromjpeg($fileName);
				imagealphablending($thumb, false);
				imagesavealpha($thumb, true);
				//$image = imagecreatefrompng( $fileName );
				imagecopyresampled($thumb, $img, 0, 0, 0, 0, $adjw, $adjh, $w, $h);
				//imagepng($thumb, null, 100);
				imagepng($thumb, $dest, 1);
			} else {
				imagecopyresampled($thumb, $img, 0, 0, 0, 0, $adjw, $adjh, $w, $h);

				imagejpeg($thumb, $dest, 100);
			}
		}

		imagedestroy($img);
	}

	private function ar_image_forceresize($filepath, $max_resize_width, $max_resize_height)
	{
		global $mainframe;
		/*
		  $thumb_width=$max_resize_width;
		  $thumb_heigth=$max_resize_height;
		 */
		$newfilename = $filepath;
		$max_width = $max_resize_width;
		$max_height = $max_resize_width;
		//Check if GD extension is loaded
		if (!extension_loaded('gd') && !extension_loaded('gd2')) {
			trigger_error("GD is not loaded", E_USER_WARNING);
			return false;
		}
		//Get Image size info
		$x = (getimagesize($filepath));
		$width_orig = $x[0];
		$height_orig = $x[1];
		$image_type = $x[2]; //		list($width_orig,$height_orig,$image_type)=getimagesize($img);
		//echo $image_type;
		if ($width_orig == $max_resize_width && $height_orig == $max_resize_height) {
			//do nothing
			//echo 'Perfect size !!!';
		} else {
			switch ($image_type) {
				case 1:
					$im = imagecreatefromgif($filepath);
					break;
				case 2:
					$im = imagecreatefromjpeg($filepath);
					break;
				case 3:
					$im = imagecreatefrompng($filepath);
					break;
				default:
					trigger_error('Unsupported filetype !');
					break;
			}
			if ($im) {
				//echo "<br>Width:".$thumb_width." Height:".$thumb_height." Aspect ratio:".$aspect_ratio;
				$newImg = imagecreatetruecolor($max_resize_width, $max_resize_height);
				imagecolortransparent($newImg, imagecolorallocate($newImg, 0, 0, 0));
				imagealphablending($newImg, false);
				imagecopyresampled($newImg, $im, 0, 0, 0, 0, $max_resize_width, $max_resize_height, $width_orig, $height_orig);
				/* Check if this image is PNG or GIF, then set if Transparent */
				if (($image_type == 1) || ($image_type == 3)) {
					imagealphablending($newImg, false);
					//imagsavealpha($newImg,false);
					$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
					imagefilledrectangle($newImg, 0, 0, $max_resize_width, $max_resize_height, $transparent);
					imagecopyresampled($newImg, $im, 0, 0, 0, 0, $max_resize_width, $max_resize_height, $width_orig, $height_orig);
				}
				//Generate the file, and rename it to $newfilename
				//echo "new name :".$newfilename;
				switch ($image_type) {
					case 1:
						imagegif($newImg, $newfilename);
						break;
					case 2:
						imagejpeg($newImg, $newfilename);
						break;
					case 3:
						imagepng($newImg, $newfilename);
						break;
					default:
						trigger_error('Failed resize image !', E_USER_WARNING);
						break;
				}
				//echo "Thumb width:".$thumb_width."Thumb height:".$thumb_height;
			} else {
				echo "Source Image Not created !";
			}
		}
	}

	public function getFieldValues()
	{
		return $this->fieldValues;
	}

	public function uploadFiles($arrFields, $width = IMAGE_W, $height = IMAGE_H)
	{
		$currVals = $this->getFieldValues();
		//var_dump($arrFields );
		//die();
		foreach ($arrFields as $f) {
			if (isset($_FILES[$f])) {
				$upload_result = $this->AR_UploadImage($f, UPLOADS_DIR . $this->uploadUrl, array($width, $height));
				if (!$upload_result[0]) {
					$message = $upload_result[1];
				} else {
					$this->setFieldValues($f, $upload_result[1]);
				}
			}
		}
		$this->update_core($this->id);
	}

	public function AR_UploadImage($strFldName, $arrDestination, $arrSize, $strPrefix = '', $oldFileName = '', $arrAllowedTypes = '', $forceresize = 0, $version = 0)
	{

		if (isset($this->fieldValues[$this->prefix . $strFldName])) {
			$oldFileName = $this->fieldValues[$this->prefix . $strFldName];
		}

		//$oldFileName=$this->field_values[$this->prefix.$strFldName];
		$strReturn = false;

		//For photo field ********************
		//$strFldName = $this->tbl_prefix.$strFldName;

		$strFileField = $strFldName;

		if (isset($_FILES[$strFileField]) && $_FILES[$strFileField]['size'] > 0) {
			$tmpName = $_FILES[$strFileField]['tmp_name'];
			$fileType = $_FILES[$strFileField]['type'];
			$fileExt = substr($_FILES[$strFileField]['name'], strrpos($_FILES[$strFileField]['name'], '.'));

			if ($oldFileName == '') {
				$newFileName = getTimeStamp() . $fileExt;
			} else {

				if ($fileExt == substr($oldFileName, -strlen($fileExt))) {
					$newFileName = $oldFileName;
				} else {
					$newFileName = getTimeStamp() . $fileExt;
				}
			}

			$tmpLoc = UPLOADS_DIR;
			$destLoc = $arrDestination;
			$extOnly = substr($fileExt, 1);

			if (is_array($arrAllowedTypes)) {
				if (!in_array($extOnly, $arrAllowedTypes)) {
					return array(false, 'Invalid File Type...');
				}
			} elseif (trim($arrAllowedTypes) != '' && $arrAllowedTypes !== $extOnly) {
				return array(false, 'Invalid File Type...');
			} else {
				$arrAllowedTypes = array(
					'jpg',
					'jpeg',
					'gif',
					'png');
				//var_dump($arrAllowedTypes,$extOnly);
				if (!in_array(strtolower($extOnly), $arrAllowedTypes)) {
					return array(false, 'Invalid File Type...');
				}
			}


			//var_dump($this->field_values);die();
			if (move_uploaded_file($tmpName, $tmpLoc . $newFileName)) {
				//copy($tmpLoc.$newFileName, $destLoc.$newFileName);
				{
					$this->ImageResize($tmpLoc . $newFileName, $destLoc . $newFileName, $arrSize[0], $arrSize[1], $forceresize);
				}
				if (copy($destLoc . $newFileName, $destLoc . 'thumb/' . $newFileName)) {
					//$this->ar_image_forceresize($destLoc . 'thumb/' . $newFileName, THUMB_W, THUMB_H);//
					$this->ImageResize($destLoc . 'thumb/' . $newFileName, $destLoc . 'thumb/' . $newFileName, THUMB_W, THUMB_H);
					//die();
				} else {
					echo 'Thumb Not Created !';
				}

				//ar_imageresize($destLoc.$newFileName,$arrSize[0],$arrSize[1]);
				//Single string with location...
				//copy( $tmpLoc.$newFileName, $destLoc.$newFileName );

				unlink($tmpLoc . $newFileName);
			}
			$strReturn = array(true, $newFileName);
			//if old data then delete the old file
		} else {

		}
		//var_dump($strReturn);
		if ($strReturn) {
			$this->fieldValues[$this->prefix . $strFldName] = $newFileName;
			$this->update_core($this->id);
		}
		return $strReturn;
	}

	public function AR_UploadAudio($strFldName, $arrDestination, $strPrefix = '', $oldFileName = '', $arrAllowedTypes = '', $forceresize = 0)
	{
		$strReturn = false;

		//For photo field ********************

		$strFileField = $strFldName;
		if (isset($this->fieldValues[$this->prefix . 'file'])) {
			$oldFileName = $this->fieldValues[$this->prefix . 'file'];
		}
		//echo $oldFileName.' '.$strFileField ;die();
		if (isset($_FILES[$strFileField]) && $_FILES[$strFileField]['size'] > 0) {
			$tmpName = $_FILES[$strFileField]['tmp_name'];
			$fileType = $_FILES[$strFileField]['type'];
			$fileExt = substr($_FILES[$strFileField]['name'], strrpos($_FILES[$strFileField]['name'], '.'));
			if (!$oldFileName)
				$newFileName = getTimeStamp() . $fileExt;
			else {
				if ($fileExt == substr($oldFileName, -strlen($fileExt))) {
					$newFileName = $oldFileName;
				} else {
					$newFileName = getTimeStamp() . $fileExt;
				}
			}

			$tmpLoc = UPLOADS_DIR;
			$destLoc = $arrDestination;
			$extOnly = substr($fileExt, 1);

			//Check the file type
			if (is_array($arrAllowedTypes)) {
				if (!in_array($extOnly, $arrAllowedTypes)) {
					return array(false, 'Invalid File Type...');
				}
			} elseif ($arrAllowedTypes != '' && $arrAllowedTypes !== $extOnly) {
				return array(false, 'Invalid File Type...');
			} else {
				$arrAllowedTypes = array('mp3', 'wav');
				if (!in_array($extOnly, $arrAllowedTypes)) {
					return array(false, 'Invalid File Type...');
				}
			}

			if (move_uploaded_file($tmpName, $destLoc . $newFileName)) {
				$strReturn = array(true, $newFileName);
			}

			//if old data then delete the old file
		} else {

		}
		return $strReturn;
	}

	public function AR_UploadAudio1($strFldName, $arrDestination, $arrSize = 1, $strPrefix = '', $oldFileName = '', $arrAllowedTypes = '', $forceresize = 0, $version = 0)
	{

		if (isset($this->fieldValues[$this->prefix . $strFldName])) {
			$oldFileName = $this->fieldValues[$this->prefix . $strFldName];
		}


		$strReturn = false;

		//For photo field ********************


		$strFileField = $strFldName;

		if (isset($_FILES[$strFileField]) && $_FILES[$strFileField]['size'] > 0) {
			$tmpName = $_FILES[$strFileField]['tmp_name'];
			$fileType = $_FILES[$strFileField]['type'];
			$fileExt = substr($_FILES[$strFileField]['name'], strrpos($_FILES[$strFileField]['name'], '.'));
			//echo $fileExt;echo substr($oldFileName,  - strlen($fileExt)).' ';
			if ($oldFileName == '') {
				$newFileName = $this->getTimeStamp() . $fileExt;
			} else {

				if ($fileExt == substr($oldFileName, -strlen($fileExt))) {
					$newFileName = $oldFileName;
				} else {
					$newFileName = $this->getTimeStamp() . $fileExt;
				}
			}

			$tmpLoc = UPLOADS_DIR;
			$destLoc = $arrDestination;
			$extOnly = substr($fileExt, 1);

			//Check the file type
			if (is_array($arrAllowedTypes)) {
				if (!in_array($extOnly, $arrAllowedTypes)) {
					return array(false, 'Invalid File Type...');
				}
			} elseif ($arrAllowedTypes != '' && $arrAllowedTypes !== $extOnly) {
				return array(false, 'Invalid File Type...');
			} else {
				$arrAllowedTypes = array(
					'jpg',
					'jpeg',
					'gif',
					'png');
				if (!in_array($extOnly, $arrAllowedTypes)) {
					return array(false, 'Invalid File Type...');
				}
			}
			if (move_uploaded_file($tmpName, $tmpLoc . $newFileName)) { {
					$this->ImageResize($tmpLoc . $newFileName, $destLoc . $newFileName, $arrSize[0], $arrSize[1], $forceresize);
				}
				if (copy($destLoc . $newFileName, $destLoc . 'thumb/' . $newFileName)) {
					$this->ar_image_forceresize($destLoc . 'thumb/' . $newFileName, THUMB_W, THUMB_H);
				} else {
					echo 'Thumb Not Created !';
				}

				//ar_imageresize($destLoc.$newFileName,$arrSize[0],$arrSize[1]);
				//Single string with location...
				//copy( $tmpLoc.$newFileName, $destLoc.$newFileName );

				unlink($tmpLoc . $newFileName);
			}
			$strReturn = array(true, $newFileName);
			//if old data then delete the old file
		} else {

		}
		if ($strReturn) {
			$this->fieldValues[$this->prefix . $strFldName] = $newFileName;
			$this->update($this->id);
		}
		return $strReturn;
	}

	public function getUpdateFields()
	{
		return $this->updateFields;
	}

	public function getPrefix()
	{
		return $this->prefix;
	}

}
