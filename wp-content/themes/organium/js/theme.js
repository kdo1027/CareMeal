"use strict";

// ---------------------- //
// --- Portfolio Grid --- //
// ---------------------- //
function portfolio_grid() {
    // Portfolio Filter
    if ( jQuery('.organium_isotope_filter').length != 0 ) {
        jQuery('.organium_isotope_filter').each(function (i, el) {
            jQuery(el).find('.organium_isotope_trigger').isotope({
                gutter: 0,
                filter: '.all'
            });
            jQuery(el).find('.filter_control_item').off();
            jQuery(el).find('.filter_control_item').on('click', function(){
                var filter = jQuery(this).data('value');

                jQuery(el).find('.filter_control_item').removeClass('active');
                jQuery(this).addClass('active');

                jQuery(el).find('.organium_isotope_trigger').isotope({
                    gutter: 0,
                    filter: '.'+filter,
                    masonry: {
                        columnWidth: '.grid-sizer'
                    }
                });
            });
        });
    }
}

function side_panel_open() {
    jQuery('.dropdown-trigger').on('click', function() {
        jQuery('.organium_aside-dropdown, .body-overlay').addClass('active');
    });
    jQuery('.organium_aside-dropdown__close, .body-overlay').on('click', function() {
        jQuery('.organium_aside-dropdown, .body-overlay').removeClass('active');
    });
}
side_panel_open();

function search_panel_open() {
    jQuery('.search_trigger').on('click', function() {
        jQuery('.site-search, .body-overlay').addClass('active');
    });
    jQuery('.close-search, .body-overlay').on('click', function() {
        jQuery('.site-search, .body-overlay').removeClass('active');
    });
}
search_panel_open();

function switch_form_columns() {
    jQuery('.tab-columns-switcher').on('click', function() {
        jQuery('.tab-column', jQuery(this).parents('.tab-columns')).toggleClass('hidden');
    });
}
switch_form_columns();

function sticky_menu_active (){
    if ( jQuery('.organium_sticky_header_on').length ) {
        jQuery('.organium_sticky_header_on').each(function(){
            let obj = jQuery(this);
            let el_offset = obj.offset().top;
            let el_height = jQuery('.sticky_wrapper', obj).innerHeight();
            let el_ready = el_offset + el_height;
            let el_not_active = el_offset + el_height + 300;
            el_offset = el_offset + el_height + 200;

            obj.height(el_height);

            jQuery(window).scroll(function(){
                var st = jQuery(this).scrollTop();
                if (st <= el_ready) {
                    obj.removeClass('sticky_ready');
                } else {
                    obj.addClass('sticky_ready');
                }
                if (st <= el_not_active) {
                    obj.removeClass('sticky_active');
                }
                if (st <= el_offset) {
                    obj.removeClass('sticky_active');
                } else {
                    obj.addClass('sticky_active');
                }
            });
        });
    }
}
sticky_menu_active();

function footer_widget_menu_columns() {
    jQuery('.footer_widgets .widget_nav_menu').each(function(){
        if (jQuery('.menu > li', this).length > 7) {
            jQuery('.menu', this).addClass('columns-3');
        } else if (jQuery('.menu > li', this).length > 4) {
            jQuery('.menu', this).addClass('columns-2');
        }
    });
}
footer_widget_menu_columns();

function mobile_menu_open() {
    jQuery('.menu_trigger').on('click', function() {
        jQuery('.organium_mobile_header_menu_container, .body-overlay').addClass('active');
    });
    jQuery('.menu_close, .body-overlay').on('click', function() {
        jQuery('.organium_mobile_header_menu_container, .body-overlay').removeClass('active');
    });
}
mobile_menu_open();

function simple_sidebar_open() {
    jQuery('.simple_sidebar_trigger').on('click', function() {
        if (jQuery(window).width() < 992) {
            jQuery('.simple_sidebar, .body-overlay').addClass('active');
        }
    });
    jQuery('.shop_hidden_sidebar_close, .body-overlay').on('click', function() {
        jQuery('.simple_sidebar, .body-overlay').removeClass('active');
    });
}
simple_sidebar_open();

function widget_list_hierarchy_init (){
    widget_archives_hierarchy_controller ( '.widget > ul li', 'ul.children', 'parent_archive', 'widget_archive_trigger' );
    widget_archives_hierarchy_controller ( '.widget_nav_menu .menu li', 'ul.sub-menu', 'parent_archive', 'widget_menu_trigger' );

    widget_archives_hierarchy_controller ( '.wp-block-categories li', '.children', 'parent_archive', 'block_archive_trigger' );
}

