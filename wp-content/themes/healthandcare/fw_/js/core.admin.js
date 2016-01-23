/**
 * HealthandCARE Framework: Admin scripts
 *
 * @package	healthandcare
 * @since	healthandcare 1.0
 */


// Fill categories after change post type in widgets
function healthandcare_admin_change_post_type(fld) {
	"use strict";
	var cat_fld = jQuery(fld).parent().next().find('select');
	var cat_lbl = jQuery(fld).parent().next().find('label');
	healthandcare_admin_fill_categories(fld, cat_fld, cat_lbl);
	return false;
}


// Fill categories in specified field
function healthandcare_admin_fill_categories(fld, cat_fld, cat_lbl) {
	"use strict";
	var cat_value = healthandcare_get_listbox_selected_value(cat_fld.get(0));
	cat_lbl.append('<span class="sc_refresh iconadmin-spin3 animate-spin"></span>');
	var pt = jQuery(fld).val();
	// Prepare data
	var data = {
		action: 'healthandcare_admin_change_post_type',
		nonce: HEALTHANDCARE_GLOBALS['ajax_nonce'],
		post_type: pt
	};
	jQuery.post(HEALTHANDCARE_GLOBALS['ajax_url'], data, function(response) {
		"use strict";
		var rez = JSON.parse(response);
		if (rez.error === '') {
			var opt_list = '';
			for (var i in rez.data.ids) {
				opt_list += '<option class="'+rez.data.ids[i]+'" value="'+rez.data.ids[i]+'"'+(rez.data.ids[i]==cat_value ? ' selected="selected"' : '')+'>'+rez.data.titles[i]+'</option>';
			}
			cat_fld.html(opt_list);
			cat_lbl.find('span').remove();
		}
	});
	return false;
}
