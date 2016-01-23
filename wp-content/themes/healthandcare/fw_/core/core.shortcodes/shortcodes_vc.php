<?php

// Width and height params
if ( !function_exists( 'healthandcare_vc_width' ) ) {
	function healthandcare_vc_width($w='') {
		return array(
			"param_name" => "width",
			"heading" => esc_html__("Width", "healthandcare"),
			"description" => esc_html__("Width (in pixels or percent) of the current element", "healthandcare"),
			"group" => esc_html__('Size &amp; Margins', 'healthandcare'),
			"value" => $w,
			"type" => "textfield"
		);
	}
}
if ( !function_exists( 'healthandcare_vc_height' ) ) {
	function healthandcare_vc_height($h='') {
		return array(
			"param_name" => "height",
			"heading" => esc_html__("Height", "healthandcare"),
			"description" => esc_html__("Height (only in pixels) of the current element", "healthandcare"),
			"group" => esc_html__('Size &amp; Margins', 'healthandcare'),
			"value" => $h,
			"type" => "textfield"
		);
	}
}

// Load scripts and styles for VC support
if ( !function_exists( 'healthandcare_shortcodes_vc_scripts_admin' ) ) {
	//add_action( 'admin_enqueue_scripts', 'healthandcare_shortcodes_vc_scripts_admin' );
	function healthandcare_shortcodes_vc_scripts_admin() {
		// Include CSS 
		healthandcare_enqueue_style ( 'shortcodes_vc-style', healthandcare_get_file_url('core/core.shortcodes/shortcodes_vc_admin.css'), array(), null );
		// Include JS
		healthandcare_enqueue_script( 'shortcodes_vc-script', healthandcare_get_file_url('core/core.shortcodes/shortcodes_vc_admin.js'), array(), null, true );
	}
}

// Load scripts and styles for VC support
if ( !function_exists( 'healthandcare_shortcodes_vc_scripts_front' ) ) {
	//add_action( 'wp_enqueue_scripts', 'healthandcare_shortcodes_vc_scripts_front' );
	function healthandcare_shortcodes_vc_scripts_front() {
		if (healthandcare_vc_is_frontend()) {
			// Include CSS 
			healthandcare_enqueue_style ( 'shortcodes_vc-style', healthandcare_get_file_url('core/core.shortcodes/shortcodes_vc_front.css'), array(), null );
			// Include JS
			healthandcare_enqueue_script( 'shortcodes_vc-script', healthandcare_get_file_url('core/core.shortcodes/shortcodes_vc_front.js'), array(), null, true );
		}
	}
}

