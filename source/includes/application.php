<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 17-MAR-2020
 * ---------------------------------------------------
 * Application Setup (application.php)
 *****************************************************/

/*****************************************
 * Setup the environment...
 *****************************************/
@ini_set('memory_limit', '1024M');
@set_time_limit(172800);
@date_default_timezone_set('America/Chicago');
@error_reporting(E_ERROR | E_WARNING | E_PARSE);
@header('Access-Control-Allow-Origin: *');

/*****************************************
 * Initialize ession management...
 *****************************************/
if (!isset($_SESSION))
{
	@session_start();
}

/*****************************************
 * Initialize the database tables...
 *****************************************/
define ('IMAGE_COMMENT_TABLE', 'site_images_comments');
define ('IMAGE_TABLE', 'site_images');
define ('USER_TABLE', 'site_users');

/*****************************************
 * Initialize the account paths...
 *****************************************/
define ('USER_DASHBOARD', 'gallery/');
define ('USER_LOGIN', 'login/');
define ('USER_LOGOFF', 'logoff/');

/*****************************************
 * Initialize the HTML templates...
 *****************************************/
define ('PUBLIC_HEADER', 'include/header.php');
define ('PUBLIC_FOOTER', 'include/footer.php');

/*****************************************
 * Initialize the environment variables...
 *****************************************/
define ('LF', "\n");
define ('CRLF', "\r\n");
define ('BR', "<br />\n");
define ('DOMAIN', 'fixyourfunnel');

/*************************************************
 * Application initialization...
 *************************************************/
if ($_SERVER['HTTP_HOST'] == 'localhost' || stripos($_SERVER['HTTP_HOST'], 'localhost') !== false || stripos($_SERVER['REMOTE_ADDR'], '192.168.1.') !== false || stripos($_SERVER['REMOTE_ADDR'], '192.168.0.') !== false)
{
	$arrConnect['db_user'] = 'root';
	$arrConnect['db_pass'] = '';
	$arrConnect['db_host'] = 'localhost';
	$arrConnect['db_name'] = 'fixyourfunnel';
	define ('BASE_URL_RSB', 'http://localhost/fixyourfunnel/');
	define ('SITE_BASEPATH', 'C:/dev/wamp/www/fixyourfunnel/');
	define ('IMAGE_ROOT', 'images/');
	define ('UPLOAD_ROOT', 'uploads/');
	define ('GALLERY_IMAGE_PATH', BASE_URL_RSB.UPLOAD_ROOT.'gallery/');
	define ('GALLERY_IMAGE_BASE_PATH', SITE_BASEPATH.UPLOAD_ROOT.'gallery/');
} else {
	$arrConnect['db_user'] = 'username';
	$arrConnect['db_pass'] = 'password';
	$arrConnect['db_host'] = 'hostname';
	$arrConnect['db_name'] = 'database';
	define ('BASE_URL_RSB', 'https://www.domain.com/');
	define ('SITE_BASEPATH', '/path/to/files/');
	define ('UPLOAD_ROOT', 'uploads/');
	define ('GALLERY_IMAGE_PATH', BASE_URL_RSB.UPLOAD_ROOT.'gallery/');
	define ('GALLERY_IMAGE_BASE_PATH', SITE_BASEPATH.UPLOAD_ROOT.'gallery/');
}

/************************************
 * Script filename declarations...
 ************************************/
$strScript = str_ireplace(SITE_BASEPATH, '', $_SERVER['SCRIPT_FILENAME']);
$arrProtectedPages = array(
	'gallery',
	'add_image',
	'edit_image',
	'view_image'
);

/************************************
 * Data array definitions...
 ************************************/
$arrSanitizeFields = array(
	'image_title'
);

$arrGlobalStatus = array(
	0 => 'Active',
	1 => 'Disabled',
	2 => 'Unavailable',
	86 => 'Deleted'
);

$arrFilterPosted = array(
	0 => 'Sort By',
	1 => 'Newest',
	2 => 'Oldest'
);

/************************************
 * Load the core functions...
 ************************************/
require_once ('functions.php');

/************************************
 * Load the core actions...
 ************************************/
require ('actions.php');
?>