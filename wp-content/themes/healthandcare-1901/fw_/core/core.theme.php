<?php
/**
 * HealthandCARE Framework: Theme specific actions
 *
 * @package	healthandcare
 * @since	healthandcare 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'healthandcare_core_theme_setup' ) ) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_core_theme_setup', 11 );
	function healthandcare_core_theme_setup() {

		// Add default posts and comments RSS feed links to head 
		add_theme_support( 'automatic-feed-links' );
		
		// Enable support for Post Thumbnails
		add_theme_support( 'post-thumbnails' );
		
		// Custom header setup
		add_theme_support( 'custom-header', array('header-text'=>false));
		
		// Custom backgrounds setup
		add_theme_support( 'custom-background');
		
		// Supported posts formats
		add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat') ); 
 
 		// Autogenerate title tag
		add_theme_support('title-tag');
 		
		// Add user menu
		add_theme_support('nav-menus');
		
		// WooCommerce Support
		add_theme_support( 'woocommerce' );
		
		// Editor custom stylesheet - for user
		add_editor_style(healthandcare_get_file_url('css/editor-style.css'));
		
		// Make theme available for translation
		// Translations can be filed in the /languages/ directory
		load_theme_textdomain( 'healthandcare', healthandcare_get_folder_dir('languages') );


		/* Front and Admin actions and filters:
		------------------------------------------------------------------------ */

		if ( !is_admin() ) {
			
			/* Front actions and filters:
			------------------------------------------------------------------------ */

			// Get theme calendar (instead standard WP calendar) to support Events
			add_filter( 'get_calendar',						'healthandcare_get_calendar' );
	
			// Filters wp_title to print a neat <title> tag based on what is being viewed
			if (floatval(get_bloginfo('version')) < "4.1") {
				add_filter('wp_title',						'healthandcare_wp_title', 10, 2);
			}

			// Add main menu classes
			//add_filter('wp_nav_menu_objects', 			'healthandcare_add_mainmenu_classes', 10, 2);
	
			// Prepare logo text
			add_filter('healthandcare_filter_prepare_logo_text',	'healthandcare_prepare_logo_text', 10, 1);
	
			// Add class "widget_number_#' for each widget
			add_filter('dynamic_sidebar_params', 			'healthandcare_add_widget_number', 10, 1);

			// Frontend editor: Save post data
			add_action('wp_ajax_frontend_editor_save',		'healthandcare_callback_frontend_editor_save');
			add_action('wp_ajax_nopriv_frontend_editor_save', 'healthandcare_callback_frontend_editor_save');

			// Frontend editor: Delete post
			add_action('wp_ajax_frontend_editor_delete', 	'healthandcare_callback_frontend_editor_delete');
			add_action('wp_ajax_nopriv_frontend_editor_delete', 'healthandcare_callback_frontend_editor_delete');
	
			// Enqueue scripts and styles
			add_action('wp_enqueue_scripts', 				'healthandcare_core_frontend_scripts');
			add_action('wp_footer',		 					'healthandcare_core_frontend_scripts_inline');
			add_action('healthandcare_action_add_scripts_inline','healthandcare_core_add_scripts_inline');

			// Prepare theme core global variables
			add_action('healthandcare_action_prepare_globals',	'healthandcare_core_prepare_globals');

		}

		// Register theme specific nav menus
		healthandcare_register_theme_menus();

		// Register theme specific sidebars
		healthandcare_register_theme_sidebars();
	}
}




/* Theme init
------------------------------------------------------------------------ */

// Init theme template
function healthandcare_core_init_theme() {
	global $HEALTHANDCARE_GLOBALS;
	if (!empty($HEALTHANDCARE_GLOBALS['theme_inited'])) return;
	$HEALTHANDCARE_GLOBALS['theme_inited'] = true;

	// Load custom options from GET and post/page/cat options
	if (isset($_GET['set']) && $_GET['set']==1) {
		foreach ($_GET as $k=>$v) {
			if (healthandcare_get_theme_option($k, null) !== null) {
				setcookie($k, $v, 0, '/');
				$_COOKIE[$k] = $v;
			}
		}
	}

	// Get custom options from current category / page / post / shop / event
	healthandcare_load_custom_options();

	// Load skin
	$skin = healthandcare_esc(healthandcare_get_custom_option('theme_skin'));
	$HEALTHANDCARE_GLOBALS['theme_skin'] = $skin;
	if ( file_exists(healthandcare_get_file_dir('skins/'.($skin).'/skin.php')) ) {
		require_once( healthandcare_get_file_dir('skins/'.($skin).'/skin.php') );
	}

	// Fire init theme actions (after skin and custom options are loaded)
	do_action('healthandcare_action_init_theme');

	// Prepare theme core global variables
	do_action('healthandcare_action_prepare_globals');

	// Fire after init theme actions
	do_action('healthandcare_action_after_init_theme');
}


