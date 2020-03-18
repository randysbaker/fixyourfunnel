<?php
/*****************************************************
* Created by: Randy S. Baker
* Created on: 17-MAR-2020
* ----------------------------------------------------
* Core Actions (actions.php)
******************************************************/

/************************************
 * Enable / disable debugging mode...
 ************************************/
$isDebug = false;

/************************************
 * Get the arguments passed in...
 ************************************/
$intImageID = ((isset($_REQUEST['image_id']) && $_REQUEST['image_id'] != '')?($_REQUEST['image_id']):(0));
$intUserID = ((isset($_REQUEST['user_id']) && $_REQUEST['user_id'] != '')?($_REQUEST['user_id']):(0));

/************************************
 * Authenticate a user...
 ************************************/
if (isset($_POST['action']) && $_POST['action'] == 'do_login')
{
	$arrAuthData = array();
	$arrAuthData['email'] = $sqli->real_escape_string($_POST['email']);
	$arrAuthData['pass'] = $sqli->real_escape_string($_POST['password']);
	userAuthenticate($arrAuthData);
	if ($_SESSION['sys_user']['is_auth'] != 1)
	{
		showAlert('Authentication error!');
		doRedirect(BASE_URL_RSB.USER_LOGIN);
	} else {
		$arrAuthData = array();
		doRedirect(BASE_URL_RSB.USER_DASHBOARD);
	}
}

/************************************
 * Add a new image...
 ************************************/
if (isset($_POST['action']) && $_POST['action'] == 'add_gallery_image')
{
	$arrData = $_POST;
	$arrFileData = $_FILES;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	unset($arrData['files']);
	$intNewID = addGalleryImageData($arrData);
	processFileUpload($arrData, $arrFileData, $intNewID);
	doRedirect(BASE_URL_RSB.USER_DASHBOARD);
}

/************************************
 * Save an image title...
 ************************************/
if (isset($_POST['action']) && $_POST['action'] == 'save_image_title')
{
	$arrData = $_POST;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	unset($arrData['files']);
	$intID = $arrData['id'];
	saveGalleryImageData($intID, $arrData);
	$image = toObject(getGalleryImageData($intID));
	doRedirect(BASE_URL_RSB.'view-image/'.$image->id.'/'.generateSEOURL($image->image_title).'/');
}

/************************************
 * Add a new image comment...
 ************************************/
if (isset($_POST['action']) && $_POST['action'] == 'add_image_comment')
{
	$arrData = $_POST;
	unset($arrData['action']);
	unset($arrData['btnSubmit']);
	unset($arrData['files']);
	$inttID = addImageCommentData($arrData);
	$image = toObject(getGalleryImageData($arrData['image_id']));
	doRedirect(BASE_URL_RSB.'view-image/'.$image->id.'/'.generateSEOURL($image->image_title).'/');
}

/************************************
 * Apply gallery criteria filters...
 ************************************/
if (isset($_POST['action']) && $_POST['action'] == 'update_gallery_filters')
{
	$arrData = $_POST;
	unset($arrData['action']);
	unset($arrData['btnFilterHome']);
	$arrImagesFiltered = filterGalleryImageList($arrData);
}

/************************************
 * Display debugging information...
 ************************************/
if ($isDebug === true)
{
	if (count($_SESSION) > 0)
	{
		echo 'SESSION:';
		showDebug($_SESSION);
	}
	
	if (count($_REQUEST) > 0)
	{
		echo 'REQUEST:';
		showDebug($_REQUEST);
	}
	
	if (count($_SERVER) > 0)
	{
		echo 'SERVER:';
		showDebug($_SERVER);
	}
	
	if (count($_POST) > 0)
	{
		echo 'POST:';
		showDebug($_POST);
	}
	
	if (count($_FILES) > 0)
	{
		echo 'FILES:';
		showDebug($_FILES);
	}
	breakpoint();
}
?>