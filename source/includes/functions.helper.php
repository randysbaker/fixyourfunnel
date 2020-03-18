<?php
/*****************************************************
* Created by: Randy S. Baker
* Created on: 17-MAR-2020
* ----------------------------------------------------
* Helper Functions (functions.helper.php)
******************************************************/

/************************************
 * Environment setup...
 ************************************/
if (!is_resource($sqli))
{
	$sqli = connectToDB($arrConnect);
}

/************************************
 * Connect to the database...
 ************************************/
function connectToDB($arrConnect=array())
{
	global $sqli;
	$sqli = new mysqli($arrConnect['db_host'], $arrConnect['db_user'], $arrConnect['db_pass'], $arrConnect['db_name']);
	if ($sqli->connect_error) 
	{
		die('Connection failed: '. mysqli_connect_error());
	}
	return $sqli;
}

/************************************
 * Friendly view of an array...
 ************************************/
if (!function_exists('showDebug'))
{
	function showDebug($arrData=array(), $strTitle='', $isDead=false)
	{
		echo '<hr><b>'. strtoupper($strTitle) .':</b><br /><pre>'.LF;
		print_r($arrData);
		echo '</pre><hr>'.LF;
		if ($isDead === true)
		{
			breakpoint('Checkpoint...');
		}
		return;
	}
}

/************************************
 * Temporarily halt the script...
 ************************************/
if (!function_exists('breakpoint'))
{
	function breakpoint($strData='Checkpoint...')
	{
		die($strData.LF);
	}
}

/************************************
 * Friendly redirect...
 ************************************/
if (!function_exists('doRedirect'))
{
	function doRedirect($strLocation='')
	{
		echo "<script>".LF;
		echo "  location.href='$strLocation';".LF;
		echo "</script>".LF;
		return;
	}
}

/************************************
 * Friendly alert...
 ************************************/
if (!function_exists('showAlert'))
{
	function showAlert($strAlert='')
	{
		echo "<script>".LF;
		echo "  alert('$strAlert');".LF;
		echo "</script>".LF;
		return;
	}
}

/******************************************
 * Generate SEO URL...
 ******************************************/
if (!function_exists('generateSEOURL'))
{
	function generateSEOURL($strURL='')
	{
		$arrFind = array(' ', ',', '.', '"', "'", '?', '!');
		$arrReplace = array('-', '', '', '', '', '', '');
		$strURL = strtolower(trim($strURL));
		$strURL = str_replace($arrFind, $arrReplace, $strURL);
		return $strURL;
	}
}

/***************************************
 * Clean up the URL...
***************************************/
if (!function_exists('cleanURL'))
{
	function cleanURL($strURL='')
	{
		$arrSearch = array('http', ':', '//', 'www.');
		$arrReplace = array('', '', '', '');
		$strURL = str_replace($arrSearch, $arrReplace, $strURL);
		return $strURL;
	}
}

/************************************
 * Free the MySQL resource...
 ************************************/
if (!function_exists('closeMeUp'))
{
	function closeMeUp($resData)
	{
		if (is_resource($resData))
		{
			$resData->close();
		}
		return;
	}
}

/************************************
 * Convert array to an object...
 ************************************/
if (!function_exists('toObject'))
{
	function toObject($arrData=array())
	{
		$objObject = json_decode(json_encode($arrData), false);
		return $objObject;
	}
}

/******************************************
 * Get the database tables...
 ******************************************/
if (!function_exists('getTables'))
{
	function getTables($strDatabase='')
	{
		global $sqli;
		$arrTables = array();
		$strDatabase = $sqli->real_escape_string($strDatabase);
		$sql = "SHOW TABLES FROM `{$strDatabase}`;";
		$res = $sqli->query($sql) or die($sqli->error);
		while ($row = $res->fetch_assoc())
		{
			$arrTables[] = $row['Tables_in_'.$strDatabase];
		}
		closeMeUp($res);
		return $arrTables;
	}
}

/******************************************
 * Get the table column definitions...
 ******************************************/
if (!function_exists('getTableFields'))
{
	function getTableFields($strTable='')
	{
		global $sqli;
		$arrFields = array();
		$strTable = $sqli->real_escape_string($strTable);
		$sql = "SHOW COLUMNS FROM `{$strTable}`;";
		$res = $sqli->query($sql) or die($sqli->error);
		while ($row = $res->fetch_assoc())
		{
			$arrFields[] = $row['Field'];
		}
		closeMeUp($res);
		return $arrFields;
	}
}

