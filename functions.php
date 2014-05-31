<?php

//**********************************************************
//onetrol Settings page array
//**********************************************************
require_once ('includes/cleanscript_core.php');

//filter the admin menu walker to the system
add_filter('wp_edit_nav_menu_walker', 'onetrol_icon_nav_edit_walker', 10, 2);

function onetrol_icon_nav_edit_walker($walker, $menu_id) {
    return 'onetrol_menu_walker';
}

add_action('wp_update_nav_menu_item', 'onetrol_section_nav_update', 10, 3);
add_filter('wp_setup_nav_menu_item', 'onetrol_add_custom_nav_fields');

function onetrol_add_custom_nav_fields($menu_item) {
    $menu_item->opSection = get_post_meta($menu_item->ID, '_menu_item_opSection', true);
    return $menu_item;
}

//********************************************************
//  Custom field in the menu - admin
//********************************************************
add_action('init', 'onetrol_init');

function onetrol_init() {
    register_nav_menu('onetrol_Menu', __('Main Menu', 'default'));
}

function onetrol_section_nav_update($menu_id, $menu_item_db_id, $args) {
    if (isset($_REQUEST['menu-item-opSection'])) {
        if (is_array($_REQUEST['menu-item-opSection'])) {
            $custom_value = $_REQUEST['menu-item-opSection'][$menu_item_db_id];
            update_post_meta($menu_item_db_id, '_menu_item_opSection', $custom_value);
        }
    }
}

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