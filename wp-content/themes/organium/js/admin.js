/*
 * Created by Artureanec
*/

"use strict";

function organium_reactivate_sortable() {
    jQuery('.organium_text_table_rows').sortable(
        {
            handle: '.organium_text_table_row_move',
        }
    );
}

function organium_rwmb_and_customizer_condition() {
    jQuery("[data-dependency-id]").each(function (index) {
        var organium_target = jQuery(this).attr('data-dependency-id');
        var organium_needed_val = jQuery(this).attr('data-dependency-val');
        var organium_needed_val_array = new Array();
        var organium_array_just_ok = false;

        if(organium_needed_val.indexOf(',') + 1) {
            // Work with array value
            organium_needed_val = organium_needed_val.replace(/\s+/g,'');
            organium_needed_val_array = organium_needed_val.split(",");

            var organium_this = jQuery(this);

            organium_needed_val_array.forEach(function(item, i, organium_arr) {
                if (organium_this.hasClass('organium_dependency_customizer')) {
                    if (organium_array_just_ok !== true) {
                        if (jQuery('#customize-control-' + organium_target).find('select').val() == item) {
                            organium_array_just_ok = true;
                        }
                    }
                }
                else {
                    if (organium_array_just_ok !== true) {
                        if (jQuery('#' + organium_target).val() == item) {
                            organium_array_just_ok = true;
                        }
                    }
                }
            });

            if (jQuery(this).hasClass('organium_dependency_customizer')) {
                var organium_target_status = jQuery('#customize-control-' + organium_target).find('select').val();
                var organium_dependency_elem_cont = jQuery(this).parents('.customize-control');
            } else {
                var organium_target_status = jQuery('#' + organium_target).val();
                var organium_dependency_elem_cont = jQuery(this).parents('.rwmb-field');
            }

            if (organium_array_just_ok == true) {
                organium_dependency_elem_cont.show('fast');
            } else {
                organium_dependency_elem_cont.hide('fast');
            }
        } else {
            // Just one value
            if (jQuery(this).hasClass('organium_dependency_customizer')) {
                var organium_target_status = jQuery('#customize-control-' + organium_target).find('select').val();
                var organium_dependency_elem_cont = jQuery(this).parents('.customize-control');
            } else {
                var organium_target_status = jQuery('#' + organium_target).val();
                var organium_dependency_elem_cont = jQuery(this).parents('.rwmb-field');
            }

            if (organium_needed_val == organium_target_status) {
                organium_dependency_elem_cont.show('fast');
            } else {
                organium_dependency_elem_cont.hide('fast');
            }
        }
    });
}

function organium_hide_unnecessary_options() {
    if (jQuery('.organium_this_template_file').size() < 1) {
        var organium_this_template_file = 'organium_temp_333';
    }
    if (jQuery('.organium_this_template_file').size() > 0) {
        organium_this_template_file = jQuery('.organium_this_template_file').val();
    }
    jQuery("[data-show-on-template-file]").each(function (index) {
        var organium_unnecessary_target = jQuery(this).attr('data-show-on-template-file');
        if (organium_unnecessary_target.indexOf(',') > -1) {
            var organium_unnecessary_target_array = organium_unnecessary_target.split(',');
            var organium_rwmb_del_status = 'not find';
            jQuery.each(organium_unnecessary_target_array, function (i, val) {
                if (organium_this_template_file == val.trim()) {
                    organium_rwmb_del_status = 'find';
                }
            });
            if (organium_rwmb_del_status == 'not find') {
                jQuery(this).parents('.rwmb-field').remove();
            }
        } else {
            if (organium_this_template_file !== organium_unnecessary_target) {
                jQuery(this).parents('.rwmb-field').remove();
            }
        }
    });

    jQuery("[data-hide-on-template-file]").each(function (index) {
        var organium_unnecessary_target = jQuery(this).attr('data-hide-on-template-file');
        if (organium_unnecessary_target.indexOf(',') > -1) {
            var organium_unnecessary_target_array = organium_unnecessary_target.split(',');
            var organium_rwmb_del_status = 'not find';
            jQuery.each(organium_unnecessary_target_array, function (i, val) {
                if (organium_this_template_file == val.trim()) {
                    organium_rwmb_del_status = 'find';
                }
            });
            if (organium_rwmb_del_status == 'find') {
                jQuery(this).parents('.rwmb-field').remove();
            }
        } else {
            if (organium_this_template_file == organium_unnecessary_target) {
                jQuery(this).parents('.rwmb-field').remove();
            }
        }
    });
}