/*************************************************
 * Save to log file...
 *************************************************/
if (!function_exists('saveToLog'))
{
	function saveToLog($strData='', $strFilename='log.txt')
	{
		$fLogFile  = SITE_BASEPATH."data/{$strFilename}";
		$fileData .= "\n============================ BEGIN LOG ENTRY ". date('m/d/Y h:ia') ." ==================\n";
		$fileData .= $strData;
		$fileData .= "\n============================ END LOG ENTRY ===========================================\n";
		if (!file_put_contents($fLogFile, $fileData, FILE_APPEND))
		{
			$ext = pathinfo($strFilename, PATHINFO_EXTENSION);
			$strNewBase = str_ireplace('.'.$ext, '', $fLogFile);
			$strNewFile = SITE_BASEPATH.'data/'.$strNewBase.'-1.'.$ext;
			breakpoint($strNewFile);
			file_put_contents($strNewFile, $fileData);
		}
		return;
	}
}

/*************************************************
 * Create a folder...
 *************************************************/
if (!function_exists('createFolder'))
{
	function createFolder($strPath='')
	{
		if ($strPath != '')
		{
			@mkdir($strPath, 0755);
			return;
		} else {
			return;
		}
	}
}

/************************************
 * Read a file into memory...
 ************************************/
if (!function_exists('getFileData'))
{
	function getFileData($strFile='')
	{
		$arrData = array();
		$strFile = $strFile;
		if (file_exists($strFile))
		{
			$fh = @fopen($strFile, 'r');
			while (!feof($fh)) 
			{
        		$data = @fgets($fh, 4096);
        		if ($data{0} != '' )
        		{
        			$arrData[] = trim($data);        	
        		}
    		}
		}
		return $arrData;
	}
}

/************************************
 * Load a file into memory...
 ************************************/
if (!function_exists('loadFileData'))
{
	function loadFileData($strFile='')
	{
		if ($strFile != '')
		{
			$strData = @file_get_contents($strFile);
			return $strData;
		} else {
			return;
		}
	}
}

/*************************************************
 * Write file data...
 *************************************************/
if (!function_exists('writeFileData'))
{
	function writeFileData($fileData='', $strFile='')
	{
		if ($strFile != '')
		{
			@file_put_contents($strFile, $fileData);
			return;
		} else {
			return;
		}
	}
}

/*************************************************
 * Copy a file from one location to another...
 *************************************************/
if (!function_exists('copyFile'))
{
	function copyFile($strSource='', $strDestination='')
	{
		if ($strSource != '' && $strDestination != '')
		{
			if (file_exists($strSource))
			{
				@copy($strSource, $strDestination);
			}
			return;
		} else {
			return;
		}
	}
}

/*************************************************
 * Write file data...
 *************************************************/
if (!function_exists('backupFile'))
{
	function backupFile($strPath='', $strFile='')
	{
		if ($strFile != '')
		{
			if (file_exists($strPath.$strFile))
			{
				$strSourceFile = $strPath.$strFile;
				$strNewDateTime = date('YmdHis').'-bak.dat';
				$strNewFile = $strPath.'bak/'.$strFile.$strNewDateTime;
				@copy($strSourceFile, $strNewFile);
			}
			return;
		} else {
			return;
		}
	}
}

/************************************
 * Read folder contents into array...
 ************************************/
if (!function_exists('getFolderContents'))
{
	function getFolderContents($strLocation='.')
	{
		$arrFiles = array();
		if ($dirHandle = @opendir($strLocation)) 
		{
			while (false !== ($file = @readdir($dirHandle))) 
			{
				if ($file != '.' && $file != '..') 
				{
					$arrFiles[] = trim($file);
				}
			}
			@closedir($dirHandle);
		}
		return $arrFiles;
	}
}

/*************************************************
 * Replace any characters that may cause issues...
 *************************************************/
if (!function_exists('makeSafe'))
{
	function makeSafe($strData='')
	{
		$arrDirty = array('"', "'", ',', '-', '.', ':', '/', '%');
		foreach ($arrDirty as $key => $val)
		{
			if ($val == '-' || $val == '.' || $val == ':' || $val == '/' || $val == '%')
			{
				$strData = str_ireplace($val, ' ', $strData);
			} else {
				$strData = str_ireplace($val, '', $strData);
			}
		}
		return trim($strData);
	}
}

