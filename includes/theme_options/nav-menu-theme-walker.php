<?php

/**
 * Custom Walker
 *
 * @access      public
 * @since       1.0 
 * @return      void
 */
class citrix_nav_menu_theme_walker extends Walker_Nav_Menu {

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ( $depth ) ? str_repeat("\t", $depth) : '';

        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        if ($item->menu_order == 1 && is_page() && is_front_page()) {
            $classes[] = 'current-menu-item';
        }
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names . '>';
        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value) || $value != 0) {
//                get parent url
                $parent_id = @get_page($item->object_id)->post_parent;
                $parent_url = get_permalink($parent_id);
                $aclass = '';
                $ofHash = '';
                global $post;
                $parent_post_id = get_option('page_on_front');
                $ofHash = '#' . $item->opSection;
                if ($item->opSection == '0') {
                    $ofHash = '';
                }
                if ($item->object_id != $post->ID) {
                    $aclass = 'class="external"';
                }



                $value = ( 'href' === $attr ) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . $ofHash . '" ' . $aclass;
            }
        }
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

}



?>