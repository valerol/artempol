<?php
/**
 * HealthandCARE Framework: Services post type settings
 *
 * @package	healthandcare
 * @since	healthandcare 1.0
 */

// Theme init
if (!function_exists('healthandcare_services_theme_setup')) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_services_theme_setup' );
	function healthandcare_services_theme_setup() {
		
		// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
		add_filter('healthandcare_filter_get_blog_type',			'healthandcare_services_get_blog_type', 9, 2);
		add_filter('healthandcare_filter_get_blog_title',		'healthandcare_services_get_blog_title', 9, 2);
		add_filter('healthandcare_filter_get_current_taxonomy',	'healthandcare_services_get_current_taxonomy', 9, 2);
		add_filter('healthandcare_filter_is_taxonomy',			'healthandcare_services_is_taxonomy', 9, 2);
		add_filter('healthandcare_filter_get_stream_page_title',	'healthandcare_services_get_stream_page_title', 9, 2);
		add_filter('healthandcare_filter_get_stream_page_link',	'healthandcare_services_get_stream_page_link', 9, 2);
		add_filter('healthandcare_filter_get_stream_page_id',	'healthandcare_services_get_stream_page_id', 9, 2);
		add_filter('healthandcare_filter_query_add_filters',		'healthandcare_services_query_add_filters', 9, 2);
		add_filter('healthandcare_filter_detect_inheritance_key','healthandcare_services_detect_inheritance_key', 9, 1);

		// Extra column for services lists
		if (healthandcare_get_theme_option('show_overriden_posts')=='yes') {
			add_filter('manage_edit-services_columns',			'healthandcare_post_add_options_column', 9);
			add_filter('manage_services_posts_custom_column',	'healthandcare_post_fill_options_column', 9, 2);
		}

		// Add shortcodes [trx_services] and [trx_services_item]
		add_action('healthandcare_action_shortcodes_list',		'healthandcare_services_get_shortcodes');
		add_action('healthandcare_action_shortcodes_list_vc',	'healthandcare_services_get_shortcodes_vc');
		
		if (function_exists('healthandcare_require_data')) {
			// Prepare type "Team"
			healthandcare_require_data( 'post_type', 'services', array(
				'label'               => esc_html__( 'Service item', 'healthandcare' ),
				'description'         => esc_html__( 'Service Description', 'healthandcare' ),
				'labels'              => array(
					'name'                => _x( 'Services', 'Post Type General Name', 'healthandcare' ),
					'singular_name'       => _x( 'Service item', 'Post Type Singular Name', 'healthandcare' ),
					'menu_name'           => esc_html__( 'Services', 'healthandcare' ),
					'parent_item_colon'   => esc_html__( 'Parent Item:', 'healthandcare' ),
					'all_items'           => esc_html__( 'All Services', 'healthandcare' ),
					'view_item'           => esc_html__( 'View Item', 'healthandcare' ),
					'add_new_item'        => esc_html__( 'Add New Service', 'healthandcare' ),
					'add_new'             => esc_html__( 'Add New', 'healthandcare' ),
					'edit_item'           => esc_html__( 'Edit Item', 'healthandcare' ),
					'update_item'         => esc_html__( 'Update Item', 'healthandcare' ),
					'search_items'        => esc_html__( 'Search Item', 'healthandcare' ),
					'not_found'           => esc_html__( 'Not found', 'healthandcare' ),
					'not_found_in_trash'  => esc_html__( 'Not found in Trash', 'healthandcare' ),
				),
				'supports'            => array( 'title', 'excerpt', 'editor', 'author', 'thumbnail', 'comments', 'custom-fields'),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'menu_icon'			  => 'dashicons-info',
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 25,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'query_var'           => true,
				'capability_type'     => 'page',
				'rewrite'             => true
				)
			);
			
			// Prepare taxonomy for team
			healthandcare_require_data( 'taxonomy', 'services_group', array(
				'post_type'			=> array( 'services' ),
				'hierarchical'      => true,
				'labels'            => array(
					'name'              => _x( 'Services Group', 'taxonomy general name', 'healthandcare' ),
					'singular_name'     => _x( 'Group', 'taxonomy singular name', 'healthandcare' ),
					'search_items'      => esc_html__( 'Search Groups', 'healthandcare' ),
					'all_items'         => esc_html__( 'All Groups', 'healthandcare' ),
					'parent_item'       => esc_html__( 'Parent Group', 'healthandcare' ),
					'parent_item_colon' => esc_html__( 'Parent Group:', 'healthandcare' ),
					'edit_item'         => esc_html__( 'Edit Group', 'healthandcare' ),
					'update_item'       => esc_html__( 'Update Group', 'healthandcare' ),
					'add_new_item'      => esc_html__( 'Add New Group', 'healthandcare' ),
					'new_item_name'     => esc_html__( 'New Group Name', 'healthandcare' ),
					'menu_name'         => esc_html__( 'Services Group', 'healthandcare' ),
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'services_group' ),
				)
			);
		}
	}
}

