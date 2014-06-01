<?php
//**********************************************************
//onetrol Settings page array
//**********************************************************
//core library
require_once ('includes/tcs_core.php');
//image sizes
if (function_exists('add_theme_support')) {
    //add support for the post thumbnails
    add_theme_support('post-thumbnails');
    //add support for the automatic feed links
    add_theme_support('automatic-feed-links');
}

//set custom thumbnails
if (function_exists('add_image_size')) {
    add_image_size('onetrol_logo', 0, 52, true); //(cropped)
}