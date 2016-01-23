<?php
/**
 * HealthandCARE Framework
 *
 * @package healthandcare
 * @since healthandcare 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Framework directory path from theme root
if ( ! defined( 'HEALTHANDCARE_FW_DIR' ) )		define( 'HEALTHANDCARE_FW_DIR', '/fw/' );

// Theme timing
if ( ! defined( 'HEALTHANDCARE_START_TIME' ) )	define( 'HEALTHANDCARE_START_TIME', microtime());			// Framework start time
if ( ! defined( 'HEALTHANDCARE_START_MEMORY' ) )	define( 'HEALTHANDCARE_START_MEMORY', memory_get_usage());	// Memory usage before core loading

// Global variables storage
global $HEALTHANDCARE_GLOBALS;
$HEALTHANDCARE_GLOBALS = array(
    'theme_slug'	=> 'healthandcare',	// Theme slug (used as prefix for theme's functions, text domain, global variables, etc.)
    'page_template'	=> '',			// Storage for current page template name (used in the inheritance system)
    'allowed_tags'	=> array(		// Allowed tags list (with attributes) in translations
        'b' => array(),
        'br' => array(),
        'strong' => array(),
        'i' => array(),
        'em' => array(),
        'u' => array(),
        'a' => array(
            'href' => array(),
            'title' => array(),
            'target' => array(),
            'id' => array(),
            'class' => array()
        ),
        'span' => array(
            'id' => array(),
            'class' => array()
        )
    )
);

/* Theme setup section
-------------------------------------------------------------------- */
if ( !function_exists( 'healthandcare_loader_theme_setup' ) ) {
	add_action( 'after_setup_theme', 'healthandcare_loader_theme_setup', 20 );
	function healthandcare_loader_theme_setup() {
		// Before init theme
		do_action('healthandcare_action_before_init_theme');

		// Load current values for main theme options
		healthandcare_load_main_options();

		// Theme core init - only for admin side. In frontend it called from header.php
		if ( is_admin() ) {
			healthandcare_core_init_theme();
		}
	}
}


/* Include core parts
------------------------------------------------------------------------ */

// Manual load important libraries before load all rest files
// core.strings must be first - we use healthandcare_str...() in the healthandcare_get_file_dir()
require_once( (file_exists(get_stylesheet_directory().(HEALTHANDCARE_FW_DIR).'core/core.strings.php') ? get_stylesheet_directory() : get_template_directory()).(HEALTHANDCARE_FW_DIR).'core/core.strings.php' );
// core.files must be first - we use healthandcare_get_file_dir() to include all rest parts
require_once( (file_exists(get_stylesheet_directory().(HEALTHANDCARE_FW_DIR).'core/core.files.php') ? get_stylesheet_directory() : get_template_directory()).(HEALTHANDCARE_FW_DIR).'core/core.files.php' );

// Include core files
healthandcare_autoload_folder( 'core' );

// Include custom theme files
healthandcare_autoload_folder( 'includes' );

// Include theme templates
healthandcare_autoload_folder( 'templates' );

// Include theme widgets
healthandcare_autoload_folder( 'widgets' );
?>