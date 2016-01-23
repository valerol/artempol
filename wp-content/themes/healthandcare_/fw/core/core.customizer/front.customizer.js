// Customization panel

jQuery(document).ready(function() {
	"use strict";

	// Open/close panel
	if (jQuery('#custom_options').length > 0) {

		jQuery('#co_toggle').on("click", function(e) {
			"use strict";
			var co = jQuery('#custom_options').eq(0);
			if (co.hasClass('opened')) {
				co.removeClass('opened');
				jQuery('body').removeClass('custom_options_opened');
				jQuery('.custom_options_shadow').fadeOut(500);
			} else {
				co.addClass('opened');
				jQuery('body').addClass('custom_options_opened');
				jQuery('.custom_options_shadow').fadeIn(500);
			}
			e.preventDefault();
			return false;
		});
		jQuery('.custom_options_shadow').on("click", function(e) {
			"use strict";
			jQuery('#co_toggle').trigger('click');
			e.preventDefault();
			return false;
		});

		// First open custom panel
		if (HEALTHANDCARE_GLOBALS['demo_time'] > 0) {
			if (healthandcare_get_cookie('healthandcare_custom_options_demo') != 1 ){
				setTimeout(function() { jQuery("#co_toggle").trigger('click'); }, HEALTHANDCARE_GLOBALS['demo_time']);
				healthandcare_set_cookie('healthandcare_custom_options_demo', '1', 1);
			}
		}

		healthandcare_custom_options_reset(!HEALTHANDCARE_GLOBALS['remember_visitors_settings']);

		jQuery('#custom_options #co_theme_reset').on("click", function(e) {
			"use strict";
			jQuery('#custom_options .co_section').each(function () {
				"use strict";
				jQuery(this).find('div[data-options]').each(function() {
					var opt = jQuery(this).data('options');
					if (HEALTHANDCARE_GLOBALS['remember_visitors_settings'])
						healthandcare_del_cookie(opt);
					else
						healthandcare_custom_options_remove_option_from_url(opt);
				});
			});
			healthandcare_custom_options_show_loader();
			//window.location.reload();
			window.location.href = jQuery('#co_site_url').val();
			e.preventDefault();
			return false;
		});

		// Switcher
		var swither = jQuery("#custom_options .co_switch_box:not(.inited)" )
		if (swither.length > 0) {
			swither.each(function() {
				jQuery(this).addClass('inited');
				healthandcare_custom_options_switcher(jQuery(this));
			});
			jQuery("#custom_options .co_switch_box a" ).on("click", function(e) {
				"use strict";
				var value = jQuery(this).data('value');
				var wrap = jQuery(this).parent('.co_switch_box');
				var options = wrap.data('options');
				wrap.find('.switcher').data('value', value);
				if (HEALTHANDCARE_GLOBALS['remember_visitors_settings']) healthandcare_set_cookie(options, value, 1);
				healthandcare_custom_options_reset(true);
				healthandcare_custom_options_switcher(wrap);
				healthandcare_custom_options_apply_settings(options, value);
				e.preventDefault();
				return false;
			});
		}

		// ColorPicker
		healthandcare_color_picker();
		jQuery('#custom_options .iColorPicker').each(function() {
			"use strict";
			jQuery(this).css('backgroundColor', jQuery(this).data('value'));
		});

		jQuery('#custom_options .iColorPicker').on("click", function(e) {
			"use strict";
			healthandcare_color_picker_show(null, jQuery(this), function(fld, clr) {
				"use strict";
				var val = fld.data('value');
				var options = fld.data('options');
				fld.css('backgroundColor', clr);
				if (HEALTHANDCARE_GLOBALS['remember_visitors_settings']) healthandcare_set_cookie(options, clr, 1);
				if (options == 'bg_color') {
					if (HEALTHANDCARE_GLOBALS['remember_visitors_settings'])  {
						healthandcare_del_cookie('bg_image');
						healthandcare_del_cookie('bg_pattern');
					}
				}
				healthandcare_custom_options_reset(true);
				healthandcare_custom_options_apply_settings(options, clr);
			});
		});
		
		// Color scheme
		jQuery('#custom_options #co_scheme_list a').on("click", function(e) {
			"use strict";
			jQuery('#custom_options #co_scheme_list .co_scheme_wrapper').removeClass('active');
			var obj = jQuery(this).addClass('active');
			var val = obj.data('value');
			if (HEALTHANDCARE_GLOBALS['remember_visitors_settings'])  {
				healthandcare_set_cookie('body_scheme', val, 1);
			}
			healthandcare_custom_options_reset(true);
			healthandcare_custom_options_apply_settings('body_scheme', val);
			e.preventDefault();
			return false;
		});
		
		// Background patterns
		jQuery('#custom_options #co_bg_pattern_list a').on("click", function(e) {
			"use strict";
			jQuery('#custom_options #co_bg_pattern_list .co_pattern_wrapper,#custom_options #co_bg_images_list .co_image_wrapper').removeClass('active');
			var obj = jQuery(this).addClass('active');
			var val = obj.attr('id').substr(-1);
			if (HEALTHANDCARE_GLOBALS['remember_visitors_settings'])  {
				healthandcare_del_cookie('bg_color');
				healthandcare_del_cookie('bg_image');
				healthandcare_set_cookie('bg_pattern', val, 1);
			}
			healthandcare_custom_options_reset(true);
			healthandcare_custom_options_apply_settings('bg_pattern', val);
			if (jQuery("#custom_options .co_switch_box .switcher").data('value') != 'boxed') {
				HEALTHANDCARE_GLOBALS['co_add_params'] = {'bg_pattern': val};
				jQuery("#custom_options .co_switch_box a[data-value='boxed']").trigger('click');
			}
			e.preventDefault();
			return false;
		});

		// Background images
		jQuery('#custom_options #co_bg_images_list a').on("click", function(e) {
			"use strict";
			jQuery('#custom_options #co_bg_images_list .co_image_wrapper, #custom_options #co_bg_pattern_list .co_pattern_wrapper').removeClass('active');
			var obj = jQuery(this).addClass('active');
			var val = obj.attr('id').substr(-1);
			if (HEALTHANDCARE_GLOBALS['remember_visitors_settings'])  {
				healthandcare_del_cookie('bg_color');
				healthandcare_del_cookie('bg_pattern');
				healthandcare_set_cookie('bg_image', val, 1);
			}
			healthandcare_custom_options_reset(true);
			healthandcare_custom_options_apply_settings('bg_image', val);
			if (jQuery("#custom_options .co_switch_box .switcher").data('value') != 'boxed') {
				HEALTHANDCARE_GLOBALS['co_add_params'] = {'bg_image': val};
				jQuery("#custom_options .co_switch_box a[data-value='boxed']").trigger('click');
			}
			e.preventDefault();
			return false;
		});

		jQuery('#custom_options #co_bg_pattern_list a, #custom_options #co_bg_images_list a, .iColorPicker').on("hover",
			function() {
				"use strict";
				jQuery(this).addClass('current');
			},
			function() {
				"use strict";
				jQuery(this).removeClass('current');
			}
		);
	}
});

