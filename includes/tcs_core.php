<?php

// global variable of the main class
global $tcs_core;
$tcs_core = new tcs_core();

//main core class
class tcs_core {

    function __construct() {
        //omclude parts
        $this->include_parts();
//********************************************************
//  Custom field in the menu - admin
//********************************************************
        add_action('init', 'onetrol_init');

        function onetrol_init() {
            register_nav_menu('onetrol_Menu', __('Main Menu', 'default'));
        }

    }

    //include core parts automatically
    private function include_parts() {
        //include function.php parts
//
//theme front end scripts and styles
        $include_files[] = 'theme_options/enqueue.php';
//theme filters
        $include_files[] = 'theme_options/filters.php';

//including the files from the array
        foreach ($include_files as $file) {
            require_once($file);
        }
    }
    //bloginfo title filter split and wrapped with a tag container
    public function split_text_tag($output,$tag='span') {
        $start = null;
        $start = round((strlen($output) - 1) / 2);

        $string = substr($output, $start);
        $output = str_replace($string, "<$tag>" . $string . "</$tag>", $output);
        return $output;
    }

}
