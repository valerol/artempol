<?php
/**
 * Theme sprecific functions and definitions
 */


/* Theme setup section
------------------------------------------------------------------- */

add_action( 'after_setup_theme', 'register_artempol_elements' );

function register_artempol_elements() {
	register_nav_menu( 'main-menu', __( 'Main menu', 'healthandcare' ) );
}

if ( function_exists( 'add_theme_support' ) ) { 
    add_theme_support( 'post-thumbnails' );
//    set_post_thumbnail_size( 150, 150, true ); // default Post Thumbnail dimensions (cropped)
}

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */

// Add theme specific actions and filters
// Attention! Function were add theme specific actions and filters handlers must have priority 1
if ( !function_exists( 'healthandcare_theme_setup' ) ) {
//	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_theme_setup', 1 );
	function healthandcare_theme_setup() {

		// Register theme menus
		add_filter( 'healthandcare_filter_add_theme_menus',		'healthandcare_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'healthandcare_filter_add_theme_sidebars',	'healthandcare_add_theme_sidebars' );

		// Set options for importer
		add_filter( 'healthandcare_filter_importer_options',		'healthandcare_set_importer_options' );

	}
}


// Add/Remove theme nav menus
if ( !function_exists( 'healthandcare_add_theme_menus' ) ) {
	add_filter( 'healthandcare_action_add_theme_menus', 'healthandcare_add_theme_menus' );
	function healthandcare_add_theme_menus($menus) {
		//For example:
		//$menus['menu_footer'] = esc_html__('Footer Menu', 'healthandcare');
		//if (isset($menus['menu_panel'])) unset($menus['menu_panel']);
		return $menus;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'healthandcare_add_theme_sidebars' ) ) {
	add_filter( 'healthandcare_filter_add_theme_sidebars',	'healthandcare_add_theme_sidebars' );
	function healthandcare_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> esc_html__( 'Main Sidebar', 'healthandcare' ),
				'sidebar_footer'	=> esc_html__( 'Footer Sidebar', 'healthandcare' ),
				'sidebar_frontpage'	=> esc_html__( 'Frontpage Sidebar', 'healthandcare' ),
				'sidebar_frontpage_bottom'	=> esc_html__( 'Frontpage Bottom Sidebar', 'healthandcare' ),
			);
			if (healthandcare_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = esc_html__( 'WooCommerce Cart Sidebar', 'healthandcare' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}


// Set theme specific importer options
if ( !function_exists( 'healthandcare_set_importer_options' ) ) {
	add_filter( 'healthandcare_filter_importer_options',	'healthandcare_set_importer_options' );
	function healthandcare_set_importer_options($options=array()) {
		if (is_array($options)) {
			$options['domain_dev'] = esc_html__('healthandcare.dv.ancorathemes.com', 'healthandcare' );
			$options['domain_demo'] = esc_html__('healthandcare.ancorathemes.com', 'healthandcare' );
			$options['page_on_front'] = esc_html__('Home Default', 'healthandcare' );	// Homepage title
			$options['page_for_posts'] = esc_html__('Blog With Sidebar', 'healthandcare' );		// Blog streampage title
			$options['menus'] = array(						// Menus locations and names
				'menu-main'	  => esc_html__('Main menu', 'healthandcare' ),
				'menu-user'	  => esc_html__('User menu', 'healthandcare' ),
				'menu-footer' => esc_html__('Footer menu', 'healthandcare' )
			);
		}
		return $options;
	}
}

?>
