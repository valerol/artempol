// Init scripts
jQuery(document).ready(function(){
	"use strict";

    if (typeof(vc) != 'undefined' && typeof(vc.Storage) != 'undefined') {

        // Override standard VC function to prevent wrap HealthandCARE shortcode's content in <p>...</p>
        vc.Storage.prototype._getShortcodeContent = function ( parent ) {
            var that = this,
                models = _.sortBy( _.filter( this.data, function ( model ) {
                    // Filter children
                    return model.parent_id === parent.id;
                } ), function ( model ) {
                    // Sort by `order` field
                    return model.order;
                } ),
                params = {};
            _.extend( params, parent.params );

            if ( ! models.length ) {

                if ( ! _.isUndefined( window.switchEditors ) && _.isString( params.content ) && window.switchEditors.wpautop( params.content ) === params.content ) {

                    if ( parent.shortcode.indexOf('trx_')!==0 )
                        params.content = window.vc_wpautop( params.content );
                }

                return _.isUndefined( params.content ) ? '' : params.content;
            }
            return _.reduce( models, function ( memo, model ) {
                return memo + that.createShortcodeString( model );
            }, '' );
        };

    }
	// Settings and constants
	HEALTHANDCARE_GLOBALS['shortcodes_delimiter'] = ',';		// Delimiter for multiple values
	HEALTHANDCARE_GLOBALS['shortcodes_popup'] = null;		// Popup with current shortcode settings
	HEALTHANDCARE_GLOBALS['shortcodes_current_idx'] = '';	// Current shortcode's index
	HEALTHANDCARE_GLOBALS['shortcodes_tab_clone_tab'] = '<li id="healthandcare_shortcodes_tab_{id}" data-id="{id}"><a href="#healthandcare_shortcodes_tab_{id}_content"><span class="iconadmin-{icon}"></span>{title}</a></li>';
	HEALTHANDCARE_GLOBALS['shortcodes_tab_clone_content'] = '';

	// Shortcode selector - "change" event handler - add selected shortcode in editor
	jQuery('body').on('change', ".sc_selector", function() {
		"use strict";
		HEALTHANDCARE_GLOBALS['shortcodes_current_idx'] = jQuery(this).find(":selected").val();
		if (HEALTHANDCARE_GLOBALS['shortcodes_current_idx'] == '') return;
		var sc = healthandcare_clone_object(HEALTHANDCARE_GLOBALS['shortcodes'][HEALTHANDCARE_GLOBALS['shortcodes_current_idx']]);
		var hdr = sc.title;
		var content = "";
		try {
			content = tinyMCE.activeEditor ? tinyMCE.activeEditor.selection.getContent({format : 'raw'}) : jQuery('#wp-content-editor-container textarea').selection();
		} catch(e) {};
		if (content) {
			for (var i in sc.params) {
				if (i == '_content_') {
					sc.params[i].value = content;
					break;
				}
			}
		}
		var html = (!healthandcare_empty(sc.desc) ? '<p>'+sc.desc+'</p>' : '')
			+ healthandcare_shortcodes_prepare_layout(sc);


		// Show Dialog popup
		HEALTHANDCARE_GLOBALS['shortcodes_popup'] = healthandcare_message_dialog(html, hdr,
			function(popup) {
				"use strict";
				healthandcare_options_init(popup);
				popup.find('.healthandcare_options_tab_content').css({
					maxHeight: jQuery(window).height() - 300 + 'px',
					overflow: 'auto'
				});
			},
			function(btn, popup) {
				"use strict";
				if (btn != 1) return;
				var sc = healthandcare_shortcodes_get_code(HEALTHANDCARE_GLOBALS['shortcodes_popup']);
				if (tinyMCE.activeEditor) {
					if ( !tinyMCE.activeEditor.isHidden() )
						tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, sc );
					//else if (typeof wpActiveEditor != 'undefined' && wpActiveEditor != '') {
					//	document.getElementById( wpActiveEditor ).value += sc;
					else
						send_to_editor(sc);
				} else
					send_to_editor(sc);
			});

		// Set first item active
		jQuery(this).get(0).options[0].selected = true;

		// Add new child tab
		HEALTHANDCARE_GLOBALS['shortcodes_popup'].find('.healthandcare_shortcodes_tab').on('tabsbeforeactivate', function (e, ui) {
			if (ui.newTab.data('id')=='add') {
				healthandcare_shortcodes_add_tab(ui.newTab);
				e.stopImmediatePropagation();
				e.preventDefault();
				return false;
			}
		});

		// Delete child tab
		HEALTHANDCARE_GLOBALS['shortcodes_popup'].find('.healthandcare_shortcodes_tab > ul').on('click', '> li+li > a > span', function (e) {
			var tab = jQuery(this).parents('li');
			var idx = tab.data('id');
			if (parseInt(idx) > 1) {
				if (tab.hasClass('ui-state-active')) {
					tab.prev().find('a').trigger('click');
				}
				tab.parents('.healthandcare_shortcodes_tab').find('.healthandcare_options_tab_content').eq(idx).remove();
				tab.remove();
				e.preventDefault();
				return false;
			}
		});

		return false;
	});

});



