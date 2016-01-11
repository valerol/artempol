<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'healthandcare_widget_services_load' );

/**
 * Register our widget.
 */
function healthandcare_widget_services_load() {
	register_widget( 'healthandcare_widget_services' );
}

/**
 * Twitter Widget class.
 */
class healthandcare_widget_services extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_services sc_services_item clearfix', 'description' => esc_html__('Services block', 'healthandcare') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'healthandcare_widget_services' );

		/* Create the widget. */
		parent::__construct( 'healthandcare_widget_services', esc_html__('HealthandCARE - Services block', 'healthandcare'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '' );
		$services_description = isset( $instance[ 'services_description' ]) ? $instance[ 'services_description' ] : '';
		$services_code = isset( $instance[ 'services_code' ] ) ? $instance[ 'services_code' ] : '';

		/* Before widget (defined by themes). */			
		echo ( $before_widget );
		
		if ( $title ) {
			echo '<h2 class="center">' . $title . '</h2>';
		}
		
		if ( $services_description ) {
			echo '<h6 class="center">' . $services_description . '</h6>';
		}

		if ( $services_code != '' ) {
			$services_code = str_replace( ';', '</li><li><span class="sc_list_icon icon-checkbox"></span>', $services_code );
			$services_code = str_replace( '---', '</li></ul><ul class="column-1_3 left sc_list sc_list_style_iconed"><li><span class="sc_list_icon icon-checkbox"></span>', $services_code );
			echo '<ul class="column-1_3 left sc_list sc_list_style_iconed"><li><span class="sc_list_icon icon-checkbox"></span>' . $services_code . '</li></ul>';
		}

		/* After widget (defined by themes). */
		echo ( $after_widget );
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		$instance[ 'services_description' ] = strip_tags( $new_instance[ 'services_description' ] );
		$instance[ 'services_code' ] = $new_instance[ 'services_code' ];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

        global $HEALTHANDCARE_GLOBALS;

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'description' => esc_html__('Services block', 'healthandcare') );
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		$title = isset($instance['title']) ? $instance['title'] : '';
		$services_description = isset($instance['services_description']) ? $instance['services_description'] : '';
		$services_code = isset($instance['services_code']) ? $instance['services_code'] : '';
		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'healthandcare'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($title); ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'services_description' )); ?>">Подзаголовок</label>
			<input id="<?php echo esc_attr($this->get_field_id( 'services_description' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'services_description' )); ?>" value="<?php echo esc_attr($services_description); ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'services_code' )); ?>"><?php esc_html_e('or paste services Widget HTML Code:', 'healthandcare'); ?></label>
			<textarea id="<?php echo esc_attr($this->get_field_id( 'services_code' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'services_code' )); ?>" rows="5" style="width:100%;"><?php echo htmlspecialchars($services_code); ?></textarea>
		</p>
	<?php
	}
}

if (is_admin()) {
	require_once(healthandcare_get_file_dir('core/core.options/core.options-custom.php'));
}
?>