jQuery(window).on('load', function () {
    var val = jQuery('#post-format-selector-0').val();

    organium_onchange_post_formats2(val);
});

jQuery(document).on('change', '#post-format-selector-0', function(){
    organium_onchange_post_formats2(jQuery(this).val());
});

function organium_onchange_post_formats2(val) {
    jQuery('#image-post-format-settings, #video-post-format-settings, #audio-past-format-settings, #quote-post-format-settings, #link-post-format-settings, #gallery-post-format-settings').hide('fast');

    if (val == 'gallery') {
        jQuery('#gallery-post-format-settings').show('fast');
    }
    if (val == 'link') {
        jQuery('#link-post-format-settings').show('fast');
    }
    if (val == 'image') {
        jQuery('#image-post-format-settings').show('fast');
    }
    if (val == 'quote') {
        jQuery('#quote-post-format-settings').show('fast');
    }
    if (val == 'standard') {
        jQuery('#image-post-format-settings, #video-post-format-settings, #audio-past-format-settings, #quote-post-format-settings, #link-post-format-settings, #gallery-post-format-settings').hide('fast');
    }
    if (val == 'video') {
        jQuery('#video-post-format-settings').show('fast');
    }
    if (val == 'audio') {
        jQuery('#audio-past-format-settings').show('fast');
    }
}

function organium_onchange_post_formats() {
    var organium_post_format = jQuery('#post-formats-select input:checked').val();

    jQuery('#image-post-format-settings, #video-post-format-settings, #audio-past-format-settings, #quote-post-format-settings, #link-post-format-settings, #gallery-post-format-settings').hide('fast');

    if (organium_post_format == 'standard') {
        jQuery('#image-post-format-settings, #video-post-format-settings, #audio-past-format-settings, #quote-post-format-settings, #link-post-format-settings, #gallery-post-format-settings').hide('fast');
    }

    if (organium_post_format == 'gallery') {
        jQuery('#gallery-post-format-settings').show('fast');
    }

    if (organium_post_format == 'image') {
        jQuery('#image-post-format-settings').show('fast');
    }

    if (organium_post_format == 'video') {
        jQuery('#video-post-format-settings').show('fast');
    }

    if (organium_post_format == 'audio') {
        jQuery('#audio-past-format-settings').show('fast');
    }

    if (organium_post_format == 'quote') {
        jQuery('#quote-post-format-settings').show('fast');
    }

    if (organium_post_format == 'link') {
        jQuery('#link-post-format-settings').show('fast');
    }

    if (jQuery('#post-formats-select').length < 1) {
        // Body Class
        if (jQuery('body').hasClass('post-type-gallery')) {
            jQuery('#gallery-post-format-settings').show('fast');
            setTimeout("jQuery('#gallery-post-format-settings').show('fast')",100);
        } else if (jQuery('body').hasClass('post-type-image')) {
            jQuery('#image-post-format-settings').show('fast');
            setTimeout("jQuery('#image-post-format-settings').show('fast')",100);
        } else if (jQuery('body').hasClass('post-type-video')) {
            jQuery('#video-post-format-settings').show('fast');
            setTimeout("jQuery('#video-post-format-settings').show('fast')",100);
        } else if (jQuery('body').hasClass('post-type-audio')) {
            jQuery('#audio-past-format-settings').show('fast');
            setTimeout("jQuery('#audio-post-format-settings').show('fast')",100);
        } else if (jQuery('body').hasClass('post-type-quote')) {
            jQuery('#quote-post-format-settings').show('fast');
            setTimeout("jQuery('#quote-post-format-settings').show('fast')",100);
        } else if (jQuery('body').hasClass('post-type-link')) {
            jQuery('#link-post-format-settings').show('fast');
            setTimeout("jQuery('#link-post-format-settings').show('fast')",100);
        } else {
            jQuery('#image-post-format-settings, #video-post-format-settings, #audio-past-format-settings, #quote-post-format-settings, #link-post-format-settings, #gallery-post-format-settings').hide('fast');
        }
    }
}

