<?php
/**
 * HealthandCARE Framework: shortcodes manipulations
 *
 * @package	healthandcare
 * @since	healthandcare 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('healthandcare_sc_theme_setup')) {
	add_action( 'healthandcare_action_init_theme', 'healthandcare_sc_theme_setup', 1 );
	function healthandcare_sc_theme_setup() {
		// Add sc stylesheets
		add_action('healthandcare_action_add_styles', 'healthandcare_sc_add_styles', 1);
	}
}

if (!function_exists('healthandcare_sc_theme_setup2')) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_sc_theme_setup2' );
	function healthandcare_sc_theme_setup2() {

		if ( !is_admin() || isset($_POST['action']) ) {
			// Enable/disable shortcodes in excerpt
			add_filter('the_excerpt', 					'healthandcare_sc_excerpt_shortcodes');
	
			// Prepare shortcodes in the content
			if (function_exists('healthandcare_sc_prepare_content')) healthandcare_sc_prepare_content();
		}

		// Add init script into shortcodes output in VC frontend editor
		add_filter('healthandcare_shortcode_output', 'healthandcare_sc_add_scripts', 10, 4);

		// AJAX: Send contact form data
		add_action('wp_ajax_send_contact_form',			'healthandcare_sc_contact_form_send');
		add_action('wp_ajax_nopriv_send_contact_form',	'healthandcare_sc_contact_form_send');

		// Show shortcodes list in admin editor
		add_action('media_buttons',						'healthandcare_sc_selector_add_in_toolbar', 11);

	}
}


// Add shortcodes styles
if ( !function_exists( 'healthandcare_sc_add_styles' ) ) {
	//add_action('healthandcare_action_add_styles', 'healthandcare_sc_add_styles', 1);
	function healthandcare_sc_add_styles() {
		// Shortcodes
		healthandcare_enqueue_style( 'healthandcare-shortcodes-style',	healthandcare_get_file_url('core/core.shortcodes/shortcodes.css'), array(), null );
	}
}


// Add shortcodes init scripts
if ( !function_exists( 'healthandcare_sc_add_scripts' ) ) {
	//add_filter('healthandcare_shortcode_output', 'healthandcare_sc_add_scripts', 10, 4);
	function healthandcare_sc_add_scripts($output, $tag='', $atts=array(), $content='') {

		global $HEALTHANDCARE_GLOBALS;
		
		if (empty($HEALTHANDCARE_GLOBALS['shortcodes_scripts_added'])) {
			$HEALTHANDCARE_GLOBALS['shortcodes_scripts_added'] = true;
			//healthandcare_enqueue_style( 'healthandcare-shortcodes-style', healthandcare_get_file_url('core/core.shortcodes/shortcodes.css'), array(), null );
			healthandcare_enqueue_script( 'healthandcare-shortcodes-script', healthandcare_get_file_url('core/core.shortcodes/shortcodes.js'), array('jquery'), null, true );
		}
		
		return $output;
	}
}


/* Prepare text for shortcodes
-------------------------------------------------------------------------------- */

// Prepare shortcodes in content
if (!function_exists('healthandcare_sc_prepare_content')) {
	function healthandcare_sc_prepare_content() {
		if (function_exists('healthandcare_sc_clear_around')) {
			$filters = array(
				array('healthandcare', 'sc', 'clear', 'around'),
				array('widget', 'text'),
				array('the', 'excerpt'),
				array('the', 'content')
			);
			if (healthandcare_exists_woocommerce()) {
				$filters[] = array('woocommerce', 'template', 'single', 'excerpt');
				$filters[] = array('woocommerce', 'short', 'description');
			}
			if (is_array($filters) && count($filters) > 0) {
				foreach ($filters as $flt)
					add_filter(join('_', $flt), 'healthandcare_sc_clear_around', 1);	// Priority 1 to clear spaces before do_shortcodes()
			}
		}
	}
}

// Enable/Disable shortcodes in the excerpt
if (!function_exists('healthandcare_sc_excerpt_shortcodes')) {
	function healthandcare_sc_excerpt_shortcodes($content) {
		if (!empty($content)) {
			$content = do_shortcode($content);
			//$content = strip_shortcodes($content);
		}
		return $content;
	}
}