// Return result code
//------------------------------------------------------------------------------------------
function healthandcare_shortcodes_get_code(popup) {
	HEALTHANDCARE_GLOBALS['sc_custom'] = '';
	
	var sc_name = HEALTHANDCARE_GLOBALS['shortcodes_current_idx'];
	var sc = HEALTHANDCARE_GLOBALS['shortcodes'][sc_name];
	var tabs = popup.find('.healthandcare_shortcodes_tab > ul > li');
	var decor = !healthandcare_isset(sc.decorate) || sc.decorate;
	var rez = '[' + sc_name + healthandcare_shortcodes_get_code_from_tab(popup.find('#healthandcare_shortcodes_tab_0_content').eq(0)) + ']'
			// + (decor ? '\n' : '')
			;
	if (healthandcare_isset(sc.children)) {
		if (HEALTHANDCARE_GLOBALS['sc_custom']!='no') {
			var decor2 = !healthandcare_isset(sc.children.decorate) || sc.children.decorate;
			for (var i=0; i<tabs.length; i++) {
				var tab = tabs.eq(i);
				var idx = tab.data('id');
				if (isNaN(idx) || parseInt(idx) < 1) continue;
				var content = popup.find('#healthandcare_shortcodes_tab_' + idx + '_content').eq(0);
				rez += (decor2 ? '\n\t' : '') + '[' + sc.children.name + healthandcare_shortcodes_get_code_from_tab(content) + ']';	// + (decor2 ? '\n' : '');
				if (healthandcare_isset(sc.children.container) && sc.children.container) {
					if (content.find('[data-param="_content_"]').length > 0) {
						rez += 
							//(decor2 ? '\t\t' : '') + 
							content.find('[data-param="_content_"]').val()
							// + (decor2 ? '\n' : '')
							;
					}
					rez += 
						//(decor2 ? '\t' : '') + 
						'[/' + sc.children.name + ']'
						// + (decor ? '\n' : '')
						;
				}
			}
		}
	} else if (healthandcare_isset(sc.container) && sc.container && popup.find('#healthandcare_shortcodes_tab_0_content [data-param="_content_"]').length > 0) {
		rez += 
			//(decor ? '\t' : '') + 
			popup.find('#healthandcare_shortcodes_tab_0_content [data-param="_content_"]').val()
			// + (decor ? '\n' : '')
			;
	}
	if (healthandcare_isset(sc.container) && sc.container || healthandcare_isset(sc.children))
		rez += 
			(healthandcare_isset(sc.children) && decor && HEALTHANDCARE_GLOBALS['sc_custom']!='no' ? '\n' : '')
			+ '[/' + sc_name + ']'
			 //+ (decor ? '\n' : '')
			 ;
	return rez;
}

// Collect all parameters from tab into string
function healthandcare_shortcodes_get_code_from_tab(tab) {
	var rez = ''
	var mainTab = tab.attr('id').indexOf('tab_0') > 0;
	tab.find('[data-param]').each(function () {
		var field = jQuery(this);
		var param = field.data('param');
		if (!field.parents('.healthandcare_options_field').hasClass('healthandcare_options_no_use') && param.substr(0, 1)!='_' && !healthandcare_empty(field.val()) && field.val()!='none' && (field.attr('type') != 'checkbox' || field.get(0).checked)) {
			rez += ' '+param+'="'+healthandcare_shortcodes_prepare_value(field.val())+'"';
		}
		// On main tab detect param "custom"
		if (mainTab && param=='custom') {
			HEALTHANDCARE_GLOBALS['sc_custom'] = field.val();
		}
	});
	// Get additional params for general tab from items tabs
	if (HEALTHANDCARE_GLOBALS['sc_custom']!='no' && mainTab) {
		var sc = HEALTHANDCARE_GLOBALS['shortcodes'][HEALTHANDCARE_GLOBALS['shortcodes_current_idx']];
		var sc_name = HEALTHANDCARE_GLOBALS['shortcodes_current_idx'];
		if (sc_name == 'trx_columns' || sc_name == 'trx_skills' || sc_name == 'trx_team' || sc_name == 'trx_price_table') {	// Determine "count" parameter
			var cnt = 0;
			tab.siblings('div').each(function() {
				var item_tab = jQuery(this);
				var merge = parseInt(item_tab.find('[data-param="span"]').val());
				cnt += !isNaN(merge) && merge > 0 ? merge : 1;
			});
			rez += ' count="'+cnt+'"';
		}
	}
	return rez;
}