jQuery(document).ready(function () {
    if (jQuery('#centered_content_hide').length) {
        console.log('i found it');
        console.log(jQuery('#centered_content_hide').val());
        if (jQuery('#centered_content_hide').val() == 'yes') {
            console.log('this is yes');
            jQuery('body').addClass('organium_hide_content');
        } else {
            console.log('this is no');
            jQuery('body').removeClass('organium_hide_content');
        }
    }
    jQuery('#centered_content_hide').on('change', function(){
        if (jQuery(this).val() == 'yes') {
            jQuery('body').addClass('organium_hide_content');
        } else {
            jQuery('body').removeClass('organium_hide_content');
        }
    });
    if (jQuery('#page_template').size() > 0 && jQuery('#page_template').val() !== 'default') {
        jQuery('body').addClass(jQuery('#page_template').val().split('.')[0]);
    }

    jQuery("[data-dependency-id]").parents('.rwmb-field').hide();

    organium_onchange_post_formats();
    organium_rwmb_and_customizer_condition();
    organium_hide_unnecessary_options();

    jQuery('.rwmb-select, .customize-control-select select').change(function () {
        organium_rwmb_and_customizer_condition();
    });

    jQuery('#post-formats-select input').on("click", function () {
        organium_onchange_post_formats();
    });

    jQuery('.organium_reset_all_settings').on("click", function () {
        if (confirm("Are you sure? All settings will be reset to default state.")) {
            jQuery.post(ajaxurl, {
                action: 'organium_reset_all_settings'
            }, function (response) {
                alert(response);
            });
        }
    });

    jQuery(document).on("click", '.organium_text_table_add_row', function () {
        var organium_text_table_data_storage_name = jQuery(this).parents('.widget-content').find('.organium_text_table_data_storage_name').val();
        var organium_text_table_name_text = jQuery(this).parents('.widget-content').find('.organium_text_table_name_text').val();
        var organium_text_table_value_text = jQuery(this).parents('.widget-content').find('.organium_text_table_value_text').val();

        jQuery(this).parents('.widget-content').find('.organium_text_table_rows').append('<div class="organium_text_table_row organium_dn"><div class="organium_50_dib"><label>' + organium_text_table_name_text + ':</label><input class="widefat" type="text" name="' + organium_text_table_data_storage_name + '[][name]" value=""></div><div class="organium_50_dib"><label>' + organium_text_table_value_text + ':</label><textarea class="widefat" type="text" name="' + organium_text_table_data_storage_name + '[][value]"></textarea></div><div class="organium_text_table_row_remove"><i class="fa fa-trash"></i></div><div class="organium_text_table_row_move"><i class="fa fa-arrows"></i></div></div>');
        jQuery('.organium_dn').slideDown("fast").removeClass('organium_dn');
    });

    jQuery(document).on("click", '.organium_text_table_row_remove', function () {
        jQuery(this).parents('.organium_text_table_row').slideUp("normal", function () {
            jQuery(this).remove();
        });
    });

    jQuery(document).on("click", '.widget-control-save', function () {
        setTimeout(function () {
            organium_reactivate_sortable()
        }, 1000);
        setTimeout(function () {
            organium_reactivate_sortable()
        }, 2000);
        setTimeout(function () {
            organium_reactivate_sortable()
        }, 3000);
    });

    organium_reactivate_sortable();

    function media_upload() {
        var _custom_media = true,
            _orig_send_attachment = wp.media.editor.send.attachment;
        jQuery('body').on('click', '.js_custom_upload_media', function () {
            var button_id = jQuery(this).attr('id');
            wp.media.editor.send.attachment = function (props, attachment) {
                if (_custom_media) {
                    jQuery('.' + button_id + '_img').attr('src', attachment.sizes.medium.url).removeClass('hidden');
                    jQuery('.' + button_id + '_url').val(attachment.url).change();
                } else {
                    return _orig_send_attachment.apply(jQuery('#' + button_id), [props, attachment]);
                }
            };

            wp.media.editor.open(jQuery('#' + button_id));

            jQuery(this).removeClass('empty').addClass('hidden');
            jQuery('.media-widget-buttons', jQuery(this).parents('.media-widget-control')).find('.js_custom_remove_media').removeClass('hidden');

            return false;
        });
    }
    media_upload();

    function media_remove() {
        jQuery('body').on('click', '.js_custom_remove_media', function() {
            jQuery('.media_image', jQuery(this).parents('.media-widget-control')).find('input.widefat').val('').change();
            jQuery('.media_image', jQuery(this).parents('.media-widget-control')).find('img').attr('src', '').addClass('hidden');
            jQuery('.media_image', jQuery(this).parents('.media-widget-control')).find('.js_custom_upload_media').addClass('empty').removeClass('hidden');
            jQuery(this).addClass('hidden');
        });
    }
    media_remove();
});

jQuery('.organium_color_picker .rwmb-color').each(function(){
    var color = jQuery(this).attr('placeholder');

    if (jQuery(this).val() == '') {
        jQuery(this).val(color);
    }
});