// Prepare theme global variables
if ( !function_exists( 'healthandcare_core_prepare_globals' ) ) {
	function healthandcare_core_prepare_globals() {
		if (!is_admin()) {
			// AJAX Queries settings
			global $HEALTHANDCARE_GLOBALS;
			$HEALTHANDCARE_GLOBALS['ajax_nonce'] = wp_create_nonce('ajax_nonce');
			$HEALTHANDCARE_GLOBALS['ajax_url'] = admin_url('admin-ajax.php');
		
			// Logo text and slogan
			$HEALTHANDCARE_GLOBALS['logo_text'] = apply_filters('healthandcare_filter_prepare_logo_text', healthandcare_get_custom_option('logo_text'));
			$slogan = healthandcare_get_custom_option('logo_slogan');
			if (!$slogan) $slogan = get_bloginfo ( 'description' );
			$HEALTHANDCARE_GLOBALS['logo_slogan'] = $slogan;
			
			// Logo image and icons from skin
			$logo_side   = healthandcare_get_logo_icon('logo_side');
			$logo_fixed  = healthandcare_get_logo_icon('logo_fixed');
			$logo_footer = healthandcare_get_logo_icon('logo_footer');
			$HEALTHANDCARE_GLOBALS['logo']        = healthandcare_get_logo_icon('logo');
			$HEALTHANDCARE_GLOBALS['logo_icon']   = healthandcare_get_logo_icon('logo_icon');
			$HEALTHANDCARE_GLOBALS['logo_side']   = $logo_side   ? $logo_side   : $HEALTHANDCARE_GLOBALS['logo'];
			$HEALTHANDCARE_GLOBALS['logo_fixed']  = $logo_fixed  ? $logo_fixed  : $HEALTHANDCARE_GLOBALS['logo'];
			$HEALTHANDCARE_GLOBALS['logo_footer'] = $logo_footer ? $logo_footer : $HEALTHANDCARE_GLOBALS['logo'];
	
			$shop_mode = '';
			if (healthandcare_get_custom_option('show_mode_buttons')=='yes')
				$shop_mode = healthandcare_get_value_gpc('healthandcare_shop_mode');
			if (empty($shop_mode))
				$shop_mode = healthandcare_get_custom_option('shop_mode', '');
			if (empty($shop_mode) || !is_archive())
				$shop_mode = 'thumbs';
			$HEALTHANDCARE_GLOBALS['shop_mode'] = $shop_mode;
		}
	}
}


// Return url for the uploaded logo image or (if not uploaded) - to image from skin folder
if ( !function_exists( 'healthandcare_get_logo_icon' ) ) {
	function healthandcare_get_logo_icon($slug) {
		$logo_icon = healthandcare_get_custom_option($slug);
		return $logo_icon;
	}
}


// Add menu locations
if ( !function_exists( 'healthandcare_register_theme_menus' ) ) {
	function healthandcare_register_theme_menus() {
		register_nav_menus(apply_filters('healthandcare_filter_add_theme_menus', array(
			'menu_main'		=> esc_html__('Main Menu', 'healthandcare'),
			'menu_user'		=> esc_html__('User Menu', 'healthandcare'),
			'menu_footer'	=> esc_html__('Footer Menu', 'healthandcare'),
			'menu_side'		=> esc_html__('Side Menu', 'healthandcare')
		)));
	}
}


// Register widgetized area
if ( !function_exists( 'healthandcare_register_theme_sidebars' ) ) {
	function healthandcare_register_theme_sidebars($sidebars=array()) {
		global $HEALTHANDCARE_GLOBALS;
		if (!is_array($sidebars)) $sidebars = array();
		// Custom sidebars
		$custom = healthandcare_get_theme_option('custom_sidebars');
		if (is_array($custom) && count($custom) > 0) {
			foreach ($custom as $i => $sb) {
				if (trim(chop($sb))=='') continue;
				$sidebars['sidebar_custom_'.($i)]  = $sb;
			}
		}
		$sidebars = apply_filters( 'healthandcare_filter_add_theme_sidebars', $sidebars );
		$HEALTHANDCARE_GLOBALS['registered_sidebars'] = $sidebars;
		if (is_array($sidebars) && count($sidebars) > 0) {
			foreach ($sidebars as $id=>$name) {
				register_sidebar( array(
					'name'          => $name,
					'id'            => $id,
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h5 class="widget_title">',
					'after_title'   => '</h5>',
				) );
			}
		}
	}
}





