<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 17-MAR-2020
 * ---------------------------------------------------
 * View Image Page (view_image.php)
 *****************************************************/

/************************************
 * Initialize the application...
 ************************************/
require ('includes/application.php');

/************************************
 * Initialize page data...
 ************************************/
$strPageName = 'view_image';
$strPageTitle = 'View Image Details';
$strPageKeywords = 'gallery, images, view';
$strPageDescription = 'This is the image details page.';

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
$arrComments = generateImageCommentList($image->id);

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
                <img src="<?php echo $strImage?>" class="img-responsive" alt="<?php echo $image->image_title?>">
                <h3><?php echo $image->image_title?> 
                <?php
                if ($image->user_id == $user->id)
                {
                    ?>
                    <a href="<?php echo BASE_URL_RSB?>edit-image/<?php echo $image->id?>/<?php echo generateSEOURL($image->image_title)?>/" title="Edit"><i class="fa fa-pencil"></i></a>
                    <?php
                }
                ?>
                </h3>
                <p>Uploaded by <?php echo getUsername($image->user_id)?> | <?php echo countImageComments($image->id)?> Comment(s)</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="push-top-15 semibold"><i class="fa fa-comments-o"></i> Comments</h3>
                <?php
                if (!empty($arrComments))
                {
                    foreach ($arrComments as $comments)
                    {
                        $comment = toObject($comments);
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <span class="semi-bold"><?php echo $comment->user_data->first_name .' '.$comment->user_data->last_name ?></span> @ <span class="semibold"><?php echo date('m/d/Y h:ia', $comment->updated)?></span>:<br />
                                <p><?php echo $comment->image_comments?></p>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="text-left">
                        <p class="red">There are currently no comments.</p>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 push-top-15 bg_cornsilk img-rounded">
                <div class="comment-form-wrap">
                    <h3 class="brown semibold"><i class="fa fa-comments"></i> Leave A Comment</h3>
                    <form id="frmAddImageComment" name="frmAddImageComment" method="post" action="<?php echo BASE_URL_RSB?>view-image/<?php echo $image->id?>/<?php echo generateSEOURL($image->image_title)?>/" class="bg_cornsilk">
                        <input type="hidden" id="image_id" name="image_id" value="<?php echo $image->id?>" />
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $user->id?>" />
                        <input type="hidden" id="action" name="action" value="add_image_comment" />
                        <div class="form-group">
                            <label for="image_comments">Comment</label>
                            <textarea id="image_comments" name="image_comments" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="btnSubmit" name="btnSubmit" class="btn btn-brown pull-right"><i class="fa fa-send"></i> Post Comment</button>
                        </div>
                    </form>
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