// Shortcode parameters builder
//-------------------------------------------------------------------------------------------

// Prepare layout from shortcode object (array)
function healthandcare_shortcodes_prepare_layout(field) {
	"use strict";
	// Make params cloneable
	field['params'] = [field['params']];
	if (!healthandcare_empty(field.children)) {
		field.children['params'] = [field.children['params']];
	}
	// Prepare output
	var output = '<div class="healthandcare_shortcodes_body healthandcare_options_body"><form>';
	output += healthandcare_shortcodes_show_tabs(field);
	output += healthandcare_shortcodes_show_field(field, 0);
	if (!healthandcare_empty(field.children)) {
		HEALTHANDCARE_GLOBALS['shortcodes_tab_clone_content'] = healthandcare_shortcodes_show_field(field.children, 1);
		output += HEALTHANDCARE_GLOBALS['shortcodes_tab_clone_content'];
	}
	output += '</div></form></div>';
	return output;
}



// Show tabs
function healthandcare_shortcodes_show_tabs(field) {
	"use strict";
	// html output
	var output = '<div class="healthandcare_shortcodes_tab healthandcare_options_container healthandcare_options_tab">'
		+ '<ul>'
		+ HEALTHANDCARE_GLOBALS['shortcodes_tab_clone_tab'].replace(/{id}/g, 0).replace('{icon}', 'cog').replace('{title}', 'General');
	if (healthandcare_isset(field.children)) {
		for (var i=0; i<field.children.params.length; i++)
			output += HEALTHANDCARE_GLOBALS['shortcodes_tab_clone_tab'].replace(/{id}/g, i+1).replace('{icon}', 'cancel').replace('{title}', field.children.title + ' ' + (i+1));
		output += HEALTHANDCARE_GLOBALS['shortcodes_tab_clone_tab'].replace(/{id}/g, 'add').replace('{icon}', 'list-add').replace('{title}', '');
	}
	output += '</ul>';
	return output;
}

// Add new tab
function healthandcare_shortcodes_add_tab(tab) {
	"use strict";
	var idx = 0;
	tab.siblings().each(function () {
		"use strict";
		var i = parseInt(jQuery(this).data('id'));
		if (i > idx) idx = i;
	});
	idx++;
	tab.before( HEALTHANDCARE_GLOBALS['shortcodes_tab_clone_tab'].replace(/{id}/g, idx).replace('{icon}', 'cancel').replace('{title}', HEALTHANDCARE_GLOBALS['shortcodes'][HEALTHANDCARE_GLOBALS['shortcodes_current_idx']].children.title + ' ' + idx) );
	tab.parents('.healthandcare_shortcodes_tab').append(HEALTHANDCARE_GLOBALS['shortcodes_tab_clone_content'].replace(/tab_1_/g, 'tab_' + idx + '_'));
	tab.parents('.healthandcare_shortcodes_tab').tabs('refresh');
	healthandcare_options_init(tab.parents('.healthandcare_shortcodes_tab').find('.healthandcare_options_tab_content').eq(idx));
	tab.prev().find('a').trigger('click');
}



