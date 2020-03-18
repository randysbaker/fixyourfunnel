<?php
/******************************************************
 * Created by: Randy S. Baker
 * Created on: 17-MAR-2020
 * ----------------------------------------------------
 * AJAX: Generic Calls (ajax.calls.php)
 ******************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('application.php');

/************************************
 * Get data via AJAX...
 ************************************/
if (isset($_GET['action']) && $_GET['action'] == 'ajax_get_data')
{
	$strData = '';
	$arrData = $_GET;
	unset($arrData['action']);
	$objData = toObject($arrData);
	switch ($objData->model)
	{
		case 'user':
			switch ($objData->method)
			{
				case 'fullname':
					$strData = getUserName($objData->id);
					break;
			}
			break;
		case 'deer':
			break;
	}
	$arrResponse = array('status' => 'success', 'data_content' => $strData);
	echo json_encode($arrResponse);
}

/*****************************************
 * Process the Stripe payment (experts)...
 *****************************************/
if (isset($_POST['action']) && $_POST['action'] == 'ajax_process_stripe_payment')
{
	$arrData = $_POST;
	$arrReturn = processStripePayment($arrData);
	echo json_encode($arrReturn);
}

/************************************
 * Get the user data...
 ************************************/
if (isset($_GET['action']) && $_GET['action'] == 'ajax_get_user_data')
{
	$intID = $_GET['id'];
	$arrData = getUserData($intID);
	echo json_encode($arrData);
}

/*************************************
 * Generate state / province list...
 *************************************/
if (isset($_POST['action']) && $_POST['action'] == 'do_get_country_provinces')
{
	$intID = $_POST['id'];
	$arrData = generateCountryProvinces($intID);
	echo json_encode($arrData);
}

/************************************
 * Validate a discount...
 ************************************/
if (isset($_GET['action']) && $_GET['action'] == 'ajax_validate_discount')
{
	$strCode = $_GET['code'];
	$intPackageID = $_GET['package_id'];
	$arrData = verifyDiscountCode($strCode, $intPackageID);
	echo json_encode($arrData);
}

/************************************
 * Add chat message...
 ************************************/
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'do_add_chat_message')
{
	$arrData = array();
	$arrData['from_user'] = $_REQUEST['from_user'];
	$arrData['to_user'] = $_REQUEST['to_user'];
	$arrData['from_account_type'] = $_REQUEST['from_account_type'];
	$arrData['to_account_type'] = $_REQUEST['to_account_type'];
	$arrData['message_data'] = $_REQUEST['message_data'];
	addChatMessageData($arrData);
	echo 'Done!';
}

/************************************
 * Get chat messages...
 ************************************/
if (isset($_GET['action']) && $_GET['action'] == 'do_get_chat_messages')
{
	$intChatUserID = $_GET['user_id'];
	$intChatUserAccountType = $_REQUEST['user_account_type'];
	$arrMessageData = generateChatMessageList(100, true, $intChatUserID, $intChatUserAccountType);
	$arrResponse = generateChatMessageHTML($arrMessageData, $intChatUserID, $intChatUserAccountType);
	echo json_encode($arrResponse);
}

/************************************
 * Get the user profile data...
 ************************************/
if (isset($_GET['action']) && $_GET['action'] == 'ajax_get_profile_data')
{
	$intID = $_GET['id'];
	$arrData = getUserProfileData($intID);
	$arrResponse = array('status' => 'success', 'data_content' => $arrData, 'ID' => $intID);
	echo json_encode($arrResponse);
}

/************************************
 * Share an item...
 ************************************/
if (isset($_GET['action']) && $_GET['action'] == 'ajax_do_submit_item_share')
{
	$arrData = $_GET;
	unset($arrData['action']);
	unset($arrData['_']);
	$intNewID = addItemShareData($arrData);
	if (!empty($arrData && $arrData['email'] != ''))
	{
		$arrPage = array();
		$arrFormData = array();
		$strEmailTo = $arrData['email'];
		$property = toObject(getPropertyData($arrData['property_id']));
		$owner = toObject(getUserData($property->user_id));
		if ($arrData['user_id'] == 0)
		{
			$sender = toObject(createGuestUser());
		} else {
			$sender = toObject(getUserData($arrData['user_id']));
		}
		$strOwnerFullName = $owner->first_name .' '. $owner->last_name;
		$strSenderFullName = $sender->first_name .' '. $sender->last_name;
		$strPageURL = BASE_URL_RSB.'property/'.$property->property_hash.'/';
		$arrFormData['page_url'] = $strPageURL;
		$arrFormData['property_name'] = $property->property_name;
		$arrFormData['owner_name'] = $strOwnerFullName;
		$arrFormData['txtDate'] = date('r');
		$arrPage['from_email'] = (($sender->email != '')?($sender->email):(FROM_EMAIL));
		$arrPage['from_name'] = (($strSenderFullName != 'Sign In')?($strSenderFullName):('Someone'));
		$arrPage['email_to'] = $strEmailTo;
		$arrPage['subject'] = (($strSenderFullName != 'Sign In')?($strSenderFullName):('Someone')).' just sent you a product to check out on JENABLINGSIT.COM';
		$arrPage['txtDate'] = date('r');
		$arrFormLabels = array(
			'page_url' => 'Page URL',
			'product_name' => 'Product Name',
			'owner_name' => 'Submitted By',
			'txtDate' => 'Date'
		);
		$body  = "<!DOCTYPE html><html><title>Someone Shared A Product With You</title><body>\n"; 
		$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>Hey,<br />".$arrPage['from_name']." just sent you a product suggestion from JENABLINGSIT.COM. Here are the details:</p>\n";
		$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>&nbsp;</p>\n";
		$body .= "<table style='width:700px; border:2px solid #000000;'>\n";
		$body .= "<tr><td colspan='2' style='background-color:#AAAAAA; color:#FFFFFF; font-weight:bold; textalign:center; padding-right:5px;'>MESSAGE DETAILS</td></tr>\n";
		foreach ($arrFormLabels as $key => $val)
		{
			if ($key == 'page_url')
			{
				$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>{$val}:</td><td style='padding-left:5px; text-align:left;'><a href='".$arrFormData[$key]."' target='_blank'>".$arrFormData[$key]."</a></td></tr>\n";
			} else {
				$body .= "<tr><td style='font-weight:bold; text-align:right; padding-right:5px; vertical-align:top; width:125px;'>{$val}:</td><td style='padding-left:5px; text-align:left;'>".$arrFormData[$key]."</td></tr>\n";
			}
		}
		$body .= "</table>\n";
		$body .= "</body></html>\n";
		$arrPage['body'] = $body;
		sendShortMessage($arrPage);
	}
	$arrResponse = array('status' => 'success', 'id' => $intNewID);
	echo json_encode($arrResponse);
}

