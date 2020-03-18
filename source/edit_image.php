<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 17-MAR-2020
 * ---------------------------------------------------
 * Edit Image Page (edit_image.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'edit_image';
$strPageTitle = 'Edit Image Details';
$strPageKeywords = 'gallery, images, edit';
$strPageDescription = 'This is the edit image page.';

/************************************
 * Check if page is protected...
 ************************************/
isProtectedPage();

/************************************
 * Initialize user data...
 ************************************/
$user = toObject($_SESSION['sys_user']);

/************************************
 * Initialize data arrays...
 ************************************/
$image = toObject(getGalleryImageData($intImageID));
$strImage = (($image->image_file != '' && @file_exists(GALLERY_IMAGE_BASE_PATH.$image->image_file))?(GALLERY_IMAGE_PATH.$image->image_file):(GALLERY_IMAGE_PATH.'no-image.png'));

/************************************
 * Check image owner...
 ************************************/
if ($image->user_id != $user->id)
{
    doRedirect(BASE_URL_RSB.'view-image/'.$image->id.'/'.generateSEOURL($image->image_title).'/');
}

/************************************
 * Include the HTML header...
 ************************************/
include (PUBLIC_HEADER);
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?php echo $strPageTitle?> <small><?php echo $image->image_title?></small></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 min-h350 portfolio-item">
                <form id="frmEditImage" name="frmEditImage" method="post" action="<?php echo BASE_URL_RSB?>view-image/<?php echo $image->id?>/<?php echo generateSEOURL($image->image_title)?>/" role="form">
                    <input type="hidden" id="action" name="action" value="save_image_title" />
                    <input type="hidden" id="id" name="id" value="<?php echo $image->id?>" />
                    <div class="row">
                        <div class="col-md-12">
                            <img src="<?php echo $strImage?>" class="img-responsive" alt="<?php echo $image->image_title?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 push-top-25">
                            <div class="form-group">
                                <label>Image Title</label>
                                <input type="text" id="image_title" name="image_title" class="form-control" value="<?php echo $image->image_title?>" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>Uploaded by <?php echo getUsername($image->user_id)?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-md btn-primary"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr />
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include (PUBLIC_FOOTER);
?>