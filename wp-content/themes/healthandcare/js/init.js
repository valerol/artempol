jQuery( document ).ready( function() {
    'use strict';    
    healthandcare_init_actions();	
});

// Theme init actions
function healthandcare_init_actions() {
    "use strict";
  
    healthandcare_ready_actions();
    healthandcare_resize_actions();
    healthandcare_scroll_actions();

    // Resize handlers
    jQuery(window).resize(function() {
        "use strict";
        healthandcare_resize_actions();
    });

    // Scroll handlers
    jQuery(window).scroll(function() {
        "use strict";
        healthandcare_scroll_actions();
    });
}

// Theme first load actions
function healthandcare_ready_actions() {
    "use strict";
    
    healthandcare_init_sfmenu();

    // Responsive menu button
    jQuery('.menu_main_responsive_button, .sidebar_outer_menu_responsive_button').on("click", function(e){
        "use strict";
        if (jQuery(this).hasClass('menu_main_responsive_button'))
            jQuery('.menu_main_responsive').slideToggle();
        else {
            jQuery(this).toggleClass('icon-down').toggleClass('icon-up');
            jQuery('.menu_side_responsive').slideToggle();
        }
        e.preventDefault();
        return false;
    });

    // Submenu click handler for the responsive menu
    jQuery('.menu_main_responsive li a, .menu_side_responsive li a').on("click", function(e) {
        "use strict";
        var is_menu_main = jQuery(this).parents('.menu_main_responsive').length > 0;
        if ((!is_menu_main || jQuery('body').hasClass('responsive_menu')) && jQuery(this).parent().hasClass('menu-item-has-children')) {
            if (jQuery(this).siblings('ul:visible').length > 0)
                jQuery(this).siblings('ul').slideUp().parent().removeClass('opened');
            else
                jQuery(this).siblings('ul').slideDown().parent().addClass('opened');
        }
        if (jQuery(this).attr('href')=='#' || ((!is_menu_main || jQuery('body').hasClass('responsive_menu')) && jQuery(this).parent().hasClass('menu-item-has-children'))) {
            e.preventDefault();
            return false;
        }
    });

    // One page mode for menu links (scroll to anchor)
    jQuery('#toc, ul#menu_main li, ul#menu_user li, ul#menu_side li, ul#menu_footer li').on('click', 'a', function(e) {
        "use strict";
        var href = jQuery(this).attr('href');
        if (href===undefined) return;
        var pos = href.indexOf('#');
        if (pos < 0 || href.length == 1) return;
        if (jQuery(href.substr(pos)).length > 0) {
            var loc = window.location.href;
            var pos2 = loc.indexOf('#');
            if (pos2 > 0) loc = loc.substring(0, pos2);
            var now = pos==0;
            if (!now) now = loc == href.substring(0, pos);
            if (now) {
                healthandcare_document_animate_to(href.substr(pos));
                healthandcare_document_set_location(pos==0 ? loc + href : href);
                e.preventDefault();
                return false;
            }
        }
    });

    // Pagination
    jQuery('.pager_cur').on("click", function(e) {
        "use strict";
        jQuery('.pager_slider').slideDown(300, function() {
            healthandcare_init_shortcodes(jQuery('.pager_slider').eq(0));
        });
        e.preventDefault();
        return false;
    });

    // Выпадающее окно авторизации
    jQuery( '.popup_link' ).addClass( 'inited' ).on( 'click' , function(e) {
	    var popup = jQuery( jQuery( this ).attr( 'href' ) );
	    if ( popup.length === 1 ) {
		    if ( popup.css( 'display' ) != 'none' )
			    popup.fadeOut();
		    else
			    popup.fadeIn();
	    }
	    e.preventDefault();
	    return false;
    });
    jQuery( '.popup_wrap .popup_close' ).on( 'click', function(e) {
	    var popup = jQuery( this ).parent();
	    if ( popup.length === 1 ) {
		    popup.fadeOut();
	    }
	    e.preventDefault();
	    return false;
    });
    
    // Main Slider
    var mainSwiper = new Swiper ( '.main-slider', {
		autoplay: 3600,
	    centeredSlides: true,
	    nextButton: '.button-prev-main',
	    prevButton: '.button-next-main',
	    pagination: '.bullets-main',
	    paginationType: 'bullets',
	    paginationClickable: true,
	    loop: true,
    });
    
    // Team Slider  
    var teamSwiper = new Swiper ( '.doctors', {
	    slidesPerView: 'auto',
	    centeredSlides: true,
	    nextButton: '.swiper-button-prev',
	    prevButton: '.swiper-button-next',
	    pagination: '.bullets-team',
	    paginationType: 'bullets',
	    paginationClickable: true,
	    loop: true,
    });
    
    // Achievements Swiper  
    var achievementsSwiper = new Swiper ( '.achievements', {
	    slidesPerView: 1,
	    centeredSlides: true,
	    nextButton: '.swiper-button-prev',
	    prevButton: '.swiper-button-next',
	    pagination: '.bullets-achievements',
	    paginationType: 'bullets',
	    paginationClickable: true,
	    loop: true,
    });
    
    jQuery( 'a.colorbox, .gallery a' ).colorbox();
}

