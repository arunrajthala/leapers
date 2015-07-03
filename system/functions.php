<?php

/**
 * @author Arun Rajthala
 * @copyright 2009
 */

/**
 * Public function to make database Connection
 */
//include_once ('database.php');
/* function getCleanContent()
  {

  } */
function Connect()
{
	$conn = @mysql_connect(DB_HOST, DB_USER, DB_PASS);
	if (!$conn) {
		echo ('Unable to connect to database: ' . mysql_error());
		die();
	} else {
		$db = mysql_select_db($strDB);
	}
	$GLOBALS['CONN'] = $conn;
}

function changetime($starttime)
{
	$start = explode(":", $starttime);
	if ($start[0] >= 12 && $start[0] < 24) {
		$anc = "";
		/* if($start[0]>12){
		  $start[0]= $start[0]-12;} */
	} else {
		$anc = "";
	}

	$time = $start[0] . ":" . $start[1] . "&nbsp;" . $anc;
	return $time;
}

/**
 * Public function to make database query
 */
function Convert_EngYearToNep($day)
{
	//echo $day;

	switch ($day) {
		case '1':
			$day = "१";
			break;

		case '2':
			$day = "२";
			break;

		case '3':
			$day = "३";
			break;

		case '4':
			$day = "४";
			break;

		case '5':
			$day = "५";
			break;

		case '6':
			$day = "६";
			break;

		case '7':
			$day = "७";
			break;
		case '8':
			$day = "८";
			break;

		case '9':
			$day = "९";
			break;

		case '0':
			$day = "०";
			break;
		case ':':
			$day = ':';

		//$day=$day;
	}
	return $day;
}

function prepare_Eng_to_Nep($day)
{
	$result = '';
	$arr_chars = str_split($day);
	//var_dump($arr_chars);
	foreach ($arr_chars as $arr_char) {
		$result .= Convert_EngYearToNep($arr_char);
	}
	return $result;
}

function VD($resource)
{
	var_dump($resource);
}

function Query($strSql)
{
	//echo $strSql;
	$obj = new PDODatabase();
	$objRes = array();
	try {
		//connect as appropriate as above
		$objRes = $obj->db->query($strSql); //invalid query!
	} catch (PDOException $ex) {
		echo "An Error occured!"; //user friendly message
		die($ex->getMessage());
	}

	//$result = mysql_query($strSql) or die("Error :: ".$strSql.'<br>'.mysql_error());
	if ($objRes)
		return $objRes->fetchAll(PDO::FETCH_ASSOC);
	else
		return array();
}

function CountResource($result)
{
	return mysql_num_rows($result);
}

/**
 * Public function to make database query
 */
