<?php

//**************************************************************************
////**************************************************************************
////**************************************************************************
//Ajax Populate - One Click Install configuration
//**************************************************************************
//**************************************************************************
//**************************************************************************
//**************************************************************************

function csc_populate_callback() {
    set_time_limit(0);
//*************************************
//*************************************
// Main Home Parent page
//*************************************
//*************************************
// Create root parent post object
    $title = 'Onefolio (Demo data)';
    $my_post = array(
        'post_title' => $title,
        'post_content' => 'empty',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_category' => array(0),
        'post_type' => 'page',
        'menu_order' => 0
    );

// Insert the post into the database
    if (!get_page_by_title($title, 'OBJECT', 'page')) {
        $post_id = wp_insert_post($my_post);
//set the home page custom page template
        update_post_meta($post_id, '_wp_page_template', 'page_templates/cs_page_builder.php');

//set this page as home page in wordpress
        update_option('show_on_front', 'page');
        update_option('page_on_front', $post_id);
    }
    if (!isset($post_id)) {
        $post_id = get_option('page_on_front');
    }
    $CleanScriptCore = new CleanScriptCore();
//the pictures
//$imac_url = $CleanScriptCore->csc_media_sideload_image(get_template_directory_uri() . '/demo_img/imac.png', $post_id, 'Imac picture', 'id');
    $img1 = $CleanScriptCore->csc_media_sideload_image(get_template_directory_uri() . '/demo_img/cyan_kangaroo.jpg', $post_id, 'Cyan Kangaroo', 'id', 'id');
    $img1_id = $CleanScriptCore->cs_get_attachment_id_by_url($img1);
//update the caption
    wp_update_post(array('ID' => $img1_id, 'post_excerpt' => 'https://www.youtube.com/watch?v=k6Kly58LYzY'));


    $gallery_ids = $img1_id . ',' . $img1_id . ',' . $img1_id . ',' . $img1_id . ',' . $img1_id . ',' . $img1_id . ',' . $img1_id . ',' . $img1_id . ',' . $img1_id . ',' . $img1_id;
//the page builder array
    $postArray = array(
        'cs-pb' => array(
            'side' => array(
                'animations' => 'Yes'
            ),
            0 => array(
                'section_type' => 's_home',
                'tonetrol_product_title' => 'A product that you',
                'bottom_product_title' => 'Will truly appreciate',
                'paragraph1_title' => 'Retina Ready',
                'paragraph1_description' => 'The design is also Retina ready, all images come in 1x and 2x and the icons are fontawesome icons, so they can be of any size and still rezor sharp. Ready to look perfect on any screen of any resolution and any pixed density.',
                'paragraph2_title' => 'Bootstrap Ready',
                'paragraph2_description' => 'This PSD was built to be compatible with the latest version of Bootstrap, with default columns and responsiveness in mind. You can find a grid layout layer at the top of the PSD layers.',
                'paragraph2_description' => 'This PSD was built to be compatible with the latest version of Bootstrap, with default columns and responsiveness in mind. You can find a grid layout layer at the top of the PSD layers.',
                'paragraph3_title' => 'Unique Design',
                'paragraph3_description' => 'Every design I build I try to make as unique as possible, with new types of sections., elements and even small elements. You can truly appreciate it if you look at the details.',
                'product_image' => $img1,
                'left_button_text' => 'See more',
                'left_button_tlink' => 'http://themeforest.net/user/CleanScript/portfolio',
                'right_button_text' => 'Download',
                'left_button_tlink' => 'http://themeforest.net/user/CleanScript/portfolio'
            ),
            1 => array(
                'section_type' => 's_portfolio',
                'section_color' => '#ffa646',
                'section_title' => 'Portfolio',
                'section_subtitle' => 'See everything we have been working on',
                'gallery' => $gallery_ids,
            ),
            2 => array(
                'section_type' => 's_services',
                'section_color' => '#279fcd',
                'section_title' => 'Services',
                'section_subtitle' => 'Here is a list of what we do',
                'box1_icon' => 'fa-eye',
                'box1_title' => 'RETINA READY DESIGNS',
                'box1_description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'box2_icon' => 'fa-code',
                'box2_title' => 'DOCUMENTED CODE',
                'box2_description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'box3_icon' => 'fa-group',
                'box3_title' => '24/7 SUPPORT',
                'box3_description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'box4_icon' => 'fa-comments',
                'box4_title' => 'COMUNITY FORUM & SOCIAL',
                'box4_description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'box5_icon' => 'fa-rocket',
                'box5_title' => 'SUPER FAST UPDATES AND FIXES',
                'box5_description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'box6_icon' => 'fa-html5',
                'box6_title' => 'USING ONLY THE LATEST STANDARDS',
                'box6_description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
            ),
            3 => array(
                'section_type' => 's_prices',
                'section_color' => '#ffa646',
                'section_title' => 'Prices',
                'section_subtitle' => 'See how much we charge for each service, pick what fits your needs best',
                'currency' => '$',
                'column1_title' => 'FREE',
                'column1_highlight' => '',
                'column1_price' => '0',
                'column1_description' => 'Everything is 100% free of charge',
                'column1_list' => '24/7 *Support| 
                10 *PSD| Pages',
                'column1_button_text' => 'Buy Now',
                'column1_button_link' => 'http://themeforest.net/user/CleanScript/portfolio',
                'column2_title' => 'ECONOMY',
                'column2_highlight' => '',
                'column2_price' => '24',
                'column2_description' => 'For all pockets',
                'column2_list' => '24/7 *Support| 
                34 *PSD| Pages
                JS, CSS, HTML & PSD *Files|',
                'column2_button_text' => 'Buy Now',
                'column2_button_link' => 'http://themeforest.net/user/CleanScript/portfolio',
                'column3_title' => 'POPULAR',
                'column3_highlight' => 'on',
                'column3_price' => '79',
                'column3_description' => 'Customer Favorite choice',
                'column3_list' => '24/7 *Support| 
                70 *PSD| Pages
                PSD & *WordPress| Theme
                Unlimited free *Updates|',
                'column3_button_text' => 'Buy Now',
                'column3_button_link' => 'http://themeforest.net/user/CleanScript/portfolio',
                'column4_title' => 'BUSINESS',
                'column4_highlight' => '',
                'column4_price' => '110',
                'column4_description' => 'Exclusively for any business user',
                'column4_list' => '24/7 *Support| 
                100 *PSD| Pages
                PSD & *WordPress| Theme
                Unlimited free *Updates|',
                'column4_button_text' => 'Buy Now',
                'column4_button_link' => 'http://themeforest.net/user/CleanScript/portfolio',
            ),
            4 => array(
                'section_type' => 's_team',
                'section_color' => '#d93c7e',
                'section_title' => 'The Team',
                'section_subtitle' => 'A closer look of our team, with pictures!',
                'Member1_picture' => $img1,
                'Member1_name' => 'Jennifer Lawrance',
                'Member1_position' => 'Main Designer',
                'Member1_email' => 'contact@domain.com',
                'Member1_facebook' => 'http://www.facebook.com',
                'Member1_twitter' => 'cleanscript',
                'Member2_picture' => $img1,
                'Member2_name' => 'Melinda May',
                'Member2_position' => 'Main Designer',
                'Member2_email' => 'contact@domain.com',
                'Member2_facebook' => 'http://www.facebook.com',
                'Member2_twitter' => 'cleanscript',
                'Member3_picture' => $img1,
                'Member3_name' => 'Courtney Cox',
                'Member3_position' => 'Main Designer',
                'Member3_email' => 'contact@domain.com',
                'Member3_facebook' => 'http://www.facebook.com',
                'Member3_twitter' => 'cleanscript',
                'Member4_picture' => $img1,
                'Member4_name' => 'Audrey Tautou',
                'Member4_position' => 'Main Designer',
                'Member4_email' => 'contact@domain.com',
                'Member4_facebook' => 'http://www.facebook.com',
                'Member4_twitter' => 'cleanscript',
                'Member5_picture' => $img1,
                'Member5_name' => 'Don Jon',
                'Member5_position' => 'Main Designer',
                'Member5_email' => 'contact@domain.com',
                'Member5_facebook' => 'http://www.facebook.com',
                'Member5_twitter' => 'cleanscript',
                'Member6_picture' => $img1,
                'Member6_name' => 'Jennifer Aniston',
                'Member6_position' => 'Main Designer',
                'Member6_email' => 'contact@domain.com',
                'Member6_facebook' => 'http://www.facebook.com',
                'Member6_twitter' => 'cleanscript',
                'Member7_picture' => $img1,
                'Member7_name' => 'Angelina Jolie',
                'Member7_position' => 'Main Designer',
                'Member7_email' => 'contact@domain.com',
                'Member7_facebook' => 'http://www.facebook.com',
                'Member7_twitter' => 'cleanscript',
                'Member8_picture' => $img1,
                'Member8_name' => 'Anne Hathaway',
                'Member8_position' => 'Main Designer',
                'Member8_email' => 'contact@domain.com',
                'Member8_facebook' => 'http://www.facebook.com',
                'Member8_twitter' => 'cleanscript',
            ),
            5 => array(
                'section_type' => 's_contact',
                'section_color' => '#a74cbd',
                'section_title' => 'Contact Us',
                'section_subtitle' => 'A few ways to get in touch with us',
                'contact_info_title' => 'Contact Info',
                'contact_info_description' => 'We are a small Company composed out of 12 dedicated individuals, with a mission to bring you the best support you ever had in your life, faster than you ever thought possible and cheaper than everywhere else.',
                'company_name' => 'Envato',
                'company_address' => 'Level 13, 2 Elizabeth St, 
Melbourne Victoria 3000 
Australia',
                'contact_email' => 'contact@yourdomain.com',
                'contact_phone' => '+123 456 678',
                'contact_website' => 'http://turcuciprian.com',
                'icon1' => 'fa-envelope',
                'icon1_link' => 'http://turcuciprian.com',
                'icon2' => 'fa-twitter',
                'icon2_link' => 'http://twitter.com',
                'icon3' => 'fa-facebook',
                'icon3_link' => 'http://facebook.com',
                'icon4' => 'fa-google-plus',
                'icon4_link' => 'http://plus.google.com',
                'icon5' => 'fa-linkedin',
                'icon5_link' => 'http://linkedin.com',
                'icon6' => 'fa-pinterest',
                'icon6_link' => 'http://pinterest.com',
                'icon7' => 'fa-dropbox',
                'icon7_link' => 'http://dropbox.com',
                'icon8' => 'fa-dribbble',
                'icon8_link' => 'http://dribbble.com',
                'contact_form_title' => 'Contact Form',
                'contact_form_description' => 'If you want to ask us something, tell us how much you love us, ask us something about our products or services, write anything long and personal or just want yo say hi, please use the following contact form:',
                'contact_name_placeholder_text' => 'Full Name',
                'contact_email_placeholder_text' => 'Email Address',
                'contact_message_placeholder_text' => 'Message',
                'contact_submit_text' => 'Submit',
            )
        )
    );
    $cs_pb_array = $CleanScriptCore->cs_encode(serialize($postArray['cs-pb']));
    update_post_meta($post_id, 'cs-pb', $cs_pb_array);
//*************************************
// Create And set OneFolio Menu
//*************************************
// If it doesn't exist, let's create it.
    $menu_id = 0;
    wp_delete_nav_menu('Main Menu');

    $menu_id = wp_create_nav_menu('Main Menu');
//set the default menu
    $default_menu = array(
        'nav_menu_locations' => array(
            'ofMenu' => $menu_id
        )
    );
    update_option('theme_mods_onefolio', $default_menu);




//**
//The menu items
//**
// Set up default menu items
//Home
    $item_id = wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => __('Home', 'default'),
        'menu-item-parent-id' => 0,
        'menu-item-object-id' => $post_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type',
        'menu-item-position' => 0,
        'menu-item-status' => 'publish'));
    update_post_meta($item_id, '_menu_item_ofSection', "s_home1");
