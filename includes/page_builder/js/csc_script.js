jQuery(document).ready(function($) {
    var ajax_button = $('.ajax_button');
    if (ajax_button[0]) {
        ajax_button.click(function() {
            var xthis = this;
            $(this).attr("disabled", "disabled");
            $('.ajax_load').html('<img src="' + $('.ajax_loader').val() + '" alt="" /> Please wait. Loading...');
            var data = {
                action: 'csc_populate'
            };
            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            $.post(ajaxurl, data, function(response) {
//                A popup message letting you know the request has completed
                alert(response);
                $(xthis).removeAttr("disabled");
                $('.ajax_load').html(data);
            });
        });
    }
    //add asection popop
    //*******************************************************
    //*******************************************************
    //*******************************************************
    //*******************************************************
    //sortable container structure
    var cspb_sortable = $('.cspb_sortable');
    function cs_sortable() {
        if (cspb_sortable[0]) {
            var icons = {
                header: "ui-icon-carat-1-e",
                activeHeader: "ui-icon-carat-1-s"
            };
            cspb_sortable.sortable({
                handle: "h3",
                axis: "y",
                placeholder: "ui-state-highlight"
            }).accordion({
                icons: icons,
                header: "> li > h3",
                heightStyle: "content",
                active: false,
                collapsible: true
            });
        }
    }
    if (cspb_sortable[0]) {
        cs_sortable();
    }

    //add a section popop magnific popup script

    var magnificPopup = $('.pbmb_add_section');
    //the popup script
    if (magnificPopup[0]) {
        magnificPopup.magnificPopup({
            items: {
                src: '.popup_content',
                type: 'inline',
                midClick: true
            },
            closeBtnInside: true
        });
    }
    var magnific_popup_this = '';
    function add_magnific_popup() {
        //add fa icons popup
        var magnificPopupDIV = $('.insert_icon_fa');
        //the popup script
        if (magnificPopupDIV[0]) {
            magnificPopupDIV.unbind('click').on('click', function() {
                magnific_popup_this = this;
            });
            magnificPopupDIV.magnificPopup({
                items: {
                    src: '.fa_icons_div',
                    type: 'inline',
                    midClick: true,
                    preloader: true
                },
                callbacks: {
                    open: function() {
                        var hidd_field_name = $(magnific_popup_this).attr('id');
                        var hidd_field = $('.' + hidd_field_name);
                        var field_icon = $(magnific_popup_this).parent('td').children('div.icon-button').children('i');
                        field_icon.parent('div.icon-button').unbind('click').on('click', function() {
                            $(this).siblings('input[type="hidden"]').val('');
                            $(this).children('i').removeClass().addClass('fa');
                        });
                        var icon_popup_button = $('.mfp-content .container button');
                        icon_popup_button.unbind('click').on('click', function() {
                            var icon_name = $(this).children('i').attr('id');
                            hidd_field.val(icon_name);
                            field_icon.removeClass().addClass('fa ' + icon_name);
                            $.magnificPopup.close();
                            return false;
                        });
                    }
                },
                closeBtnInside: true
            });

            //remove icon (fa icon button) and hidden field value on click
            $('div.icon-button').unbind('click').on('click', function() {
                var hidd_field_name = $(this).parent('div').children('.insert_icon_fa').attr('id');
                var hidd_field = $('.' + hidd_field_name);
                var field_icon = $(this).parent('div').children('div.button').children('i');
                $(this).siblings('input[type="hidden"]').val('');
                $(this).children('i').removeClass().addClass('fa');
            });
        }
    }
    add_magnific_popup();
    var section_button = $('.popup_content .section_button');
    var remove_section = $('.cs_right');
    if (section_button[0]) {
        section_button.click(function() {
            $.magnificPopup.close();
            var section_type = $(this).attr('id');
            var linr = $('.cspb_sortable li').length;
            var listcount = linr;
            magnificPopup.attr('disabled', 'disabled');
            var datax = {
                action: 'csc_ajax_sections',
                s_type: section_type,
                count_id: listcount
            };
            $.post(ajaxurl, datax, function(response) {
                var icons = {
                    header: "ui-icon-circle-arrow-e",
                    activeHeader: "ui-icon-circle-arrow-s"
                };
                cspb_sortable.append(response).accordion('destroy').accordion({
                    icons: icons,
                    header: "> li > h3",
                    heightStyle: "content",
                    active: false,
                    collapsible: true
                });
                cs_sortable();
                magnificPopup.removeAttr('disabled');
                //remove on click functionality
                remove_list_section();
                upload_single_media_button();
                upload_single_media_gallery_button();
                add_magnific_popup();
                cs_jquery_radio();
            });
        });
    }
    remove_list_section();
    //remove section on remove button click
    function remove_list_section() {
        remove_section = $('.cs_right');
        if (remove_section[0]) {
            remove_section.on('click', function() {
                $(this).parent('h3').parent('li').remove();
            });
        }
    }
    //adding the bootstrap radio buttons, buttons group javascript code
    var button_group = $('.button-group');
    if (button_group[0]) {
        //button_group.button();
    }
    //The single file upload media button script:
    function upload_single_media_button() {
        var cs_mb_upload = $('.cs_mb_upload');
        cs_mb_upload.unbind("click").on('click', function() {
            var xthis = this;
            var hidden_url = $(this).parent('td').children('.cs_mb_hidden');
            var tag_img = $(this).parent('td').children('img');
            if (hidden_url.val() == '') {
                tb_show('Upload a logo', 'media-upload.php?type=file&amp;TB_iframe=true');
                window.send_to_editor = function(html) {
                    var image_url = $('img', html).attr('src');
                    hidden_url.val(image_url);
                    tb_remove();
                    tag_img.attr('src', image_url);
                    $(xthis).val('Remove');
                };
                return false;
            } else {
                hidden_url.val('');
                tag_img.attr('src', '');
                $(this).val('Upload');
            }
        });
    }
    //The single file upload media gallery button script:
    function upload_single_media_gallery_button() {
        var cs_mb_upload_gallery = $('.cs_mb_upload_gallery');
        var remove_button = $('.cs_mb_remove_gallery');
        remove_button.unbind('click').on('click', function() {
            var hidden_url = $(this).parent('td').children('.cs_mb_hidden');
            hidden_url.val('');
            $(this).attr('disabled', 'disabled');
        });
        cs_mb_upload_gallery.unbind('click').on('click', function() {
            var hidden_url = $(this).parent('td').children('.cs_mb_hidden');
            var xthis = this;
            var gallerysc = '[gallery ids="' + hidden_url.val() + '"]';
            wp.media.gallery.edit(gallerysc).on('update', function(g) {
                var id_array = [];
                $.each(g.models, function(id, img) {
                    id_array.push(img.id);
                });
                // Make comma separated list from array and set the hidden value
                hidden_url.val(id_array.join(","));
                remove_button.removeAttr('disabled');
                $(xthis).val('Update Gallery');
            });
        });
    }
//    the styled yes/no radio button script
    function cs_jquery_radio() {
        //radio labels jquery
        var radiolabel = $('label.button');
        radiolabel.unbind('click').on('click', function() {
            $(this).parent().children('.button').removeClass('active');
            $(this).addClass('active');
        });
    }
//    color picker script
    var cs_colorpicker = $('.colorpicker');
    if (cs_colorpicker[0]) {
        cs_colorpicker.spectrum({
            showInput: true
        });
    }


    upload_single_media_button();
    upload_single_media_gallery_button();
    cs_jquery_radio();
});