/* Front actions and filters:
------------------------------------------------------------------------ */

//  Enqueue scripts and styles
if ( !function_exists( 'healthandcare_core_frontend_scripts' ) ) {
	function healthandcare_core_frontend_scripts() {
		global $HEALTHANDCARE_GLOBALS;

		// Modernizr will load in head before other scripts and styles
		//healthandcare_enqueue_script( 'healthandcare-core-modernizr-script', healthandcare_get_file_url('js/modernizr.js'), array(), null, false );

		// Enqueue styles
		//-----------------------------------------------------------------------------------------------------

		// Prepare custom fonts
		$fonts = healthandcare_get_list_fonts(false);
		$theme_fonts = array();
		$custom_fonts = healthandcare_get_custom_fonts();
		if (is_array($custom_fonts) && count($custom_fonts) > 0) {
			foreach ($custom_fonts as $s=>$f) {
				if (!empty($f['font-family']) && !healthandcare_is_inherit_option($f['font-family'])) $theme_fonts[$f['font-family']] = 1;
			}
		}
		// Prepare current skin fonts
		$theme_fonts = apply_filters('healthandcare_filter_used_fonts', $theme_fonts);
		// Link to selected fonts
		if (is_array($theme_fonts) && count($theme_fonts) > 0) {
			foreach ($theme_fonts as $font=>$v) {
				if (isset($fonts[$font])) {
					$font_name = ($pos=healthandcare_strpos($font,' ('))!==false ? healthandcare_substr($font, 0, $pos) : $font;
					$css = !empty($fonts[$font]['css'])
						? $fonts[$font]['css']
						: 'http://fonts.googleapis.com/css?family='
							.(!empty($fonts[$font]['link']) ? $fonts[$font]['link'] : str_replace(' ', '+', $font_name).':100,100italic,300,300italic,400,400italic,700,700italic')
							.(empty($fonts[$font]['link']) || healthandcare_strpos($fonts[$font]['link'], 'subset=')===false ? '&subset=latin,latin-ext,cyrillic,cyrillic-ext' : '');
					healthandcare_enqueue_style( 'theme-font-'.str_replace(' ', '-', $font_name), $css, array(), null );
				}
			}
		}

		// Fontello styles must be loaded before main stylesheet
		healthandcare_enqueue_style( 'healthandcare-fontello-style',  healthandcare_get_file_url('css/fontello/css/fontello.css'),  array(), null);
		//healthandcare_enqueue_style( 'healthandcare-fontello-animation-style', healthandcare_get_file_url('css/fontello/css/animation.css'), array(), null);

		// Main stylesheet
		healthandcare_enqueue_style( 'healthandcare-main-style', get_stylesheet_uri(), array(), null );

		// Animations
		if (healthandcare_get_theme_option('css_animation')=='yes')
			healthandcare_enqueue_style( 'healthandcare-animation-style',	healthandcare_get_file_url('css/core.animation.css'), array(), null );

		// Theme skin stylesheet
		do_action('healthandcare_action_add_styles');

		// Theme customizer stylesheet and inline styles
		healthandcare_enqueue_custom_styles();

		// Responsive
		if (healthandcare_get_theme_option('responsive_layouts') == 'yes') {
			$suffix = healthandcare_param_is_off(healthandcare_get_custom_option('show_sidebar_outer')) ? '' : '-outer';
			healthandcare_enqueue_style( 'healthandcare-responsive-style', healthandcare_get_file_url('css/responsive'.($suffix).'.css'), array(), null );
			do_action('healthandcare_action_add_responsive');
			if (healthandcare_get_custom_option('theme_skin')!='') {
				$css = apply_filters('healthandcare_filter_add_responsive_inline', '');
				if (!empty($css)) wp_add_inline_style( 'healthandcare-responsive-style', $css );
			}
		}


		// Enqueue scripts
		//----------------------------------------------------------------------------------------------------------------------------

		// Load separate theme scripts
		healthandcare_enqueue_script( 'superfish', healthandcare_get_file_url('js/superfish.min.js'), array('jquery'), null, true );
		if (healthandcare_get_theme_option('menu_slider')=='yes') {
			healthandcare_enqueue_script( 'healthandcare-slidemenu-script', healthandcare_get_file_url('js/jquery.slidemenu.js'), array('jquery'), null, true );
			//healthandcare_enqueue_script( 'healthandcare-jquery-easing-script', healthandcare_get_file_url('js/jquery.easing.js'), array('jquery'), null, true );
		}

		if ( is_single() && healthandcare_get_custom_option('show_reviews')=='yes' ) {
			healthandcare_enqueue_script( 'healthandcare-core-reviews-script', healthandcare_get_file_url('js/core.reviews.js'), array('jquery'), null, true );
		}

		healthandcare_enqueue_script( 'healthandcare-core-utils-script', healthandcare_get_file_url('js/core.utils.js'), array('jquery'), null, true );
		healthandcare_enqueue_script( 'healthandcare-core-init-script', healthandcare_get_file_url('js/core.init.js'), array('jquery'), null, true );

		// Media elements library
		if (healthandcare_get_theme_option('use_mediaelement')=='yes') {
			wp_enqueue_style ( 'mediaelement' );
			wp_enqueue_style ( 'wp-mediaelement' );
			wp_enqueue_script( 'mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );
		} else {
			global $wp_styles, $wp_scripts;
			$wp_scripts->done[]	= 'mediaelement';
			$wp_scripts->done[]	= 'wp-mediaelement';
			$wp_styles->done[]	= 'mediaelement';
			$wp_styles->done[]	= 'wp-mediaelement';
		}

		// Video background
		if (healthandcare_get_custom_option('show_video_bg') == 'yes' && healthandcare_get_custom_option('video_bg_youtube_code') != '') {
			healthandcare_enqueue_script( 'healthandcare-video-bg-script', healthandcare_get_file_url('js/jquery.tubular.1.0.js'), array('jquery'), null, true );
		}

		// Google map
		if ( healthandcare_get_custom_option('show_googlemap')=='yes' ) {
			healthandcare_enqueue_script( 'googlemap', 'http://maps.google.com/maps/api/js?sensor=false', array(), null, true );
			healthandcare_enqueue_script( 'healthandcare-googlemap-script', healthandcare_get_file_url('js/core.googlemap.js'), array(), null, true );
		}

		if ( healthandcare_get_custom_option('show_googlemap_before_contact')=='yes' ) {
			healthandcare_enqueue_script( 'googlemap', 'http://maps.google.com/maps/api/js?sensor=false', array(), null, true );
			healthandcare_enqueue_script( 'healthandcare-googlemap-script', healthandcare_get_file_url('js/core.googlemap.js'), array(), null, true );
		}


		// Social share buttons
		if (is_singular() && !healthandcare_get_global('blog_streampage') && healthandcare_get_custom_option('show_share')!='hide') {
			healthandcare_enqueue_script( 'healthandcare-social-share-script', healthandcare_get_file_url('js/social/social-share.js'), array('jquery'), null, true );
		}

		// Comments
		if ( is_singular() && !healthandcare_get_global('blog_streampage') && comments_open() && get_option( 'thread_comments' ) ) {
			healthandcare_enqueue_script( 'comment-reply', false, array(), null, true );
		}

		// Custom panel
		if (healthandcare_get_theme_option('show_theme_customizer') == 'yes') {
			if (file_exists(healthandcare_get_file_dir('core/core.customizer/front.customizer.css')))
				healthandcare_enqueue_style(  'healthandcare-customizer-style',  healthandcare_get_file_url('core/core.customizer/front.customizer.css'), array(), null );
			if (file_exists(healthandcare_get_file_dir('core/core.customizer/front.customizer.js')))
				healthandcare_enqueue_script( 'healthandcare-customizer-script', healthandcare_get_file_url('core/core.customizer/front.customizer.js'), array(), null, true );
		}

		//Debug utils
		if (healthandcare_get_theme_option('debug_mode')=='yes') {
			healthandcare_enqueue_script( 'healthandcare-core-debug-script', healthandcare_get_file_url('js/core.debug.js'), array(), null, true );
		}

		// Theme skin script
		do_action('healthandcare_action_add_scripts');
	}
}

//  Enqueue Swiper Slider scripts and styles
if ( !function_exists( 'healthandcare_enqueue_slider' ) ) {
	function healthandcare_enqueue_slider($engine='all') {
		if ($engine=='all' || $engine=='swiper') {
			healthandcare_enqueue_style( 'healthandcare-swiperslider-style', 				healthandcare_get_file_url('js/swiper/idangerous.swiper.css'), array(), null );
			healthandcare_enqueue_script( 'healthandcare-swiperslider-script', 			healthandcare_get_file_url('js/swiper/idangerous.swiper-2.7.js'), array('jquery'), null, true );
			healthandcare_enqueue_script( 'healthandcare-swiperslider-scrollbar-script',	healthandcare_get_file_url('js/swiper/idangerous.swiper.scrollbar-2.4.js'), array('jquery'), null, true );
		}
	}
}

//  Enqueue Messages scripts and styles
if ( !function_exists( 'healthandcare_enqueue_messages' ) ) {
	function healthandcare_enqueue_messages() {
		healthandcare_enqueue_style( 'healthandcare-messages-style',		healthandcare_get_file_url('js/core.messages/core.messages.css'), array(), null );
		healthandcare_enqueue_script( 'healthandcare-messages-script',	healthandcare_get_file_url('js/core.messages/core.messages.js'),  array('jquery'), null, true );
	}
}

//  Enqueue Portfolio hover scripts and styles
if ( !function_exists( 'healthandcare_enqueue_portfolio' ) ) {
	function healthandcare_enqueue_portfolio($hover='') {
		healthandcare_enqueue_style( 'healthandcare-portfolio-style',  healthandcare_get_file_url('css/core.portfolio.css'), array(), null );
		if (healthandcare_strpos($hover, 'effect_dir')!==false)
			healthandcare_enqueue_script( 'hoverdir', healthandcare_get_file_url('js/hover/jquery.hoverdir.js'), array(), null, true );
	}
}

//  Enqueue Charts and Diagrams scripts and styles
if ( !function_exists( 'healthandcare_enqueue_diagram' ) ) {
	function healthandcare_enqueue_diagram($type='all') {
		if ($type=='all' || $type=='pie') healthandcare_enqueue_script( 'healthandcare-diagram-chart-script',	healthandcare_get_file_url('js/diagram/chart.min.js'), array(), null, true );
		if ($type=='all' || $type=='arc') healthandcare_enqueue_script( 'healthandcare-diagram-raphael-script',	healthandcare_get_file_url('js/diagram/diagram.raphael.min.js'), array(), 'no-compose', true );
	}
}

// Enqueue Theme Popup scripts and styles
// Link must have attribute: data-rel="popup" or data-rel="popup[gallery]"
if ( !function_exists( 'healthandcare_enqueue_popup' ) ) {
	function healthandcare_enqueue_popup($engine='') {
		if ($engine=='pretty' || (empty($engine) && healthandcare_get_theme_option('popup_engine')=='pretty')) {
			healthandcare_enqueue_style(  'healthandcare-prettyphoto-style',	healthandcare_get_file_url('js/prettyphoto/css/prettyPhoto.css'), array(), null );
			healthandcare_enqueue_script( 'healthandcare-prettyphoto-script',	healthandcare_get_file_url('js/prettyphoto/jquery.prettyPhoto.min.js'), array('jquery'), 'no-compose', true );
		} else if ($engine=='magnific' || (empty($engine) && healthandcare_get_theme_option('popup_engine')=='magnific')) {
			healthandcare_enqueue_style(  'healthandcare-magnific-style',	healthandcare_get_file_url('js/magnific/magnific-popup.css'), array(), null );
			healthandcare_enqueue_script( 'healthandcare-magnific-script',healthandcare_get_file_url('js/magnific/jquery.magnific-popup.min.js'), array('jquery'), '', true );
		} else if ($engine=='internal' || (empty($engine) && healthandcare_get_theme_option('popup_engine')=='internal')) {
			healthandcare_enqueue_messages();
		}
	}
}

//  Add inline scripts in the footer hook
if ( !function_exists( 'healthandcare_core_frontend_scripts_inline' ) ) {
	function healthandcare_core_frontend_scripts_inline() {
		do_action('healthandcare_action_add_scripts_inline');
	}
}

//  Add inline scripts in the footer
if (!function_exists('healthandcare_core_add_scripts_inline')) {
	function healthandcare_core_add_scripts_inline() {
		global $HEALTHANDCARE_GLOBALS;

		$msg = healthandcare_get_system_message(true);
		if (!empty($msg['message'])) healthandcare_enqueue_messages();

		echo "<script type=\"text/javascript\">"
			. "jQuery(document).ready(function() {"

			// AJAX parameters
			. "HEALTHANDCARE_GLOBALS['ajax_url']			= '" . esc_url($HEALTHANDCARE_GLOBALS['ajax_url']) . "';"
			. "HEALTHANDCARE_GLOBALS['ajax_nonce']		= '" . esc_attr($HEALTHANDCARE_GLOBALS['ajax_nonce']) . "';"
			. "HEALTHANDCARE_GLOBALS['ajax_nonce_editor'] = '" . esc_attr(wp_create_nonce('healthandcare_editor_nonce')) . "';"

			// Site base url
			. "HEALTHANDCARE_GLOBALS['site_url']			= '" . get_site_url() . "';"

			// VC frontend edit mode
			. "HEALTHANDCARE_GLOBALS['vc_edit_mode']		= " . (healthandcare_vc_is_frontend() ? 'true' : 'false') . ";"

			// Theme base font
			. "HEALTHANDCARE_GLOBALS['theme_font']		= '" . healthandcare_get_custom_font_settings('p', 'font-family') . "';"

			// Theme skin
			. "HEALTHANDCARE_GLOBALS['theme_skin']			= '" . esc_attr(healthandcare_get_custom_option('theme_skin')) . "';"
			. "HEALTHANDCARE_GLOBALS['theme_skin_color']		= '" . healthandcare_get_scheme_color('text_dark') . "';"
			. "HEALTHANDCARE_GLOBALS['theme_skin_bg_color']	= '" . healthandcare_get_scheme_color('bg_color') . "';"

			// Slider height
			. "HEALTHANDCARE_GLOBALS['slider_height']	= " . max(100, healthandcare_get_custom_option('slider_height')) . ";"

			// System message
			. "HEALTHANDCARE_GLOBALS['system_message']	= {"
				. "message: '" . addslashes($msg['message']) . "',"
				. "status: '"  . addslashes($msg['status'])  . "',"
				. "header: '"  . addslashes($msg['header'])  . "'"
				. "};"

			// User logged in
			. "HEALTHANDCARE_GLOBALS['user_logged_in']	= " . (is_user_logged_in() ? 'true' : 'false') . ";"

			// Show table of content for the current page
			. "HEALTHANDCARE_GLOBALS['toc_menu']		= '" . esc_attr(healthandcare_get_custom_option('menu_toc')) . "';"
			. "HEALTHANDCARE_GLOBALS['toc_menu_home']	= " . (healthandcare_get_custom_option('menu_toc')!='hide' && healthandcare_get_custom_option('menu_toc_home')=='yes' ? 'true' : 'false') . ";"
			. "HEALTHANDCARE_GLOBALS['toc_menu_top']	= " . (healthandcare_get_custom_option('menu_toc')!='hide' && healthandcare_get_custom_option('menu_toc_top')=='yes' ? 'true' : 'false') . ";"

			// Fix main menu
			. "HEALTHANDCARE_GLOBALS['menu_fixed']		= " . (healthandcare_get_theme_option('menu_attachment')=='fixed' ? 'true' : 'false') . ";"

			// Use responsive version for main menu
			. "HEALTHANDCARE_GLOBALS['menu_relayout']	= " . max(0, (int) healthandcare_get_theme_option('menu_relayout')) . ";"
			. "HEALTHANDCARE_GLOBALS['menu_responsive']	= " . (healthandcare_get_theme_option('responsive_layouts') == 'yes' ? max(0, (int) healthandcare_get_theme_option('menu_responsive')) : 0) . ";"
			. "HEALTHANDCARE_GLOBALS['menu_slider']     = " . (healthandcare_get_theme_option('menu_slider')=='yes' ? 'true' : 'false') . ";"

			// Right panel demo timer
			. "HEALTHANDCARE_GLOBALS['demo_time']		= " . (healthandcare_get_theme_option('show_theme_customizer')=='yes' ? max(0, (int) healthandcare_get_theme_option('customizer_demo')) : 0) . ";"

			// Video and Audio tag wrapper
			. "HEALTHANDCARE_GLOBALS['media_elements_enabled'] = " . (healthandcare_get_theme_option('use_mediaelement')=='yes' ? 'true' : 'false') . ";"

			// Use AJAX search
			. "HEALTHANDCARE_GLOBALS['ajax_search_enabled'] 	= " . (healthandcare_get_theme_option('use_ajax_search')=='yes' ? 'true' : 'false') . ";"
			. "HEALTHANDCARE_GLOBALS['ajax_search_min_length']	= " . min(3, healthandcare_get_theme_option('ajax_search_min_length')) . ";"
			. "HEALTHANDCARE_GLOBALS['ajax_search_delay']		= " . min(200, max(1000, healthandcare_get_theme_option('ajax_search_delay'))) . ";"

			// Use CSS animation
			. "HEALTHANDCARE_GLOBALS['css_animation']      = " . (healthandcare_get_theme_option('css_animation')=='yes' ? 'true' : 'false') . ";"
			. "HEALTHANDCARE_GLOBALS['menu_animation_in']  = '" . esc_attr(healthandcare_get_theme_option('menu_animation_in')) . "';"
			. "HEALTHANDCARE_GLOBALS['menu_animation_out'] = '" . esc_attr(healthandcare_get_theme_option('menu_animation_out')) . "';"

			// Popup windows engine
			. "HEALTHANDCARE_GLOBALS['popup_engine']	= '" . esc_attr(healthandcare_get_theme_option('popup_engine')) . "';"

			// E-mail mask
			. "HEALTHANDCARE_GLOBALS['email_mask']		= '^([a-zA-Z0-9_\\-]+\\.)*[a-zA-Z0-9_\\-]+@[a-z0-9_\\-]+(\\.[a-z0-9_\\-]+)*\\.[a-z]{2,6}$';"

			// Messages max length
			. "HEALTHANDCARE_GLOBALS['contacts_maxlength']	= " . intval(healthandcare_get_theme_option('message_maxlength_contacts')) . ";"
			. "HEALTHANDCARE_GLOBALS['comments_maxlength']	= " . intval(healthandcare_get_theme_option('message_maxlength_comments')) . ";"

			// Remember visitors settings
			. "HEALTHANDCARE_GLOBALS['remember_visitors_settings']	= " . (healthandcare_get_theme_option('remember_visitors_settings')=='yes' ? 'true' : 'false') . ";"

			// Internal vars - do not change it!
			// Flag for review mechanism
			. "HEALTHANDCARE_GLOBALS['admin_mode']			= false;"
			// Max scale factor for the portfolio and other isotope elements before relayout
			. "HEALTHANDCARE_GLOBALS['isotope_resize_delta']	= 0.3;"
			// jQuery object for the message box in the form
			. "HEALTHANDCARE_GLOBALS['error_message_box']	= null;"
			// Waiting for the viewmore results
			. "HEALTHANDCARE_GLOBALS['viewmore_busy']		= false;"
			. "HEALTHANDCARE_GLOBALS['video_resize_inited']	= false;"
			. "HEALTHANDCARE_GLOBALS['top_panel_height']		= 0;"
			. "});"
			. "</script>";
	}
}


//  Enqueue Custom styles (main Theme options settings)
if ( !function_exists( 'healthandcare_enqueue_custom_styles' ) ) {
	function healthandcare_enqueue_custom_styles() {
		// Custom stylesheet
		$custom_css = '';	//healthandcare_get_custom_option('custom_stylesheet_url');
		healthandcare_enqueue_style( 'healthandcare-custom-style', $custom_css ? $custom_css : healthandcare_get_file_url('css/custom-style.css'), array(), null );
		// Custom inline styles
		wp_add_inline_style( 'healthandcare-custom-style', healthandcare_prepare_custom_styles() );
	}
}

// Add class "widget_number_#' for each widget
if ( !function_exists( 'healthandcare_add_widget_number' ) ) {
	//add_filter('dynamic_sidebar_params', 'healthandcare_add_widget_number', 10, 1);
	function healthandcare_add_widget_number($prm) {
		global $HEALTHANDCARE_GLOBALS;
		if (is_admin()) return $prm;
		static $num=0, $last_sidebar='', $last_sidebar_id='', $last_sidebar_columns=0, $last_sidebar_count=0, $sidebars_widgets=array();
		$cur_sidebar = !empty($HEALTHANDCARE_GLOBALS['current_sidebar']) ? $HEALTHANDCARE_GLOBALS['current_sidebar'] : 'undefined';
		if (count($sidebars_widgets) == 0)
			$sidebars_widgets = wp_get_sidebars_widgets();
		if ($last_sidebar != $cur_sidebar) {
			$num = 0;
			$last_sidebar = $cur_sidebar;
			$last_sidebar_id = $prm[0]['id'];
			$last_sidebar_columns = max(1, (int) healthandcare_get_custom_option('sidebar_'.($cur_sidebar).'_columns'));
			$last_sidebar_count = count($sidebars_widgets[$last_sidebar_id]);
		}
		$num++;
		$prm[0]['before_widget'] = str_replace(' class="', ' class="widget_number_'.esc_attr($num).($last_sidebar_columns > 1 ? ' column-1_'.esc_attr($last_sidebar_columns) : '').' ', $prm[0]['before_widget']);
		return $prm;
	}
}


// Filters wp_title to print a neat <title> tag based on what is being viewed.
if ( !function_exists( 'healthandcare_wp_title' ) ) {
	// add_filter( 'wp_title', 'healthandcare_wp_title', 10, 2 );
	function healthandcare_wp_title( $title, $sep ) {
		global $page, $paged;
		if ( is_feed() ) return $title;
		// Add the blog name
		$title .= get_bloginfo( 'name' );
		// Add the blog description for the home/front page.
		if ( is_home() || is_front_page() ) {
			$site_description = healthandcare_get_custom_option('logo_slogan');
			if (empty($site_description))
				$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description )
				$title .= " $sep $site_description";
		}
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'healthandcare' ), max( $paged, $page ) );
		return $title;
	}
}