// Show one field layout
function healthandcare_shortcodes_show_field(field, tab_idx) {
	"use strict";
	
	// html output
	var output = '';

	// Parse field params
	for (var clone_num in field['params']) {
		var tab_id = 'tab_' + (parseInt(tab_idx) + parseInt(clone_num));
		output += '<div id="healthandcare_shortcodes_' + tab_id + '_content" class="healthandcare_options_content healthandcare_options_tab_content">';

		for (var param_num in field['params'][clone_num]) {
			
			var param = field['params'][clone_num][param_num];
			var id = tab_id + '_' + param_num;
	
			// Divider after field
			var divider = healthandcare_isset(param['divider']) && param['divider'] ? ' healthandcare_options_divider' : '';
		
			// Setup default parameters
			if (param['type']=='media') {
				if (!healthandcare_isset(param['before'])) param['before'] = {};
				param['before'] = healthandcare_merge_objects({
						'title': 'Choose image',
						'action': 'media_upload',
						'type': 'image',
						'multiple': false,
						'sizes': false,
						'linked_field': '',
						'captions': { 	
							'choose': 'Choose image',
							'update': 'Select image'
							}
					}, param['before']);
				if (!healthandcare_isset(param['after'])) param['after'] = {};
				param['after'] = healthandcare_merge_objects({
						'icon': 'iconadmin-cancel',
						'action': 'media_reset'
					}, param['after']);
			}
			if (param['type']=='color' && (HEALTHANDCARE_GLOBALS['shortcodes_cp']=='tiny' || (healthandcare_isset(param['style']) && param['style']!='wp'))) {
				if (!healthandcare_isset(param['after'])) param['after'] = {};
				param['after'] = healthandcare_merge_objects({
						'icon': 'iconadmin-cancel',
						'action': 'color_reset'
					}, param['after']);
			}
		
			// Buttons before and after field
			var before = '', after = '', buttons_classes = '', rez, rez2, i, key, opt;
			
			if (healthandcare_isset(param['before'])) {
				rez = healthandcare_shortcodes_action_button(param['before'], 'before');
				before = rez[0];
				buttons_classes += rez[1];
			}
			if (healthandcare_isset(param['after'])) {
				rez = healthandcare_shortcodes_action_button(param['after'], 'after');
				after = rez[0];
				buttons_classes += rez[1];
			}
			if (healthandcare_in_array(param['type'], ['list', 'select', 'fonts']) || (param['type']=='socials' && (healthandcare_empty(param['style']) || param['style']=='icons'))) {
				buttons_classes += ' healthandcare_options_button_after_small';
			}

			if (param['type'] != 'hidden') {
				output += '<div class="healthandcare_options_field'
					+ ' healthandcare_options_field_' + (healthandcare_in_array(param['type'], ['list','fonts']) ? 'select' : param['type'])
					+ (healthandcare_in_array(param['type'], ['media', 'fonts', 'list', 'select', 'socials', 'date', 'time']) ? ' healthandcare_options_field_text'  : '')
					+ (param['type']=='socials' && !healthandcare_empty(param['style']) && param['style']=='images' ? ' healthandcare_options_field_images'  : '')
					+ (param['type']=='socials' && (healthandcare_empty(param['style']) || param['style']=='icons') ? ' healthandcare_options_field_icons'  : '')
					+ (healthandcare_isset(param['dir']) && param['dir']=='vertical' ? ' healthandcare_options_vertical' : '')
					+ (!healthandcare_empty(param['multiple']) ? ' healthandcare_options_multiple' : '')
					+ (healthandcare_isset(param['size']) ? ' healthandcare_options_size_'+param['size'] : '')
					+ (healthandcare_isset(param['class']) ? ' ' + param['class'] : '')
					+ divider 
					+ '">' 
					+ "\n"
					+ '<label class="healthandcare_options_field_label" for="' + id + '">' + param['title']
					+ '</label>'
					+ "\n"
					+ '<div class="healthandcare_options_field_content'
					+ buttons_classes
					+ '">'
					+ "\n";
			}
			
			if (!healthandcare_isset(param['value'])) {
				param['value'] = '';
			}
			

			switch ( param['type'] ) {
	
			case 'hidden':
				output += '<input class="healthandcare_options_input healthandcare_options_input_hidden" name="' + id + '" id="' + id + '" type="hidden" value="' + healthandcare_shortcodes_prepare_value(param['value']) + '" data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '" />';
			break;

			case 'date':
				if (healthandcare_isset(param['style']) && param['style']=='inline') {
					output += '<div class="healthandcare_options_input_date"'
						+ ' id="' + id + '_calendar"'
						+ ' data-format="' + (!healthandcare_empty(param['format']) ? param['format'] : 'yy-mm-dd') + '"'
						+ ' data-months="' + (!healthandcare_empty(param['months']) ? max(1, min(3, param['months'])) : 1) + '"'
						+ ' data-linked-field="' + (!healthandcare_empty(data['linked_field']) ? data['linked_field'] : id) + '"'
						+ '></div>'
						+ '<input id="' + id + '"'
							+ ' name="' + id + '"'
							+ ' type="hidden"'
							+ ' value="' + healthandcare_shortcodes_prepare_value(param['value']) + '"'
							+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
							+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
							+ ' />';
				} else {
					output += '<input class="healthandcare_options_input healthandcare_options_input_date' + (!healthandcare_empty(param['mask']) ? ' healthandcare_options_input_masked' : '') + '"'
						+ ' name="' + id + '"'
						+ ' id="' + id + '"'
						+ ' type="text"'
						+ ' value="' + healthandcare_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-format="' + (!healthandcare_empty(param['format']) ? param['format'] : 'yy-mm-dd') + '"'
						+ ' data-months="' + (!healthandcare_empty(param['months']) ? max(1, min(3, param['months'])) : 1) + '"'
						+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
						+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />'
						+ before 
						+ after;
				}
			break;

			case 'text':
				output += '<input class="healthandcare_options_input healthandcare_options_input_text' + (!healthandcare_empty(param['mask']) ? ' healthandcare_options_input_masked' : '') + '"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' type="text"'
					+ ' value="' + healthandcare_shortcodes_prepare_value(param['value']) + '"'
					+ (!healthandcare_empty(param['mask']) ? ' data-mask="'+param['mask']+'"' : '')
					+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
					+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
				+ before 
				+ after;
			break;
		
			case 'textarea':
				var cols = healthandcare_isset(param['cols']) && param['cols'] > 10 ? param['cols'] : '40';
				var rows = healthandcare_isset(param['rows']) && param['rows'] > 1 ? param['rows'] : '8';
				output += '<textarea class="healthandcare_options_input healthandcare_options_input_textarea"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' cols="' + cols + '"'
					+ ' rows="' + rows + '"'
					+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
					+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
					+ '>'
					+ param['value']
					+ '</textarea>';
			break;

			case 'spinner':
				output += '<input class="healthandcare_options_input healthandcare_options_input_spinner' + (!healthandcare_empty(param['mask']) ? ' healthandcare_options_input_masked' : '') + '"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' type="text"'
					+ ' value="' + healthandcare_shortcodes_prepare_value(param['value']) + '"'
					+ (!healthandcare_empty(param['mask']) ? ' data-mask="'+param['mask']+'"' : '')
					+ (healthandcare_isset(param['min']) ? ' data-min="'+param['min']+'"' : '')
					+ (healthandcare_isset(param['max']) ? ' data-max="'+param['max']+'"' : '')
					+ (!healthandcare_empty(param['step']) ? ' data-step="'+param['step']+'"' : '')
					+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
					+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />' 
					+ '<span class="healthandcare_options_arrows"><span class="healthandcare_options_arrow_up iconadmin-up-dir"></span><span class="healthandcare_options_arrow_down iconadmin-down-dir"></span></span>';
			break;

			case 'tags':
				var tags = param['value'].split(HEALTHANDCARE_GLOBALS['shortcodes_delimiter']);
				if (tags.length > 0) {
					for (i=0; i<tags.length; i++) {
						if (healthandcare_empty(tags[i])) continue;
						output += '<span class="healthandcare_options_tag iconadmin-cancel">' + tags[i] + '</span>';
					}
				}
				output += '<input class="healthandcare_options_input_tags"'
					+ ' type="text"'
					+ ' value=""'
					+ ' />'
					+ '<input name="' + id + '"'
						+ ' type="hidden"'
						+ ' value="' + healthandcare_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
						+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />';
			break;
		
			case "checkbox": 
				output += '<input type="checkbox" class="healthandcare_options_input healthandcare_options_input_checkbox"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' value="true"' 
					+ (param['value'] == 'true' ? ' checked="checked"' : '') 
					+ (!healthandcare_empty(param['disabled']) ? ' readonly="readonly"' : '')
					+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
					+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
					+ '<label for="' + id + '" class="' + (!healthandcare_empty(param['disabled']) ? 'healthandcare_options_state_disabled' : '') + (param['value']=='true' ? ' healthandcare_options_state_checked' : '') + '"><span class="healthandcare_options_input_checkbox_image iconadmin-check"></span>' + (!healthandcare_empty(param['label']) ? param['label'] : param['title']) + '</label>';
			break;
		
			case "radio":
				for (key in param['options']) { 
					output += '<span class="healthandcare_options_radioitem"><input class="healthandcare_options_input healthandcare_options_input_radio" type="radio"'
						+ ' name="' + id + '"'
						+ ' value="' + healthandcare_shortcodes_prepare_value(key) + '"'
						+ ' data-value="' + healthandcare_shortcodes_prepare_value(key) + '"'
						+ (param['value'] == key ? ' checked="checked"' : '') 
						+ ' id="' + id + '_' + key + '"'
						+ ' />'
						+ '<label for="' + id + '_' + key + '"' + (param['value'] == key ? ' class="healthandcare_options_state_checked"' : '') + '><span class="healthandcare_options_input_radio_image iconadmin-circle-empty' + (param['value'] == key ? ' iconadmin-dot-circled' : '') + '"></span>' + param['options'][key] + '</label></span>';
				}
				output += '<input type="hidden"'
						+ ' value="' + healthandcare_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
						+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />';

			break;
		
			case "switch":
				opt = [];
				i = 0;
				for (key in param['options']) {
					opt[i++] = {'key': key, 'title': param['options'][key]};
					if (i==2) break;
				}
				output += '<input name="' + id + '"'
					+ ' type="hidden"'
					+ ' value="' + healthandcare_shortcodes_prepare_value(healthandcare_empty(param['value']) ? opt[0]['key'] : param['value']) + '"'
					+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
					+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
					+ '<span class="healthandcare_options_switch' + (param['value']==opt[1]['key'] ? ' healthandcare_options_state_off' : '') + '"><span class="healthandcare_options_switch_inner iconadmin-circle"><span class="healthandcare_options_switch_val1" data-value="' + opt[0]['key'] + '">' + opt[0]['title'] + '</span><span class="healthandcare_options_switch_val2" data-value="' + opt[1]['key'] + '">' + opt[1]['title'] + '</span></span></span>';
			break;

			case 'media':
				output += '<input class="healthandcare_options_input healthandcare_options_input_text healthandcare_options_input_media"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' type="text"'
					+ ' value="' + healthandcare_shortcodes_prepare_value(param['value']) + '"'
					+ (!healthandcare_isset(param['readonly']) || param['readonly'] ? ' readonly="readonly"' : '')
					+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
					+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
					+ before 
					+ after;
				if (!healthandcare_empty(param['value'])) {
					var fname = healthandcare_get_file_name(param['value']);
					var fext  = healthandcare_get_file_ext(param['value']);
					output += '<a class="healthandcare_options_image_preview" rel="prettyPhoto" target="_blank" href="' + param['value'] + '">' + (fext!='' && healthandcare_in_list('jpg,png,gif', fext, ',') ? '<img src="'+param['value']+'" alt="" />' : '<span>'+fname+'</span>') + '</a>';
				}
			break;
		
			case 'button':
				rez = healthandcare_shortcodes_action_button(param, 'button');
				output += rez[0];
			break;

			case 'range':
				output += '<div class="healthandcare_options_input_range" data-step="'+(!healthandcare_empty(param['step']) ? param['step'] : 1) + '">'
					+ '<span class="healthandcare_options_range_scale"><span class="healthandcare_options_range_scale_filled"></span></span>';
				if (param['value'].toString().indexOf(HEALTHANDCARE_GLOBALS['shortcodes_delimiter']) == -1)
					param['value'] = Math.min(param['max'], Math.max(param['min'], param['value']));
				var sliders = param['value'].toString().split(HEALTHANDCARE_GLOBALS['shortcodes_delimiter']);
				for (i=0; i<sliders.length; i++) {
					output += '<span class="healthandcare_options_range_slider"><span class="healthandcare_options_range_slider_value">' + sliders[i] + '</span><span class="healthandcare_options_range_slider_button"></span></span>';
				}
				output += '<span class="healthandcare_options_range_min">' + param['min'] + '</span><span class="healthandcare_options_range_max">' + param['max'] + '</span>'
					+ '<input name="' + id + '"'
						+ ' type="hidden"'
						+ ' value="' + healthandcare_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
						+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />'
					+ '</div>';			
			break;
		
			case "checklist":
				for (key in param['options']) { 
					output += '<span class="healthandcare_options_listitem'
						+ (healthandcare_in_list(param['value'], key, HEALTHANDCARE_GLOBALS['shortcodes_delimiter']) ? ' healthandcare_options_state_checked' : '') + '"'
						+ ' data-value="' + healthandcare_shortcodes_prepare_value(key) + '"'
						+ '>'
						+ param['options'][key]
						+ '</span>';
				}
				output += '<input name="' + id + '"'
					+ ' type="hidden"'
					+ ' value="' + healthandcare_shortcodes_prepare_value(param['value']) + '"'
					+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
					+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />';
			break;
		
			case 'fonts':
				for (key in param['options']) {
					param['options'][key] = key;
				}
			case 'list':
			case 'select':
				if (!healthandcare_isset(param['options']) && !healthandcare_empty(param['from']) && !healthandcare_empty(param['to'])) {
					param['options'] = [];
					for (i = param['from']; i <= param['to']; i+=(!healthandcare_empty(param['step']) ? param['step'] : 1)) {
						param['options'][i] = i;
					}
				}
				rez = healthandcare_shortcodes_menu_list(param);
				if (healthandcare_empty(param['style']) || param['style']=='select') {
					output += '<input class="healthandcare_options_input healthandcare_options_input_select" type="text" value="' + healthandcare_shortcodes_prepare_value(rez[1]) + '"'
						+ ' readonly="readonly"'
						//+ (!healthandcare_empty(param['mask']) ? ' data-mask="'+param['mask']+'"' : '')
						+ ' />'
						+ '<span class="healthandcare_options_field_after healthandcare_options_with_action iconadmin-down-open" onchange="healthandcare_options_action_show_menu(this);return false;"></span>';
				}
				output += rez[0]
					+ '<input name="' + id + '"'
						+ ' type="hidden"'
						+ ' value="' + healthandcare_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
						+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />';
			break;

			case 'images':
				rez = healthandcare_shortcodes_menu_list(param);
				if (healthandcare_empty(param['style']) || param['style']=='select') {
					output += '<div class="healthandcare_options_caption_image iconadmin-down-open">'
						//+'<img src="' + rez[1] + '" alt="" />'
						+'<span style="background-image: url(' + rez[1] + ')"></span>'
						+'</div>';
				}
				output += rez[0]
					+ '<input name="' + id + '"'
						+ ' type="hidden"'
						+ ' value="' + healthandcare_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
						+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />';
			break;
		
			case 'icons':
				rez = healthandcare_shortcodes_menu_list(param);
				if (healthandcare_empty(param['style']) || param['style']=='select') {
					output += '<div class="healthandcare_options_caption_icon iconadmin-down-open"><span class="' + rez[1] + '"></span></div>';
				}
				output += rez[0]
					+ '<input name="' + id + '"'
						+ ' type="hidden"'
						+ ' value="' + healthandcare_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
						+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />';
			break;

			case 'socials':
				if (!healthandcare_is_object(param['value'])) param['value'] = {'url': '', 'icon': ''};
				rez = healthandcare_shortcodes_menu_list(param);
				if (healthandcare_empty(param['style']) || param['style']=='icons') {
					rez2 = healthandcare_shortcodes_action_button({
						'action': healthandcare_empty(param['style']) || param['style']=='icons' ? 'select_icon' : '',
						'icon': (healthandcare_empty(param['style']) || param['style']=='icons') && !healthandcare_empty(param['value']['icon']) ? param['value']['icon'] : 'iconadmin-users'
						}, 'after');
				} else
					rez2 = ['', ''];
				output += '<input class="healthandcare_options_input healthandcare_options_input_text healthandcare_options_input_socials'
					+ (!healthandcare_empty(param['mask']) ? ' healthandcare_options_input_masked' : '') + '"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' type="text" value="' + healthandcare_shortcodes_prepare_value(param['value']['url']) + '"'
					+ (!healthandcare_empty(param['mask']) ? ' data-mask="'+param['mask']+'"' : '')
					+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
					+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
					+ rez2[0];
				if (!healthandcare_empty(param['style']) && param['style']=='images') {
					output += '<div class="healthandcare_options_caption_image iconadmin-down-open">'
						//+'<img src="' + rez[1] + '" alt="" />'
						+'<span style="background-image: url(' + rez[1] + ')"></span>'
						+'</div>';
				}
				output += rez[0]
					+ '<input name="' + id + '_icon' + '" type="hidden" value="' + healthandcare_shortcodes_prepare_value(param['value']['icon']) + '" />';
			break;

			case "color":
				var cp_style = healthandcare_isset(param['style']) ? param['style'] : HEALTHANDCARE_GLOBALS['shortcodes_cp'];
				output += '<input class="healthandcare_options_input healthandcare_options_input_color healthandcare_options_input_color_'+cp_style +'"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' data-param="' + healthandcare_shortcodes_prepare_value(param_num) + '"'
					+ ' type="text"'
					+ ' value="' + healthandcare_shortcodes_prepare_value(param['value']) + '"'
					+ (!healthandcare_empty(param['action']) ? ' onchange="healthandcare_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
					+ before;
				if (cp_style=='custom')
					output += '<span class="healthandcare_options_input_colorpicker iColorPicker"></span>';
				else if (cp_style=='tiny')
					output += after;
			break;   
	
			}

			if (param['type'] != 'hidden') {
				output += '</div>';
				if (!healthandcare_empty(param['desc']))
					output += '<div class="healthandcare_options_desc">' + param['desc'] + '</div>' + "\n";
				output += '</div>' + "\n";
			}

		}

		output += '</div>';
	}

	
	return output;
}



// Return menu items list (menu, images or icons)
function healthandcare_shortcodes_menu_list(field) {
	"use strict";
	if (field['type'] == 'socials') field['value'] = field['value']['icon'];
	var list = '<div class="healthandcare_options_input_menu ' + (healthandcare_empty(field['style']) ? '' : ' healthandcare_options_input_menu_' + field['style']) + '">';
	var caption = '';
	for (var key in field['options']) {
		var value = field['options'][key];
		if (healthandcare_in_array(field['type'], ['list', 'icons', 'socials'])) key = value;
		var selected = '';
		if (healthandcare_in_list(field['value'], key, HEALTHANDCARE_GLOBALS['shortcodes_delimiter'])) {
			caption = value;
			selected = ' healthandcare_options_state_checked';
		}
		list += '<span class="healthandcare_options_menuitem'
			+ selected 
			+ '" data-value="' + healthandcare_shortcodes_prepare_value(key) + '"'
			+ '>';
		if (healthandcare_in_array(field['type'], ['list', 'select', 'fonts']))
			list += value;
		else if (field['type'] == 'icons' || (field['type'] == 'socials' && field['style'] == 'icons'))
			list += '<span class="' + value + '"></span>';
		else if (field['type'] == 'images' || (field['type'] == 'socials' && field['style'] == 'images'))
			//list += '<img src="' + value + '" data-icon="' + key + '" alt="" class="healthandcare_options_input_image" />';
			list += '<span style="background-image:url(' + value + ')" data-src="' + value + '" data-icon="' + key + '" class="healthandcare_options_input_image"></span>';
		list += '</span>';
	}
	list += '</div>';
	return [list, caption];
}



// Return action button
function healthandcare_shortcodes_action_button(data, type) {
	"use strict";
	var class_name = ' healthandcare_options_button_' + type + (healthandcare_empty(data['title']) ? ' healthandcare_options_button_'+type+'_small' : '');
	var output = '<span class="' 
				+ (type == 'button' ? 'healthandcare_options_input_button'  : 'healthandcare_options_field_'+type)
				+ (!healthandcare_empty(data['action']) ? ' healthandcare_options_with_action' : '')
				+ (!healthandcare_empty(data['icon']) ? ' '+data['icon'] : '')
				+ '"'
				+ (!healthandcare_empty(data['icon']) && !healthandcare_empty(data['title']) ? ' title="'+healthandcare_shortcodes_prepare_value(data['title'])+'"' : '')
				+ (!healthandcare_empty(data['action']) ? ' onclick="healthandcare_options_action_'+data['action']+'(this);return false;"' : '')
				+ (!healthandcare_empty(data['type']) ? ' data-type="'+data['type']+'"' : '')
				+ (!healthandcare_empty(data['multiple']) ? ' data-multiple="'+data['multiple']+'"' : '')
				+ (!healthandcare_empty(data['sizes']) ? ' data-sizes="'+data['sizes']+'"' : '')
				+ (!healthandcare_empty(data['linked_field']) ? ' data-linked-field="'+data['linked_field']+'"' : '')
				+ (!healthandcare_empty(data['captions']) && !healthandcare_empty(data['captions']['choose']) ? ' data-caption-choose="'+healthandcare_shortcodes_prepare_value(data['captions']['choose'])+'"' : '')
				+ (!healthandcare_empty(data['captions']) && !healthandcare_empty(data['captions']['update']) ? ' data-caption-update="'+healthandcare_shortcodes_prepare_value(data['captions']['update'])+'"' : '')
				+ '>'
				+ (type == 'button' || (healthandcare_empty(data['icon']) && !healthandcare_empty(data['title'])) ? data['title'] : '')
				+ '</span>';
	return [output, class_name];
}

// Prepare string to insert as parameter's value
function healthandcare_shortcodes_prepare_value(val) {
	return typeof val == 'string' ? val.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#039;').replace(/</g, '&lt;').replace(/>/g, '&gt;') : val;
}
