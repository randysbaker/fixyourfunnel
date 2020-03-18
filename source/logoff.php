<?php
/*********************************************************
 * Created by: Randy S. Baker
 * Created on: 17-MAR-2020
 * -------------------------------------------------------
 * Account: Logoff Page (logoff.php)
 *********************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'user_logoff';
$strPageTitle = 'User Logoff';

/************************************
 * Check authentication...
 ************************************/
if (!loggedIn())
{
	doRedirect(BASE_URL_RSB.USER_LOGIN);
}

/************************************
 * Get user data...
 ************************************/
$user = toObject($_SESSION['sys_user']);

/************************************
 * Perform logoff actions...
 ************************************/
session_clear(DOMAIN);
doRedirect(BASE_URL_RSB);
?>