// Add init script into shortcodes output in VC frontend editor
if ( !function_exists( 'healthandcare_shortcodes_vc_add_init_script' ) ) {
	//add_filter('healthandcare_shortcode_output', 'healthandcare_shortcodes_vc_add_init_script', 10, 4);
	function healthandcare_shortcodes_vc_add_init_script($output, $tag='', $atts=array(), $content='') {
		if ( (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') && (isset($_POST['action']) && $_POST['action']=='vc_load_shortcode')
				&& ( isset($_POST['shortcodes'][0]['tag']) && $_POST['shortcodes'][0]['tag']==$tag )
		) {
			if (healthandcare_strpos($output, 'healthandcare_vc_init_shortcodes')===false) {
				$id = "healthandcare_vc_init_shortcodes_".str_replace('.', '', mt_rand());
				$output .= '
					<script id="'.esc_attr($id).'">
						try {
							healthandcare_init_post_formats();
							healthandcare_init_shortcodes(jQuery("body").eq(0));
							healthandcare_scroll_actions();
						} catch (e) { };
					</script>
				';
			}
		}
		return $output;
	}
}


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'healthandcare_shortcodes_vc_theme_setup' ) ) {
	//if ( healthandcare_vc_is_frontend() )
	if ( (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') || (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline') )
		add_action( 'healthandcare_action_before_init_theme', 'healthandcare_shortcodes_vc_theme_setup', 20 );
	else
		add_action( 'healthandcare_action_after_init_theme', 'healthandcare_shortcodes_vc_theme_setup' );
	function healthandcare_shortcodes_vc_theme_setup() {
		if (healthandcare_shortcodes_is_used()) {
			// Set VC as main editor for the theme
			vc_set_as_theme( true );
			
			// Enable VC on follow post types
			vc_set_default_editor_post_types( array('page', 'team') );
			
			// Disable frontend editor
//			vc_disable_frontend();

			// Load scripts and styles for VC support
			add_action( 'wp_enqueue_scripts',		'healthandcare_shortcodes_vc_scripts_front');
			add_action( 'admin_enqueue_scripts',	'healthandcare_shortcodes_vc_scripts_admin' );

			// Add init script into shortcodes output in VC frontend editor
			add_filter('healthandcare_shortcode_output', 'healthandcare_shortcodes_vc_add_init_script', 10, 4);

			// Remove standard VC shortcodes
			vc_remove_element("vc_button");
			vc_remove_element("vc_posts_slider");
			vc_remove_element("vc_gmaps");
			vc_remove_element("vc_teaser_grid");
			vc_remove_element("vc_progress_bar");
			vc_remove_element("vc_facebook");
			vc_remove_element("vc_tweetmeme");
			vc_remove_element("vc_googleplus");
			vc_remove_element("vc_facebook");
			vc_remove_element("vc_pinterest");
			vc_remove_element("vc_message");
			vc_remove_element("vc_posts_grid");
			vc_remove_element("vc_carousel");
			vc_remove_element("vc_flickr");
			vc_remove_element("vc_tour");
			vc_remove_element("vc_separator");
			vc_remove_element("vc_single_image");
			vc_remove_element("vc_cta_button");
//			vc_remove_element("vc_accordion");
//			vc_remove_element("vc_accordion_tab");
			vc_remove_element("vc_toggle");
			vc_remove_element("vc_tabs");
			vc_remove_element("vc_tab");
			vc_remove_element("vc_images_carousel");
			
			// Remove standard WP widgets
			vc_remove_element("vc_wp_archives");
			vc_remove_element("vc_wp_calendar");
			vc_remove_element("vc_wp_categories");
			vc_remove_element("vc_wp_custommenu");
			vc_remove_element("vc_wp_links");
			vc_remove_element("vc_wp_meta");
			vc_remove_element("vc_wp_pages");
			vc_remove_element("vc_wp_posts");
			vc_remove_element("vc_wp_recentcomments");
			vc_remove_element("vc_wp_rss");
			vc_remove_element("vc_wp_search");
			vc_remove_element("vc_wp_tagcloud");
			vc_remove_element("vc_wp_text");
			
			global $HEALTHANDCARE_GLOBALS;
			
			$HEALTHANDCARE_GLOBALS['vc_params'] = array(
				
				// Common arrays and strings
				'category' => esc_html__("HealthandCARE shortcodes", "healthandcare"),
			
				// Current element id
				'id' => array(
					"param_name" => "id",
					"heading" => esc_html__("Element ID", "healthandcare"),
					"description" => esc_html__("ID for current element", "healthandcare"),
					"group" => esc_html__('ID &amp; Class', 'healthandcare'),
					"value" => "",
					"type" => "textfield"
				),
			
				// Current element class
				'class' => array(
					"param_name" => "class",
					"heading" => esc_html__("Element CSS class", "healthandcare"),
					"description" => esc_html__("CSS class for current element", "healthandcare"),
					"group" => esc_html__('ID &amp; Class', 'healthandcare'),
					"value" => "",
					"type" => "textfield"
				),

				// Current element animation
				'animation' => array(
					"param_name" => "animation",
					"heading" => esc_html__("Animation", "healthandcare"),
					"description" => esc_html__("Select animation while object enter in the visible area of page", "healthandcare"),
					"group" => esc_html__('ID &amp; Class', 'healthandcare'),
					"class" => "",
					"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['animations']),
					"type" => "dropdown"
				),
			
				// Current element style
				'css' => array(
					"param_name" => "css",
					"heading" => esc_html__("CSS styles", "healthandcare"),
					"description" => esc_html__("Any additional CSS rules (if need)", "healthandcare"),
					"group" => esc_html__('ID &amp; Class', 'healthandcare'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
			
				// Margins params
				'margin_top' => array(
					"param_name" => "top",
					"heading" => esc_html__("Top margin", "healthandcare"),
					"description" => esc_html__("Top margin (in pixels).", "healthandcare"),
					"group" => esc_html__('Size &amp; Margins', 'healthandcare'),
					"value" => "",
					"type" => "textfield"
				),
			
				'margin_bottom' => array(
					"param_name" => "bottom",
					"heading" => esc_html__("Bottom margin", "healthandcare"),
					"description" => esc_html__("Bottom margin (in pixels).", "healthandcare"),
					"group" => esc_html__('Size &amp; Margins', 'healthandcare'),
					"value" => "",
					"type" => "textfield"
				),
			
				'margin_left' => array(
					"param_name" => "left",
					"heading" => esc_html__("Left margin", "healthandcare"),
					"description" => esc_html__("Left margin (in pixels).", "healthandcare"),
					"group" => esc_html__('Size &amp; Margins', 'healthandcare'),
					"value" => "",
					"type" => "textfield"
				),
				
				'margin_right' => array(
					"param_name" => "right",
					"heading" => esc_html__("Right margin", "healthandcare"),
					"description" => esc_html__("Right margin (in pixels).", "healthandcare"),
					"group" => esc_html__('Size &amp; Margins', 'healthandcare'),
					"value" => "",
					"type" => "textfield"
				)
			);
	
	
	
			// Accordion
			//-------------------------------------------------------------------------------------
			vc_map( array(
				"base" => "trx_accordion",
				"name" => esc_html__("Accordion", "healthandcare"),
				"description" => esc_html__("Accordion items", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_accordion',
				"class" => "trx_sc_collection trx_sc_accordion",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => false,
				"as_parent" => array('only' => 'trx_accordion_item'),	// Use only|except attributes to limit child shortcodes (separate multiple values with comma)
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Accordion style", "healthandcare"),
						"description" => esc_html__("Select style for display accordion", "healthandcare"),
						"class" => "",
						"admin_label" => true,
						"value" => array_flip(healthandcare_get_list_styles(1, 2)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "counter",
						"heading" => esc_html__("Counter", "healthandcare"),
						"description" => esc_html__("Display counter before each accordion title", "healthandcare"),
						"class" => "",
						"value" => array("Add item numbers before each element" => "on" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "initial",
						"heading" => esc_html__("Initially opened item", "healthandcare"),
						"description" => esc_html__("Number of initially opened item", "healthandcare"),
						"class" => "",
						"value" => 1,
						"type" => "textfield"
					),
					array(
						"param_name" => "icon_closed",
						"heading" => esc_html__("Icon while closed", "healthandcare"),
						"description" => esc_html__("Select icon for the closed accordion item from Fontello icons set", "healthandcare"),
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "icon_opened",
						"heading" => esc_html__("Icon while opened", "healthandcare"),
						"description" => esc_html__("Select icon for the opened accordion item from Fontello icons set", "healthandcare"),
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
				'default_content' => '
					[trx_accordion_item title="' . esc_html__( 'Item 1 title', 'healthandcare' ) . '"][/trx_accordion_item]
					[trx_accordion_item title="' . esc_html__( 'Item 2 title', 'healthandcare' ) . '"][/trx_accordion_item]
				',
				"custom_markup" => '
					<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
						%content%
					</div>
					<div class="tab_controls">
						<button class="add_tab" title="'.esc_html__("Add item", "healthandcare").'">'.esc_html__("Add item", "healthandcare").'</button>
					</div>
				',
				'js_view' => 'VcTrxAccordionView'
			) );
			
			
			vc_map( array(
				"base" => "trx_accordion_item",
				"name" => esc_html__("Accordion item", "healthandcare"),
				"description" => esc_html__("Inner accordion item", "healthandcare"),
				"show_settings_on_create" => true,
				"content_element" => true,
				"is_container" => true,
				'icon' => 'icon_trx_accordion_item',
				"as_child" => array('only' => 'trx_accordion'), 	// Use only|except attributes to limit parent (separate multiple values with comma)
				"as_parent" => array('except' => 'trx_accordion'),
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", "healthandcare"),
						"description" => esc_html__("Title for current accordion item", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
                    array(
                        "param_name" => "icon_before_title",
                        "heading" => esc_html__("Icon before title", "healthandcare"),
                        "description" => esc_html__("Select icon for before title accordion item from Fontello icons set", "healthandcare"),
                        "class" => "",
                        "value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
                        "type" => "dropdown"
                    ),
					array(
						"param_name" => "icon_closed",
						"heading" => esc_html__("Icon while closed", "healthandcare"),
						"description" => esc_html__("Select icon for the closed accordion item from Fontello icons set", "healthandcare"),
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "icon_opened",
						"heading" => esc_html__("Icon while opened", "healthandcare"),
						"description" => esc_html__("Select icon for the opened accordion item from Fontello icons set", "healthandcare"),
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css']
				),
			  'js_view' => 'VcTrxAccordionTabView'
			) );

			class WPBakeryShortCode_Trx_Accordion extends HEALTHANDCARE_VC_ShortCodeAccordion {}
			class WPBakeryShortCode_Trx_Accordion_Item extends HEALTHANDCARE_VC_ShortCodeAccordionItem {}
			
			
			
			
			
			
			// Anchor
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_anchor",
				"name" => esc_html__("Anchor", "healthandcare"),
				"description" => esc_html__("Insert anchor for the TOC (table of content)", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_anchor',
				"class" => "trx_sc_single trx_sc_anchor",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "icon",
						"heading" => esc_html__("Anchor's icon", "healthandcare"),
						"description" => esc_html__("Select icon for the anchor from Fontello icons set", "healthandcare"),
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Short title", "healthandcare"),
						"description" => esc_html__("Short title of the anchor (for the table of content)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => esc_html__("Long description", "healthandcare"),
						"description" => __("Description for the popup (then hover on the icon). You can use:<br>'{{' and '}}' - to make the text italic,<br>'((' and '))' - to make the text bold,<br>'||' - to insert line break", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "url",
						"heading" => esc_html__("External URL", "healthandcare"),
						"description" => esc_html__("External URL for this TOC item", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "separator",
						"heading" => esc_html__("Add separator", "healthandcare"),
						"description" => esc_html__("Add separator under item in the TOC", "healthandcare"),
						"class" => "",
						"value" => array("Add separator" => "yes" ),
						"type" => "checkbox"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id']
				),
			) );
			
			class WPBakeryShortCode_Trx_Anchor extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			// Audio
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_audio",
				"name" => esc_html__("Audio", "healthandcare"),
				"description" => esc_html__("Insert audio player", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_audio',
				"class" => "trx_sc_single trx_sc_audio",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "url",
						"heading" => esc_html__("URL for audio file", "healthandcare"),
						"description" => esc_html__("Put here URL for audio file", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "image",
						"heading" => esc_html__("Cover image", "healthandcare"),
						"description" => esc_html__("Select or upload image or write URL from other site for audio cover", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", "healthandcare"),
						"description" => esc_html__("Title of the audio file", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "author",
						"heading" => esc_html__("Author", "healthandcare"),
						"description" => esc_html__("Author of the audio file", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "controls",
						"heading" => esc_html__("Controls", "healthandcare"),
						"description" => esc_html__("Show/hide controls", "healthandcare"),
						"class" => "",
						"value" => array("Hide controls" => "hide" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "autoplay",
						"heading" => esc_html__("Autoplay", "healthandcare"),
						"description" => esc_html__("Autoplay audio on page load", "healthandcare"),
						"class" => "",
						"value" => array("Autoplay" => "on" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Select block alignment", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
			) );
			
			class WPBakeryShortCode_Trx_Audio extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Block
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_block",
				"name" => esc_html__("Block container", "healthandcare"),
				"description" => esc_html__("Container for any block ([section] analog - to enable nesting)", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_block',
				"class" => "trx_sc_collection trx_sc_block",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "dedicated",
						"heading" => esc_html__("Dedicated", "healthandcare"),
						"description" => esc_html__("Use this block as dedicated content - show it before post title on single page", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array(esc_html__('Use as dedicated content', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Select block alignment", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns emulation", "healthandcare"),
						"description" => esc_html__("Select width for columns emulation", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['columns']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "pan",
						"heading" => esc_html__("Use pan effect", "healthandcare"),
						"description" => esc_html__("Use pan effect to show section content", "healthandcare"),
						"group" => esc_html__('Scroll', 'healthandcare'),
						"class" => "",
						"value" => array(esc_html__('Content scroller', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "scroll",
						"heading" => esc_html__("Use scroller", "healthandcare"),
						"description" => esc_html__("Use scroller to show section content", "healthandcare"),
						"group" => esc_html__('Scroll', 'healthandcare'),
						"admin_label" => true,
						"class" => "",
						"value" => array(esc_html__('Content scroller', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "scroll_dir",
						"heading" => esc_html__("Scroll direction", "healthandcare"),
						"description" => esc_html__("Scroll direction (if Use scroller = yes)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"group" => esc_html__('Scroll', 'healthandcare'),
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['dir']),
						'dependency' => array(
							'element' => 'scroll',
							'not_empty' => true
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "scroll_controls",
						"heading" => esc_html__("Scroll controls", "healthandcare"),
						"description" => esc_html__("Show scroll controls (if Use scroller = yes)", "healthandcare"),
						"class" => "",
						"group" => esc_html__('Scroll', 'healthandcare'),
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['dir']),
						'dependency' => array(
							'element' => 'scroll',
							'not_empty' => true
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "scheme",
						"heading" => esc_html__("Color scheme", "healthandcare"),
						"description" => esc_html__("Select color scheme for this block", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['schemes']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => esc_html__("Fore color", "healthandcare"),
						"description" => esc_html__("Any color for objects in this section", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => esc_html__("Background color", "healthandcare"),
						"description" => esc_html__("Any background color for this section", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_image",
						"heading" => esc_html__("Background image URL", "healthandcare"),
						"description" => esc_html__("Select background image from library for this section", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_overlay",
						"heading" => esc_html__("Overlay", "healthandcare"),
						"description" => esc_html__("Overlay color opacity (from 0.0 to 1.0)", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_texture",
						"heading" => esc_html__("Texture", "healthandcare"),
						"description" => esc_html__("Texture style from 1 to 11. Empty or 0 - without texture.", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "font_size",
						"heading" => esc_html__("Font size", "healthandcare"),
						"description" => esc_html__("Font size of the text (default - in pixels, allows any CSS units of measure)", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "font_weight",
						"heading" => esc_html__("Font weight", "healthandcare"),
						"description" => esc_html__("Font weight of the text", "healthandcare"),
						"class" => "",
						"value" => array(
							esc_html__('Default', 'healthandcare') => 'inherit',
							esc_html__('Thin (100)', 'healthandcare') => '100',
							esc_html__('Light (300)', 'healthandcare') => '300',
							esc_html__('Normal (400)', 'healthandcare') => '400',
							esc_html__('Bold (700)', 'healthandcare') => '700'
						),
						"type" => "dropdown"
					),
					/*
					array(
						"param_name" => "content",
						"heading" => esc_html__("Container content", "healthandcare"),
						"description" => esc_html__("Content for section container", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Block extends HEALTHANDCARE_VC_ShortCodeCollection {}
			
			
			
			
			
			
			// Blogger
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_blogger",
				"name" => esc_html__("Blogger", "healthandcare"),
				"description" => esc_html__("Insert posts (pages) in many styles from desired categories or directly from ids", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_blogger',
				"class" => "trx_sc_single trx_sc_blogger",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Output style", "healthandcare"),
						"description" => esc_html__("Select desired style for posts output", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['blogger_styles']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "filters",
						"heading" => esc_html__("Show filters", "healthandcare"),
						"description" => esc_html__("Use post's tags or categories as filter buttons", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['filters']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "hover",
						"heading" => esc_html__("Hover effect", "healthandcare"),
						"description" => esc_html__("Select hover effect (only if style=Portfolio)", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['hovers']),
						'dependency' => array(
							'element' => 'style',
							'value' => array('portfolio_2','portfolio_3','portfolio_4','grid_2','grid_3','grid_4','square_2','square_3','square_4','short_2','short_3','short_4','colored_2','colored_3','colored_4')
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "hover_dir",
						"heading" => esc_html__("Hover direction", "healthandcare"),
						"description" => esc_html__("Select hover direction (only if style=Portfolio and hover=Circle|Square)", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['hovers_dir']),
						'dependency' => array(
							'element' => 'style',
							'value' => array('portfolio_2','portfolio_3','portfolio_4','grid_2','grid_3','grid_4','square_2','square_3','square_4','short_2','short_3','short_4','colored_2','colored_3','colored_4')
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "location",
						"heading" => esc_html__("Dedicated content location", "healthandcare"),
						"description" => esc_html__("Select position for dedicated content (only for style=excerpt)", "healthandcare"),
						"class" => "",
						'dependency' => array(
							'element' => 'style',
							'value' => array('excerpt')
						),
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['locations']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "dir",
						"heading" => esc_html__("Posts direction", "healthandcare"),
						"description" => esc_html__("Display posts in horizontal or vertical direction", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"std" => "horizontal",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['dir']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "rating",
						"heading" => esc_html__("Show rating stars", "healthandcare"),
						"description" => esc_html__("Show rating stars under post's header", "healthandcare"),
						"group" => esc_html__('Details', 'healthandcare'),
						"class" => "",
						"value" => array(esc_html__('Show rating', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "info",
						"heading" => esc_html__("Show post info block", "healthandcare"),
						"description" => esc_html__("Show post info block (author, date, tags, etc.)", "healthandcare"),
						"class" => "",
						"std" => 'yes',
						"value" => array(esc_html__('Show info', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "descr",
						"heading" => esc_html__("Description length", "healthandcare"),
						"description" => esc_html__("How many characters are displayed from post excerpt? If 0 - don't show description", "healthandcare"),
						"group" => esc_html__('Details', 'healthandcare'),
						"class" => "",
						"value" => 0,
						"type" => "textfield"
					),
					array(
						"param_name" => "links",
						"heading" => esc_html__("Allow links to the post", "healthandcare"),
						"description" => esc_html__("Allow links to the post from each blogger item", "healthandcare"),
						"group" => esc_html__('Details', 'healthandcare'),
						"class" => "",
						"std" => 'yes',
						"value" => array(esc_html__('Allow links', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "readmore",
						"heading" => esc_html__("More link text", "healthandcare"),
						"description" => esc_html__("Read more link text. If empty - show 'More', else - used as link text", "healthandcare"),
						"group" => esc_html__('Details', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", "healthandcare"),
						"description" => esc_html__("Title for the block", "healthandcare"),
						"admin_label" => true,
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => esc_html__("Subtitle", "healthandcare"),
						"description" => esc_html__("Subtitle for the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => esc_html__("Description", "healthandcare"),
						"description" => esc_html__("Description for the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textarea"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Button URL", "healthandcare"),
						"description" => esc_html__("Link URL for the button at the bottom of the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link_caption",
						"heading" => esc_html__("Button caption", "healthandcare"),
						"description" => esc_html__("Caption for the button at the bottom of the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "post_type",
						"heading" => esc_html__("Post type", "healthandcare"),
						"description" => esc_html__("Select post type to show", "healthandcare"),
						"group" => esc_html__('Query', 'healthandcare'),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['posts_types']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("Post IDs list", "healthandcare"),
						"description" => esc_html__("Comma separated list of posts ID. If set - parameters above are ignored!", "healthandcare"),
						"group" => esc_html__('Query', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "cat",
						"heading" => esc_html__("Categories list", "healthandcare"),
						"description" => esc_html__("Select category. If empty - show posts from any category or from IDs list", "healthandcare"),
						'dependency' => array(
							'element' => 'ids',
							'is_empty' => true
						),
						"group" => esc_html__('Query', 'healthandcare'),
						"class" => "",
						"value" => array_flip(healthandcare_array_merge(array(0 => esc_html__('- Select category -', 'healthandcare')), $HEALTHANDCARE_GLOBALS['sc_params']['categories'])),
						"type" => "dropdown"
					),
					array(
						"param_name" => "count",
						"heading" => esc_html__("Total posts to show", "healthandcare"),
						"description" => esc_html__("How many posts will be displayed? If used IDs - this parameter ignored.", "healthandcare"),
						'dependency' => array(
							'element' => 'ids',
							'is_empty' => true
						),
						"admin_label" => true,
						"group" => esc_html__('Query', 'healthandcare'),
						"class" => "",
						"value" => 3,
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns number", "healthandcare"),
						"description" => esc_html__("How many columns used to display posts?", "healthandcare"),
						'dependency' => array(
							'element' => 'dir',
							'value' => 'horizontal'
						),
						"group" => esc_html__('Query', 'healthandcare'),
						"class" => "",
						"value" => 3,
						"type" => "textfield"
					),
					array(
						"param_name" => "offset",
						"heading" => esc_html__("Offset before select posts", "healthandcare"),
						"description" => esc_html__("Skip posts before select next part.", "healthandcare"),
						'dependency' => array(
							'element' => 'ids',
							'is_empty' => true
						),
						"group" => esc_html__('Query', 'healthandcare'),
						"class" => "",
						"value" => 0,
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Post order by", "healthandcare"),
						"description" => esc_html__("Select desired posts sorting method", "healthandcare"),
						"class" => "",
						"group" => esc_html__('Query', 'healthandcare'),
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['sorting']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Post order", "healthandcare"),
						"description" => esc_html__("Select desired posts order", "healthandcare"),
						"class" => "",
						"group" => esc_html__('Query', 'healthandcare'),
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "only",
						"heading" => esc_html__("Select posts only", "healthandcare"),
						"description" => esc_html__("Select posts only with reviews, videos, audios, thumbs or galleries", "healthandcare"),
						"class" => "",
						"group" => esc_html__('Query', 'healthandcare'),
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['formats']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "scroll",
						"heading" => esc_html__("Use scroller", "healthandcare"),
						"description" => esc_html__("Use scroller to show all posts", "healthandcare"),
						"group" => esc_html__('Scroll', 'healthandcare'),
						"class" => "",
						"value" => array(esc_html__('Use scroller', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "controls",
						"heading" => esc_html__("Show slider controls", "healthandcare"),
						"description" => esc_html__("Show arrows to control scroll slider", "healthandcare"),
						"group" => esc_html__('Scroll', 'healthandcare'),
						"class" => "",
						"value" => array(esc_html__('Show controls', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
			) );
			
			class WPBakeryShortCode_Trx_Blogger extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			// Br
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_br",
				"name" => esc_html__("Line break", "healthandcare"),
				"description" => esc_html__("Line break or Clear Floating", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_br',
				"class" => "trx_sc_single trx_sc_br",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "clear",
						"heading" => esc_html__("Clear floating", "healthandcare"),
						"description" => esc_html__("Select clear side (if need)", "healthandcare"),
						"class" => "",
						"value" => "",
						"value" => array(
							esc_html__('None', 'healthandcare') => 'none',
							esc_html__('Left', 'healthandcare') => 'left',
							esc_html__('Right', 'healthandcare') => 'right',
							esc_html__('Both', 'healthandcare') => 'both'
						),
						"type" => "dropdown"
					)
				)
			) );
			
			class WPBakeryShortCode_Trx_Br extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Button
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_button",
				"name" => esc_html__("Button", "healthandcare"),
				"description" => esc_html__("Button with link", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_button',
				"class" => "trx_sc_single trx_sc_button",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "content",
						"heading" => esc_html__("Caption", "healthandcare"),
						"description" => esc_html__("Button caption", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "type",
						"heading" => esc_html__("Button's shape", "healthandcare"),
						"description" => esc_html__("Select button's shape", "healthandcare"),
						"class" => "",
						"value" => array(
							esc_html__('Square', 'healthandcare') => 'square',
							esc_html__('Round', 'healthandcare') => 'round'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "style",
						"heading" => esc_html__("Button's style", "healthandcare"),
						"description" => esc_html__("Select button's style", "healthandcare"),
						"class" => "",
						"value" => array(
							esc_html__('Filled', 'healthandcare') => 'filled',
							esc_html__('Border', 'healthandcare') => 'border'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "size",
						"heading" => esc_html__("Button's size", "healthandcare"),
						"description" => esc_html__("Select button's size", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Small', 'healthandcare') => 'small',
							esc_html__('Medium', 'healthandcare') => 'medium',
							esc_html__('Large', 'healthandcare') => 'large'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "icon",
						"heading" => esc_html__("Button's icon", "healthandcare"),
						"description" => esc_html__("Select icon for the title from Fontello icons set", "healthandcare"),
						"class" => "icon-right-2",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "bg_style",
						"heading" => esc_html__("Button's color scheme", "healthandcare"),
						"description" => esc_html__("Select button's color scheme", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['button_styles']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => esc_html__("Button's text color", "healthandcare"),
						"description" => esc_html__("Any color for button's caption", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => esc_html__("Button's backcolor", "healthandcare"),
						"description" => esc_html__("Any color for button's background", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Button's alignment", "healthandcare"),
						"description" => esc_html__("Align button to left, center or right", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link URL", "healthandcare"),
						"description" => esc_html__("URL for the link on button click", "healthandcare"),
						"class" => "",
						"group" => esc_html__('Link', 'healthandcare'),
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "target",
						"heading" => esc_html__("Link target", "healthandcare"),
						"description" => esc_html__("Target for the link on button click", "healthandcare"),
						"class" => "",
						"group" => esc_html__('Link', 'healthandcare'),
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "popup",
						"heading" => esc_html__("Open link in popup", "healthandcare"),
						"description" => esc_html__("Open link target in popup window", "healthandcare"),
						"class" => "",
						"group" => esc_html__('Link', 'healthandcare'),
						"value" => array(esc_html__('Open in popup', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "rel",
						"heading" => esc_html__("Rel attribute", "healthandcare"),
						"description" => esc_html__("Rel attribute for the button's link (if need", "healthandcare"),
						"class" => "",
						"group" => esc_html__('Link', 'healthandcare'),
						"value" => "",
						"type" => "textfield"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
				'js_view' => 'VcTrxTextView'
			) );
			
			class WPBakeryShortCode_Trx_Button extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Call to Action block
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_call_to_action",
				"name" => esc_html__("Call to Action", "healthandcare"),
				"description" => esc_html__("Insert call to action block in your page (post)", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_call_to_action',
				"class" => "trx_sc_collection trx_sc_call_to_action",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Block's style", "healthandcare"),
						"description" => esc_html__("Select style to display this block", "healthandcare"),
						"class" => "",
						"admin_label" => true,
						"value" => array_flip(healthandcare_get_list_styles(1, 2)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Select block alignment", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "accent",
						"heading" => esc_html__("Accent", "healthandcare"),
						"description" => esc_html__("Fill entire block with Accent1 color from current color scheme", "healthandcare"),
						"class" => "",
						"value" => array("Fill with Accent1 color" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "custom",
						"heading" => esc_html__("Custom", "healthandcare"),
						"description" => esc_html__("Allow get featured image or video from inner shortcodes (custom) or get it from shortcode parameters below", "healthandcare"),
						"class" => "",
						"value" => array("Custom content" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "image",
						"heading" => esc_html__("Image", "healthandcare"),
						"description" => esc_html__("Image to display inside block", "healthandcare"),
				        'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "video",
						"heading" => esc_html__("URL for video file", "healthandcare"),
						"description" => esc_html__("Paste URL for video file to display inside block", "healthandcare"),
				        'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", "healthandcare"),
						"description" => esc_html__("Title for the block", "healthandcare"),
						"admin_label" => true,
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => esc_html__("Subtitle", "healthandcare"),
						"description" => esc_html__("Subtitle for the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => esc_html__("Description", "healthandcare"),
						"description" => esc_html__("Description for the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textarea"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Button URL", "healthandcare"),
						"description" => esc_html__("Link URL for the button at the bottom of the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link_caption",
						"heading" => esc_html__("Button caption", "healthandcare"),
						"description" => esc_html__("Caption for the button at the bottom of the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link2",
						"heading" => esc_html__("Button 2 URL", "healthandcare"),
						"description" => esc_html__("Link URL for the second button at the bottom of the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link2_caption",
						"heading" => esc_html__("Button 2 caption", "healthandcare"),
						"description" => esc_html__("Caption for the second button at the bottom of the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Call_To_Action extends HEALTHANDCARE_VC_ShortCodeCollection {}


			
			
			
			
			// Chat
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_chat",
				"name" => esc_html__("Chat", "healthandcare"),
				"description" => esc_html__("Chat message", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_chat',
				"class" => "trx_sc_container trx_sc_chat",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => esc_html__("Item title", "healthandcare"),
						"description" => esc_html__("Title for current chat item", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "photo",
						"heading" => esc_html__("Item photo", "healthandcare"),
						"description" => esc_html__("Select or upload image or write URL from other site for the item photo (avatar)", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link URL", "healthandcare"),
						"description" => esc_html__("URL for the link on chat title click", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					/*
					array(
						"param_name" => "content",
						"heading" => esc_html__("Chat item content", "healthandcare"),
						"description" => esc_html__("Current chat item content", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
				'js_view' => 'VcTrxTextContainerView'
			
			) );
			
			class WPBakeryShortCode_Trx_Chat extends HEALTHANDCARE_VC_ShortCodeContainer {}
			
			
			
			
			
			
			// Columns
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_columns",
				"name" => esc_html__("Columns", "healthandcare"),
				"description" => esc_html__("Insert columns with margins", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_columns',
				"class" => "trx_sc_columns",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => false,
				"as_parent" => array('only' => 'trx_column_item'),
				"params" => array(
					array(
						"param_name" => "count",
						"heading" => esc_html__("Columns count", "healthandcare"),
						"description" => esc_html__("Number of the columns in the container.", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "2",
						"type" => "textfield"
					),
					array(
						"param_name" => "fluid",
						"heading" => esc_html__("Fluid columns", "healthandcare"),
						"description" => esc_html__("To squeeze the columns when reducing the size of the window (fluid=yes) or to rebuild them (fluid=no)", "healthandcare"),
						"class" => "",
						"value" => array(esc_html__('Fluid columns', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
				'default_content' => '
					[trx_column_item][/trx_column_item]
					[trx_column_item][/trx_column_item]
				',
				'js_view' => 'VcTrxColumnsView'
			) );
			
			
			vc_map( array(
				"base" => "trx_column_item",
				"name" => esc_html__("Column", "healthandcare"),
				"description" => esc_html__("Column item", "healthandcare"),
				"show_settings_on_create" => true,
				"class" => "trx_sc_collection trx_sc_column_item",
				"content_element" => true,
				"is_container" => true,
				'icon' => 'icon_trx_column_item',
				"as_child" => array('only' => 'trx_columns'),
				"as_parent" => array('except' => 'trx_columns'),
				"params" => array(
					array(
						"param_name" => "span",
						"heading" => esc_html__("Merge columns", "healthandcare"),
						"description" => esc_html__("Count merged columns from current", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Alignment text in the column", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => esc_html__("Fore color", "healthandcare"),
						"description" => esc_html__("Any color for objects in this column", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => esc_html__("Background color", "healthandcare"),
						"description" => esc_html__("Any background color for this column", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_image",
						"heading" => esc_html__("URL for background image file", "healthandcare"),
						"description" => esc_html__("Select or upload image or write URL from other site for the background", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					/*
					array(
						"param_name" => "content",
						"heading" => esc_html__("Column's content", "healthandcare"),
						"description" => esc_html__("Content of the current column", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxColumnItemView'
			) );
			
			class WPBakeryShortCode_Trx_Columns extends HEALTHANDCARE_VC_ShortCodeColumns {}
			class WPBakeryShortCode_Trx_Column_Item extends HEALTHANDCARE_VC_ShortCodeCollection {}
			
			
			
			
			
			
			
			// Contact form
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_contact_form",
				"name" => esc_html__("Contact form", "healthandcare"),
				"description" => esc_html__("Insert contact form", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_contact_form',
				"class" => "trx_sc_collection trx_sc_contact_form",
				"content_element" => true,
				"is_container" => true,
				"as_parent" => array('only' => 'trx_form_item'),
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "custom",
						"heading" => esc_html__("Custom", "healthandcare"),
						"description" => esc_html__("Use custom fields or create standard contact form (ignore info from 'Field' tabs)", "healthandcare"),
						"class" => "",
						"value" => array(esc_html__('Create custom form', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "style",
						"heading" => esc_html__("Style", "healthandcare"),
						"description" => esc_html__("Select style of the contact form", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(healthandcare_get_list_styles(1, 2)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "action",
						"heading" => esc_html__("Action", "healthandcare"),
						"description" => esc_html__("Contact form action (URL to handle form data). If empty - use internal action", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Select form alignment", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", "healthandcare"),
						"description" => esc_html__("Title for the block", "healthandcare"),
						"admin_label" => true,
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => esc_html__("Subtitle", "healthandcare"),
						"description" => esc_html__("Subtitle for the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => esc_html__("Description", "healthandcare"),
						"description" => esc_html__("Description for the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textarea"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			
			vc_map( array(
				"base" => "trx_form_item",
				"name" => esc_html__("Form item (custom field)", "healthandcare"),
				"description" => esc_html__("Custom field for the contact form", "healthandcare"),
				"class" => "trx_sc_item trx_sc_form_item",
				'icon' => 'icon_trx_form_item',
				//"allowed_container_element" => 'vc_row',
				"show_settings_on_create" => true,
				"content_element" => true,
				"is_container" => false,
				"as_child" => array('only' => 'trx_contact_form'), // Use only|except attributes to limit parent (separate multiple values with comma)
				"params" => array(
					array(
						"param_name" => "type",
						"heading" => esc_html__("Type", "healthandcare"),
						"description" => esc_html__("Select type of the custom field", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['field_types']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "name",
						"heading" => esc_html__("Name", "healthandcare"),
						"description" => esc_html__("Name of the custom field", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "value",
						"heading" => esc_html__("Default value", "healthandcare"),
						"description" => esc_html__("Default value of the custom field", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "options",
						"heading" => esc_html__("Options", "healthandcare"),
						"description" => esc_html__("Field options. For example: big=My daddy|middle=My brother|small=My little sister", "healthandcare"),
						'dependency' => array(
							'element' => 'type',
							'value' => array('radio','checkbox','select')
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "label",
						"heading" => esc_html__("Label", "healthandcare"),
						"description" => esc_html__("Label for the custom field", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "label_position",
						"heading" => esc_html__("Label position", "healthandcare"),
						"description" => esc_html__("Label position relative to the field", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['label_positions']),
						"type" => "dropdown"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Contact_Form extends HEALTHANDCARE_VC_ShortCodeCollection {}
			class WPBakeryShortCode_Trx_Form_Item extends HEALTHANDCARE_VC_ShortCodeItem {}
			
			
			
			
			
			
			
			// Content block on fullscreen page
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_content",
				"name" => esc_html__("Content block", "healthandcare"),
				"description" => esc_html__("Container for main content block (use it only on fullscreen pages)", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_content',
				"class" => "trx_sc_collection trx_sc_content",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "scheme",
						"heading" => esc_html__("Color scheme", "healthandcare"),
						"description" => esc_html__("Select color scheme for this block", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['schemes']),
						"type" => "dropdown"
					),
					/*
					array(
						"param_name" => "content",
						"heading" => esc_html__("Container content", "healthandcare"),
						"description" => esc_html__("Content for section container", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom']
				)
			) );
			
			class WPBakeryShortCode_Trx_Content extends HEALTHANDCARE_VC_ShortCodeCollection {}
			
			
			
			
			
			
			
			// Countdown
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_countdown",
				"name" => esc_html__("Countdown", "healthandcare"),
				"description" => esc_html__("Insert countdown object", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_countdown',
				"class" => "trx_sc_single trx_sc_countdown",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "date",
						"heading" => esc_html__("Date", "healthandcare"),
						"description" => esc_html__("Upcoming date (format: yyyy-mm-dd)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "time",
						"heading" => esc_html__("Time", "healthandcare"),
						"description" => esc_html__("Upcoming time (format: HH:mm:ss)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "style",
						"heading" => esc_html__("Style", "healthandcare"),
						"description" => esc_html__("Countdown style", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(healthandcare_get_list_styles(1, 2)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Align counter to left, center or right", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Countdown extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Dropcaps
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_dropcaps",
				"name" => esc_html__("Dropcaps", "healthandcare"),
				"description" => esc_html__("Make first letter of the text as dropcaps", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_dropcaps',
				"class" => "trx_sc_single trx_sc_dropcaps",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Style", "healthandcare"),
						"description" => esc_html__("Dropcaps style", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(healthandcare_get_list_styles(1, 4)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "content",
						"heading" => esc_html__("Paragraph text", "healthandcare"),
						"description" => esc_html__("Paragraph with dropcaps content", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTextView'
			
			) );
			
			class WPBakeryShortCode_Trx_Dropcaps extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Emailer
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_emailer",
				"name" => esc_html__("E-mail collector", "healthandcare"),
				"description" => esc_html__("Collect e-mails into specified group", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_emailer',
				"class" => "trx_sc_single trx_sc_emailer",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "group",
						"heading" => esc_html__("Group", "healthandcare"),
						"description" => esc_html__("The name of group to collect e-mail address", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "open",
						"heading" => esc_html__("Opened", "healthandcare"),
						"description" => esc_html__("Initially open the input field on show object", "healthandcare"),
						"class" => "",
						"value" => array(esc_html__('Initially opened', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Align field to left, center or right", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Emailer extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Gap
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_gap",
				"name" => esc_html__("Gap", "healthandcare"),
				"description" => esc_html__("Insert gap (fullwidth area) in the post content", "healthandcare"),
				"category" => esc_html__('Structure', 'js_composer'),
				'icon' => 'icon_trx_gap',
				"class" => "trx_sc_collection trx_sc_gap",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => false,
				"params" => array(
					/*
					array(
						"param_name" => "content",
						"heading" => esc_html__("Gap content", "healthandcare"),
						"description" => esc_html__("Gap inner content", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					)
					*/
				)
			) );
			
			class WPBakeryShortCode_Trx_Gap extends HEALTHANDCARE_VC_ShortCodeCollection {}
			
			
			
			
			
			
			
			// Googlemap
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_googlemap",
				"name" => esc_html__("Google map", "healthandcare"),
				"description" => esc_html__("Insert Google map with desired address or coordinates", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_googlemap',
				"class" => "trx_sc_collection trx_sc_googlemap",
				"content_element" => true,
				"is_container" => true,
				"as_parent" => array('only' => 'trx_googlemap_marker'),
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "zoom",
						"heading" => esc_html__("Zoom", "healthandcare"),
						"description" => esc_html__("Map zoom factor", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "16",
						"type" => "textfield"
					),
					array(
						"param_name" => "style",
						"heading" => esc_html__("Style", "healthandcare"),
						"description" => esc_html__("Map custom style", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['googlemap_styles']),
						"type" => "dropdown"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width('100%'),
					healthandcare_vc_height(240),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			vc_map( array(
				"base" => "trx_googlemap_marker",
				"name" => esc_html__("Googlemap marker", "healthandcare"),
				"description" => esc_html__("Insert new marker into Google map", "healthandcare"),
				"class" => "trx_sc_collection trx_sc_googlemap_marker",
				'icon' => 'icon_trx_googlemap_marker',
				//"allowed_container_element" => 'vc_row',
				"show_settings_on_create" => true,
				"content_element" => true,
				"is_container" => true,
				"as_child" => array('only' => 'trx_googlemap'), // Use only|except attributes to limit parent (separate multiple values with comma)
				"params" => array(
					array(
						"param_name" => "address",
						"heading" => esc_html__("Address", "healthandcare"),
						"description" => esc_html__("Address of this marker", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "latlng",
						"heading" => esc_html__("Latitude and Longtitude", "healthandcare"),
						"description" => esc_html__("Comma separated marker's coorditanes (instead Address)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", "healthandcare"),
						"description" => esc_html__("Title for this marker", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "point",
						"heading" => esc_html__("URL for marker image file", "healthandcare"),
						"description" => esc_html__("Select or upload image or write URL from other site for this marker. If empty - use default marker", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id']
				)
			) );
			
			class WPBakeryShortCode_Trx_Googlemap extends HEALTHANDCARE_VC_ShortCodeCollection {}
			class WPBakeryShortCode_Trx_Googlemap_Marker extends HEALTHANDCARE_VC_ShortCodeCollection {}
			
			
			
			
			
			
			
			
			
			// Highlight
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_highlight",
				"name" => esc_html__("Highlight text", "healthandcare"),
				"description" => esc_html__("Highlight text with selected color, background color and other styles", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_highlight',
				"class" => "trx_sc_single trx_sc_highlight",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "type",
						"heading" => esc_html__("Type", "healthandcare"),
						"description" => esc_html__("Highlight type", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
								esc_html__('Custom', 'healthandcare') => 0,
								esc_html__('Type 1', 'healthandcare') => 1,
								esc_html__('Type 2', 'healthandcare') => 2,
								esc_html__('Type 3', 'healthandcare') => 3
							),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => esc_html__("Text color", "healthandcare"),
						"description" => esc_html__("Color for the highlighted text", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => esc_html__("Background color", "healthandcare"),
						"description" => esc_html__("Background color for the highlighted text", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "font_size",
						"heading" => esc_html__("Font size", "healthandcare"),
						"description" => esc_html__("Font size for the highlighted text (default - in pixels, allows any CSS units of measure)", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "content",
						"heading" => esc_html__("Highlight text", "healthandcare"),
						"description" => esc_html__("Content for highlight", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTextView'
			) );
			
			class WPBakeryShortCode_Trx_Highlight extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			// Icon
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_icon",
				"name" => esc_html__("Icon", "healthandcare"),
				"description" => esc_html__("Insert the icon", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_icon',
				"class" => "trx_sc_single trx_sc_icon",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "icon",
						"heading" => esc_html__("Icon", "healthandcare"),
						"description" => esc_html__("Select icon class from Fontello icons set", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => esc_html__("Text color", "healthandcare"),
						"description" => esc_html__("Icon's color", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => esc_html__("Background color", "healthandcare"),
						"description" => esc_html__("Background color for the icon", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_shape",
						"heading" => esc_html__("Background shape", "healthandcare"),
						"description" => esc_html__("Shape of the icon background", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('None', 'healthandcare') => 'none',
							esc_html__('Round', 'healthandcare') => 'round',
							esc_html__('Square', 'healthandcare') => 'square'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "bg_style",
						"heading" => esc_html__("Icon's color scheme", "healthandcare"),
						"description" => esc_html__("Select icon's color scheme", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['button_styles']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "font_size",
						"heading" => esc_html__("Font size", "healthandcare"),
						"description" => esc_html__("Icon's font size", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "font_weight",
						"heading" => esc_html__("Font weight", "healthandcare"),
						"description" => esc_html__("Icon's font weight", "healthandcare"),
						"class" => "",
						"value" => array(
							esc_html__('Default', 'healthandcare') => 'inherit',
							esc_html__('Thin (100)', 'healthandcare') => '100',
							esc_html__('Light (300)', 'healthandcare') => '300',
							esc_html__('Normal (400)', 'healthandcare') => '400',
							esc_html__('Bold (700)', 'healthandcare') => '700'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Icon's alignment", "healthandcare"),
						"description" => esc_html__("Align icon to left, center or right", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link URL", "healthandcare"),
						"description" => esc_html__("Link URL from this icon (if not empty)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
			) );
			
			class WPBakeryShortCode_Trx_Icon extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Image
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_image",
				"name" => esc_html__("Image", "healthandcare"),
				"description" => esc_html__("Insert image", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_image',
				"class" => "trx_sc_single trx_sc_image",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "url",
						"heading" => esc_html__("Select image", "healthandcare"),
						"description" => esc_html__("Select image from library", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Image alignment", "healthandcare"),
						"description" => esc_html__("Align image to left or right side", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['float']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "shape",
						"heading" => esc_html__("Image shape", "healthandcare"),
						"description" => esc_html__("Shape of the image: square or round", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Square', 'healthandcare') => 'square',
							esc_html__('Round', 'healthandcare') => 'round'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", "healthandcare"),
						"description" => esc_html__("Image's title", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "icon",
						"heading" => esc_html__("Title's icon", "healthandcare"),
						"description" => esc_html__("Select icon for the title from Fontello icons set", "healthandcare"),
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link", "healthandcare"),
						"description" => esc_html__("The link URL from the image", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Image extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Infobox
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_infobox",
				"name" => esc_html__("Infobox", "healthandcare"),
				"description" => esc_html__("Box with info or error message", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_infobox',
				"class" => "trx_sc_container trx_sc_infobox",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Style", "healthandcare"),
						"description" => esc_html__("Infobox style", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
								esc_html__('Regular', 'healthandcare') => 'regular',
								esc_html__('Info', 'healthandcare') => 'info',
								esc_html__('Success', 'healthandcare') => 'success',
								esc_html__('Error', 'healthandcare') => 'error',
								esc_html__('Result', 'healthandcare') => 'result'
							),
						"type" => "dropdown"
					),
					array(
						"param_name" => "closeable",
						"heading" => esc_html__("Closeable", "healthandcare"),
						"description" => esc_html__("Create closeable box (with close button)", "healthandcare"),
						"class" => "",
						"value" => array(esc_html__('Close button', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "icon",
						"heading" => esc_html__("Custom icon", "healthandcare"),
						"description" => esc_html__("Select icon for the infobox from Fontello icons set. If empty - use default icon", "healthandcare"),
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => esc_html__("Text color", "healthandcare"),
						"description" => esc_html__("Any color for the text and headers", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => esc_html__("Background color", "healthandcare"),
						"description" => esc_html__("Any background color for this infobox", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					/*
					array(
						"param_name" => "content",
						"heading" => esc_html__("Message text", "healthandcare"),
						"description" => esc_html__("Message for the infobox", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
				'js_view' => 'VcTrxTextContainerView'
			) );
			
			class WPBakeryShortCode_Trx_Infobox extends HEALTHANDCARE_VC_ShortCodeContainer {}
			
			
			
			
			
			
			
			// Line
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_line",
				"name" => esc_html__("Line", "healthandcare"),
				"description" => esc_html__("Insert line (delimiter)", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				"class" => "trx_sc_single trx_sc_line",
				'icon' => 'icon_trx_line',
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Style", "healthandcare"),
						"description" => esc_html__("Line style", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
								esc_html__('Solid', 'healthandcare') => 'solid',
								esc_html__('Dashed', 'healthandcare') => 'dashed',
								esc_html__('Dotted', 'healthandcare') => 'dotted',
								esc_html__('Double', 'healthandcare') => 'double',
								esc_html__('Shadow', 'healthandcare') => 'shadow'
							),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => esc_html__("Line color", "healthandcare"),
						"description" => esc_html__("Line color", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Line extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// List
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_list",
				"name" => esc_html__("List", "healthandcare"),
				"description" => esc_html__("List items with specific bullets", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				"class" => "trx_sc_collection trx_sc_list",
				'icon' => 'icon_trx_list',
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => false,
				"as_parent" => array('only' => 'trx_list_item'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Bullet's style", "healthandcare"),
						"description" => esc_html__("Bullet's style for each list item", "healthandcare"),
						"class" => "",
						"admin_label" => true,
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['list_styles']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => esc_html__("Color", "healthandcare"),
						"description" => esc_html__("List items color", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "icon",
						"heading" => esc_html__("List icon", "healthandcare"),
						"description" => esc_html__("Select list icon from Fontello icons set (only for style=Iconed)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						'dependency' => array(
							'element' => 'style',
							'value' => array('iconed')
						),
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "icon_color",
						"heading" => esc_html__("Icon color", "healthandcare"),
						"description" => esc_html__("List icons color", "healthandcare"),
						"class" => "",
						'dependency' => array(
							'element' => 'style',
							'value' => array('iconed')
						),
						"value" => "",
						"type" => "colorpicker"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
				'default_content' => '
					[trx_list_item]' . esc_html__( 'Item 1', 'healthandcare' ) . '[/trx_list_item]
					[trx_list_item]' . esc_html__( 'Item 2', 'healthandcare' ) . '[/trx_list_item]
				'
			) );
			
			
			vc_map( array(
				"base" => "trx_list_item",
				"name" => esc_html__("List item", "healthandcare"),
				"description" => esc_html__("List item with specific bullet", "healthandcare"),
				"class" => "trx_sc_single trx_sc_list_item",
				"show_settings_on_create" => true,
				"content_element" => true,
				"is_container" => false,
				'icon' => 'icon_trx_list_item',
				"as_child" => array('only' => 'trx_list'), // Use only|except attributes to limit parent (separate multiple values with comma)
				"as_parent" => array('except' => 'trx_list'),
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => esc_html__("List item title", "healthandcare"),
						"description" => esc_html__("Title for the current list item (show it as tooltip)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link URL", "healthandcare"),
						"description" => esc_html__("Link URL for the current list item", "healthandcare"),
						"admin_label" => true,
						"group" => esc_html__('Link', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "target",
						"heading" => esc_html__("Link target", "healthandcare"),
						"description" => esc_html__("Link target for the current list item", "healthandcare"),
						"admin_label" => true,
						"group" => esc_html__('Link', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "color",
						"heading" => esc_html__("Color", "healthandcare"),
						"description" => esc_html__("Text color for this item", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "icon",
						"heading" => esc_html__("List item icon", "healthandcare"),
						"description" => esc_html__("Select list item icon from Fontello icons set (only for style=Iconed)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "icon_color",
						"heading" => esc_html__("Icon color", "healthandcare"),
						"description" => esc_html__("Icon color for this item", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "content",
						"heading" => esc_html__("List item text", "healthandcare"),
						"description" => esc_html__("Current list item content", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTextView'
			
			) );
			
			class WPBakeryShortCode_Trx_List extends HEALTHANDCARE_VC_ShortCodeCollection {}
			class WPBakeryShortCode_Trx_List_Item extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			
			
			// Number
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_number",
				"name" => esc_html__("Number", "healthandcare"),
				"description" => esc_html__("Insert number or any word as set of separated characters", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				"class" => "trx_sc_single trx_sc_number",
				'icon' => 'icon_trx_number',
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "value",
						"heading" => esc_html__("Value", "healthandcare"),
						"description" => esc_html__("Number or any word to separate", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Select block alignment", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Number extends HEALTHANDCARE_VC_ShortCodeSingle {}


			
			
			
			
			
			// Parallax
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_parallax",
				"name" => esc_html__("Parallax", "healthandcare"),
				"description" => esc_html__("Create the parallax container (with asinc background image)", "healthandcare"),
				"category" => esc_html__('Structure', 'js_composer'),
				'icon' => 'icon_trx_parallax',
				"class" => "trx_sc_collection trx_sc_parallax",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "gap",
						"heading" => esc_html__("Create gap", "healthandcare"),
						"description" => esc_html__("Create gap around parallax container (not need in fullscreen pages)", "healthandcare"),
						"class" => "",
						"value" => array(esc_html__('Create gap', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "dir",
						"heading" => esc_html__("Direction", "healthandcare"),
						"description" => esc_html__("Scroll direction for the parallax background", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
								esc_html__('Up', 'healthandcare') => 'up',
								esc_html__('Down', 'healthandcare') => 'down'
							),
						"type" => "dropdown"
					),
					array(
						"param_name" => "speed",
						"heading" => esc_html__("Speed", "healthandcare"),
						"description" => esc_html__("Parallax background motion speed (from 0.0 to 1.0)", "healthandcare"),
						"class" => "",
						"value" => "0.3",
						"type" => "textfield"
					),
					array(
						"param_name" => "scheme",
						"heading" => esc_html__("Color scheme", "healthandcare"),
						"description" => esc_html__("Select color scheme for this block", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['schemes']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => esc_html__("Text color", "healthandcare"),
						"description" => esc_html__("Select color for text object inside parallax block", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => esc_html__("Backgroud color", "healthandcare"),
						"description" => esc_html__("Select color for parallax background", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_image",
						"heading" => esc_html__("Background image", "healthandcare"),
						"description" => esc_html__("Select or upload image or write URL from other site for the parallax background", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_image_x",
						"heading" => esc_html__("Image X position", "healthandcare"),
						"description" => esc_html__("Parallax background X position (in percents)", "healthandcare"),
						"class" => "",
						"value" => "50%",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_video",
						"heading" => esc_html__("Video background", "healthandcare"),
						"description" => esc_html__("Paste URL for video file to show it as parallax background", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_video_ratio",
						"heading" => esc_html__("Video ratio", "healthandcare"),
						"description" => esc_html__("Specify ratio of the video background. For example: 16:9 (default), 4:3, etc.", "healthandcare"),
						"class" => "",
						"value" => "16:9",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_overlay",
						"heading" => esc_html__("Overlay", "healthandcare"),
						"description" => esc_html__("Overlay color opacity (from 0.0 to 1.0)", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_texture",
						"heading" => esc_html__("Texture", "healthandcare"),
						"description" => esc_html__("Texture style from 1 to 11. Empty or 0 - without texture.", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					/*
					array(
						"param_name" => "content",
						"heading" => esc_html__("Content", "healthandcare"),
						"description" => esc_html__("Content for the parallax container", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Parallax extends HEALTHANDCARE_VC_ShortCodeCollection {}
			
			
			
			
			
			
			// Popup
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_popup",
				"name" => esc_html__("Popup window", "healthandcare"),
				"description" => esc_html__("Container for any html-block with desired class and style for popup window", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_popup',
				"class" => "trx_sc_collection trx_sc_popup",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					/*
					array(
						"param_name" => "content",
						"heading" => esc_html__("Container content", "healthandcare"),
						"description" => esc_html__("Content for popup container", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Popup extends HEALTHANDCARE_VC_ShortCodeCollection {}
			
			
			
			
			
			
			
			// Price
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_price",
				"name" => esc_html__("Price", "healthandcare"),
				"description" => esc_html__("Insert price with decoration", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_price',
				"class" => "trx_sc_single trx_sc_price",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "money",
						"heading" => esc_html__("Money", "healthandcare"),
						"description" => esc_html__("Money value (dot or comma separated)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "currency",
						"heading" => esc_html__("Currency symbol", "healthandcare"),
						"description" => esc_html__("Currency character", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "$",
						"type" => "textfield"
					),
					array(
						"param_name" => "period",
						"heading" => esc_html__("Period", "healthandcare"),
						"description" => esc_html__("Period text (if need). For example: monthly, daily, etc.", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Align price to left or right side", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['float']),
						"type" => "dropdown"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Price extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Price block
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_price_block",
				"name" => esc_html__("Price block", "healthandcare"),
				"description" => esc_html__("Insert price block with title, price and description", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_price_block',
				"class" => "trx_sc_single trx_sc_price_block",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", "healthandcare"),
						"description" => esc_html__("Block title", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link URL", "healthandcare"),
						"description" => esc_html__("URL for link from button (at bottom of the block)", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link_text",
						"heading" => esc_html__("Link text", "healthandcare"),
						"description" => esc_html__("Text (caption) for the link button (at bottom of the block). If empty - button not showed", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "icon",
						"heading" => esc_html__("Icon", "healthandcare"),
						"description" => esc_html__("Select icon from Fontello icons set (placed before/instead price)", "healthandcare"),
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "money",
						"heading" => esc_html__("Money", "healthandcare"),
						"description" => esc_html__("Money value (dot or comma separated)", "healthandcare"),
						"admin_label" => true,
						"group" => esc_html__('Money', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "currency",
						"heading" => esc_html__("Currency symbol", "healthandcare"),
						"description" => esc_html__("Currency character", "healthandcare"),
						"admin_label" => true,
						"group" => esc_html__('Money', 'healthandcare'),
						"class" => "",
						"value" => "$",
						"type" => "textfield"
					),
					array(
						"param_name" => "period",
						"heading" => esc_html__("Period", "healthandcare"),
						"description" => esc_html__("Period text (if need). For example: monthly, daily, etc.", "healthandcare"),
						"admin_label" => true,
						"group" => esc_html__('Money', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "scheme",
						"heading" => esc_html__("Color scheme", "healthandcare"),
						"description" => esc_html__("Select color scheme for this block", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['schemes']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Align price to left or right side", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['float']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "content",
						"heading" => esc_html__("Description", "healthandcare"),
						"description" => esc_html__("Description for this price block", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
				'js_view' => 'VcTrxTextView'
			) );
			
			class WPBakeryShortCode_Trx_PriceBlock extends HEALTHANDCARE_VC_ShortCodeSingle {}

			
			
			
			
			// Quote
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_quote",
				"name" => esc_html__("Quote", "healthandcare"),
				"description" => esc_html__("Quote text", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_quote',
				"class" => "trx_sc_single trx_sc_quote",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "cite",
						"heading" => esc_html__("Quote cite", "healthandcare"),
						"description" => esc_html__("URL for the quote cite link", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title (author)", "healthandcare"),
						"description" => esc_html__("Quote title (author name)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "content",
						"heading" => esc_html__("Quote content", "healthandcare"),
						"description" => esc_html__("Quote content", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
				'js_view' => 'VcTrxTextView'
			) );
			
			class WPBakeryShortCode_Trx_Quote extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Reviews
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_reviews",
				"name" => esc_html__("Reviews", "healthandcare"),
				"description" => esc_html__("Insert reviews block in the single post", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_reviews',
				"class" => "trx_sc_single trx_sc_reviews",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Align counter to left, center or right", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Reviews extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Search
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_search",
				"name" => esc_html__("Search form", "healthandcare"),
				"description" => esc_html__("Insert search form", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_search',
				"class" => "trx_sc_single trx_sc_search",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Style", "healthandcare"),
						"description" => esc_html__("Select style to display search field", "healthandcare"),
						"class" => "",
						"value" => array(
							esc_html__('Regular', 'healthandcare') => "regular",
							esc_html__('Flat', 'healthandcare') => "flat"
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "state",
						"heading" => esc_html__("State", "healthandcare"),
						"description" => esc_html__("Select search field initial state", "healthandcare"),
						"class" => "",
						"value" => array(
							esc_html__('Fixed', 'healthandcare')  => "fixed",
							esc_html__('Opened', 'healthandcare') => "opened",
							esc_html__('Closed', 'healthandcare') => "closed"
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", "healthandcare"),
						"description" => esc_html__("Title (placeholder) for the search field", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => esc_html__("Search &hellip;", 'healthandcare'),
						"type" => "textfield"
					),
					array(
						"param_name" => "ajax",
						"heading" => esc_html__("AJAX", "healthandcare"),
						"description" => esc_html__("Search via AJAX or reload page", "healthandcare"),
						"class" => "",
						"value" => array(esc_html__('Use AJAX search', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Search extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Section
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_section",
				"name" => esc_html__("Section container", "healthandcare"),
				"description" => esc_html__("Container for any block ([block] analog - to enable nesting)", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				"class" => "trx_sc_collection trx_sc_section",
				'icon' => 'icon_trx_block',
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "dedicated",
						"heading" => esc_html__("Dedicated", "healthandcare"),
						"description" => esc_html__("Use this block as dedicated content - show it before post title on single page", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array(esc_html__('Use as dedicated content', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Select block alignment", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns emulation", "healthandcare"),
						"description" => esc_html__("Select width for columns emulation", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['columns']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "pan",
						"heading" => esc_html__("Use pan effect", "healthandcare"),
						"description" => esc_html__("Use pan effect to show section content", "healthandcare"),
						"group" => esc_html__('Scroll', 'healthandcare'),
						"class" => "",
						"value" => array(esc_html__('Content scroller', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "scroll",
						"heading" => esc_html__("Use scroller", "healthandcare"),
						"description" => esc_html__("Use scroller to show section content", "healthandcare"),
						"group" => esc_html__('Scroll', 'healthandcare'),
						"admin_label" => true,
						"class" => "",
						"value" => array(esc_html__('Content scroller', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "scroll_dir",
						"heading" => esc_html__("Scroll and Pan direction", "healthandcare"),
						"description" => esc_html__("Scroll and Pan direction (if Use scroller = yes or Pan = yes)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"group" => esc_html__('Scroll', 'healthandcare'),
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['dir']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "scroll_controls",
						"heading" => esc_html__("Scroll controls", "healthandcare"),
						"description" => esc_html__("Show scroll controls (if Use scroller = yes)", "healthandcare"),
						"class" => "",
						"group" => esc_html__('Scroll', 'healthandcare'),
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['dir']),
						'dependency' => array(
							'element' => 'scroll',
							'not_empty' => true
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "scheme",
						"heading" => esc_html__("Color scheme", "healthandcare"),
						"description" => esc_html__("Select color scheme for this block", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['schemes']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => esc_html__("Fore color", "healthandcare"),
						"description" => esc_html__("Any color for objects in this section", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => esc_html__("Background color", "healthandcare"),
						"description" => esc_html__("Any background color for this section", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_image",
						"heading" => esc_html__("Background image URL", "healthandcare"),
						"description" => esc_html__("Select background image from library for this section", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_overlay",
						"heading" => esc_html__("Overlay", "healthandcare"),
						"description" => esc_html__("Overlay color opacity (from 0.0 to 1.0)", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_texture",
						"heading" => esc_html__("Texture", "healthandcare"),
						"description" => esc_html__("Texture style from 1 to 11. Empty or 0 - without texture.", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "font_size",
						"heading" => esc_html__("Font size", "healthandcare"),
						"description" => esc_html__("Font size of the text (default - in pixels, allows any CSS units of measure)", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "font_weight",
						"heading" => esc_html__("Font weight", "healthandcare"),
						"description" => esc_html__("Font weight of the text", "healthandcare"),
						"class" => "",
						"value" => array(
							esc_html__('Default', 'healthandcare') => 'inherit',
							esc_html__('Thin (100)', 'healthandcare') => '100',
							esc_html__('Light (300)', 'healthandcare') => '300',
							esc_html__('Normal (400)', 'healthandcare') => '400',
							esc_html__('Bold (700)', 'healthandcare') => '700'
						),
						"type" => "dropdown"
					),
					/*
					array(
						"param_name" => "content",
						"heading" => esc_html__("Container content", "healthandcare"),
						"description" => esc_html__("Content for section container", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					*/
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Section extends HEALTHANDCARE_VC_ShortCodeCollection {}
			
			
			
			
			
			
			
			// Skills
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_skills",
				"name" => esc_html__("Skills", "healthandcare"),
				"description" => esc_html__("Insert skills diagramm", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_skills',
				"class" => "trx_sc_collection trx_sc_skills",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_skills_item'),
				"params" => array(
					array(
						"param_name" => "max_value",
						"heading" => esc_html__("Max value", "healthandcare"),
						"description" => esc_html__("Max value for skills items", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "100",
						"type" => "textfield"
					),
					array(
						"param_name" => "type",
						"heading" => esc_html__("Skills type", "healthandcare"),
						"description" => esc_html__("Select type of skills block", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Bar', 'healthandcare') => 'bar',
							esc_html__('Pie chart', 'healthandcare') => 'pie',
							esc_html__('Counter', 'healthandcare') => 'counter',
							esc_html__('Arc', 'healthandcare') => 'arc'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "layout",
						"heading" => esc_html__("Skills layout", "healthandcare"),
						"description" => esc_html__("Select layout of skills block", "healthandcare"),
						"admin_label" => true,
						'dependency' => array(
							'element' => 'type',
							'value' => array('counter','bar','pie')
						),
						"class" => "",
						"value" => array(
							esc_html__('Rows', 'healthandcare') => 'rows',
							esc_html__('Columns', 'healthandcare') => 'columns'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "dir",
						"heading" => esc_html__("Direction", "healthandcare"),
						"description" => esc_html__("Select direction of skills block", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['dir']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "style",
						"heading" => esc_html__("Counters style", "healthandcare"),
						"description" => esc_html__("Select style of skills items (only for type=counter)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(healthandcare_get_list_styles(1, 4)),
						'dependency' => array(
							'element' => 'type',
							'value' => array('counter')
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns count", "healthandcare"),
						"description" => esc_html__("Skills columns count (required)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "2",
						"type" => "textfield"
					),
					array(
						"param_name" => "color",
						"heading" => esc_html__("Color", "healthandcare"),
						"description" => esc_html__("Color for all skills items", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => esc_html__("Background color", "healthandcare"),
						"description" => esc_html__("Background color for all skills items (only for type=pie)", "healthandcare"),
						'dependency' => array(
							'element' => 'type',
							'value' => array('pie')
						),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "border_color",
						"heading" => esc_html__("Border color", "healthandcare"),
						"description" => esc_html__("Border color for all skills items (only for type=pie)", "healthandcare"),
						'dependency' => array(
							'element' => 'type',
							'value' => array('pie')
						),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Align skills block to left or right side", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['float']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "arc_caption",
						"heading" => esc_html__("Arc caption", "healthandcare"),
						"description" => esc_html__("Arc caption - text in the center of the diagram", "healthandcare"),
						'dependency' => array(
							'element' => 'type',
							'value' => array('arc')
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "pie_compact",
						"heading" => esc_html__("Pie compact", "healthandcare"),
						"description" => esc_html__("Show all skills in one diagram or as separate diagrams", "healthandcare"),
						'dependency' => array(
							'element' => 'type',
							'value' => array('pie')
						),
						"class" => "",
						"value" => array(esc_html__('Show all skills in one diagram', 'healthandcare') => 'on'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "pie_cutout",
						"heading" => esc_html__("Pie cutout", "healthandcare"),
						"description" => esc_html__("Pie cutout (0-99). 0 - without cutout, 99 - max cutout", "healthandcare"),
						'dependency' => array(
							'element' => 'type',
							'value' => array('pie')
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", "healthandcare"),
						"description" => esc_html__("Title for the block", "healthandcare"),
						"admin_label" => true,
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => esc_html__("Subtitle", "healthandcare"),
						"description" => esc_html__("Subtitle for the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => esc_html__("Description", "healthandcare"),
						"description" => esc_html__("Description for the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textarea"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Button URL", "healthandcare"),
						"description" => esc_html__("Link URL for the button at the bottom of the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link_caption",
						"heading" => esc_html__("Button caption", "healthandcare"),
						"description" => esc_html__("Caption for the button at the bottom of the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			
			vc_map( array(
				"base" => "trx_skills_item",
				"name" => esc_html__("Skill", "healthandcare"),
				"description" => esc_html__("Skills item", "healthandcare"),
				"show_settings_on_create" => true,
				"class" => "trx_sc_single trx_sc_skills_item",
				"content_element" => true,
				"is_container" => false,
				"as_child" => array('only' => 'trx_skills'),
				"as_parent" => array('except' => 'trx_skills'),
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", "healthandcare"),
						"description" => esc_html__("Title for the current skills item", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "value",
						"heading" => esc_html__("Value", "healthandcare"),
						"description" => esc_html__("Value for the current skills item", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "50",
						"type" => "textfield"
					),
					array(
						"param_name" => "color",
						"heading" => esc_html__("Color", "healthandcare"),
						"description" => esc_html__("Color for current skills item", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_color",
						"heading" => esc_html__("Background color", "healthandcare"),
						"description" => esc_html__("Background color for current skills item (only for type=pie)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "border_color",
						"heading" => esc_html__("Border color", "healthandcare"),
						"description" => esc_html__("Border color for current skills item (only for type=pie)", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "style",
						"heading" => esc_html__("Counter style", "healthandcare"),
						"description" => esc_html__("Select style for the current skills item (only for type=counter)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(healthandcare_get_list_styles(1, 4)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "icon",
						"heading" => esc_html__("Counter icon", "healthandcare"),
						"description" => esc_html__("Select icon from Fontello icons set, placed before counter (only for type=counter)", "healthandcare"),
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Skills extends HEALTHANDCARE_VC_ShortCodeCollection {}
			class WPBakeryShortCode_Trx_Skills_Item extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Slider
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_slider",
				"name" => esc_html__("Slider", "healthandcare"),
				"description" => esc_html__("Insert slider", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_slider',
				"class" => "trx_sc_collection trx_sc_slider",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_slider_item'),
				"params" => array_merge(array(
					array(
						"param_name" => "engine",
						"heading" => esc_html__("Engine", "healthandcare"),
						"description" => esc_html__("Select engine for slider. Attention! Swiper is built-in engine, all other engines appears only if corresponding plugings are installed", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['sliders']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Float slider", "healthandcare"),
						"description" => esc_html__("Float slider to left or right side", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['float']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "custom",
						"heading" => esc_html__("Custom slides", "healthandcare"),
						"description" => esc_html__("Make custom slides from inner shortcodes (prepare it on tabs) or prepare slides from posts thumbnails", "healthandcare"),
						"class" => "",
						"value" => array(esc_html__('Custom slides', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					)
					),
					healthandcare_exists_revslider() || healthandcare_exists_royalslider() ? array(
					array(
						"param_name" => "alias",
						"heading" => esc_html__("Revolution slider alias or Royal Slider ID", "healthandcare"),
						"description" => esc_html__("Alias for Revolution slider or Royal slider ID", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						'dependency' => array(
							'element' => 'engine',
							'value' => array('revo','royal')
						),
						"value" => "",
						"type" => "textfield"
					)) : array(), array(
					array(
						"param_name" => "cat",
						"heading" => esc_html__("Categories list", "healthandcare"),
						"description" => esc_html__("Select category. If empty - show posts from any category or from IDs list", "healthandcare"),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array_flip(healthandcare_array_merge(array(0 => esc_html__('- Select category -', 'healthandcare')), $HEALTHANDCARE_GLOBALS['sc_params']['categories'])),
						"type" => "dropdown"
					),
					array(
						"param_name" => "count",
						"heading" => esc_html__("Swiper: Number of posts", "healthandcare"),
						"description" => esc_html__("How many posts will be displayed? If used IDs - this parameter ignored.", "healthandcare"),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "offset",
						"heading" => esc_html__("Swiper: Offset before select posts", "healthandcare"),
						"description" => esc_html__("Skip posts before select next part.", "healthandcare"),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Swiper: Post sorting", "healthandcare"),
						"description" => esc_html__("Select desired posts sorting method", "healthandcare"),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['sorting']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Swiper: Post order", "healthandcare"),
						"description" => esc_html__("Select desired posts order", "healthandcare"),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("Swiper: Post IDs list", "healthandcare"),
						"description" => esc_html__("Comma separated list of posts ID. If set - parameters above are ignored!", "healthandcare"),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "controls",
						"heading" => esc_html__("Swiper: Show slider controls", "healthandcare"),
						"description" => esc_html__("Show arrows inside slider", "healthandcare"),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array(esc_html__('Show controls', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "pagination",
						"heading" => esc_html__("Swiper: Show slider pagination", "healthandcare"),
						"description" => esc_html__("Show bullets or titles to switch slides", "healthandcare"),
						"group" => esc_html__('Details', 'healthandcare'),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array(
								esc_html__('Dots', 'healthandcare') => 'yes',
								esc_html__('Side Titles', 'healthandcare') => 'full',
								esc_html__('Over Titles', 'healthandcare') => 'over',
								esc_html__('None', 'healthandcare') => 'no'
							),
						"type" => "dropdown"
					),
					array(
						"param_name" => "titles",
						"heading" => esc_html__("Swiper: Show titles section", "healthandcare"),
						"description" => esc_html__("Show section with post's title and short post's description", "healthandcare"),
						"group" => esc_html__('Details', 'healthandcare'),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array(
								esc_html__('Not show', 'healthandcare') => "no",
								esc_html__('Show/Hide info', 'healthandcare') => "slide",
								esc_html__('Fixed info', 'healthandcare') => "fixed"
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "descriptions",
						"heading" => esc_html__("Swiper: Post descriptions", "healthandcare"),
						"description" => esc_html__("Show post's excerpt max length (characters)", "healthandcare"),
						"group" => esc_html__('Details', 'healthandcare'),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "links",
						"heading" => esc_html__("Swiper: Post's title as link", "healthandcare"),
						"description" => esc_html__("Make links from post's titles", "healthandcare"),
						"group" => esc_html__('Details', 'healthandcare'),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array(esc_html__('Titles as a links', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "crop",
						"heading" => esc_html__("Swiper: Crop images", "healthandcare"),
						"description" => esc_html__("Crop images in each slide or live it unchanged", "healthandcare"),
						"group" => esc_html__('Details', 'healthandcare'),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array(esc_html__('Crop images', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "autoheight",
						"heading" => esc_html__("Swiper: Autoheight", "healthandcare"),
						"description" => esc_html__("Change whole slider's height (make it equal current slide's height)", "healthandcare"),
						"group" => esc_html__('Details', 'healthandcare'),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => array(esc_html__('Autoheight', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					array(
						"param_name" => "interval",
						"heading" => esc_html__("Swiper: Slides change interval", "healthandcare"),
						"description" => esc_html__("Slides change interval (in milliseconds: 1000ms = 1s)", "healthandcare"),
						"group" => esc_html__('Details', 'healthandcare'),
						'dependency' => array(
							'element' => 'engine',
							'value' => array('swiper')
						),
						"class" => "",
						"value" => "5000",
						"type" => "textfield"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				))
			) );
			
			
			vc_map( array(
				"base" => "trx_slider_item",
				"name" => esc_html__("Slide", "healthandcare"),
				"description" => esc_html__("Slider item - single slide", "healthandcare"),
				"show_settings_on_create" => true,
				"content_element" => true,
				"is_container" => false,
				'icon' => 'icon_trx_slider_item',
				"as_child" => array('only' => 'trx_slider'),
				"as_parent" => array('except' => 'trx_slider'),
				"params" => array(
					array(
						"param_name" => "src",
						"heading" => esc_html__("URL (source) for image file", "healthandcare"),
						"description" => esc_html__("Select or upload image or write URL from other site for the current slide", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css']
				)
			) );
			
			class WPBakeryShortCode_Trx_Slider extends HEALTHANDCARE_VC_ShortCodeCollection {}
			class WPBakeryShortCode_Trx_Slider_Item extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Socials
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_socials",
				"name" => esc_html__("Social icons", "healthandcare"),
				"description" => esc_html__("Custom social icons", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_socials',
				"class" => "trx_sc_collection trx_sc_socials",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_social_item'),
				"params" => array_merge(array(
					array(
						"param_name" => "type",
						"heading" => esc_html__("Icon's type", "healthandcare"),
						"description" => esc_html__("Type of the icons - images or font icons", "healthandcare"),
						"class" => "",
						"std" => healthandcare_get_theme_setting('socials_type'),
						"value" => array(
							esc_html__('Icons', 'healthandcare') => 'icons',
							esc_html__('Images', 'healthandcare') => 'images'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "size",
						"heading" => esc_html__("Icon's size", "healthandcare"),
						"description" => esc_html__("Size of the icons", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['sizes']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "shape",
						"heading" => esc_html__("Icon's shape", "healthandcare"),
						"description" => esc_html__("Shape of the icons", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['shapes']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "socials",
						"heading" => esc_html__("Manual socials list", "healthandcare"),
						"description" => esc_html__("Custom list of social networks. For example: twitter=http://twitter.com/my_profile|facebook=http://facebooc.com/my_profile. If empty - use socials from Theme options.", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "custom",
						"heading" => esc_html__("Custom socials", "healthandcare"),
						"description" => esc_html__("Make custom icons from inner shortcodes (prepare it on tabs)", "healthandcare"),
						"class" => "",
						"value" => array(esc_html__('Custom socials', 'healthandcare') => 'yes'),
						"type" => "checkbox"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				))
			) );
			
			
			vc_map( array(
				"base" => "trx_social_item",
				"name" => esc_html__("Custom social item", "healthandcare"),
				"description" => esc_html__("Custom social item: name, profile url and icon url", "healthandcare"),
				"show_settings_on_create" => true,
				"content_element" => true,
				"is_container" => false,
				'icon' => 'icon_trx_social_item',
				"as_child" => array('only' => 'trx_socials'),
				"as_parent" => array('except' => 'trx_socials'),
				"params" => array(
					array(
						"param_name" => "name",
						"heading" => esc_html__("Social name", "healthandcare"),
						"description" => esc_html__("Name (slug) of the social network (twitter, facebook, linkedin, etc.)", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "url",
						"heading" => esc_html__("Your profile URL", "healthandcare"),
						"description" => esc_html__("URL of your profile in specified social network", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "icon",
						"heading" => esc_html__("URL (source) for icon file", "healthandcare"),
						"description" => esc_html__("Select or upload image or write URL from other site for the current social icon", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					)
				)
			) );
			
			class WPBakeryShortCode_Trx_Socials extends HEALTHANDCARE_VC_ShortCodeCollection {}
			class WPBakeryShortCode_Trx_Social_Item extends HEALTHANDCARE_VC_ShortCodeSingle {}
			

			
			
			
			
			
			// Table
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_table",
				"name" => esc_html__("Table", "healthandcare"),
				"description" => esc_html__("Insert a table", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_table',
				"class" => "trx_sc_container trx_sc_table",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "align",
						"heading" => esc_html__("Cells content alignment", "healthandcare"),
						"description" => esc_html__("Select alignment for each table cell", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "content",
						"heading" => esc_html__("Table content", "healthandcare"),
						"description" => esc_html__("Content, created with any table-generator", "healthandcare"),
						"class" => "",
						"value" => "Paste here table content, generated on one of many public internet resources, for example: http://www.impressivewebs.com/html-table-code-generator/ or http://html-tables.com/",
						"type" => "textarea_html"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
				'js_view' => 'VcTrxTextContainerView'
			) );
			
			class WPBakeryShortCode_Trx_Table extends HEALTHANDCARE_VC_ShortCodeContainer {}
			
			
			
			
			
			
			
			// Tabs
			//-------------------------------------------------------------------------------------
			
			$tab_id_1 = 'sc_tab_'.time() . '_1_' . rand( 0, 100 );
			$tab_id_2 = 'sc_tab_'.time() . '_2_' . rand( 0, 100 );
			vc_map( array(
				"base" => "trx_tabs",
				"name" => esc_html__("Tabs", "healthandcare"),
				"description" => esc_html__("Tabs", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_tabs',
				"class" => "trx_sc_collection trx_sc_tabs",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => false,
				"as_parent" => array('only' => 'trx_tab'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Tabs style", "healthandcare"),
						"description" => esc_html__("Select style of tabs items", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(healthandcare_get_list_styles(1, 2)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "initial",
						"heading" => esc_html__("Initially opened tab", "healthandcare"),
						"description" => esc_html__("Number of initially opened tab", "healthandcare"),
						"class" => "",
						"value" => 1,
						"type" => "textfield"
					),
					array(
						"param_name" => "scroll",
						"heading" => esc_html__("Scroller", "healthandcare"),
						"description" => esc_html__("Use scroller to show tab content (height parameter required)", "healthandcare"),
						"class" => "",
						"value" => array("Use scroller" => "yes" ),
						"type" => "checkbox"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
				'default_content' => '
					[trx_tab title="' . esc_html__( 'Tab 1', 'healthandcare' ) . '" tab_id="'.esc_attr($tab_id_1).'"][/trx_tab]
					[trx_tab title="' . esc_html__( 'Tab 2', 'healthandcare' ) . '" tab_id="'.esc_attr($tab_id_2).'"][/trx_tab]
				',
				"custom_markup" => '
					<div class="wpb_tabs_holder wpb_holder vc_container_for_children">
						<ul class="tabs_controls">
						</ul>
						%content%
					</div>
				',
				'js_view' => 'VcTrxTabsView'
			) );
			
			
			vc_map( array(
				"base" => "trx_tab",
				"name" => esc_html__("Tab item", "healthandcare"),
				"description" => esc_html__("Single tab item", "healthandcare"),
				"show_settings_on_create" => true,
				"class" => "trx_sc_collection trx_sc_tab",
				"content_element" => true,
				"is_container" => true,
				'icon' => 'icon_trx_tab',
				"as_child" => array('only' => 'trx_tabs'),
				"as_parent" => array('except' => 'trx_tabs'),
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => esc_html__("Tab title", "healthandcare"),
						"description" => esc_html__("Title for current tab", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
                    array(
                        "param_name" => "icon_before_title",
                        "heading" => esc_html__("Icon before title", "healthandcare"),
                        "description" => esc_html__("Select icon for before title tabs item from Fontello icons set", "healthandcare"),
                        "class" => "",
                        "value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
                        "type" => "dropdown"
                    ),
					array(
						"param_name" => "tab_id",
						"heading" => esc_html__("Tab ID", "healthandcare"),
						"description" => esc_html__("ID for current tab (required). Please, start it from letter.", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css']
				),
			  'js_view' => 'VcTrxTabView'
			) );
			class WPBakeryShortCode_Trx_Tabs extends HEALTHANDCARE_VC_ShortCodeTabs {}
			class WPBakeryShortCode_Trx_Tab extends HEALTHANDCARE_VC_ShortCodeTab {}
			
			
			
			
			
			
			
			// Title
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_title",
				"name" => esc_html__("Title", "healthandcare"),
				"description" => esc_html__("Create header tag (1-6 level) with many styles", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_title',
				"class" => "trx_sc_single trx_sc_title",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "content",
						"heading" => esc_html__("Title content", "healthandcare"),
						"description" => esc_html__("Title content", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					array(
						"param_name" => "type",
						"heading" => esc_html__("Title type", "healthandcare"),
						"description" => esc_html__("Title type (header level)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Header 1', 'healthandcare') => '1',
							esc_html__('Header 2', 'healthandcare') => '2',
							esc_html__('Header 3', 'healthandcare') => '3',
							esc_html__('Header 4', 'healthandcare') => '4',
							esc_html__('Header 5', 'healthandcare') => '5',
							esc_html__('Header 6', 'healthandcare') => '6'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "style",
						"heading" => esc_html__("Title style", "healthandcare"),
						"description" => esc_html__("Title style: only text (regular) or with icon/image (iconed)", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Regular', 'healthandcare') => 'regular',
							esc_html__('Underline', 'healthandcare') => 'underline',
							esc_html__('Divider', 'healthandcare') => 'divider',
							esc_html__('With icon (image)', 'healthandcare') => 'iconed'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Title text alignment", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "font_size",
						"heading" => esc_html__("Font size", "healthandcare"),
						"description" => esc_html__("Custom font size. If empty - use theme default", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "font_weight",
						"heading" => esc_html__("Font weight", "healthandcare"),
						"description" => esc_html__("Custom font weight. If empty or inherit - use theme default", "healthandcare"),
						"class" => "",
						"value" => array(
							esc_html__('Default', 'healthandcare') => 'inherit',
							esc_html__('Thin (100)', 'healthandcare') => '100',
							esc_html__('Light (300)', 'healthandcare') => '300',
							esc_html__('Normal (400)', 'healthandcare') => '400',
							esc_html__('Semibold (600)', 'healthandcare') => '600',
							esc_html__('Bold (700)', 'healthandcare') => '700',
							esc_html__('Black (900)', 'healthandcare') => '900'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "color",
						"heading" => esc_html__("Title color", "healthandcare"),
						"description" => esc_html__("Select color for the title", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "icon",
						"heading" => esc_html__("Title font icon", "healthandcare"),
						"description" => esc_html__("Select font icon for the title from Fontello icons set (if style=iconed)", "healthandcare"),
						"class" => "",
						"group" => esc_html__('Icon &amp; Image', 'healthandcare'),
						'dependency' => array(
							'element' => 'style',
							'value' => array('iconed')
						),
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "image",
						"heading" => esc_html__("or image icon", "healthandcare"),
						"description" => esc_html__("Select image icon for the title instead icon above (if style=iconed)", "healthandcare"),
						"class" => "",
						"group" => esc_html__('Icon &amp; Image', 'healthandcare'),
						'dependency' => array(
							'element' => 'style',
							'value' => array('iconed')
						),
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['images'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "picture",
						"heading" => esc_html__("or select uploaded image", "healthandcare"),
						"description" => esc_html__("Select or upload image or write URL from other site (if style=iconed)", "healthandcare"),
						"group" => esc_html__('Icon &amp; Image', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "image_size",
						"heading" => esc_html__("Image (picture) size", "healthandcare"),
						"description" => esc_html__("Select image (picture) size (if style=iconed)", "healthandcare"),
						"group" => esc_html__('Icon &amp; Image', 'healthandcare'),
						"class" => "",
						"value" => array(
							esc_html__('Small', 'healthandcare') => 'small',
							esc_html__('Medium', 'healthandcare') => 'medium',
							esc_html__('Large', 'healthandcare') => 'large'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "position",
						"heading" => esc_html__("Icon (image) position", "healthandcare"),
						"description" => esc_html__("Select icon (image) position (if style=iconed)", "healthandcare"),
						"group" => esc_html__('Icon &amp; Image', 'healthandcare'),
						"class" => "",
						"value" => array(
							esc_html__('Top', 'healthandcare') => 'top',
							esc_html__('Left', 'healthandcare') => 'left'
						),
						"type" => "dropdown"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
				'js_view' => 'VcTrxTextView'
			) );
			
			class WPBakeryShortCode_Trx_Title extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Toggles
			//-------------------------------------------------------------------------------------
				
			vc_map( array(
				"base" => "trx_toggles",
				"name" => esc_html__("Toggles", "healthandcare"),
				"description" => esc_html__("Toggles items", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_toggles',
				"class" => "trx_sc_collection trx_sc_toggles",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => false,
				"as_parent" => array('only' => 'trx_toggles_item'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Toggles style", "healthandcare"),
						"description" => esc_html__("Select style for display toggles", "healthandcare"),
						"class" => "",
						"admin_label" => true,
						"value" => array_flip(healthandcare_get_list_styles(1, 2)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "counter",
						"heading" => esc_html__("Counter", "healthandcare"),
						"description" => esc_html__("Display counter before each toggles title", "healthandcare"),
						"class" => "",
						"value" => array("Add item numbers before each element" => "on" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "icon_closed",
						"heading" => esc_html__("Icon while closed", "healthandcare"),
						"description" => esc_html__("Select icon for the closed toggles item from Fontello icons set", "healthandcare"),
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "icon_opened",
						"heading" => esc_html__("Icon while opened", "healthandcare"),
						"description" => esc_html__("Select icon for the opened toggles item from Fontello icons set", "healthandcare"),
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
				'default_content' => '
					[trx_toggles_item title="' . esc_html__( 'Item 1 title', 'healthandcare' ) . '"][/trx_toggles_item]
					[trx_toggles_item title="' . esc_html__( 'Item 2 title', 'healthandcare' ) . '"][/trx_toggles_item]
				',
				"custom_markup" => '
					<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
						%content%
					</div>
					<div class="tab_controls">
						<button class="add_tab" title="'.esc_html__("Add item", "healthandcare").'">'.esc_html__("Add item", "healthandcare").'</button>
					</div>
				',
				'js_view' => 'VcTrxTogglesView'
			) );
			
			
			vc_map( array(
				"base" => "trx_toggles_item",
				"name" => esc_html__("Toggles item", "healthandcare"),
				"description" => esc_html__("Single toggles item", "healthandcare"),
				"show_settings_on_create" => true,
				"content_element" => true,
				"is_container" => true,
				'icon' => 'icon_trx_toggles_item',
				"as_child" => array('only' => 'trx_toggles'),
				"as_parent" => array('except' => 'trx_toggles'),
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", "healthandcare"),
						"description" => esc_html__("Title for current toggles item", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "open",
						"heading" => esc_html__("Open on show", "healthandcare"),
						"description" => esc_html__("Open current toggle item on show", "healthandcare"),
						"class" => "",
						"value" => array("Opened" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "icon_closed",
						"heading" => esc_html__("Icon while closed", "healthandcare"),
						"description" => esc_html__("Select icon for the closed toggles item from Fontello icons set", "healthandcare"),
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "icon_opened",
						"heading" => esc_html__("Icon while opened", "healthandcare"),
						"description" => esc_html__("Select icon for the opened toggles item from Fontello icons set", "healthandcare"),
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTogglesTabView'
			) );
			class WPBakeryShortCode_Trx_Toggles extends HEALTHANDCARE_VC_ShortCodeToggles {}
			class WPBakeryShortCode_Trx_Toggles_Item extends HEALTHANDCARE_VC_ShortCodeTogglesItem {}
			
			
			
			
			
			
			// Twitter
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "trx_twitter",
				"name" => esc_html__("Twitter", "healthandcare"),
				"description" => esc_html__("Insert twitter feed into post (page)", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_twitter',
				"class" => "trx_sc_single trx_sc_twitter",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "user",
						"heading" => esc_html__("Twitter Username", "healthandcare"),
						"description" => esc_html__("Your username in the twitter account. If empty - get it from Theme Options.", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "consumer_key",
						"heading" => esc_html__("Consumer Key", "healthandcare"),
						"description" => esc_html__("Consumer Key from the twitter account", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "consumer_secret",
						"heading" => esc_html__("Consumer Secret", "healthandcare"),
						"description" => esc_html__("Consumer Secret from the twitter account", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "token_key",
						"heading" => esc_html__("Token Key", "healthandcare"),
						"description" => esc_html__("Token Key from the twitter account", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "token_secret",
						"heading" => esc_html__("Token Secret", "healthandcare"),
						"description" => esc_html__("Token Secret from the twitter account", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "count",
						"heading" => esc_html__("Tweets number", "healthandcare"),
						"description" => esc_html__("Number tweets to show", "healthandcare"),
						"class" => "",
						"divider" => true,
						"value" => 3,
						"type" => "textfield"
					),
					array(
						"param_name" => "controls",
						"heading" => esc_html__("Show arrows", "healthandcare"),
						"description" => esc_html__("Show control buttons", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['yes_no']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "interval",
						"heading" => esc_html__("Tweets change interval", "healthandcare"),
						"description" => esc_html__("Tweets change interval (in milliseconds: 1000ms = 1s)", "healthandcare"),
						"class" => "",
						"value" => "7000",
						"type" => "textfield"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Alignment of the tweets block", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "autoheight",
						"heading" => esc_html__("Autoheight", "healthandcare"),
						"description" => esc_html__("Change whole slider's height (make it equal current slide's height)", "healthandcare"),
						"class" => "",
						"value" => array("Autoheight" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "scheme",
						"heading" => esc_html__("Color scheme", "healthandcare"),
						"description" => esc_html__("Select color scheme for this block", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['schemes']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "bg_color",
						"heading" => esc_html__("Background color", "healthandcare"),
						"description" => esc_html__("Any background color for this section", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_image",
						"heading" => esc_html__("Background image URL", "healthandcare"),
						"description" => esc_html__("Select background image from library for this section", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_overlay",
						"heading" => esc_html__("Overlay", "healthandcare"),
						"description" => esc_html__("Overlay color opacity (from 0.0 to 1.0)", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_texture",
						"heading" => esc_html__("Texture", "healthandcare"),
						"description" => esc_html__("Texture style from 1 to 11. Empty or 0 - without texture.", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				),
			) );
			
			class WPBakeryShortCode_Trx_Twitter extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Video
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_video",
				"name" => esc_html__("Video", "healthandcare"),
				"description" => esc_html__("Insert video player", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_video',
				"class" => "trx_sc_single trx_sc_video",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "url",
						"heading" => esc_html__("URL for video file", "healthandcare"),
						"description" => esc_html__("Paste URL for video file", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "ratio",
						"heading" => esc_html__("Ratio", "healthandcare"),
						"description" => esc_html__("Select ratio for display video", "healthandcare"),
						"class" => "",
						"value" => array(
							esc_html__('16:9', 'healthandcare') => "16:9",
							esc_html__('4:3', 'healthandcare') => "4:3"
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "autoplay",
						"heading" => esc_html__("Autoplay video", "healthandcare"),
						"description" => esc_html__("Autoplay video on page load", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array("Autoplay" => "on" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Select block alignment", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "image",
						"heading" => esc_html__("Cover image", "healthandcare"),
						"description" => esc_html__("Select or upload image or write URL from other site for video preview", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_image",
						"heading" => esc_html__("Background image", "healthandcare"),
						"description" => esc_html__("Select or upload image or write URL from other site for video background. Attention! If you use background image - specify paddings below from background margins to video block in percents!", "healthandcare"),
						"group" => esc_html__('Background', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_top",
						"heading" => esc_html__("Top offset", "healthandcare"),
						"description" => esc_html__("Top offset (padding) from background image to video block (in percent). For example: 3%", "healthandcare"),
						"group" => esc_html__('Background', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_bottom",
						"heading" => esc_html__("Bottom offset", "healthandcare"),
						"description" => esc_html__("Bottom offset (padding) from background image to video block (in percent). For example: 3%", "healthandcare"),
						"group" => esc_html__('Background', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_left",
						"heading" => esc_html__("Left offset", "healthandcare"),
						"description" => esc_html__("Left offset (padding) from background image to video block (in percent). For example: 20%", "healthandcare"),
						"group" => esc_html__('Background', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_right",
						"heading" => esc_html__("Right offset", "healthandcare"),
						"description" => esc_html__("Right offset (padding) from background image to video block (in percent). For example: 12%", "healthandcare"),
						"group" => esc_html__('Background', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Video extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
			
			
			
			// Zoom
			//-------------------------------------------------------------------------------------
			
			vc_map( array(
				"base" => "trx_zoom",
				"name" => esc_html__("Zoom", "healthandcare"),
				"description" => esc_html__("Insert the image with zoom/lens effect", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_zoom',
				"class" => "trx_sc_single trx_sc_zoom",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "effect",
						"heading" => esc_html__("Effect", "healthandcare"),
						"description" => esc_html__("Select effect to display overlapping image", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Lens', 'healthandcare') => 'lens',
							esc_html__('Zoom', 'healthandcare') => 'zoom'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "url",
						"heading" => esc_html__("Main image", "healthandcare"),
						"description" => esc_html__("Select or upload main image", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "over",
						"heading" => esc_html__("Overlaping image", "healthandcare"),
						"description" => esc_html__("Select or upload overlaping image", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Float zoom to left or right side", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['float']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "bg_image",
						"heading" => esc_html__("Background image", "healthandcare"),
						"description" => esc_html__("Select or upload image or write URL from other site for zoom background. Attention! If you use background image - specify paddings below from background margins to video block in percents!", "healthandcare"),
						"group" => esc_html__('Background', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_top",
						"heading" => esc_html__("Top offset", "healthandcare"),
						"description" => esc_html__("Top offset (padding) from background image to zoom block (in percent). For example: 3%", "healthandcare"),
						"group" => esc_html__('Background', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_bottom",
						"heading" => esc_html__("Bottom offset", "healthandcare"),
						"description" => esc_html__("Bottom offset (padding) from background image to zoom block (in percent). For example: 3%", "healthandcare"),
						"group" => esc_html__('Background', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_left",
						"heading" => esc_html__("Left offset", "healthandcare"),
						"description" => esc_html__("Left offset (padding) from background image to zoom block (in percent). For example: 20%", "healthandcare"),
						"group" => esc_html__('Background', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_right",
						"heading" => esc_html__("Right offset", "healthandcare"),
						"description" => esc_html__("Right offset (padding) from background image to zoom block (in percent). For example: 12%", "healthandcare"),
						"group" => esc_html__('Background', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css'],
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right']
				)
			) );
			
			class WPBakeryShortCode_Trx_Zoom extends HEALTHANDCARE_VC_ShortCodeSingle {}
			

			do_action('healthandcare_action_shortcodes_list_vc');
			
			
			if (false && healthandcare_exists_woocommerce()) {
			
				// WooCommerce - Cart
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "woocommerce_cart",
					"name" => esc_html__("Cart", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: show cart page", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_wooc_cart',
					"class" => "trx_sc_alone trx_sc_woocommerce_cart",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => false,
					"params" => array(
						array(
							"param_name" => "dummy",
							"heading" => esc_html__("Dummy data", "healthandcare"),
							"description" => esc_html__("Dummy data - not used in shortcodes", "healthandcare"),
							"class" => "",
							"value" => "",
							"type" => "textfield"
						)
					)
				) );
				
				class WPBakeryShortCode_Woocommerce_Cart extends HEALTHANDCARE_VC_ShortCodeAlone {}
			
			
				// WooCommerce - Checkout
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "woocommerce_checkout",
					"name" => esc_html__("Checkout", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: show checkout page", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_wooc_checkout',
					"class" => "trx_sc_alone trx_sc_woocommerce_checkout",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => false,
					"params" => array(
						array(
							"param_name" => "dummy",
							"heading" => esc_html__("Dummy data", "healthandcare"),
							"description" => esc_html__("Dummy data - not used in shortcodes", "healthandcare"),
							"class" => "",
							"value" => "",
							"type" => "textfield"
						)
					)
				) );
				
				class WPBakeryShortCode_Woocommerce_Checkout extends HEALTHANDCARE_VC_ShortCodeAlone {}
			
			
				// WooCommerce - My Account
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "woocommerce_my_account",
					"name" => esc_html__("My Account", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: show my account page", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_wooc_my_account',
					"class" => "trx_sc_alone trx_sc_woocommerce_my_account",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => false,
					"params" => array(
						array(
							"param_name" => "dummy",
							"heading" => esc_html__("Dummy data", "healthandcare"),
							"description" => esc_html__("Dummy data - not used in shortcodes", "healthandcare"),
							"class" => "",
							"value" => "",
							"type" => "textfield"
						)
					)
				) );
				
				class WPBakeryShortCode_Woocommerce_My_Account extends HEALTHANDCARE_VC_ShortCodeAlone {}
			
			
				// WooCommerce - Order Tracking
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "woocommerce_order_tracking",
					"name" => esc_html__("Order Tracking", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: show order tracking page", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_wooc_order_tracking',
					"class" => "trx_sc_alone trx_sc_woocommerce_order_tracking",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => false,
					"params" => array(
						array(
							"param_name" => "dummy",
							"heading" => esc_html__("Dummy data", "healthandcare"),
							"description" => esc_html__("Dummy data - not used in shortcodes", "healthandcare"),
							"class" => "",
							"value" => "",
							"type" => "textfield"
						)
					)
				) );
				
				class WPBakeryShortCode_Woocommerce_Order_Tracking extends HEALTHANDCARE_VC_ShortCodeAlone {}
			
			
				// WooCommerce - Shop Messages
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "shop_messages",
					"name" => esc_html__("Shop Messages", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: show shop messages", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_wooc_shop_messages',
					"class" => "trx_sc_alone trx_sc_shop_messages",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => false,
					"params" => array(
						array(
							"param_name" => "dummy",
							"heading" => esc_html__("Dummy data", "healthandcare"),
							"description" => esc_html__("Dummy data - not used in shortcodes", "healthandcare"),
							"class" => "",
							"value" => "",
							"type" => "textfield"
						)
					)
				) );
				
				class WPBakeryShortCode_Shop_Messages extends HEALTHANDCARE_VC_ShortCodeAlone {}
			
			
				// WooCommerce - Product Page
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "product_page",
					"name" => esc_html__("Product Page", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: display single product page", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_product_page',
					"class" => "trx_sc_single trx_sc_product_page",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "sku",
							"heading" => esc_html__("SKU", "healthandcare"),
							"description" => esc_html__("SKU code of displayed product", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "id",
							"heading" => esc_html__("ID", "healthandcare"),
							"description" => esc_html__("ID of displayed product", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "posts_per_page",
							"heading" => esc_html__("Number", "healthandcare"),
							"description" => esc_html__("How many products showed", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "1",
							"type" => "textfield"
						),
						array(
							"param_name" => "post_type",
							"heading" => esc_html__("Post type", "healthandcare"),
							"description" => esc_html__("Post type for the WP query (leave 'product')", "healthandcare"),
							"class" => "",
							"value" => "product",
							"type" => "textfield"
						),
						array(
							"param_name" => "post_status",
							"heading" => esc_html__("Post status", "healthandcare"),
							"description" => esc_html__("Display posts only with this status", "healthandcare"),
							"class" => "",
							"value" => array(
								esc_html__('Publish', 'healthandcare') => 'publish',
								esc_html__('Protected', 'healthandcare') => 'protected',
								esc_html__('Private', 'healthandcare') => 'private',
								esc_html__('Pending', 'healthandcare') => 'pending',
								esc_html__('Draft', 'healthandcare') => 'draft'
							),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Product_Page extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Product
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "product",
					"name" => esc_html__("Product", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: display one product", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_product',
					"class" => "trx_sc_single trx_sc_product",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "sku",
							"heading" => esc_html__("SKU", "healthandcare"),
							"description" => esc_html__("Product's SKU code", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "id",
							"heading" => esc_html__("ID", "healthandcare"),
							"description" => esc_html__("Product's ID", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						)
					)
				) );
				
				class WPBakeryShortCode_Product extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
				// WooCommerce - Best Selling Products
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "best_selling_products",
					"name" => esc_html__("Best Selling Products", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: show best selling products", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_best_selling_products',
					"class" => "trx_sc_single trx_sc_best_selling_products",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "per_page",
							"heading" => esc_html__("Number", "healthandcare"),
							"description" => esc_html__("How many products showed", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns", "healthandcare"),
							"description" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						)
					)
				) );
				
				class WPBakeryShortCode_Best_Selling_Products extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Recent Products
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "recent_products",
					"name" => esc_html__("Recent Products", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: show recent products", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_recent_products',
					"class" => "trx_sc_single trx_sc_recent_products",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "per_page",
							"heading" => esc_html__("Number", "healthandcare"),
							"description" => esc_html__("How many products showed", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns", "healthandcare"),
							"description" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => esc_html__("Order by", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								esc_html__('Date', 'healthandcare') => 'date',
								esc_html__('Title', 'healthandcare') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => esc_html__("Order", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Recent_Products extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Related Products
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "related_products",
					"name" => esc_html__("Related Products", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: show related products", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_related_products',
					"class" => "trx_sc_single trx_sc_related_products",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "posts_per_page",
							"heading" => esc_html__("Number", "healthandcare"),
							"description" => esc_html__("How many products showed", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns", "healthandcare"),
							"description" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => esc_html__("Order by", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								esc_html__('Date', 'healthandcare') => 'date',
								esc_html__('Title', 'healthandcare') => 'title'
							),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Related_Products extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Featured Products
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "featured_products",
					"name" => esc_html__("Featured Products", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: show featured products", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_featured_products',
					"class" => "trx_sc_single trx_sc_featured_products",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "per_page",
							"heading" => esc_html__("Number", "healthandcare"),
							"description" => esc_html__("How many products showed", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns", "healthandcare"),
							"description" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => esc_html__("Order by", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								esc_html__('Date', 'healthandcare') => 'date',
								esc_html__('Title', 'healthandcare') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => esc_html__("Order", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Featured_Products extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Top Rated Products
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "top_rated_products",
					"name" => esc_html__("Top Rated Products", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: show top rated products", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_top_rated_products',
					"class" => "trx_sc_single trx_sc_top_rated_products",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "per_page",
							"heading" => esc_html__("Number", "healthandcare"),
							"description" => esc_html__("How many products showed", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns", "healthandcare"),
							"description" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => esc_html__("Order by", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								esc_html__('Date', 'healthandcare') => 'date',
								esc_html__('Title', 'healthandcare') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => esc_html__("Order", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Top_Rated_Products extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Sale Products
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "sale_products",
					"name" => esc_html__("Sale Products", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: list products on sale", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_sale_products',
					"class" => "trx_sc_single trx_sc_sale_products",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "per_page",
							"heading" => esc_html__("Number", "healthandcare"),
							"description" => esc_html__("How many products showed", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns", "healthandcare"),
							"description" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => esc_html__("Order by", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								esc_html__('Date', 'healthandcare') => 'date',
								esc_html__('Title', 'healthandcare') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => esc_html__("Order", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Sale_Products extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Product Category
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "product_category",
					"name" => esc_html__("Products from category", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: list products in specified category(-ies)", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_product_category',
					"class" => "trx_sc_single trx_sc_product_category",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "per_page",
							"heading" => esc_html__("Number", "healthandcare"),
							"description" => esc_html__("How many products showed", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns", "healthandcare"),
							"description" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => esc_html__("Order by", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								esc_html__('Date', 'healthandcare') => 'date',
								esc_html__('Title', 'healthandcare') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => esc_html__("Order", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						),
						array(
							"param_name" => "category",
							"heading" => esc_html__("Categories", "healthandcare"),
							"description" => esc_html__("Comma separated category slugs", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "operator",
							"heading" => esc_html__("Operator", "healthandcare"),
							"description" => esc_html__("Categories operator", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								esc_html__('IN', 'healthandcare') => 'IN',
								esc_html__('NOT IN', 'healthandcare') => 'NOT IN',
								esc_html__('AND', 'healthandcare') => 'AND'
							),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Product_Category extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Products
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "products",
					"name" => esc_html__("Products", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: list all products", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_products',
					"class" => "trx_sc_single trx_sc_products",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "skus",
							"heading" => esc_html__("SKUs", "healthandcare"),
							"description" => esc_html__("Comma separated SKU codes of products", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "ids",
							"heading" => esc_html__("IDs", "healthandcare"),
							"description" => esc_html__("Comma separated ID of products", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns", "healthandcare"),
							"description" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => esc_html__("Order by", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								esc_html__('Date', 'healthandcare') => 'date',
								esc_html__('Title', 'healthandcare') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => esc_html__("Order", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						)
					)
				) );
				
				class WPBakeryShortCode_Products extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
			
				// WooCommerce - Product Attribute
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "product_attribute",
					"name" => esc_html__("Products by Attribute", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: show products with specified attribute", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_product_attribute',
					"class" => "trx_sc_single trx_sc_product_attribute",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "per_page",
							"heading" => esc_html__("Number", "healthandcare"),
							"description" => esc_html__("How many products showed", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns", "healthandcare"),
							"description" => esc_html__("How many columns per row use for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => esc_html__("Order by", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								esc_html__('Date', 'healthandcare') => 'date',
								esc_html__('Title', 'healthandcare') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => esc_html__("Order", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						),
						array(
							"param_name" => "attribute",
							"heading" => esc_html__("Attribute", "healthandcare"),
							"description" => esc_html__("Attribute name", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "filter",
							"heading" => esc_html__("Filter", "healthandcare"),
							"description" => esc_html__("Attribute value", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						)
					)
				) );
				
				class WPBakeryShortCode_Product_Attribute extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
			
			
				// WooCommerce - Products Categories
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "product_categories",
					"name" => esc_html__("Product Categories", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: show categories with products", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_product_categories',
					"class" => "trx_sc_single trx_sc_product_categories",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "number",
							"heading" => esc_html__("Number", "healthandcare"),
							"description" => esc_html__("How many categories showed", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "columns",
							"heading" => esc_html__("Columns", "healthandcare"),
							"description" => esc_html__("How many columns per row use for categories output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "4",
							"type" => "textfield"
						),
						array(
							"param_name" => "orderby",
							"heading" => esc_html__("Order by", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array(
								esc_html__('Date', 'healthandcare') => 'date',
								esc_html__('Title', 'healthandcare') => 'title'
							),
							"type" => "dropdown"
						),
						array(
							"param_name" => "order",
							"heading" => esc_html__("Order", "healthandcare"),
							"description" => esc_html__("Sorting order for products output", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['ordering']),
							"type" => "dropdown"
						),
						array(
							"param_name" => "parent",
							"heading" => esc_html__("Parent", "healthandcare"),
							"description" => esc_html__("Parent category slug", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "date",
							"type" => "textfield"
						),
						array(
							"param_name" => "ids",
							"heading" => esc_html__("IDs", "healthandcare"),
							"description" => esc_html__("Comma separated ID of products", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "hide_empty",
							"heading" => esc_html__("Hide empty", "healthandcare"),
							"description" => esc_html__("Hide empty categories", "healthandcare"),
							"class" => "",
							"value" => array("Hide empty" => "1" ),
							"type" => "checkbox"
						)
					)
				) );
				
				class WPBakeryShortCode_Products_Categories extends HEALTHANDCARE_VC_ShortCodeSingle {}
			
				/*
			
				// WooCommerce - Add to cart
				//-------------------------------------------------------------------------------------
				
				vc_map( array(
					"base" => "add_to_cart",
					"name" => esc_html__("Add to cart", "healthandcare"),
					"description" => esc_html__("WooCommerce shortcode: Display a single product price + cart button", "healthandcare"),
					"category" => esc_html__('WooCommerce', 'js_composer'),
					'icon' => 'icon_trx_add_to_cart',
					"class" => "trx_sc_single trx_sc_add_to_cart",
					"content_element" => true,
					"is_container" => false,
					"show_settings_on_create" => true,
					"params" => array(
						array(
							"param_name" => "id",
							"heading" => esc_html__("ID", "healthandcare"),
							"description" => esc_html__("Product's ID", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "sku",
							"heading" => esc_html__("SKU", "healthandcare"),
							"description" => esc_html__("Product's SKU code", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "quantity",
							"heading" => esc_html__("Quantity", "healthandcare"),
							"description" => esc_html__("How many item add", "healthandcare"),
							"admin_label" => true,
							"class" => "",
							"value" => "1",
							"type" => "textfield"
						),
						array(
							"param_name" => "show_price",
							"heading" => esc_html__("Show price", "healthandcare"),
							"description" => esc_html__("Show price near button", "healthandcare"),
							"class" => "",
							"value" => array("Show price" => "true" ),
							"type" => "checkbox"
						),
						array(
							"param_name" => "class",
							"heading" => esc_html__("Class", "healthandcare"),
							"description" => esc_html__("CSS class", "healthandcare"),
							"class" => "",
							"value" => "",
							"type" => "textfield"
						),
						array(
							"param_name" => "style",
							"heading" => esc_html__("CSS style", "healthandcare"),
							"description" => esc_html__("CSS style for additional decoration", "healthandcare"),
							"class" => "",
							"value" => "",
							"type" => "textfield"
						)
					)
				) );
				
				class WPBakeryShortCode_Add_To_Cart extends HEALTHANDCARE_VC_ShortCodeSingle {}
				*/
			}

		}
	}
}
?>