<?php

//remove current-menu-item from the menu on pagebuilder pages (it's on all the li's because the menu is made out of the same page menu item)
//function onetrol_nav_menu_css_class_filter($classes, $item) {
//
//    if (($key = array_search('current-menu-item', $classes)) !== false) {
//        unset($classes[$key]);
//    }
//    return $classes;
//}
//
//add_filter('nav_menu_css_class', 'onetrol_nav_menu_css_class_filter', 10, 2);
