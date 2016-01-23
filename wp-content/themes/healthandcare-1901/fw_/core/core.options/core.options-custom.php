<?php
/**
 * HealthandCARE Framework: Theme options custom fields
 *
 * @package	healthandcare
 * @since	healthandcare 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'healthandcare_options_custom_theme_setup' ) ) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_options_custom_theme_setup' );
	function healthandcare_options_custom_theme_setup() {

		if ( is_admin() ) {
			add_action("admin_enqueue_scripts",	'healthandcare_options_custom_load_scripts');
		}
		
	}
}

// Load required styles and scripts for custom options fields
if ( !function_exists( 'healthandcare_options_custom_load_scripts' ) ) {
	//add_action("admin_enqueue_scripts", 'healthandcare_options_custom_load_scripts');
	function healthandcare_options_custom_load_scripts() {
		healthandcare_enqueue_script( 'healthandcare-options-custom-script',	healthandcare_get_file_url('core/core.options/js/core.options-custom.js'), array(), null, true );
	}
}


// Show theme specific fields in Post (and Page) options
function healthandcare_show_custom_field($id, $field, $value) {
	$output = '';
	switch ($field['type']) {
		case 'reviews':
			$output .= '<div class="reviews_block">' . trim(healthandcare_reviews_get_markup($field, $value, true)) . '</div>';
			break;

		case 'mediamanager':
			wp_enqueue_media( );
			$output .= '<a id="'.esc_attr($id).'" class="button mediamanager"
				data-param="' . esc_attr($id) . '"
				data-choose="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'healthandcare') : esc_html__( 'Choose Image', 'healthandcare')).'"
				data-update="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Add to Gallery', 'healthandcare') : esc_html__( 'Choose Image', 'healthandcare')).'"
				data-multiple="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? 'true' : 'false').'"
				data-linked-field="'.esc_attr($field['media_field_id']).'"
				onclick="healthandcare_show_media_manager(this); return false;"
				>' . (isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'healthandcare') : esc_html__( 'Choose Image', 'healthandcare')) . '</a>';
			break;
	}
	return apply_filters('healthandcare_filter_show_custom_field', $output, $id, $field, $value);
}
?>