if ( !function_exists( 'healthandcare_services_settings_theme_setup2' ) ) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_services_settings_theme_setup2', 3 );
	function healthandcare_services_settings_theme_setup2() {
		// Add post type 'services' and taxonomy 'services_group' into theme inheritance list
		healthandcare_add_theme_inheritance( array('services' => array(
			'stream_template' => 'blog-services',
			'single_template' => 'single-services',
			'taxonomy' => array('services_group'),
			'taxonomy_tags' => array(),
			'post_type' => array('services'),
			'override' => 'page'
			) )
		);
	}
}



// Return true, if current page is services page
if ( !function_exists( 'healthandcare_is_services_page' ) ) {
	function healthandcare_is_services_page() {
		return get_query_var('post_type')=='services' || is_tax('services_group') || (is_page() && healthandcare_get_template_page_id('blog-services')==get_the_ID());
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'healthandcare_services_detect_inheritance_key' ) ) {
	//add_filter('healthandcare_filter_detect_inheritance_key',	'healthandcare_services_detect_inheritance_key', 9, 1);
	function healthandcare_services_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return healthandcare_is_services_page() ? 'services' : '';
	}
}

// Filter to detect current page slug
if ( !function_exists( 'healthandcare_services_get_blog_type' ) ) {
	//add_filter('healthandcare_filter_get_blog_type',	'healthandcare_services_get_blog_type', 9, 2);
	function healthandcare_services_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		if ($query && $query->is_tax('services_group') || is_tax('services_group'))
			$page = 'services_category';
		else if ($query && $query->get('post_type')=='services' || get_query_var('post_type')=='services')
			$page = $query && $query->is_single() || is_single() ? 'services_item' : 'services';
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'healthandcare_services_get_blog_title' ) ) {
	//add_filter('healthandcare_filter_get_blog_title',	'healthandcare_services_get_blog_title', 9, 2);
	function healthandcare_services_get_blog_title($title, $page) {
		if (!empty($title)) return $title;
		if ( healthandcare_strpos($page, 'services')!==false ) {
			if ( $page == 'services_category' ) {
				$term = get_term_by( 'slug', get_query_var( 'services_group' ), 'services_group', OBJECT);
				$title = $term->name;
			} else if ( $page == 'services_item' ) {
				$title = healthandcare_get_post_title();
			} else {
				$title = esc_html__('All services', 'healthandcare');
			}
		}
		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'healthandcare_services_get_stream_page_title' ) ) {
	//add_filter('healthandcare_filter_get_stream_page_title',	'healthandcare_services_get_stream_page_title', 9, 2);
	function healthandcare_services_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (healthandcare_strpos($page, 'services')!==false) {
			if (($page_id = healthandcare_services_get_stream_page_id(0, $page=='services' ? 'blog-services' : $page)) > 0)
				$title = healthandcare_get_post_title($page_id);
			else
				$title = esc_html__('All services', 'healthandcare');
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'healthandcare_services_get_stream_page_id' ) ) {
	//add_filter('healthandcare_filter_get_stream_page_id',	'healthandcare_services_get_stream_page_id', 9, 2);
	function healthandcare_services_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (healthandcare_strpos($page, 'services')!==false) $id = healthandcare_get_template_page_id('blog-services');
		return $id;
	}
}

