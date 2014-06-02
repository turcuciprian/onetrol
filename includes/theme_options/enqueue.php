<?php

add_action('wp_enqueue_scripts', 'citrix_enqueue_scripts');

//Registering scripts and styles for the theme
function citrix_enqueue_scripts() {
    global $post;
    //Javascript
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap', 'http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js', array(), '1.0.0', true);

    wp_enqueue_script('cleanscript-core', get_template_directory_uri() . '/js/tcs_core.js', array(), '1.0.0', true);
    wp_enqueue_script('main-script', get_template_directory_uri() . '/js/script.js', array(), '1.0.0', true);

    if (is_singular()) {
        wp_enqueue_script("comment-reply");
    }

//    Bootstrap Style
    wp_enqueue_style('bootstrap-style', 'http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css');
//    Google fonts
    wp_enqueue_style('google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700,800|Open+Sans+Condensed:300|Dosis:200,300,400,500,600,700,800');
//    Font awesome icons style
    wp_enqueue_style('font-awesome', 'http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');
//    Main Stylesheet
    wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css');
}
