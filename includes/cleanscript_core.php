<?php
/*
 * Here you can find the main libraries that make most of the custom functionality of the theme.
 * 
 * by CleanScript
 */
$include_files = array();
//Sections confuguration file
$include_files[] = 'page_builder/sections_array.php';
//One Click install file
$include_files[] = 'page_builder/oci.php';
//*****************
//Menu Walkers
//*****************
//admin menu walker
$include_files[] = 'theme_options/nav-menu-walker.php';
//front end output menu walker
$include_files[] = 'theme_options/nav-menu-theme-walker.php';
//Theme Specific includes
//Meta boxes dynamic code
$include_files[] = 'theme_options/meta-boxes.php';
//theme front end scripts and styles
$include_files[] = 'theme_options/enqueue.php';
//theme filters
$include_files[] = 'theme_options/filters.php';

//including the files from the array
foreach ($include_files as $file) {
    require_once($file);
}

//*******************************
//ACTIONS
//*******************************
$csc_var = new CleanScriptCore();

add_action('admin_menu', array($csc_var, 'cs_theme_page'));
add_action('admin_init', array($csc_var, 'cs_admin_init'));
//admin scripts
add_action('admin_enqueue_scripts', array($csc_var, 'csc_admin_enqueue_scripts'));
add_action('admin_footer', array($csc_var, 'csc_ajax'));
//one click install
add_action('wp_ajax_csc_populate', 'csc_populate_callback');
//Add sections callback
//'page_builder/oci.php' - path to function file
add_action('wp_ajax_csc_ajax_sections', array($csc_var, 'csc_ajax_sections_callback'));

class CleanScriptCore {

    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    public function __construct() {
        
    }

    /**
     * Add options page
     */
    public function cs_theme_page() {
// This page will be under "Settings"
        add_theme_page('Theme Settings', 'Theme Settings', 'administrator', 'cs_theme_options', array($this, 'cs_menu_page'));
    }

    /**
     * Options page callback
     */
    public function cs_menu_page() {
        global $options_page_arr;
// Set class property
        $this->options = get_option($options_page_arr['option_name']);
        ?>
        <div class="wrap cs_admin_page">
            <?php screen_icon(); ?>
            <h2>Theme Settings</h2>           
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields($options_page_arr['option_group']);
                do_settings_sections($options_page_arr['page_name']);
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function cs_admin_init() {
        global $options_page_arr;
        register_setting(
                $options_page_arr['option_group'], // Option group
                $options_page_arr['option_name']
        );
        foreach ($options_page_arr['sections'] as $cs_section) {
            add_settings_section(
                    $cs_section['id'], // ID
                    $cs_section['title'], // Title
                    array($this, 'cs_print_section_info'), // Callback
                    $options_page_arr['page_name'] // Page
            );
            foreach ($cs_section['fields'] as $field) {
                $field_options = NULL;
                if (isset($field['options'])) {
                    $field_options = $field['options'];
                }
                add_settings_field(
                        $field['id'], // ID
                        $field['title'], // Title 
                        array($this, 'cs_fields_callback'), // Callback
                        $options_page_arr['page_name'], // Page
                        $cs_section['id'], // Section         
                        array(
                    'id' => $field['id'],
                    'option_name' => $options_page_arr['option_name'],
                    'type' => $field['type'],
                    'options' => $field_options
                        )
                );
            }
        }
    }

//    enqueue and register admin scripts
    public function csc_admin_enqueue_scripts() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
        wp_enqueue_style('jquery-ui-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.css');
        wp_enqueue_script('media-upload');
        wp_enqueue_style('GoogleFonts', 'http://fonts.googleapis.com/css?family=Roboto:400,100,300|Open+Sans|Fjalla+One');
        wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/includes/page_builder/js/jquery.magnific-popup.min.js', array(), '1.0.0', true);
        wp_enqueue_script('spectrum-js', get_template_directory_uri() . '/includes/page_builder/js/spectrum.js', array(), '1.0.0', true);

        wp_enqueue_style('font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css');
        wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/includes/page_builder/css/magnific-popup.css');
        //color picker css
        wp_enqueue_style('spectrum-css', get_template_directory_uri() . '/includes/page_builder/css/spectrum.css');
        wp_enqueue_style('cs-admin-pb-style', get_template_directory_uri() . '/includes/page_builder/css/pb_admin.css');

        if (isset($_GET['page']) && $_GET['page'] == 'cs_theme_options') {
            wp_enqueue_script('jquery');
            wp_enqueue_script('thickbox');
            wp_enqueue_style('thickbox');
            wp_enqueue_script('media-upload');
//            media upload script for theme settings page
            wp_enqueue_script('cs-admin-script', get_template_directory_uri() . '/includes/page_builder/js/admin_script.js', array('jquery', 'media-upload', 'thickbox'), '1.0.0', true);
        }
    }

