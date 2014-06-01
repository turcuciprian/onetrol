<!DOCTYPE html>
<!--[if IE 8]><html lang="en" class="ie8" lang="en-US" > <![endif]-->  
<!--[if !IE]> <html <?php language_attributes(); ?>><![endif]--> 
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
    ?>
</head>
<body <?php body_class(); ?>>
    <!-- Main Menu -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">

                        <div class="logo">
                                <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
                        </div>
                        <!--Mobile menu expand button START-->
                        <a  class="button btn btn-default collapsed navbar-toggle" data-toggle="collapse" data-target="#main_menu" href="javascript:void(0);">
                            <i class="fa fa-bars"></i>
                        </a>
                        <!--Mobile menu expand button END-->
                        <!--Main navigation menu START-->
                        <div class="navigation_menu">
                            <!--Main menu list START-->

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
                            <!--Main menu list END-->
                        </div>
                        <!--Main navigation menu END-->
                </div>
            </div>
        </div>
    </header>
    <!-- Main Menu END-->
