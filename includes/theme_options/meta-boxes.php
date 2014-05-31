<?php

if (isset($_GET['post']) || isset($_GET['post']) || isset($_POST['post_ID'])) {
    $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
    $template_file = get_post_meta($post_id, '_wp_page_template', TRUE);
// check for a template type
    switch ($template_file) {
        case 'page_templates/cs_page_builder.php':
            include(get_template_directory() . '/includes/meta-boxes/cs_page_builder.php');
            break;
    }
}