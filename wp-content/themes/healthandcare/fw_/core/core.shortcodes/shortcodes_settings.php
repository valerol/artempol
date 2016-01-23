<?php

// Check if shortcodes settings are now used
if ( !function_exists( 'healthandcare_shortcodes_is_used' ) ) {
	function healthandcare_shortcodes_is_used() {
		return healthandcare_options_is_used() 															// All modes when Theme Options are used
			|| (is_admin() && isset($_POST['action']) 
					&& in_array($_POST['action'], array('vc_edit_form', 'wpb_show_edit_form')))		// AJAX query when save post/page
			|| healthandcare_vc_is_frontend();															// VC Frontend editor mode
	}
}

// Width and height params
if ( !function_exists( 'healthandcare_shortcodes_width' ) ) {
	function healthandcare_shortcodes_width($w="") {
		return array(
			"title" => esc_html__("Width", "healthandcare"),
			"divider" => true,
			"value" => $w,
			"type" => "text"
		);
	}
}
if ( !function_exists( 'healthandcare_shortcodes_height' ) ) {
	function healthandcare_shortcodes_height($h='') {
		return array(
			"title" => esc_html__("Height", "healthandcare"),
			"desc" => esc_html__("Width (in pixels or percent) and height (only in pixels) of element", "healthandcare"),
			"value" => $h,
			"type" => "text"
		);
	}
}

