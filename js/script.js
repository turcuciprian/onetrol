jQuery(window).load(function() {
    "use strict";
    var $ = jQuery.noConflict();
    var window_width = window.innerWidth;
    //retina support
    csc_retina_support();
    
    //magnific popup implementation
    //image link
    
    function csc_custom_scripts_function() {
//        width of the page
        window_width = window.innerWidth;
        //logo scroll expand script
        var obj_arr = new Array('header .logo a',
                'header .navigation_menu .nav',
                24,
                4,
                28);
                
        if (window_width > 767) {
            jQuery('#main_menu').removeClass('collapsed').removeClass('collapse').removeClass('in');
            //Stack menu if it does not fit
            scs_long_menu('header .cs_container');
            // recalculate drop down menu position dependin on available space & menu width depending on the content
            csc_menu_hierarchy_recalculate('ul.nav');
            //resize menu height on scroll
            csc_height_on_scroll(obj_arr);
            csc_removeAttr('ul#main_menu');
            
        } else {
//Stack menu if it does not fit
            scs_long_menu('header .cs_container', undefined, true);
            //mobile button clicked = menu position absolute top
            csc_sttm('header', 'a.button.btn');
            //Menu scrolling rules (make menu fixed)
            csc_fixed_scrolling('header', '.navigation_menu a.btn', undefined, 'ul.nav');
            csc_removeAttr('.nav a');
            csc_removeAttr('.nav ul.sub-menu');
        }
    }

    csc_custom_scripts_function();
    $(window).resize(function() {
        csc_custom_scripts_function();
    });
});