    /**
     * Print the Section text
     */
    public function cs_print_section_info() {
        
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function cs_fields_callback($args) {
        switch ($args['type']) {
            case 'input':
                printf('<input type="text" id="' . $args['id'] . '" name="' . $args['option_name'] . '[' . $args['id'] . ']" value="%s" />', isset($this->options[$args['id']]) ? esc_attr($this->options[$args['id']]) : '');
                break;
            case 'radio':
                $value = isset($this->options[$args['id']]) ? esc_attr($this->options[$args['id']]) : '';
                foreach ($args['options'] as $key => $option) {
                    printf('<input type="radio" name="' . $args['option_name'] . '[' . $args['id'] . ']" ' . checked($key, $value, false) . ' value="' . $key . '" />' . $option . '<br/> ');
                }

                break;
            case 'radio_special':
                $value = isset($this->options[$args['id']]) ? esc_attr($this->options[$args['id']]) : '';
                ?>
                <div class="button-group" data-toggle="buttons">
                    <?php foreach ($args['options'] as $key => $option) { ?>
                        <label class="button button-default <?php $this->cs_BSradio_selected($key, $value); ?>">
                            <input type="radio" name = "<?php echo $args['option_name']; ?>[<?php echo $args['id']; ?>][<?php echo $args['id']; ?>]" <?php checked($value, $key); ?> value="<?php echo $key; ?>"> <?php echo $option; ?>
                        </label>
                    <?php } ?>
                </div>
                <?php
                break;
            case 'radioimg':
                if (!isset($args['options'])) {
                    break;
                }
                foreach ($args['options'] as $option) {
                    printf('<input type="radio" name="' . $args['option_name'] . '[' . $args['id'] . ']" ' . checked(isset($this->options[$args['id']]) ? esc_attr($this->options[$args['id']]) : '', $option['value'], false) . ' value="' . $option['value'] . '" /> <img src="' . $option['img_url'] . '" alt=""/> - ' . $option['text'] . '<br/><br/> ');
                }
                break;
            case 'upload':
                $value = '<img src="" alt="" />';
                $button = 'Upload';
                if (!empty($this->options[$args['id']])) {
                    $value = '<img src="' . $this->options[$args['id']] . '" alt="" />';
                    $button = 'Remove';
                }
                printf('<div class="lmub">');
                printf('<span class="status">' . $value . '</span> <br/><input type="button" id="button" value="' . $button . '">');
                printf('<input type="hidden" id="hidden_logo_url"  name="' . $args['option_name'] . '[' . $args['id'] . ']" value="%s" />', isset($this->options[$args['id']]) ? esc_attr($this->options[$args['id']]) : '');
                printf('<div>');
                break;
            case 'ajax-button':
                printf('<input type="hidden" value="' . get_template_directory_uri() . '/img/ajax-loader.gif" class="ajax_loader" />');
                printf('<span class="ajax_load"></span><br/><input type="button" class="ajax_button" value="Load dummy data" />');
                printf('<input type="hidden" class="ajax_url" value="' . get_template_directory_uri() . '/includes/populate.php" />');
                break;
            case 'fa':
                $classValue = 'fa';
                $value = isset($this->options[$args['id']]) ? esc_attr($this->options[$args['id']]) : '';
                if (!empty($value)) {
                    $classValue = 'fa ' . $value;
                }
                ?>
                <div class="button button-default icon-button"><i class="<?php echo $classValue; ?>"></i></div>
                <input type="hidden" class="<?php echo $args['id']; ?>" name="<?php echo $args['option_name'] . '[' . $args['id']; ?>]" value="<?php echo $value; ?>" />
                <input type="button" class="button button-default insert_icon_fa" id="<?php echo $args['id']; ?>" value="Select Icon">
                <?php
                break;
            case 'extra':
                $this->fa_icons_generate();
                break;
        }
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function cs_meta_boxes_add_generate($values, $the_array) {

        $lhsh_main_title = isset($values['lhsh_main_title']) ? $values['lhsh_main_title'][0] : '';
        if (empty($the_array['warning'])) {
            $begin_output = '';
        } else {
            $begin_output = '<div class="cs_warning"><span>Warning!</span> This Section is a page template, do not try to view this page as a page, this is for section content generating purposes only!</div>';
        }
        $output = $begin_output;
        foreach ($the_array as $content_block) {
            if (is_array($content_block)) {
//$output .= '<div class="wp-editor-container" id="postcustomstuff">';
                $output .= '<h4>' . $content_block['name'] . '</h4>';
                $output .= '<div class = "inside" >';
                $output .= '<table id="newmeta">';
                $output .= '<tbody>';
                foreach ($content_block['content'] as $column) {
                    $output .='<tr>';
                    foreach ($column as $field) {
                        $value = isset($values[$field['name']]) ? $values[$field['name']][0] : '';
                        $output .='<td class="left">';
                        $output .='<p class="inside"><strong>' . $field['text'] . '</strong></p>';
                        switch ($field['type']) {
                            case 'input':
                                $output .= '<input type="text" name="' . $field['name'] . '" id="title" value="' . $value . '" />';
                                break;
                            case 'textarea':
                                $output .='<textarea class="wp-editor-area" name="' . $field['name'] . '" id="' . $field['name'] . '" rows="5">' . $value . '</textarea>';
                                break;
                            case 'description':
                                $output .='<p class="inside">' . $field['description'] . '</p>';
                                break;
                            case 'dropdown':
                                switch ($field['output_type']) {
                                    case 'page':
                                        $selected = selected((string) $value, (string) "0", false);
                                        $output .='<select name="' . $field['name'] . '">';
                                        $output .='<option value="0" ' . $selected . ' > None (default) </option>';
                                        $pages = get_pages();
                                        foreach ($pages as $page) {
                                            $selected = selected($value, $page->ID, false);
                                            $output .='<option value="' . $page->ID . '" ' . $selected . '>' . $page->post_title . '</option>';
                                        }
                                        $output .='</select>';
                                        break;
                                    case 'post':
                                        $selected = selected($value, "0", false);
                                        $output .='<select name="' . $field['name'] . '">';
                                        $output .='<option value="0" ' . $selected . '> None (default) </option>';
                                        $posts = get_posts();
                                        foreach ($posts as $post) {
                                            $selected = selected($value, $post->ID, false);
                                            $output .='<option value="' . $post->ID . '" ' . $selected . '>' . $post->post_title . '</option>';
                                        }
                                        $output .='</select>';
                                        break;
                                    case 'fontawesome':
                                        global $fontawesome_icons;
                                        $output .='<select name="' . $field['name'] . '" style="font-family:\'FontAwesome\',\'Arial\';font-size:24px;">';
                                        $output .='<option value="">None (default)</option>';
                                        foreach ($fontawesome_icons as $icon) {
                                            $output .= '<option value="' . $icon[0] . '" ' . selected($icon[0], $value, false) . ' >' . $icon[1];
                                        }
                                        $output .='</select>';
                                        break;
                                    case 'custom':
                                        $output .='<select name="' . $field['name'] . '">';
                                        $output .='<option value="">Default</option>';
                                        foreach ($field['options'] as $option) {
                                            $output .= '<option value="' . $option['value'] . '" ' . selected($option['value'], $value, false) . ' >' . $option['text'];
                                        }
                                        $output .='</select>';
                                        break;
                                    case 'cpt':
                                        $selected = selected($value, "0", false);
                                        $output .='<select name="' . $field['name'] . '">';
                                        $output .='<option value="0" ' . $selected . '> None (default) </option>';
                                        $posts = get_posts();
                                        foreach ($posts as $post) {
                                            $selected = selected($value, $post->ID, false);
                                            $output .='<option value="' . $post->ID . '" ' . $selected . '>' . $post->post_title . '</option>';
                                        }
                                        $output .='</select>';
                                        break;
                                }
                                break;
                            case 'radio':
                                foreach ($field['options'] as $radio_button) {
                                    $output .='<input type="radio" name="' . $field['name'] . '" value="' . $radio_button['value'] . '" style="width:auto;margin-top:0px;" ' . checked($value, $radio_button['value'], false) . ' />' . $radio_button['text'] . '<br/>';
                                }
                                break;
                            case 'checkbox':
                                $output .='<input type="checkbox" name="' . $field['name'] . '" value="' . $field['value'] . '"  style="width:auto;margin-top:0px;" ' . checked($value, $field['value'], false) . ' />' . $field['description'];
                                break;
                            case 'upload':
                                $output .='<img width="200" height="auto" src="' . $value . '" id="' . $field['name'] . '_img" alt=""/>';
                                $upload_button_text = 'Upload';
                                if (!empty($value)) {
                                    $output .='<br/>';
                                    $upload_button_text = 'Remove';
                                }
                                $output .='<input type="hidden" name="' . $field['name'] . '" id="' . $field['name'] . '_hidden" value="' . $value . '"  />'
                                        . '<input type="button" class="cs_upload_button button" style="width:auto;" id="' . $field['name'] . '" value="' . $upload_button_text . '" /><p class="inside">' . $field['description'] . "</p>";
                                break;
                        }
                        $output .= '</td>';
                    }
                    $output .='</tr>';
                }
                $output .= '</tbody>';
                $output .= '</table>';
//$output .= '</div>';
                $output .= '</div><br/><hr/><br/>';
            } else {
                continue;
            }
        }
        $output .= wp_nonce_field('my_' . $the_array['nonce'], $the_array['nonce'], true);
        return $output;
    }

    public function cs_pb_get_value($fields_arr, $name) {
        if (isset($fields_arr))
            foreach ($fields_arr as $field => $value) {
                if ($field == $name) {
                    return $value;
                }
            }
        return '';
    }

    /*
     * 
     * 
     * *************************************************************************************************
     * *************************************************************************************************
     * 
     * 
     * Page builder Code
     * 
     * 
     * *************************************************************************************************
     * *************************************************************************************************
     * 
     * 
     *  */

    public function cs_pb_sections_fields_generate($sections_array, $section_type, $count_id, $values_array = null) {
//get the section array and set it to $fields_array
        $fields_array = array();
        foreach ($sections_array as $section_array) {
            if ($section_type == $section_array['section_type']) {
                $fields_array = $section_array;
                break;
            }
        }
        ?>
        <div class="container">
            <table class="form-table">
                <tbody>
                    <?php
                    foreach ($fields_array['fields'] as $field) {
                        $cs_before = '<tr valign="top">
                            <th scope="row">
                                <label>' . $field['text'] . '</label>
                            </th>
                            <td>';
                        $cs_after = '<p class="description">' . $field['description'] . '</p>'
                                . '</td>'
                                . '</tr>';

                        $value = stripslashes($this->cs_pb_get_value($values_array, $field['name']));
                        switch ($field['type']) {
                            case 'textbox':
                                ?>
                                <?php echo $cs_before; ?>
                            <input type = "text" class="regular-text" name = "cs-pb[<?php echo $count_id; ?>][<?php echo $field['name']; ?>]" value = "<?php echo $value; ?>" />
                            <?php echo $cs_after; ?>
                            <?php
                            break;
                        case 'textarea':
                            ?>
                            <?php echo $cs_before; ?>
                            <textarea  class="large-text" name = "cs-pb[<?php echo $count_id; ?>][<?php echo $field['name']; ?>]" rows="10" cols="50" ><?php echo $value; ?></textarea>

                            <?php echo $cs_after; ?>
                            <?php
                            break;
                        case 'checkbox':
                            ?>
                            <?php echo $cs_before; ?>
                            <input type="checkbox"  name = "cs-pb[<?php echo $count_id; ?>][<?php echo $field['name']; ?>]" <?php
                            checked($value, 'on');
                            echo $value;
                            ?> ><?php
                                   echo $cs_after;
                                   break;
                               case 'radio_special':
                                   echo $cs_before;
                                   ?>
                            <div class="button-group" data-toggle="buttons">
                                <?php foreach ($field['options'] as $option) { ?>
                                    <label class="button button-default <?php $this->cs_BSradio_selected($option, $value); ?>">
                                        <input type="radio" name = "cs-pb[<?php echo $count_id; ?>][<?php echo $field['name']; ?>]" <?php checked($value, $option); ?> value="<?php echo $option; ?>"> <?php echo $option; ?>
                                    </label>
                                <?php } ?>
                            </div>
                            <?php echo $cs_after; ?>
                            <?php
                            break;
                        case 'radio':
                            ?>
                            <?php echo $cs_before; ?>
                            <input type="radio"  name = "cs-pb[<?php echo $count_id; ?>][<?php echo $field['name']; ?>]" <?php
                            checked($value, $field['radio_value']);
                            ?> value="<?php echo $field['radio_value']; ?>"><?php
                                   echo $cs_after;
                                   break;
                               case 'upload':
                                   $buttonText = $field['button_text'][0];
                                   if (!empty($value)) {
                                       $buttonText = $field['button_text'][1];
                                   }
                                   ?>
                                   <?php echo $cs_before; ?>
                            <img src="<?php echo $value; ?>" width="100" alt="" class="img-thumbnail img-responsive" />
                            <input type="hidden"  name = "cs-pb[<?php echo $count_id; ?>][<?php echo $field['name']; ?>]" class="cs_mb_hidden" value="<?php echo $value; ?>" />
                            <input type="button" class=" button button-default cs_mb_upload" value="<?php echo $buttonText; ?>" />
                            <?php echo $cs_after; ?>
                            <?php
                            break;
                        case 'upload-gallery':
                            $buttonText = $field['button_text'][0];
                            $remove_status = ' disabled="disabled" ';
                            if (!empty($value)) {
                                $buttonText = $field['button_text'][1];
                                $remove_status = '';
                            }
                            ?>
                            <?php echo $cs_before; ?>
                            <input type="hidden"  name = "cs-pb[<?php echo $count_id; ?>][<?php echo $field['name']; ?>]" class="cs_mb_hidden" id="cs-pb[<?php echo $count_id; ?>][<?php echo $field['name']; ?>]" value="<?php echo $value; ?>" />
                            <input type="button" class="button button-default cs_mb_upload_gallery" value="<?php echo $buttonText; ?>" />
                            <input type="button" class="button button-default cs_mb_remove_gallery" <?php echo $remove_status; ?> value="<?php echo $field['button_text'][2]; ?>" />
                            <?php echo $cs_after; ?>
                            <?php
                            break;
                        case 'dropdown':
                            switch ($field['option_type']) {
                                case 'posts':
                                    ?>
                                    <?php echo $cs_before; ?>
                                    <select name="cs-pb[<?php echo $count_id; ?>][<?php echo $field['name']; ?>]"> 
                                        <option value="0" <?php selected($value, "0") ?> > None (default) </option><?php
                                        $pages = get_posts();
                                        foreach ($pages as $page) {
                                            ?><option value="<?php echo$page->ID; ?>" <?php selected($value, $page->ID); ?>><?php echo $page->post_title; ?></option><?php
                                        }
                                        ?></select>
                                    <?php echo $cs_after; ?>
                                    <?php
                                    break;
                                case 'pages':
                                    ?>
                                    <?php echo $cs_before; ?>
                                    <select name="cs-pb[<?php echo $count_id; ?>][<?php echo $field['name']; ?>]"> 
                                        <option value="0" <?php selected($value, "0") ?> > None (default) </option><?php
                                        $pages = get_pages();
                                        foreach ($pages as $page) {
                                            ?><option value="<?php echo$page->ID; ?>" <?php selected($value, $page->ID); ?>><?php echo $page->post_title; ?></option><?php
                                        }
                                        ?></select>
                                    <?php echo $cs_after; ?>
                                    <?php
                                    break;
                                case 'categories':
                                    ?>
                                    <?php echo $cs_before; ?>
                                    <select name="cs-pb[<?php echo $count_id; ?>][<?php echo $field['name']; ?>]"> 
                                        <option value="0" <?php selected($value, "0") ?> > None (default) </option><?php
                                        $pages = get_categories();
                                        foreach ($pages as $page) {
                                            ?><option value="<?php echo$page->cat_ID; ?>" <?php selected($value, $page->cat_ID); ?>><?php echo $page->name; ?></option><?php
                                        }
                                        ?></select>
                                    <?php echo $cs_after; ?>
                                    <?php
                                    break;
                                case 'tags':
                                    ?>
                                    <?php echo $cs_before; ?>
                                    <select name="cs-pb[<?php echo $count_id; ?>][<?php echo $field['name']; ?>]"> 
                                        <option value="0" <?php selected($value, "0") ?> > None (default) </option><?php
                                        $pages = get_tags();
                                        foreach ($pages as $page) {
                                            ?><option value="<?php echo$page->term_id; ?>" <?php selected($value, $page->term_id); ?>><?php echo $page->name; ?></option><?php
                                        }
                                        ?></select>
                                    <?php echo $cs_after; ?>
                                    <?php
                                    break;
                                case 'cf7':
                                    $selected = selected($value, "0", false);
                                    ?>
                                    <?php echo $cs_before; ?>
                                    <select  name="cs-pb[<?php echo $count_id; ?>][<?php echo $field['name']; ?>]">
                                        <option value = "0" <?php echo $selected;
                                    ?>> None (default) </option>';
                                                <?php
                                                $loop = new WP_Query(array('post_type' => 'wpcf7_contact_form'));
                                                while ($loop->have_posts()) {
                                                    $loop->the_post();
                                                    $selected = selected($value, $loop->post->ID, false);
                                                    ?>
                                            <option value="<?php echo $loop->post->ID; ?>"<?php echo $selected; ?>><?php echo get_the_title(); ?></option>
                                            <?php
                                        }
                                        wp_reset_postdata();
                                        ?>
                                    </select>
                                    <?php echo $cs_after; ?>
                                    <?php
                                    break;
                            }

                            break;
                        case 'fa':
                            $classValue = 'fa';
                            if (!empty($value)) {
                                $classValue = 'fa ' . $value;
                            }
                            ?>
                            <?php echo $cs_before; ?>
                            <div class="button button-default icon-button"><i class="<?php echo $classValue; ?>"></i></div>
                            <input type="hidden" class="<?php echo $field['name'] . $count_id; ?>" name="cs-pb[<?php echo $count_id; ?>][<?php echo $field['name']; ?>]" value="<?php echo $value; ?>" />
                            <input type="button" class="button button-default insert_icon_fa" id="<?php echo $field['name'] . $count_id; ?>" value="<?php echo $field['text_value']; ?>">
                            <?php echo $cs_after; ?>
                            <?php
                            break;
                        case 'color':
                            if (empty($value)) {
                                $value = $field['default_value'];
                            }
                            ?>
                            <?php echo $cs_before; ?>
                            <input type="color" class="colorpicker" name="cs-pb[<?php echo $count_id; ?>][<?php echo $field['name']; ?>]" value="<?php echo $value; ?>" />
                            <?php echo $cs_after; ?>
                            <?php
                            break;
                        case 'sub-section':
                            ?> <ul class = "cspb_sortable">
                            <?php
                            ?>
                            </ul> <?php
                            break;
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    private function cs_BSradio_selected($value1, $value2) {

        if ($value1 == $value2) {
            echo " active ";
        }
    }

    public function fa_icons_generate() {
        ?>
        <div class = "fa_icons_div mfp-hide">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        global $fa_array;
                        foreach ($fa_array as $fa) {
                            ?>
                            <button class="button button-default"><i class="fa <?php echo $fa; ?>" id="<?php echo $fa; ?>"></i></button>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public function cs_pb_sections_generate($sections_array, $count_id, $s_type, $values_array = null) {
        foreach ($sections_array as $section_array) {
            $section_name = '';
            if ($s_type == $section_array['section_type']) {
                $section_name = $section_array['section_name'];
                break;
            }
        }
        ?>
        <li>
            <h3><?php echo $section_name; ?><a class="cs_right" href="javascript:void(0);"><i class="fa fa-minus-circle"></i></a></h3>
            <div class="item-<?php echo $count_id; ?> item-content collapse out">
                <input type="hidden" name="cs-pb[<?php echo $count_id; ?>][section_type]" value ="<?php echo $s_type; ?>" />
                <?php $this->cs_pb_sections_fields_generate($sections_array, $s_type, $count_id, $values_array); ?>
            </div>
        </li>
        <?php
    }

    public function cs_meta_boxes_add_post_save($post_id) {

// Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
// if our nonce isn't there, or we can't verify it, bail 
        if (!isset($_POST['cs_nounce']) || !wp_verify_nonce($_POST['cs_nounce'], 'cs_nounce')) {
            return;
        }
// if our current user can't edit this post, bail  
        if (!current_user_can('edit_post')) {
            return;
        }
        $allowed = array(
            'a' => array(// on allow a tags  
                'href' => array() // and those anchors can only have href attribute  
            )
        );
        if (!empty($_POST['cs-pb'])) {
            $cs_pb_array = $this->cs_encode(serialize($_POST['cs-pb']));
            update_post_meta($post_id, 'cs-pb', $cs_pb_array);
        } else {
            delete_post_meta($post_id, 'cs-pb');
        }
    }

    public function cs_generate_page_builder() {
        add_action('add_meta_boxes', array($this, 'cs_pb_meta_box_add'));
//Save the POST data for pagebuilder
       add_action('save_post', array($this, 'cs_options_save'));
//remove the content editor
        add_action('init', array($this, 'cs_remove_post_type_support'), 10);
    }

    public function cs_pb_meta_box_add() {
        //create the side field information
        add_meta_box('cs_meta_box-id', 'One Page Settings', array($this, 'cs_side_meta_box_create'), 'page', 'side', 'low');
//        the pagebuilder meta box content
        add_meta_box('cs_pb_meta_box-id', 'Page builder', array($this, 'cs_pb_meta_box_create'), 'page', 'normal', 'high');
    }

// creates the side meta box content
    function cs_side_meta_box_create() {
        global $post;
        $val = get_post_custom($post->ID);
        $values = unserialize($this->cs_decode($val['cs-pb'][0]));
        $field['animations'][0] = 'Yes';
        $field['animations'][1] = 'No';
        ?>
        <h2>Animations</h2>
        <div class="button-group" data-toggle="buttons">            
            <?php
            foreach ($field['animations'] as $key => $option) {
                ?>
                <label class="button button-default <?php $this->cs_BSradio_selected($values['side']['animations'], $option); ?>">
                    <input type="radio" name="cs-pb[side][animations]" <?php checked($values['side']['animations'], $option); ?> value="<?php echo $option; ?>"> <?php echo $option; ?>
                </label>
            <?php } ?>
        </div>
        <br />
        <br />
        <strong>Activate animations? </strong> <br />(Default is <strong>No</strong>)
        <?php
    }

    public function cs_generate_sections() {
        global $sections_array;
        global $post;

        $values_arr = get_post_meta($post->ID, 'cs-pb', true);
        $values_array = unserialize($this->cs_decode($values_arr));
        ?>
        <div class = "cs_pb_section">
            <ul class="cspb_sortable">
                <?php
                $count_id = 0;
                if (!empty($values_array))
                    foreach ($values_array as $key => $fields_arr) {
                        if ($key !== 'side') {
                            $this->cs_pb_sections_generate($sections_array, $count_id, $fields_arr['section_type'], $fields_arr);
                            $count_id++;
                        }
                    }
                ?>
            </ul>
            <?php $this->fa_icons_generate(); ?>
        </div>
        <?php
    }

    public function cs_pb_meta_box_create() {
        global $sections_array;
        global $post;
        $this->cs_generate_sections();
        ?>
        <div class="text-center"><input type = "button" class="button button-primary button-lg pbmb_add_section" name = "none" value = "Add Section" /></div> 
        <!--The popup Code Start-->
        <div class="popup_content mfp-hide">
            <input type="hidden" class="tm_ajax_url" value="<?php echo get_template_directory_uri(); ?>/includes/page_builder/ajax_sections.php" />
            <?php foreach ($sections_array as $section) { ?>
                <div class="section_button button button-default" id="<?php echo $section['section_type']; ?>">
                    <span><?php echo $section['section_name']; ?></span>
                    <?php if (isset($section['section_image'])) { ?><img src="<?php echo get_template_directory_uri(); ?>/includes/page_builder/img/sections/<?php echo $section['section_image']; ?>" alt="<?php echo $section['section_name']; ?>" /> <?php } ?>
                </div>
                <?php
            }
            wp_nonce_field('cs_nounce', 'cs_nounce');
            ?>
        </div>
        <!--The popup Code END-->
        <?php
    }

    public function cs_options_save($post_id) {
//Start saving the pagebuilder fields:
        $this->cs_meta_boxes_add_post_save($post_id);
//Start saving the pagebuilder side fields:
        //$this->cs_meta_boxes_add_post_side_save($post_id);
    }

    public function cs_remove_post_type_support() {
        remove_post_type_support('page', 'editor');
    }

//replaces * and | with <strong> and </strong>
    public function cs_text_str_replace($string, $tag = "strong") {
        $string = str_replace("*", "<" . $tag . ">", $string);
        $string = str_replace("|", "</" . $tag . ">", $string);
        return $string;
    }

    public function cs_get_attachment_id_by_url($url) {
// Split the $url into two parts with the wp-content directory as the separator.
        $parse_url = explode(parse_url(WP_CONTENT_URL, PHP_URL_PATH), $url);

// Get the host of the current site and the host of the $url, ignoring www.
        $this_host = str_ireplace('www.', '', parse_url(home_url(), PHP_URL_HOST));
        $file_host = str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));

// Return nothing if there aren't any $url parts or if the current host and $url host do not match.
        if (!isset($parse_url[1]) || empty($parse_url[1]) || ( $this_host != $file_host ))
            return;

// Now we're going to quickly search the DB for any attachment GUID with a partial path match.
// Example: /uploads/2013/05/test-image.jpg
        global $wpdb;

        $prefix = $wpdb->prefix;
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts WHERE guid RLIKE %s;", $parse_url[1]));

// Returns null if no attachment is found.
        return $attachment[0];
    }

    public function cs_split_price($price, $value = '') {
        $delimiter_pos = strpos($price, '.');
        if ($value == 'decimal') {
            if (strpos($price, '.') === FALSE) {
                return '00';
            }
            return substr($price, $delimiter_pos + 1);
        }
        if (strpos($price, '.') === FALSE) {
            return $price;
        }
        return substr($price, 0, $delimiter_pos);
    }

    public function cs_link_n_page($cs_link, $cs_page_id) {
        $button_link = '#';
        if ($cs_link == "") {
            if ($cs_page_id > 0) {
                $button_link = get_permalink($cs_page_id);
            }
        } else {
            $button_link = $cs_link;
        }
        return $button_link;
    }

    public function cs_price_list($string, $icon = false) {
        $list_arr = explode("\n", $string);
        $fa_icon = "fa-check";
        $result = "";
        foreach ($list_arr as $list_element) {
            $list_element = $this->cs_text_str_replace($list_element, 'strong');
            $result .= '<li>' . $list_element . '</li>';
        }
        return $result;
    }

    public function cs_encode($value) {

        $func = 'base64' . '_encode';
        return @$func($value);
    }

//encode decode functions:
    public function cs_decode($value) {

        $func = 'base64' . '_decode';
        if (is_array($value)) {
            return false;
        } else {
            return @$func($value);
        }
    }

//    Add sections  ajax callback
    function csc_ajax_sections_callback() {
        $count_id = 0;
        if (isset($_POST['count_id'])) {
            $count_id = $_POST['count_id'];
        }
        if ($_POST['s_type']) {
            $s_type = $_POST['s_type'];
        }
        global $sections_array;
        $this->cs_pb_sections_generate($sections_array, $count_id, $s_type);
        die();
    }

    function csc_preg_callback($matches) {
        // as usual: $matches[0] is the complete match
        // $matches[1] the match for the first subpattern
        // enclosed in '(...)' and so on
        return $matches;
    }

    // Format HTML for mail contact form submission
    function csc_format_mail_text($content, $html = false) {
        $content = str_replace("\'", "'", $content);
        $regex = '/(\[?)\[\s*([a-zA-Z_][0-9a-zA-Z:._-]*)\s*\](\]?)/';

        if ($html) {
            $callback = array(&$this, csc_preg_callback);
        } else {
            $callback = array(&$this, 'mail_callback');
        }

        return preg_replace_callback($regex, $callback, $content);
    }

    function csc_media_sideload_image($file, $post_id, $desc = null, $return = "html") {
        if (!empty($file)) {
// Download file to temp location
            $tmp = download_url($file);

// Set variables for storage
// fix file filename for query strings
            preg_match('/[^\?]+\.(jpe?g|jpe|gif|png)\b/i', $file, $matches);
            $file_array['name'] = basename($matches[0]);
            $file_array['tmp_name'] = $tmp;

// If error storing temporarily, unlink
            if (is_wp_error($tmp)) {
                @unlink($file_array['tmp_name']);
                $file_array['tmp_name'] = '';
            }

// do the validation and storage stuff
            $id = media_handle_sideload($file_array, $post_id, $desc);
// If error storing permanently, unlink
            if (is_wp_error($id)) {
                @unlink($file_array['tmp_name']);
                return $id;
            }

            $src = wp_get_attachment_url($id);
        }

// Finally check to make sure the file has been saved, then return the html
        if (!empty($src)) {
            return $src;
            $alt = isset($desc) ? esc_attr($desc) : '';
            $html = "<img src='$src' alt='$alt' />";
            if ($return == "html") {
                return $html;
            } else {
                return $id;
            }
        }
    }

    function cs_column_flow($has_sidebar, $i, $has_large_columns, $compare_value = 1) {
        if ($has_sidebar != $compare_value && is_int($i / 2) && $has_large_columns == $compare_value) {
            ?>
            </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php
                } elseif ($has_sidebar != $compare_value && is_int($i / 3) && $has_large_columns != $compare_value) {
                    ?>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php
                } elseif ($has_sidebar == $compare_value && is_int($i / 2) && $has_large_columns != $compare_value) {
                    ?>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php
                }
            }

//Hex color convertor
            function csc_color_convertor($hex, $steps) {
                // Steps should be between -255 and 255. Negative = darker, positive = lighter
                $steps = max(-255, min(255, $steps));

                // Format the hex color string
                $hex = str_replace('#', '', $hex);
                if (strlen($hex) == 3) {
                    $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
                }

                // Get decimal values
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));

                // Adjust number of steps and keep it inside 0 to 255
                $r = max(0, min(255, $r + $steps));
                $g = max(0, min(255, $g + $steps));
                $b = max(0, min(255, $b + $steps));

                $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
                $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
                $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

                return '#' . $r_hex . $g_hex . $b_hex;
            }

//            Convert hex to rgb
            function csc_hex2rgb($hex) {
                $hex = str_replace("#", "", $hex);

                if (strlen($hex) == 3) {
                    $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
                    $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
                    $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
                } else {
                    $r = hexdec(substr($hex, 0, 2));
                    $g = hexdec(substr($hex, 2, 2));
                    $b = hexdec(substr($hex, 4, 2));
                }
                $rgb = array($r, $g, $b);
                //return implode(",", $rgb); // returns the rgb values separated by commas
                return $rgb; // returns an array with the rgb values
            }

            function csc_ajax() {
                //including the main script for the admin javascript, ajax
                ?><script type="text/javascript"><?php
                require_once 'page_builder/js/csc_script.js';
                ?></script><?php
            }

            //bloginfo title filter
            function csc_title_replace($output) {
                $start = null;
                $start = round((strlen($output) - 1) / 2);

                $string = substr($output, $start);
                $output = str_replace($string, "<span>" . $string . "</span>", $output);
                return $output;
            }

        }

        /*
         * Strategy Page Navigation
          Version: 1.0.2
         */

        class cs_prime_strategy_page_navi {

            public function page_navi($args = '') {
                global $wp_query;

                if (!( is_archive() || is_home() || is_search() )) {
                    return;
                }
                $default = array(
                    'items' => 11,
                    'edge_type' => 'none',
                    'show_adjacent' => true,
                    'prev_label' => '&lt;',
                    'next_label' => '&gt;',
                    'show_boundary' => true,
                    'first_label' => '&laquo;',
                    'last_label' => '&raquo;',
                    'show_num' => false,
                    'num_position' => 'before',
                    'num_format' => '<span>%d/%d</span>',
                    'echo' => true,
                    'navi_element' => '',
                    'elm_class' => 'page_navi',
                    'elm_id' => '',
                    'li_class' => '',
                    'current_class' => 'current',
                    'current_format' => '<span>%d</span>',
                    'class_prefix' => '',
                    'indent' => 0,
                    //this argument is to add the #id code
                    'add_fragment' => ''
                );
                $default = apply_filters('page_navi_default', $default);

                $args = wp_parse_args($args, $default);

                $max_page_num = $wp_query->max_num_pages;
                $current_page_num = get_query_var('paged') ? get_query_var('paged') : 1;

                $elm = in_array($args['navi_element'], array('nav', 'div', '')) ? $args['navi_element'] : 'div';

                $args['items'] = absint($args['items']) ? absint($args['items']) : $default['items'];
                $args['elm_id'] = is_array($args['elm_id']) ? $default['elm_id'] : $args['elm_id'];
                $args['elm_id'] = preg_replace('/[^\w_-]+/', '', $args['elm_id']);
                $args['elm_id'] = preg_replace('/^[\d_-]+/', '', $args['elm_id']);

                $args['class_prefix'] = is_array($args['class_prefix']) ? $default['class_prefix'] : $args['class_prefix'];
                $args['class_prefix'] = preg_replace('/[^\w_-]+/', '', $args['class_prefix']);
                $args['class_prefix'] = preg_replace('/^[\d_-]+/', '', $args['class_prefix']);

                $args['elm_class'] = $this->sanitize_attr_classes($args['elm_class'], $args['class_prefix']);
                $args['li_class'] = $this->sanitize_attr_classes($args['li_class'], $args['class_prefix']);
                $args['current_class'] = $this->sanitize_attr_classes($args['current_class'], $args['class_prefix']);
                $args['current_class'] = $args['current_class'] ? $args['current_class'] : $default['current_class'];
                $args['show_adjacent'] = $this->uniform_boolean($args['show_adjacent'], $default['show_adjacent']);
                $args['show_boundary'] = $this->uniform_boolean($args['show_boundary'], $default['show_boundary']);
                $args['show_num'] = $this->uniform_boolean($args['show_num'], $default['show_num']);
                $args['echo'] = $this->uniform_boolean($args['echo'], $default['echo']);

                $tabs = str_repeat("\t", (int) $args['indent']);
                $elm_tabs = '';

                $befores = $current_page_num - floor(( $args['items'] - 1 ) / 2);
                $afters = $current_page_num + ceil(( $args['items'] - 1 ) / 2);

                if ($max_page_num <= $args['items']) {
                    $start = 1;
                    $end = $max_page_num;
                } elseif ($befores <= 1) {
                    $start = 1;
                    $end = $args['items'];
                } elseif ($afters >= $max_page_num) {
                    $start = $max_page_num - $args['items'] + 1;
                    $end = $max_page_num;
                } else {
                    $start = $befores;
                    $end = $afters;
                }

                $elm_attrs = '';
                if ($args['elm_id']) {
                    $elm_attrs = ' id="' . $args['elm_id'] . '"';
                }
                if ($args['elm_class']) {
                    $elm_attrs .= ' class="' . $args['elm_class'] . '"';
                }

                $num_list_item = '';
                if ($args['show_num']) {
                    $num_list_item = '<li class="page_nums';
                    if ($args['li_class']) {
                        $num_list_item .= ' ' . $args['li_class'];
                    }
                    $num_list_item .= '">' . sprintf($args['num_format'], $current_page_num, $max_page_num) . "</li>\n";
                }

                $page_navi = '';
                if ($elm) {
                    $elm_tabs = "\t";
                    $page_navi = $tabs . '<' . $elm;
                    if ($elm_attrs) {
                        $page_navi .= $elm_attrs . ">\n";
                    }
                }

                $page_navi .= $elm_tabs . $tabs . '<ul';
                if (!$elm && $elm_attrs) {
                    $page_navi .= $elm_attrs;
                }
                $page_navi .= ">\n";

                if ($args['num_position'] != 'after' && $num_list_item) {
                    $page_navi .= "\t" . $elm_tabs . $tabs . $num_list_item;
                }
                if ($args['show_boundary'] && ( $current_page_num != 1 || in_array($args['edge_type'], array('span', 'link')) )) {
                    $page_navi .= "\t" . $elm_tabs . $tabs . '<li class="' . $args['class_prefix'] . 'first';
                    if ($args['li_class']) {
                        $page_navi .= ' ' . $args['li_class'];
                    }
                    if ($args['edge_type'] == 'span' && $current_page_num == 1) {
                        $page_navi .= '"><span>' . esc_html($args['first_label']) . '</span></li>' . "\n";
                    } else {
                        $page_navi .= '"><a href="' . get_pagenum_link() . $args['add_fragment'] . '">' . esc_html($args['first_label']) . '</a></li>' . "\n";
                    }
                }

                if ($args['show_adjacent'] && ( $current_page_num != 1 || in_array($args['edge_type'], array('span', 'link')) )) {
                    $previous_num = max(1, $current_page_num - 1);
                    $page_navi .= "\t" . $elm_tabs . $tabs . '<li class="' . $args['class_prefix'] . 'previous';
                    if ($args['li_class']) {
                        $page_navi .= ' ' . $args['li_class'];
                    }
                    if ($args['edge_type'] == 'span' && $current_page_num == 1) {
                        $page_navi .= '"><span>' . esc_html($args['prev_label']) . '</span></li>' . "\n";
                    } else {
                        $page_navi .= '"><a href="' . get_pagenum_link($previous_num) . $args['add_fragment'] . '">' . esc_html($args['prev_label']) . '</a></li>' . "\n";
                    }
                }

                for ($i = $start; $i <= $end; $i++) {
                    $page_navi .= "\t" . $elm_tabs . $tabs . '<li class="';
                    if ($i == $current_page_num) {
                        $page_navi .= $args['current_class'];
                        if ($args['li_class']) {
                            $page_navi .= ' ' . $args['li_class'];
                        }
                        $page_navi .= '">' . sprintf($args['current_format'], $i) . "</li>\n";
                    } else {
                        $delta = absint($i - $current_page_num);
                        $b_f = $i < $current_page_num ? 'before' : 'after';
                        $page_navi .= $args['class_prefix'] . $b_f . ' ' . $args['class_prefix'] . 'delta-' . $delta;
                        if ($i == $start) {
                            $page_navi .= ' ' . $args['class_prefix'] . 'head';
                        } elseif ($i == $end) {
                            $page_navi .= ' ' . $args['class_prefix'] . 'tail';
                        }
                        if ($args['li_class']) {
                            $page_navi .= ' ' . $args['li_class'] . '"';
                        }
                        $page_navi .= '"><a href="' . get_pagenum_link($i) . $args['add_fragment'] . '">' . $i . "</a></li>\n";
                    }
                }

                if ($args['show_adjacent'] && ( $current_page_num != $max_page_num || in_array($args['edge_type'], array('span', 'link')) )) {
                    $next_num = min($max_page_num, $current_page_num + 1);
                    $page_navi .= "\t" . $elm_tabs . $tabs . '<li class="' . $args['class_prefix'] . 'next';
                    if ($args['li_class']) {
                        $page_navi .= ' ' . $args['li_class'];
                    }
                    if ($args['edge_type'] == 'span' && $current_page_num == $max_page_num) {
                        $page_navi .= '"><span>' . esc_html($args['next_label']) . '</span></li>' . "\n";
                    } else {
                        $page_navi .= '"><a href="' . get_pagenum_link($next_num) . $args['add_fragment'] . '">' . esc_html($args['next_label']) . '</a></li>' . "\n";
                    }
                }

                if ($args['show_boundary'] && ( $current_page_num != $max_page_num || in_array($args['edge_type'], array('span', 'link')) )) {
                    $page_navi .= "\t" . $elm_tabs . $tabs . '<li class="' . $args['class_prefix'] . 'last';
                    if ($args['li_class']) {
                        $page_navi .= ' ' . $args['li_class'];
                    }
                    if ($args['edge_type'] == 'span' && $current_page_num == $max_page_num) {
                        $page_navi .= '"><span>' . esc_html($args['last_label']) . '</span></li>' . "\n";
                    } else {
                        $page_navi .= '"><a href="' . get_pagenum_link($max_page_num) . $args['add_fragment'] . '">' . esc_html($args['last_label']) . '</a></li>' . "\n";
                    }
                }

                if ($args['num_position'] == 'after' && $num_list_item) {
                    $page_navi .= "\t" . $elm_tabs . $tabs . $num_list_item;
                }

                $page_navi .= $elm_tabs . $tabs . "</ul>\n";

                if ($elm) {
                    $page_navi .= $tabs . '</' . $elm . ">\n";
                }

                $page_navi = apply_filters('page_navi', $page_navi);

                if ($args['echo']) {
                    echo $page_navi;
                } else {
                    return $page_navi;
                }
            }

            private function sanitize_attr_classes($classes, $prefix = '') {
                if (!is_array($classes)) {
                    $classes = preg_replace('/[^\s\w_-]+/', '', $classes);
                    $classes = preg_split('/[\s]+/', $classes);
                }

                foreach ($classes as $key => $class) {
                    if (is_array($class)) {
                        unset($classes[$key]);
                    } else {
                        $class = preg_replace('/[^\w_-]+/', '', $class);
                        $class = preg_replace('/^[\d_-]+/', '', $class);
                        if ($class) {
                            $classes[$key] = $prefix . $class;
                        }
                    }
                }
                $classes = implode(' ', $classes);

                return $classes;
            }

            private function uniform_boolean($arg, $default = true) {
                if (is_numeric($arg)) {
                    $arg = (int) $arg;
                }
                if (is_string($arg)) {
                    $arg = strtolower($arg);
                    if ($arg == 'false') {
                        $arg = false;
                    } elseif ($arg == 'true') {
                        $arg = true;
                    } else {
                        $arg = $default;
                    }
                }
                return $arg;
            }

        }

// class end
        $cs_prime_strategy_page_navi = new cs_prime_strategy_page_navi();

        if (!function_exists('page_navi')) {

            function page_navi($args = '') {
                global $cs_prime_strategy_page_navi;
                return $cs_prime_strategy_page_navi->page_navi($args);
            }

        }
        
        