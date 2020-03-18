<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 17-MAR-2020
 * ---------------------------------------------------
 * Add Image Page (add_image.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'add_image';
$strPageTitle = 'Add New Image';
$strPageKeywords = 'image, new';
$strPageDescription = 'Add a new image.';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize user data...
 ************************************/
$user = toObject($_SESSION['sys_user']);

/************************************
 * Include the HTML header...
 ************************************/
include (PUBLIC_HEADER);
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?php echo $strPageTitle?> <small>Populate your gallery...</small></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 min-h350">
                <div class="col-md-6 col-centered">
                    <div class="basic-login">
                        <form id="frmAddImage" name="frmAddImage" action="<?php echo BASE_URL_RSB.USER_DASHBOARD?>" method="post" class="form-light" enctype="multipart/form-data" role="form">
                            <input id="user_id" name="user_id" type="hidden" value="<?php echo $user->id?>" />
                            <input id="action" name="action" type="hidden" value="add_gallery_image" />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Image Title</label>
                                        <input id="image_title" name="image_title" type="text" class="form-control" value="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row push-bottom-25">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="image_main">Upload Image</label>
                                        <input type="file" class="form-control-file" id="image_file" name="image_file[]" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center push-top-25">
                                    <button type="button" id="btnCancel" name="btnCancel" class="btn btn-danger pull-left same-window" data-url="<?php echo BASE_URL_RSB.USER_DASHBOARD?>"><i class="fa fa-close"></i> Cancel</button>
                                    <button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save</button>
                                </div>
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