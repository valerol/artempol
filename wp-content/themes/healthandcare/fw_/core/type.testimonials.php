<?php
/**
 * HealthandCARE Framework: Testimonial post type settings
 *
 * @package	healthandcare
 * @since	healthandcare 1.0
 */

// Theme init
if (!function_exists('healthandcare_testimonial_theme_setup')) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_testimonial_theme_setup' );
	function healthandcare_testimonial_theme_setup() {
	
		// Add item in the admin menu
		add_action('admin_menu',			'healthandcare_testimonial_add_meta_box');

		// Save data from meta box
		add_action('save_post',				'healthandcare_testimonial_save_data');

		// Add shortcodes [trx_testimonials] and [trx_testimonials_item]
		add_action('healthandcare_action_shortcodes_list',		'healthandcare_testimonials_get_shortcodes');
		add_action('healthandcare_action_shortcodes_list_vc',	'healthandcare_testimonials_get_shortcodes_vc');

		// Meta box fields
		global $HEALTHANDCARE_GLOBALS;
		$HEALTHANDCARE_GLOBALS['testimonial_meta_box'] = array(
			'id' => 'testimonial-meta-box',
			'title' => esc_html__('Testimonial Details', 'healthandcare'),
			'page' => 'testimonial',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				"testimonial_author" => array(
					"title" => esc_html__('Testimonial author',  'healthandcare'),
					"desc" => esc_html__("Name of the testimonial's author", 'healthandcare'),
					"class" => "testimonial_author",
					"std" => "",
					"type" => "text"),
				"testimonial_position" => array(
					"title" => esc_html__("Author's position",  'healthandcare'),
					"desc" => esc_html__("Position of the testimonial's author", 'healthandcare'),
					"class" => "testimonial_author",
					"std" => "",
					"type" => "text"),
				"testimonial_email" => array(
					"title" => esc_html__("Author's e-mail",  'healthandcare'),
					"desc" => esc_html__("E-mail of the testimonial's author - need to take Gravatar (if registered)", 'healthandcare'),
					"class" => "testimonial_email",
					"std" => "",
					"type" => "text"),
				"testimonial_link" => array(
					"title" => esc_html__('Testimonial link',  'healthandcare'),
					"desc" => esc_html__("URL of the testimonial source or author profile page", 'healthandcare'),
					"class" => "testimonial_link",
					"std" => "",
					"type" => "text")
			)
		);
		
		if (function_exists('healthandcare_require_data')) {
			// Prepare type "Testimonial"
			healthandcare_require_data( 'post_type', 'testimonial', array(
				'label'               => esc_html__( 'Testimonial', 'healthandcare' ),
				'description'         => esc_html__( 'Testimonial Description', 'healthandcare' ),
				'labels'              => array(
					'name'                => _x( 'Testimonials', 'Post Type General Name', 'healthandcare' ),
					'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'healthandcare' ),
					'menu_name'           => esc_html__( 'Testimonials', 'healthandcare' ),
					'parent_item_colon'   => esc_html__( 'Parent Item:', 'healthandcare' ),
					'all_items'           => esc_html__( 'All Testimonials', 'healthandcare' ),
					'view_item'           => esc_html__( 'View Item', 'healthandcare' ),
					'add_new_item'        => esc_html__( 'Add New Testimonial', 'healthandcare' ),
					'add_new'             => esc_html__( 'Add New', 'healthandcare' ),
					'edit_item'           => esc_html__( 'Edit Item', 'healthandcare' ),
					'update_item'         => esc_html__( 'Update Item', 'healthandcare' ),
					'search_items'        => esc_html__( 'Search Item', 'healthandcare' ),
					'not_found'           => esc_html__( 'Not found', 'healthandcare' ),
					'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'healthandcare' ),
				),
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail'),
				'hierarchical'        => false,
				'public'              => false,
				'show_ui'             => true,
				'menu_icon'			  => 'dashicons-cloud',
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 27.5,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => false,
				'capability_type'     => 'page',
				)
			);
			
			// Prepare taxonomy for testimonial
			healthandcare_require_data( 'taxonomy', 'testimonial_group', array(
				'post_type'			=> array( 'testimonial' ),
				'hierarchical'      => true,
				'labels'            => array(
					'name'              => _x( 'Testimonials Group', 'taxonomy general name', 'healthandcare' ),
					'singular_name'     => _x( 'Group', 'taxonomy singular name', 'healthandcare' ),
					'search_items'      => esc_html__( 'Search Groups', 'healthandcare' ),
					'all_items'         => esc_html__( 'All Groups', 'healthandcare' ),
					'parent_item'       => esc_html__( 'Parent Group', 'healthandcare' ),
					'parent_item_colon' => esc_html__( 'Parent Group:', 'healthandcare' ),
					'edit_item'         => esc_html__( 'Edit Group', 'healthandcare' ),
					'update_item'       => esc_html__( 'Update Group', 'healthandcare' ),
					'add_new_item'      => esc_html__( 'Add New Group', 'healthandcare' ),
					'new_item_name'     => esc_html__( 'New Group Name', 'healthandcare' ),
					'menu_name'         => esc_html__( 'Testimonial Group', 'healthandcare' ),
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'testimonial_group' ),
				)
			);
		}
	}
}


