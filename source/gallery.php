<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 17-MAR-2020
 * ---------------------------------------------------
 * Gallery Page (gallery.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'gallery';
$strPageTitle = 'Image Gallery';
$strPageKeywords = 'gallery, images';
$strPageDescription = 'This is the gallery page.';

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
if (isset($arrImagesFiltered) && !empty($arrImagesFiltered))
{
    $arrImages = $arrImagesFiltered;
} else {
    $arrImages = generateGalleryImageList();
}

/************************************
 * Include the HTML header...
 ************************************/
include (PUBLIC_HEADER);
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?php echo $strPageTitle?> <small>Enjoy!</small></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 push-bottom-15">
                <form id="frmGalleryFilters" name="frmGalleryFilters" method="post" action="<?php echo BASE_URL_RSB?>gallery/" class="form-inline">
                    <input type="hidden" id="action" name="action" value="update_gallery_filters" />
                    <div class="col-md-12 text-right push-top-5 no-padding">
                        <div class="form-group">
                            <input type="text" id="gallery_search" name="gallery_search" class="form-control" placeholder="Search..." value="<?php echo ((isset($_POST['gallery_search']) && $_POST['gallery_search'] != '')?($_POST['gallery_search']):(''))?>" />
                        </div>
                        <div class="form-group">
                            <select id="filter_posted" name="filter_posted" class="form-control input-sm">
                                <?php
                                    foreach ($arrFilterPosted as $key => $val)
                                    {
                                        ?>
                                        <option value="<?php echo $key?>"<?php echo (($key == $_POST['filter_posted'])?(' selected="selected"'):(''))?>><?php echo $val?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" id="btnFilterHomeReset" name="btnFilterHomeReset" class="btn btn-sm btn-danger same-window" data-url="<?php echo BASE_URL_RSB?>gallery/"><i class="fa fa-refresh fa-right-5"></i> RESET</button>
                            <button type="submit" id="btnFilterHome" name="btnFilterHome" class="btn btn-sm btn-brown"><i class="fa fa-filter fa-right-5"></i> UPDATE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <?php
            if (!empty($arrImages))
            {
                foreach ($arrImages as $images)
                {
                    $image = toObject($images);
                    $strImage = (($image->image_file != '' && @file_exists(GALLERY_IMAGE_BASE_PATH.$image->image_file))?(GALLERY_IMAGE_PATH.$image->image_file):(GALLERY_IMAGE_PATH.'no-image.png'));
                    ?>
                    <div class="col-md-4 portfolio-item">
                        <a href="<?php echo $strImage?>" class="fancybox"><img src="<?php echo $strImage?>" class="img-responsive" data-fancybox="gallery" alt="<?php echo $image->image_title?>"></a>
                        <h3><a href="<?php echo BASE_URL_RSB?>view-image/<?php echo $image->id?>/<?php echo generateSEOURL($image->image_title)?>/"><?php echo $image->image_title?></a></h3>
                        <p>Uploaded by <?php echo getUsername($image->user_id)?> | <?php echo countImageComments($image->id)?> Comment(s)</p>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <hr />
<?php
/************************************
 * Include the HTML footer...
 ************************************/
include (PUBLIC_FOOTER);
?>