/************************************
 * Add a blog comment...
 ************************************/
if (isset($_GET['action']) && $_GET['action'] == 'ajax_do_add_blog_comment')
{
	$arrData = $_GET;
	$arrFields = array('user_id','blog_id','parent_id','blog_comments');
	foreach ($arrData as $key => $val)
	{
		if (!in_array($key, $arrFields))
		{
			unset($arrData[$key]);
		}
	}
	$intNewID = addBlogCommentData($arrData);
	$arrBlogComment = getBlogCommentData($intNewID);
	$arrBlog = getBlogData($arrData['blog_id']);
	$arrResponse = array('status' => 'success', 'id' => $intNewID, 'comment_data' => $arrBlogComment, 'blog_data' => $arrBlog);
	echo json_encode($arrResponse);
}

/************************************
 * Add a product to the cart...
 ************************************/
if (isset($_GET['action']) && $_GET['action'] == 'ajax_add_product_to_cart')
{
	$arrData = array();
	$arrData['product_id'] = $_GET['product_id'];
	$arrData['product_qty'] = $_GET['product_qty'];
	$arrData['product_name'] = $_GET['product_name'];
	$arrData['product_price'] = $_GET['product_price'];
	$arrData['product_image'] = $_GET['product_image'];
	$_SESSION['cart_data'][$arrData['product_id']] = $arrData;
	$arrResponse = array('status' => 'success');
	echo json_encode($arrResponse);
}

/************************************
 * Remove a product from the cart...
 ************************************/
if (isset($_GET['action']) && $_GET['action'] == 'ajax_remove_product_from_cart')
{
	$strData = $_GET['product_id'];
	if (!empty($_SESSION['cart_data']) && isset($_SESSION['cart_data'][$strData]))
	{
		unset($_SESSION['cart_data'][$strData]);
	}
	$arrResponse = array('status' => 'success');
	echo json_encode($arrResponse);
}

/************************************
 * Update product quantity...
 ************************************/
if (isset($_GET['action']) && $_GET['action'] == 'ajax_update_product_quantity')
{
	$intQty = $_GET['product_qty'];
	$strData = $_GET['product_id'];
	if (!empty($_SESSION['cart_data']) && isset($_SESSION['cart_data'][$strData]))
	{
		$_SESSION['cart_data'][$strData]['product_qty'] = $intQty;
		echo 'Done!';
	} else {
		echo 'Product not in cart!';
	}
}

/************************************
 * Get shopping cart contents...
 ************************************/
if (isset($_GET['action']) && $_GET['action'] == 'ajax_get_cart_contents')
{
	$arrData = array();
	if (!empty($_SESSION['cart_data']))
	{
		$arrData = $_SESSION['cart_data'];
	}
	echo json_encode($arrData);
}

/************************************
 * AJAX email test...
 ************************************/
if (isset($_GET['action']) && $_GET['action'] == 'ajax_test_send_email')
{
	$arrData = $_GET;
	$strEmailTo = 'randysbaker@gmail.com';
	$arrPage['from_email'] = FROM_EMAIL;
	$arrPage['from_name'] = FROM_NAME;
	$arrPage['email_to'] = $strEmailTo;
	$arrPage['subject'] = 'This is an email test';
	$arrPage['txtDate'] = date('r');
	$body  = "<!DOCTYPE html><html><title>Email Test</title><body>\n"; 
	$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>Hey,<br />Email test from website. Here are the details:</p>\n";
	$body .= "<p style='font-family:Arial, Helvetica, sans-serif; font-size:12px;'>&nbsp;</p>\n";
	$body .= "</body></html>\n";
	$arrPage['body'] = $body;
	sendShortMessage($arrPage);
	$arrResponse = array('status' => 'success');
	echo json_encode($arrResponse);
}
?>