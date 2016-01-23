<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'healthandcare_widget_latest_news_load' );

/**
 * Register our widget.
 */
function healthandcare_widget_latest_news_load() {
	register_widget('healthandcare_widget_latest_news');
}

/**
 * Latest News Widget class.
 */
class healthandcare_widget_latest_news extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array('classname' => 'widget_latest_news', 'description' => esc_html__('The recent blog posts (extended)', 'healthandcare'));

		/* Widget control settings. */
		$control_ops = array('width' => 200, 'height' => 250, 'id_base' => 'healthandcare_widget_latest_news');

		/* Create the widget. */
		parent::__construct( 'healthandcare_widget_latest_news', esc_html__('HealthandCARE - Latest News', 'healthandcare'), $widget_ops, $control_ops );

		// Add thumb sizes into list
		healthandcare_add_thumb_sizes( array( 'layout' => 'widgets', 'w' => 75, 'h' => 75, 'h_crop' => 75, 'title'=>esc_html__('Widgets', 'healthandcare') ) );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget($args, $instance) {
		
		extract( $args );

		global $wp_query, $post;

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '' );
		
		$before_title = '<h2>';
		$after_title = '</h2>';

		$number = isset( $instance[ 'number' ] ) ? (int) $instance[ 'number' ] : '';

		$category = isset( $instance[ 'category' ] ) ? (int) $instance[ 'category' ] : 0;
		
		$output = '';

		$args = array(
			'numberposts' => $number,
//			'offset' => 0,
//			'orderby' => 'post_date',
//			'order' => 'DESC',
			'post_type' => 'post',
//			'post_status' => current_user_can( 'read_private_pages' ) && current_user_can( 'read_private_posts' ) ? array( 'publish', 'private' ) : 'publish',
//			'ignore_sticky_posts' => true,
//			'suppress_filters' => true,
			'category' => $category
    	);

    	$recent_posts = wp_get_recent_posts( $args, OBJECT );
			
		$post_number = 0;

		if ( is_array( $recent_posts ) && count( $recent_posts ) > 0) {
			
			$post_args = array(
					'layout' => $blog_style,
					'number' => $number,
					'add_view_more' => false,
					'posts_on_page' => $per_page,
					'columns_count' => $blog_columns,
					// Get post data
					'strip_teaser' => false,
					'content' => healthandcare_get_template_property( $blog_style, 'need_content' ),
//					'terms_list' => !healthandcare_param_is_off($show_filters) || healthandcare_get_template_property($blog_style, 'need_terms'),
//					'parent_tax_id' => $parent_tax_id,
//					'descr' => healthandcare_get_custom_option('post_excerpt_maxlength'.($blog_columns > 1 ? '_masonry' : '')),
					'sidebar' => !healthandcare_param_is_off($show_sidebar),
//					'filters' => $show_filters != 'hide' ? $show_filters : '',
					'hover' => $hover,
					'hover_dir' => $hover_dir
			);
			
			/* Before widget (defined by themes). */			
			echo $before_widget;
			
			/* Display the widget title if one was input (before and after defined by themes). */
			echo $before_title . $title . $after_title;
				
			foreach ( $recent_posts as $post ) {
				$post_number++;
				healthandcare_show_post_layout( $post_args, $post_data );
				
				if ( $post_number == $number ) break;
			}
			
			/* After widget (defined by themes). */
			echo ( $after_widget );
		}
	}

	/**
	 * Update the widget settings.
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		/* Strip tags for title and comments count to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['category'] = (int) $new_instance['category'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance) {
		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'number' => '4',
			'category'=>'0',
			)
		);
		$title = $instance['title'];
		$number = (int) $instance['number'];
		$category = (int) $instance['category'];

		$posts_types = healthandcare_get_list_posts_types(false);
		$categories = healthandcare_get_list_terms(false, healthandcare_get_taxonomy_categories_by_post_type('post'));
		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Widget title:', 'healthandcare'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php esc_html_e('Category:', 'healthandcare'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('category')); ?>" name="<?php echo esc_attr($this->get_field_name('category')); ?>" style="width:100%;">
				<option value="0"><?php esc_html_e('-- Any category --', 'healthandcare'); ?></option>
			<?php
				if (is_array($categories) && count($categories) > 0) {
					foreach ($categories as $cat_id => $cat_name) {
						echo '<option value="'.esc_attr($cat_id).'"'.($category==$cat_id ? ' selected="selected"' : '').'>'.esc_html($cat_name).'</option>';
					}
				}
			?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number posts to show:', 'healthandcare'); ?></label>
			<input type="text" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" value="<?php echo esc_attr($number); ?>" style="width:100%;" />
		</p>
	<?php
	}
}

?>
