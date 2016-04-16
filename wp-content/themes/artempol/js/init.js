jQuery( document ).ready( function() {
    'use strict';   
    artempol_init_actions();	
} );

// Theme init actions
function artempol_init_actions() {
    'use strict'; 
  
    artempol_ready_actions();
    artempol_resize_actions();
    artempol_scroll_actions();

    // Resize handlers
    jQuery(window).resize(function() {
        'use strict'; 
        artempol_resize_actions();
    } );

    // Scroll handlers
    jQuery(window).scroll(function() {
        'use strict'; 
        artempol_scroll_actions();
    } );
}

// Theme first load actions
function artempol_ready_actions() {
    'use strict'; 
	
	if ( ! jQuery( 'html' ).hasClass( 'ie8') ) { 
		new WOW().init();	
	};
    
    artempol_init_sfmenu();
	
	artempol_resize_fullscreen_slider();

    // Responsive menu button
    jQuery( '.menu_main_responsive_button' ).on( 'click', function(e){
        'use strict';
        jQuery( '.menu_main.responsive' ).slideToggle();
        e.preventDefault();
        return false;
    } );

    // Submenu click handler for the responsive menu
    jQuery( '.menu_main.responsive li a' ).on( 'click', function(e) {
        'use strict'; 
        var is_fullsize = jQuery( this ).parents( '.menu_main.responsive' ).length > 0;
        
        if ( ( ! is_fullsize || jQuery( 'body' ).hasClass( 'responsive_menu' ) ) && jQuery( this ).parent().hasClass( 'menu-item-has-children') ) {
            
            if ( jQuery( this ).siblings( 'ul:visible' ).length > 0)
                jQuery( this ).siblings( 'ul' ).slideUp().parent().removeClass( 'opened' );
            else
                jQuery( this ).siblings( 'ul' ).slideDown().parent().addClass( 'opened' );
        }
        
        if ( jQuery( this ).attr( 'href' ) == '#' || ( ( ! is_fullsize || jQuery( 'body' ).hasClass( 'responsive_menu' ) ) && jQuery( this ).parent().hasClass( 'menu-item-has-children' ) ) ) {
            e.preventDefault();
            return false;
        }
    } );

    // One page mode for menu links (scroll to anchor)
    jQuery( 'ul#menu_main li, ul#menu_user li' ).on( 'click', 'a', function(e) {
        'use strict';
        var href = jQuery( this ).attr( 'href' );
        
        if ( href===undefined ) return;
        
        var pos = href.indexOf( '#' );
        
        if ( pos < 0 || href.length == 1 ) return;
        
        if ( jQuery( href.substr(pos) ).length > 0 ) {
            var loc = window.location.href;
            var pos2 = loc.indexOf( '#' );
            
            if ( pos2 > 0 ) loc = loc.substring( 0, pos2 );
            var now = pos == 0;
            
            if ( ! now ) now = loc == href.substring( 0, pos );
            
            if ( now ) {
                artempol_document_animate_to( href.substr( pos ) );
                artempol_document_set_location( pos==0 ? loc + href : href );
                e.preventDefault();
                return false;
            }
        }
    } );

    // Authorization
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
    } );
    
    jQuery( '.popup_wrap .popup_close' ).on( 'click', function(e) {
	    var popup = jQuery( this ).parent();
	    
	    if ( popup.length === 1 ) {
		    popup.fadeOut();
	    }
	    e.preventDefault();
	    return false;
    } );
    
    // Flexslider
    
    jQuery( '.slider-main' ).flexslider( {
		animation: 'slide',
	} );
	
	jQuery( '.slider-achieve' ).flexslider( {
		animation: "slide",
		itemWidth: 300,
		maxItems: 1,
	} );
	
	jQuery( '.slider-team' ).flexslider( {
		animation: 'slide',
		slideshowSpeed: 10000000,
		itemWidth: 300,
		maxItems: 4,
	} );
	
	// Colorbox    
    jQuery( 'a.colorbox, .gallery a' ).colorbox();
}