/*************************************************
 * Replace characters that cause issues (file)...
 *************************************************/
if (!function_exists('makeSafeFilename'))
{
	function makeSafeFilename($strData='')
	{
		$arrDirty = array(' ', '"', "'", ',', ':', '/', '%', '$');
		foreach ($arrDirty as $key => $val)
		{
			if ($val == ' ' | $val == ':' || $val == '/' || $val == '%')
			{
				$strData = str_ireplace($val, '_', $strData);
			} else {
				$strData = str_ireplace($val, '', $strData);
			}
		}
		return trim($strData);
	}
}

/*************************************************
 * Email format verification check...
 *************************************************/
if(!function_exists('isValidEmail'))
{
	function isValidEmail($strEmail='')
	{
		if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $strEmail))
		{
			return false;
		} else {
			return true;
		}
	}
}

/******************************************
 * Check authentication status...
 ******************************************/
if (!function_exists('doAuthCheck'))
{
	function doAuthCheck()
	{
		if ($_SESSION['sys_user']['is_auth'] == 1 && $_SESSION['sys_user']['id'] > 0) 
		{
			return true;
		} else {
			return false;
		}
	}
}

/******************************************
 * Create a generic (guest) user...
 ******************************************/
if (!function_exists('createGuestUser'))
{
	function createGuestUser()
	{
		$arrData = array(
			'id' => 0,
		    'status' => 0,
		    'confirmed' => 1,
		    'membership_approved' => 1,
		    'subscription_id' => 1,
		    'email' => 'guest@guest.com',
		    'password' => 'guest',
		    'username' => 'guest',
		    'first_name' => 'Sign',
		    'last_name' => 'In',
		    'account_type' => 2,
		    'job_title' => '',
		    'organization' => '',
		    'website' => '',
		    'blog' => '',
		    'organization_type' => 0,
		    'address_1' => '123 My Way',
		    'address_2' => '',
		    'city' => 'Wimberley',
		    'state' => 'TX',
		    'zipcode' => '78676',
		    'country' => 0,
		    'phone' => '(800) 555-1212',
		    'fax' => '',
		    'coverage' => '',
		    'image' => '',
		    'newsletter' => 0,
		    'referral_code' => '',
		    'discount_code' => '',
		    'tz' => 0,
		    'ts' => '2020-03-17 00:00:00',
		    'is_auth' => 0,
		);
		return $arrData;
    }
}

/******************************************
 * Clear _SESSION data...
 ******************************************/
if (!function_exists('session_clear'))
{
	function session_clear($strDomain='')
	{
		$arrCookieData = session_get_cookie_params();
		$_SESSION = array();
		if (@ini_get('session.use_cookies'))
		{
			$arrCookieData = @session_get_cookie_params();
			@setcookie(session_name(), '', 1, $arrCookieData['path'], $arrCookieData['domain'], $arrCookieData['secure'], $arrCookieData['httponly']);
			@setcookie('auth_data', '', 1, '/');
		}
		session_destroy();
	}
}

/******************************************
 * Check if user is logged in...
 ******************************************/
if (!function_exists('loggedIn'))
{
	function loggedIn()
	{
		if (isset($_SESSION['admin_area']) && $_SESSION['admin_area'] == 1)
		{
			return false;
		} else {
			if (doAuthCheck()) 
			{
				return true;
			} else {
				return false;
			}
		}
	}
}

/******************************************
 * Check if user...
 ******************************************/
if (!function_exists('isUser'))
{
	function isUser()
	{
		if ($_SESSION['sys_user']['account_type'] == 2) 
		{
			return true;
		} else {
			return false;
		}
	}
}

/******************************************
 * Check if guest account...
 ******************************************/
if (!function_exists('isGuest'))
{
	function isGuest()
	{
		if ($_SESSION['sys_user']['username'] == 'guest') 
		{
			return true;
		} else {
			return false;
		}
	}
}

/******************************************
 * Check if page is protected...
 ******************************************/
if (!function_exists('isProtectedPage'))
{
	function isProtectedPage()
	{
		global $strPageName, $arrProtectedPages;
		if (in_array($strPageName, $arrProtectedPages)) 
		{
			if (!loggedIn())
			{
				doRedirect(BASE_URL_RSB.USER_LOGOFF);
			}
		}
		return;
	}
}
?>