// Filter to detect stream page URL
if ( !function_exists( 'healthandcare_services_get_stream_page_link' ) ) {
	//add_filter('healthandcare_filter_get_stream_page_link',	'healthandcare_services_get_stream_page_link', 9, 2);
	function healthandcare_services_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (healthandcare_strpos($page, 'services')!==false) {
			$id = healthandcare_get_template_page_id('blog-services');
			if ($id) $url = get_permalink($id);
		}
		return $url;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'healthandcare_services_get_current_taxonomy' ) ) {
	//add_filter('healthandcare_filter_get_current_taxonomy',	'healthandcare_services_get_current_taxonomy', 9, 2);
	function healthandcare_services_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( healthandcare_strpos($page, 'services')!==false ) {
			$tax = 'services_group';
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'healthandcare_services_is_taxonomy' ) ) {
	//add_filter('healthandcare_filter_is_taxonomy',	'healthandcare_services_is_taxonomy', 9, 2);
	function healthandcare_services_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else 
			return $query && $query->get('services_group')!='' || is_tax('services_group') ? 'services_group' : '';
	}
}

// Add custom post type and/or taxonomies arguments to the query
if ( !function_exists( 'healthandcare_services_query_add_filters' ) ) {
	//add_filter('healthandcare_filter_query_add_filters',	'healthandcare_services_query_add_filters', 9, 2);
	function healthandcare_services_query_add_filters($args, $filter) {
		if ($filter == 'services') {
			$args['post_type'] = 'services';
		}
		return $args;
	}
}





// ---------------------------------- [trx_services] ---------------------------------------

/*
[trx_services id="unique_id" columns="4" count="4" style="services-1|services-2|..." title="Block title" subtitle="xxx" description="xxxxxx"]
	[trx_services_item icon="url" title="Item title" description="Item description" link="url" link_caption="Link text"]
	[trx_services_item icon="url" title="Item title" description="Item description" link="url" link_caption="Link text"]
[/trx_services]
*/
if ( !function_exists( 'healthandcare_sc_services' ) ) {
	function healthandcare_sc_services($atts, $content=null){
		if (healthandcare_in_shortcode_blogger()) return '';
		extract(healthandcare_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "services-1",
			"columns" => 4,
			"slider" => "no",
			"controls" => "no",
			"interval" => "",
			"autoheight" => "no",
			"align" => "",
			"custom" => "no",
			"type" => "icons",	// icons | images
			"ids" => "",
			"cat" => "",
			"count" => 4,
			"offset" => "",
			"orderby" => "date",
			"order" => "desc",
			"readmore" => esc_html__('Learn more', 'healthandcare'),
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link_caption" => esc_html__('Learn more', 'healthandcare'),
			"link" => '',
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
	
		if (empty($id)) $id = "sc_services_".str_replace('.', '', mt_rand());
		if (empty($width)) $width = "100%";
		if (!empty($height) && healthandcare_param_is_on($autoheight)) $autoheight = "no";
		if (empty($interval)) $interval = mt_rand(5000, 10000);
		
		$ms = healthandcare_get_css_position_from_values($top, $right, $bottom, $left);
		$ws = healthandcare_get_css_position_from_values('', '', '', '', $width);
		$hs = healthandcare_get_css_position_from_values('', '', '', '', '', $height);
		$css .= ($ms) . ($hs) . ($ws);

		$count = max(1, (int) $count);
		$columns = max(1, min(12, (int) $columns));
		if (healthandcare_param_is_off($custom) && $count < $columns) $columns = $count;

		global $HEALTHANDCARE_GLOBALS;
		$HEALTHANDCARE_GLOBALS['sc_services_id'] = $id;
		$HEALTHANDCARE_GLOBALS['sc_services_style'] = $style;
		$HEALTHANDCARE_GLOBALS['sc_services_columns'] = $columns;
		$HEALTHANDCARE_GLOBALS['sc_services_counter'] = 0;
		$HEALTHANDCARE_GLOBALS['sc_services_slider'] = $slider;
		$HEALTHANDCARE_GLOBALS['sc_services_css_wh'] = $ws . $hs;
		$HEALTHANDCARE_GLOBALS['sc_services_readmore'] = $readmore;
		
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_services'
							. ' sc_services_style_'.esc_attr($style)
							. ' sc_services_type_'.esc_attr($type)
							. ' ' . esc_attr(healthandcare_get_template_property($style, 'container_classes'))
							. ' ' . esc_attr(healthandcare_get_slider_controls_classes($controls))
							. (healthandcare_param_is_on($slider)
								? ' sc_slider_swiper swiper-slider-container'
									. (healthandcare_param_is_on($autoheight) ? ' sc_slider_height_auto' : '')
									. ($hs ? ' sc_slider_height_fixed' : '')
								: '')
							. (!empty($class) ? ' '.esc_attr($class) : '')
							. ($align!='' && $align!='none' ? ' align'.esc_attr($align) : '')
							. '"'
						. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
						. (!empty($width) && healthandcare_strpos($width, '%')===false ? ' data-old-width="' . esc_attr($width) . '"' : '')
						. (!empty($height) && healthandcare_strpos($height, '%')===false ? ' data-old-height="' . esc_attr($height) . '"' : '')
						. ((int) $interval > 0 ? ' data-interval="'.esc_attr($interval).'"' : '')
						. ($columns > 1 ? ' data-slides-per-view="' . esc_attr($columns) . '"' : '')
						. (!healthandcare_param_is_off($animation) ? ' data-animation="'.esc_attr(healthandcare_get_animation_classes($animation)).'"' : '')
					. '>'
					. (!empty($subtitle) ? '<h6 class="sc_services_subtitle sc_item_subtitle">' . trim(healthandcare_strmacros($subtitle)) . '</h6>' : '')
					. (!empty($title) ? '<h2 class="sc_services_title sc_item_title">' . trim(healthandcare_strmacros($title)) . '</h2>' : '')
					. (!empty($description) ? '<div class="sc_services_descr sc_item_descr">' . trim(healthandcare_strmacros($description)) . '</div>' : '')
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
				'post_type' => 'services',
				'post_status' => 'publish',
				'posts_per_page' => $count,
				'ignore_sticky_posts' => true,
				'order' => $order=='asc' ? 'asc' : 'desc',
				'readmore' => $readmore
			);
		
			if ($offset > 0 && empty($ids)) {
				$args['offset'] = $offset;
			}
		
			$args = healthandcare_query_add_sort_order($args, $orderby, $order);
			$args = healthandcare_query_add_posts_and_cats($args, $ids, 'services', $cat, 'services_group');
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
					'readmore' => $readmore,
					'tag_type' => $type,
					'columns_count' => $columns,
					'slider' => $slider,
					'tag_id' => $id ? $id . '_' . $post_number : '',
					'tag_class' => '',
					'tag_animation' => '',
					'tag_css' => '',
					'tag_css_wh' => $ws . $hs
				);
				$output .= healthandcare_show_post_layout($args);
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

		$output .=  (!empty($link) ? '<div class="sc_services_button sc_item_button">'.do_shortcode('[trx_button link="'.esc_url($link).'" icon="icon-right-2"]'.esc_html($link_caption).'[/trx_button]').'</div>' : '')
					. '</div>';
	
		return apply_filters('healthandcare_shortcode_output', $output, 'trx_services', $atts, $content);
	}
    if (function_exists('healthandcare_require_shortcode')) healthandcare_require_shortcode('trx_services', 'healthandcare_sc_services');
}



