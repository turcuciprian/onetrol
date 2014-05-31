<?php

/*
  Template Name: Page Builder
  Description: The main Page builder page template
 */
get_header();
//setting a content width
if (!isset($content_width)) {
    $content_width = 1200;
}
global $post;
$CleanScriptCore = new CleanScriptCore();
//
$values_array = get_post_meta($post->ID, 'cs-pb', true);
$values_array = unserialize($CleanScriptCore->cs_decode($values_array));
$count_array = array();
if (!empty($values_array)) {
    foreach ($values_array as $section) {
        if (isset($section['section_type']) && $section['section_type'] != "") {
            array_push($count_array, $section['section_type']);
            $count_result = array_count_values($count_array);

            $count_nr = $count_result[$section['section_type']];
            //include the section
            get_template_part('page_templates/parts/' . $section['section_type']);
        }
    }
}
get_footer();
