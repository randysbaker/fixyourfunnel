<?php
/******************************************************
 * Created by: Randy S. Baker
 * Created on: 17-MAR-2020
 * -----------------------------------------------------
 * Core Functions (functions.php)
 ******************************************************/

/*************************************************
 * Helper functions...
 *************************************************/
require_once ('functions.helper.php');

/************************************
 * Authenticate a user...
 ************************************/
if (!function_exists('userAuthenticate'))
{
	function userAuthenticate($arrLoginData=array())
	{
		global $sqli;
		$arrData = array();
		$arrFields = getTableFields(USER_TABLE);
		$strEmail = $sqli->real_escape_string($arrLoginData['email']);
		$strPass = $sqli->real_escape_string($arrLoginData['pass']);
		$sql = "SELECT ".implode(',', $arrFields)." FROM `".USER_TABLE."` WHERE `email`='{$strEmail}' AND `password`='{$strPass}' AND `confirmed`=1 AND `status` != 86 LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		if ($sqli->affected_rows > 0)
		{
			$row = $res->fetch_assoc();
			foreach ($arrFields as $key => $val)
			{
				$arrData[$val] = $row[$val];
			}
			$arrData['is_auth'] = 1;
			$arrData['is_online'] = 1;
			$_SESSION['sys_user'] = $arrData;
			saveToLog($_SESSION['sys_user']['email'].' - Logged In...');
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Get the user name via ID...
 ************************************/
if (!function_exists('getUserName'))
{
	function getUserName($intID=0)
	{
		global $sqli;
		$strData = '';
		$intID = $sqli->real_escape_string($intID);
		$sql = "SELECT `first_name`,`last_name` FROM `".USER_TABLE."` WHERE `id`='{$intID}' LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		$strData = $row['first_name'] .' '. $row['last_name'];
		closeMeUp($res);
		return $strData;
	}
}

/************************************
 * Get user data...
 ************************************/
if (!function_exists('getUserData'))
{
	function getUserData($intID=0)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(USER_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM `".USER_TABLE."` WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		foreach ($arrFields as $key => $val)
		{
			$arrData[$val] = $row[$val];
		}
		$arrData['updated'] = $row['updated'];
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Generate gallery image list...
 ************************************/
if (!function_exists('filterGalleryImageList'))
{
	function filterGalleryImageList($arrFilters=array())
	{
		global $sqli;
		$sqlSearch = '';
		$sqlSort = '`id` DESC';
		$arrData = array();
		if (!empty($arrFilters))
		{
			if (isset($arrFilters['gallery_search']) && $arrFilters['gallery_search'] != '')
			{
				$strSearch = $sqli->real_escape_string($arrFilters['gallery_search']);
				$sqlSearch = "AND `image_title` LIKE '%{$strSearch}%'";
			}

			if (isset($arrFilters['filter_posted']) && $arrFilters['filter_posted'] > 0)
			{
				switch ($arrFilters['filter_posted'])
				{
					case 1:
						$sqlSort = "`id` ASC";
						break;
					case 2:
						$sqlSort = "`id` DESC";
						break;
					default:
						$sqlSort = "`id` ASC";
						break;
				}
			}
			$arrFields = getTableFields(IMAGE_TABLE);
			$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM `".IMAGE_TABLE."` WHERE `status` != 86 {$sqlSearch} ORDER BY {$sqlSort};";
			$res = $sqli->query($sql) or die($sqli->error);
			while ($row = $res->fetch_assoc())
			{
				$arrTemp = array();
				foreach ($arrFields as $key => $val)
				{
					$arrTemp[$val] = $row[$val];
				}
				$arrTemp['updated'] = $row['updated'];
				$arrData[$row['id']] = $arrTemp;
			}
			closeMeUp($res);
		}
		return $arrData;
	}
}

/************************************
 * Generate galleryimage list...
 ************************************/
if (!function_exists('generateGalleryImageList'))
{
	function generateGalleryImageList($intID=0)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(IMAGE_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM `".IMAGE_TABLE."` WHERE `status` != 86;";
		$res = $sqli->query($sql) or die($sqli->error);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			foreach ($arrFields as $key => $val)
			{
				$arrTemp[$val] = $row[$val];
			}
			$arrTemp['updated'] = $row['updated'];
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Get gallery image data...
 ************************************/
if (!function_exists('getGalleryImageData'))
{
	function getGalleryImageData($intID=0)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(IMAGE_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM ".IMAGE_TABLE." WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		foreach ($arrFields as $key => $val)
		{
			$arrData[$val] = $row[$val];
		}
		$arrData['updated'] = $row['updated'];
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Add a new gallery image...
 ************************************/
if (!function_exists('addGalleryImageData'))
{
	function addGalleryImageData($arrData=array())
	{
		global $sqli;
		$strSQL = "";
		$intLastID = 0;
		foreach ($arrData as $key => $val)
		{
			if ($key != 'action')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "`{$key}`='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "INSERT INTO `".IMAGE_TABLE."` SET {$strSQL},`date_added`=NOW();";
		$res = $sqli->query($sql) or die($sqli->error);
		$intLastID = $sqli->insert_id;
		closeMeUp($res);
		return $intLastID;
	}
}

/************************************
 * Save a gallery image ...
 ************************************/
if (!function_exists('saveGalleryImageData'))
{
	function saveGalleryImageData($intID=0, $arrData=array())
	{
		global $sqli, $arrSanitizeFields;
		$strSQL = "";
		$intID = $sqli->real_escape_string($intID);
		foreach ($arrData as $key => $val)
		{
			if ($key != 'id' && $key != 'action' && $key != 'btnSubmit' && $key != 'btnCancel')
			{
				if (in_array($key, $arrSanitizeFields))
				{
					$val = str_ireplace('$', '', $val);
					$val = str_ireplace('%', '', $val);
					$val = str_ireplace(',', '', $val);
				}
				$strSQL .= "{$key}='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "UPDATE `".IMAGE_TABLE."` SET {$strSQL} WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		closeMeUp($res);
		return;
	}
}

/*************************************
 * Upload gallery image...
 *************************************/
if (!function_exists('processFileUpload'))
{
	function processFileUpload($arrData=array(), $arrFileData=array(), $intID=0)
	{
		global $sqli;
		$intID = $sqli->real_escape_string($intID);
		if (count($arrFileData) > 0)
		{
			$data = toObject($arrData);
			if (isset($arrFileData['image_file']['name'][0]) && $arrFileData['image_file']['name'][0] != '')
			{
				if ($arrFileData['image_file']['error'][0] == '0')
				{
					$tmpFilename = $arrFileData['image_file']['tmp_name'][0];
					$strFilename = 'gallery-image-'.$intID.'-'.$arrFileData['image_file']['name'][0];
					$strFilename = makeSafeFilename($strFilename);
					@move_uploaded_file($tmpFilename, GALLERY_IMAGE_BASE_PATH.$strFilename);
					$sql = "UPDATE `".IMAGE_TABLE."` SET `image_file`='{$strFilename}' WHERE `id`={$intID} LIMIT 1;";
					$res = $sqli->query($sql) or die($sqli->error);
					closeMeUp($res);
				}
			}
		}
		return;
	}
}

/************************************
 * Get number of image comments...
 ************************************/
if (!function_exists('countImageComments'))
{
	function countImageComments($intID=0)
	{
		global $sqli;
		$intData = 0;
		$intID = $sqli->real_escape_string($intID);
		$sql = "SELECT COUNT(1) AS `total` FROM ".IMAGE_COMMENT_TABLE." WHERE `status` != 86 AND `image_id`={$intID};";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		$intData = $row['total'];
		closeMeUp($res);
		return $intData;
	}
}

/************************************
 * Generate list of image comments...
 ************************************/
if (!function_exists('generateImageCommentList'))
{
	function generateImageCommentList($intImageID=0)
	{
		global $sqli;
		$arrData = array();
		$intImageID = $sqli->real_escape_string($intImageID);
		$arrFields = getTableFields(IMAGE_COMMENT_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM `".IMAGE_COMMENT_TABLE."` WHERE `status`!=86 AND `image_id`={$intImageID} ORDER BY `id`;";
		$res = $sqli->query($sql);
		while ($row = $res->fetch_assoc())
		{
			$arrTemp = array();
			foreach ($arrFields as $key => $val)
			{
				$arrTemp[$val] = $row[$val];
			}
			$arrUserData = getUserData($row['user_id']);
			$arrTemp['updated'] = $row['updated'];
			$arrTemp['user_data'] = $arrUserData;
			$arrData[$row['id']] = $arrTemp;
		}
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Get image comment data...
 ************************************/
if (!function_exists('getImageCommentData'))
{
	function getImageCommentData($intID=0)
	{
		global $sqli;
		$arrData = array();
		$intID = $sqli->real_escape_string($intID);
		$arrFields = getTableFields(IMAGE_COMMENT_TABLE);
		$sql = "SELECT ".implode(',', $arrFields).", UNIX_TIMESTAMP(`ts`) AS `updated` FROM ".IMAGE_COMMENT_TABLE." WHERE `id`={$intID} LIMIT 1;";
		$res = $sqli->query($sql) or die($sqli->error);
		$row = $res->fetch_assoc();
		foreach ($arrFields as $key => $val)
		{
			$arrData[$val] = $row[$val];
		}
		$arrData['updated'] = $row['updated'];
		closeMeUp($res);
		return $arrData;
	}
}

/************************************
 * Add a new image comment...
 ************************************/
if (!function_exists('addImageCommentData'))
{
	function addImageCommentData($arrData=array())
	{
		global $sqli;
		$strSQL = "";
		foreach ($arrData as $key => $val)
		{
			if ($key != 'action')
			{
				$val = $sqli->real_escape_string($val);
				$strSQL .= "`{$key}`='{$val}',";
			}
		}
		$strSQL = substr($strSQL, 0, strlen($strSQL) - 1);
		$sql = "INSERT INTO `".IMAGE_COMMENT_TABLE."` SET {$strSQL};";
		$res = $sqli->query($sql) or die($sqli->error);
		$intLastID = $sqli->insert_id;
		closeMeUp($res);
		return $intLastID;
	}
}
?>