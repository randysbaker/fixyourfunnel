<?php
/*****************************************************
 * Created by: Randy S. Baker
 * Created on: 17-MAR-2020
 * ---------------------------------------------------
 * Public HTML Header (header.php)
 *****************************************************/
@header('Access-Control-Allow-Origin: *');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="<?php echo $strPageDescription?>" />
        <meta name="keywords" content="<?php echo $strPageKeywords?>" />
        <meta name="author" content="Randy S. Baker" />
        <title><?php echo (($strPageTitle != '') ? ($strPageTitle . ' | RSB Demo') : ('RSB Demo'))?></title>
        <link rel="stylesheet" href="<?php echo BASE_URL_RSB?>plugins/bootstrap/v3.3.7/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo BASE_URL_RSB?>plugins/font-awesome/v4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo BASE_URL_RSB?>plugins/fancybox/v3.5.7/jquery.fancybox.css" />
        <link rel="stylesheet" href="<?php echo BASE_URL_RSB?>css/default.css" />
        <link rel="stylesheet" href="<?php echo BASE_URL_RSB?>css/custom.css" />
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo BASE_URL_RSB?>">RSB Demo</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo BASE_URL_RSB?>">Home</a></li>
                        <li><a href="<?php echo BASE_URL_RSB.USER_DASHBOARD?>">Gallery</a></li>
                        <?php
                        if (loggedIn())
                        {
                            ?>
                            <li><a href="<?php echo BASE_URL_RSB?>add-image/">Add Image</a></li>
                            <li><a href="<?php echo BASE_URL_RSB.USER_LOGOFF?>">Log Out</a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="<?php echo BASE_URL_RSB.USER_LOGIN?>">Log In</a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>