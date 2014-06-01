<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <title><?php bloginfo('name'); ?> | <?php
        bloginfo('description');
        wp_title('');
        ?></title>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=2">
    <!-- Respond.js proxy on external server -->
    <?php
    wp_head();
    global $tcs_core;
    ?>
</head>
<body <?php body_class(); ?>>
    <!-- Main Menu -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                        <div class="logo">
                                <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo $tcs_core->split_text_tag(get_bloginfo('name')); ?></a>
                        </div>
                        <!--Mobile menu expand button START-->
                        <a  class="button btn btn-default collapsed navbar-toggle" data-toggle="collapse" data-target="#main_menu" href="javascript:void(0);">
                            <i class="fa fa-bars"></i>
                        </a>
                        <!--Mobile menu expand button END-->
                        
                        <!--Main navigation menu START-->
                            <?php
                            if (has_nav_menu('onetrol_Menu')) {
                                //
                                wp_nav_menu(
                                        array('theme_location' => 'onetrol_Menu',
                                            'menu_class' => 'nav collapsed',
                                            'container' => FALSE)
                                );
                            } else {
                                $url = admin_url('nav-menus.php');
                                echo '<br/><a href="' . $url . '">Set a Menu</a>';
                            }
                            ?>
                        <!--Main navigation menu END-->
                </div>
            </div>
        </div>
    </header>
    <!-- Main Menu END-->
