<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <title><?php bloginfo('name'); ?> | <?php
            bloginfo('description');
            wp_title('');
            ?></title>
        <meta charset="<?php bloginfo('charset'); ?>">
        
        <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=2">
        <?php
        wp_head();
        $csc_main = new CleanScriptCore();
        ?>
    </head>
    <body <?php body_class(); ?>>
        <?php
        $citrix_options = get_option('citrix_options');
        if (isset($citrix_options['menu_style']) && !empty($citrix_options['menu_style'])) {
            switch ($citrix_options['menu_style']) {
                case 0:
                    $menu_style = "";
                    break;
                case 1:
                    $menu_style = "left_menu";
                    break;
                case 2:
                    $menu_style = "center_menu";
                    break;
            }
        } else {
            $menu_style = "";
        }
        $logo_text = $csc_main->csc_title_replace(get_bloginfo('name'));
        if (isset($citrix_options['logo_and_text']) && ($citrix_options['logo_and_text'] == 0 || $citrix_options['logo_and_text'] == 1 || empty($citrix_options['logo_and_text']))) {
            $logo_text = $csc_main->csc_title_replace(get_bloginfo('name'));
        }
        ?>
        <!-- Main Menu -->
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="cs_container <?php echo $menu_style; ?>">
                            <div class="logo">
                                <?php if (empty($citrix_options['custom_logo'])) { ?>
                                    <a href="<?php echo esc_url(home_url('/')); ?>"><?php echo $csc_main->csc_title_replace(get_bloginfo('name')); ?></a>
                                <?php } else { ?> 
                                    <a href="<?php echo esc_url(home_url('/')); ?>" class="img">
                                        <?php
                                        echo $logo_text;

                                        $logo = stripslashes($citrix_options['custom_logo']);
                                        $logo_id = $csc_main->cs_get_attachment_id_by_url($logo);
                                        if (isset($citrix_options['logo_and_text']) && ($citrix_options['logo_and_text'] == 1 || $citrix_options['logo_and_text'] == 2)) {
                                            echo wp_get_attachment_image($logo_id, 'citrix_logo', FALSE, array('class' => 'img-responsive'));
                                        }
                                        ?>
                                    </a>
                                <?php } ?> 
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
                                if (has_nav_menu('citrix_Menu')) {
                                    //
                                    wp_nav_menu(
                                            array('theme_location' => 'citrix_Menu',
                                                'menu_id' => 'main_menu',
                                                'menu_class' => 'nav collapsed',
                                                'container' => FALSE,
                                                'walker' => new citrix_nav_menu_theme_walker)
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
            </div>
        </header>
        <!-- Main Menu END-->