// Add main menu classes
if ( !function_exists( 'healthandcare_add_mainmenu_classes' ) ) {
	// add_filter('wp_nav_menu_objects', 'healthandcare_add_mainmenu_classes', 10, 2);
	function healthandcare_add_mainmenu_classes($items, $args) {
		if (is_admin()) return $items;
		if ($args->menu_id == 'mainmenu' && healthandcare_get_theme_option('menu_colored')=='yes' && is_array($items) && count($items) > 0) {
			foreach($items as $k=>$item) {
				if ($item->menu_item_parent==0) {
					if ($item->type=='taxonomy' && $item->object=='category') {
						$cur_tint = healthandcare_taxonomy_get_inherited_property('category', $item->object_id, 'bg_tint');
						if (!empty($cur_tint) && !healthandcare_is_inherit_option($cur_tint))
							$items[$k]->classes[] = 'bg_tint_'.esc_attr($cur_tint);
					}
				}
			}
		}
		return $items;
	}
}


// Save post data from frontend editor
if ( !function_exists( 'healthandcare_callback_frontend_editor_save' ) ) {
	function healthandcare_callback_frontend_editor_save() {
		global $_REQUEST;

		if ( !wp_verify_nonce( $_REQUEST['nonce'], 'healthandcare_editor_nonce' ) )
			die();

		$response = array('error'=>'');

		parse_str($_REQUEST['data'], $output);
		$post_id = $output['frontend_editor_post_id'];

		if ( healthandcare_get_theme_option("allow_editor")=='yes' && (current_user_can('edit_posts', $post_id) || current_user_can('edit_pages', $post_id)) ) {
			if ($post_id > 0) {
				$title   = stripslashes($output['frontend_editor_post_title']);
				$content = stripslashes($output['frontend_editor_post_content']);
				$excerpt = stripslashes($output['frontend_editor_post_excerpt']);
				$rez = wp_update_post(array(
					'ID'           => $post_id,
					'post_content' => $content,
					'post_excerpt' => $excerpt,
					'post_title'   => $title
				));
				if ($rez == 0)
					$response['error'] = esc_html__('Post update error!', 'healthandcare');
			} else {
				$response['error'] = esc_html__('Post update error!', 'healthandcare');
			}
		} else
			$response['error'] = esc_html__('Post update denied!', 'healthandcare');

		echo json_encode($response);
		die();
	}
}