if ( !function_exists( 'healthandcare_sc_services_item' ) ) {
	function healthandcare_sc_services_item($atts, $content=null) {
		if (healthandcare_in_shortcode_blogger()) return '';
		extract(healthandcare_html_decode(shortcode_atts( array(
			// Individual params
			"icon" => "",
			"image" => "",
			"title" => "",
			"link" => "",
			"readmore" => "(none)",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => ""
		), $atts)));
	
		global $HEALTHANDCARE_GLOBALS;
		$HEALTHANDCARE_GLOBALS['sc_services_counter']++;

		$id = $id ? $id : ($HEALTHANDCARE_GLOBALS['sc_services_id'] ? $HEALTHANDCARE_GLOBALS['sc_services_id'] . '_' . $HEALTHANDCARE_GLOBALS['sc_services_counter'] : '');

		$descr = trim(chop(do_shortcode($content)));
		$readmore = $readmore=='(none)' ? $HEALTHANDCARE_GLOBALS['sc_services_readmore'] : $readmore;

		if (!empty($icon)) {
			$type = 'icons';
		} else if (!empty($image)) {
			$type = 'images';
			if ($image > 0) {
				$attach = wp_get_attachment_image_src( $image, 'full' );
				if (isset($attach[0]) && $attach[0]!='')
					$image = $attach[0];
			}
			$thumb_sizes = healthandcare_get_thumb_sizes(array('layout' => $HEALTHANDCARE_GLOBALS['sc_services_style']));
			$image = healthandcare_get_resized_image_tag($image, $thumb_sizes['w'], $thumb_sizes['h']);
		}
	
		$post_data = array(
			'post_title' => $title,
			'post_excerpt' => $descr,
			'post_thumb' => $image,
			'post_icon' => $icon,
			'post_link' => $link
		);
		$args = array(
			'layout' => $HEALTHANDCARE_GLOBALS['sc_services_style'],
			'number' => $HEALTHANDCARE_GLOBALS['sc_services_counter'],
			'columns_count' => $HEALTHANDCARE_GLOBALS['sc_services_columns'],
			'slider' => $HEALTHANDCARE_GLOBALS['sc_services_slider'],
			'show' => false,
			'descr'  => 0,
			'readmore' => $readmore,
			'tag_type' => $type,
			'tag_id' => $id,
			'tag_class' => $class,
			'tag_animation' => $animation,
			'tag_css' => $css,
			'tag_css_wh' => $HEALTHANDCARE_GLOBALS['sc_services_css_wh']
		);
		$output = healthandcare_show_post_layout($args, $post_data);
		return apply_filters('healthandcare_shortcode_output', $output, 'trx_services_item', $atts, $content);
	}
    if (function_exists('healthandcare_require_shortcode')) healthandcare_require_shortcode('trx_services_item', 'healthandcare_sc_services_item');
}
// ---------------------------------- [/trx_services] ---------------------------------------



