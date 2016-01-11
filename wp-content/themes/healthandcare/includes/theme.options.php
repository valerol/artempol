<?php

/* Theme setup section
-------------------------------------------------------------------- */


// ONLY FOR PROGRAMMERS, NOT FOR CUSTOMER
// Framework settings
$HEALTHANDCARE_GLOBALS['settings'] = array(
	'less_prefix'		=> '',									// any string - Use prefix before each selector when compile less. For example: 'html '
	'less_separator'	=> '/*---LESS_SEPARATOR---*/',			// string - separator inside .less files to split it when compiling to reduce memory usage
	'socials_type'		=> 'icons'								// images|icons - Use this kind of pictograms for all socials: share, social profiles, team members socials, etc.
);



// Default Theme Options
if ( !function_exists( 'healthandcare_options_settings_theme_setup' ) ) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_options_settings_theme_setup', 2 );	// Priority 1 for add healthandcare_filter handlers
	function healthandcare_options_settings_theme_setup() {
		global $HEALTHANDCARE_GLOBALS;
		
		// Remove 'false' to clear all saved Theme Options on next run.
		// Attention! Use this way only on new theme installation, not in updates!
		healthandcare_options_reset();

		// Settings 
		$socials_type = healthandcare_get_theme_setting('socials_type');
				
		// Prepare arrays 
		$HEALTHANDCARE_GLOBALS['options_params'] = array(
			'list_fonts'		=> array('$healthandcare_get_list_fonts' => ''),
			'list_fonts_styles'	=> array('$healthandcare_get_list_fonts_styles' => ''),
			'list_socials' 		=> array('$healthandcare_get_list_socials' => ''),
			'list_icons' 		=> array('$healthandcare_get_list_icons' => ''),
			'list_posts_types' 	=> array('$healthandcare_get_list_posts_types' => ''),
			'list_categories' 	=> array('$healthandcare_get_list_categories' => ''),
			'list_menus'		=> array('$healthandcare_get_list_menus' => ''),
			'list_sidebars'		=> array('$healthandcare_get_list_sidebars' => ''),
			'list_positions' 	=> array('$healthandcare_get_list_sidebars_positions' => ''),
			'list_skins'		=> array('$healthandcare_get_list_skins' => ''),
			'list_color_schemes'=> array('$healthandcare_get_list_color_schemes' => ''),
			'list_body_styles'	=> array('$healthandcare_get_list_body_styles' => ''),
			'list_header_styles'=> array('$healthandcare_get_list_templates_header' => ''),
			'list_blog_styles'	=> array('$healthandcare_get_list_templates_blog' => ''),
			'list_single_styles'=> array('$healthandcare_get_list_templates_single' => ''),
			'list_article_styles'=> array('$healthandcare_get_list_article_styles' => ''),
			'list_animations_in' => array('$healthandcare_get_list_animations_in' => ''),
			'list_animations_out'=> array('$healthandcare_get_list_animations_out' => ''),
			'list_filters'		=> array('$healthandcare_get_list_portfolio_filters' => ''),
			'list_hovers'		=> array('$healthandcare_get_list_hovers' => ''),
			'list_hovers_dir'	=> array('$healthandcare_get_list_hovers_directions' => ''),
			'list_sliders' 		=> array('$healthandcare_get_list_sliders' => ''),
			'list_revo_sliders'	=> array('$healthandcare_get_list_revo_sliders' => ''),
			'list_bg_image_positions' => array('$healthandcare_get_list_bg_image_positions' => ''),
			'list_popups' 		=> array('$healthandcare_get_list_popup_engines' => ''),
			'list_gmap_styles' 	=> array('$healthandcare_get_list_googlemap_styles' => ''),
			'list_yes_no' 		=> array('$healthandcare_get_list_yesno' => ''),
			'list_on_off' 		=> array('$healthandcare_get_list_onoff' => ''),
			'list_show_hide' 	=> array('$healthandcare_get_list_showhide' => ''),
			'list_sorting' 		=> array('$healthandcare_get_list_sortings' => ''),
			'list_ordering' 	=> array('$healthandcare_get_list_orderings' => ''),
			'list_locations' 	=> array('$healthandcare_get_list_dedicated_locations' => '')
			);


		// Theme options array
		$HEALTHANDCARE_GLOBALS['options'] = array(

		
		//###############################
		//#### Customization         #### 
		//###############################
		'partition_customization' => array(
					"title" => esc_html__('Customization', 'healthandcare'),
					"start" => "partitions",
					"override" => "category,services_group,page,post",
					"icon" => "iconadmin-cog-alt",
					"type" => "partition"
					),
		
		
		// Customization -> Body Style
		//-------------------------------------------------
		
		'customization_body' => array(
					"title" => esc_html__('Body style', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"icon" => 'iconadmin-picture',
					"start" => "customization_tabs",
					"type" => "tab"
					),
		
		'info_body_1' => array(
					"title" => esc_html__('Body parameters', 'healthandcare'),
					"desc" => esc_html__('Select body style, skin and color scheme for entire site. You can override this parameters on any page, post or category', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"type" => "info"
					),
					
		'body_style' => array(
					"title" => esc_html__('Body style', 'healthandcare'),
					"desc" => __('Select body style:<br><b>boxed</b> - if you want use background color and/or image,<br><b>wide</b> - page fill whole window with centered content,<br><b>fullwide</b> - page content stretched on the full width of the window (with few left and right paddings),<br><b>fullscreen</b> - page content fill whole window without any paddings', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "wide",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_body_styles'],
					"dir" => "horizontal",
					"type" => "radio"
					),

		'theme_skin' => array(
					"title" => esc_html__('Select theme skin', 'healthandcare'),
					"desc" => esc_html__('Select skin for the theme decoration', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "healthandcare",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_skins'],
					"type" => "select"
					),

		"body_scheme" => array(
					"title" => esc_html__('Color scheme', 'healthandcare'),
					"desc" => esc_html__('Select predefined color scheme for the entire page', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "original",
					"dir" => "horizontal",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_color_schemes'],
					"type" => "checklist"),
		
		'body_filled' => array(
					"title" => esc_html__('Fill body', 'healthandcare'),
					"desc" => esc_html__('Fill the page background with the solid color or leave it transparend to show background image (or video background)', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

		'info_body_2' => array(
					"title" => esc_html__('Background color and image', 'healthandcare'),
					"desc" => esc_html__('Color and image for the site background', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"type" => "info"
					),

		'bg_custom' => array(
					"title" => esc_html__('Use custom background',  'healthandcare'),
					"desc" => esc_html__("Use custom color and/or image as the site background", 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),
		
		'bg_color' => array(
					"title" => esc_html__('Background color',  'healthandcare'),
					"desc" => esc_html__('Body background color',  'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "#ffffff",
					"type" => "color"
					),

		'bg_pattern' => array(
					"title" => esc_html__('Background predefined pattern',  'healthandcare'),
					"desc" => esc_html__('Select theme background pattern (first case - without pattern)',  'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "",
					"options" => array(
						0 => healthandcare_get_file_url('images/spacer.png'),
						1 => healthandcare_get_file_url('images/bg/pattern_1.jpg'),
						2 => healthandcare_get_file_url('images/bg/pattern_2.jpg'),
						3 => healthandcare_get_file_url('images/bg/pattern_3.jpg'),
						4 => healthandcare_get_file_url('images/bg/pattern_4.jpg'),
						5 => healthandcare_get_file_url('images/bg/pattern_5.jpg')
					),
					"style" => "list",
					"type" => "images"
					),
		
		'bg_pattern_custom' => array(
					"title" => esc_html__('Background custom pattern',  'healthandcare'),
					"desc" => esc_html__('Select or upload background custom pattern. If selected - use it instead the theme predefined pattern (selected in the field above)',  'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "",
					"type" => "media"
					),
		
		'bg_image' => array(
					"title" => esc_html__('Background predefined image',  'healthandcare'),
					"desc" => esc_html__('Select theme background image (first case - without image)',  'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"options" => array(
						0 => healthandcare_get_file_url('images/spacer.png'),
						1 => healthandcare_get_file_url('images/bg/image_1_thumb.jpg'),
						2 => healthandcare_get_file_url('images/bg/image_2_thumb.jpg'),
						3 => healthandcare_get_file_url('images/bg/image_3_thumb.jpg')
					),
					"style" => "list",
					"type" => "images"
					),
		
		'bg_image_custom' => array(
					"title" => esc_html__('Background custom image',  'healthandcare'),
					"desc" => esc_html__('Select or upload background custom image. If selected - use it instead the theme predefined image (selected in the field above)',  'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"std" => "",
					"type" => "media"
					),
		
		'bg_image_custom_position' => array( 
					"title" => esc_html__('Background custom image position',  'healthandcare'),
					"desc" => esc_html__('Select custom image position',  'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "left_top",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"options" => array(
						'left_top' => "Left Top",
						'center_top' => "Center Top",
						'right_top' => "Right Top",
						'left_center' => "Left Center",
						'center_center' => "Center Center",
						'right_center' => "Right Center",
						'left_bottom' => "Left Bottom",
						'center_bottom' => "Center Bottom",
						'right_bottom' => "Right Bottom",
					),
					"type" => "select"
					),
		
		'bg_image_load' => array(
					"title" => esc_html__('Load background image', 'healthandcare'),
					"desc" => esc_html__('Always load background images or only for boxed body style', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "boxed",
					"size" => "medium",
					"dependency" => array(
						'bg_custom' => array('yes')
					),
					"options" => array(
						'boxed' => esc_html__('Boxed', 'healthandcare'),
						'always' => esc_html__('Always', 'healthandcare')
					),
					"type" => "switch"
					),

		
		'info_body_3' => array(
					"title" => esc_html__('Video background', 'healthandcare'),
					"desc" => esc_html__('Parameters of the video, used as site background', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"type" => "info"
					),

		'show_video_bg' => array(
					"title" => esc_html__('Show video background',  'healthandcare'),
					"desc" => esc_html__("Show video as the site background", 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

		'video_bg_youtube_code' => array(
					"title" => esc_html__('Youtube code for video bg',  'healthandcare'),
					"desc" => esc_html__("Youtube code of video", 'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_video_bg' => array('yes')
					),
					"std" => "",
					"type" => "text"
					),

		'video_bg_url' => array(
					"title" => esc_html__('Local video for video bg',  'healthandcare'),
					"desc" => esc_html__("URL to video-file (uploaded on your site)", 'healthandcare'),
					"readonly" =>false,
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_video_bg' => array('yes')
					),
					"before" => array(	'title' => esc_html__('Choose video', 'healthandcare'),
										'action' => 'media_upload',
										'multiple' => false,
										'linked_field' => '',
										'type' => 'video',
										'captions' => array('choose' => esc_html__( 'Choose Video', 'healthandcare'),
															'update' => esc_html__( 'Select Video', 'healthandcare')
														)
								),
					"std" => "",
					"type" => "media"
					),

		'video_bg_overlay' => array(
					"title" => esc_html__('Use overlay for video bg', 'healthandcare'),
					"desc" => esc_html__('Use overlay texture for the video background', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_video_bg' => array('yes')
					),
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),
		
		
		
		
		
		// Customization -> Header
		//-------------------------------------------------
		
		'customization_header' => array(
					"title" => esc_html__("Header", 'healthandcare'),
					"override" => "category,services_group,post,page",
					"icon" => 'iconadmin-window',
					"type" => "tab"),
		
		"info_header_1" => array(
					"title" => esc_html__('Top panel', 'healthandcare'),
					"desc" => esc_html__('Top panel settings. It include user menu area (with contact info, cart button, language selector, login/logout menu and user menu) and main menu area (with logo and main menu).', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"type" => "info"),
		
		"top_panel_style" => array(
					"title" => esc_html__('Top panel style', 'healthandcare'),
					"desc" => esc_html__('Select desired style of the page header', 'healthandcare'),
					"override" => "category,services_group,page",
					"std" => "header_4",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_header_styles'],
					"style" => "list",
					"type" => "images"),
		
		"top_panel_position" => array( 
					"title" => esc_html__('Top panel position', 'healthandcare'),
					"desc" => esc_html__('Select position for the top panel with logo and main menu', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "above",
					"options" => array(
						'hide'  => esc_html__('Hide', 'healthandcare'),
						'above' => esc_html__('Above slider', 'healthandcare'),
						'below' => esc_html__('Below slider', 'healthandcare'),
						'over'  => esc_html__('Over slider', 'healthandcare')
					),
					"type" => "checklist"),

		"top_panel_scheme" => array(
					"title" => esc_html__('Top panel color scheme', 'healthandcare'),
					"desc" => esc_html__('Select predefined color scheme for the top panel', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "original",
					"dir" => "horizontal",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_color_schemes'],
					"type" => "checklist"),
		
		"show_page_title" => array(
					"title" => esc_html__('Show Page title', 'healthandcare'),
					"desc" => esc_html__('Show post/page/category title', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_breadcrumbs" => array(
					"title" => esc_html__('Show Breadcrumbs', 'healthandcare'),
					"desc" => esc_html__('Show path to current category (post, page)', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"breadcrumbs_max_level" => array(
					"title" => esc_html__('Breadcrumbs max nesting', 'healthandcare'),
					"desc" => esc_html__("Max number of the nested categories in the breadcrumbs (0 - unlimited)", 'healthandcare'),
					"dependency" => array(
						'show_breadcrumbs' => array('yes')
					),
					"std" => "0",
					"min" => 0,
					"max" => 100,
					"step" => 1,
					"type" => "spinner"),

		
		
		
		"info_header_2" => array( 
					"title" => esc_html__('Main menu style and position', 'healthandcare'),
					"desc" => esc_html__('Select the Main menu style and position', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"type" => "info"),
		
		"menu_main" => array( 
					"title" => esc_html__('Select main menu',  'healthandcare'),
					"desc" => esc_html__('Select main menu for the current page',  'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "default",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_menus'],
					"type" => "select"),
		
		"menu_attachment" => array( 
					"title" => esc_html__('Main menu attachment', 'healthandcare'),
					"desc" => esc_html__('Attach main menu to top of window then page scroll down', 'healthandcare'),
					"std" => "fixed",
					"options" => array(
						"fixed"=>__("Fix menu position", 'healthandcare'),
						"none"=>__("Don't fix menu position", 'healthandcare')
					),
					"dir" => "vertical",
					"type" => "radio"),

		"menu_slider" => array( 
					"title" => esc_html__('Main menu slider', 'healthandcare'),
					"desc" => esc_html__('Use slider background for main menu items', 'healthandcare'),
					"std" => "yes",
					"type" => "switch",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no']),

		"menu_animation_in" => array( 
					"title" => esc_html__('Submenu show animation', 'healthandcare'),
					"desc" => esc_html__('Select animation to show submenu ', 'healthandcare'),
					"std" => "bounceIn",
					"type" => "select",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_animations_in']),

		"menu_animation_out" => array( 
					"title" => esc_html__('Submenu hide animation', 'healthandcare'),
					"desc" => esc_html__('Select animation to hide submenu ', 'healthandcare'),
					"std" => "fadeOutDown",
					"type" => "select",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_animations_out']),
		
		"menu_relayout" => array( 
					"title" => esc_html__('Main menu relayout', 'healthandcare'),
					"desc" => esc_html__('Allow relayout main menu if window width less then this value', 'healthandcare'),
					"std" => 960,
					"min" => 320,
					"max" => 1024,
					"type" => "spinner"),
		
		"menu_responsive" => array( 
					"title" => esc_html__('Main menu responsive', 'healthandcare'),
					"desc" => esc_html__('Allow responsive version for the main menu if window width less then this value', 'healthandcare'),
					"std" => 640,
					"min" => 320,
					"max" => 1024,
					"type" => "spinner"),
		
		"menu_width" => array( 
					"title" => esc_html__('Submenu width', 'healthandcare'),
					"desc" => esc_html__('Width for dropdown menus in main menu', 'healthandcare'),
					"step" => 5,
					"std" => "",
					"min" => 180,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"),
		
		
		
		"info_header_3" => array(
					"title" => esc_html__("User's menu area components", 'healthandcare'),
					"desc" => esc_html__("Select parts for the user's menu area", 'healthandcare'),
					"override" => "category,services_group,page,post",
					"type" => "info"),
		
		"show_top_panel_top" => array(
					"title" => esc_html__('Show user menu area', 'healthandcare'),
					"desc" => esc_html__('Show user menu area on top of page', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"menu_user" => array(
					"title" => esc_html__('Select user menu',  'healthandcare'),
					"desc" => esc_html__('Select user menu for the current page',  'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "default",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_menus'],
					"type" => "select"),
		
		"show_languages" => array(
					"title" => esc_html__('Show language selector', 'healthandcare'),
					"desc" => esc_html__('Show language selector in the user menu (if WPML plugin installed and current page/post has multilanguage version)', 'healthandcare'),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_login" => array( 
					"title" => esc_html__('Show Login/Logout buttons', 'healthandcare'),
					"desc" => esc_html__('Show Login and Logout buttons in the user menu area', 'healthandcare'),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_bookmarks" => array(
					"title" => esc_html__('Show bookmarks', 'healthandcare'),
					"desc" => esc_html__('Show bookmarks selector in the user menu', 'healthandcare'),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_socials" => array( 
					"title" => esc_html__('Show Social icons', 'healthandcare'),
					"desc" => esc_html__('Show Social icons in the user menu area', 'healthandcare'),
					"dependency" => array(
						'show_top_panel_top' => array('yes')
					),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		

		
		"info_header_4" => array( 
					"title" => esc_html__("Table of Contents (TOC)", 'healthandcare'),
					"desc" => esc_html__("Table of Contents for the current page. Automatically created if the page contains objects with id starting with 'toc_'", 'healthandcare'),
					"override" => "category,services_group,page,post",
					"type" => "info"),
		
		"menu_toc" => array( 
					"title" => esc_html__('TOC position', 'healthandcare'),
					"desc" => esc_html__('Show TOC for the current page', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "float",
					"options" => array(
						'hide'  => esc_html__('Hide', 'healthandcare'),
						'fixed' => esc_html__('Fixed', 'healthandcare'),
						'float' => esc_html__('Float', 'healthandcare')
					),
					"type" => "checklist"),
		
		"menu_toc_home" => array(
					"title" => esc_html__('Add "Home" into TOC', 'healthandcare'),
					"desc" => esc_html__('Automatically add "Home" item into table of contents - return to home page of the site', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'menu_toc' => array('fixed','float')
					),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"menu_toc_top" => array( 
					"title" => esc_html__('Add "To Top" into TOC', 'healthandcare'),
					"desc" => esc_html__('Automatically add "To Top" item into table of contents - scroll to top of the page', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'menu_toc' => array('fixed','float')
					),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		
		
		
		'info_header_5' => array(
					"title" => esc_html__('Main logo', 'healthandcare'),
					"desc" => esc_html__("Select or upload logos for the site's header and select it position", 'healthandcare'),
					"override" => "category,services_group,post,page",
					"type" => "info"
					),

		'favicon' => array(
					"title" => esc_html__('Favicon', 'healthandcare'),
					"desc" => esc_html__("Upload a 16px x 16px image that will represent your website's favicon.<br /><em>To ensure cross-browser compatibility, we recommend converting the favicon into .ico format before uploading. (<a href='http://www.favicon.cc/'>www.favicon.cc</a>)</em>", 'healthandcare'),
					"std" => "",
					"type" => "media"
					),

		'logo' => array(
					"title" => esc_html__('Logo image', 'healthandcare'),
					"desc" => esc_html__('Main logo image', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "",
					"type" => "media"
					),

		'logo_fixed' => array(
					"title" => esc_html__('Logo image (fixed header)', 'healthandcare'),
					"desc" => esc_html__('Logo image for the header (if menu is fixed after the page is scrolled)', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"divider" => false,
					"std" => "",
					"type" => "media"
					),

		'logo_text' => array(
					"title" => esc_html__('Logo text', 'healthandcare'),
					"desc" => esc_html__('Logo text - display it after logo image', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => 'Health&amp;Care',
					"type" => "text"
					),

		'logo_slogan' => array(
					"title" => esc_html__('Logo slogan', 'healthandcare'),
					"desc" => esc_html__('Logo slogan - display it under logo image (instead the site tagline)', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => '',
					"type" => "text"
					),

		'logo_height' => array(
					"title" => esc_html__('Logo height', 'healthandcare'),
					"desc" => esc_html__('Height for the logo in the header area', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"step" => 1,
					"std" => '',
					"min" => 10,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"
					),

		'logo_offset' => array(
					"title" => esc_html__('Logo top offset', 'healthandcare'),
					"desc" => esc_html__('Top offset for the logo in the header area', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"step" => 1,
					"std" => '',
					"min" => 0,
					"max" => 99,
					"mask" => "?99",
					"type" => "spinner"
					),
		
		
		
		
		
		
		
		// Customization -> Slider
		//-------------------------------------------------
		
/*		"customization_slider" => array( 
					"title" => esc_html__('Slider', 'healthandcare'),
					"icon" => "iconadmin-picture",
					"override" => "category,services_group,page",
					"type" => "tab"),
		
		"info_slider_1" => array(
					"title" => esc_html__('Main slider parameters', 'healthandcare'),
					"desc" => esc_html__('Select parameters for main slider (you can override it in each category and page)', 'healthandcare'),
					"override" => "category,services_group,page",
					"type" => "info"),
					
		"show_slider" => array(
					"title" => esc_html__('Show Slider', 'healthandcare'),
					"desc" => esc_html__('Do you want to show slider on each page (post)', 'healthandcare'),
					"override" => "category,services_group,page",
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
					
		"slider_display" => array(
					"title" => esc_html__('Slider display', 'healthandcare'),
					"desc" => esc_html__('How display slider: boxed (fixed width and height), fullwide (fixed height) or fullscreen', 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_slider' => array('yes')
					),
					"std" => "fullwide",
					"options" => array(
						"boxed"=>__("Boxed", 'healthandcare'),
						"fullwide"=>esc_html__("Fullwide", 'healthandcare'),
						"fullscreen"=>esc_html__("Fullscreen", 'healthandcare')
					),
					"type" => "checklist"),
		
		"slider_height" => array(
					"title" => esc_html__("Height (in pixels)", 'healthandcare'),
					"desc" => esc_html__("Slider height (in pixels) - only if slider display with fixed height.", 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_slider' => array('yes')
					),
					"std" => '',
					"min" => 100,
					"step" => 10,
					"type" => "spinner"),
		
		"slider_engine" => array(
					"title" => esc_html__('Slider engine', 'healthandcare'),
					"desc" => esc_html__('What engine use to show slider?', 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_slider' => array('yes')
					),
					"std" => "revo",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_sliders'],
					"type" => "radio"),
		
		"slider_alias" => array(
					"title" => esc_html__('Revolution Slider: Select slider',  'healthandcare'),
					"desc" => esc_html__("Select slider to show (if engine=revo in the field above)", 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('revo')
					),
					"std" => "",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_revo_sliders'],
					"type" => "select"),
		
		"slider_category" => array(
					"title" => esc_html__('Posts Slider: Category to show', 'healthandcare'),
					"desc" => esc_html__('Select category to show in Flexslider (ignored for Revolution and Royal sliders)', 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "",
					"options" => healthandcare_array_merge(array(0 => esc_html__('- Select category -', 'healthandcare')), $HEALTHANDCARE_GLOBALS['options_params']['list_categories']),
					"type" => "select",
					"multiple" => true,
					"style" => "list"),
		
		"slider_posts" => array(
					"title" => esc_html__('Posts Slider: Number posts or comma separated posts list',  'healthandcare'),
					"desc" => esc_html__("How many recent posts display in slider or comma separated list of posts ID (in this case selected category ignored)", 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "5",
					"type" => "text"),
		
		"slider_orderby" => array(
					"title" => esc_html__("Posts Slider: Posts order by",  'healthandcare'),
					"desc" => esc_html__("Posts in slider ordered by date (default), comments, views, author rating, users rating, random or alphabetically", 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "date",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_sorting'],
					"type" => "select"),
		
		"slider_order" => array(
					"title" => esc_html__("Posts Slider: Posts order", 'healthandcare'),
					"desc" => esc_html__('Select the desired ordering method for posts', 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "desc",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_ordering'],
					"size" => "big",
					"type" => "switch"),
					
		"slider_interval" => array(
					"title" => esc_html__("Posts Slider: Slide change interval", 'healthandcare'),
					"desc" => esc_html__("Interval (in ms) for slides change in slider", 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => 7000,
					"min" => 100,
					"step" => 100,
					"type" => "spinner"),
		
		"slider_pagination" => array(
					"title" => esc_html__("Posts Slider: Pagination", 'healthandcare'),
					"desc" => esc_html__("Choose pagination style for the slider", 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "no",
					"options" => array(
						'no'   => esc_html__('None', 'healthandcare'),
						'yes'  => esc_html__('Dots', 'healthandcare'),
						'over' => esc_html__('Titles', 'healthandcare')
					),
					"type" => "checklist"),
		
		"slider_infobox" => array(
					"title" => esc_html__("Posts Slider: Show infobox", 'healthandcare'),
					"desc" => esc_html__("Do you want to show post's title, reviews rating and description on slides in slider", 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "slide",
					"options" => array(
						'no'    => esc_html__('None',  'healthandcare'),
						'slide' => esc_html__('Slide', 'healthandcare'),
						'fixed' => esc_html__('Fixed', 'healthandcare')
					),
					"type" => "checklist"),
					
		"slider_info_category" => array(
					"title" => esc_html__("Posts Slider: Show post's category", 'healthandcare'),
					"desc" => esc_html__("Do you want to show post's category on slides in slider", 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
					
		"slider_info_reviews" => array(
					"title" => esc_html__("Posts Slider: Show post's reviews rating", 'healthandcare'),
					"desc" => esc_html__("Do you want to show post's reviews rating on slides in slider", 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
					
		"slider_info_descriptions" => array(
					"title" => esc_html__("Posts Slider: Show post's descriptions", 'healthandcare'),
					"desc" => esc_html__("How many characters show in the post's description in slider. 0 - no descriptions", 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_slider' => array('yes'),
						'slider_engine' => array('swiper')
					),
					"std" => 0,
					"min" => 0,
					"step" => 10,
					"type" => "spinner"),*/
		
		
		
		
		
		// Customization -> Sidebars
		//-------------------------------------------------
		
		"customization_sidebars" => array( 
					"title" => esc_html__('Sidebars', 'healthandcare'),
					"icon" => "iconadmin-indent-right",
					"override" => "category,services_group,post,page",
					"type" => "tab"),
		
		"info_sidebars_1" => array( 
					"title" => esc_html__('Custom sidebars', 'healthandcare'),
					"desc" => esc_html__('In this section you can create unlimited sidebars. You can fill them with widgets in the menu Appearance - Widgets', 'healthandcare'),
					"type" => "info"),
		
		"custom_sidebars" => array(
					"title" => esc_html__('Custom sidebars',  'healthandcare'),
					"desc" => esc_html__('Manage custom sidebars. You can use it with each category (page, post) independently',  'healthandcare'),
					"std" => "",
					"cloneable" => true,
					"type" => "text"),
		
		"info_sidebars_2" => array(
					"title" => esc_html__('Main sidebar', 'healthandcare'),
					"desc" => esc_html__('Show / Hide and select main sidebar', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"type" => "info"),
		
		'show_sidebar_main' => array( 
					"title" => esc_html__('Show main sidebar',  'healthandcare'),
					"desc" => esc_html__('Select position for the main sidebar or hide it',  'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "right",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_positions'],
					"dir" => "horizontal",
					"type" => "checklist"),

		"sidebar_main_scheme" => array(
					"title" => esc_html__("Color scheme", 'healthandcare'),
					"desc" => esc_html__('Select predefined color scheme for the main sidebar', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_sidebar_main' => array('left', 'right')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_color_schemes'],
					"type" => "checklist"),
		
		"sidebar_main" => array( 
					"title" => esc_html__('Select main sidebar',  'healthandcare'),
					"desc" => esc_html__('Select main sidebar content',  'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_sidebar_main' => array('left', 'right')
					),
					"std" => "sidebar_main",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_sidebars'],
					"type" => "select"),

		// Customization -> Footer
		//-------------------------------------------------
		
		'customization_footer' => array(
					"title" => esc_html__("Footer", 'healthandcare'),
					"override" => "category,services_group,post,page",
					"icon" => 'iconadmin-window',
					"type" => "tab"),
		
		
		"info_footer_1" => array(
					"title" => esc_html__("Footer components", 'healthandcare'),
					"desc" => esc_html__("Select components of the footer, set style and put the content for the user's footer area", 'healthandcare'),
					"override" => "category,services_group,page,post",
					"type" => "info"),
		
		"show_sidebar_footer" => array(
					"title" => esc_html__('Show footer sidebar', 'healthandcare'),
					"desc" => esc_html__('Select style for the footer sidebar or hide it', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"sidebar_footer_scheme" => array(
					"title" => esc_html__("Color scheme", 'healthandcare'),
					"desc" => esc_html__('Select predefined color scheme for the footer', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_sidebar_footer' => array('yes')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_color_schemes'],
					"type" => "checklist"),
		
		"sidebar_footer" => array( 
					"title" => esc_html__('Select footer sidebar',  'healthandcare'),
					"desc" => esc_html__('Select footer sidebar for the blog page',  'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_sidebar_footer' => array('yes')
					),
					"std" => "sidebar_footer",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_sidebars'],
					"type" => "select"),
		
		"sidebar_footer_columns" => array( 
					"title" => esc_html__('Footer sidebar columns',  'healthandcare'),
					"desc" => esc_html__('Select columns number for the footer sidebar',  'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_sidebar_footer' => array('yes')
					),
					"std" => 4,
					"min" => 1,
					"max" => 6,
					"type" => "spinner"),
		
		
		"info_footer_2" => array(
					"title" => esc_html__('Testimonials in Footer', 'healthandcare'),
					"desc" => esc_html__('Select parameters for Testimonials in the Footer', 'healthandcare'),
					"override" => "category,services_group,page,post",
					"type" => "info"),

		"show_testimonials_in_footer" => array(
					"title" => esc_html__('Show Testimonials in footer', 'healthandcare'),
					"desc" => esc_html__('Show Testimonials slider in footer. For correct operation of the slider (and shortcode testimonials) you must fill out Testimonials posts on the menu "Testimonials"', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"testimonials_scheme" => array(
					"title" => esc_html__("Color scheme", 'healthandcare'),
					"desc" => esc_html__('Select predefined color scheme for the testimonials area', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_testimonials_in_footer' => array('yes')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_color_schemes'],
					"type" => "checklist"),

		"testimonials_count" => array( 
					"title" => esc_html__('Testimonials count', 'healthandcare'),
					"desc" => esc_html__('Number testimonials to show', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_testimonials_in_footer' => array('yes')
					),
					"std" => 3,
					"step" => 1,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),
		
		
		"info_footer_4" => array(
					"title" => esc_html__('Google map parameters', 'healthandcare'),
					"desc" => esc_html__('Select parameters for Google map (you can override it in each category and page)', 'healthandcare'),
					"override" => "category,services_group,page,post",
					"type" => "info"),
					
		"show_googlemap" => array(
					"title" => esc_html__('Show Google Map', 'healthandcare'),
					"desc" => esc_html__('Do you want to show Google map on each page (post)', 'healthandcare'),
					"override" => "category,services_group,page,post",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),


		"show_googlemap_before_contact" => array(
			"title" => esc_html__('Show Google Map Under Contact', 'healthandcare'),
			"desc" => esc_html__('Do you want to show Google map under contact on each page (post)', 'healthandcare'),
			"override" => "category,services_group,page,post",
			"std" => "no",
			"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
			"type" => "switch"),
		
		"googlemap_height" => array(
					"title" => esc_html__("Map height", 'healthandcare'),
					"desc" => esc_html__("Map height (default - in pixels, allows any CSS units of measure)", 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => 314,
					"min" => 100,
					"step" => 10,
					"type" => "spinner"),
		
		"googlemap_address" => array(
					"title" => esc_html__('Address to show on map',  'healthandcare'),
					"desc" => esc_html__("Enter address to show on map center", 'healthandcare'),
					"override" => "category,services_group,page,post",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "653 Newark St Hoboken, NJ 07030, USA",
					"type" => "text"),
		
		"googlemap_latlng" => array(
					"title" => esc_html__('Latitude and Longtitude to show on map',  'healthandcare'),
					"desc" => esc_html__("Enter coordinates (separated by comma) to show on map center (instead of address)", 'healthandcare'),
					"override" => "category,services_group,page,post",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "",
					"type" => "text"),
		
		"googlemap_title" => array(
					"title" => esc_html__('Title to show on map',  'healthandcare'),
					"desc" => esc_html__("Enter title to show on map center", 'healthandcare'),
					"override" => "category,services_group,page,post",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "",
					"type" => "text"),
		
		"googlemap_description" => array(
					"title" => esc_html__('Description to show on map',  'healthandcare'),
					"desc" => esc_html__("Enter description to show on map center", 'healthandcare'),
					"override" => "category,services_group,page,post",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => "",
					"type" => "text"),
		
		"googlemap_zoom" => array(
					"title" => esc_html__('Google map initial zoom',  'healthandcare'),
					"desc" => esc_html__("Enter desired initial zoom for Google map", 'healthandcare'),
					"override" => "category,services_group,page,post",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => 11,
					"min" => 1,
					"max" => 20,
					"step" => 1,
					"type" => "spinner"),
		
		"googlemap_style" => array(
					"title" => esc_html__('Google map style',  'healthandcare'),
					"desc" => esc_html__("Select style to show Google map", 'healthandcare'),
					"override" => "category,services_group,page,post",
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => 'style2',
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_gmap_styles'],
					"type" => "select"),
		
		"googlemap_marker" => array(
					"title" => esc_html__('Google map marker',  'healthandcare'),
					"desc" => esc_html__("Select or upload png-image with Google map marker", 'healthandcare'),
					"dependency" => array(
						'show_googlemap' => array('yes')
					),
					"std" => '',
					"type" => "media"),
		
		
		
		"info_footer_5" => array(
					"title" => esc_html__("Contacts area", 'healthandcare'),
					"desc" => esc_html__("Show/Hide contacts area in the footer", 'healthandcare'),
					"override" => "category,services_group,page,post",
					"type" => "info"),

		"show_banner_in_footer" => array(
					"title" => esc_html__('Show Banner in footer', 'healthandcare'),
					"desc" => esc_html__('Show banner in footer', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_contacts_in_footer" => array(
					"title" => esc_html__('Show Contacts in footer', 'healthandcare'),
					"desc" => esc_html__('Show contact information area', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
                    "type" => "switch"),

		"show_footer_contact_form" => array(
					"title" => esc_html__('Show Contacts Form in footer', 'healthandcare'),
					"desc" => esc_html__('Show contact form area in footer', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
                    "type" => "switch"),

		"contacts_scheme" => array(
					"title" => esc_html__("Color scheme", 'healthandcare'),
					"desc" => esc_html__('Select predefined color scheme for the contacts area', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_contacts_in_footer' => array('yes')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_color_schemes'],
					"type" => "checklist"),

		'logo_footer' => array(
					"title" => esc_html__('Logo image for footer', 'healthandcare'),
					"desc" => esc_html__('Logo image in the footer (in the contacts area)', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_contacts_in_footer' => array('yes')
					),
					"std" => "",
					"type" => "media"
					),
		
		'logo_footer_height' => array(
					"title" => esc_html__('Logo height', 'healthandcare'),
					"desc" => esc_html__('Height for the logo in the footer area (in the contacts area)', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_contacts_in_footer' => array('yes')
					),
					"step" => 1,
					"std" => 30,
					"min" => 10,
					"max" => 300,
					"mask" => "?999",
					"type" => "spinner"
					),
		
		
		
		"info_footer_6" => array(
					"title" => esc_html__("Copyright and footer menu", 'healthandcare'),
					"desc" => esc_html__("Show/Hide copyright area in the footer", 'healthandcare'),
					"override" => "category,services_group,page,post",
					"type" => "info"),

		"show_copyright_in_footer" => array(
					"title" => esc_html__('Show Copyright area in footer', 'healthandcare'),
					"desc" => esc_html__('Show area with copyright information, footer menu and small social icons in footer', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "plain",
					"options" => array(
						'none' => esc_html__('Hide', 'healthandcare'),
						'text' => esc_html__('Text', 'healthandcare'),
						'menu' => esc_html__('Text and menu', 'healthandcare'),
						'socials' => esc_html__('Text and Social icons', 'healthandcare')
					),
					"type" => "checklist"),

		"copyright_scheme" => array(
					"title" => esc_html__("Color scheme", 'healthandcare'),
					"desc" => esc_html__('Select predefined color scheme for the copyright area', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_copyright_in_footer' => array('text', 'menu', 'socials')
					),
					"std" => "original",
					"dir" => "horizontal",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_color_schemes'],
					"type" => "checklist"),
		
		"menu_footer" => array( 
					"title" => esc_html__('Select footer menu',  'healthandcare'),
					"desc" => esc_html__('Select footer menu for the current page',  'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "default",
					"dependency" => array(
						'show_copyright_in_footer' => array('menu')
					),
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_menus'],
					"type" => "select"),

		"footer_copyright" => array(
					"title" => esc_html__('Footer copyright text',  'healthandcare'),
					"desc" => esc_html__("Copyright text to show in footer area (bottom of site)", 'healthandcare'),
					"override" => "category,services_group,page,post",
					"dependency" => array(
						'show_copyright_in_footer' => array('text', 'menu', 'socials')
					),
					"std" => "Health and care &copy; 2014 All Rights Reserved ",
					"rows" => "10",
					"type" => "editor"),




		// Customization -> Other
		//-------------------------------------------------
		
		'customization_other' => array(
					"title" => esc_html__('Other', 'healthandcare'),
					"override" => "category,services_group,page,post",
					"icon" => 'iconadmin-cog',
					"type" => "tab"
					),

		'info_other_1' => array(
					"title" => esc_html__('Theme customization other parameters', 'healthandcare'),
					"desc" => esc_html__('Animation parameters and responsive layouts for the small screens', 'healthandcare'),
					"type" => "info"
					),

		'show_theme_customizer' => array(
					"title" => esc_html__('Show Theme customizer', 'healthandcare'),
					"desc" => esc_html__('Do you want to show theme customizer in the right panel? Your website visitors will be able to customise it yourself.', 'healthandcare'),
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

		"customizer_demo" => array(
					"title" => esc_html__('Theme customizer panel demo time', 'healthandcare'),
					"desc" => esc_html__('Timer for demo mode for the customizer panel (in milliseconds: 1000ms = 1s). If 0 - no demo.', 'healthandcare'),
					"dependency" => array(
						'show_theme_customizer' => array('yes')
					),
					"std" => "0",
					"min" => 0,
					"max" => 10000,
					"step" => 500,
					"type" => "spinner"),
		
		'css_animation' => array(
					"title" => esc_html__('Extended CSS animations', 'healthandcare'),
					"desc" => esc_html__('Do you want use extended animations effects on your site?', 'healthandcare'),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),

		'remember_visitors_settings' => array(
					"title" => esc_html__("Remember visitor's settings", 'healthandcare'),
					"desc" => esc_html__('To remember the settings that were made by the visitor, when navigating to other pages or to limit their effect only within the current page', 'healthandcare'),
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),
					
		'responsive_layouts' => array(
					"title" => esc_html__('Responsive Layouts', 'healthandcare'),
					"desc" => esc_html__('Do you want use responsive layouts on small screen or still use main layout?', 'healthandcare'),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),
		


		'info_other_2' => array(
					"title" => esc_html__('Additional CSS and HTML/JS code', 'healthandcare'),
					"desc" => esc_html__('Put here your custom CSS and JS code', 'healthandcare'),
					"override" => "category,services_group,page,post",
					"type" => "info"
					),
					
		'custom_css_html' => array(
					"title" => esc_html__('Use custom CSS/HTML/JS', 'healthandcare'),
					"desc" => esc_html__('Do you want use custom HTML/CSS/JS code in your site? For example: custom styles, Google Analitics code, etc.', 'healthandcare'),
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"
					),
		
		"gtm_code" => array(
					"title" => esc_html__('Google tags manager or Google analitics code',  'healthandcare'),
					"desc" => esc_html__('Put here Google Tags Manager (GTM) code from your account: Google analitics, remarketing, etc. This code will be placed after open body tag.',  'healthandcare'),
					"dependency" => array(
						'custom_css_html' => array('yes')
					),
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"type" => "textarea"),
		
		"gtm_code2" => array(
					"title" => esc_html__('Google remarketing code',  'healthandcare'),
					"desc" => esc_html__('Put here Google Remarketing code from your account. This code will be placed before close body tag.',  'healthandcare'),
					"dependency" => array(
						'custom_css_html' => array('yes')
					),
					"divider" => false,
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"type" => "textarea"),
		
		'custom_code' => array(
					"title" => esc_html__('Your custom HTML/JS code',  'healthandcare'),
					"desc" => esc_html__('Put here your invisible html/js code: Google analitics, counters, etc',  'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'custom_css_html' => array('yes')
					),
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"type" => "textarea"
					),
		
		'custom_css' => array(
					"title" => esc_html__('Your custom CSS code',  'healthandcare'),
					"desc" => esc_html__('Put here your css code to correct main theme styles',  'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'custom_css_html' => array('yes')
					),
					"divider" => false,
					"cols" => 80,
					"rows" => 20,
					"std" => "",
					"type" => "textarea"
					),
		
		
		
		
		
		
		
		
		
		//###############################
		//#### Blog and Single pages #### 
		//###############################
		"partition_blog" => array(
					"title" => esc_html__('Blog &amp; Single', 'healthandcare'),
					"icon" => "iconadmin-docs",
					"override" => "category,services_group,post,page",
					"type" => "partition"),
		
		
		
		// Blog -> Stream page
		//-------------------------------------------------
		
		'blog_tab_stream' => array(
					"title" => esc_html__('Stream page', 'healthandcare'),
					"start" => 'blog_tabs',
					"icon" => "iconadmin-docs",
					"override" => "category,services_group,post,page",
					"type" => "tab"),
		
		"info_blog_1" => array(
					"title" => esc_html__('Blog streampage parameters', 'healthandcare'),
					"desc" => esc_html__('Select desired blog streampage parameters (you can override it in each category)', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"type" => "info"),
		
		"blog_style" => array(
					"title" => esc_html__('Blog style', 'healthandcare'),
					"desc" => esc_html__('Select desired blog style', 'healthandcare'),
					"override" => "category,services_group,page",
					"std" => "excerpt",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_blog_styles'],
					"type" => "select"),
		
		"hover_style" => array(
					"title" => esc_html__('Hover style', 'healthandcare'),
					"desc" => esc_html__('Select desired hover style (only for Blog style = Portfolio)', 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'blog_style' => array('portfolio','grid','square','colored')
					),
					"std" => "square effect_shift",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_hovers'],
					"type" => "select"),
		
		"hover_dir" => array(
					"title" => esc_html__('Hover dir', 'healthandcare'),
					"desc" => esc_html__('Select hover direction (only for Blog style = Portfolio and Hover style = Circle or Square)', 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'blog_style' => array('portfolio','grid','square','colored'),
						'hover_style' => array('square','circle')
					),
					"std" => "left_to_right",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_hovers_dir'],
					"type" => "select"),
		
		"article_style" => array(
					"title" => esc_html__('Article style', 'healthandcare'),
					"desc" => esc_html__('Select article display method: boxed or stretch', 'healthandcare'),
					"override" => "category,services_group,page",
					"std" => "stretch",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_article_styles'],
					"size" => "medium",
					"type" => "switch"),
		
		"dedicated_location" => array(
					"title" => esc_html__('Dedicated location', 'healthandcare'),
					"desc" => esc_html__('Select location for the dedicated content or featured image in the "excerpt" blog style', 'healthandcare'),
					"override" => "category,services_group,page,post",
					"dependency" => array(
						'blog_style' => array('excerpt')
					),
					"std" => "default",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_locations'],
					"type" => "select"),
		
		"show_filters" => array(
					"title" => esc_html__('Show filters', 'healthandcare'),
					"desc" => esc_html__('What taxonomy use for filter buttons', 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'blog_style' => array('portfolio','grid','square','colored')
					),
					"std" => "hide",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_filters'],
					"type" => "checklist"),
		
		"blog_sort" => array(
					"title" => esc_html__('Blog posts sorted by', 'healthandcare'),
					"desc" => esc_html__('Select the desired sorting method for posts', 'healthandcare'),
					"override" => "category,services_group,page",
					"std" => "date",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_sorting'],
					"dir" => "vertical",
					"type" => "radio"),
		
		"blog_order" => array(
					"title" => esc_html__('Blog posts order', 'healthandcare'),
					"desc" => esc_html__('Select the desired ordering method for posts', 'healthandcare'),
					"override" => "category,services_group,page",
					"std" => "desc",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_ordering'],
					"size" => "big",
					"type" => "switch"),
		
		"posts_per_page" => array(
					"title" => esc_html__('Blog posts per page',  'healthandcare'),
					"desc" => esc_html__('How many posts display on blog pages for selected style. If empty or 0 - inherit system wordpress settings',  'healthandcare'),
					"override" => "category,services_group,page",
					"std" => "12",
					"mask" => "?99",
					"type" => "text"),
		
		"post_excerpt_maxlength" => array(
					"title" => esc_html__('Excerpt maxlength for streampage',  'healthandcare'),
					"desc" => esc_html__('How many characters from post excerpt are display in blog streampage (only for Blog style = Excerpt). 0 - do not trim excerpt.',  'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'blog_style' => array('excerpt', 'portfolio', 'grid', 'square', 'related')
					),
					"std" => "250",
					"mask" => "?9999",
					"type" => "text"),
		
		"post_excerpt_maxlength_masonry" => array(
					"title" => esc_html__('Excerpt maxlength for classic and masonry',  'healthandcare'),
					"desc" => esc_html__('How many characters from post excerpt are display in blog streampage (only for Blog style = Classic or Masonry). 0 - do not trim excerpt.',  'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'blog_style' => array('masonry', 'classic')
					),
					"std" => "150",
					"mask" => "?9999",
					"type" => "text"),
		
		
		
		
		// Blog -> Single page
		//-------------------------------------------------
		
		'blog_tab_single' => array(
					"title" => esc_html__('Single page', 'healthandcare'),
					"icon" => "iconadmin-doc",
					"override" => "category,services_group,post,page",
					"type" => "tab"),
		
		
		"info_single_1" => array(
					"title" => esc_html__('Single (detail) pages parameters', 'healthandcare'),
					"desc" => esc_html__('Select desired parameters for single (detail) pages (you can override it in each category and single post (page))', 'healthandcare'),
					"override" => "category,services_group,page,post",
					"type" => "info"),
		
		"single_style" => array(
					"title" => esc_html__('Single page style', 'healthandcare'),
					"desc" => esc_html__('Select desired style for single page', 'healthandcare'),
					"override" => "category,services_group,page,post",
					"std" => "single-standard",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_single_styles'],
					"dir" => "horizontal",
					"type" => "radio"),

		"icon" => array(
					"title" => esc_html__('Select post icon', 'healthandcare'),
					"desc" => esc_html__('Select icon for output before post/category name in some layouts', 'healthandcare'),
					"override" => "services_group,page,post",
					"std" => "",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_icons'],
					"style" => "select",
					"type" => "icons"
					),
		
		"show_featured_image" => array(
					"title" => esc_html__('Show featured image before post',  'healthandcare'),
					"desc" => esc_html__("Show featured image (if selected) before post content on single pages", 'healthandcare'),
					"override" => "category,services_group,page,post",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_title" => array(
					"title" => esc_html__('Show post title', 'healthandcare'),
					"desc" => esc_html__('Show area with post title on single pages', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_title_on_quotes" => array(
					"title" => esc_html__('Show post title on links, chat, quote, status', 'healthandcare'),
					"desc" => esc_html__('Show area with post title on single and blog pages in specific post formats: links, chat, quote, status', 'healthandcare'),
					"override" => "category,services_group,page",
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_info" => array(
					"title" => esc_html__('Show post info', 'healthandcare'),
					"desc" => esc_html__('Show area with post info on single pages', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_text_before_readmore" => array(
					"title" => esc_html__('Show text before "Read more" tag', 'healthandcare'),
					"desc" => esc_html__('Show text before "Read more" tag on single pages', 'healthandcare'),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
					
		"show_post_author" => array(
					"title" => esc_html__('Show post author details',  'healthandcare'),
					"desc" => esc_html__("Show post author information block on single post page", 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_tags" => array(
					"title" => esc_html__('Show post tags',  'healthandcare'),
					"desc" => esc_html__("Show tags block on single post page", 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"show_post_related" => array(
					"title" => esc_html__('Show related posts',  'healthandcare'),
					"desc" => esc_html__("Show related posts block on single post page", 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"post_related_count" => array(
					"title" => esc_html__('Related posts number',  'healthandcare'),
					"desc" => esc_html__("How many related posts showed on single post page", 'healthandcare'),
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"override" => "category,services_group,post,page",
					"std" => "2",
					"step" => 1,
					"min" => 2,
					"max" => 8,
					"type" => "spinner"),

		"post_related_columns" => array(
					"title" => esc_html__('Related posts columns',  'healthandcare'),
					"desc" => esc_html__("How many columns used to show related posts on single post page. 1 - use scrolling to show all related posts", 'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"std" => "2",
					"step" => 1,
					"min" => 1,
					"max" => 4,
					"type" => "spinner"),
		
		"post_related_sort" => array(
					"title" => esc_html__('Related posts sorted by', 'healthandcare'),
					"desc" => esc_html__('Select the desired sorting method for related posts', 'healthandcare'),
		//			"override" => "category,services_group,page",
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"std" => "date",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_sorting'],
					"type" => "select"),
		
		"post_related_order" => array(
					"title" => esc_html__('Related posts order', 'healthandcare'),
					"desc" => esc_html__('Select the desired ordering method for related posts', 'healthandcare'),
		//			"override" => "category,services_group,page",
					"dependency" => array(
						'show_post_related' => array('yes')
					),
					"std" => "desc",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_ordering'],
					"size" => "big",
					"type" => "switch"),
		
		"show_post_comments" => array(
					"title" => esc_html__('Show comments',  'healthandcare'),
					"desc" => esc_html__("Show comments block on single post page", 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		
		
		// Blog -> Other parameters
		//-------------------------------------------------
		
		'blog_tab_other' => array(
					"title" => esc_html__('Other parameters', 'healthandcare'),
					"icon" => "iconadmin-newspaper",
					"override" => "category,services_group,page",
					"type" => "tab"),
		
		"info_blog_other_1" => array(
					"title" => esc_html__('Other Blog parameters', 'healthandcare'),
					"desc" => esc_html__('Select excluded categories, substitute parameters, etc.', 'healthandcare'),
					"type" => "info"),
		
		"exclude_cats" => array(
					"title" => esc_html__('Exclude categories', 'healthandcare'),
					"desc" => esc_html__('Select categories, which posts are exclude from blog page', 'healthandcare'),
					"std" => "",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_categories'],
					"multiple" => true,
					"style" => "list",
					"type" => "select"),
		
		"blog_pagination" => array(
					"title" => esc_html__('Blog pagination', 'healthandcare'),
					"desc" => esc_html__('Select type of the pagination on blog streampages', 'healthandcare'),
					"std" => "pages",
					"override" => "category,services_group,page",
					"options" => array(
						'pages'    => esc_html__('Standard page numbers', 'healthandcare'),
						'viewmore' => esc_html__('"View more" button', 'healthandcare'),
						'infinite' => esc_html__('Infinite scroll', 'healthandcare')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"blog_pagination_style" => array(
					"title" => esc_html__('Blog pagination style', 'healthandcare'),
					"desc" => esc_html__('Select pagination style for standard page numbers', 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'blog_pagination' => array('pages')
					),
					"std" => "pages",
					"options" => array(
						'pages'  => esc_html__('Page numbers list', 'healthandcare'),
						'slider' => esc_html__('Slider with page numbers', 'healthandcare')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"blog_counters" => array(
					"title" => esc_html__('Blog counters', 'healthandcare'),
					"desc" => esc_html__('Select counters, displayed near the post title', 'healthandcare'),
					"override" => "category,services_group,page",
					"std" => "views",
					"options" => array(
						'views' => esc_html__('Views', 'healthandcare'),
						'likes' => esc_html__('Likes', 'healthandcare'),
						'rating' => esc_html__('Rating', 'healthandcare'),
						'comments' => esc_html__('Comments', 'healthandcare')
					),
					"dir" => "vertical",
					"multiple" => true,
					"type" => "checklist"),
		
		"close_category" => array(
					"title" => esc_html__("Post's category announce", 'healthandcare'),
					"desc" => esc_html__('What category display in announce block (over posts thumb) - original or nearest parental', 'healthandcare'),
					"override" => "category,services_group,page",
					"std" => "parental",
					"options" => array(
						'parental' => esc_html__('Nearest parental category', 'healthandcare'),
						'original' => esc_html__("Original post's category", 'healthandcare')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"show_date_after" => array(
					"title" => esc_html__('Show post date after', 'healthandcare'),
					"desc" => esc_html__('Show post date after N days (before - show post age)', 'healthandcare'),
					"override" => "category,services_group,page",
					"std" => "0",
					"mask" => "?99",
					"type" => "text"),
		
		
		
		
		
		//###############################
		//#### Reviews               #### 
		//###############################
		"partition_reviews" => array(
					"title" => esc_html__('Reviews', 'healthandcare'),
					"icon" => "iconadmin-newspaper",
					"override" => "category,services_group,services_group",
					"type" => "partition"),
		
		"info_reviews_1" => array(
					"title" => esc_html__('Reviews criterias', 'healthandcare'),
					"desc" => esc_html__('Set up list of reviews criterias. You can override it in any category.', 'healthandcare'),
					"override" => "category,services_group,services_group",
					"type" => "info"),
		
		"show_reviews" => array(
					"title" => esc_html__('Show reviews block',  'healthandcare'),
					"desc" => esc_html__("Show reviews block on single post page and average reviews rating after post's title in stream pages", 'healthandcare'),
					"override" => "category,services_group,services_group",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"reviews_max_level" => array(
					"title" => esc_html__('Max reviews level',  'healthandcare'),
					"desc" => esc_html__("Maximum level for reviews marks", 'healthandcare'),
					"std" => "5",
					"options" => array(
						'5'=>esc_html__('5 stars', 'healthandcare'),
						'10'=>esc_html__('10 stars', 'healthandcare'),
						'100'=>esc_html__('100%', 'healthandcare')
					),
					"type" => "radio",
					),
		
		"reviews_style" => array(
					"title" => esc_html__('Show rating as',  'healthandcare'),
					"desc" => esc_html__("Show rating marks as text or as stars/progress bars.", 'healthandcare'),
					"std" => "stars",
					"options" => array(
						'text' => esc_html__('As text (for example: 7.5 / 10)', 'healthandcare'),
						'stars' => esc_html__('As stars or bars', 'healthandcare')
					),
					"dir" => "vertical",
					"type" => "radio"),
		
		"reviews_criterias_levels" => array(
					"title" => esc_html__('Reviews Criterias Levels', 'healthandcare'),
					"desc" => esc_html__('Words to mark criterials levels. Just write the word and press "Enter". Also you can arrange words.', 'healthandcare'),
					"std" => esc_html__("bad,poor,normal,good,great", 'healthandcare'),
					"type" => "tags"),
		
		"reviews_first" => array(
					"title" => esc_html__('Show first reviews',  'healthandcare'),
					"desc" => esc_html__("What reviews will be displayed first: by author or by visitors. Also this type of reviews will display under post's title.", 'healthandcare'),
					"std" => "author",
					"options" => array(
						'author' => esc_html__('By author', 'healthandcare'),
						'users' => esc_html__('By visitors', 'healthandcare')
						),
					"dir" => "horizontal",
					"type" => "radio"),
		
		"reviews_second" => array(
					"title" => esc_html__('Hide second reviews',  'healthandcare'),
					"desc" => esc_html__("Do you want hide second reviews tab in widgets and single posts?", 'healthandcare'),
					"std" => "show",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_show_hide'],
					"size" => "medium",
					"type" => "switch"),
		
		"reviews_can_vote" => array(
					"title" => esc_html__('What visitors can vote',  'healthandcare'),
					"desc" => esc_html__("What visitors can vote: all or only registered", 'healthandcare'),
					"std" => "all",
					"options" => array(
						'all'=>esc_html__('All visitors', 'healthandcare'),
						'registered'=>esc_html__('Only registered', 'healthandcare')
					),
					"dir" => "horizontal",
					"type" => "radio"),
		
		"reviews_criterias" => array(
					"title" => esc_html__('Reviews criterias',  'healthandcare'),
					"desc" => esc_html__('Add default reviews criterias.',  'healthandcare'),
					"override" => "category,services_group,services_group",
					"std" => "",
					"cloneable" => true,
					"type" => "text"),

		// Don't remove this parameter - it used in admin for store marks
		"reviews_marks" => array(
					"std" => "",
					"type" => "hidden"),
		





		//###############################
		//#### Media                #### 
		//###############################
		"partition_media" => array(
					"title" => esc_html__('Media', 'healthandcare'),
					"icon" => "iconadmin-picture",
					"override" => "category,services_group,post,page",
					"type" => "partition"),
		
		"info_media_1" => array(
					"title" => esc_html__('Media settings', 'healthandcare'),
					"desc" => esc_html__('Set up parameters to show images, galleries, audio and video posts', 'healthandcare'),
					"override" => "category,services_group,services_group",
					"type" => "info"),
					
		"retina_ready" => array(
					"title" => esc_html__('Image dimensions', 'healthandcare'),
					"desc" => esc_html__('What dimensions use for uploaded image: Original or "Retina ready" (twice enlarged)', 'healthandcare'),
					"std" => "1",
					"size" => "medium",
					"options" => array(
						"1" => esc_html__("Original", 'healthandcare'),
						"2" => esc_html__("Retina", 'healthandcare')
					),
					"type" => "switch"),
		
		"substitute_gallery" => array(
					"title" => esc_html__('Substitute standard Wordpress gallery', 'healthandcare'),
					"desc" => esc_html__('Substitute standard Wordpress gallery with our slider on the single pages', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"gallery_instead_image" => array(
					"title" => esc_html__('Show gallery instead featured image', 'healthandcare'),
					"desc" => esc_html__('Show slider with gallery instead featured image on blog streampage and in the related posts section for the gallery posts', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"gallery_max_slides" => array(
					"title" => esc_html__('Max images number in the slider', 'healthandcare'),
					"desc" => esc_html__('Maximum images number from gallery into slider', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"dependency" => array(
						'gallery_instead_image' => array('yes')
					),
					"std" => "5",
					"min" => 2,
					"max" => 10,
					"type" => "spinner"),
		
		"popup_engine" => array(
					"title" => esc_html__('Popup engine to zoom images', 'healthandcare'),
					"desc" => esc_html__('Select engine to show popup windows with images and galleries', 'healthandcare'),
					"std" => "magnific",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_popups'],
					"type" => "select"),
		
		"substitute_audio" => array(
					"title" => esc_html__('Substitute audio tags', 'healthandcare'),
					"desc" => esc_html__('Substitute audio tag with source from soundcloud to embed player', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"substitute_video" => array(
					"title" => esc_html__('Substitute video tags', 'healthandcare'),
					"desc" => esc_html__('Substitute video tags with embed players or leave video tags unchanged (if you use third party plugins for the video tags)', 'healthandcare'),
					"override" => "category,services_group,post,page",
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"use_mediaelement" => array(
					"title" => esc_html__('Use Media Element script for audio and video tags', 'healthandcare'),
					"desc" => esc_html__('Do you want use the Media Element script for all audio and video tags on your site or leave standard HTML5 behaviour?', 'healthandcare'),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		
		
		
		//###############################
		//#### Socials               #### 
		//###############################
		"partition_socials" => array(
					"title" => esc_html__('Socials', 'healthandcare'),
					"icon" => "iconadmin-users",
					"override" => "category,services_group,page",
					"type" => "partition"),
		
		"info_socials_1" => array(
					"title" => esc_html__('Social networks', 'healthandcare'),
					"desc" => esc_html__("Social networks list for site footer and Social widget", 'healthandcare'),
					"type" => "info"),
		
		"social_icons" => array(
					"title" => esc_html__('Social networks',  'healthandcare'),
					"desc" => esc_html__('Select icon and write URL to your profile in desired social networks.',  'healthandcare'),
					"std" => array(array('url'=>'', 'icon'=>'')),
					"cloneable" => true,
					"size" => "small",
					"style" => $socials_type,
					"options" => $socials_type=='images' ? $HEALTHANDCARE_GLOBALS['options_params']['list_socials'] : $HEALTHANDCARE_GLOBALS['options_params']['list_icons'],
					"type" => "socials"),
		
		"info_socials_2" => array(
					"title" => esc_html__('Share buttons', 'healthandcare'),
					"desc" => __("Add button's code for each social share network.<br>
					In share url you can use next macro:<br>
					<b>{url}</b> - share post (page) URL,<br>
					<b>{title}</b> - post title,<br>
					<b>{image}</b> - post image,<br>
					<b>{descr}</b> - post description (if supported)<br>
					For example:<br>
					<b>Facebook</b> share string: <em>http://www.facebook.com/sharer.php?u={link}&amp;t={title}</em><br>
					<b>Delicious</b> share string: <em>http://delicious.com/save?url={link}&amp;title={title}&amp;note={descr}</em>", 'healthandcare'),
					"override" => "category,services_group,page",
					"type" => "info"),
		
		"show_share" => array(
					"title" => esc_html__('Show social share buttons',  'healthandcare'),
					"desc" => esc_html__("Show social share buttons block", 'healthandcare'),
					"override" => "category,services_group,page",
					"std" => "horizontal",
					"options" => array(
						'hide'		=> esc_html__('Hide', 'healthandcare'),
						'vertical'	=> esc_html__('Vertical', 'healthandcare'),
						'horizontal'=> esc_html__('Horizontal', 'healthandcare')
					),
					"type" => "checklist"),

		"show_share_counters" => array(
					"title" => esc_html__('Show share counters',  'healthandcare'),
					"desc" => esc_html__("Show share counters after social buttons", 'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_share' => array('vertical', 'horizontal')
					),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"share_caption" => array(
					"title" => esc_html__('Share block caption',  'healthandcare'),
					"desc" => esc_html__('Caption for the block with social share buttons',  'healthandcare'),
					"override" => "category,services_group,page",
					"dependency" => array(
						'show_share' => array('vertical', 'horizontal')
					),
					"std" => esc_html__('Share:', 'healthandcare'),
					"type" => "text"),
		
		"share_buttons" => array(
					"title" => esc_html__('Share buttons',  'healthandcare'),
					"desc" => __('Select icon and write share URL for desired social networks.<br><b>Important!</b> If you leave text field empty - internal theme link will be used (if present).',  'healthandcare'),
					"dependency" => array(
						'show_share' => array('vertical', 'horizontal')
					),
					"std" => array(array('url'=>'', 'icon'=>'')),
					"cloneable" => true,
					"size" => "small",
					"style" => $socials_type,
					"options" => $socials_type=='images' ? $HEALTHANDCARE_GLOBALS['options_params']['list_socials'] : $HEALTHANDCARE_GLOBALS['options_params']['list_icons'],
					"type" => "socials"),

		
		//###############################
		//#### Contact info          #### 
		//###############################
		"partition_contacts" => array(
					"title" => esc_html__('Contact info', 'healthandcare'),
					"icon" => "iconadmin-mail",
					"type" => "partition"),
		
		"info_contact_1" => array(
					"title" => esc_html__('Contact information', 'healthandcare'),
					"desc" => esc_html__('Company address, phones and e-mail', 'healthandcare'),
					"type" => "info"),
		
		"contact_info" => array(
					"title" => esc_html__('Contacts in the header', 'healthandcare'),
					"desc" => esc_html__('String with contact info in the left side of the site header', 'healthandcare'),
					"std" => "100 E 77th St, New York, New York 10075",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),
		
		"contact_open_hours" => array(
					"title" => esc_html__('Open hours in the header', 'healthandcare'),
					"desc" => esc_html__('String with open hours in the site header', 'healthandcare'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-clock'),
					"type" => "text"),
		
		"contact_email" => array(
					"title" => esc_html__('Contact form email', 'healthandcare'),
					"desc" => esc_html__('E-mail for send contact form and user registration data', 'healthandcare'),
					"std" => "info@ancora.com",
					"before" => array('icon'=>'iconadmin-mail'),
					"type" => "text"),
		
		"contact_address_1" => array(
					"title" => esc_html__('Company address (part 1)', 'healthandcare'),
					"desc" => esc_html__('Company country, post code and city', 'healthandcare'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),
		
		"contact_address_2" => array(
					"title" => esc_html__('Company address (part 2)', 'healthandcare'),
					"desc" => esc_html__('Street and house number', 'healthandcare'),
					"std" => "600 E 77th St	<br> New York, New York 10075",
					"before" => array('icon'=>'iconadmin-home'),
					"type" => "text"),
		
		"contact_phone" => array(
					"title" => esc_html__('Phone', 'healthandcare'),
					"desc" => esc_html__('Phone number', 'healthandcare'),
					"std" => "(212) 434-2000",
					"before" => array('icon'=>'iconadmin-phone'),
					"type" => "text"),
		
		"contact_fax" => array(
					"title" => esc_html__('Fax', 'healthandcare'),
					"desc" => esc_html__('Fax number', 'healthandcare'),
					"std" => "",
					"before" => array('icon'=>'iconadmin-phone'),
					"type" => "text"),
		
		"info_contact_2" => array(
					"title" => esc_html__('Contact and Comments form', 'healthandcare'),
					"desc" => esc_html__('Maximum length of the messages in the contact form shortcode and in the comments form', 'healthandcare'),
					"type" => "info"),
		
		"message_maxlength_contacts" => array(
					"title" => esc_html__('Contact form message', 'healthandcare'),
					"desc" => esc_html__("Message's maxlength in the contact form shortcode", 'healthandcare'),
					"std" => "1000",
					"min" => 0,
					"max" => 10000,
					"step" => 100,
					"type" => "spinner"),
		
		"message_maxlength_comments" => array(
					"title" => esc_html__('Comments form message', 'healthandcare'),
					"desc" => esc_html__("Message's maxlength in the comments form", 'healthandcare'),
					"std" => "1000",
					"min" => 0,
					"max" => 10000,
					"step" => 100,
					"type" => "spinner"),
		
		"info_contact_3" => array(
					"title" => esc_html__('Default mail function', 'healthandcare'),
					"desc" => esc_html__('What function you want to use for sending mail: the built-in Wordpress wp_mail() or standard PHP mail() function? Attention! Some plugins may not work with one of them and you always have the ability to switch to alternative.', 'healthandcare'),
					"type" => "info"),
		
		"mail_function" => array(
					"title" => esc_html__("Mail function", 'healthandcare'),
					"desc" => esc_html__("What function you want to use for sending mail?", 'healthandcare'),
					"std" => "wp_mail",
					"size" => "medium",
					"options" => array(
						'wp_mail' => esc_html__('WP mail', 'healthandcare'),
						'mail' => esc_html__('PHP mail', 'healthandcare')
					),
					"type" => "switch"),
		
		
		
		
		
		
		
		//###############################
		//#### Search parameters     #### 
		//###############################
		"partition_search" => array(
					"title" => esc_html__('Search', 'healthandcare'),
					"icon" => "iconadmin-search",
					"type" => "partition"),
		
		"info_search_1" => array(
					"title" => esc_html__('Search parameters', 'healthandcare'),
					"desc" => esc_html__('Enable/disable AJAX search and output settings for it', 'healthandcare'),
					"type" => "info"),
		
		"show_search" => array(
					"title" => esc_html__('Show search field', 'healthandcare'),
					"desc" => esc_html__('Show search field in the top area and side menus', 'healthandcare'),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"use_ajax_search" => array(
					"title" => esc_html__('Enable AJAX search', 'healthandcare'),
					"desc" => esc_html__('Use incremental AJAX search for the search field in top of page', 'healthandcare'),
					"dependency" => array(
						'show_search' => array('yes')
					),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"ajax_search_min_length" => array(
					"title" => esc_html__('Min search string length',  'healthandcare'),
					"desc" => esc_html__('The minimum length of the search string',  'healthandcare'),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"std" => 4,
					"min" => 3,
					"type" => "spinner"),
		
		"ajax_search_delay" => array(
					"title" => esc_html__('Delay before search (in ms)',  'healthandcare'),
					"desc" => esc_html__('How much time (in milliseconds, 1000 ms = 1 second) must pass after the last character before the start search',  'healthandcare'),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"std" => 500,
					"min" => 300,
					"max" => 1000,
					"step" => 100,
					"type" => "spinner"),
		
		"ajax_search_types" => array(
					"title" => esc_html__('Search area', 'healthandcare'),
					"desc" => esc_html__('Select post types, what will be include in search results. If not selected - use all types.', 'healthandcare'),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"std" => "",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_posts_types'],
					"multiple" => true,
					"style" => "list",
					"type" => "select"),
		
		"ajax_search_posts_count" => array(
					"title" => esc_html__('Posts number in output',  'healthandcare'),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"desc" => esc_html__('Number of the posts to show in search results',  'healthandcare'),
					"std" => 5,
					"min" => 1,
					"max" => 10,
					"type" => "spinner"),
		
		"ajax_search_posts_image" => array(
					"title" => esc_html__("Show post's image", 'healthandcare'),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"desc" => esc_html__("Show post's thumbnail in the search results", 'healthandcare'),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"ajax_search_posts_date" => array(
					"title" => esc_html__("Show post's date", 'healthandcare'),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"desc" => esc_html__("Show post's publish date in the search results", 'healthandcare'),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"ajax_search_posts_author" => array(
					"title" => esc_html__("Show post's author", 'healthandcare'),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"desc" => esc_html__("Show post's author in the search results", 'healthandcare'),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"ajax_search_posts_counters" => array(
					"title" => esc_html__("Show post's counters", 'healthandcare'),
					"dependency" => array(
						'show_search' => array('yes'),
						'use_ajax_search' => array('yes')
					),
					"desc" => esc_html__("Show post's counters (views, comments, likes) in the search results", 'healthandcare'),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		
		
		
		
		//###############################
		//#### Service               #### 
		//###############################
		
		"partition_service" => array(
					"title" => esc_html__('Service', 'healthandcare'),
					"icon" => "iconadmin-wrench",
					"type" => "partition"),
		
		"info_service_1" => array(
					"title" => esc_html__('Theme functionality', 'healthandcare'),
					"desc" => esc_html__('Basic theme functionality settings', 'healthandcare'),
					"type" => "info"),
		
		"notify_about_new_registration" => array(
					"title" => esc_html__('Notify about new registration', 'healthandcare'),
					"desc" => esc_html__('Send E-mail with new registration data to the contact email or to site admin e-mail (if contact email is empty)', 'healthandcare'),
					"divider" => false,
					"std" => "no",
					"options" => array(
						'no'    => esc_html__('No', 'healthandcare'),
						'both'  => esc_html__('Both', 'healthandcare'),
						'admin' => esc_html__('Admin', 'healthandcare'),
						'user'  => esc_html__('User', 'healthandcare')
					),
					"dir" => "horizontal",
					"type" => "checklist"),
		
		"use_ajax_views_counter" => array(
					"title" => esc_html__('Use AJAX post views counter', 'healthandcare'),
					"desc" => esc_html__('Use javascript for post views count (if site work under the caching plugin) or increment views count in single page template', 'healthandcare'),
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"allow_editor" => array(
					"title" => esc_html__('Frontend editor',  'healthandcare'),
					"desc" => esc_html__("Allow authors to edit their posts in frontend area)", 'healthandcare'),
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"admin_add_filters" => array(
					"title" => esc_html__('Additional filters in the admin panel', 'healthandcare'),
					"desc" => __('Show additional filters (on post formats, tags and categories) in admin panel page "Posts". <br>Attention! If you have more than 2.000-3.000 posts, enabling this option may cause slow load of the "Posts" page! If you encounter such slow down, simply open Appearance - Theme Options - Service and set "No" for this option.', 'healthandcare'),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_overriden_taxonomies" => array(
					"title" => esc_html__('Show overriden options for taxonomies', 'healthandcare'),
					"desc" => esc_html__('Show extra column in categories list, where changed (overriden) theme options are displayed.', 'healthandcare'),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"show_overriden_posts" => array(
					"title" => esc_html__('Show overriden options for posts and pages', 'healthandcare'),
					"desc" => esc_html__('Show extra column in posts and pages list, where changed (overriden) theme options are displayed.', 'healthandcare'),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"admin_dummy_data" => array(
					"title" => esc_html__('Enable Dummy Data Installer', 'healthandcare'),
					"desc" => __('Show "Install Dummy Data" in the menu "Appearance". <b>Attention!</b> When you install dummy data all content of your site will be replaced!', 'healthandcare'),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"admin_dummy_timeout" => array(
					"title" => esc_html__('Dummy Data Installer Timeout',  'healthandcare'),
					"desc" => esc_html__('Web-servers set the time limit for the execution of php-scripts. By default, this is 30 sec. Therefore, the import process will be split into parts. Upon completion of each part - the import will resume automatically! The import process will try to increase this limit to the time, specified in this field.',  'healthandcare'),
					"std" => 1200,
					"min" => 30,
					"max" => 1800,
					"type" => "spinner"),
		
		"admin_emailer" => array(
					"title" => esc_html__('Enable Emailer in the admin panel', 'healthandcare'),
					"desc" => esc_html__('Allow to use health and care Emailer for mass-volume e-mail distribution and management of mailing lists in "Appearance - Emailer"', 'healthandcare'),
					"std" => "yes",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),

		"admin_po_composer" => array(
					"title" => esc_html__('Enable PO Composer in the admin panel', 'healthandcare'),
					"desc" => esc_html__('Allow to use "PO Composer" for edit language files in this theme (in the "Appearance - PO Composer")', 'healthandcare'),
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		"debug_mode" => array(
					"title" => esc_html__('Debug mode', 'healthandcare'),
					"desc" => __('In debug mode we are using unpacked scripts and styles, else - using minified scripts and styles (if present). <b>Attention!</b> If you have modified the source code in the js or css files, regardless of this option will be used latest (modified) version stylesheets and scripts. You can re-create minified versions of files using on-line services (for example <a href="http://yui.2clics.net/" target="_blank">http://yui.2clics.net/</a>) or utility <b>yuicompressor-x.y.z.jar</b>', 'healthandcare'),
					"std" => "no",
					"options" => $HEALTHANDCARE_GLOBALS['options_params']['list_yes_no'],
					"type" => "switch"),
		
		
		"info_service_2" => array(
					"title" => esc_html__('Clear Wordpress cache', 'healthandcare'),
					"desc" => esc_html__('For example, it recommended after activating the WPML plugin - in the cache are incorrect data about the structure of categories and your site may display "white screen". After clearing the cache usually the performance of the site is restored.', 'healthandcare'),
					"type" => "info"),
		
		"clear_cache" => array(
					"title" => esc_html__('Clear cache', 'healthandcare'),
					"desc" => esc_html__('Clear Wordpress cache data', 'healthandcare'),
					"divider" => false,
					"icon" => "iconadmin-trash",
					"action" => "clear_cache",
					"type" => "button")
		);



		
		
		
		//###############################################
		//#### Hidden fields (for internal use only) #### 
		//###############################################
		/*
		$HEALTHANDCARE_GLOBALS['options']["custom_stylesheet_file"] = array(
			"title" => esc_html__('Custom stylesheet file', 'healthandcare'),
			"desc" => esc_html__('Path to the custom stylesheet (stored in the uploads folder)', 'healthandcare'),
			"std" => "",
			"type" => "hidden");
		
		$HEALTHANDCARE_GLOBALS['options']["custom_stylesheet_url"] = array(
			"title" => esc_html__('Custom stylesheet url', 'healthandcare'),
			"desc" => esc_html__('URL to the custom stylesheet (stored in the uploads folder)', 'healthandcare'),
			"std" => "",
			"type" => "hidden");
		*/

		
		
	}
}


// Update all temporary vars (start with $healthandcare_) in the Theme Options with actual lists
if ( !function_exists( 'healthandcare_options_settings_theme_setup2' ) ) {
	add_action( 'healthandcare_action_after_init_theme', 'healthandcare_options_settings_theme_setup2', 1 );
	function healthandcare_options_settings_theme_setup2() {
		if (healthandcare_options_is_used()) {
			global $HEALTHANDCARE_GLOBALS;
			// Replace arrays with actual parameters
			$lists = array();
			if (count($HEALTHANDCARE_GLOBALS['options']) > 0) {
				foreach ($HEALTHANDCARE_GLOBALS['options'] as $k=>$v) {
					if (isset($v['options']) && is_array($v['options']) && count($v['options']) > 0) {
						foreach ($v['options'] as $k1=>$v1) {
							if (healthandcare_substr($k1, 0, 15) == '$healthandcare_' || healthandcare_substr($v1, 0, 15) == '$healthandcare_') {
								$list_func = healthandcare_substr(healthandcare_substr($k1, 0, 15) == '$healthandcare_' ? $k1 : $v1, 1);
								unset($HEALTHANDCARE_GLOBALS['options'][$k]['options'][$k1]);
								if (isset($lists[$list_func]))
									$HEALTHANDCARE_GLOBALS['options'][$k]['options'] = healthandcare_array_merge($HEALTHANDCARE_GLOBALS['options'][$k]['options'], $lists[$list_func]);
								else {
									if (function_exists($list_func)) {
										$HEALTHANDCARE_GLOBALS['options'][$k]['options'] = $lists[$list_func] = healthandcare_array_merge($HEALTHANDCARE_GLOBALS['options'][$k]['options'], $list_func == 'healthandcare_get_list_menus' ? $list_func(true) : $list_func());
								   	} else
								   		echo sprintf(__('Wrong function name %s in the theme options array', 'healthandcare'), $list_func);
								}
							}
						}
					}
				}
			}
		}
	}
}

// Reset old Theme Options while theme first run
if ( !function_exists( 'healthandcare_options_reset' ) ) {
	function healthandcare_options_reset($clear=true) {
		$theme_data = wp_get_theme();
		$slug = str_replace(' ', '_', trim(healthandcare_strtolower((string) $theme_data->get('Name'))));
		$option_name = 'healthandcare_'.strip_tags($slug).'_options_reset';
		if ( get_option($option_name, false) === false ) {	// && (string) $theme_data->get('Version') == '1.0'
			if ($clear) {
				// Remove Theme Options from WP Options
				global $wpdb;
				$wpdb->query('delete from '.esc_sql($wpdb->options).' where option_name like "healthandcare_%"');
				// Add Templates Options
				if (file_exists(healthandcare_get_file_dir('demo/templates_options.txt'))) {
					$theme_options_txt = healthandcare_fgc(healthandcare_get_file_dir('demo/templates_options.txt'));
					$data = unserialize( base64_decode( $theme_options_txt) );
					// Replace upload url in options
					if (is_array($data) && count($data) > 0) {
						foreach ($data as $k=>$v) {
							if (is_array($v) && count($v) > 0) {
								foreach ($v as $k1=>$v1) {
									$v[$k1] = healthandcare_replace_uploads_url(healthandcare_replace_uploads_url($v1, 'uploads'), 'imports');
								}
							}
							add_option( $k, $v, '', 'yes' );
						}
					}
				}
			}
			add_option($option_name, 1, '', 'yes');
		}
	}
}
?>
