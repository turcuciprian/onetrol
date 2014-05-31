//retina ready screens support
function csc_retina_support() {
    var retina = window.devicePixelRatio >= 1.5;
    if (retina) {
        jQuery('body').addClass('retina');
    }
}

//scroll to top on mobile menu expand
function csc_sttm(main_menu, mobile_menu_btn) {
//**
//**
// main_menu - The main menu parent tag &/or class path
// mobile_menu_btn - The mobile menu button tag &/or class path
//**
//**
    var main_menu_obj = jQuery(main_menu);
    jQuery(mobile_menu_btn).unbind('click').bind('click', function(event) {
        jQuery(document).scrollTop(0);
        if (jQuery(mobile_menu_btn).hasClass('collapsed')) {
            if (main_menu_obj.hasClass('fixed')) {
                main_menu_obj.removeClass('fixed');
            }
        }
        //event.stopPropagation();
    });
}
var csc_height_on_scroll_arr = [0, 0, 0, 0, 0, 0];
//change menu height  on scroll
function csc_height_on_scroll(obj_arr) {
    //array options
    //0-logo container class
    //1-Menu ul container
    //2-min font-size
    //3-min top&bottom padding
    //4-min line height
    //5-mobile min margin top&bottom & padding

    // Logo container
    var container = jQuery(obj_arr[0]),
            //the menu container object
            menu_container = jQuery(obj_arr[1]).children('li').children('a'),
            //the menu container object
            logo_container = container.children('img'),
            scrollTop = jQuery(window).scrollTop(),
            container_height = csc_height_on_scroll_arr[0],
            //
            // Original values
            // 

            //original width and height for the image logo
            original_logo_height = logo_container.attr('height');
    //console.log(scrollTop);
    //if the main container height is not set, set it from default
    container_height = csc_height_on_scroll_arr[1];
    if (container_height === 0) {
        container_height = container.height();
        csc_height_on_scroll_arr[0] = container_height;
    }
    if (container_height === 0) {
        var original_logo_width = logo_container.attr('width');
        csc_height_on_scroll_arr[1] = original_logo_width;
    }
    var original_logo_width = csc_height_on_scroll_arr[2];
    if (original_logo_width === 0) {
        original_logo_width = logo_container.attr('width');
        csc_height_on_scroll_arr[2] = original_logo_width;
    }

    // - Font size
    var original_font_size = csc_height_on_scroll_arr[3];
    if (original_font_size === 0) {
        original_font_size = container.css('font-size');
        csc_height_on_scroll_arr[3] = original_font_size;
    }

    // - Line height
    var original_lh = csc_height_on_scroll_arr[4];
    if (original_lh === 0) {
        original_lh = container.css('line-height');
        csc_height_on_scroll_arr[4] = original_lh;
    }
    // Padding 
    var original_padding = csc_height_on_scroll_arr[5];
    if (original_padding === 0) {
        original_padding = container.css('padding-top');
        csc_height_on_scroll_arr[5] = original_padding;
    }
    //
    // Min values
    // 
    // min line height
    var min_lh = obj_arr[4],
            // min font size
            min_fs = obj_arr[2],
            // min padding
            min_padding = obj_arr[3],
            // min logo width&height
            min_logo_height = Math.round(original_logo_height - original_logo_height * 0.44),
            min_logo_width = Math.round(original_logo_width - original_logo_width * 0.44);

    original_padding = original_padding.replace('px', '');
    original_lh = original_lh.replace('px', '');
    original_font_size = original_font_size.replace('px', '');
    function csc_dynamic_menu_height() {

        container = jQuery(obj_arr[0]);
        menu_container = jQuery(obj_arr[1]).children('li').children('a');

        //37 - height 36/24 - font sizes
        scrollTop = jQuery(window).scrollTop();
        if (scrollTop <= container_height) {
            //font size
            //new font size
            var font_size = csc_math_min(original_font_size, min_fs, scrollTop, container_height);
            if (font_size < min_fs) {
                font_size = min_fs;
            }
            if (font_size > original_font_size) {
                font_size = original_font_size;
            }
            container.css('font-size', font_size + 'px');
            //padding
            // difference from the min limit for the font

            var padding_size = csc_math_min(original_padding, min_padding, scrollTop, container_height),
//            img size
                    new_logo_height = csc_math_min(original_logo_height, min_logo_height, scrollTop, container_height),
                    new_logo_width = csc_math_min(original_logo_width, min_logo_width, scrollTop, container_height),
                    // logo line height
                    new_lh = csc_math_min(original_lh, min_lh, scrollTop, container_height);
            container.css('padding-top', padding_size + 'px');
            container.css('padding-bottom', padding_size + 'px');
            //line height
            container.css('line-height', new_lh + 'px');
            // menu container padding
            menu_container.css('padding-top', padding_size + 'px');
            menu_container.css('padding-bottom', padding_size + 'px');
            //menu line height
            menu_container.css('line-height', new_lh + 'px');
            // resize logo container
            if (logo_container[0]) {
                logo_container.css('height', new_logo_height + 'px');
                logo_container.css('width', new_logo_width + 'px');
            }

        } else {
            //Logo container modification
            container.css('font-size', min_fs + 'px');
            container.css('padding-top', min_padding + 'px');
            container.css('padding-bottom', min_padding + 'px');
            //line height
            container.css('line-height', min_lh + 'px');
            menu_container.css('line-height', min_lh + 'px');

            // menu container padding
            menu_container.css('padding-top', min_padding + 'px');
            menu_container.css('padding-bottom', min_padding + 'px');

            //logo height
            if (logo_container[0]) {
                logo_container.css('height', min_logo_height + 'px');
                logo_container.css('width', min_logo_width + 'px');
            }
        }
    }
    csc_dynamic_menu_height();
    jQuery(window).unbind('scroll').bind('scroll', function() {
        csc_dynamic_menu_height();
    });
}
//calculate the remaining space/font-size/padding/height (number) of a element relative to the window position
function csc_math_min(original, min, scrollTop, div_container) {
    // percentage scrolled according to container height 
    var scrolled = Math.round((scrollTop / div_container) * 100);
    if (scrollTop === 0 && div_container === 0) {
        scrolled = 0;
    }
    // calculate percentage of current scrolling position
    var percent = 100 - scrolled;
    return Math.round(min + ((original - min) * (percent / 100)));
}