//Portfolio
    $item_id = wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => __('Portfolio', 'default'),
        'menu-item-parent-id' => 0,
        'menu-item-object-id' => $post_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type',
        'menu-item-position' => 0,
        'menu-item-status' => 'publish'));
    update_post_meta($item_id, '_menu_item_ofSection', "s_portfolio1");
//Services
    $item_id = wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => __('Services', 'default'),
        'menu-item-parent-id' => 0,
        'menu-item-object-id' => $post_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type',
        'menu-item-position' => 0,
        'menu-item-status' => 'publish'));
    update_post_meta($item_id, '_menu_item_ofSection', "s_services1");
//Prices
    $item_id = wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => __('Prices', 'default'),
        'menu-item-parent-id' => 0,
        'menu-item-object-id' => $post_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type',
        'menu-item-position' => 0,
        'menu-item-status' => 'publish'));
    update_post_meta($item_id, '_menu_item_ofSection', "s_prices1");
//Team
    $item_id = wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => __('Team', 'default'),
        'menu-item-parent-id' => 0,
        'menu-item-object-id' => $post_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type',
        'menu-item-position' => 0,
        'menu-item-status' => 'publish'));
    update_post_meta($item_id, '_menu_item_ofSection', "s_team1");
//Contact
    $item_id = wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => __('Contact', 'default'),
        'menu-item-parent-id' => 0,
        'menu-item-object-id' => $post_id,
        'menu-item-object' => 'page',
        'menu-item-type' => 'post_type',
        'menu-item-position' => 0,
        'menu-item-status' => 'publish'));
    update_post_meta($item_id, '_menu_item_ofSection', "s_contact1");
    echo "All done. Demo content has been generated.";
    die();
}