// Do actions when page scrolled
function healthandcare_scroll_actions() {
    "use strict";

    var scroll_offset = jQuery(window).scrollTop();
    var scroll_to_top_button = jQuery('.scroll_to_top');
    var adminbar_height = Math.max(0, jQuery('#wpadminbar').height());
    var slider_height = 0;
    var top_height = 100;

    // Call skin specific action (if exists)
    //----------------------------------------------
    if (window.healthandcare_skin_scroll_actions) healthandcare_skin_scroll_actions();


    // Scroll to top button show/hide
    if (scroll_offset > top_height )
        scroll_to_top_button.addClass('show');
    else
        scroll_to_top_button.removeClass('show');

    // Fix/unfix top panel
    if (!jQuery('body').hasClass('responsive_menu') ) {

	if (scroll_offset <= slider_height + top_height ) {
        
	    if (jQuery('body').hasClass('top_panel_fixed')) {
                jQuery('body').removeClass('top_panel_fixed');
		jQuery('.top_panel_wrap').css('marginTop', 0);
            }
        } 
        else if (scroll_offset > slider_height + top_height ) {
        
	    if (!jQuery('body').hasClass('top_panel_fixed')) {
                jQuery('.top_panel_fixed_wrap').height( top_height );
                jQuery('.top_panel_wrap').css('marginTop', '-150px').animate({'marginTop': 0 + adminbar_height }, 500);
                jQuery('body').addClass('top_panel_fixed');
            }
        }
    }

    // TOC current items
    jQuery('#toc .toc_item').each(function() {
        "use strict";
        var id = jQuery(this).find('a').attr('href');
        var pos = id.indexOf('#');
        if (pos < 0 || id.length == 1) return;
        var loc = window.location.href;
        var pos2 = loc.indexOf('#');
        if (pos2 > 0) loc = loc.substring(0, pos2);
        var now = pos==0;
        if (!now) now = loc == href.substring(0, pos);
        if (!now) return;
        var off = jQuery(id).offset().top;
        var id_next  = jQuery(this).next().find('a').attr('href');
        var off_next = id_next ? jQuery(id_next).offset().top : 1000000;
        if (off < scroll_offset + jQuery(window).height()*0.8 && scroll_offset + top_height < off_next)
            jQuery(this).addClass('current');
        else
            jQuery(this).removeClass('current');
    });
}

// Do actions when page resized
function healthandcare_resize_actions() {
    "use strict";

    // Call skin specific action (if exists)
    //----------------------------------------------
    if (window.healthandcare_skin_resize_actions) healthandcare_skin_resize_actions();
    healthandcare_responsive_menu();
    healthandcare_resize_fullscreen_slider();
}

// Check window size and do responsive menu
function healthandcare_responsive_menu() {
  
    if (healthandcare_is_responsive_need( 768 )) {
        
	if (!jQuery('body').hasClass('responsive_menu')) {
            jQuery('body').removeClass('top_panel_fixed').addClass('responsive_menu');
            if (jQuery('body').hasClass('menu_relayout'))
                jQuery('body').removeClass('menu_relayout');
            if (jQuery('ul.menu_main_nav').hasClass('inited')) {
                jQuery('ul.menu_main_nav').removeClass('inited').superfish('destroy');
            }
            if (jQuery('ul.menu_side_nav').hasClass('inited')) {
                jQuery('ul.menu_side_nav').removeClass('inited').superfish('destroy');
            }
        }
    } 
    else {
        if (jQuery('body').hasClass('responsive_menu')) {
            jQuery('body').removeClass('responsive_menu');
            jQuery('.menu_main_responsive').hide();
	    healthandcare_init_sfmenu();
            jQuery('.menu_main_nav_area').show();
        }
    }
    if (!jQuery('.top_panel_wrap').hasClass('menu_show')) jQuery('.top_panel_wrap').addClass('menu_show');
}

// Check if responsive menu need
function healthandcare_is_responsive_need(max_width) {
    "use strict";
    var rez = false;
    if (max_width > 0) {
        var w = window.innerWidth;
        if (w == undefined) {
            w = jQuery(window).width()+(jQuery(window).height() < jQuery(document).height() || jQuery(window).scrollTop() > 0 ? 16 : 0);
        }
        rez = max_width > w;
    }
    return rez;
}

// Выпадающее меню
function healthandcare_init_sfmenu() {
    jQuery( 'ul#menu_main' ).superfish( {
	  delay:       1000,                            // задержка в миллисекунду
	  animation: { 
		  opacity:'show',
		  height:'show' 
		},  // fade-in и slide-down анимация
	  speed:       'fast',                          // увеличение скорости анимации
	  autoArrows:  false,                           // отключает стрелку подменю
	  dropShadows: false                            // отключает тень
    } );
}

// Resize Fullscreen Slider
function healthandcare_resize_fullscreen_slider() {
    "use strict";
    
    var slider = jQuery( '.main-slider' );
    
    if ( slider.length < 1 )
        return;
    
    var h = jQuery(window).height() - jQuery('#wpadminbar').height() - (jQuery('body').hasClass('top_panel_above') && !jQuery('body').hasClass('.top_panel_fixed') ? jQuery('.top_panel_wrap').height() : 0);
    
    if ( h < 570 ) {
      slider.height(h);
    }
}