// Delete post from frontend editor
if ( !function_exists( 'healthandcare_callback_frontend_editor_delete' ) ) {
	function healthandcare_callback_frontend_editor_delete() {
		global $_REQUEST;

		if ( !wp_verify_nonce( $_REQUEST['nonce'], 'healthandcare_editor_nonce' ) )
			die();

		$response = array('error'=>'');

		$post_id = $_REQUEST['post_id'];

		if ( healthandcare_get_theme_option("allow_editor")=='yes' && (current_user_can('delete_posts', $post_id) || current_user_can('delete_pages', $post_id)) ) {
			if ($post_id > 0) {
				$rez = wp_delete_post($post_id);
				if ($rez === false)
					$response['error'] = esc_html__('Post delete error!', 'healthandcare');
			} else {
				$response['error'] = esc_html__('Post delete error!', 'healthandcare');
			}
		} else
			$response['error'] = esc_html__('Post delete denied!', 'healthandcare');

		echo json_encode($response);
		die();
	}
}


// Prepare logo text
if ( !function_exists( 'healthandcare_prepare_logo_text' ) ) {
	function healthandcare_prepare_logo_text($text) {
		$text = str_replace(array('[', ']'), array('<span class="theme_accent">', '</span>'), $text);
		$text = str_replace(array('{', '}'), array('<strong>', '</strong>'), $text);
		return $text;
	}
}
?>