// Add meta box
if (!function_exists('healthandcare_testimonial_add_meta_box')) {
	//add_action('admin_menu', 'healthandcare_testimonial_add_meta_box');
	function healthandcare_testimonial_add_meta_box() {
		global $HEALTHANDCARE_GLOBALS;
		$mb = $HEALTHANDCARE_GLOBALS['testimonial_meta_box'];
		add_meta_box($mb['id'], $mb['title'], 'healthandcare_testimonial_show_meta_box', $mb['page'], $mb['context'], $mb['priority']);
	}
}

// Callback function to show fields in meta box
if (!function_exists('healthandcare_testimonial_show_meta_box')) {
	function healthandcare_testimonial_show_meta_box() {
		global $post, $HEALTHANDCARE_GLOBALS;

		// Use nonce for verification
		echo '<input type="hidden" name="meta_box_testimonial_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
		
		$data = get_post_meta($post->ID, 'testimonial_data', true);
	
		$fields = $HEALTHANDCARE_GLOBALS['testimonial_meta_box']['fields'];
		?>
		<table class="testimonial_area">
		<?php
		if (is_array($fields) && count($fields) > 0) {
			foreach ($fields as $id=>$field) { 
				$meta = isset($data[$id]) ? $data[$id] : '';
				?>
				<tr class="testimonial_field <?php echo esc_attr($field['class']); ?>" valign="top">
					<td><label for="<?php echo esc_attr($id); ?>"><?php echo esc_attr($field['title']); ?></label></td>
					<td><input type="text" name="<?php echo esc_attr($id); ?>" id="<?php echo esc_attr($id); ?>" value="<?php echo esc_attr($meta); ?>" size="30" />
						<br><small><?php echo esc_attr($field['desc']); ?></small></td>
				</tr>
				<?php
			}
		}
		?>
		</table>
		<?php
	}
}


// Save data from meta box
if (!function_exists('healthandcare_testimonial_save_data')) {
	//add_action('save_post', 'healthandcare_testimonial_save_data');
	function healthandcare_testimonial_save_data($post_id) {
		// verify nonce
		if (!isset($_POST['meta_box_testimonial_nonce']) || !wp_verify_nonce($_POST['meta_box_testimonial_nonce'], basename(__FILE__))) {
			return $post_id;
		}

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		// check permissions
		if ($_POST['post_type']!='testimonial' || !current_user_can('edit_post', $post_id)) {
			return $post_id;
		}

		global $HEALTHANDCARE_GLOBALS;

		$data = array();

		$fields = $HEALTHANDCARE_GLOBALS['testimonial_meta_box']['fields'];

		// Post type specific data handling
		if (is_array($fields) && count($fields) > 0) {
			foreach ($fields as $id=>$field) { 
				if (isset($_POST[$id])) 
					$data[$id] = stripslashes($_POST[$id]);
			}
		}

		update_post_meta($post_id, 'testimonial_data', $data);
	}
}






// ---------------------------------- [trx_testimonials] ---------------------------------------

/*
[trx_testimonials id="unique_id" style="1|2|3"]
	[trx_testimonials_item user="user_login"]Testimonials text[/trx_testimonials_item]
	[trx_testimonials_item email="" name="" position="" photo="photo_url"]Testimonials text[/trx_testimonials]
[/trx_testimonials]
*/

