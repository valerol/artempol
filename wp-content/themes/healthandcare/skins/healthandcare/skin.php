<?php
/**
 * Skin file for the theme.
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('healthandcare_action_skin_theme_setup')) {
	add_action( 'healthandcare_action_init_theme', 'healthandcare_action_skin_theme_setup', 1 );
	function healthandcare_action_skin_theme_setup() {

		// Add skin fonts in the used fonts list
		add_filter('healthandcare_filter_used_fonts',			'healthandcare_filter_skin_used_fonts');
		// Add skin fonts (from Google fonts) in the main fonts list (if not present).
		add_filter('healthandcare_filter_list_fonts',			'healthandcare_filter_skin_list_fonts');

		// Add skin stylesheets
		add_action('healthandcare_action_add_styles',			'healthandcare_action_skin_add_styles');
		// Add skin inline styles
		add_filter('healthandcare_filter_add_styles_inline',		'healthandcare_filter_skin_add_styles_inline');
		// Add skin responsive styles
		add_action('healthandcare_action_add_responsive',		'healthandcare_action_skin_add_responsive');
		// Add skin responsive inline styles
		add_filter('healthandcare_filter_add_responsive_inline',	'healthandcare_filter_skin_add_responsive_inline');

		// Add skin scripts
		add_action('healthandcare_action_add_scripts',			'healthandcare_action_skin_add_scripts');
		// Add skin scripts inline
		add_action('healthandcare_action_add_scripts_inline',	'healthandcare_action_skin_add_scripts_inline');

		// Add skin less files into list for compilation
		add_filter('healthandcare_filter_compile_less',			'healthandcare_filter_skin_compile_less');


		/* Color schemes
		
		// Accenterd colors
		accent1			- theme accented color 1
		accent1_hover	- theme accented color 1 (hover state)
		accent2			- theme accented color 2
		accent2_hover	- theme accented color 2 (hover state)		
		accent3			- theme accented color 3
		accent3_hover	- theme accented color 3 (hover state)		
		
		// Headers, text and links
		text			- main content
		text_light		- post info
		text_dark		- headers
		inverse_text	- text on accented background
		inverse_light	- post info on accented background
		inverse_dark	- headers on accented background
		inverse_link	- links on accented background
		inverse_hover	- hovered links on accented background
		
		// Block's border and background
		bd_color		- border for the entire block
		bg_color		- background color for the entire block
		bg_image, bg_image_position, bg_image_repeat, bg_image_attachment  - first background image for the entire block
		bg_image2,bg_image2_position,bg_image2_repeat,bg_image2_attachment - second background image for the entire block
		
		// Alternative colors - highlight blocks, form fields, etc.
		alter_text		- text on alternative background
		alter_light		- post info on alternative background
		alter_dark		- headers on alternative background
		alter_link		- links on alternative background
		alter_hover		- hovered links on alternative background
		alter_bd_color	- alternative border
		alter_bd_hover	- alternative border for hovered state or active field
		alter_bg_color	- alternative background
		alter_bg_hover	- alternative background for hovered state or active field 
		alter_bg_image, alter_bg_image_position, alter_bg_image_repeat, alter_bg_image_attachment - background image for the alternative block
		
		*/

		// Add color schemes
		healthandcare_add_color_scheme('original', array(

			'title'					=> esc_html__('Original', 'healthandcare'),

			// Accent colors
			'accent1'				=> '#595d8f', // main violet
			'accent1_hover'			=> '#ff5b4f', // main red
//			'accent2'				=> '#ff5b4f',
//			'accent2_hover'			=> '#aa0000',
//			'accent3'				=> '',
//			'accent3_hover'			=> '',
			
			// Headers, text and links colors
			'text'					=> '#9b9cab', //main text color
			'text_light'			=> '#ff5b4f', //main text red
			'text_dark'				=> '#474761', //main heading color dark violet
			'inverse_text'			=> '#ffffff', //just white color for text
			'inverse_light'			=> '#a4a6b9', //gray text or with alpha chanel
			'inverse_dark'			=> '#595d8f', //main violet
			'inverse_link'			=> '#222222', //black for icon
			'inverse_hover'			=> '#8d8d9c', //gray dark
			
			// Whole block border and background
			'bd_color'				=> '#efefef', //main border color
			'bg_color'				=> '#ffffff', //main background color
			'bg_image'				=> '',
			'bg_image_position'		=> 'left top',
			'bg_image_repeat'		=> 'repeat',
			'bg_image_attachment'	=> 'scroll',
			'bg_image2'				=> '',
			'bg_image2_position'	=> 'left top',
			'bg_image2_repeat'		=> 'repeat',
			'bg_image2_attachment'	=> 'scroll',
		
			// Alternative blocks (submenu items, form's fields, etc.)
			'alter_text'			=> '#a4a6b9', //border color in before element
			'alter_light'			=> '#ffcd5f', //yellow line
			'alter_dark'			=> '#424459', //violet dark header
			'alter_link'			=> '#ffffff', //free
			'alter_hover'			=> '#8fcec5', //blue line
			'alter_bd_color'		=> '#8e91af', //free
			'alter_bd_hover'		=> '#ffffff', //free
			'alter_bg_color'		=> '#c6c8d9', //gray background used for page title
			'alter_bg_hover'		=> '#fafafa', //used for accordion
			'alter_bg_image'			=> '',
			'alter_bg_image_position'	=> 'left top',
			'alter_bg_image_repeat'		=> 'repeat',
			'alter_bg_image_attachment'	=> 'scroll',
			)
		);

		// Add color schemes
        healthandcare_add_color_scheme('dark_blue', array(

            'title'					=> esc_html__('Dark blue', 'healthandcare'),

            // Accent colors
            'accent1'				=> '#3156a4', // main violet
            'accent1_hover'			=> '#0484cf', // main red
//			'accent2'				=> '#ff5b4f',
//			'accent2_hover'			=> '#aa0000',
//			'accent3'				=> '',
//			'accent3_hover'			=> '',

            // Headers, text and links colors
            'text'					=> '#9b9cab', //main text color
            'text_light'			=> '#41b3e5', //main text red
            'text_dark'				=> '#474761', //main heading color dark violet
            'inverse_text'			=> '#ffffff', //just white color for text
            'inverse_light'			=> '#a4a6b9', //gray text or with alpha chanel
            'inverse_dark'			=> '#193776', //main violet
            'inverse_link'			=> '#222222', //black for icon
            'inverse_hover'			=> '#8d8d9c', //gray dark

            // Whole block border and background
            'bd_color'				=> '#efefef', //main border color
            'bg_color'				=> '#ffffff', //main background color
            'bg_image'				=> '',
            'bg_image_position'		=> 'left top',
            'bg_image_repeat'		=> 'repeat',
            'bg_image_attachment'	=> 'scroll',
            'bg_image2'				=> '',
            'bg_image2_position'	=> 'left top',
            'bg_image2_repeat'		=> 'repeat',
            'bg_image2_attachment'	=> 'scroll',

            // Alternative blocks (submenu items, form's fields, etc.)
            'alter_text'			=> '#a4a6b9', //border color in before element
            'alter_light'			=> '#41b3e5', //yellow line
            'alter_dark'			=> '#424459', //violet dark header
            'alter_link'			=> '#ffffff', //free
            'alter_hover'			=> '#193776', //blue line
            'alter_bd_color'		=> '#8e91af', //free
            'alter_bd_hover'		=> '#ffffff', //free
            'alter_bg_color'		=> '#c6c8d9', //gray background used for page title
            'alter_bg_hover'		=> '#fafafa', //used for accordion
            'alter_bg_image'			=> '',
            'alter_bg_image_position'	=> 'left top',
            'alter_bg_image_repeat'		=> 'repeat',
            'alter_bg_image_attachment'	=> 'scroll',
            )
        );
        // Add color schemes
        healthandcare_add_color_scheme('green', array(

            'title'					=> esc_html__('Green', 'healthandcare'),

            // Accent colors
            'accent1'				=> '#36aba7', // main violet
            'accent1_hover'			=> '#4dc4c0', // main red
//			'accent2'				=> '#ff5b4f',
//			'accent2_hover'			=> '#aa0000',
//			'accent3'				=> '',
//			'accent3_hover'			=> '',

            // Headers, text and links colors
            'text'					=> '#9b9cab', //main text color
            'text_light'			=> '#4dc4c0', //main text red
            'text_dark'				=> '#474761', //main heading color dark violet
            'inverse_text'			=> '#ffffff', //just white color for text
            'inverse_light'			=> '#a4a6b9', //gray text or with alpha chanel
            'inverse_dark'			=> '#36aba7', //main violet
            'inverse_link'			=> '#222222', //black for icon
            'inverse_hover'			=> '#8d8d9c', //gray dark

            // Whole block border and background
            'bd_color'				=> '#efefef', //main border color
            'bg_color'				=> '#ffffff', //main background color
            'bg_image'				=> '',
            'bg_image_position'		=> 'left top',
            'bg_image_repeat'		=> 'repeat',
            'bg_image_attachment'	=> 'scroll',
            'bg_image2'				=> '',
            'bg_image2_position'	=> 'left top',
            'bg_image2_repeat'		=> 'repeat',
            'bg_image2_attachment'	=> 'scroll',

            // Alternative blocks (submenu items, form's fields, etc.)
            'alter_text'			=> '#a4a6b9', //border color in before element
            'alter_light'			=> '#bbbbbb', //yellow line
            'alter_dark'			=> '#424459', //violet dark header
            'alter_link'			=> '#ffffff', //free
            'alter_hover'			=> '#e82624', //blue line
            'alter_bd_color'		=> '#8e91af', //free
            'alter_bd_hover'		=> '#ffffff', //free
            'alter_bg_color'		=> '#c6c8d9', //gray background used for page title
            'alter_bg_hover'		=> '#fafafa', //used for accordion
            'alter_bg_image'			=> '',
            'alter_bg_image_position'	=> 'left top',
            'alter_bg_image_repeat'		=> 'repeat',
            'alter_bg_image_attachment'	=> 'scroll',
            )
        );
        // Add color schemes
        healthandcare_add_color_scheme('colored', array(

            'title'					=> esc_html__('Colored', 'healthandcare'),

            // Accent colors
            'accent1'				=> '#69c8f8', // main violet
            'accent1_hover'			=> '#d56c9c', // main red
//			'accent2'				=> '#ff5b4f',
//			'accent2_hover'			=> '#aa0000',
//			'accent3'				=> '',
//			'accent3_hover'			=> '',

            // Headers, text and links colors
            'text'					=> '#9b9cab', //main text color
            'text_light'			=> '#d56c9c', //main text red
            'text_dark'				=> '#474761', //main heading color dark violet
            'inverse_text'			=> '#ffffff', //just white color for text
            'inverse_light'			=> '#a4a6b9', //gray text or with alpha chanel
            'inverse_dark'			=> '#69c8f8', //main violet
            'inverse_link'			=> '#222222', //black for icon
            'inverse_hover'			=> '#8d8d9c', //gray dark

            // Whole block border and background
            'bd_color'				=> '#efefef', //main border color
            'bg_color'				=> '#ffffff', //main background color
            'bg_image'				=> '',
            'bg_image_position'		=> 'left top',
            'bg_image_repeat'		=> 'repeat',
            'bg_image_attachment'	=> 'scroll',
            'bg_image2'				=> '',
            'bg_image2_position'	=> 'left top',
            'bg_image2_repeat'		=> 'repeat',
            'bg_image2_attachment'	=> 'scroll',

            // Alternative blocks (submenu items, form's fields, etc.)
            'alter_text'			=> '#a4a6b9', //border color in before element
            'alter_light'			=> '#a361d1', //yellow line
            'alter_dark'			=> '#424459', //violet dark header
            'alter_link'			=> '#ffffff', //free
            'alter_hover'			=> '#e98b71', //blue line
            'alter_bd_color'		=> '#8e91af', //free
            'alter_bd_hover'		=> '#ffffff', //free
            'alter_bg_color'		=> '#c6c8d9', //gray background used for page title
            'alter_bg_hover'		=> '#fafafa', //used for accordion
            'alter_bg_image'			=> '',
            'alter_bg_image_position'	=> 'left top',
            'alter_bg_image_repeat'		=> 'repeat',
            'alter_bg_image_attachment'	=> 'scroll',
            )
        );

		/* Font slugs:
		h1 ... h6	- headers
		p			- plain text
		link		- links
		info		- info blocks (Posted 15 May, 2015 by John Doe)
		menu		- main menu
		submenu		- dropdown menus
		logo		- logo text
		button		- button's caption
		input		- input fields
		*/

		// Add Custom fonts
		healthandcare_add_custom_font('h1', array(
			'title'			=> esc_html__('Heading 1', 'healthandcare'),
			'description'	=> '',
			'font-family'	=> 'Open Sans Condensed',
			'font-size' 	=> '3.462rem',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '',
			'margin-bottom'	=> '1.61538rem'
			)
		);
		healthandcare_add_custom_font('h2', array(
			'title'			=> esc_html__('Heading 2', 'healthandcare'),
			'description'	=> '',
			'font-family'	=> 'Open Sans Condensed',
			'font-size' 	=> '2.692rem',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '3.15384rem',
			'margin-bottom'	=> '0.92307rem'
			)
		);
		healthandcare_add_custom_font('h3', array(
			'title'			=> esc_html__('Heading 3', 'healthandcare'),
			'description'	=> '',
			'font-family'	=> 'Open Sans Condensed',
			'font-size' 	=> '1.923rem',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '3.38461rem',
			'margin-bottom'	=> '1.69230rem'
			)
		);
		healthandcare_add_custom_font('h4', array(
			'title'			=> esc_html__('Heading 4', 'healthandcare'),
			'description'	=> '',
			'font-family'	=> 'Open Sans Condensed',
			'font-size' 	=> '1.538rem',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '3.53846rem',
			'margin-bottom'	=> '1.30769rem'
			)
		);
		healthandcare_add_custom_font('h5', array(
			'title'			=> esc_html__('Heading 5', 'healthandcare'),
			'description'	=> '',
			'font-family'	=> 'Open Sans',
			'font-size' 	=> '1.385rem',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '3.23076rem',
			'margin-bottom'	=> '1.38461rem'
			)
		);
		healthandcare_add_custom_font('h6', array(
			'title'			=> esc_html__('Heading 6', 'healthandcare'),
			'description'	=> '',
			'font-family'	=> 'Open Sans',
			'font-size' 	=> '1.154rem',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '2.46153rem',
			'margin-bottom'	=> '0.92307rem'
			)
		);
		healthandcare_add_custom_font('p', array(
			'title'			=> esc_html__('Text', 'healthandcare'),
			'description'	=> '',
			'font-family'	=> 'Open Sans',
			'font-size' 	=> '13px',
			'font-weight'	=> '600',
			'font-style'	=> '',
			'line-height'	=> '1.846em',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
		healthandcare_add_custom_font('link', array(
			'title'			=> esc_html__('Links', 'healthandcare'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> ''
			)
		);
		healthandcare_add_custom_font('info', array(
			'title'			=> esc_html__('Post info', 'healthandcare'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> 'i',
			'line-height'	=> '1.3em',
			'margin-top'	=> '',
			'margin-bottom'	=> '1.5em'
			)
		);
		healthandcare_add_custom_font('menu', array(
			'title'			=> esc_html__('Main menu items', 'healthandcare'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1em',
			'margin-top'	=> '1.8em',
			'margin-bottom'	=> '1.8em'
			)
		);
		healthandcare_add_custom_font('submenu', array(
			'title'			=> esc_html__('Dropdown menu items', 'healthandcare'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
		healthandcare_add_custom_font('logo', array(
			'title'			=> esc_html__('Logo', 'healthandcare'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '1.923rem',
			'font-weight'	=> '700',
			'font-style'	=> '',
			'line-height'	=> '1em',
			'margin-top'	=> '1.61538rem',
			'margin-bottom'	=> '1.84615rem'
			)
		);
		healthandcare_add_custom_font('button', array(
			'title'			=> esc_html__('Buttons', 'healthandcare'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.3em'
			)
		);
		healthandcare_add_custom_font('input', array(
			'title'			=> esc_html__('Input fields', 'healthandcare'),
			'description'	=> '',
			'font-family'	=> '',
			'font-size' 	=> '',
			'font-weight'	=> '',
			'font-style'	=> '',
			'line-height'	=> '1.3em'
			)
		);

	}
}





//------------------------------------------------------------------------------
// Skin's fonts
//------------------------------------------------------------------------------

// Add skin fonts in the used fonts list
if (!function_exists('healthandcare_filter_skin_used_fonts')) {
	//add_filter('healthandcare_filter_used_fonts', 'healthandcare_filter_skin_used_fonts');
	function healthandcare_filter_skin_used_fonts($theme_fonts) {
		//$theme_fonts['Roboto'] = 1;
		//$theme_fonts['Love Ya Like A Sister'] = 1;
        $theme_fonts['Open Sans'] = 1;
        $theme_fonts['Open Sans Condensed'] = 1;
        $theme_fonts['Lato'] = 1;
		return $theme_fonts;
	}
}

// Add skin fonts (from Google fonts) in the main fonts list (if not present).
// To use custom font-face you not need add it into list in this function
// How to install custom @font-face fonts into the theme?
// All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!
// Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.
// Create your @font-face kit by using Fontsquirrel @font-face Generator (http://www.fontsquirrel.com/fontface/generator)
// and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install
if (!function_exists('healthandcare_filter_skin_list_fonts')) {
	//add_filter('healthandcare_filter_list_fonts', 'healthandcare_filter_skin_list_fonts');
	function healthandcare_filter_skin_list_fonts($list) {
		// Example:
		// if (!isset($list['Advent Pro'])) {
		//		$list['Advent Pro'] = array(
		//			'family' => 'sans-serif',																						// (required) font family
		//			'link'   => 'Advent+Pro:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic',	// (optional) if you use Google font repository
		//			'css'    => healthandcare_get_file_url('/css/font-face/Advent-Pro/stylesheet.css')									// (optional) if you use custom font-face
		//			);
		// }
        if (!isset($list['Open Sans']))	$list['Open Sans'] = array('family'=>'sans-serif', 'link'=>'Open+Sans:700,600');
        if (!isset($list['Open Sans Condensed']))	$list['Open Sans Condensed'] = array('family'=>'sans-serif', 'link'=>'Open+Sans+Condensed:700');
        if (!isset($list['Lato']))	$list['Lato'] = array('family'=>'sans-serif', 'link'=>'Lato:400,900');
		return $list;
	}
}



//------------------------------------------------------------------------------
// Skin's stylesheets
//------------------------------------------------------------------------------
// Add skin stylesheets
if (!function_exists('healthandcare_action_skin_add_styles')) {
	//add_action('healthandcare_action_add_styles', 'healthandcare_action_skin_add_styles');
	function healthandcare_action_skin_add_styles() {
		// Add stylesheet files
		healthandcare_enqueue_style( 'healthandcare-skin-style', healthandcare_get_file_url('skin.css'), array(), null );
		if (file_exists(healthandcare_get_file_dir('skin.customizer.css')))
			healthandcare_enqueue_style( 'healthandcare-skin-customizer-style', healthandcare_get_file_url('skin.customizer.css'), array(), null );
	}
}

// Add skin inline styles
if (!function_exists('healthandcare_filter_skin_add_styles_inline')) {
	//add_filter('healthandcare_filter_add_styles_inline', 'healthandcare_filter_skin_add_styles_inline');
	function healthandcare_filter_skin_add_styles_inline($custom_style) {
		// Todo: add skin specific styles in the $custom_style to override
		//       rules from style.css and shortcodes.css
		// Example:
		//		$scheme = healthandcare_get_custom_option('body_scheme');
		//		if (empty($scheme)) $scheme = 'original';
		//		$clr = healthandcare_get_scheme_color('accent1');
		//		if (!empty($clr)) {
		// 			$custom_style .= '
		//				a,
		//				.bg_tint_light a,
		//				.top_panel .content .search_wrap.search_style_regular .search_form_wrap .search_submit,
		//				.top_panel .content .search_wrap.search_style_regular .search_icon,
		//				.search_results .post_more,
		//				.search_results .search_results_close {
		//					color:'.esc_attr($clr).';
		//				}
		//			';
		//		}
		return $custom_style;	
	}
}

// Add skin responsive styles
if (!function_exists('healthandcare_action_skin_add_responsive')) {
	//add_action('healthandcare_action_add_responsive', 'healthandcare_action_skin_add_responsive');
	function healthandcare_action_skin_add_responsive() {
		$suffix = healthandcare_param_is_off(healthandcare_get_custom_option('show_sidebar_outer')) ? '' : '-outer';
		if (file_exists(healthandcare_get_file_dir('skin.responsive'.($suffix).'.css')))
			healthandcare_enqueue_style( 'theme-skin-responsive-style', healthandcare_get_file_url('skin.responsive'.($suffix).'.css'), array(), null );
	}
}

// Add skin responsive inline styles
if (!function_exists('healthandcare_filter_skin_add_responsive_inline')) {
	//add_filter('healthandcare_filter_add_responsive_inline', 'healthandcare_filter_skin_add_responsive_inline');
	function healthandcare_filter_skin_add_responsive_inline($custom_style) {
		return $custom_style;	
	}
}

// Add skin.less into list files for compilation
if (!function_exists('healthandcare_filter_skin_compile_less')) {
	//add_filter('healthandcare_filter_compile_less', 'healthandcare_filter_skin_compile_less');
	function healthandcare_filter_skin_compile_less($files) {
		if (file_exists(healthandcare_get_file_dir('skin.less'))) {
		 	$files[] = healthandcare_get_file_dir('skin.less');
		 	$files[] = healthandcare_get_file_dir('skin.responsive.less');
		 	$files[] = healthandcare_get_file_dir('skin.responsive-outer.less');
		}
		return $files;	
	}
}



//------------------------------------------------------------------------------
// Skin's scripts
//------------------------------------------------------------------------------

// Add skin scripts
if (!function_exists('healthandcare_action_skin_add_scripts')) {
	//add_action('healthandcare_action_add_scripts', 'healthandcare_action_skin_add_scripts');
	function healthandcare_action_skin_add_scripts() {
		if (file_exists(healthandcare_get_file_dir('skin.js')))
			healthandcare_enqueue_script( 'theme-skin-script', healthandcare_get_file_url('skin.js'), array(), null );
		if (healthandcare_get_theme_option('show_theme_customizer') == 'yes' && file_exists(healthandcare_get_file_dir('skin.customizer.js')))
			healthandcare_enqueue_script( 'theme-skin-customizer-script', healthandcare_get_file_url('skin.customizer.js'), array(), null );
	}
}

// Add skin scripts inline
if (!function_exists('healthandcare_action_skin_add_scripts_inline')) {
	//add_action('healthandcare_action_add_scripts_inline', 'healthandcare_action_skin_add_scripts_inline');
	function healthandcare_action_skin_add_scripts_inline() {
		// Todo: add skin specific scripts
		// Example:
		// echo '<script type="text/javascript">'
		//	. 'jQuery(document).ready(function() {'
		//	. "if (HEALTHANDCARE_GLOBALS['theme_font']=='') HEALTHANDCARE_GLOBALS['theme_font'] = '" . healthandcare_get_custom_font_settings('p', 'font-family') . "';"
		//	. "HEALTHANDCARE_GLOBALS['theme_skin_color'] = '" . healthandcare_get_scheme_color('accent1') . "';"
		//	. "});"
		//	. "< /script>";
	}
}
?>