<?php
//include function.php parts
//
//theme front end scripts and styles
$include_files[] = 'theme_options/enqueue.php';
//theme filters
$include_files[] = 'theme_options/filters.php';

//including the files from the array
foreach ($include_files as $file) {
    require_once($file);
}

//********************************************************
//  Custom field in the menu - admin
//********************************************************
add_action('init', 'onetrol_init');

function onetrol_init() {
    register_nav_menu('onetrol_Menu', __('Main Menu', 'default'));
}