if (!function_exists('healthandcare_sc_testimonials')) {
	function healthandcare_sc_testimonials($atts, $content=null){
		if (healthandcare_in_shortcode_blogger()) return '';
		extract(healthandcare_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "testimonials-1",
			"columns" => 1,
			"slider" => "yes",
			"slides_space" => 0,
			"controls" => "no",
			"interval" => "",
			"autoheight" => "no",
			"align" => "",
			"custom" => "no",
			"ids" => "",
			"cat" => "",
			"count" => "3",
			"offset" => "",
			"orderby" => "date",
			"order" => "desc",
			"scheme" => "",
			"bg_color" => "",
			"bg_image" => "",
			"bg_overlay" => "",
			"bg_texture" => "",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
	
		if (empty($id)) $id = "sc_testimonials_".str_replace('.', '', mt_rand());
		if (empty($width)) $width = "100%";
		if (!empty($height) && healthandcare_param_is_on($autoheight)) $autoheight = "no";
		if (empty($interval)) $interval = mt_rand(5000, 10000);
	
		if ($bg_image > 0) {
			$attach = wp_get_attachment_image_src( $bg_image, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$bg_image = $attach[0];
		}
	
		if ($bg_overlay > 0) {
			if ($bg_color=='') $bg_color = healthandcare_get_scheme_color('bg');
			$rgb = healthandcare_hex2rgb($bg_color);
		}
		
		$ms = healthandcare_get_css_position_from_values($top, $right, $bottom, $left);
		$ws = healthandcare_get_css_position_from_values('', '', '', '', $width);
		$hs = healthandcare_get_css_position_from_values('', '', '', '', '', $height);
		$css .= ($ms) . ($hs) . ($ws);

		$count = max(1, (int) $count);
		$columns = max(1, min(12, (int) $columns));
		if (healthandcare_param_is_off($custom) && $count < $columns) $columns = $count;
		
		global $HEALTHANDCARE_GLOBALS;
		$HEALTHANDCARE_GLOBALS['sc_testimonials_id'] = $id;
		$HEALTHANDCARE_GLOBALS['sc_testimonials_style'] = $style;
		$HEALTHANDCARE_GLOBALS['sc_testimonials_columns'] = $columns;
		$HEALTHANDCARE_GLOBALS['sc_testimonials_counter'] = 0;
		$HEALTHANDCARE_GLOBALS['sc_testimonials_slider'] = $slider;
		$HEALTHANDCARE_GLOBALS['sc_testimonials_css_wh'] = $ws . $hs;

		if (healthandcare_param_is_on($slider)) healthandcare_enqueue_slider('swiper');
	
		$output = ($bg_color!='' || $bg_image!='' || $bg_overlay>0 || $bg_texture>0 || healthandcare_strlen($bg_texture)>2 || ($scheme && !healthandcare_param_is_off($scheme) && !healthandcare_param_is_inherit($scheme))
					? '<div class="sc_testimonials_wrap sc_section'
							. ($scheme && !healthandcare_param_is_off($scheme) && !healthandcare_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '')
							. '"'
						.' style="'
							. ($bg_color !== '' && $bg_overlay==0 ? 'background-color:' . esc_attr($bg_color) . ';' : '')
							. ($bg_image !== '' ? 'background-image:url(' . esc_url($bg_image) . ');' : '')
							. '"'
						. (!healthandcare_param_is_off($animation) ? ' data-animation="'.esc_attr(healthandcare_get_animation_classes($animation)).'"' : '')
						. '>'
						. '<div class="sc_section_overlay'.($bg_texture>0 ? ' texture_bg_'.esc_attr($bg_texture) : '') . '"'
								. ' style="' . ($bg_overlay>0 ? 'background-color:rgba('.(int)$rgb['r'].','.(int)$rgb['g'].','.(int)$rgb['b'].','.min(1, max(0, $bg_overlay)).');' : '')
									. (healthandcare_strlen($bg_texture)>2 ? 'background-image:url('.esc_url($bg_texture).');' : '')
									. '"'
									. ($bg_overlay > 0 ? ' data-overlay="'.esc_attr($bg_overlay).'" data-bg_color="'.esc_attr($bg_color).'"' : '')
									. '>' 
					: '')
				. '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_testimonials sc_testimonials_style_'.esc_attr($style)
 					. ' ' . esc_attr(healthandcare_get_template_property($style, 'container_classes'))
 					. (healthandcare_param_is_on($slider)
						? ' sc_slider_swiper swiper-slider-container'
							. ' ' . esc_attr(healthandcare_get_slider_controls_classes($controls))
							. (healthandcare_param_is_on($autoheight) ? ' sc_slider_height_auto' : '')
							. ($hs ? ' sc_slider_height_fixed' : '')
						: '')
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. ($align!='' && $align!='none' ? ' align'.esc_attr($align) : '')
					. '"'
				. ($bg_color=='' && $bg_image=='' && $bg_overlay==0 && ($bg_texture=='' || $bg_texture=='0') && !healthandcare_param_is_off($animation) ? ' data-animation="'.esc_attr(healthandcare_get_animation_classes($animation)).'"' : '')
				. (!empty($width) && healthandcare_strpos($width, '%')===false ? ' data-old-width="' . esc_attr($width) . '"' : '')
				. (!empty($height) && healthandcare_strpos($height, '%')===false ? ' data-old-height="' . esc_attr($height) . '"' : '')
				. ((int) $interval > 0 ? ' data-interval="'.esc_attr($interval).'"' : '')
				. ($columns > 1 ? ' data-slides-per-view="' . esc_attr($columns) . '"' : '')
				. ($slides_space > 0 ? ' data-slides-space="' . esc_attr($slides_space) . '"' : '')
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. '>'
			. (!empty($subtitle) ? '<h6 class="sc_testimonials_subtitle sc_item_subtitle">' . trim(healthandcare_strmacros($subtitle)) . '</h6>' : '')
			. (!empty($title) ? '<h2 class="sc_testimonials_title sc_item_title">' . trim(healthandcare_strmacros($title)) . '</h2>' : '')
			. (!empty($description) ? '<div class="sc_testimonials_descr sc_item_descr">' . trim(healthandcare_strmacros($description)) . '</div>' : '')
			. (healthandcare_param_is_on($slider)
				? '<div class="slides swiper-wrapper">' 
				: ($columns > 1 
					? '<div class="sc_columns columns_wrap">' 
					: '')
				);
	
		$content = do_shortcode($content);
			
		if (healthandcare_param_is_on($custom) && $content) {
			$output .= $content;
		} else {
			global $post;
		
			if (!empty($ids)) {
				$posts = explode(',', $ids);
				$count = count($posts);
			}
			
			$args = array(
				'post_type' => 'testimonial',
				'post_status' => 'publish',
				'posts_per_page' => $count,
				'ignore_sticky_posts' => true,
				'order' => $order=='asc' ? 'asc' : 'desc',
			);
		
			if ($offset > 0 && empty($ids)) {
				$args['offset'] = $offset;
			}
		
			$args = healthandcare_query_add_sort_order($args, $orderby, $order);
			$args = healthandcare_query_add_posts_and_cats($args, $ids, 'testimonial', $cat, 'testimonial_group');
	
			$query = new WP_Query( $args );
	
			$post_number = 0;
				
			while ( $query->have_posts() ) { 
				$query->the_post();
				$post_number++;
				$args = array(
					'layout' => $style,
					'show' => false,
					'number' => $post_number,
					'posts_on_page' => ($count > 0 ? $count : $query->found_posts),
					"descr" => healthandcare_get_custom_option('post_excerpt_maxlength'.($columns > 1 ? '_masonry' : '')),
					"orderby" => $orderby,
					'content' => false,
					'terms_list' => false,
					'columns_count' => $columns,
					'slider' => $slider,
					'tag_id' => $id ? $id . '_' . $post_number : '',
					'tag_class' => '',
					'tag_animation' => '',
					'tag_css' => '',
					'tag_css_wh' => $ws . $hs
				);
				$post_data = healthandcare_get_post_data($args);
				$post_data['post_content'] = wpautop($post_data['post_content']);	// Add <p> around text and paragraphs. Need separate call because 'content'=>false (see above)
				$post_meta = get_post_meta($post_data['post_id'], 'testimonial_data', true);
				$thumb_sizes = healthandcare_get_thumb_sizes(array('layout' => $style));
				$args['author'] = $post_meta['testimonial_author'];
				$args['position'] = $post_meta['testimonial_position'];
				$args['link'] = !empty($post_meta['testimonial_link']) ? $post_meta['testimonial_link'] : '';	//$post_data['post_link'];
				$args['email'] = $post_meta['testimonial_email'];
				$args['photo'] = $post_data['post_thumb'];
				if (empty($args['photo']) && !empty($args['email'])) $args['photo'] = get_avatar($args['email'], $thumb_sizes['w']*min(2, max(1, healthandcare_get_theme_option("retina_ready"))));
				$output .= healthandcare_show_post_layout($args, $post_data);
			}
			wp_reset_postdata();
		}
	
		if (healthandcare_param_is_on($slider)) {
			$output .= '</div>'
				. '<div class="sc_slider_controls_wrap"><a class="sc_slider_prev" href="#"></a><a class="sc_slider_next" href="#"></a></div>'
				. '<div class="sc_slider_pagination_wrap"></div>';
		} else if ($columns > 1) {
			$output .= '</div>';
		}

		$output .= '</div>'
					. ($bg_color!='' || $bg_image!='' || $bg_overlay>0 || $bg_texture>0 || healthandcare_strlen($bg_texture)>2
						?  '</div></div>'
						: '');

		return apply_filters('healthandcare_shortcode_output', $output, 'trx_testimonials', $atts, $content);
	}
	if (function_exists('healthandcare_require_shortcode')) healthandcare_require_shortcode('trx_testimonials', 'healthandcare_sc_testimonials');
}
	
	
if (!function_exists('healthandcare_sc_testimonials_item')) {
	function healthandcare_sc_testimonials_item($atts, $content=null){
		if (healthandcare_in_shortcode_blogger()) return '';
		extract(healthandcare_html_decode(shortcode_atts(array(
			// Individual params
			"author" => "",
			"position" => "",
			"link" => "",
			"photo" => "",
			"email" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
		), $atts)));

		global $HEALTHANDCARE_GLOBALS;
		$HEALTHANDCARE_GLOBALS['sc_testimonials_counter']++;
	
		$id = $id ? $id : ($HEALTHANDCARE_GLOBALS['sc_testimonials_id'] ? $HEALTHANDCARE_GLOBALS['sc_testimonials_id'] . '_' . $HEALTHANDCARE_GLOBALS['sc_testimonials_counter'] : '');
	
		$thumb_sizes = healthandcare_get_thumb_sizes(array('layout' => $HEALTHANDCARE_GLOBALS['sc_testimonials_style']));

		if (empty($photo)) {
			if (!empty($email))
				$photo = get_avatar($email, $thumb_sizes['w']*min(2, max(1, healthandcare_get_theme_option("retina_ready"))));
		} else {
			if ($photo > 0) {
				$attach = wp_get_attachment_image_src( $photo, 'full' );
				if (isset($attach[0]) && $attach[0]!='')
					$photo = $attach[0];
			}
			$photo = healthandcare_get_resized_image_tag($photo, $thumb_sizes['w'], $thumb_sizes['h']);
		}

		$post_data = array(
			'post_content' => do_shortcode($content)
		);
		$args = array(
			'layout' => $HEALTHANDCARE_GLOBALS['sc_testimonials_style'],
			'number' => $HEALTHANDCARE_GLOBALS['sc_testimonials_counter'],
			'columns_count' => $HEALTHANDCARE_GLOBALS['sc_testimonials_columns'],
			'slider' => $HEALTHANDCARE_GLOBALS['sc_testimonials_slider'],
			'show' => false,
			'descr'  => 0,
			'tag_id' => $id,
			'tag_class' => $class,
			'tag_animation' => '',
			'tag_css' => $css,
			'tag_css_wh' => $HEALTHANDCARE_GLOBALS['sc_testimonials_css_wh'],
			'author' => $author,
			'position' => $position,
			'link' => $link,
			'email' => $email,
			'photo' => $photo
		);
		$output = healthandcare_show_post_layout($args, $post_data);

		return apply_filters('healthandcare_shortcode_output', $output, 'trx_testimonials_item', $atts, $content);
	}
	if (function_exists('healthandcare_require_shortcode')) healthandcare_require_shortcode('trx_testimonials_item', 'healthandcare_sc_testimonials_item');
}
// ---------------------------------- [/trx_testimonials] ---------------------------------------



// Add [trx_testimonials] and [trx_testimonials_item] in the shortcodes list
if (!function_exists('healthandcare_testimonials_get_shortcodes')) {
	//add_filter('healthandcare_action_shortcodes_list',	'healthandcare_testimonials_get_shortcodes');
	function healthandcare_testimonials_get_shortcodes() {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['shortcodes'])) {

			$testimonials_groups = healthandcare_get_list_terms(false, 'testimonial_group');
			$testimonials_styles = healthandcare_get_list_templates('testimonials');
			$controls = healthandcare_get_list_slider_controls();

			healthandcare_array_insert_before($HEALTHANDCARE_GLOBALS['shortcodes'], 'trx_title', array(
			
				// Testimonials
				"trx_testimonials" => array(
					"title" => esc_html__("Testimonials", "healthandcare"),
					"desc" => esc_html__("Insert testimonials into post (page)", "healthandcare"),
					"decorate" => true,
					"container" => false,
					"params" => array(
						"title" => array(
							"title" => esc_html__("Title", "healthandcare"),
							"desc" => esc_html__("Title for the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"subtitle" => array(
							"title" => esc_html__("Subtitle", "healthandcare"),
							"desc" => esc_html__("Subtitle for the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"description" => array(
							"title" => esc_html__("Description", "healthandcare"),
							"desc" => esc_html__("Short description for the block", "healthandcare"),
							"value" => "",
							"type" => "textarea"
						),
						"style" => array(
							"title" => esc_html__("Testimonials style", "healthandcare"),
							"desc" => esc_html__("Select style to display testimonials", "healthandcare"),
							"value" => "testimonials-1",
							"type" => "select",
							"options" => $testimonials_styles
						),
						"columns" => array(
							"title" => esc_html__("Columns", "healthandcare"),
							"desc" => esc_html__("How many columns use to show testimonials", "healthandcare"),
							"value" => 1,
							"min" => 1,
							"max" => 6,
							"step" => 1,
							"type" => "spinner"
						),
						"slider" => array(
							"title" => esc_html__("Slider", "healthandcare"),
							"desc" => esc_html__("Use slider to show testimonials", "healthandcare"),
							"value" => "yes",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"controls" => array(
							"title" => esc_html__("Controls", "healthandcare"),
							"desc" => esc_html__("Slider controls style and position", "healthandcare"),
							"dependency" => array(
								'slider' => array('yes')
							),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $controls
						),
						"slides_space" => array(
							"title" => esc_html__("Space between slides", "healthandcare"),
							"desc" => esc_html__("Size of space (in px) between slides", "healthandcare"),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => 0,
							"min" => 0,
							"max" => 100,
							"step" => 10,
							"type" => "spinner"
						),
						"interval" => array(
							"title" => esc_html__("Slides change interval", "healthandcare"),
							"desc" => esc_html__("Slides change interval (in milliseconds: 1000ms = 1s)", "healthandcare"),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => 7000,
							"step" => 500,
							"min" => 0,
							"type" => "spinner"
						),
						"autoheight" => array(
							"title" => esc_html__("Autoheight", "healthandcare"),
							"desc" => esc_html__("Change whole slider's height (make it equal current slide's height)", "healthandcare"),
							"dependency" => array(
								'slider' => array('yes')
							),
							"value" => "yes",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"align" => array(
							"title" => esc_html__("Alignment", "healthandcare"),
							"desc" => esc_html__("Alignment of the testimonials block", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						),
						"custom" => array(
							"title" => esc_html__("Custom", "healthandcare"),
							"desc" => esc_html__("Allow get testimonials from inner shortcodes (custom) or get it from specified group (cat)", "healthandcare"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"cat" => array(
							"title" => esc_html__("Categories", "healthandcare"),
							"desc" => esc_html__("Select categories (groups) to show testimonials. If empty - select testimonials from any category (group) or from IDs list", "healthandcare"),
							"dependency" => array(
								'custom' => array('no')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => healthandcare_array_merge(array(0 => esc_html__('- Select category -', 'healthandcare')), $testimonials_groups)
						),
						"count" => array(
							"title" => esc_html__("Number of posts", "healthandcare"),
							"desc" => esc_html__("How many posts will be displayed? If used IDs - this parameter ignored.", "healthandcare"),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => 3,
							"min" => 1,
							"max" => 100,
							"type" => "spinner"
						),
						"offset" => array(
							"title" => esc_html__("Offset before select posts", "healthandcare"),
							"desc" => esc_html__("Skip posts before select next part.", "healthandcare"),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => 0,
							"min" => 0,
							"type" => "spinner"
						),
						"orderby" => array(
							"title" => esc_html__("Post order by", "healthandcare"),
							"desc" => esc_html__("Select desired posts sorting method", "healthandcare"),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "date",
							"type" => "select",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['sorting']
						),
						"order" => array(
							"title" => esc_html__("Post order", "healthandcare"),
							"desc" => esc_html__("Select desired posts order", "healthandcare"),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "desc",
							"type" => "switch",
							"size" => "big",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['ordering']
						),
						"ids" => array(
							"title" => esc_html__("Post IDs list", "healthandcare"),
							"desc" => esc_html__("Comma separated list of posts ID. If set - parameters above are ignored!", "healthandcare"),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "",
							"type" => "text"
						),
						"scheme" => array(
							"title" => esc_html__("Color scheme", "healthandcare"),
							"desc" => esc_html__("Select color scheme for this block", "healthandcare"),
							"value" => "",
							"type" => "checklist",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['schemes']
						),
						"bg_color" => array(
							"title" => esc_html__("Background color", "healthandcare"),
							"desc" => esc_html__("Any background color for this section", "healthandcare"),
							"value" => "",
							"type" => "color"
						),
						"bg_image" => array(
							"title" => esc_html__("Background image URL", "healthandcare"),
							"desc" => esc_html__("Select or upload image or write URL from other site for the background", "healthandcare"),
							"readonly" => false,
							"value" => "",
							"type" => "media"
						),
						"bg_overlay" => array(
							"title" => esc_html__("Overlay", "healthandcare"),
							"desc" => esc_html__("Overlay color opacity (from 0.0 to 1.0)", "healthandcare"),
							"min" => "0",
							"max" => "1",
							"step" => "0.1",
							"value" => "0",
							"type" => "spinner"
						),
						"bg_texture" => array(
							"title" => esc_html__("Texture", "healthandcare"),
							"desc" => esc_html__("Predefined texture style from 1 to 11. 0 - without texture.", "healthandcare"),
							"min" => "0",
							"max" => "11",
							"step" => "1",
							"value" => "0",
							"type" => "spinner"
						),
						"width" => healthandcare_shortcodes_width(),
						"height" => healthandcare_shortcodes_height(),
						"top" => $HEALTHANDCARE_GLOBALS['sc_params']['top'],
						"bottom" => $HEALTHANDCARE_GLOBALS['sc_params']['bottom'],
						"left" => $HEALTHANDCARE_GLOBALS['sc_params']['left'],
						"right" => $HEALTHANDCARE_GLOBALS['sc_params']['right'],
						"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
						"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
						"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
						"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
					),
					"children" => array(
						"name" => "trx_testimonials_item",
						"title" => esc_html__("Item", "healthandcare"),
						"desc" => esc_html__("Testimonials item (custom parameters)", "healthandcare"),
						"container" => true,
						"params" => array(
							"author" => array(
								"title" => esc_html__("Author", "healthandcare"),
								"desc" => esc_html__("Name of the testimonmials author", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"link" => array(
								"title" => esc_html__("Link", "healthandcare"),
								"desc" => esc_html__("Link URL to the testimonmials author page", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"email" => array(
								"title" => esc_html__("E-mail", "healthandcare"),
								"desc" => esc_html__("E-mail of the testimonmials author (to get gravatar)", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"photo" => array(
								"title" => esc_html__("Photo", "healthandcare"),
								"desc" => esc_html__("Select or upload photo of testimonmials author or write URL of photo from other site", "healthandcare"),
								"value" => "",
								"type" => "media"
							),
							"_content_" => array(
								"title" => esc_html__("Testimonials text", "healthandcare"),
								"desc" => esc_html__("Current testimonials text", "healthandcare"),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
							"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
							"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
						)
					)
				)

			));
		}
	}
}


// Add [trx_testimonials] and [trx_testimonials_item] in the VC shortcodes list
if (!function_exists('healthandcare_testimonials_get_shortcodes_vc')) {
	//add_filter('healthandcare_action_shortcodes_list_vc',	'healthandcare_testimonials_get_shortcodes_vc');
	function healthandcare_testimonials_get_shortcodes_vc() {
		global $HEALTHANDCARE_GLOBALS;

		$testimonials_groups = healthandcare_get_list_terms(false, 'testimonial_group');
		$testimonials_styles = healthandcare_get_list_templates('testimonials');
		$controls			 = healthandcare_get_list_slider_controls();
			
		// Testimonials			
		vc_map( array(
				"base" => "trx_testimonials",
				"name" => esc_html__("Testimonials", "healthandcare"),
				"description" => esc_html__("Insert testimonials slider", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_testimonials',
				"class" => "trx_sc_collection trx_sc_testimonials",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_testimonials_item'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Testimonials style", "healthandcare"),
						"description" => esc_html__("Select style to display testimonials", "healthandcare"),
						"class" => "",
						"admin_label" => true,
						"value" => array_flip($testimonials_styles),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "healthandcare"),
						"description" => esc_html__("How many columns use to show testimonials", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "slider",
						"heading" => esc_html__("Slider", "healthandcare"),
						"description" => esc_html__("Use slider to show testimonials", "healthandcare"),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'healthandcare'),
						"class" => "",
						"std" => "yes",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['yes_no']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "controls",
						"heading" => esc_html__("Controls", "healthandcare"),
						"description" => esc_html__("Slider controls style and position", "healthandcare"),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'healthandcare'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"std" => "no",
						"value" => array_flip($controls),
						"type" => "dropdown"
					),
					array(
						"param_name" => "slides_space",
						"heading" => esc_html__("Space between slides", "healthandcare"),
						"description" => esc_html__("Size of space (in px) between slides", "healthandcare"),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'healthandcare'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "interval",
						"heading" => esc_html__("Slides change interval", "healthandcare"),
						"description" => esc_html__("Slides change interval (in milliseconds: 1000ms = 1s)", "healthandcare"),
						"group" => esc_html__('Slider', 'healthandcare'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => "7000",
						"type" => "textfield"
					),
					array(
						"param_name" => "autoheight",
						"heading" => esc_html__("Autoheight", "healthandcare"),
						"description" => esc_html__("Change whole slider's height (make it equal current slide's height)", "healthandcare"),
						"group" => esc_html__('Slider', 'healthandcare'),
						'dependency' => array(
							'element' => 'slider',
							'value' => 'yes'
						),
						"class" => "",
						"value" => array("Autoheight" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "align",
						"heading" => esc_html__("Alignment", "healthandcare"),
						"description" => esc_html__("Alignment of the testimonials block", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "custom",
						"heading" => esc_html__("Custom", "healthandcare"),
						"description" => esc_html__("Allow get testimonials from inner shortcodes (custom) or get it from specified group (cat)", "healthandcare"),
						"class" => "",
						"value" => array("Custom slides" => "yes" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", "healthandcare"),
						"description" => esc_html__("Title for the block", "healthandcare"),
						"admin_label" => true,
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "subtitle",
						"heading" => esc_html__("Subtitle", "healthandcare"),
						"description" => esc_html__("Subtitle for the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "description",
						"heading" => esc_html__("Description", "healthandcare"),
						"description" => esc_html__("Description for the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textarea"
					),
					array(
						"param_name" => "cat",
						"heading" => esc_html__("Categories", "healthandcare"),
						"description" => esc_html__("Select categories (groups) to show testimonials. If empty - select testimonials from any category (group) or from IDs list", "healthandcare"),
						"group" => esc_html__('Query', 'healthandcare'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip(healthandcare_array_merge(array(0 => esc_html__('- Select category -', 'healthandcare')), $testimonials_groups)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "count",
						"heading" => esc_html__("Number of posts", "healthandcare"),
						"description" => esc_html__("How many posts will be displayed? If used IDs - this parameter ignored.", "healthandcare"),
						"group" => esc_html__('Query', 'healthandcare'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "offset",
						"heading" => esc_html__("Offset before select posts", "healthandcare"),
						"description" => esc_html__("Skip posts before select next part.", "healthandcare"),
						"group" => esc_html__('Query', 'healthandcare'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "0",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Post sorting", "healthandcare"),
						"description" => esc_html__("Select desired posts sorting method", "healthandcare"),
						"group" => esc_html__('Query', 'healthandcare'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['sorting']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Post order", "healthandcare"),
						"description" => esc_html__("Select desired posts order", "healthandcare"),
						"group" => esc_html__('Query', 'healthandcare'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['ordering']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("Post IDs list", "healthandcare"),
						"description" => esc_html__("Comma separated list of posts ID. If set - parameters above are ignored!", "healthandcare"),
						"group" => esc_html__('Query', 'healthandcare'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "scheme",
						"heading" => esc_html__("Color scheme", "healthandcare"),
						"description" => esc_html__("Select color scheme for this block", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['schemes']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "bg_color",
						"heading" => esc_html__("Background color", "healthandcare"),
						"description" => esc_html__("Any background color for this section", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "colorpicker"
					),
					array(
						"param_name" => "bg_image",
						"heading" => esc_html__("Background image URL", "healthandcare"),
						"description" => esc_html__("Select background image from library for this section", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "bg_overlay",
						"heading" => esc_html__("Overlay", "healthandcare"),
						"description" => esc_html__("Overlay color opacity (from 0.0 to 1.0)", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "bg_texture",
						"heading" => esc_html__("Texture", "healthandcare"),
						"description" => esc_html__("Texture style from 1 to 11. Empty or 0 - without texture.", "healthandcare"),
						"group" => esc_html__('Colors and Images', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					healthandcare_vc_width(),
					healthandcare_vc_height(),
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right'],
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css']
				)
		) );
			
			
		vc_map( array(
				"base" => "trx_testimonials_item",
				"name" => esc_html__("Testimonial", "healthandcare"),
				"description" => esc_html__("Single testimonials item", "healthandcare"),
				"show_settings_on_create" => true,
				"class" => "trx_sc_single trx_sc_testimonials_item",
				"content_element" => true,
				"is_container" => false,
				'icon' => 'icon_trx_testimonials_item',
				"as_child" => array('only' => 'trx_testimonials'),
				"as_parent" => array('except' => 'trx_testimonials'),
				"params" => array(
					array(
						"param_name" => "author",
						"heading" => esc_html__("Author", "healthandcare"),
						"description" => esc_html__("Name of the testimonmials author", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link", "healthandcare"),
						"description" => esc_html__("Link URL to the testimonmials author page", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "email",
						"heading" => esc_html__("E-mail", "healthandcare"),
						"description" => esc_html__("E-mail of the testimonmials author", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "photo",
						"heading" => esc_html__("Photo", "healthandcare"),
						"description" => esc_html__("Select or upload photo of testimonmials author or write URL of photo from other site", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "content",
						"heading" => esc_html__("Testimonials text", "healthandcare"),
						"description" => esc_html__("Current testimonials text", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textarea_html"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxTextView'
		) );
			
		class WPBakeryShortCode_Trx_Testimonials extends HEALTHANDCARE_VC_ShortCodeColumns {}
		class WPBakeryShortCode_Trx_Testimonials_Item extends HEALTHANDCARE_VC_ShortCodeSingle {}
		
	}
}
?>