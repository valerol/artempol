<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'healthandcare_widget_colorblock_load' );

/**
 * Register our widget.
 */
function healthandcare_widget_colorblock_load() {
	register_widget( 'healthandcare_widget_colorblock' );
}

/**
 * Twitter Widget class.
 */
class healthandcare_widget_colorblock extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget_colorblock sc_services_item', 'description' => esc_html__('Colorblock block', 'healthandcare') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'healthandcare_widget_colorblock' );

		/* Create the widget. */
		parent::__construct( 'healthandcare_widget_colorblock', esc_html__('HealthandCARE - Colorblock block', 'healthandcare'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$colorblock_image = isset($instance['colorblock_image']) ? $instance['colorblock_image'] : '';
		$colorblock_link = isset($instance['colorblock_link']) ? $instance['colorblock_link'] : '';
		$colorblock_code = isset($instance['colorblock_code']) ? $instance['colorblock_code'] : '';
		
		$before_widget = '<div class="sc_services column-1_4 animated fadeInUp normal">' . $before_widget;
		$before_widget = str_replace( 'widget_number_', 'sc_services_item_', $before_widget );
		$after_widget .= '</div>';

		$before_title .= '<h4 class="sc_services_item_title">';

		if ( $colorblock_link ) {
			$before_title .= '<a href="' . $colorblock_link . '">';
			$after_title .= '</a>';
		}
		
		$before_title .= '<span class="' . $colorblock_image . '"></span>';
		
		$after_title .= '</h4>';

		/* Before widget (defined by themes). */			
		echo ( $before_widget );

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}

		if ( $colorblock_code!='' ) {
			echo '<div class="sc_services_item_content"><div class="sc_services_item_description">';
			echo force_balance_tags(healthandcare_substitute_all($colorblock_code));
			echo '</div></div>';
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
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['colorblock_image'] = strip_tags( $new_instance['colorblock_image'] );
		$instance['colorblock_link'] = strip_tags( $new_instance['colorblock_link'] );
		$instance['colorblock_code'] = $new_instance['colorblock_code'];

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
		$defaults = array( 'title' => '', 'description' => esc_html__('Colorblock block', 'healthandcare') );
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		$title = isset($instance['title']) ? $instance['title'] : '';
		$colorblock_image = isset($instance['colorblock_image']) ? $instance['colorblock_image'] : '';
		$colorblock_link = isset($instance['colorblock_link']) ? $instance['colorblock_link'] : '';
		$colorblock_code = isset($instance['colorblock_code']) ? $instance['colorblock_code'] : '';
		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'healthandcare'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($title); ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'colorblock_image' )); ?>">Кодовое имя изображения с сайта fontello.com (sc_icon имя)</label>
			<input id="<?php echo esc_attr($this->get_field_id( 'colorblock_image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'colorblock_image' )); ?>" value="<?php echo esc_attr($colorblock_image); ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'colorblock_link' )); ?>">Ссылка</label>
			<input id="<?php echo esc_attr($this->get_field_id( 'colorblock_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'colorblock_link' )); ?>" value="<?php echo esc_attr($colorblock_link); ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'colorblock_code' )); ?>"><?php esc_html_e('or paste colorblock Widget HTML Code:', 'healthandcare'); ?></label>
			<textarea id="<?php echo esc_attr($this->get_field_id( 'colorblock_code' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'colorblock_code' )); ?>" rows="5" style="width:100%;"><?php echo htmlspecialchars($colorblock_code); ?></textarea>
		</p>
	<?php
	}
}

if (is_admin()) {
	require_once(healthandcare_get_file_dir('core/core.options/core.options-custom.php'));
}
?>