// Do actions when page scrolled
function artempol_scroll_actions() {
    'use strict';

    var scroll_offset = jQuery( window ).scrollTop();
    var scroll_to_top_button = jQuery( '.scroll_to_top' );
    var adminbar_height = Math.max( 0, jQuery( '#wpadminbar' ).height() );
    var slider_height = 0;
    var top_height = 100;

    // Call skin specific action (if exists)
    //----------------------------------------------
    if ( window.artempol_skin_scroll_actions ) artempol_skin_scroll_actions();


    // Scroll to top button show/hide
    if ( scroll_offset > top_height )
        scroll_to_top_button.css( 'display', 'block' );
    else
        scroll_to_top_button.css( 'display', 'none' );

    // Fix/unfix top panel
    if ( ! jQuery( 'body' ).hasClass( 'responsive_menu' ) ) {

		if ( scroll_offset <= slider_height + top_height ) {
        
			if ( jQuery( 'body' ).hasClass( 'top_panel_fixed' ) ) {
				jQuery('body').removeClass('top_panel_fixed');
				jQuery( '.nav' ).css( 'marginTop', 0 );
			}
        } 
        else if ( scroll_offset > slider_height + top_height ) {
        
			if ( !jQuery( 'body' ).hasClass( 'top_panel_fixed' ) ) {
				jQuery( 'body' ).addClass( 'top_panel_fixed' );
				jQuery( '.nav' ).css( 'marginTop', '-150px' ).animate( { 'marginTop': 0 + adminbar_height }, 500 );
			}
        }
    }
}

// Do actions when page resized
function artempol_resize_actions() {
    'use strict';
    artempol_responsive_menu();
    artempol_resize_fullscreen_slider();
}

// Check window size and do responsive menu
function artempol_responsive_menu() {
  
    if ( artempol_is_responsive_need( 768 ) ) {
        
		if ( ! jQuery( 'body' ).hasClass( 'responsive_menu' ) ) {
            jQuery( 'body' ).removeClass( 'top_panel_fixed' ).addClass( 'responsive_menu' );
        }
		jQuery( '.menu_main.fullsize' ).hide();
		jQuery( '.menu_main_responsive_button' ).show();
    } 
    else {
        
        if ( jQuery( 'body' ).hasClass( 'responsive_menu' ) ) {
            jQuery( 'body' ).removeClass( 'responsive_menu' );
            jQuery( '.menu_main.responsive' ).hide();
			jQuery( '.menu_main_responsive_button' ).hide();
			jQuery( '.menu_main.fullsize' ).show();
			artempol_init_sfmenu();
        }
    }
}

// Check if responsive menu need
function artempol_is_responsive_need( max_width ) {
    'use strict';
    var rez = false;
    
    if ( max_width > 0 ) {
        var w = window.innerWidth;
        
        if ( w == undefined ) {
            w = jQuery( window ).width() + ( jQuery( window ).height() < jQuery( document ).height() || jQuery( window ).scrollTop() > 0 ? 16 : 0);
        }
        rez = max_width > w;
    }
    return rez;
}

// Выпадающее меню
function artempol_init_sfmenu() {
    jQuery( 'ul#menu_main.fullsize' ).superfish( {
	  delay: 1000, // задержка в миллисекунду
	  animation: { 
		  opacity:'show',
		  height:'show' 
		}, // fade-in и slide-down анимация
	  speed: 'fast', // увеличение скорости анимации
	  autoArrows: false, // отключает стрелку подменю
	  dropShadows: false // отключает тень
    } );
}

// Resize Fullscreen Slider
function artempol_resize_fullscreen_slider() {
    'use strict';
    
    var slider = jQuery( '.slider-main' )
    
    if ( slider.length < 1 ) {
        return;
	}
    
    var window_height = jQuery( window ).height() - jQuery( '#wpadminbar' ).height() - ( jQuery( 'body' ).hasClass( 'top_panel_above' ) && ! jQuery( 'body' ).hasClass( '.top_panel_fixed' ) ? jQuery( '.top_panel_wrap' ).height() : 0 );
	var window_width = jQuery( window ).width();

	if ( window_height < 570 ) {
		jQuery( '.slider-main, li.slide' ).height( window_height );
		
		if ( window_height * 2 > window_width * 3 ) {
			jQuery( '.slider-main h2' ).css( 'width', '100%' );
		}
		else {
			jQuery( '.slider-main h2' ).css( 'width', '70%' );
		}
	}
	else jQuery( '.slider-main, li.slide' ).height( 570 );
}