// Add [trx_services] and [trx_services_item] in the shortcodes list
if (!function_exists('healthandcare_services_get_shortcodes')) {
	//add_filter('healthandcare_action_shortcodes_list',	'healthandcare_services_get_shortcodes');
	function healthandcare_services_get_shortcodes() {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['shortcodes'])) {

			$services_groups = healthandcare_get_list_terms(false, 'services_group');
			$services_styles = healthandcare_get_list_templates('services');
			$controls 		 = healthandcare_get_list_slider_controls();

			healthandcare_array_insert_after($HEALTHANDCARE_GLOBALS['shortcodes'], 'trx_section', array(

				// Services
				"trx_services" => array(
					"title" => esc_html__("Services", "healthandcare"),
					"desc" => esc_html__("Insert services list in your page (post)", "healthandcare"),
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
							"title" => esc_html__("Services style", "healthandcare"),
							"desc" => esc_html__("Select style to display services list", "healthandcare"),
							"value" => "services-1",
							"type" => "select",
							"options" => $services_styles
						),
						"type" => array(
							"title" => esc_html__("Icon's type", "healthandcare"),
							"desc" => esc_html__("Select type of icons: font icon or image", "healthandcare"),
							"value" => "icons",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => array(
								'icons'  => esc_html__('Icons', 'healthandcare'),
								'images' => esc_html__('Images', 'healthandcare')
							)
						),
						"columns" => array(
							"title" => esc_html__("Columns", "healthandcare"),
							"desc" => esc_html__("How many columns use to show services list", "healthandcare"),
							"value" => 4,
							"min" => 2,
							"max" => 6,
							"step" => 1,
							"type" => "spinner"
						),
						"slider" => array(
							"title" => esc_html__("Slider", "healthandcare"),
							"desc" => esc_html__("Use slider to show services", "healthandcare"),
							"value" => "no",
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
							"desc" => esc_html__("Alignment of the services block", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
						),
						"custom" => array(
							"title" => esc_html__("Custom", "healthandcare"),
							"desc" => esc_html__("Allow get services items from inner shortcodes (custom) or get it from specified group (cat)", "healthandcare"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"cat" => array(
							"title" => esc_html__("Categories", "healthandcare"),
							"desc" => esc_html__("Select categories (groups) to show services list. If empty - select services from any category (group) or from IDs list", "healthandcare"),
							"dependency" => array(
								'custom' => array('no')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => healthandcare_array_merge(array(0 => esc_html__('- Select category -', 'healthandcare')), $services_groups)
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
							"value" => "title",
							"type" => "select",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['sorting']
						),
						"order" => array(
							"title" => esc_html__("Post order", "healthandcare"),
							"desc" => esc_html__("Select desired posts order", "healthandcare"),
							"dependency" => array(
								'custom' => array('no')
							),
							"value" => "asc",
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
						"readmore" => array(
							"title" => esc_html__("Read more", "healthandcare"),
							"desc" => esc_html__("Caption for the Read more link (if empty - link not showed)", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"link" => array(
							"title" => esc_html__("Button URL", "healthandcare"),
							"desc" => esc_html__("Link URL for the button at the bottom of the block", "healthandcare"),
							"value" => "",
							"type" => "text"
						),
						"link_caption" => array(
							"title" => esc_html__("Button caption", "healthandcare"),
							"desc" => esc_html__("Caption for the button at the bottom of the block", "healthandcare"),
							"value" => "",
							"type" => "text"
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
						"name" => "trx_services_item",
						"title" => esc_html__("Service item", "healthandcare"),
						"desc" => esc_html__("Service item", "healthandcare"),
						"container" => true,
						"params" => array(
							"title" => array(
								"title" => esc_html__("Title", "healthandcare"),
								"desc" => esc_html__("Item's title", "healthandcare"),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"icon" => array(
								"title" => esc_html__("Item's icon",  'healthandcare'),
								"desc" => esc_html__('Select icon for the item from Fontello icons set',  'healthandcare'),
								"value" => "",
								"type" => "icons",
								"options" => $HEALTHANDCARE_GLOBALS['sc_params']['icons']
							),
							"image" => array(
								"title" => esc_html__("Item's image", "healthandcare"),
								"desc" => esc_html__("Item's image (if icon not selected)", "healthandcare"),
								"dependency" => array(
									'icon' => array('is_empty', 'none')
								),
								"value" => "",
								"readonly" => false,
								"type" => "media"
							),
							"link" => array(
								"title" => esc_html__("Link", "healthandcare"),
								"desc" => esc_html__("Link on service's item page", "healthandcare"),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"readmore" => array(
								"title" => esc_html__("Read more", "healthandcare"),
								"desc" => esc_html__("Caption for the Read more link (if empty - link not showed)", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"_content_" => array(
								"title" => esc_html__("Description", "healthandcare"),
								"desc" => esc_html__("Item's short description", "healthandcare"),
								"divider" => true,
								"rows" => 4,
								"value" => "",
								"type" => "textarea"
							),
							"id" => $HEALTHANDCARE_GLOBALS['sc_params']['id'],
							"class" => $HEALTHANDCARE_GLOBALS['sc_params']['class'],
							"animation" => $HEALTHANDCARE_GLOBALS['sc_params']['animation'],
							"css" => $HEALTHANDCARE_GLOBALS['sc_params']['css']
						)
					)
				)

			));
		}
	}
}


// Add [trx_services] and [trx_services_item] in the VC shortcodes list
if (!function_exists('healthandcare_services_get_shortcodes_vc')) {
	//add_filter('healthandcare_action_shortcodes_list_vc',	'healthandcare_services_get_shortcodes_vc');
	function healthandcare_services_get_shortcodes_vc() {
		global $HEALTHANDCARE_GLOBALS;

		$services_groups = healthandcare_get_list_terms(false, 'services_group');
		$services_styles = healthandcare_get_list_templates('services');
		$controls		 = healthandcare_get_list_slider_controls();

		// Services
		vc_map( array(
				"base" => "trx_services",
				"name" => esc_html__("Services", "healthandcare"),
				"description" => esc_html__("Insert services list", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				"icon" => 'icon_trx_services',
				"class" => "trx_sc_columns trx_sc_services",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_services_item'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Services style", "healthandcare"),
						"description" => esc_html__("Select style to display services list", "healthandcare"),
						"class" => "",
						"admin_label" => true,
						"value" => array_flip($services_styles),
						"type" => "dropdown"
					),
					array(
						"param_name" => "type",
						"heading" => esc_html__("Icon's type", "healthandcare"),
						"description" => esc_html__("Select type of icons: font icon or image", "healthandcare"),
						"class" => "",
						"admin_label" => true,
						"value" => array(
                            esc_html__('Icons', 'healthandcare') => 'icons',
                            esc_html__('Images', 'healthandcare') => 'images'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "healthandcare"),
						"description" => esc_html__("How many columns use to show services list", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "slider",
						"heading" => esc_html__("Slider", "healthandcare"),
						"description" => esc_html__("Use slider to show services", "healthandcare"),
						"admin_label" => true,
						"group" => esc_html__('Slider', 'healthandcare'),
						"class" => "",
						"std" => "no",
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
						"description" => esc_html__("Alignment of the services block", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "custom",
						"heading" => esc_html__("Custom", "healthandcare"),
						"description" => esc_html__("Allow get services from inner shortcodes (custom) or get it from specified group (cat)", "healthandcare"),
						"class" => "",
						"value" => array("Custom services" => "yes" ),
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
						"description" => esc_html__("Select category to show services. If empty - select services from any category (group) or from IDs list", "healthandcare"),
						"group" => esc_html__('Query', 'healthandcare'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip(healthandcare_array_merge(array(0 => esc_html__('- Select category -', 'healthandcare')), $services_groups)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "count",
						"heading" => esc_html__("Number of posts", "healthandcare"),
						"description" => esc_html__("How many posts will be displayed? If used IDs - this parameter ignored.", "healthandcare"),
						"admin_label" => true,
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
						"heading" => esc_html__("Team member's IDs list", "healthandcare"),
						"description" => esc_html__("Comma separated list of team members's ID. If set - parameters above (category, count, order, etc.)  are ignored!", "healthandcare"),
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
						"param_name" => "readmore",
						"heading" => esc_html__("Read more", "healthandcare"),
						"description" => esc_html__("Caption for the Read more link (if empty - link not showed)", "healthandcare"),
						"admin_label" => true,
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Button URL", "healthandcare"),
						"description" => esc_html__("Link URL for the button at the bottom of the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link_caption",
						"heading" => esc_html__("Button caption", "healthandcare"),
						"description" => esc_html__("Caption for the button at the bottom of the block", "healthandcare"),
						"group" => esc_html__('Captions', 'healthandcare'),
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
				),
				'default_content' => '
					[trx_services_item title="' . esc_html__( 'Service item 1', 'healthandcare' ) . '"][/trx_services_item]
					[trx_services_item title="' . esc_html__( 'Service item 2', 'healthandcare' ) . '"][/trx_services_item]
					[trx_services_item title="' . esc_html__( 'Service item 3', 'healthandcare' ) . '"][/trx_services_item]
					[trx_services_item title="' . esc_html__( 'Service item 4', 'healthandcare' ) . '"][/trx_services_item]
				',
				'js_view' => 'VcTrxColumnsView'
			) );
			
			
		vc_map( array(
				"base" => "trx_services_item",
				"name" => esc_html__("Services item", "healthandcare"),
				"description" => esc_html__("Custom services item - all data pull out from shortcode parameters", "healthandcare"),
				"show_settings_on_create" => true,
				"class" => "trx_sc_item trx_sc_column_item trx_sc_services_item",
				"content_element" => true,
				"is_container" => false,
				'icon' => 'icon_trx_services_item',
				"as_child" => array('only' => 'trx_services'),
				"as_parent" => array('except' => 'trx_services'),
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => esc_html__("Title", "healthandcare"),
						"description" => esc_html__("Item's title", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "icon",
						"heading" => esc_html__("Icon", "healthandcare"),
						"description" => esc_html__("Select icon for the item from Fontello icons set", "healthandcare"),
						"class" => "",
						"value" => $HEALTHANDCARE_GLOBALS['sc_params']['icons'],
						"type" => "dropdown"
					),
					array(
						"param_name" => "image",
						"heading" => esc_html__("Image", "healthandcare"),
						"description" => esc_html__("Item's image (if icon is empty)", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
                    array(
                        "param_name" => "description",
                        "heading" => esc_html__("Description", "healthandcare"),
                        "description" => esc_html__("Description for the block", "healthandcare"),
                        "class" => "",
                        "value" => "",
                        "type" => "textarea"
                    ),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link", "healthandcare"),
						"description" => esc_html__("Link on item's page", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "readmore",
						"heading" => esc_html__("Read more", "healthandcare"),
						"description" => esc_html__("Caption for the Read more link (if empty - link not showed)", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css']
				)
			) );
			
		class WPBakeryShortCode_Trx_Services extends HEALTHANDCARE_VC_ShortCodeColumns {}
		class WPBakeryShortCode_Trx_Services_Item extends HEALTHANDCARE_VC_ShortCodeItem {}

	}
}
?>