function widget_archives_hierarchy_controller ( list_item_selector, sublist_item_selector, parent_class, trigger_class ){
    jQuery( list_item_selector ).has( sublist_item_selector ).each( function (){
        jQuery( this ).addClass( parent_class );
        jQuery(this).append( "<span class='fa fa-angle-right " + trigger_class + "'></span>" );
    });
    jQuery( list_item_selector + ">" + sublist_item_selector ).css( "display", "none" );
    jQuery( list_item_selector + ">.item-wrapper>" + sublist_item_selector ).css( "display", "none" );
    jQuery( document ).on( "click", "." + trigger_class, function (){
        var el = jQuery(this);
        var sublist = el.siblings( sublist_item_selector );
        var sublist_alt = el.siblings('.item-wrapper').children( sublist_item_selector );
        if ( !sublist.length && !sublist_alt.length ) return;
        sublist = sublist.first();
        sublist_alt = sublist_alt.first();
        el.toggleClass('active');
        sublist.slideToggle( 300 );
        sublist_alt.slideToggle( 300 );
    });
}

function fix_responsive_iframe () {
    jQuery('.video-embed > div').each(function() {
        jQuery(this).unwrap('.video-embed');
    });
}

// ---------------------- //
// --- Document Ready --- //
// ---------------------- //
jQuery(document).ready(function () {

    // Mobile Menu
    function mobile_menu(){
        jQuery('.organium_mobile_header_menu_container .organium_main-menu').find('.menu-item').each(function(i, el){
            if( jQuery(el).find('.sub-menu').length != 0 && jQuery(el).find('.sub-menu-trigger').length == 0 ){
                jQuery(el).append('<span class="sub-menu-trigger"></span>');
            }
        });

        jQuery('.sub-menu-trigger').off();
        jQuery('.sub-menu-trigger').on('click', function() {
            if( jQuery(this).parent().hasClass('active') ){
                jQuery(this).prev().slideUp();
                jQuery(this).parent().removeClass('active');
            } else {
                var currentParents = jQuery(this).parents('.menu-item');
                jQuery('.sub-menu-trigger').parent().not(currentParents).removeClass('active');
                jQuery('.sub-menu-trigger').parent().not(currentParents).find('.sub-menu').slideUp(300);

                jQuery(this).prev().slideDown();
                jQuery(this).parent().addClass('active');
            }
        });
    }
    mobile_menu();
    widget_list_hierarchy_init();
    portfolio_grid();
    setTimeout(portfolio_grid, 500);
    setTimeout(fix_responsive_iframe, 500);
});

// --------------------- //
// --- Window Resize --- //
// --------------------- //
jQuery(window).on('resize', function () {
    sticky_menu_active();
    mobile_menu_open();
});

// --------------------- //
// --- Window Scroll --- //
// --------------------- //
jQuery(window).on('scroll', function () {

});

(function ($){
    var loader;
    $.fn.start_loader = start_loader;
    $.fn.stop_loader = stop_loader;

    $( document ).ready(function (){
        page_loader_controller ();
    });

    function page_loader_controller (){
        var cws_page_loader, interval, timeLaps ;
        cws_page_loader = $( '.page_loader' );
        timeLaps = 0;
        interval = setInterval( function (){
            var page_loaded = check_if_page_loaded ();
            timeLaps ++;
            if ( page_loaded ||  timeLaps == 12) {
                clearInterval ( interval );
                cws_page_loader.stop_loader ();
            }
        }, 10);
    }

    function check_if_page_loaded (){
        var keys, key, i, r;
        if ( window.modules_state == undefined ) return false;
        r = true;
        keys = Object.keys( window.modules_state );
        for ( i = 0; i < keys.length; i++ ){
            key = keys[i];
            if ( !window.modules_state[key] ){
                r = false;
                break;
            }
        }
        return r;
    }

    function start_loader (){
        var loader_container;
        loader = jQuery( this );
        if ( !loader.length ) return;
        loader_container = loader[0].parentNode;
        if ( loader_container != null ){
            loader_container.style.opacity = 1;
            setTimeout( function (){
                loader_container.style.display = "block";
            }, 10);
        }
    }

    function stop_loader (){
        var loader_container;
        loader = jQuery( this );
        if ( !loader.length ) return;
        loader_container = loader[0].parentNode;
        if ( loader_container != null ){
            loader_container.style.opacity = 0;
            setTimeout( function (){
                loader_container.style.display = "none";
            }, 200);
        }
    }

}(jQuery));