function MySQL_to_Array($arResult, $arFields)
{
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
 * load the specific module...
 */
function loadModule($strModuleName, $arrSharedData = array())
{
	//die();

	if (!file_exists(MODULES . $strModuleName . '.php')) {

		$strBlockContent = defaultModule($strModuleName, $arrSharedData);
	} else {

		ob_start();
		if (file_exists(MODULES . $strModuleName . '.php')) {

			include_once (MODULES . $strModuleName . '.php');
			//var_dump( $strModuleName);
		} elseif (file_exists(TPL . 'modules/' . $strModuleName . '.php'))
			include_once (TPL . 'modules/' . $strModuleName . '.php');
		else
			include_once (MODULES . $strModuleName . '.php');
		$strBlockContent = ob_get_contents();
		ob_end_clean();
	}
	$strReturn = <<< ARUN
                {$strBlockContent}
ARUN;
	return $strReturn;
}

function loadAdminModule($strModuleName, $arrSharedData = array())
{


	if (!file_exists(ADMIN_MODULE . 'modules/' . $strModuleName . '.php')) {
		$strBlockContent = defaultAdminModule($strModuleName, $arrSharedData);
	} else {
		ob_start();
		if (file_exists(ADMIN_MODULE . 'modules/' . $strModuleName . '.php')) {

			include_once (ADMIN_MODULE . 'modules/' . $strModuleName . '.php');
			//var_dump( $strModuleName);
		} elseif (file_exists(ADMIN_TPL_MODULE . $strModuleName . '.php'))
			include_once (ADMIN_TPL_MODULE . $strModuleName . '.php');
		else
			include_once (ADMIN_MODULE . $strModuleName . '.php');
		$strBlockContent = ob_get_contents();
		ob_end_clean();
	}
	$strReturn = <<< ARUN
        <div class="moduleWrapper mod{$strModuleName}">
            <div class="moduleContent">
                {$strBlockContent}
            </div>
        </div>
ARUN;
	return $strReturn;
}

/** function updated to received the shared data which can be passed to template... */
function defaultModule($strModuleName, $arrSharedData = array())
{
	if (!file_exists(TPL . 'modules' . DS . $strModuleName . '.php')) {

		$strModuleName = NOT_FOUND;
	}


	$strReturn = '';
	$objMain = new TemplateParser();
	$objMain->setTemplate(TPL . 'modules' . DS . $strModuleName . '.php');
	$objMain->setSharedData($arrSharedData);

	$strReturn = $objMain->returnContent();
	unset($objMain);
	return $strReturn;
}

function LoadDefaultModule_v2($strModuleName, $arrSharedData = array())
{
	if (!file_exists(TPL . 'modules' . DS . $strModuleName . '.php')) {

		$strModuleName = DEFAULT_VIEW;
	}


	$strReturn = '';
	$objMain = new TemplateParser();
	$objMain->setTemplate(TPL . 'modules' . DS . $strModuleName . '.php');
	$objMain->setSharedData($arrSharedData);

	$strReturn = $objMain->returnContent();
	unset($objMain);
	return $strReturn;
}

function defaultAdminModule($strModuleName, $arrSharedData = array())
{
	//echo 'loading default module '.$strModuleName.' '.ADMIN_TPL_MODULE.'modules'.DS.$strModuleName.'.php';die();
	if (!file_exists(ADMIN_TPL_MODULE . $strModuleName . '.php'))
		$strModuleName = NOT_FOUND;
	$strReturn = '';
	$objMain = new TemplateParser();
	$objMain->setTemplate(ADMIN_TPL_MODULE . $strModuleName . '.php');
	$objMain->setSharedData($arrSharedData);

	$strReturn = $objMain->returnContent();
	unset($objMain);
	return $strReturn;
}

function LoadDefaultAdminModule_v2($strModuleName, $arrSharedData = array())
{
	//echo 'loading default module '.$strModuleName.' '.ADMIN_TPL_MODULE.'modules'.DS.$strModuleName.'.php';die();
	if (!file_exists(ADMIN_TPL_MODULE . $strModuleName . '.php'))
		$strModuleName = DEFAULT_VIEW;
	$strReturn = '';
	$objMain = new TemplateParser();
	$objMain->setTemplate(ADMIN_TPL_MODULE . $strModuleName . '.php');
	$objMain->setSharedData($arrSharedData);

	$strReturn = $objMain->returnContent();
	unset($objMain);
	return $strReturn;
}

/**
 * Function to Load the TPL File and replace its variables
 */
function loadFormat($strFormat, $arrData)
{
	$content = '';
	if (is_array($arrData)) {
		$fileContents = $strFormat;

		foreach ($arrData as $k => $v) {
			$fileContents = getTemplateVal($fileContents, $k, $v);
		}
		$content = $fileContents;
	} else
		$content = false;

	return $content;
}

/**
 * Function to get the dot seperated value for templates
 * */
function getTemplateVal($strContent, $k, $v)
{
	if (is_array($v)) {
		foreach ($v as $k1 => $v1) {
			$strContent = getTemplateVal($strContent, $k . '.' . $k1, $v1);
		}
	} else {
		$strContent = str_replace('{' . $k . '}', $v, $strContent);
	}
	return $strContent;
}

function getLinks($strSection, &$arrData)
{
	$strReturn = '';
	switch ($strSection) {

	}
	return $strReturn;
}

/**
 * Function to get value from get/post method in a recursive way along with array_walk
 * */
function getRequestValList($arrFields)
{
	$data = array_fill_keys($arrFields, '');
	array_walk($data, 'getRequestVal');
	return $data;
}

/**
 * Function to get value from get/post method in a recursive way along with array_walk
 * */
function getRequestVal(&$item, $key)
{
	$item = getREQUEST($key);
}

/* function PrepareModule($prefix, $table, $field_list)
  {
  $obj = new PDODatabase();
  $obj->setMasterData($table, $field_list, $prefix);
  return $obj;
  } */

/**
 * Function to get value from get/post method
 * */
function getREQUEST($strVarName, $strDefaultVal = '')
{
	$strReturnVal = false;
	$strReturnVal = $strDefaultVal;
	if (isset($_GET[$strVarName]))
		$strReturnVal = getGPCFree($_GET[$strVarName]);
	elseif (isset($_POST[$strVarName]))
		$strReturnVal = getGPCFree($_POST[$strVarName]);
	elseif (isset($_COOKIE[$strVarName]))
		$strReturnVal = getGPCFree($_COOKIE[$strVarName]);
	return $strReturnVal;
}

/**
 * Function to get the selected method value. if gpc_add_slashes on it will strip slashed
 * */
function getGPCFree($strValue)
{
	if (get_magic_quotes_gpc()) {
		return stripValue($strValue);
	} else {
		return $strValue;
	}
}

function stripValue($arrVal)
{
	if (is_array($arrVal)) {
		foreach ($arrVal as $k => $v) {
			$retVal[$k] = stripValue($v);
		}
	} else {
		$retVal = stripslashes($arrVal);
	}
	return $retVal;
}

/**
 * Function to get HTML_Safe to print
 * */
function getHTMLSafe($strValue)
{
	return htmlentities($strValue, ENT_QUOTES);
}

/**
 * Function to get the DB Safe val
 * */
function getDBSafe($strValue)
{
	return mysql_escape_string($strValue);
}

/**
 * Function to redirect using javascript code
 * */
function forceRedirect($strLocation)
{

	echo '<script>window.location="' . str_replace('"', '\"', $strLocation) .
	'"</script>';
	die();
	header('location: ' . $strLocation);
	//die();
}

/**
 * Function to redirect using javascript code
 * */
function redirect($strLocation)
{

	echo '<script>window.location="' . str_replace('"', '\"', $strLocation) .
	'"</script>';
	header('location:' . $strLocation);
}

/**
 * Function to get the current timestamp for uinque id
 */
function getTimeStamp()
{
	$x = microtime();
	$x = preg_replace('/\./', '', $x);
	$x = preg_replace('/ /', '', $x);
	return $x;
}

/**
 * Function to resize the image n copy to new location
 */
function ImageResize($src, $dest, $thumbwidth, $thumbheight, $force = 0)
{
	$dimensions = GetImageSize($src);
	$w = $dimensions[0];
	$h = $dimensions[1];

	$nw = $thumbwidth;
	$nh = $thumbheight;

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
		/* $R = 255;
		  $G = 255;
		  $B = 255;
		  $bgcolor = imagecolorallocate($thumb, $R, $G, $B);
		  imagefill($thumb, 1, 1, $bgcolor);

		  imagecopyresampled($thumb, $img, 0, 0, 0, 0, $adjw, $adjh, $w, $h); */
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

/**
 * Function to get the file extensions
 */
function getFileExtension($strFileName, $addDot = false)
{
	$addDot = ($addDot) ? 0 : 1;
	return substr($strFileName, strrpos($strFileName, '.') + $addDot);
}

/**
 * Function to upload and extract the image
 * This function is made custumize
 * */
function AR_UploadImage($strFldName, $arrDestination, $arrSize, $strPrefix = '', $oldFileName = '', $arrAllowedTypes = '', $forceresize = 0, $version = 0)
{
	//echo $oldFileName;die();
	$strReturn = false;
	//var_dump($arrOldData);
	//For photo field ********************
	//$strFldName = $this->tbl_prefix.'file';
	if ($version == 0)
		$strFileField = $strPrefix . $strFldName;
	elseif ($version == 1)
		$strFileField = $strFldName;

	if (isset($_FILES[$strFileField]) && $_FILES[$strFileField]['size'] > 0) {
		$tmpName = $_FILES[$strFileField]['tmp_name'];
		$fileType = $_FILES[$strFileField]['type'];
		$fileExt = substr($_FILES[$strFileField]['name'], strrpos($_FILES[$strFileField]['name'], '.'));
		if ($oldFileName == '')
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
		//echo $extOnly;
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

		if (move_uploaded_file($tmpName, $tmpLoc . $newFileName)) {
			//copy($tmpLoc.$newFileName, $destLoc.$newFileName);
			{
				ImageResize($tmpLoc . $newFileName, $destLoc . $newFileName, $arrSize[0], $arrSize[1], $forceresize);
			}
			if (copy($destLoc . $newFileName, $destLoc . 'thumb/' . $newFileName)) {
				ar_image_forceresize($destLoc . 'thumb/' . $newFileName, THUMB_W, THUMB_H);
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
		$strReturn = array('false', $_FILES[$strFileField]['size']);
	}
	return $strReturn;
}

function AR_UploadAudio($strFldName, $arrDestination, $strPrefix = '', $oldFileName = '', $arrAllowedTypes = '', $forceresize = 0)
{
	$strReturn = false;
	//var_dump($arrOldData);
	//For photo field ********************
	//$strFldName = $this->tbl_prefix.'file';
	$strFileField = $strPrefix . $strFldName;

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
		//echo $extOnly;
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

function AR_UploadDocs($strFldName, $arrDestination, $strPrefix = '', $oldFileName = '', $arrAllowedTypes = '')
{
	$strReturn = false;
	//var_dump($arrOldData);
	//For photo field ********************
	//$strFldName = $this->tbl_prefix.'file';
	$strFileField = $strFldName;

	if (isset($_FILES[$strFileField]) && $_FILES[$strFileField]['size'] > 0) {
		///echo 'uploading file';
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
		//echo $extOnly;
		//Check the file type
		if (is_array($arrAllowedTypes)) {
			if (!in_array($extOnly, $arrAllowedTypes)) {
				return array(false, 'Invalid File Type...');
			}
		} elseif ($arrAllowedTypes != '' && $arrAllowedTypes !== $extOnly) {
			return array(false, 'Invalid File Type...');
		} else {
			$arrAllowedTypes = array('doc', 'docx', 'pdf');
			if (!in_array($extOnly, $arrAllowedTypes)) {
				return array(false, 'Invalid File Type...');
			}
		}

		if (move_uploaded_file($tmpName, $destLoc . $newFileName)) {
			$strReturn = array(true, $newFileName);
		}

		//if old data then delete the old file
	} else {
		echo 'file not uploading';
	}

	return $strReturn;
}

function validateUser($x)
{
	if ($x['txtUser'] == '') {
		echo '<br>Username required';
		return false;
	}
	if ($x['txtPass1'] == '') {
		echo '<br>Password required';
		return false;
	} else {
		if ($x['txtPass1'] != $x['txtPass2']) {
			echo '<br>New Passoword and Confirm Password doesnot match  ';
			return false;
		}
	}
	return true;
}

/**
 * php uploader by Arun Rajthala
 *
 * $filename is source file
 * $newname is the new unique name
 * $folder is the folder where source file is uploaded

 */
function uploadfile($toolname, $filename, $newname, $folder, $width, $height)
{
	if ((($_FILES[$toolname]["type"] == "image/gif") || ($_FILES[$toolname]["type"] ==
		"image/jpeg" || ($_FILES[$toolname]["type"] == "image/png") || ($_FILES[$toolname]["type"] ==
		"image/pjpeg")) && ($_FILES[$toolname]["size"] < 2000000))) {

		//echo $_POST['field'].$a.$_POST['fabric'].$_POST['prop'].$_POST['location'];
		if ($_FILES[$toolname]["error"] > 0) {
			echo "Return Code: " . $_FILES[$toolname]["error"] . "<br />";
			return "false";
		} else {
			//$a= substr($_FILES[$toolname]["name"],-3,3);

			if (file_exists($folder . $newname . $filename)) {
				echo "File already exists. ";
				$file = $newname . $filename;
			} else {
				if (move_uploaded_file($_FILES[$toolname]["tmp_name"], $folder . $newname)) {
					// echo "Upload Success";
					$file = $folder . $newname;
					ar_imageresize($file, $width, $height);
				} else {
					echo "Upload Unsuccess" . mysql_error();
				}
			}
			return $newname;
		}
	} else {
		if (isset($_FILES[$toolname]) && $_FILES[$toolname]["name"] != "") {
			$file = "";
			echo '<div class="headline1"> Invalid file</div>';
			return false;
		}
	}
}

/* * *******************************end*********************************** */

function ar_image_forceresize($filepath, $max_resize_width, $max_resize_height)
{
	global $mainframe;

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
			//			$res=imagej
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

function ar_imageresize($filepath, $max_resize_width, $max_resize_height, $force = 0)
{
	global $mainframe;
	$thumb_width = $max_resize_width;
	$thumb_heigth = $max_resize_height;
	$newfilename = $filepath;
	$max_width = $thumb_width;
	$max_height = $thumb_width;
	//Check if GD extension is loaded
	if (!extension_loaded('gd') && !extension_loaded('gd2')) {
		trigger_error("GD is not loaded", E_USER_WARNING);
		return false;
	}
	//Get Image size info
	$x = getimagesize($filepath);
	//var_dump($x);
	$width_orig = $x[0];
	$height_orig = $x[1];
	$image_type = $x[2]; //		list($width_orig,$height_orig,$image_type)=getimagesize($img);
	//echo $image_type;
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
		//echo "Source Image created !";
		$aspect_ratio = 1;
		if (!$force) {
			if (($width_orig >= $height_orig) || ($max_resize_height == 0) || ($max_resize_height == null)) {
				/*				 * * Calculate the thumnail width based on the height** */
				//echo 'Calculate the thumnail width based on the height';
				$aspect_ratio = (float) $height_orig / $width_orig;
				//$thumb_height=round($thumb_width *$aspect_ratio);
				$thumb_width = $max_resize_width;
				$thumb_height = round($thumb_width * $aspect_ratio);
			} else {
				/*				 * * Calculate the thumnail width based on the width** */
				//echo 'Calculate the thumnail height based on the width';
				$aspect_ratio = (float) $width_orig / $height_orig;
				//$thumb_width=round($thumb_height *$aspect_ratio);

				$thumb_height = $max_resize_height;
				$thumb_width = round($thumb_height * $aspect_ratio);
			}
		}

		//echo "<br>Width:".$thumb_width." Height:".$thumb_height." Aspect ratio:".$aspect_ratio;
		$newImg = imagecreatetruecolor($thumb_width, $thumb_height);
		imagecolortransparent($newImg, imagecolorallocate($newImg, 0, 0, 0));
		imagealphablending($newImg, false);
		imagecopyresampled($newImg, $im, 0, 0, 0, 0, $thumb_width, $thumb_height, $width_orig, $height_orig);
		//			$res=imagej
		/* Check if this image is PNG or GIF, then set if Transparent */
		if (($image_type == 1) || ($image_type == 3)) {
			imagealphablending($newImg, false);
			//imagsavealpha($newImg,false);
			$transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
			imagefilledrectangle($newImg, 0, 0, $thumb_width, $thumb_height, $transparent);
			imagecopyresampled($newImg, $im, 0, 0, 0, 0, $thumb_width, $thumb_height, $width_orig, $height_orig);
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

function getCurrentURL()
{
	return curPageURL();
}

function curPageURL()
{
	$pageURL = 'http';
	//if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}

function downlaod_file($file_path, $type, $file_name = '')
{
	/* Actual filename = 'attachment.zip' (Unknown to the viewers).
	  When downloaded to be saved as 'mydownload.zip'.
	 */
	//To download file
	//echo $file_path;die();
	//$filename='mydownload.zip';
	//@header("Content-type: application/zip");
	$ext = '';
	if ($type = 'audio/mpeg') {
		$ext = '.mp3';
	}
	if ($file_name == '') {
		$file_name = getTimeStamp() . $ext;
	}
	header('Content-Description: File Transfer');
	header('Cache-Control: public');
	header('Content-Type: ' . $type);
	header("Content-Transfer-Encoding: binary");
	header('Content-Disposition: attachment; filename=' . $file_name);
	header('Content-Length: ' . filesize($file_path));
	ob_clean(); #THIS!
	flush();
	//echo readfile($file_path);
	readfile($file_path);
	/* @header('Content-Transfer-Encoding: binary');
	  @header("Content-type: ".$type);
	  @header("Content-Disposition: attachment; filename=$file_name");


	 */
}

/* Actual filename = 'attachment.zip' (Unknown to the viewers).
  When downloaded to be saved as 'mydownload.zip'.
 */

//To download file
/*
  $filename='mydownload.zip';
  @header("Content-type: application/zip");
  @header("Content-Disposition: attachment; filename=$filename");
  echo file_get_contents('attachment.zip');
 */

function getSiteLink($module, $action = "", $query_string = "", $value = "", $value1 = "", $value2 = "", $SEO_Key = "")
{
	if ($module == '') {

		return curPageURL() . '#';
	}
	$ModuleList = array('About', 'Programs');
	global $siteName;
	//echo $module;
	$link = '';
	if ($SEO_Key) {
		//$newstr = preg_replace('/[^a-zA-Z0-9\']/', '_', $SEO_Key);
		//$SEO_Key = str_replace("'", '', $newstr);
		$SEO_Key = str_replace(' ', '-', $SEO_Key);
	}

	if (isset($module) && ($module == 'home')) {
		$link = BASE_URL;
		if ($value != "")
			$link .= $value;
		return $link;
		//echo $query_string;
	}
	elseif ($value2 != '') {
		$link = BASE_URL . "Page/$module/$value/$value1/$value2/";
	} elseif ($value1 != '') {
		$link = BASE_URL . "Page/$module/$value/$value1/";
	} elseif ($action == '' && $value == '') {
		$link = BASE_URL . "Page/$module/";
	} elseif (isset($module) && (in_array($module, $ModuleList))) {
		if ($action == "") {
			//Page/TripActivity/50/SIKKIM_-_KASTURI_LABDANG_TREK
			$link = BASE_URL . "Page/" . $module . "/$value/";
		}
	} elseif (isset($module) && ($module == 'tripcountry')) {
		//var_dump($_GET);die();
		if ($action == "") {
			$link = BASE_URL . "Page/TripCountries/$value/";
		}

		//var_dump( $link);die();
	} elseif (isset($module) && ($module == 'trips')) {
		//echo 'i am in trips';
		if ($action == "") {

			$link = BASE_URL . "Page/Trips/$value/";
		} //bookedForm
	} elseif (isset($module) && ($module == 'bookedForm')) {
		//echo 'i am in trips';
		if ($action == "") {
			$link = BASE_URL . "Page/bookedForm/$value";
		}
	} elseif (isset($module)) {
		if ($action == "") {
			$link = BASE_URL . "Page/$module/$value/";
		}
	}

	//$link = $siteName . "index.php?module=$module&action=$action";

	if ($query_string != "") {
		$link .= str_replace(' ', '-', $query_string);
		;
	}
	if ($SEO_Key) {
		$link .= $SEO_Key;
	}
	return $link;
}

function getAdminLink($module, $action = "", $keywords = "", $value = "", $value1 = "", $value2 = "")
{
	if ($module == '') {

		return curPageURL() . '#';
	}
	$ModuleList = array('About', 'Programs');
	global $siteName;
	//echo $module;
	$link = '';

	if (isset($module) && ($module == 'home')) {
		$link = ADMIN_URL;
		if ($value != "")
			$link .= $value;
		return $link;
		//echo $query_string;
	}
	elseif ($value2 != '') {
		$link = ADMIN_URL . "Page/$module/$value/$value1/$value2/";
	} elseif ($value1 != '') {
		$link = ADMIN_URL . "Page/$module/$value/$value1/";
	} elseif ($action == '' && $value == '') {
		$link = ADMIN_URL . "Page/$module/";
	} elseif (isset($module) && (in_array($module, $ModuleList))) {
		if ($action == "") {
			//Page/TripActivity/50/SIKKIM_-_KASTURI_LABDANG_TREK
			$link = ADMIN_URL . "Page/" . $module . "/$value/";
		}
	} elseif (isset($module) && ($module == 'tripcountry')) {
		//var_dump($_GET);die();
		if ($action == "") {
			$link = ADMIN_URL . "Page/TripCountries/$value/";
		}

		//var_dump( $link);die();
	} elseif (isset($module) && ($module == 'trips')) {
		//echo 'i am in trips';
		if ($action == "") {

			$link = ADMIN_URL . "Page/Trips/$value/";
		} //bookedForm
	} elseif (isset($module) && ($module == 'bookedForm')) {
		//echo 'i am in trips';
		if ($action == "") {
			$link = ADMIN_URL . "Page/bookedForm/$value";
		}
	} elseif (isset($module)) {
		if ($action == "") {
			$link = ADMIN_URL . "Page/$module/$value/";
		}
	}

	//$link = $siteName . "index.php?module=$module&action=$action";

	if ($keywords != "") {
		$link .= str_replace(' ', '_', $keywords);
		;
	}

	return $link;
}

function mail_attachment($from, $to, $subject, $message, $attachment)
{
	$fileatt = $attachment; // Path to the file
	$fileatt_type = "application/octet-stream"; // File Type
	$start = strrpos($attachment, '/') == -1 ? strrpos($attachment, '//') : strrpos($attachment, '/') + 1;
	$fileatt_name = substr($attachment, $start, strlen($attachment)); // Filename that will be used for the file as the attachment

	$email_from = $from; // Who the email is from
	$email_subject = $subject; // The Subject of the email
	$email_txt = $message; // Message that the email has in it

	$email_to = $to; // Who the email is to

	$headers = "From: " . $email_from . "
    ";
	//$headers = "From: ".$email_from;

	$file = fopen($fileatt, 'rb');
	$data = fread($file, filesize($fileatt));
	fclose($file);
	$msg_txt = "";

	$semi_rand = md5(time());
	$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
	$headers .= "Bcc: try_test_abc@yahoo.com";
	$headers .= "
    MIME-Version: 1.0
    " . "Content-Type: multipart/mixed;
    " . " boundary={$mime_boundary}";

	$email_txt .= $msg_txt;

	$email_message .= "This is a multi-part message in MIME format.

    " . "--{$mime_boundary}
    " . "Content-Type:text/html; charset='iso-8859-1'
    " . "Content-Transfer-Encoding: 7bit

    " . $email_txt . "

    ";

	$data = chunk_split(base64_encode($data));

	$email_message .= "--{$mime_boundary}
    " . "Content-Type: {$fileatt_type};
    " . " name='{$fileatt_name}'
    " . //"Content-Disposition: attachment;
		//" filename='{$fileatt_name}'

		"Content-Transfer-Encoding: base64

    " . $data . "

    " . "--{$mime_boundary}--
    ";

	$ok = mail($email_to, $email_subject, $email_message, $headers);

	if ($ok) {
		return ture;
	} else {
		return false;
		//	print "<b>Sorry Could not send</b>";
	}
}

function PageMe($url, $order, $perpage, $sql, $class, $p)
{
	$cnt = $this->count($this->exec($sql));
	if ($cnt > 0) {
		//resultset
		$pageNum = !empty($p) ? $p : 1;
		$pageNum = $pageNum < 1 ? 1 : $pageNum;
		$maxPage = ceil($cnt / $perpage);
		$pageNum = $pageNum > $maxPage ? $maxPage : $pageNum;
		$offset = ($pageNum - 1) * $perpage;
		$sql .=!empty($order) ? " " . $order : "";
		$sql = $sql . " LIMIT $offset, $perpage ";
		$res = $this->exec($sql);

		//link set
		$aend = "";
		$pageStart = ($pageNum > 5) ? $pageNum - 5 : 1;
		$pageEnd = ($pageNum > ($maxPage - 5)) ? $maxPage : $pageNum + 5;
		if ($pageNum > 1) {
			$page = 1;
			$nav[] = "<li><a href=\"$url&per=$perpage&p=$page/\" class=\"$class\">First</a></li>";
			$page = $pageNum - 1;
			$nav[] = "<li><a href=\"$url&per=$perpage&p=$page/\" class=\"$class\">Previous</a></li>";
		}

		($pageNum > 6) ? $nav[] = " ... " : "";

		for ($page = $pageStart; $page <= $pageEnd; $page++) {
			$nav[] = ($page == $pageNum) ? "<li class='active'><a href='#'> $page</a></li>" :
				"<li><a href=\"$url&per=$perpage&p=$page/\" class=\"$class\">" . $page .
				"</a><li>";
		}

		($pageNum > ($maxPage - 6)) ? "" : $nav[] = " ... ";

		if ($pageNum < $maxPage) {
			$page = $pageNum + 1;
			$nav[] = "<li><a href=\"$url&per=$perpage&p=$page/\" class=\"$class\">Next</a><li>";
			$page = $maxPage;
			$nav[] = "<li><a href=\"$url&per=$perpage&p=$page/\" class=\"$class\">Last</a><li>";
		}

		$ref = array(
			$offset + 1,
			$offset + $perpage,
			$cnt);

		return array(
			$res,
			$nav,
			$ref);
	} else
		return;
}

function Lang_filtered($strEng, $strNep)
{
	$output = '';
	if ($_SESSION['lang_type'] == '') {
		$output = $strEng;
	} else {
		$output = $strNep;
	}
	return $output;
}

function generateRandomString($length = 10)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+|';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
}

function export_excel_csv($arrResource, $fname = 'report')
{

	$file_type = "vnd.ms-excel";
	$file_ending = "xls";

	$Use_Title = 0;
	//header info for browser: determines file type ('.doc' or '.xls')

	header("Content-Type: application/$file_type");
	header("Content-Disposition: attachment; filename=$fname.$file_ending");
	header("Pragma: no-cache");
	header("Expires: 0");

	$sep = "\t"; //tabbed character
	foreach ($arrResource[0] as $paramName => $value)
		print $paramName . $sep;
	//print ();
	echo "\n";
	$sum = 0;
	foreach ($arrResource as $row) {
		$schema_insert = '';
		foreach ($row as $paramName => $value) {
			if ($paramName == 'Amount') {
				$sum += $value;
			}
			if ($paramName == 'Status') {
				$schema_insert .= getStrAccStatus($value) . $sep;
			} else {
				$schema_insert .= $value . $sep;
			}
		}

		$schema_insert = str_replace($sep . "$", "", $schema_insert);
		$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
		//var_dump($schema_insert);die();
		$schema_insert .= "\t";
		//var_dump($schema_insert);die();

		$schema_insert .= "\n";
		print (($schema_insert));
	}
	print ("\n\t\t\t\tGrand Total\t" . $sum);
	//var_dump($schema_insert);die();
}

function arrayToCsv($fields, $delimiter = ';', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false)
{
	$delimiter_esc = preg_quote($delimiter, '/');
	$enclosure_esc = preg_quote($enclosure, '/');

	$output = array();
	foreach ($fields as $field) {
		if ($field === null && $nullToMysqlNull) {
			$output[] = 'NULL';
			continue;
		}

		// Enclose fields containing $delimiter, $enclosure or whitespace
		if ($encloseAll || preg_match("/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field)) {
			$output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) .
				$enclosure;
		} else {
			$output[] = $field;
		}
	}

	return implode($delimiter, $output);
}

function export_excel_csv1($myArray, $fname = 'report')
{

	$num_fields = count($myArray[0]);
	var_dump($num_fields);
	//echo $num_fields;
	//if this parameter is included ($w=1), file returned will be in word format ('.doc')
	//if parameter is not included, file returned will be in excel format ('.xls')

	$file_type = "vnd.ms-excel";
	$file_ending = "xls";

	//header info for browser: determines file type ('.doc' or '.xls')
	header("Content-Type: application/$file_type");
	header("Content-Disposition: attachment; filename=$fname.$file_ending");
	header("Pragma: no-cache");
	header("Expires: 0");
	//return;
	/*    Start of Formatting for Word or Excel    */

	/*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */
	//create title with timestamp:
	//define separator (defines columns in excel & tabs in word)
	$sep = "\t"; //tabbed character
	//start of printing column names as names of MySQL fields
	for ($i = 0; $i < $num_fields; $i++) {
		echo key($myArray[0]) . "\t";
	}
	print ("\n");
	//end of printing column names
	//start while loop to get data
	foreach ($myArray as $row) {
		//var_dump($row);
		//set_time_limit(60); // HaRa
		$schema_insert = "";
		for ($j = 0; $j < $num_fields; $j++) {
			if (!isset($row[$j]))
				$schema_insert .= "NULL" . $sep;
			elseif ($row[$j] != "")
				$schema_insert .= "$row[$j]" . $sep;
			else
				$schema_insert .= "" . $sep;
		}
		$schema_insert = str_replace($sep . "$", "", $schema_insert);
		//following fix suggested by Josue (thanks, Josue!)
		//this corrects output in excel when table fields contain \n or \r
		//these two characters are now replaced with a space
		$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
		$schema_insert .= "\t";
		print (trim($schema_insert));
		print "\n";
	}
}

function Get_DOW($daynum)
{
	$daynames = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
	return $daynames[$daynum];
}

function Force_Downlaod($module, $file_name, $Type, $download_name = 'downloads')
{
	//var_dump($module);die();
	//header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
	$downloadPath = UPLOADS_DIR . $module . DS . $file_name;
	//echo $downloadPath;
	if ($Type == 'pdf') {
		if (file_exists($downloadPath)) :
			header('Pragma: public');   // required
			header('Expires: 0');	// no cache
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($downloadPath)) . ' GMT');
			header('Cache-Control: private', false);
			header('Content-Type: ' . 'application/pdf');
			header('Content-Disposition: attachment; filename="' . basename($downloadPath) . '"');
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: ' . filesize($downloadPath)); // provide file size
			header('Connection: close');
			readfile($downloadPath);  // push it out
			exit();
		else:
			echo 'file doesnt exist';
		endif;
		/* header('Content-Type: application/pdf');
		  header('Content-Length: ' . filesize($file_path));
		  readfile($file_path); */
	}
	else {
		header('Content-Type: application/octet-stream'); // or application/force-download
	}



	//

	echo $file_name;
	exit;
}

function LoadMyImage($url, $name, $alt = '', $class = '', $attrib = '')
{
	if ($name == '' || $name == '0') {
		return;
	}
	return '<img src="' . $url . $name . '" alt="' . $alt . '" class="' . $class . '" ' . $attrib . ' />';
}

function getFileExtensions($name)
{
	$fileExt = substr($name, strrpos($name, '.'));
	//$fileExt = substr($name, $name,'.'));
	return $fileExt;
}

function clipMyText($text, $charCount)
{

	$shortTry = substr(strip_tags($text), 0, $charCount);
	return substr($shortTry, 0, strrpos($shortTry, ' ', -1));
}

//}
?>