/*
// Remove spaces and line breaks between close and open shortcode brackets ][:
[trx_columns]
	[trx_column_item]Column text ...[/trx_column_item]
	[trx_column_item]Column text ...[/trx_column_item]
	[trx_column_item]Column text ...[/trx_column_item]
[/trx_columns]

convert to

[trx_columns][trx_column_item]Column text ...[/trx_column_item][trx_column_item]Column text ...[/trx_column_item][trx_column_item]Column text ...[/trx_column_item][/trx_columns]
*/
if (!function_exists('healthandcare_sc_clear_around')) {
	function healthandcare_sc_clear_around($content) {
		if (!empty($content)) $content = preg_replace("/\](\s|\n|\r)*\[/", "][", $content);
		return $content;
	}
}






/* Shortcodes support utils
---------------------------------------------------------------------- */

// HealthandCARE shortcodes load scripts
if (!function_exists('healthandcare_sc_load_scripts')) {
	function healthandcare_sc_load_scripts() {
		healthandcare_enqueue_script( 'healthandcare-shortcodes-script', healthandcare_get_file_url('core/core.shortcodes/shortcodes_admin.js'), array('jquery'), null, true );
		healthandcare_enqueue_script( 'healthandcare-selection-script',  healthandcare_get_file_url('js/jquery.selection.js'), array('jquery'), null, true );
	}
}

// HealthandCARE shortcodes prepare scripts
if (!function_exists('healthandcare_sc_prepare_scripts')) {
	function healthandcare_sc_prepare_scripts() {
		global $HEALTHANDCARE_GLOBALS;
		if (!isset($HEALTHANDCARE_GLOBALS['shortcodes_prepared'])) {
			$HEALTHANDCARE_GLOBALS['shortcodes_prepared'] = true;
			?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					try {
						HEALTHANDCARE_GLOBALS['shortcodes'] = <?php esc_html_e('eval', 'healthandcare'); ?>(<?php echo json_encode( healthandcare_array_prepare_to_json($HEALTHANDCARE_GLOBALS['shortcodes']) ); ?>);
					} catch (e) {}
					HEALTHANDCARE_GLOBALS['shortcodes_cp'] = '<?php echo is_admin() ? (!empty($HEALTHANDCARE_GLOBALS['to_colorpicker']) ? $HEALTHANDCARE_GLOBALS['to_colorpicker'] : 'wp') : 'custom'; ?>';	// wp | tiny | custom
				});
			</script>
			<?php
		}
	}
}

// Show shortcodes list in admin editor
if (!function_exists('healthandcare_sc_selector_add_in_toolbar')) {
	//add_action('media_buttons','healthandcare_sc_selector_add_in_toolbar', 11);
	function healthandcare_sc_selector_add_in_toolbar(){

		if ( !healthandcare_options_is_used() ) return;

		healthandcare_sc_load_scripts();
		healthandcare_sc_prepare_scripts();

		global $HEALTHANDCARE_GLOBALS;

		$shortcodes = $HEALTHANDCARE_GLOBALS['shortcodes'];
		$shortcodes_list = '<select class="sc_selector"><option value="">&nbsp;'.esc_html__('- Select Shortcode -', 'healthandcare').'&nbsp;</option>';

		if (is_array($shortcodes) && count($shortcodes) > 0) {
			foreach ($shortcodes as $idx => $sc) {
				$shortcodes_list .= '<option value="'.esc_attr($idx).'" title="'.esc_attr($sc['desc']).'">'.esc_html($sc['title']).'</option>';
			}
		}

		$shortcodes_list .= '</select>';

		echo ($shortcodes_list);
	}
}


require_once( healthandcare_get_file_dir('core/core.shortcodes/shortcodes_settings.php') );

if ( class_exists('WPBakeryShortCode') 
		&& ( 
			is_admin() 
			|| (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true' )
			|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline')
			) 
	) {
	require_once( healthandcare_get_file_dir('core/core.shortcodes/shortcodes_vc_classes.php') );
	require_once( healthandcare_get_file_dir('core/core.shortcodes/shortcodes_vc.php') );
}

require_once( healthandcare_get_file_dir('core/core.shortcodes/shortcodes.php') );
?>