jQuery(window).resize(function () {
	jQuery('#custom_options .sc_scroll').css('height',jQuery('#custom_options').height()-46);
})


// SwitchBox
function healthandcare_custom_options_switcher(wrap) {
	"use strict";
	var drag = wrap.find('.switcher').eq(0);
	var value = drag.data('value');
	var pos = wrap.find('a[data-value="'+value+'"]').position();
	if (pos != undefined) {
		drag.css({
			left: pos.left,
			top: pos.top
		});
	}
}

// Show Reset button
function healthandcare_custom_options_reset() {
	"use strict";

	var cooks = arguments[0] ? true : false;
	
	if (!cooks) {
		jQuery('#custom_options .co_section').each(function () {
			if (cooks) return;
	
			jQuery(this).find('div[data-options]').each(function() {
				var cook = healthandcare_get_cookie(jQuery(this).data('options'))
				if (cook != null && cook != undefined)
					cooks = true;			
			});
		});
	}
	if (cooks)
		jQuery('#custom_options').addClass('co_show_reset');			
	else
		jQuery('#custom_options').removeClass('co_show_reset');
}

// Remove specified option from URL
function healthandcare_custom_options_remove_option_from_url(option) {
	var pos = -1, pos2 = -1, pos3 = -1;
	var loc = jQuery('#co_site_url').val();
	if (loc && (pos = loc.indexOf('?')) > 0) {
		if ((pos2 = loc.indexOf(option, pos)) > 0) {
			if ((pos3 = loc.indexOf('&', pos2)) > 0)
				loc = loc.substr(0, pos2) + loc.substr(pos3);
			else
				loc = loc.substr(0, pos2);
		}
		jQuery('#co_site_url').val(loc);
	}
}

// Show Loader
function healthandcare_custom_options_show_loader() {
	jQuery('.custom_options_shadow').addClass('loading');
}

// Apply settings
function healthandcare_custom_options_apply_settings(option, val) {
	if (window.healthandcare_skin_customizer)
		healthandcare_skin_customizer(option, val);
	else {
		healthandcare_custom_options_show_loader();
		location.reload();
	}
}
