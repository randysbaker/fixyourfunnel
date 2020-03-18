<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 17-MAR-2020
 * ---------------------------------------------------
 * Home Page (index.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'home';
$strPageTitle = 'Home';
$strPageKeywords = 'home, landing';
$strPageDescription = 'This is the home page.';

/************************************
 * Initialize user data...
 ************************************/
if (loggedIn())
{
    $user = toObject($_SESSION['sys_user']);
} else {
    $user = toObject(createGuestUser());
}

/************************************
 * Include the HTML header...
 ************************************/
include (PUBLIC_HEADER);
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Welcome! <small>Good to see you again...</small></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 min-h350">
                <p>In order to view the image gallery, you must first login.</p>
                <div class="col-md-12 text-center">
                    <a href="<?php echo BASE_URL_RSB?>login/" class="btn btn-lg btn-primary">Continue <i class="fa fa-arrow-right"></i></a>
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