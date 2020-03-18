<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 17-MAR-2020
 * ---------------------------------------------------
 * Login Page (login.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'user_login';
$strPageTitle = 'User Login';
$strPageKeywords = 'login, authenticate';
$strPageDescription = 'This is the login page.';

/************************************
 * Initialize user data...
 ************************************/
if (loggedIn())
{
    doRedirect(BASE_URL_RSB.USER_DASHBOARD);
}

/************************************
 * Include the HTML header...
 ************************************/
include (PUBLIC_HEADER);
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?php echo $strPageTitle?> <small>Please login...</small></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 min-h350">
                <div class="col-md-6 col-centered">
                    <div class="basic-login">
                        <form id="frmUserLogin" name="frmUserLogin" action="<?php echo BASE_URL_RSB?>login/" method="post" role="form">
                            <input id="action" name="action" type="hidden" value="do_login" />
                            <div class="form-group">
                                <label for="email"><i class="fa fa-user"></i> <b>Email</b></label>
                                <input class="form-control" id="email" name="email" type="text" placeholder="" />
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="fa fa-lock"></i> <b>Password</b></label>
                                <input class="form-control" id="password" name="password" type="password" placeholder="" />
                            </div>
                            <div class="form-group" style="margin-left:20px;">
                                <label class="checkbox">
                                    <input type="checkbox" name="chkRememberMe" id="chkRememberMe" /> Remember Me
                                </label>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-primary pull-right"><i class="fa fa-lock"></i> Login</button>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr />
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include (PUBLIC_FOOTER);
?>