//recalculate the position of the submenu that's going to appear
function csc_menu_hierarchy_recalculate(menu_container_string, menu_type_bol) {
    //true = mobile version, unbind hover
    if (menu_type_bol === true) {
        jQuery(menu_container_string + ' li.menu-item-has-children').unbind('hover');
        return false;
    }
    jQuery(menu_container_string + ' li.menu-item-has-children').unbind('hover').bind('hover', function() {
        var this_li = jQuery(this);
        var childUL = this_li.children('ul');
        if (childUL[0]) {
            menu_text_wrap(childUL);
            var offset = childUL.offset(),
                    leftUL_pos = offset.left;
            if (leftUL_pos !== undefined) {
                var leftUL_width = childUL.width(),
                        window_width = jQuery(window).width();
                if (window_width < (leftUL_pos + leftUL_width)) {
                    var target_left_position = leftUL_width + 2;
                    if (this_li.parent().hasClass('nav')) {
                        target_left_position = childUL.width() - this_li.width() + 2;
                    }
                    childUL.css('marginLeft', '-' + target_left_position + 'px');
                }
            }
        }
    });

}
function menu_text_wrap(container_obj) {
    var max_width = 0,
            self_padd = 0;
    container_obj.children('li').each(function() {
        var self = jQuery(this);
        if (self[0]) {
            var children = self.children('a');
        }
        if (children[0]) {
            self_padd = children.css('padding-left');
            self_padd = self_padd.replace('px', '');
            container_obj.width('10000px');
            children.width('auto');
            var temp_width = children.width();
            //console.log(temp_width);
            container_obj.css('width', '100%');
            children.css('width', '100%');
            if (temp_width > max_width) {
                max_width = temp_width;
            }
        }
    });
    container_obj.width((max_width + (self_padd * 2)));
    container_obj.children('li').children('a').css('width', '100%');
    //console.log("Max width: " + max_width);
}
//Menu scrolling rules
// *
// For double or single menus
//If you want to hide the top menu on scroll or you have the menu placed anywhere else other than top 0px 
function csc_fixed_scrolling(main_menu, mobile_btn, top_menu, menuClass) {
//**
//**
// main_menu - The main menu parent tag &/or class path
//**
//**
//the window scroll top position
    var scrollPos = jQuery(document).scrollTop();
    var ulMenu = jQuery(main_menu + ' ' + menuClass);
    //define the main menu class
    var mainMenu = jQuery(main_menu);
    jQuery(window).scroll(function() {
//position fixed is removed if menu is expanded
        if (!jQuery(mobile_btn).hasClass('collapsed') && mainMenu.hasClass('fixed')) {
            mainMenu.removeClass('fixed');
        }
//scroll position
        scrollPos = jQuery(document).scrollTop();
        var positionBool = true;
        //if there is a top extra menu
        if (top_menu !== undefined) {
//get the top menu height
            var topMenuHeight = jQuery(top_menu).height();
            // set the condition
            positionBool = scrollPos > topMenuHeight;
//position fixed is removed if menu is expanded
        } else {
// set the condition ****getting the menu position relative to the document
            positionBool = scrollPos > mainMenu.offset().top;
        }
        var mainMenuHeight = mainMenu.height();
        if (positionBool && !ulMenu.hasClass('in') && !ulMenu.hasClass('collapsing')) {
            mainMenu.addClass('fixed');
        } else {
            if (mainMenu.hasClass('fixed')) {
                mainMenu.removeClass('fixed');
            }
        }
    });
    if (scrollPos !== 0) {
        mainMenu.addClass('fixed');
    } else {
        mainMenu.removeClass('fixed');
    }
//position fixed is removed if menu is expanded
    if (!jQuery(mobile_btn).hasClass('collapsed') && mainMenu.hasClass('fixed')) {
        mainMenu.removeClass('fixed');
    }
}
var menu_arr = [];
var original_items_arr = [0];
function scs_long_menu(header_menu_wrap_str, args, menu_type_bool) {
//header_menu_wrap_str - header menu container tag (the div containing the logo and the menu ul)
//

//Args - optional
//0 - overwrite logo container str (.logo)
//1 - overwrite div menu container str (.navigation_menu)
//1 - overwrite ul menu container str (#main_menu)
    if (args === undefined) {
        args = [".logo", ".menu_container", "#main_menu"];
    }
    var header_menu_wrap = jQuery(header_menu_wrap_str);
    var logo_container = header_menu_wrap.children(args[0]);
    var menu_container = header_menu_wrap.find(args[2]);
    var logo_container_width = original_items_arr[0];
    //set and get the original logo width
    if (logo_container_width === 0) {
//        get the logo width from it's original place
        logo_container_width = logo_container.width();
//        set the array element with it's original value
        original_items_arr[0] = logo_container_width;
    }
//    calculate the available width and declaration of the variable
    var available_width = header_menu_wrap.width() - logo_container_width;
//    declare total width and set it to an initial 0
    var total_width = 0;

//save the entire contents of the menu elements inside an array
    if (menu_arr.length === 0) {
        menu_container.children('li').each(function() {
            var current_li = jQuery(this);
            menu_arr.push([current_li, current_li.width()]);
            current_li.remove();
        });
    }
    //extra element object declaration
    var em_width = 54;
    var li_width = 0;
    var i;
    menu_container.html('');
    for (i = 0; i < menu_arr.length; ++i) {
        var this_li = menu_arr[i][0];
        li_width = menu_arr[i][1];
        //console.log(menu_arr[i]);
        //see if all menu items up until the current one fit
        if (menu_type_bool === true) {
            menu_container.append(this_li);
        } else {
            if ((total_width < (available_width - li_width - em_width))) {
                //console.log(total_width + " - " + (available_width - li_width - em_width) + "(" + available_width + " - " + li_width + " - " + em_width + ")");
                total_width += li_width;
                //add the li element to the menu
                menu_container.append(this_li);
            } else {
                var extra_menu = jQuery(header_menu_wrap_str + ' li.extra_menu');
                if (!extra_menu[0]) {
//                add the extra menu to the list at the end
                    menu_container.append('<li class="extra_menu menu-item-has-children menu-item">\n\
<a href="javascript:void(0);">\n\
<i class="fa fa-bars"></i>\n\
</a>\n\
<ul></ul>\n\
</li>');
                    
                    extra_menu = menu_container.children('li.extra_menu');
                    em_width = extra_menu.width();
                    total_width += extra_menu.width();
                    //remove style attributes of new menu items
                    this_li.children('a').removeAttr('style');
//                    add a new menu object with all the html hierarchy
                    this_li.appendTo(extra_menu.children('ul'));
                } else {
                    //remove style attributes of new menu items
                    this_li.children('a').removeAttr('style');
//                    add a new menu object with all the html hierarchy
                    this_li.appendTo(extra_menu.children('ul'));
                }
            }
        }
    }
    if (menu_type_bool === true) {
        menu_arr = [];
    }
    
}
function csc_removeAttr(str_class){
    jQuery(str_class).removeAttr('style');
}