/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'healthandcare_shortcodes_settings_theme_setup' ) ) {
//	if ( healthandcare_vc_is_frontend() )
	if ( (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') || (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline') )
		add_action( 'healthandcare_action_before_init_theme', 'healthandcare_shortcodes_settings_theme_setup', 20 );
	else
		add_action( 'healthandcare_action_after_init_theme', 'healthandcare_shortcodes_settings_theme_setup' );
	function healthandcare_shortcodes_settings_theme_setup() {
		if (healthandcare_shortcodes_is_used()) {
			global $HEALTHANDCARE_GLOBALS;

			// Prepare arrays 
			$HEALTHANDCARE_GLOBALS['sc_params'] = array(
			
				// Current element id
				'id' => array(
					"title" => esc_html__("Element ID", "healthandcare"),
					"desc" => esc_html__("ID for current element", "healthandcare"),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
			
				// Current element class
				'class' => array(
					"title" => esc_html__("Element CSS class", "healthandcare"),
					"desc" => esc_html__("CSS class for current element (optional)", "healthandcare"),
					"value" => "",
					"type" => "text"
				),
			
				// Current element style
				'css' => array(
					"title" => esc_html__("CSS styles", "healthandcare"),
					"desc" => esc_html__("Any additional CSS rules (if need)", "healthandcare"),
					"value" => "",
					"type" => "text"
				),
			
				// Margins params
				'top' => array(
					"title" => esc_html__("Top margin", "healthandcare"),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
			
				'bottom' => array(
					"title" => esc_html__("Bottom margin", "healthandcare"),
					"value" => "",
					"type" => "text"
				),
			
				'left' => array(
					"title" => esc_html__("Left margin", "healthandcare"),
					"value" => "",
					"type" => "text"
				),
			
				'right' => array(
					"title" => esc_html__("Right margin", "healthandcare"),
					"desc" => esc_html__("Margins around list (in pixels).", "healthandcare"),
					"value" => "",
					"type" => "text"
				),
			
				// Switcher choises
				'list_styles' => array(
					'ul'	=> esc_html__('Unordered', 'healthandcare'),
					'ol'	=> esc_html__('Ordered', 'healthandcare'),
					'iconed'=> esc_html__('Iconed', 'healthandcare')
				),
				'yes_no'	=> healthandcare_get_list_yesno(),
				'on_off'	=> healthandcare_get_list_onoff(),
				'dir' 		=> healthandcare_get_list_directions(),
				'align'		=> healthandcare_get_list_alignments(),
				'float'		=> healthandcare_get_list_floats(),
				'show_hide'	=> healthandcare_get_list_showhide(),
				'sorting' 	=> healthandcare_get_list_sortings(),
				'ordering' 	=> healthandcare_get_list_orderings(),
				'shapes'	=> healthandcare_get_list_shapes(),
				'sizes'		=> healthandcare_get_list_sizes(),
				'sliders'	=> healthandcare_get_list_sliders(),
				'categories'=> healthandcare_get_list_categories(),
				'columns'	=> healthandcare_get_list_columns(),
				'images'	=> array_merge(array('none'=>"none"), healthandcare_get_list_files("images/icons", "png")),
				'icons'		=> array_merge(array("inherit", "none"), healthandcare_get_list_icons()),
				'locations'	=> healthandcare_get_list_dedicated_locations(),
				'filters'	=> healthandcare_get_list_portfolio_filters(),
				'formats'	=> healthandcare_get_list_post_formats_filters(),
				'hovers'	=> healthandcare_get_list_hovers(),
				'hovers_dir'=> healthandcare_get_list_hovers_directions(),
				'schemes'	=> healthandcare_get_list_color_schemes(true),
				'animations'=> healthandcare_get_list_animations_in(),
				'blogger_styles'	=> healthandcare_get_list_templates_blogger(),
				'posts_types'		=> healthandcare_get_list_posts_types(),
				'button_styles'		=> healthandcare_get_list_button_styles(),
				'googlemap_styles'	=> healthandcare_get_list_googlemap_styles(),
				'field_types'		=> healthandcare_get_list_field_types(),
				'label_positions'	=> healthandcare_get_list_label_positions()
			);

			$HEALTHANDCARE_GLOBALS['sc_params']['animation'] = array(
				"title" => esc_html__("Animation",  'healthandcare'),
				"desc" => esc_html__('Select animation while object enter in the visible area of page',  'healthandcare'),
				"value" => "none",
				"type" => "select",
				"options" => $HEALTHANDCARE_GLOBALS['sc_params']['animations']
			);
	
			// Shortcodes list
			//------------------------------------------------------------------
			$HEALTHANDCARE_GLOBALS['shortcodes'] = array(
			
				// Accordion
				"trx_accordion" => array(
					"title" => esc_html__("Accordion", "healthandcare"),
					"desc" => esc_html__("Accordion items", "healthandcare"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => esc_html__("Accordion style", "healthandcare"),
							"desc" => esc_html__("Select style for display accordion", "healthandcare"),
							"value" => 1,
							"options" => healthandcare_get_list_styles(1, 2),
							"type" => "radio"
						),
						"counter" => array(
							"title" => esc_html__("Counter", "healthandcare"),
							"desc" => esc_html__("Display counter before each accordion title", "healthandcare"),
							"value" => "off",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['on_off']
						),
						"initial" => array(
							"title" => esc_html__("Initially opened item", "healthandcare"),
							"desc" => esc_html__("Number of initially opened item", "healthandcare"),
							"value" => 1,
							"min" => 0,
							"type" => "spinner"
						),
						"icon_closed" => array(
							"title" => esc_html__("Icon while closed",  'healthandcare'),
							"desc" => esc_html__('Select icon for the closed accordion item from Fontello icons set',  'healthandcare'),
							"value" => "",
							"type" => "icons",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
						),
						"icon_opened" => array(
							"title" => esc_html__("Icon while opened",  'healthandcare'),
							"desc" => esc_html__('Select icon for the opened accordion item from Fontello icons set',  'healthandcare'),
							"value" => "",
							"type" => "icons",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
						),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_accordion_item",
						"title" => esc_html__("Item", "healthandcare"),
						"desc" => esc_html__("Accordion item", "healthandcare"),
						"container" => true,
						"params" => array(
							"title" => array(
								"title" => esc_html__("Accordion item title", "healthandcare"),
								"desc" => esc_html__("Title for current accordion item", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
                            "icon_before_title" => array(
                                "title" => esc_html__("Icon before title",  'healthandcare'),
                                "desc" => esc_html__('Select icon for before title accordion item from Fontello icons set',  'healthandcare'),
                                "value" => "",
                                "type" => "icons",
                                "options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
                            ),
							"icon_closed" => array(
								"title" => esc_html__("Icon while closed",  'healthandcare'),
								"desc" => esc_html__('Select icon for the closed accordion item from Fontello icons set',  'healthandcare'),
								"value" => "",
								"type" => "icons",
								"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
							),
							"icon_opened" => array(
								"title" => esc_html__("Icon while opened",  'healthandcare'),
								"desc" => esc_html__('Select icon for the opened accordion item from Fontello icons set',  'healthandcare'),
								"value" => "",
								"type" => "icons",
								"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
							),
							"_content_" => array(
								"title" => esc_html__("Accordion item content", "healthandcare"),
								"desc" => esc_html__("Current accordion item content", "healthandcare"),
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
							"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
							"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Anchor
				"trx_anchor" => array(
					"title" => esc_html__("Anchor", "healthandcare"),
					"desc" => esc_html__("Insert anchor for the TOC (table of content)", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"icon" => array(
							"title" => esc_html__("Anchor's icon",  'healthandcare'),
							"desc" => esc_html__('Select icon for the anchor from Fontello icons set',  'healthandcare'),
							"value" => "",
							"type" => "icons",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
						),
						"title" => array(
							"title" => esc_html__("Short title", "healthandcare"),
							"desc" => esc_html__("Short title of the anchor (for the table of content)", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => esc_html__("Long description", "healthandcare"),
							"desc" => __("Description for the popup (then hover on the icon). You can use:<br>'{{' and '}}' - to make the text italic,<br>'((' and '))' - to make the text bold,<br>'||' - to insert line break", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"url" => array(
							"title" => esc_html__("External URL", "healthandcare"),
							"desc" => esc_html__("External URL for this TOC item", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"separator" => array(
							"title" => esc_html__("Add separator", "healthandcare"),
							"desc" => esc_html__("Add separator under item in the TOC", "healthandcare"),
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id']
					)
				),
			
			
				// Audio
				"trx_audio" => array(
					"title" => esc_html__("Audio", "healthandcare"),
					"desc" => esc_html__("Insert audio player", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"url" => array(
							"title" => esc_html__("URL for audio file", "healthandcare"),
							"desc" => esc_html__("URL for audio file", "healthandcare"),
							"readonly" => false,
							"value" => "",
							"type" => "media",
							"before" => array(
								'title' => esc_html__('Choose audio', 'healthandcare'),
								'action' => 'media_upload',
								'type' => 'audio',
								'multiple' => false,
								'linked_field' => '',
								'captions' => array( 	
									'choose' => esc_html__('Choose audio file', 'healthandcare'),
									'update' => esc_html__('Select audio file', 'healthandcare')
								)
							),
							"after" => array(
								'icon' => 'icon-cancel',
								'action' => 'media_reset'
							)
						),
						"image" => array(
							"title" => esc_html__("Cover image", "healthandcare"),
							"desc" => esc_html__("Select or upload image or write URL from other site for audio cover", "healthandcare"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"title" => array(
							"title" => esc_html__("Title", "healthandcare"),
							"desc" => esc_html__("Title of the audio file", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"author" => array(
							"title" => esc_html__("Author", "healthandcare"),
							"desc" => esc_html__("Author of the audio file", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"controls" => array(
							"title" => esc_html__("Show controls", "healthandcare"),
							"desc" => esc_html__("Show controls in audio player", "healthandcare"),
							"divider" => true,
							"size" => "medium",
							"value" => "show",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['show_hide']
						),
						"autoplay" => array(
							"title" => esc_html__("Autoplay audio", "healthandcare"),
							"desc" => esc_html__("Autoplay audio on page load", "healthandcare"),
							"value" => "off",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['on_off']
						),
						"align" => array(
							"title" => esc_html__("Align", "healthandcare"),
							"desc" => esc_html__("Select block alignment", "healthandcare"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Block
				"trx_block" => array(
					"title" => esc_html__("Block container", "healthandcare"),
					"desc" => esc_html__("Container for any block ([section] analog - to enable nesting)", "healthandcare"),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"dedicated" => array(
							"title" => esc_html__("Dedicated", "healthandcare"),
							"desc" => esc_html__("Use this block as dedicated content - show it before post title on single page", "healthandcare"),
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"align" => array(
							"title" => esc_html__("Align", "healthandcare"),
							"desc" => esc_html__("Select block alignment", "healthandcare"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						),
						"columns" => array(
							"title" => esc_html__("Columns emulation", "healthandcare"),
							"desc" => esc_html__("Select width for columns emulation", "healthandcare"),
							"value" => "none",
							"type" => "checklist",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['columns']
						), 
						"pan" => array(
							"title" => esc_html__("Use pan effect", "healthandcare"),
							"desc" => esc_html__("Use pan effect to show section content", "healthandcare"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"scroll" => array(
							"title" => esc_html__("Use scroller", "healthandcare"),
							"desc" => esc_html__("Use scroller to show section content", "healthandcare"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"scroll_dir" => array(
							"title" => esc_html__("Scroll direction", "healthandcare"),
							"desc" => esc_html__("Scroll direction (if Use scroller = yes)", "healthandcare"),
							"dependency" => array(
								'scroll' => array('yes')
							),
							"value" => "horizontal",
							"type" => "switch",
							"size" => "big",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['dir']
						),
						"scroll_controls" => array(
							"title" => esc_html__("Scroll controls", "healthandcare"),
							"desc" => esc_html__("Show scroll controls (if Use scroller = yes)", "healthandcare"),
							"dependency" => array(
								'scroll' => array('yes')
							),
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"scheme" => array(
							"title" => esc_html__("Color scheme", "healthandcare"),
							"desc" => esc_html__("Select color scheme for this block", "healthandcare"),
							"value" => "",
							"type" => "checklist",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['schemes']
						),
						"color" => array(
							"title" => esc_html__("Fore color", "healthandcare"),
							"desc" => esc_html__("Any color for objects in this section", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"bg_color" => array(
							"title" => esc_html__("Background color", "healthandcare"),
							"desc" => esc_html__("Any background color for this section", "healthandcare"),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => esc_html__("Background image URL", "healthandcare"),
							"desc" => esc_html__("Select or upload image or write URL from other site for the background", "healthandcare"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_overlay" => array(
							"title" => esc_html__("Overlay", "healthandcare"),
							"desc" => esc_html__("Overlay color opacity (from 0.0 to 1.0)", "healthandcare"),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => esc_html__("Texture", "healthandcare"),
							"desc" => esc_html__("Predefined texture style from 1 to 11. 0 - without texture.", "healthandcare"),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"font_size" => array(
							"title" => esc_html__("Font size", "healthandcare"),
							"desc" => esc_html__("Font size of the text (default - in pixels, allows any CSS units of measure)", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"font_weight" => array(
							"title" => esc_html__("Font weight", "healthandcare"),
							"desc" => esc_html__("Font weight of the text", "healthandcare"),
							"value" => "",
							"type" => "select",
							"size" => "medium",
							"options" => array(
								'100' => esc_html__('Thin (100)', 'healthandcare'),
								'300' => esc_html__('Light (300)', 'healthandcare'),
								'400' => esc_html__('Normal (400)', 'healthandcare'),
								'700' => esc_html__('Bold (700)', 'healthandcare')
							)
						),
						"_content_" => array(
							"title" => esc_html__("Container content", "healthandcare"),
							"desc" => esc_html__("Content for section container", "healthandcare"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Blogger
				"trx_blogger" => array(
					"title" => esc_html__("Blogger", "healthandcare"),
					"desc" => esc_html__("Insert posts (pages) in many styles from desired categories or directly from ids", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"title" => array(
							"title" => esc_html__("Title", "healthandcare"),
							"desc" => esc_html__("Title for the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => esc_html__("Subtitle", "healthandcare"),
							"desc" => esc_html__("Subtitle for the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => esc_html__("Description", "healthandcare"),
							"desc" => esc_html__("Short description for the block", "healthandcare"),
							"value" => "",
							"type" => "textarea"
						),
						"style" => array(
							"title" => esc_html__("Posts output style", "healthandcare"),
							"desc" => esc_html__("Select desired style for posts output", "healthandcare"),
							"value" => "regular",
							"type" => "select",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['blogger_styles']
						),
						"filters" => array(
							"title" => esc_html__("Show filters", "healthandcare"),
							"desc" => esc_html__("Use post's tags or categories as filter buttons", "healthandcare"),
							"value" => "no",
							"dir" => "horizontal",
							"type" => "checklist",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['filters']
						),
						"hover" => array(
							"title" => esc_html__("Hover effect", "healthandcare"),
							"desc" => esc_html__("Select hover effect (only if style=Portfolio)", "healthandcare"),
							"dependency" => array(
								'style' => array('portfolio','grid','square','short','colored')
							),
							"value" => "",
							"type" => "select",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['hovers']
						),
						"hover_dir" => array(
							"title" => esc_html__("Hover direction", "healthandcare"),
							"desc" => esc_html__("Select hover direction (only if style=Portfolio and hover=Circle|Square)", "healthandcare"),
							"dependency" => array(
								'style' => array('portfolio','grid','square','short','colored'),
								'hover' => array('square','circle')
							),
							"value" => "left_to_right",
							"type" => "select",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['hovers_dir']
						),
						"dir" => array(
							"title" => esc_html__("Posts direction", "healthandcare"),
							"desc" => esc_html__("Display posts in horizontal or vertical direction", "healthandcare"),
							"value" => "horizontal",
							"type" => "switch",
							"size" => "big",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['dir']
						),
						"post_type" => array(
							"title" => esc_html__("Post type", "healthandcare"),
							"desc" => esc_html__("Select post type to show", "healthandcare"),
							"value" => "post",
							"type" => "select",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['posts_types']
						),
						"ids" => array(
							"title" => esc_html__("Post IDs list", "healthandcare"),
							"desc" => esc_html__("Comma separated list of posts ID. If set - parameters above are ignored!", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"cat" => array(
							"title" => esc_html__("Categories list", "healthandcare"),
							"desc" => esc_html__("Select the desired categories. If not selected - show posts from any category or from IDs list", "healthandcare"),
							"dependency" => array(
								'ids' => array('is_empty'),
								'post_type' => array('refresh')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => healthandcare_array_merge(array(0 => esc_html__('- Select category -', 'healthandcare')), $HEALTHANDCARE_GLOBALS['sc_params']['categories'])
						),
						"count" => array(
							"title" => esc_html__("Total posts to show", "healthandcare"),
							"desc" => esc_html__("How many posts will be displayed? If used IDs - this parameter ignored.", "healthandcare"),
							"dependency" => array(
								'ids' => array('is_empty')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => esc_html__("Columns number", "healthandcare"),
							"desc" => esc_html__("How many columns used to show posts? If empty or 0 - equal to posts number", "healthandcare"),
							"dependency" => array(
								'dir' => array('horizontal')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => esc_html__("Offset before select posts", "healthandcare"),
							"desc" => esc_html__("Skip posts before select next part.", "healthandcare"),
							"dependency" => array(
								'ids' => array('is_empty')
							),
							"value" => 0,
							"min" => 0,
							"max" => 100,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Post order by", "healthandcare"),
							"desc" => esc_html__("Select desired posts sorting method", "healthandcare"),
							"value" => "date",
							"type" => "select",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['sorting']
						),
						"order" => array(
							"title" => esc_html__("Post order", "healthandcare"),
							"desc" => esc_html__("Select desired posts order", "healthandcare"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['ordering']
						),
						"only" => array(
							"title" => esc_html__("Select posts only", "healthandcare"),
							"desc" => esc_html__("Select posts only with reviews, videos, audios, thumbs or galleries", "healthandcare"),
							"value" => "no",
							"type" => "select",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['formats']
						),
						"scroll" => array(
							"title" => esc_html__("Use scroller", "healthandcare"),
							"desc" => esc_html__("Use scroller to show all posts", "healthandcare"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"controls" => array(
							"title" => esc_html__("Show slider controls", "healthandcare"),
							"desc" => esc_html__("Show arrows to control scroll slider", "healthandcare"),
							"dependency" => array(
								'scroll' => array('yes')
							),
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"location" => array(
							"title" => esc_html__("Dedicated content location", "healthandcare"),
							"desc" => esc_html__("Select position for dedicated content (only for style=excerpt)", "healthandcare"),
							"divider" => true,
							"dependency" => array(
								'style' => array('excerpt')
							),
							"value" => "default",
							"type" => "select",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['locations']
						),
						"rating" => array(
							"title" => esc_html__("Show rating stars", "healthandcare"),
							"desc" => esc_html__("Show rating stars under post's header", "healthandcare"),
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"info" => array(
							"title" => esc_html__("Show post info block", "healthandcare"),
							"desc" => esc_html__("Show post info block (author, date, tags, etc.)", "healthandcare"),
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"links" => array(
							"title" => esc_html__("Allow links on the post", "healthandcare"),
							"desc" => esc_html__("Allow links on the post from each blogger item", "healthandcare"),
							"value" => "yes",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"descr" => array(
							"title" => esc_html__("Description length", "healthandcare"),
							"desc" => esc_html__("How many characters are displayed from post excerpt? If 0 - don't show description", "healthandcare"),
							"value" => 0,
							"min" => 0,
							"step" => 10,
							"type" => "spinner"
						),
						"readmore" => array(
							"title" => esc_html__("More link text", "healthandcare"),
							"desc" => esc_html__("Read more link text. If empty - show 'More', else - used as link text", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"link" => array(
							"title" => esc_html__("Button URL", "healthandcare"),
							"desc" => esc_html__("Link URL for the button at the bottom of the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"link_caption" => array(
							"title" => esc_html__("Button caption", "healthandcare"),
							"desc" => esc_html__("Caption for the button at the bottom of the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Br
				"trx_br" => array(
					"title" => esc_html__("Break", "healthandcare"),
					"desc" => esc_html__("Line break with clear floating (if need)", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"clear" => 	array(
							"title" => esc_html__("Clear floating", "healthandcare"),
							"desc" => esc_html__("Clear floating (if need)", "healthandcare"),
							"value" => "",
							"type" => "checklist",
							"options" => array(
								'none' => esc_html__('None', 'healthandcare'),
								'left' => esc_html__('Left', 'healthandcare'),
								'right' => esc_html__('Right', 'healthandcare'),
								'both' => esc_html__('Both', 'healthandcare')
							)
						)
					)
				),
			
			
			
			
				// Button
				"trx_button" => array(
					"title" => esc_html__("Button", "healthandcare"),
					"desc" => esc_html__("Button with link", "healthandcare"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"_content_" => array(
							"title" => esc_html__("Caption", "healthandcare"),
							"desc" => esc_html__("Button caption", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"type" => array(
							"title" => esc_html__("Button's shape", "healthandcare"),
							"desc" => esc_html__("Select button's shape", "healthandcare"),
							"value" => "square",
							"size" => "medium",
							"options" => array(
								'square' => esc_html__('Square', 'healthandcare'),
								'round' => esc_html__('Round', 'healthandcare')
							),
							"type" => "switch"
						), 
						"style" => array(
							"title" => esc_html__("Button's style", "healthandcare"),
							"desc" => esc_html__("Select button's style", "healthandcare"),
							"value" => "default",
							"dir" => "horizontal",
							"options" => array(
								'filled' => esc_html__('Filled', 'healthandcare'),
								'border' => esc_html__('Border', 'healthandcare')
							),
							"type" => "checklist"
						), 
						"size" => array(
							"title" => esc_html__("Button's size", "healthandcare"),
							"desc" => esc_html__("Select button's size", "healthandcare"),
							"value" => "small",
							"dir" => "horizontal",
							"options" => array(
								'small' => esc_html__('Small', 'healthandcare'),
								'medium' => esc_html__('Medium', 'healthandcare'),
								'large' => esc_html__('Large', 'healthandcare')
							),
							"type" => "checklist"
						), 
						"icon" => array(
							"title" => esc_html__("Button's icon",  'healthandcare'),
							"desc" => esc_html__('Select icon for the title from Fontello icons set',  'healthandcare'),
							"value" => "icon-right-2",
							"type" => "icons",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
						),
						"bg_style" => array(
							"title" => esc_html__("Button's color scheme", "healthandcare"),
							"desc" => esc_html__("Select button's color scheme", "healthandcare"),
							"value" => "custom",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['button_styles']
						), 
						"color" => array(
							"title" => esc_html__("Button's text color", "healthandcare"),
							"desc" => esc_html__("Any color for button's caption", "healthandcare"),
							"std" => "",
							"value" => "",
							"type" => "color"
						),
						"bg_color" => array(
							"title" => esc_html__("Button's backcolor", "healthandcare"),
							"desc" => esc_html__("Any color for button's background", "healthandcare"),
							"value" => "",
							"type" => "color"
						),
						"align" => array(
							"title" => esc_html__("Button's alignment", "healthandcare"),
							"desc" => esc_html__("Align button to left, center or right", "healthandcare"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						), 
						"link" => array(
							"title" => esc_html__("Link URL", "healthandcare"),
							"desc" => esc_html__("URL for link on button click", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"target" => array(
							"title" => esc_html__("Link target", "healthandcare"),
							"desc" => esc_html__("Target for link on button click", "healthandcare"),
							"dependency" => array(
								'link' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"popup" => array(
							"title" => esc_html__("Open link in popup", "healthandcare"),
							"desc" => esc_html__("Open link target in popup window", "healthandcare"),
							"dependency" => array(
								'link' => array('not_empty')
							),
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						), 
						"rel" => array(
							"title" => esc_html__("Rel attribute", "healthandcare"),
							"desc" => esc_html__("Rel attribute for button's link (if need)", "healthandcare"),
							"dependency" => array(
								'link' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),

				// Call to Action block
				"trx_call_to_action" => array(
					"title" => esc_html__("Call to action", "healthandcare"),
					"desc" => esc_html__("Insert call to action block in your page (post)", "healthandcare"),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"title" => array(
							"title" => esc_html__("Title", "healthandcare"),
							"desc" => esc_html__("Title for the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => esc_html__("Subtitle", "healthandcare"),
							"desc" => esc_html__("Subtitle for the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => esc_html__("Description", "healthandcare"),
							"desc" => esc_html__("Short description for the block", "healthandcare"),
							"value" => "",
							"type" => "textarea"
						),
						"style" => array(
							"title" => esc_html__("Style", "healthandcare"),
							"desc" => esc_html__("Select style to display block", "healthandcare"),
							"value" => "1",
							"type" => "checklist",
							"options" => healthandcare_get_list_styles(1, 2)
						),
						"align" => array(
							"title" => esc_html__("Alignment", "healthandcare"),
							"desc" => esc_html__("Alignment elements in the block", "healthandcare"),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						),
						"accent" => array(
							"title" => esc_html__("Accented", "healthandcare"),
							"desc" => esc_html__("Fill entire block with Accent1 color from current color scheme", "healthandcare"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"custom" => array(
							"title" => esc_html__("Custom", "healthandcare"),
							"desc" => esc_html__("Allow get featured image or video from inner shortcodes (custom) or get it from shortcode parameters below", "healthandcare"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"image" => array(
							"title" => esc_html__("Image", "healthandcare"),
							"desc" => esc_html__("Select or upload image or write URL from other site to include image into this block", "healthandcare"),
							"divider" => true,
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"video" => array(
							"title" => esc_html__("URL for video file", "healthandcare"),
							"desc" => esc_html__("Select video from media library or paste URL for video file from other site to include video into this block", "healthandcare"),
							"readonly" => false,
							"value" => "",
							"type" => "media",
							"before" => array(
								'title' => esc_html__('Choose video', 'healthandcare'),
								'action' => 'media_upload',
								'type' => 'video',
								'multiple' => false,
								'linked_field' => '',
								'captions' => array( 	
									'choose' => esc_html__('Choose video file', 'healthandcare'),
									'update' => esc_html__('Select video file', 'healthandcare')
								)
							),
							"after" => array(
								'icon' => 'icon-cancel',
								'action' => 'media_reset'
							)
						),
						"link" => array(
							"title" => esc_html__("Button URL", "healthandcare"),
							"desc" => esc_html__("Link URL for the button at the bottom of the block", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"link_caption" => array(
							"title" => esc_html__("Button caption", "healthandcare"),
							"desc" => esc_html__("Caption for the button at the bottom of the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"link2" => array(
							"title" => esc_html__("Button 2 URL", "healthandcare"),
							"desc" => esc_html__("Link URL for the second button at the bottom of the block", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"link2_caption" => array(
							"title" => esc_html__("Button 2 caption", "healthandcare"),
							"desc" => esc_html__("Caption for the second button at the bottom of the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
				// Chat
				"trx_chat" => array(
					"title" => esc_html__("Chat", "healthandcare"),
					"desc" => esc_html__("Chat message", "healthandcare"),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"title" => array(
							"title" => esc_html__("Item title", "healthandcare"),
							"desc" => esc_html__("Chat item title", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"photo" => array(
							"title" => esc_html__("Item photo", "healthandcare"),
							"desc" => esc_html__("Select or upload image or write URL from other site for the item photo (avatar)", "healthandcare"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"link" => array(
							"title" => esc_html__("Item link", "healthandcare"),
							"desc" => esc_html__("Chat item link", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"_content_" => array(
							"title" => esc_html__("Chat item content", "healthandcare"),
							"desc" => esc_html__("Current chat item content", "healthandcare"),
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
				// Columns
				"trx_columns" => array(
					"title" => esc_html__("Columns", "healthandcare"),
					"desc" => esc_html__("Insert up to 5 columns in your page (post)", "healthandcare"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"fluid" => array(
							"title" => esc_html__("Fluid columns", "healthandcare"),
							"desc" => esc_html__("To squeeze the columns when reducing the size of the window (fluid=yes) or to rebuild them (fluid=no)", "healthandcare"),
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						), 
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_column_item",
						"title" => esc_html__("Column", "healthandcare"),
						"desc" => esc_html__("Column item", "healthandcare"),
						"container" => true,
						"params" => array(
							"span" => array(
								"title" => esc_html__("Merge columns", "healthandcare"),
								"desc" => esc_html__("Count merged columns from current", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"align" => array(
								"title" => esc_html__("Alignment", "healthandcare"),
								"desc" => esc_html__("Alignment text in the column", "healthandcare"),
								"value" => "",
								"type" => "checklist",
								"dir" => "horizontal",
								"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
							),
							"color" => array(
								"title" => esc_html__("Fore color", "healthandcare"),
								"desc" => esc_html__("Any color for objects in this column", "healthandcare"),
								"value" => "",
								"type" => "color"
							),
							"bg_color" => array(
								"title" => esc_html__("Background color", "healthandcare"),
								"desc" => esc_html__("Any background color for this column", "healthandcare"),
								"value" => "",
								"type" => "color"
							),
							"bg_image" => array(
								"title" => esc_html__("URL for background image file", "healthandcare"),
								"desc" => esc_html__("Select or upload image or write URL from other site for the background", "healthandcare"),
								"readonly" => false,
								"value" => "",
								"type" => "media"
							),
							"_content_" => array(
								"title" => esc_html__("Column item content", "healthandcare"),
								"desc" => esc_html__("Current column item content", "healthandcare"),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
							"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
							"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
							"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Contact form
				"trx_contact_form" => array(
					"title" => esc_html__("Contact form", "healthandcare"),
					"desc" => esc_html__("Insert contact form", "healthandcare"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"title" => array(
							"title" => esc_html__("Title", "healthandcare"),
							"desc" => esc_html__("Title for the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => esc_html__("Subtitle", "healthandcare"),
							"desc" => esc_html__("Subtitle for the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => esc_html__("Description", "healthandcare"),
							"desc" => esc_html__("Short description for the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"style" => array(
							"title" => esc_html__("Style", "healthandcare"),
							"desc" => esc_html__("Select style of the contact form", "healthandcare"),
							"value" => 1,
							"options" => healthandcare_get_list_styles(1, 2),
							"type" => "checklist"
						), 
						"custom" => array(
							"title" => esc_html__("Custom", "healthandcare"),
							"desc" => esc_html__("Use custom fields or create standard contact form (ignore info from 'Field' tabs)", "healthandcare"),
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						), 
						"action" => array(
							"title" => esc_html__("Action", "healthandcare"),
							"desc" => esc_html__("Contact form action (URL to handle form data). If empty - use internal action", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"align" => array(
							"title" => esc_html__("Align", "healthandcare"),
							"desc" => esc_html__("Select form alignment", "healthandcare"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						),
						"width" => healthandcare_shortcodes_width(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_form_item",
						"title" => esc_html__("Field", "healthandcare"),
						"desc" => esc_html__("Custom field", "healthandcare"),
						"container" => false,
						"params" => array(
							"type" => array(
								"title" => esc_html__("Type", "healthandcare"),
								"desc" => esc_html__("Type of the custom field", "healthandcare"),
								"value" => "text",
								"type" => "checklist",
								"dir" => "horizontal",
								"options" => $HEALTHANDCARE_GLOBALS['sc_params']['field_types']
							), 
							"name" => array(
								"title" => esc_html__("Name", "healthandcare"),
								"desc" => esc_html__("Name of the custom field", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"value" => array(
								"title" => esc_html__("Default value", "healthandcare"),
								"desc" => esc_html__("Default value of the custom field", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"options" => array(
								"title" => esc_html__("Options", "healthandcare"),
								"desc" => esc_html__("Field options. For example: big=My daddy|middle=My brother|small=My little sister", "healthandcare"),
								"dependency" => array(
									'type' => array('radio', 'checkbox', 'select')
								),
								"value" => "",
								"type" => "text"
							),
							"label" => array(
								"title" => esc_html__("Label", "healthandcare"),
								"desc" => esc_html__("Label for the custom field", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"label_position" => array(
								"title" => esc_html__("Label position", "healthandcare"),
								"desc" => esc_html__("Label position relative to the field", "healthandcare"),
								"value" => "top",
								"type" => "checklist",
								"dir" => "horizontal",
								"options" => $HEALTHANDCARE_GLOBALS['sc_params']['label_positions']
							), 
							"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
							"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
							"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
							"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
							"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
							"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
							"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
							"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Content block on fullscreen page
				"trx_content" => array(
					"title" => esc_html__("Content block", "healthandcare"),
					"desc" => esc_html__("Container for main content block with desired class and style (use it only on fullscreen pages)", "healthandcare"),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"scheme" => array(
							"title" => esc_html__("Color scheme", "healthandcare"),
							"desc" => esc_html__("Select color scheme for this block", "healthandcare"),
							"value" => "",
							"type" => "checklist",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['schemes']
						),
						"_content_" => array(
							"title" => esc_html__("Container content", "healthandcare"),
							"desc" => esc_html__("Content for section container", "healthandcare"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Countdown
				"trx_countdown" => array(
					"title" => esc_html__("Countdown", "healthandcare"),
					"desc" => esc_html__("Insert countdown object", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"date" => array(
							"title" => esc_html__("Date", "healthandcare"),
							"desc" => esc_html__("Upcoming date (format: yyyy-mm-dd)", "healthandcare"),
							"value" => "",
							"format" => "yy-mm-dd",
							"type" => "date"
						),
						"time" => array(
							"title" => esc_html__("Time", "healthandcare"),
							"desc" => esc_html__("Upcoming time (format: HH:mm:ss)", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"style" => array(
							"title" => esc_html__("Style", "healthandcare"),
							"desc" => esc_html__("Countdown style", "healthandcare"),
							"value" => "1",
							"type" => "checklist",
							"options" => healthandcare_get_list_styles(1, 2)
						),
						"align" => array(
							"title" => esc_html__("Alignment", "healthandcare"),
							"desc" => esc_html__("Align counter to left, center or right", "healthandcare"),
							"divider" => true,
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						), 
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Dropcaps
				"trx_dropcaps" => array(
					"title" => esc_html__("Dropcaps", "healthandcare"),
					"desc" => esc_html__("Make first letter as dropcaps", "healthandcare"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"style" => array(
							"title" => esc_html__("Style", "healthandcare"),
							"desc" => esc_html__("Dropcaps style", "healthandcare"),
							"value" => "1",
							"type" => "checklist",
							"options" => healthandcare_get_list_styles(1, 4)
						),
						"_content_" => array(
							"title" => esc_html__("Paragraph content", "healthandcare"),
							"desc" => esc_html__("Paragraph with dropcaps content", "healthandcare"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Emailer
				"trx_emailer" => array(
					"title" => esc_html__("E-mail collector", "healthandcare"),
					"desc" => esc_html__("Collect the e-mail address into specified group", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"group" => array(
							"title" => esc_html__("Group", "healthandcare"),
							"desc" => esc_html__("The name of group to collect e-mail address", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"open" => array(
							"title" => esc_html__("Open", "healthandcare"),
							"desc" => esc_html__("Initially open the input field on show object", "healthandcare"),
							"divider" => true,
							"value" => "yes",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"align" => array(
							"title" => esc_html__("Alignment", "healthandcare"),
							"desc" => esc_html__("Align object to left, center or right", "healthandcare"),
							"divider" => true,
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						), 
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Gap
				"trx_gap" => array(
					"title" => esc_html__("Gap", "healthandcare"),
					"desc" => esc_html__("Insert gap (fullwidth area) in the post content. Attention! Use the gap only in the posts (pages) without left or right sidebar", "healthandcare"),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"_content_" => array(
							"title" => esc_html__("Gap content", "healthandcare"),
							"desc" => esc_html__("Gap inner content", "healthandcare"),
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						)
					)
				),
			
			
			
			
			
				// Google map
				"trx_googlemap" => array(
					"title" => esc_html__("Google map", "healthandcare"),
					"desc" => esc_html__("Insert Google map with specified markers", "healthandcare"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"zoom" => array(
							"title" => esc_html__("Zoom", "healthandcare"),
							"desc" => esc_html__("Map zoom factor", "healthandcare"),
							"divider" => true,
							"value" => 16,
							"min" => 1,
							"max" => 20,
							"type" => "spinner"
						),
						"style" => array(
							"title" => esc_html__("Map style", "healthandcare"),
							"desc" => esc_html__("Select map style", "healthandcare"),
							"value" => "default",
							"type" => "checklist",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['googlemap_styles']
						),
						"width" => healthandcare_shortcodes_width('100%'),
						"height" => healthandcare_shortcodes_height(240),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_googlemap_marker",
						"title" => esc_html__("Google map marker", "healthandcare"),
						"desc" => esc_html__("Google map marker", "healthandcare"),
						"decorate" => false,
						"container" => true,
						"params" => array(
							"address" => array(
								"title" => esc_html__("Address", "healthandcare"),
								"desc" => esc_html__("Address of this marker", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"latlng" => array(
								"title" => esc_html__("Latitude and Longtitude", "healthandcare"),
								"desc" => esc_html__("Comma separated marker's coorditanes (instead Address)", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"point" => array(
								"title" => esc_html__("URL for marker image file", "healthandcare"),
								"desc" => esc_html__("Select or upload image or write URL from other site for this marker. If empty - use default marker", "healthandcare"),
								"readonly" => false,
								"value" => "",
								"type" => "media"
							),
							"title" => array(
								"title" => esc_html__("Title", "healthandcare"),
								"desc" => esc_html__("Title for this marker", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"_content_" => array(
								"title" => esc_html__("Description", "healthandcare"),
								"desc" => esc_html__("Description for this marker", "healthandcare"),
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id']
						)
					)
				),
			
			
			
				// Hide or show any block
				"trx_hide" => array(
					"title" => esc_html__("Hide/Show any block", "healthandcare"),
					"desc" => esc_html__("Hide or Show any block with desired CSS-selector", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"selector" => array(
							"title" => esc_html__("Selector", "healthandcare"),
							"desc" => esc_html__("Any block's CSS-selector", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"hide" => array(
							"title" => esc_html__("Hide or Show", "healthandcare"),
							"desc" => esc_html__("New state for the block: hide or show", "healthandcare"),
							"value" => "yes",
							"size" => "small",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no'],
							"type" => "switch"
						)
					)
				),
			
			
			
				// Highlght text
				"trx_highlight" => array(
					"title" => esc_html__("Highlight text", "healthandcare"),
					"desc" => esc_html__("Highlight text with selected color, background color and other styles", "healthandcare"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"type" => array(
							"title" => esc_html__("Type", "healthandcare"),
							"desc" => esc_html__("Highlight type", "healthandcare"),
							"value" => "1",
							"type" => "checklist",
							"options" => array(
								0 => esc_html__('Custom', 'healthandcare'),
								1 => esc_html__('Type 1', 'healthandcare'),
								2 => esc_html__('Type 2', 'healthandcare'),
								3 => esc_html__('Type 3', 'healthandcare')
							)
						),
						"color" => array(
							"title" => esc_html__("Color", "healthandcare"),
							"desc" => esc_html__("Color for the highlighted text", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"bg_color" => array(
							"title" => esc_html__("Background color", "healthandcare"),
							"desc" => esc_html__("Background color for the highlighted text", "healthandcare"),
							"value" => "",
							"type" => "color"
						),
						"font_size" => array(
							"title" => esc_html__("Font size", "healthandcare"),
							"desc" => esc_html__("Font size of the highlighted text (default - in pixels, allows any CSS units of measure)", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"_content_" => array(
							"title" => esc_html__("Highlighting content", "healthandcare"),
							"desc" => esc_html__("Content for highlight", "healthandcare"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Icon
				"trx_icon" => array(
					"title" => esc_html__("Icon", "healthandcare"),
					"desc" => esc_html__("Insert icon", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"icon" => array(
							"title" => esc_html__('Icon',  'healthandcare'),
							"desc" => esc_html__('Select font icon from the Fontello icons set',  'healthandcare'),
							"value" => "",
							"type" => "icons",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
						),
						"color" => array(
							"title" => esc_html__("Icon's color", "healthandcare"),
							"desc" => esc_html__("Icon's color", "healthandcare"),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "",
							"type" => "color"
						),
						"bg_shape" => array(
							"title" => esc_html__("Background shape", "healthandcare"),
							"desc" => esc_html__("Shape of the icon background", "healthandcare"),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "none",
							"type" => "radio",
							"options" => array(
								'none' => esc_html__('None', 'healthandcare'),
								'round' => esc_html__('Round', 'healthandcare'),
								'square' => esc_html__('Square', 'healthandcare')
							)
						),
						"bg_style" => array(
							"title" => esc_html__("Background style", "healthandcare"),
							"desc" => esc_html__("Select icon's color scheme", "healthandcare"),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "custom",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['button_styles']
						), 
						"bg_color" => array(
							"title" => esc_html__("Icon's background color", "healthandcare"),
							"desc" => esc_html__("Icon's background color", "healthandcare"),
							"dependency" => array(
								'icon' => array('not_empty'),
								'background' => array('round','square')
							),
							"value" => "",
							"type" => "color"
						),
						"font_size" => array(
							"title" => esc_html__("Font size", "healthandcare"),
							"desc" => esc_html__("Icon's font size", "healthandcare"),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "",
							"type" => "spinner",
							"min" => 8,
							"max" => 240
						),
						"font_weight" => array(
							"title" => esc_html__("Font weight", "healthandcare"),
							"desc" => esc_html__("Icon font weight", "healthandcare"),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "",
							"type" => "select",
							"size" => "medium",
							"options" => array(
								'100' => esc_html__('Thin (100)', 'healthandcare'),
								'300' => esc_html__('Light (300)', 'healthandcare'),
								'400' => esc_html__('Normal (400)', 'healthandcare'),
								'700' => esc_html__('Bold (700)', 'healthandcare')
							)
						),
						"align" => array(
							"title" => esc_html__("Alignment", "healthandcare"),
							"desc" => esc_html__("Icon text alignment", "healthandcare"),
							"dependency" => array(
								'icon' => array('not_empty')
							),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						), 
						"link" => array(
							"title" => esc_html__("Link URL", "healthandcare"),
							"desc" => esc_html__("Link URL from this icon (if not empty)", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Image
				"trx_image" => array(
					"title" => esc_html__("Image", "healthandcare"),
					"desc" => esc_html__("Insert image into your post (page)", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"url" => array(
							"title" => esc_html__("URL for image file", "healthandcare"),
							"desc" => esc_html__("Select or upload image or write URL from other site", "healthandcare"),
							"readonly" => false,
							"value" => "",
							"type" => "media",
							"before" => array(
								'sizes' => true		// If you want allow user select thumb size for image. Otherwise, thumb size is ignored - image fullsize used
							)
						),
						"title" => array(
							"title" => esc_html__("Title", "healthandcare"),
							"desc" => esc_html__("Image title (if need)", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"icon" => array(
							"title" => esc_html__("Icon before title",  'healthandcare'),
							"desc" => esc_html__('Select icon for the title from Fontello icons set',  'healthandcare'),
							"value" => "",
							"type" => "icons",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
						),
						"align" => array(
							"title" => esc_html__("Float image", "healthandcare"),
							"desc" => esc_html__("Float image to left or right side", "healthandcare"),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['float']
						), 
						"shape" => array(
							"title" => esc_html__("Image Shape", "healthandcare"),
							"desc" => esc_html__("Shape of the image: square (rectangle) or round", "healthandcare"),
							"value" => "square",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								"square" => esc_html__('Square', 'healthandcare'),
								"round" => esc_html__('Round', 'healthandcare')
							)
						), 
						"link" => array(
							"title" => esc_html__("Link", "healthandcare"),
							"desc" => esc_html__("The link URL from the image", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
				// Infobox
				"trx_infobox" => array(
					"title" => esc_html__("Infobox", "healthandcare"),
					"desc" => esc_html__("Insert infobox into your post (page)", "healthandcare"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"style" => array(
							"title" => esc_html__("Style", "healthandcare"),
							"desc" => esc_html__("Infobox style", "healthandcare"),
							"value" => "regular",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								'regular' => esc_html__('Regular', 'healthandcare'),
								'info' => esc_html__('Info', 'healthandcare'),
								'success' => esc_html__('Success', 'healthandcare'),
								'error' => esc_html__('Error', 'healthandcare')
							)
						),
						"closeable" => array(
							"title" => esc_html__("Closeable box", "healthandcare"),
							"desc" => esc_html__("Create closeable box (with close button)", "healthandcare"),
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"icon" => array(
							"title" => esc_html__("Custom icon",  'healthandcare'),
							"desc" => esc_html__('Select icon for the infobox from Fontello icons set. If empty - use default icon',  'healthandcare'),
							"value" => "",
							"type" => "icons",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
						),
						"color" => array(
							"title" => esc_html__("Text color", "healthandcare"),
							"desc" => esc_html__("Any color for text and headers", "healthandcare"),
							"value" => "",
							"type" => "color"
						),
						"bg_color" => array(
							"title" => esc_html__("Background color", "healthandcare"),
							"desc" => esc_html__("Any background color for this infobox", "healthandcare"),
							"value" => "",
							"type" => "color"
						),
						"_content_" => array(
							"title" => esc_html__("Infobox content", "healthandcare"),
							"desc" => esc_html__("Content for infobox", "healthandcare"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
				// Line
				"trx_line" => array(
					"title" => esc_html__("Line", "healthandcare"),
					"desc" => esc_html__("Insert Line into your post (page)", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => esc_html__("Style", "healthandcare"),
							"desc" => esc_html__("Line style", "healthandcare"),
							"value" => "solid",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								'solid' => esc_html__('Solid', 'healthandcare'),
								'dashed' => esc_html__('Dashed', 'healthandcare'),
								'dotted' => esc_html__('Dotted', 'healthandcare'),
								'double' => esc_html__('Double', 'healthandcare')
							)
						),
						"color" => array(
							"title" => esc_html__("Color", "healthandcare"),
							"desc" => esc_html__("Line color", "healthandcare"),
							"value" => "",
							"type" => "color"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// List
				"trx_list" => array(
					"title" => esc_html__("List", "healthandcare"),
					"desc" => esc_html__("List items with specific bullets", "healthandcare"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => esc_html__("Bullet's style", "healthandcare"),
							"desc" => esc_html__("Bullet's style for each list item", "healthandcare"),
							"value" => "ul",
							"type" => "checklist",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['list_styles']
						), 
						"color" => array(
							"title" => esc_html__("Color", "healthandcare"),
							"desc" => esc_html__("List items color", "healthandcare"),
							"value" => "",
							"type" => "color"
						),
						"icon" => array(
							"title" => esc_html__('List icon',  'healthandcare'),
							"desc" => esc_html__("Select list icon from Fontello icons set (only for style=Iconed)",  'healthandcare'),
							"dependency" => array(
								'style' => array('iconed')
							),
							"value" => "",
							"type" => "icons",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
						),
						"icon_color" => array(
							"title" => esc_html__("Icon color", "healthandcare"),
							"desc" => esc_html__("List icons color", "healthandcare"),
							"value" => "",
							"dependency" => array(
								'style' => array('iconed')
							),
							"type" => "color"
						),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_list_item",
						"title" => esc_html__("Item", "healthandcare"),
						"desc" => esc_html__("List item with specific bullet", "healthandcare"),
						"decorate" => false,
						"container" => true,
						"params" => array(
							"_content_" => array(
								"title" => esc_html__("List item content", "healthandcare"),
								"desc" => esc_html__("Current list item content", "healthandcare"),
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"title" => array(
								"title" => esc_html__("List item title", "healthandcare"),
								"desc" => esc_html__("Current list item title (show it as tooltip)", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"color" => array(
								"title" => esc_html__("Color", "healthandcare"),
								"desc" => esc_html__("Text color for this item", "healthandcare"),
								"value" => "",
								"type" => "color"
							),
							"icon" => array(
								"title" => esc_html__('List icon',  'healthandcare'),
								"desc" => esc_html__("Select list item icon from Fontello icons set (only for style=Iconed)",  'healthandcare'),
								"value" => "",
								"type" => "icons",
								"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
							),
							"icon_color" => array(
								"title" => esc_html__("Icon color", "healthandcare"),
								"desc" => esc_html__("Icon color for this item", "healthandcare"),
								"value" => "",
								"type" => "color"
							),
							"link" => array(
								"title" => esc_html__("Link URL", "healthandcare"),
								"desc" => esc_html__("Link URL for the current list item", "healthandcare"),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"target" => array(
								"title" => esc_html__("Link target", "healthandcare"),
								"desc" => esc_html__("Link target for the current list item", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
							"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
							"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
				// Number
				"trx_number" => array(
					"title" => esc_html__("Number", "healthandcare"),
					"desc" => esc_html__("Insert number or any word as set separate characters", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"value" => array(
							"title" => esc_html__("Value", "healthandcare"),
							"desc" => esc_html__("Number or any word", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"align" => array(
							"title" => esc_html__("Align", "healthandcare"),
							"desc" => esc_html__("Select block alignment", "healthandcare"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Parallax
				"trx_parallax" => array(
					"title" => esc_html__("Parallax", "healthandcare"),
					"desc" => esc_html__("Create the parallax container (with asinc background image)", "healthandcare"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"gap" => array(
							"title" => esc_html__("Create gap", "healthandcare"),
							"desc" => esc_html__("Create gap around parallax container", "healthandcare"),
							"value" => "no",
							"size" => "small",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no'],
							"type" => "switch"
						), 
						"dir" => array(
							"title" => esc_html__("Dir", "healthandcare"),
							"desc" => esc_html__("Scroll direction for the parallax background", "healthandcare"),
							"value" => "up",
							"size" => "medium",
							"options" => array(
								'up' => esc_html__('Up', 'healthandcare'),
								'down' => esc_html__('Down', 'healthandcare')
							),
							"type" => "switch"
						), 
						"speed" => array(
							"title" => esc_html__("Speed", "healthandcare"),
							"desc" => esc_html__("Image motion speed (from 0.0 to 1.0)", "healthandcare"),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0.3",
							"type" => "spinner"
						),
						"scheme" => array(
							"title" => esc_html__("Color scheme", "healthandcare"),
							"desc" => esc_html__("Select color scheme for this block", "healthandcare"),
							"value" => "",
							"type" => "checklist",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['schemes']
						),
						"color" => array(
							"title" => esc_html__("Text color", "healthandcare"),
							"desc" => esc_html__("Select color for text object inside parallax block", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"bg_color" => array(
							"title" => esc_html__("Background color", "healthandcare"),
							"desc" => esc_html__("Select color for parallax background", "healthandcare"),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => esc_html__("Background image", "healthandcare"),
							"desc" => esc_html__("Select or upload image or write URL from other site for the parallax background", "healthandcare"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_image_x" => array(
							"title" => esc_html__("Image X position", "healthandcare"),
							"desc" => esc_html__("Image horizontal position (as background of the parallax block) - in percent", "healthandcare"),
							"min" => "0",
							"max" => "100",
							"value" => "50",
							"type" => "spinner"
						),
						"bg_video" => array(
							"title" => esc_html__("Video background", "healthandcare"),
							"desc" => esc_html__("Select video from media library or paste URL for video file from other site to show it as parallax background", "healthandcare"),
							"readonly" => false,
							"value" => "",
							"type" => "media",
							"before" => array(
								'title' => esc_html__('Choose video', 'healthandcare'),
								'action' => 'media_upload',
								'type' => 'video',
								'multiple' => false,
								'linked_field' => '',
								'captions' => array( 	
									'choose' => esc_html__('Choose video file', 'healthandcare'),
									'update' => esc_html__('Select video file', 'healthandcare')
								)
							),
							"after" => array(
								'icon' => 'icon-cancel',
								'action' => 'media_reset'
							)
						),
						"bg_video_ratio" => array(
							"title" => esc_html__("Video ratio", "healthandcare"),
							"desc" => esc_html__("Specify ratio of the video background. For example: 16:9 (default), 4:3, etc.", "healthandcare"),
							"value" => "16:9",
							"type" => "text"
						),
						"bg_overlay" => array(
							"title" => esc_html__("Overlay", "healthandcare"),
							"desc" => esc_html__("Overlay color opacity (from 0.0 to 1.0)", "healthandcare"),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => esc_html__("Texture", "healthandcare"),
							"desc" => esc_html__("Predefined texture style from 1 to 11. 0 - without texture.", "healthandcare"),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"_content_" => array(
							"title" => esc_html__("Content", "healthandcare"),
							"desc" => esc_html__("Content for the parallax container", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Popup
				"trx_popup" => array(
					"title" => esc_html__("Popup window", "healthandcare"),
					"desc" => esc_html__("Container for any html-block with desired class and style for popup window", "healthandcare"),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"_content_" => array(
							"title" => esc_html__("Container content", "healthandcare"),
							"desc" => esc_html__("Content for section container", "healthandcare"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Price
				"trx_price" => array(
					"title" => esc_html__("Price", "healthandcare"),
					"desc" => esc_html__("Insert price with decoration", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"money" => array(
							"title" => esc_html__("Money", "healthandcare"),
							"desc" => esc_html__("Money value (dot or comma separated)", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"currency" => array(
							"title" => esc_html__("Currency", "healthandcare"),
							"desc" => esc_html__("Currency character", "healthandcare"),
							"value" => "$",
							"type" => "text"
						),
						"period" => array(
							"title" => esc_html__("Period", "healthandcare"),
							"desc" => esc_html__("Period text (if need). For example: monthly, daily, etc.", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"align" => array(
							"title" => esc_html__("Alignment", "healthandcare"),
							"desc" => esc_html__("Align price to left or right side", "healthandcare"),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['float']
						), 
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
				// Price block
				"trx_price_block" => array(
					"title" => esc_html__("Price block", "healthandcare"),
					"desc" => esc_html__("Insert price block with title, price and description", "healthandcare"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"title" => array(
							"title" => esc_html__("Title", "healthandcare"),
							"desc" => esc_html__("Block title", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"link" => array(
							"title" => esc_html__("Link URL", "healthandcare"),
							"desc" => esc_html__("URL for link from button (at bottom of the block)", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"link_text" => array(
							"title" => esc_html__("Link text", "healthandcare"),
							"desc" => esc_html__("Text (caption) for the link button (at bottom of the block). If empty - button not showed", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"icon" => array(
							"title" => esc_html__("Icon",  'healthandcare'),
							"desc" => esc_html__('Select icon from Fontello icons set (placed before/instead price)',  'healthandcare'),
							"value" => "",
							"type" => "icons",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
						),
						"money" => array(
							"title" => esc_html__("Money", "healthandcare"),
							"desc" => esc_html__("Money value (dot or comma separated)", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"currency" => array(
							"title" => esc_html__("Currency", "healthandcare"),
							"desc" => esc_html__("Currency character", "healthandcare"),
							"value" => "$",
							"type" => "text"
						),
						"period" => array(
							"title" => esc_html__("Period", "healthandcare"),
							"desc" => esc_html__("Period text (if need). For example: monthly, daily, etc.", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"scheme" => array(
							"title" => esc_html__("Color scheme", "healthandcare"),
							"desc" => esc_html__("Select color scheme for this block", "healthandcare"),
							"value" => "",
							"type" => "checklist",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['schemes']
						),
						"align" => array(
							"title" => esc_html__("Alignment", "healthandcare"),
							"desc" => esc_html__("Align price to left or right side", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['float']
						), 
						"_content_" => array(
							"title" => esc_html__("Description", "healthandcare"),
							"desc" => esc_html__("Description for this price block", "healthandcare"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Quote
				"trx_quote" => array(
					"title" => esc_html__("Quote", "healthandcare"),
					"desc" => esc_html__("Quote text", "healthandcare"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"cite" => array(
							"title" => esc_html__("Quote cite", "healthandcare"),
							"desc" => esc_html__("URL for quote cite", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"title" => array(
							"title" => esc_html__("Title (author)", "healthandcare"),
							"desc" => esc_html__("Quote title (author name)", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"_content_" => array(
							"title" => esc_html__("Quote content", "healthandcare"),
							"desc" => esc_html__("Quote content", "healthandcare"),
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => healthandcare_shortcodes_width(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Reviews
				"trx_reviews" => array(
					"title" => esc_html__("Reviews", "healthandcare"),
					"desc" => esc_html__("Insert reviews block in the single post", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"align" => array(
							"title" => esc_html__("Alignment", "healthandcare"),
							"desc" => esc_html__("Align counter to left, center or right", "healthandcare"),
							"divider" => true,
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						), 
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Search
				"trx_search" => array(
					"title" => esc_html__("Search", "healthandcare"),
					"desc" => esc_html__("Show search form", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => esc_html__("Style", "healthandcare"),
							"desc" => esc_html__("Select style to display search field", "healthandcare"),
							"value" => "regular",
							"options" => array(
								"regular" => esc_html__('Regular', 'healthandcare'),
								"rounded" => esc_html__('Rounded', 'healthandcare')
							),
							"type" => "checklist"
						),
						"state" => array(
							"title" => esc_html__("State", "healthandcare"),
							"desc" => esc_html__("Select search field initial state", "healthandcare"),
							"value" => "fixed",
							"options" => array(
								"fixed"  => esc_html__('Fixed',  'healthandcare'),
								"opened" => esc_html__('Opened', 'healthandcare'),
								"closed" => esc_html__('Closed', 'healthandcare')
							),
							"type" => "checklist"
						),
						"title" => array(
							"title" => esc_html__("Title", "healthandcare"),
							"desc" => esc_html__("Title (placeholder) for the search field", "healthandcare"),
							"value" => esc_html__("Search &hellip;", 'healthandcare'),
							"type" => "text"
						),
						"ajax" => array(
							"title" => esc_html__("AJAX", "healthandcare"),
							"desc" => esc_html__("Search via AJAX or reload page", "healthandcare"),
							"value" => "yes",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no'],
							"type" => "switch"
						),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Section
				"trx_section" => array(
					"title" => esc_html__("Section container", "healthandcare"),
					"desc" => esc_html__("Container for any block with desired class and style", "healthandcare"),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"dedicated" => array(
							"title" => esc_html__("Dedicated", "healthandcare"),
							"desc" => esc_html__("Use this block as dedicated content - show it before post title on single page", "healthandcare"),
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"align" => array(
							"title" => esc_html__("Align", "healthandcare"),
							"desc" => esc_html__("Select block alignment", "healthandcare"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						),
						"columns" => array(
							"title" => esc_html__("Columns emulation", "healthandcare"),
							"desc" => esc_html__("Select width for columns emulation", "healthandcare"),
							"value" => "none",
							"type" => "checklist",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['columns']
						), 
						"pan" => array(
							"title" => esc_html__("Use pan effect", "healthandcare"),
							"desc" => esc_html__("Use pan effect to show section content", "healthandcare"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"scroll" => array(
							"title" => esc_html__("Use scroller", "healthandcare"),
							"desc" => esc_html__("Use scroller to show section content", "healthandcare"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"scroll_dir" => array(
							"title" => esc_html__("Scroll and Pan direction", "healthandcare"),
							"desc" => esc_html__("Scroll and Pan direction (if Use scroller = yes or Pan = yes)", "healthandcare"),
							"dependency" => array(
								'pan' => array('yes'),
								'scroll' => array('yes')
							),
							"value" => "horizontal",
							"type" => "switch",
							"size" => "big",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['dir']
						),
						"scroll_controls" => array(
							"title" => esc_html__("Scroll controls", "healthandcare"),
							"desc" => esc_html__("Show scroll controls (if Use scroller = yes)", "healthandcare"),
							"dependency" => array(
								'scroll' => array('yes')
							),
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"scheme" => array(
							"title" => esc_html__("Color scheme", "healthandcare"),
							"desc" => esc_html__("Select color scheme for this block", "healthandcare"),
							"value" => "",
							"type" => "checklist",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['schemes']
						),
						"color" => array(
							"title" => esc_html__("Fore color", "healthandcare"),
							"desc" => esc_html__("Any color for objects in this section", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"bg_color" => array(
							"title" => esc_html__("Background color", "healthandcare"),
							"desc" => esc_html__("Any background color for this section", "healthandcare"),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => esc_html__("Background image URL", "healthandcare"),
							"desc" => esc_html__("Select or upload image or write URL from other site for the background", "healthandcare"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_overlay" => array(
							"title" => esc_html__("Overlay", "healthandcare"),
							"desc" => esc_html__("Overlay color opacity (from 0.0 to 1.0)", "healthandcare"),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => esc_html__("Texture", "healthandcare"),
							"desc" => esc_html__("Predefined texture style from 1 to 11. 0 - without texture.", "healthandcare"),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"font_size" => array(
							"title" => esc_html__("Font size", "healthandcare"),
							"desc" => esc_html__("Font size of the text (default - in pixels, allows any CSS units of measure)", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"font_weight" => array(
							"title" => esc_html__("Font weight", "healthandcare"),
							"desc" => esc_html__("Font weight of the text", "healthandcare"),
							"value" => "",
							"type" => "select",
							"size" => "medium",
							"options" => array(
								'100' => esc_html__('Thin (100)', 'healthandcare'),
								'300' => esc_html__('Light (300)', 'healthandcare'),
								'400' => esc_html__('Normal (400)', 'healthandcare'),
								'700' => esc_html__('Bold (700)', 'healthandcare')
							)
						),
						"_content_" => array(
							"title" => esc_html__("Container content", "healthandcare"),
							"desc" => esc_html__("Content for section container", "healthandcare"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
				// Skills
				"trx_skills" => array(
					"title" => esc_html__("Skills", "healthandcare"),
					"desc" => esc_html__("Insert skills diagramm in your page (post)", "healthandcare"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"max_value" => array(
							"title" => esc_html__("Max value", "healthandcare"),
							"desc" => esc_html__("Max value for skills items", "healthandcare"),
							"value" => 100,
							"min" => 1,
							"type" => "spinner"
						),
						"type" => array(
							"title" => esc_html__("Skills type", "healthandcare"),
							"desc" => esc_html__("Select type of skills block", "healthandcare"),
							"value" => "bar",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								'bar' => esc_html__('Bar', 'healthandcare'),
								'pie' => esc_html__('Pie chart', 'healthandcare'),
								'counter' => esc_html__('Counter', 'healthandcare'),
								'arc' => esc_html__('Arc', 'healthandcare')
							)
						), 
						"layout" => array(
							"title" => esc_html__("Skills layout", "healthandcare"),
							"desc" => esc_html__("Select layout of skills block", "healthandcare"),
							"dependency" => array(
								'type' => array('counter','pie','bar')
							),
							"value" => "rows",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								'rows' => esc_html__('Rows', 'healthandcare'),
								'columns' => esc_html__('Columns', 'healthandcare')
							)
						),
						"dir" => array(
							"title" => esc_html__("Direction", "healthandcare"),
							"desc" => esc_html__("Select direction of skills block", "healthandcare"),
							"dependency" => array(
								'type' => array('counter','pie','bar')
							),
							"value" => "horizontal",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['dir']
						), 
						"style" => array(
							"title" => esc_html__("Counters style", "healthandcare"),
							"desc" => esc_html__("Select style of skills items (only for type=counter)", "healthandcare"),
							"dependency" => array(
								'type' => array('counter')
							),
							"value" => 1,
							"options" => healthandcare_get_list_styles(1, 4),
							"type" => "checklist"
						), 
						// "columns" - autodetect, not set manual
						"color" => array(
							"title" => esc_html__("Skills items color", "healthandcare"),
							"desc" => esc_html__("Color for all skills items", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "color"
						),
						"bg_color" => array(
							"title" => esc_html__("Background color", "healthandcare"),
							"desc" => esc_html__("Background color for all skills items (only for type=pie)", "healthandcare"),
							"dependency" => array(
								'type' => array('pie')
							),
							"value" => "",
							"type" => "color"
						),
						"border_color" => array(
							"title" => esc_html__("Border color", "healthandcare"),
							"desc" => esc_html__("Border color for all skills items (only for type=pie)", "healthandcare"),
							"dependency" => array(
								'type' => array('pie')
							),
							"value" => "",
							"type" => "color"
						),
						"align" => array(
							"title" => esc_html__("Align skills block", "healthandcare"),
							"desc" => esc_html__("Align skills block to left or right side", "healthandcare"),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['float']
						), 
						"arc_caption" => array(
							"title" => esc_html__("Arc Caption", "healthandcare"),
							"desc" => esc_html__("Arc caption - text in the center of the diagram", "healthandcare"),
							"dependency" => array(
								'type' => array('arc')
							),
							"value" => "",
							"type" => "text"
						),
						"pie_compact" => array(
							"title" => esc_html__("Pie compact", "healthandcare"),
							"desc" => esc_html__("Show all skills in one diagram or as separate diagrams", "healthandcare"),
							"dependency" => array(
								'type' => array('pie')
							),
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"pie_cutout" => array(
							"title" => esc_html__("Pie cutout", "healthandcare"),
							"desc" => esc_html__("Pie cutout (0-99). 0 - without cutout, 99 - max cutout", "healthandcare"),
							"dependency" => array(
								'type' => array('pie')
							),
							"value" => 0,
							"min" => 0,
							"max" => 99,
							"type" => "spinner"
						),
						"title" => array(
							"title" => esc_html__("Title", "healthandcare"),
							"desc" => esc_html__("Title for the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => esc_html__("Subtitle", "healthandcare"),
							"desc" => esc_html__("Subtitle for the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => esc_html__("Description", "healthandcare"),
							"desc" => esc_html__("Short description for the block", "healthandcare"),
							"value" => "",
							"type" => "textarea"
						),
						"link" => array(
							"title" => esc_html__("Button URL", "healthandcare"),
							"desc" => esc_html__("Link URL for the button at the bottom of the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"link_caption" => array(
							"title" => esc_html__("Button caption", "healthandcare"),
							"desc" => esc_html__("Caption for the button at the bottom of the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_skills_item",
						"title" => esc_html__("Skill", "healthandcare"),
						"desc" => esc_html__("Skills item", "healthandcare"),
						"container" => false,
						"params" => array(
							"title" => array(
								"title" => esc_html__("Title", "healthandcare"),
								"desc" => esc_html__("Current skills item title", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"value" => array(
								"title" => esc_html__("Value", "healthandcare"),
								"desc" => esc_html__("Current skills level", "healthandcare"),
								"value" => 50,
								"min" => 0,
								"step" => 1,
								"type" => "spinner"
							),
							"color" => array(
								"title" => esc_html__("Color", "healthandcare"),
								"desc" => esc_html__("Current skills item color", "healthandcare"),
								"value" => "",
								"type" => "color"
							),
							"bg_color" => array(
								"title" => esc_html__("Background color", "healthandcare"),
								"desc" => esc_html__("Current skills item background color (only for type=pie)", "healthandcare"),
								"value" => "",
								"type" => "color"
							),
							"border_color" => array(
								"title" => esc_html__("Border color", "healthandcare"),
								"desc" => esc_html__("Current skills item border color (only for type=pie)", "healthandcare"),
								"value" => "",
								"type" => "color"
							),
							"style" => array(
								"title" => esc_html__("Counter style", "healthandcare"),
								"desc" => esc_html__("Select style for the current skills item (only for type=counter)", "healthandcare"),
								"value" => 1,
								"options" => healthandcare_get_list_styles(1, 4),
								"type" => "checklist"
							), 
							"icon" => array(
								"title" => esc_html__("Counter icon",  'healthandcare'),
								"desc" => esc_html__('Select icon from Fontello icons set, placed above counter (only for type=counter)',  'healthandcare'),
								"value" => "",
								"type" => "icons",
								"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
							),
							"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
							"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
							"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Slider
				"trx_slider" => array(
					"title" => esc_html__("Slider", "healthandcare"),
					"desc" => esc_html__("Insert slider into your post (page)", "healthandcare"),
					"decorate" => true,
					"container" => false,
					"params" => array_merge(array(
						"engine" => array(
							"title" => esc_html__("Slider engine", "healthandcare"),
							"desc" => esc_html__("Select engine for slider. Attention! Swiper is built-in engine, all other engines appears only if corresponding plugings are installed", "healthandcare"),
							"value" => "swiper",
							"type" => "checklist",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['sliders']
						),
						"align" => array(
							"title" => esc_html__("Float slider", "healthandcare"),
							"desc" => esc_html__("Float slider to left or right side", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['float']
						),
						"custom" => array(
							"title" => esc_html__("Custom slides", "healthandcare"),
							"desc" => esc_html__("Make custom slides from inner shortcodes (prepare it on tabs) or prepare slides from posts thumbnails", "healthandcare"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						)
						),
						healthandcare_exists_revslider() || healthandcare_exists_royalslider() ? array(
						"alias" => array(
							"title" => esc_html__("Revolution slider alias or Royal Slider ID", "healthandcare"),
							"desc" => esc_html__("Alias for Revolution slider or Royal slider ID", "healthandcare"),
							"dependency" => array(
								'engine' => array('revo','royal')
							),
							"divider" => true,
							"value" => "",
							"type" => "text"
						)) : array(), array(
						"cat" => array(
							"title" => esc_html__("Swiper: Category list", "healthandcare"),
							"desc" => esc_html__("Select category to show post's images. If empty - select posts from any category or from IDs list", "healthandcare"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => healthandcare_array_merge(array(0 => esc_html__('- Select category -', 'healthandcare')), $HEALTHANDCARE_GLOBALS['sc_params']['categories'])
						),
						"count" => array(
							"title" => esc_html__("Swiper: Number of posts", "healthandcare"),
							"desc" => esc_html__("How many posts will be displayed? If used IDs - this parameter ignored.", "healthandcare"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => esc_html__("Swiper: Offset before select posts", "healthandcare"),
							"desc" => esc_html__("Skip posts before select next part.", "healthandcare"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Swiper: Post order by", "healthandcare"),
							"desc" => esc_html__("Select desired posts sorting method", "healthandcare"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "date",
							"type" => "select",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['sorting']
						),
						"order" => array(
							"title" => esc_html__("Swiper: Post order", "healthandcare"),
							"desc" => esc_html__("Select desired posts order", "healthandcare"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['ordering']
						),
						"ids" => array(
							"title" => esc_html__("Swiper: Post IDs list", "healthandcare"),
							"desc" => esc_html__("Comma separated list of posts ID. If set - parameters above are ignored!", "healthandcare"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "",
							"type" => "text"
						),
						"controls" => array(
							"title" => esc_html__("Swiper: Show slider controls", "healthandcare"),
							"desc" => esc_html__("Show arrows inside slider", "healthandcare"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"divider" => true,
							"value" => "yes",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"pagination" => array(
							"title" => esc_html__("Swiper: Show slider pagination", "healthandcare"),
							"desc" => esc_html__("Show bullets for switch slides", "healthandcare"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "yes",
							"type" => "checklist",
							"options" => array(
								'yes'  => esc_html__('Dots', 'healthandcare'),
								'full' => esc_html__('Side Titles', 'healthandcare'),
								'over' => esc_html__('Over Titles', 'healthandcare'),
								'no'   => esc_html__('None', 'healthandcare')
							)
						),
						"titles" => array(
							"title" => esc_html__("Swiper: Show titles section", "healthandcare"),
							"desc" => esc_html__("Show section with post's title and short post's description", "healthandcare"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"divider" => true,
							"value" => "no",
							"type" => "checklist",
							"options" => array(
								"no"    => esc_html__('Not show', 'healthandcare'),
								"slide" => esc_html__('Show/Hide info', 'healthandcare'),
								"fixed" => esc_html__('Fixed info', 'healthandcare')
							)
						),
						"descriptions" => array(
							"title" => esc_html__("Swiper: Post descriptions", "healthandcare"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"desc" => esc_html__("Show post's excerpt max length (characters)", "healthandcare"),
							"value" => 0,
							"min" => 0,
							"max" => 1000,
							"step" => 10,
							"type" => "spinner"
						),
						"links" => array(
							"title" => esc_html__("Swiper: Post's title as link", "healthandcare"),
							"desc" => esc_html__("Make links from post's titles", "healthandcare"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "yes",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"crop" => array(
							"title" => esc_html__("Swiper: Crop images", "healthandcare"),
							"desc" => esc_html__("Crop images in each slide or live it unchanged", "healthandcare"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "yes",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"autoheight" => array(
							"title" => esc_html__("Swiper: Autoheight", "healthandcare"),
							"desc" => esc_html__("Change whole slider's height (make it equal current slide's height)", "healthandcare"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => "yes",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"interval" => array(
							"title" => esc_html__("Swiper: Slides change interval", "healthandcare"),
							"desc" => esc_html__("Slides change interval (in milliseconds: 1000ms = 1s)", "healthandcare"),
							"dependency" => array(
								'engine' => array('swiper')
							),
							"value" => 5000,
							"step" => 500,
							"min" => 0,
							"type" => "spinner"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)),
					"children" => array(
						"name" => "trx_slider_item",
						"title" => esc_html__("Slide", "healthandcare"),
						"desc" => esc_html__("Slider item", "healthandcare"),
						"container" => false,
						"params" => array(
							"src" => array(
								"title" => esc_html__("URL (source) for image file", "healthandcare"),
								"desc" => esc_html__("Select or upload image or write URL from other site for the current slide", "healthandcare"),
								"readonly" => false,
								"value" => "",
								"type" => "media"
							),
							"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
							"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
							"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
				// Socials
				"trx_socials" => array(
					"title" => esc_html__("Social icons", "healthandcare"),
					"desc" => esc_html__("List of social icons (with hovers)", "healthandcare"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"type" => array(
							"title" => esc_html__("Icon's type", "healthandcare"),
							"desc" => esc_html__("Type of the icons - images or font icons", "healthandcare"),
							"value" => healthandcare_get_theme_setting('socials_type'),
							"options" => array(
								'icons' => esc_html__('Icons', 'healthandcare'),
								'images' => esc_html__('Images', 'healthandcare')
							),
							"type" => "checklist"
						), 
						"size" => array(
							"title" => esc_html__("Icon's size", "healthandcare"),
							"desc" => esc_html__("Size of the icons", "healthandcare"),
							"value" => "small",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['sizes'],
							"type" => "checklist"
						), 
						"shape" => array(
							"title" => esc_html__("Icon's shape", "healthandcare"),
							"desc" => esc_html__("Shape of the icons", "healthandcare"),
							"value" => "square",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['shapes'],
							"type" => "checklist"
						), 
						"socials" => array(
							"title" => esc_html__("Manual socials list", "healthandcare"),
							"desc" => esc_html__("Custom list of social networks. For example: twitter=http://twitter.com/my_profile|facebook=http://facebooc.com/my_profile. If empty - use socials from Theme options.", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "text"
						),
						"custom" => array(
							"title" => esc_html__("Custom socials", "healthandcare"),
							"desc" => esc_html__("Make custom icons from inner shortcodes (prepare it on tabs)", "healthandcare"),
							"divider" => true,
							"value" => "no",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no'],
							"type" => "switch"
						),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_social_item",
						"title" => esc_html__("Custom social item", "healthandcare"),
						"desc" => esc_html__("Custom social item: name, profile url and icon url", "healthandcare"),
						"decorate" => false,
						"container" => false,
						"params" => array(
							"name" => array(
								"title" => esc_html__("Social name", "healthandcare"),
								"desc" => esc_html__("Name (slug) of the social network (twitter, facebook, linkedin, etc.)", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"url" => array(
								"title" => esc_html__("Your profile URL", "healthandcare"),
								"desc" => esc_html__("URL of your profile in specified social network", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"icon" => array(
								"title" => esc_html__("URL (source) for icon file", "healthandcare"),
								"desc" => esc_html__("Select or upload image or write URL from other site for the current social icon", "healthandcare"),
								"readonly" => false,
								"value" => "",
								"type" => "media"
							)
						)
					)
				),
			
			
			
			
				// Table
				"trx_table" => array(
					"title" => esc_html__("Table", "healthandcare"),
					"desc" => esc_html__("Insert a table into post (page). ", "healthandcare"),
					"decorate" => true,
					"container" => true,
					"params" => array(
						"align" => array(
							"title" => esc_html__("Content alignment", "healthandcare"),
							"desc" => esc_html__("Select alignment for each table cell", "healthandcare"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						),
						"_content_" => array(
							"title" => esc_html__("Table content", "healthandcare"),
							"desc" => esc_html__("Content, created with any table-generator", "healthandcare"),
							"divider" => true,
							"rows" => 8,
							"value" => "Paste here table content, generated on one of many public internet resources, for example: http://www.impressivewebs.com/html-table-code-generator/ or http://html-tables.com/",
							"type" => "textarea"
						),
						"width" => healthandcare_shortcodes_width(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Tabs
				"trx_tabs" => array(
					"title" => esc_html__("Tabs", "healthandcare"),
					"desc" => esc_html__("Insert tabs in your page (post)", "healthandcare"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => esc_html__("Tabs style", "healthandcare"),
							"desc" => esc_html__("Select style for tabs items", "healthandcare"),
							"value" => 1,
							"options" => healthandcare_get_list_styles(1, 2),
							"type" => "radio"
						),
						"initial" => array(
							"title" => esc_html__("Initially opened tab", "healthandcare"),
							"desc" => esc_html__("Number of initially opened tab", "healthandcare"),
							"divider" => true,
							"value" => 1,
							"min" => 0,
							"type" => "spinner"
						),
						"scroll" => array(
							"title" => esc_html__("Use scroller", "healthandcare"),
							"desc" => esc_html__("Use scroller to show tab content (height parameter required)", "healthandcare"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_tab",
						"title" => esc_html__("Tab", "healthandcare"),
						"desc" => esc_html__("Tab item", "healthandcare"),
						"container" => true,
						"params" => array(
							"title" => array(
								"title" => esc_html__("Tab title", "healthandcare"),
								"desc" => esc_html__("Current tab title", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
                            "icon_before_title" => array(
                                "title" => esc_html__("Icon before title",  'healthandcare'),
                                "desc" => esc_html__('Select icon for before title tabs item from Fontello icons set',  'healthandcare'),
                                "value" => "",
                                "type" => "icons",
                                "options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
                            ),
							"_content_" => array(
								"title" => esc_html__("Tab content", "healthandcare"),
								"desc" => esc_html__("Current tab content", "healthandcare"),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
							"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
							"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
						)
					)
				),
			


				
			
			
				// Title
				"trx_title" => array(
					"title" => esc_html__("Title", "healthandcare"),
					"desc" => esc_html__("Create header tag (1-6 level) with many styles", "healthandcare"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"_content_" => array(
							"title" => esc_html__("Title content", "healthandcare"),
							"desc" => esc_html__("Title content", "healthandcare"),
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"type" => array(
							"title" => esc_html__("Title type", "healthandcare"),
							"desc" => esc_html__("Title type (header level)", "healthandcare"),
							"divider" => true,
							"value" => "1",
							"type" => "select",
							"options" => array(
								'1' => esc_html__('Header 1', 'healthandcare'),
								'2' => esc_html__('Header 2', 'healthandcare'),
								'3' => esc_html__('Header 3', 'healthandcare'),
								'4' => esc_html__('Header 4', 'healthandcare'),
								'5' => esc_html__('Header 5', 'healthandcare'),
								'6' => esc_html__('Header 6', 'healthandcare'),
							)
						),
						"style" => array(
							"title" => esc_html__("Title style", "healthandcare"),
							"desc" => esc_html__("Title style", "healthandcare"),
							"value" => "regular",
							"type" => "select",
							"options" => array(
								'regular' => esc_html__('Regular', 'healthandcare'),
								'underline' => esc_html__('Underline', 'healthandcare'),
								'divider' => esc_html__('Divider', 'healthandcare'),
								'iconed' => esc_html__('With icon (image)', 'healthandcare')
							)
						),
						"align" => array(
							"title" => esc_html__("Alignment", "healthandcare"),
							"desc" => esc_html__("Title text alignment", "healthandcare"),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						), 
						"font_size" => array(
							"title" => esc_html__("Font_size", "healthandcare"),
							"desc" => esc_html__("Custom font size. If empty - use theme default", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"font_weight" => array(
							"title" => esc_html__("Font weight", "healthandcare"),
							"desc" => esc_html__("Custom font weight. If empty or inherit - use theme default", "healthandcare"),
							"value" => "",
							"type" => "select",
							"size" => "medium",
							"options" => array(
								'inherit' => esc_html__('Default', 'healthandcare'),
								'100' => esc_html__('Thin (100)', 'healthandcare'),
								'300' => esc_html__('Light (300)', 'healthandcare'),
								'400' => esc_html__('Normal (400)', 'healthandcare'),
								'600' => esc_html__('Semibold (600)', 'healthandcare'),
								'700' => esc_html__('Bold (700)', 'healthandcare'),
								'900' => esc_html__('Black (900)', 'healthandcare')
							)
						),
						"color" => array(
							"title" => esc_html__("Title color", "healthandcare"),
							"desc" => esc_html__("Select color for the title", "healthandcare"),
							"value" => "",
							"type" => "color"
						),
						"icon" => array(
							"title" => esc_html__('Title font icon',  'healthandcare'),
							"desc" => esc_html__("Select font icon for the title from Fontello icons set (if style=iconed)",  'healthandcare'),
							"dependency" => array(
								'style' => array('iconed')
							),
							"value" => "",
							"type" => "icons",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
						),
						"image" => array(
							"title" => esc_html__('or image icon',  'healthandcare'),
							"desc" => esc_html__("Select image icon for the title instead icon above (if style=iconed)",  'healthandcare'),
							"dependency" => array(
								'style' => array('iconed')
							),
							"value" => "",
							"type" => "images",
							"size" => "small",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['images']
						),
						"picture" => array(
							"title" => esc_html__('or URL for image file', "healthandcare"),
							"desc" => esc_html__("Select or upload image or write URL from other site (if style=iconed)", "healthandcare"),
							"dependency" => array(
								'style' => array('iconed')
							),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"image_size" => array(
							"title" => esc_html__('Image (picture) size', "healthandcare"),
							"desc" => esc_html__("Select image (picture) size (if style='iconed')", "healthandcare"),
							"dependency" => array(
								'style' => array('iconed')
							),
							"value" => "small",
							"type" => "checklist",
							"options" => array(
								'small' => esc_html__('Small', 'healthandcare'),
								'medium' => esc_html__('Medium', 'healthandcare'),
								'large' => esc_html__('Large', 'healthandcare')
							)
						),
						"position" => array(
							"title" => esc_html__('Icon (image) position', "healthandcare"),
							"desc" => esc_html__("Select icon (image) position (if style=iconed)", "healthandcare"),
							"dependency" => array(
								'style' => array('iconed')
							),
							"value" => "left",
							"type" => "checklist",
							"options" => array(
								'top' => esc_html__('Top', 'healthandcare'),
								'left' => esc_html__('Left', 'healthandcare')
							)
						),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
			
				// Toggles
				"trx_toggles" => array(
					"title" => esc_html__("Toggles", "healthandcare"),
					"desc" => esc_html__("Toggles items", "healthandcare"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"style" => array(
							"title" => esc_html__("Toggles style", "healthandcare"),
							"desc" => esc_html__("Select style for display toggles", "healthandcare"),
							"value" => 1,
							"options" => healthandcare_get_list_styles(1, 2),
							"type" => "radio"
						),
						"counter" => array(
							"title" => esc_html__("Counter", "healthandcare"),
							"desc" => esc_html__("Display counter before each toggles title", "healthandcare"),
							"value" => "off",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['on_off']
						),
						"icon_closed" => array(
							"title" => esc_html__("Icon while closed",  'healthandcare'),
							"desc" => esc_html__('Select icon for the closed toggles item from Fontello icons set',  'healthandcare'),
							"value" => "",
							"type" => "icons",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
						),
						"icon_opened" => array(
							"title" => esc_html__("Icon while opened",  'healthandcare'),
							"desc" => esc_html__('Select icon for the opened toggles item from Fontello icons set',  'healthandcare'),
							"value" => "",
							"type" => "icons",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
						),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_toggles_item",
						"title" => esc_html__("Toggles item", "healthandcare"),
						"desc" => esc_html__("Toggles item", "healthandcare"),
						"container" => true,
						"params" => array(
							"title" => array(
								"title" => esc_html__("Toggles item title", "healthandcare"),
								"desc" => esc_html__("Title for current toggles item", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"open" => array(
								"title" => esc_html__("Open on show", "healthandcare"),
								"desc" => esc_html__("Open current toggles item on show", "healthandcare"),
								"value" => "no",
								"type" => "switch",
								"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
							),
							"icon_closed" => array(
								"title" => esc_html__("Icon while closed",  'healthandcare'),
								"desc" => esc_html__('Select icon for the closed toggles item from Fontello icons set',  'healthandcare'),
								"value" => "",
								"type" => "icons",
								"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
							),
							"icon_opened" => array(
								"title" => esc_html__("Icon while opened",  'healthandcare'),
								"desc" => esc_html__('Select icon for the opened toggles item from Fontello icons set',  'healthandcare'),
								"value" => "",
								"type" => "icons",
								"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
							),
							"_content_" => array(
								"title" => esc_html__("Toggles item content", "healthandcare"),
								"desc" => esc_html__("Current toggles item content", "healthandcare"),
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
							"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
							"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
						)
					)
				),
			
			
			
			
			
				// Tooltip
				"trx_tooltip" => array(
					"title" => esc_html__("Tooltip", "healthandcare"),
					"desc" => esc_html__("Create tooltip for selected text", "healthandcare"),
					"decorate" => false,
					"container" => true,
					"params" => array(
						"title" => array(
							"title" => esc_html__("Title", "healthandcare"),
							"desc" => esc_html__("Tooltip title (required)", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"_content_" => array(
							"title" => esc_html__("Tipped content", "healthandcare"),
							"desc" => esc_html__("Highlighted content with tooltip", "healthandcare"),
							"divider" => true,
							"rows" => 4,
							"value" => "",
							"type" => "textarea"
						),
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Twitter
				"trx_twitter" => array(
					"title" => esc_html__("Twitter", "healthandcare"),
					"desc" => esc_html__("Insert twitter feed into post (page)", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"user" => array(
							"title" => esc_html__("Twitter Username", "healthandcare"),
							"desc" => esc_html__("Your username in the twitter account. If empty - get it from Theme Options.", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"consumer_key" => array(
							"title" => esc_html__("Consumer Key", "healthandcare"),
							"desc" => esc_html__("Consumer Key from the twitter account", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"consumer_secret" => array(
							"title" => esc_html__("Consumer Secret", "healthandcare"),
							"desc" => esc_html__("Consumer Secret from the twitter account", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"token_key" => array(
							"title" => esc_html__("Token Key", "healthandcare"),
							"desc" => esc_html__("Token Key from the twitter account", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"token_secret" => array(
							"title" => esc_html__("Token Secret", "healthandcare"),
							"desc" => esc_html__("Token Secret from the twitter account", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"count" => array(
							"title" => esc_html__("Tweets number", "healthandcare"),
							"desc" => esc_html__("Tweets number to show", "healthandcare"),
							"divider" => true,
							"value" => 3,
							"max" => 20,
							"min" => 1,
							"type" => "spinner"
						),
						"controls" => array(
							"title" => esc_html__("Show arrows", "healthandcare"),
							"desc" => esc_html__("Show control buttons", "healthandcare"),
							"value" => "yes",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"interval" => array(
							"title" => esc_html__("Tweets change interval", "healthandcare"),
							"desc" => esc_html__("Tweets change interval (in milliseconds: 1000ms = 1s)", "healthandcare"),
							"value" => 7000,
							"step" => 500,
							"min" => 0,
							"type" => "spinner"
						),
						"align" => array(
							"title" => esc_html__("Alignment", "healthandcare"),
							"desc" => esc_html__("Alignment of the tweets block", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						),
						"autoheight" => array(
							"title" => esc_html__("Autoheight", "healthandcare"),
							"desc" => esc_html__("Change whole slider's height (make it equal current slide's height)", "healthandcare"),
							"value" => "yes",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"scheme" => array(
							"title" => esc_html__("Color scheme", "healthandcare"),
							"desc" => esc_html__("Select color scheme for this block", "healthandcare"),
							"value" => "",
							"type" => "checklist",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['schemes']
						),
						"bg_color" => array(
							"title" => esc_html__("Background color", "healthandcare"),
							"desc" => esc_html__("Any background color for this section", "healthandcare"),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => esc_html__("Background image URL", "healthandcare"),
							"desc" => esc_html__("Select or upload image or write URL from other site for the background", "healthandcare"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_overlay" => array(
							"title" => esc_html__("Overlay", "healthandcare"),
							"desc" => esc_html__("Overlay color opacity (from 0.0 to 1.0)", "healthandcare"),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => esc_html__("Texture", "healthandcare"),
							"desc" => esc_html__("Predefined texture style from 1 to 11. 0 - without texture.", "healthandcare"),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
				// Video
				"trx_video" => array(
					"title" => esc_html__("Video", "healthandcare"),
					"desc" => esc_html__("Insert video player", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"url" => array(
							"title" => esc_html__("URL for video file", "healthandcare"),
							"desc" => esc_html__("Select video from media library or paste URL for video file from other site", "healthandcare"),
							"readonly" => false,
							"value" => "",
							"type" => "media",
							"before" => array(
								'title' => esc_html__('Choose video', 'healthandcare'),
								'action' => 'media_upload',
								'type' => 'video',
								'multiple' => false,
								'linked_field' => '',
								'captions' => array( 	
									'choose' => esc_html__('Choose video file', 'healthandcare'),
									'update' => esc_html__('Select video file', 'healthandcare')
								)
							),
							"after" => array(
								'icon' => 'icon-cancel',
								'action' => 'media_reset'
							)
						),
						"ratio" => array(
							"title" => esc_html__("Ratio", "healthandcare"),
							"desc" => esc_html__("Ratio of the video", "healthandcare"),
							"value" => "16:9",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								"16:9" => esc_html__("16:9", 'healthandcare'),
								"4:3" => esc_html__("4:3", 'healthandcare')
							)
						),
						"autoplay" => array(
							"title" => esc_html__("Autoplay video", "healthandcare"),
							"desc" => esc_html__("Autoplay video on page load", "healthandcare"),
							"value" => "off",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['on_off']
						),
						"align" => array(
							"title" => esc_html__("Align", "healthandcare"),
							"desc" => esc_html__("Select block alignment", "healthandcare"),
							"value" => "none",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						),
						"image" => array(
							"title" => esc_html__("Cover image", "healthandcare"),
							"desc" => esc_html__("Select or upload image or write URL from other site for video preview", "healthandcare"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_image" => array(
							"title" => esc_html__("Background image", "healthandcare"),
							"desc" => esc_html__("Select or upload image or write URL from other site for video background. Attention! If you use background image - specify paddings below from background margins to video block in percents!", "healthandcare"),
							"divider" => true,
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_top" => array(
							"title" => esc_html__("Top offset", "healthandcare"),
							"desc" => esc_html__("Top offset (padding) inside background image to video block (in percent). For example: 3%", "healthandcare"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_bottom" => array(
							"title" => esc_html__("Bottom offset", "healthandcare"),
							"desc" => esc_html__("Bottom offset (padding) inside background image to video block (in percent). For example: 3%", "healthandcare"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_left" => array(
							"title" => esc_html__("Left offset", "healthandcare"),
							"desc" => esc_html__("Left offset (padding) inside background image to video block (in percent). For example: 20%", "healthandcare"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_right" => array(
							"title" => esc_html__("Right offset", "healthandcare"),
							"desc" => esc_html__("Right offset (padding) inside background image to video block (in percent). For example: 12%", "healthandcare"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				),
			
			
			
			
				// Zoom
				"trx_zoom" => array(
					"title" => esc_html__("Zoom", "healthandcare"),
					"desc" => esc_html__("Insert the image with zoom/lens effect", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"effect" => array(
							"title" => esc_html__("Effect", "healthandcare"),
							"desc" => esc_html__("Select effect to display overlapping image", "healthandcare"),
							"value" => "lens",
							"size" => "medium",
							"type" => "switch",
							"options" => array(
								"lens" => esc_html__('Lens', 'healthandcare'),
								"zoom" => esc_html__('Zoom', 'healthandcare')
							)
						),
						"url" => array(
							"title" => esc_html__("Main image", "healthandcare"),
							"desc" => esc_html__("Select or upload main image", "healthandcare"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"over" => array(
							"title" => esc_html__("Overlaping image", "healthandcare"),
							"desc" => esc_html__("Select or upload overlaping image", "healthandcare"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"align" => array(
							"title" => esc_html__("Float zoom", "healthandcare"),
							"desc" => esc_html__("Float zoom to left or right side", "healthandcare"),
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['float']
						), 
						"bg_image" => array(
							"title" => esc_html__("Background image", "healthandcare"),
							"desc" => esc_html__("Select or upload image or write URL from other site for zoom block background. Attention! If you use background image - specify paddings below from background margins to zoom block in percents!", "healthandcare"),
							"divider" => true,
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_top" => array(
							"title" => esc_html__("Top offset", "healthandcare"),
							"desc" => esc_html__("Top offset (padding) inside background image to zoom block (in percent). For example: 3%", "healthandcare"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_bottom" => array(
							"title" => esc_html__("Bottom offset", "healthandcare"),
							"desc" => esc_html__("Bottom offset (padding) inside background image to zoom block (in percent). For example: 3%", "healthandcare"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_left" => array(
							"title" => esc_html__("Left offset", "healthandcare"),
							"desc" => esc_html__("Left offset (padding) inside background image to zoom block (in percent). For example: 20%", "healthandcare"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"bg_right" => array(
							"title" => esc_html__("Right offset", "healthandcare"),
							"desc" => esc_html__("Right offset (padding) inside background image to zoom block (in percent). For example: 12%", "healthandcare"),
							"dependency" => array(
								'bg_image' => array('not_empty')
							),
							"value" => "",
							"type" => "text"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					)
				)
			);
	
			// Woocommerce Shortcodes list
			//------------------------------------------------------------------
			if (healthandcare_exists_woocommerce()) {
				
				// WooCommerce - Cart
				$HEALTHANDCARE_GLOBALS['shortcodes']["woocommerce_cart"] = array(
					"title" => esc_html__("Woocommerce: Cart", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: show Cart page", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array()
				);
				
				// WooCommerce - Checkout
				$HEALTHANDCARE_GLOBALS['shortcodes']["woocommerce_checkout"] = array(
					"title" => esc_html__("Woocommerce: Checkout", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: show Checkout page", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array()
				);
				
				// WooCommerce - My Account
				$HEALTHANDCARE_GLOBALS['shortcodes']["woocommerce_my_account"] = array(
					"title" => esc_html__("Woocommerce: My Account", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: show My Account page", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array()
				);
				
				// WooCommerce - Order Tracking
				$HEALTHANDCARE_GLOBALS['shortcodes']["woocommerce_order_tracking"] = array(
					"title" => esc_html__("Woocommerce: Order Tracking", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: show Order Tracking page", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array()
				);
				
				// WooCommerce - Shop Messages
				$HEALTHANDCARE_GLOBALS['shortcodes']["shop_messages"] = array(
					"title" => esc_html__("Woocommerce: Shop Messages", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: show shop messages", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array()
				);
				
				// WooCommerce - Product Page
				$HEALTHANDCARE_GLOBALS['shortcodes']["product_page"] = array(
					"title" => esc_html__("Woocommerce: Product Page", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: display single product page", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"sku" => array(
							"title" => esc_html__("SKU", "healthandcare"),
							"desc" => esc_html__("SKU code of displayed product", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"id" => array(
							"title" => esc_html__("ID", "healthandcare"),
							"desc" => esc_html__("ID of displayed product", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"posts_per_page" => array(
							"title" => esc_html__("Number", "healthandcare"),
							"desc" => esc_html__("How many products showed", "healthandcare"),
							"value" => "1",
							"min" => 1,
							"type" => "spinner"
						),
						"post_type" => array(
							"title" => esc_html__("Post type", "healthandcare"),
							"desc" => esc_html__("Post type for the WP query (leave 'product')", "healthandcare"),
							"value" => "product",
							"type" => "text"
						),
						"post_status" => array(
							"title" => esc_html__("Post status", "healthandcare"),
							"desc" => esc_html__("Display posts only with this status", "healthandcare"),
							"value" => "publish",
							"type" => "select",
							"options" => array(
								"publish" => esc_html__('Publish', 'healthandcare'),
								"protected" => esc_html__('Protected', 'healthandcare'),
								"private" => esc_html__('Private', 'healthandcare'),
								"pending" => esc_html__('Pending', 'healthandcare'),
								"draft" => esc_html__('Draft', 'healthandcare')
							)
						)
					)
				);
				
				// WooCommerce - Product
				$HEALTHANDCARE_GLOBALS['shortcodes']["product"] = array(
					"title" => esc_html__("Woocommerce: Product", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: display one product", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"sku" => array(
							"title" => esc_html__("SKU", "healthandcare"),
							"desc" => esc_html__("SKU code of displayed product", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"id" => array(
							"title" => esc_html__("ID", "healthandcare"),
							"desc" => esc_html__("ID of displayed product", "healthandcare"),
							"value" => "",
							"type" => "text"
						)
					)
				);
				
				// WooCommerce - Best Selling Products
				$HEALTHANDCARE_GLOBALS['shortcodes']["best_selling_products"] = array(
					"title" => esc_html__("Woocommerce: Best Selling Products", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: show best selling products", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => esc_html__("Number", "healthandcare"),
							"desc" => esc_html__("How many products showed", "healthandcare"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => esc_html__("Columns", "healthandcare"),
							"desc" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						)
					)
				);
				
				// WooCommerce - Recent Products
				$HEALTHANDCARE_GLOBALS['shortcodes']["recent_products"] = array(
					"title" => esc_html__("Woocommerce: Recent Products", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: show recent products", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => esc_html__("Number", "healthandcare"),
							"desc" => esc_html__("How many products showed", "healthandcare"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => esc_html__("Columns", "healthandcare"),
							"desc" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Order by", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => esc_html__('Date', 'healthandcare'),
								"title" => esc_html__('Title', 'healthandcare')
							)
						),
						"order" => array(
							"title" => esc_html__("Order", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['ordering']
						)
					)
				);
				
				// WooCommerce - Related Products
				$HEALTHANDCARE_GLOBALS['shortcodes']["related_products"] = array(
					"title" => esc_html__("Woocommerce: Related Products", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: show related products", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"posts_per_page" => array(
							"title" => esc_html__("Number", "healthandcare"),
							"desc" => esc_html__("How many products showed", "healthandcare"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => esc_html__("Columns", "healthandcare"),
							"desc" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Order by", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => esc_html__('Date', 'healthandcare'),
								"title" => esc_html__('Title', 'healthandcare')
							)
						)
					)
				);
				
				// WooCommerce - Featured Products
				$HEALTHANDCARE_GLOBALS['shortcodes']["featured_products"] = array(
					"title" => esc_html__("Woocommerce: Featured Products", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: show featured products", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => esc_html__("Number", "healthandcare"),
							"desc" => esc_html__("How many products showed", "healthandcare"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => esc_html__("Columns", "healthandcare"),
							"desc" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Order by", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => esc_html__('Date', 'healthandcare'),
								"title" => esc_html__('Title', 'healthandcare')
							)
						),
						"order" => array(
							"title" => esc_html__("Order", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['ordering']
						)
					)
				);
				
				// WooCommerce - Top Rated Products
				$HEALTHANDCARE_GLOBALS['shortcodes']["featured_products"] = array(
					"title" => esc_html__("Woocommerce: Top Rated Products", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: show top rated products", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => esc_html__("Number", "healthandcare"),
							"desc" => esc_html__("How many products showed", "healthandcare"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => esc_html__("Columns", "healthandcare"),
							"desc" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Order by", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => esc_html__('Date', 'healthandcare'),
								"title" => esc_html__('Title', 'healthandcare')
							)
						),
						"order" => array(
							"title" => esc_html__("Order", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['ordering']
						)
					)
				);
				
				// WooCommerce - Sale Products
				$HEALTHANDCARE_GLOBALS['shortcodes']["featured_products"] = array(
					"title" => esc_html__("Woocommerce: Sale Products", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: list products on sale", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => esc_html__("Number", "healthandcare"),
							"desc" => esc_html__("How many products showed", "healthandcare"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => esc_html__("Columns", "healthandcare"),
							"desc" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Order by", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => esc_html__('Date', 'healthandcare'),
								"title" => esc_html__('Title', 'healthandcare')
							)
						),
						"order" => array(
							"title" => esc_html__("Order", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['ordering']
						)
					)
				);
				
				// WooCommerce - Product Category
				$HEALTHANDCARE_GLOBALS['shortcodes']["product_category"] = array(
					"title" => esc_html__("Woocommerce: Products from category", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: list products in specified category(-ies)", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => esc_html__("Number", "healthandcare"),
							"desc" => esc_html__("How many products showed", "healthandcare"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => esc_html__("Columns", "healthandcare"),
							"desc" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Order by", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => esc_html__('Date', 'healthandcare'),
								"title" => esc_html__('Title', 'healthandcare')
							)
						),
						"order" => array(
							"title" => esc_html__("Order", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['ordering']
						),
						"category" => array(
							"title" => esc_html__("Categories", "healthandcare"),
							"desc" => esc_html__("Comma separated category slugs", "healthandcare"),
							"value" => '',
							"type" => "text"
						),
						"operator" => array(
							"title" => esc_html__("Operator", "healthandcare"),
							"desc" => esc_html__("Categories operator", "healthandcare"),
							"value" => "IN",
							"type" => "checklist",
							"size" => "medium",
							"options" => array(
								"IN" => esc_html__('IN', 'healthandcare'),
								"NOT IN" => esc_html__('NOT IN', 'healthandcare'),
								"AND" => esc_html__('AND', 'healthandcare')
							)
						)
					)
				);
				
				// WooCommerce - Products
				$HEALTHANDCARE_GLOBALS['shortcodes']["products"] = array(
					"title" => esc_html__("Woocommerce: Products", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: list all products", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"skus" => array(
							"title" => esc_html__("SKUs", "healthandcare"),
							"desc" => esc_html__("Comma separated SKU codes of products", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"ids" => array(
							"title" => esc_html__("IDs", "healthandcare"),
							"desc" => esc_html__("Comma separated ID of products", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"columns" => array(
							"title" => esc_html__("Columns", "healthandcare"),
							"desc" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Order by", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => esc_html__('Date', 'healthandcare'),
								"title" => esc_html__('Title', 'healthandcare')
							)
						),
						"order" => array(
							"title" => esc_html__("Order", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['ordering']
						)
					)
				);
				
				// WooCommerce - Product attribute
				$HEALTHANDCARE_GLOBALS['shortcodes']["product_attribute"] = array(
					"title" => esc_html__("Woocommerce: Products by Attribute", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: show products with specified attribute", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"per_page" => array(
							"title" => esc_html__("Number", "healthandcare"),
							"desc" => esc_html__("How many products showed", "healthandcare"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => esc_html__("Columns", "healthandcare"),
							"desc" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Order by", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => esc_html__('Date', 'healthandcare'),
								"title" => esc_html__('Title', 'healthandcare')
							)
						),
						"order" => array(
							"title" => esc_html__("Order", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['ordering']
						),
						"attribute" => array(
							"title" => esc_html__("Attribute", "healthandcare"),
							"desc" => esc_html__("Attribute name", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"filter" => array(
							"title" => esc_html__("Filter", "healthandcare"),
							"desc" => esc_html__("Attribute value", "healthandcare"),
							"value" => "",
							"type" => "text"
						)
					)
				);
				
				// WooCommerce - Products Categories
				$HEALTHANDCARE_GLOBALS['shortcodes']["product_categories"] = array(
					"title" => esc_html__("Woocommerce: Product Categories", "healthandcare"),
					"desc" => esc_html__("WooCommerce shortcode: show categories with products", "healthandcare"),
					"decorate" => false,
					"container" => false,
					"params" => array(
						"number" => array(
							"title" => esc_html__("Number", "healthandcare"),
							"desc" => esc_html__("How many categories showed", "healthandcare"),
							"value" => 4,
							"min" => 1,
							"type" => "spinner"
						),
						"columns" => array(
							"title" => esc_html__("Columns", "healthandcare"),
							"desc" => esc_html__("How many columns per row use for categories output", "healthandcare"),
							"value" => 4,
							"min" => 2,
							"max" => 4,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Order by", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "date",
							"type" => "select",
							"options" => array(
								"date" => esc_html__('Date', 'healthandcare'),
								"title" => esc_html__('Title', 'healthandcare')
							)
						),
						"order" => array(
							"title" => esc_html__("Order", "healthandcare"),
							"desc" => esc_html__("Sorting order for products output", "healthandcare"),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['ordering']
						),
						"parent" => array(
							"title" => esc_html__("Parent", "healthandcare"),
							"desc" => esc_html__("Parent category slug", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"ids" => array(
							"title" => esc_html__("IDs", "healthandcare"),
							"desc" => esc_html__("Comma separated ID of products", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"hide_empty" => array(
							"title" => esc_html__("Hide empty", "healthandcare"),
							"desc" => esc_html__("Hide empty categories", "healthandcare"),
							"value" => "yes",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						)
					)
				);

			}
			
			do_action('healthandcare_action_shortcodes_list');

		}
	}
}
?>