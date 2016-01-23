<?php
/**
 * HealthandCARE Framework: Clients post type settings
 *
 * @package	healthandcare
 * @since	healthandcare 1.0
 */

// Theme init
if (!function_exists('healthandcare_clients_theme_setup')) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_clients_theme_setup' );
	function healthandcare_clients_theme_setup() {

		// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
		add_filter('healthandcare_filter_get_blog_type',			'healthandcare_clients_get_blog_type', 9, 2);
		add_filter('healthandcare_filter_get_blog_title',		'healthandcare_clients_get_blog_title', 9, 2);
		add_filter('healthandcare_filter_get_current_taxonomy',	'healthandcare_clients_get_current_taxonomy', 9, 2);
		add_filter('healthandcare_filter_is_taxonomy',			'healthandcare_clients_is_taxonomy', 9, 2);
		add_filter('healthandcare_filter_get_stream_page_title',	'healthandcare_clients_get_stream_page_title', 9, 2);
		add_filter('healthandcare_filter_get_stream_page_link',	'healthandcare_clients_get_stream_page_link', 9, 2);
		add_filter('healthandcare_filter_get_stream_page_id',	'healthandcare_clients_get_stream_page_id', 9, 2);
		add_filter('healthandcare_filter_query_add_filters',		'healthandcare_clients_query_add_filters', 9, 2);
		add_filter('healthandcare_filter_detect_inheritance_key','healthandcare_clients_detect_inheritance_key', 9, 1);

		// Extra column for clients lists
		if (healthandcare_get_theme_option('show_overriden_posts')=='yes') {
			add_filter('manage_edit-clients_columns',			'healthandcare_post_add_options_column', 9);
			add_filter('manage_clients_posts_custom_column',	'healthandcare_post_fill_options_column', 9, 2);
		}

		// Add shortcodes [trx_clients] and [trx_clients_item]
		add_action('healthandcare_action_shortcodes_list',		'healthandcare_clients_get_shortcodes');
		add_action('healthandcare_action_shortcodes_list_vc',	'healthandcare_clients_get_shortcodes_vc');
		
		if (function_exists('healthandcare_require_data')) {
			// Prepare type "Clients"
			healthandcare_require_data( 'post_type', 'clients', array(
				'label'               => esc_html__( 'Clients', 'healthandcare' ),
				'description'         => esc_html__( 'Clients Description', 'healthandcare' ),
				'labels'              => array(
					'name'                => _x( 'Clients', 'Post Type General Name', 'healthandcare' ),
					'singular_name'       => _x( 'Client', 'Post Type Singular Name', 'healthandcare' ),
					'menu_name'           => esc_html__( 'Clients', 'healthandcare' ),
					'parent_item_colon'   => esc_html__( 'Parent Item:', 'healthandcare' ),
					'all_items'           => esc_html__( 'All Clients', 'healthandcare' ),
					'view_item'           => esc_html__( 'View Item', 'healthandcare' ),
					'add_new_item'        => esc_html__( 'Add New Client', 'healthandcare' ),
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
				'menu_icon'			  => 'dashicons-admin-users',
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
			
			// Prepare taxonomy for clients
			healthandcare_require_data( 'taxonomy', 'clients_group', array(
				'post_type'			=> array( 'clients' ),
				'hierarchical'      => true,
				'labels'            => array(
					'name'              => _x( 'Clients Group', 'taxonomy general name', 'healthandcare' ),
					'singular_name'     => _x( 'Group', 'taxonomy singular name', 'healthandcare' ),
					'search_items'      => esc_html__( 'Search Groups', 'healthandcare' ),
					'all_items'         => esc_html__( 'All Groups', 'healthandcare' ),
					'parent_item'       => esc_html__( 'Parent Group', 'healthandcare' ),
					'parent_item_colon' => esc_html__( 'Parent Group:', 'healthandcare' ),
					'edit_item'         => esc_html__( 'Edit Group', 'healthandcare' ),
					'update_item'       => esc_html__( 'Update Group', 'healthandcare' ),
					'add_new_item'      => esc_html__( 'Add New Group', 'healthandcare' ),
					'new_item_name'     => esc_html__( 'New Group Name', 'healthandcare' ),
					'menu_name'         => esc_html__( 'Clients Group', 'healthandcare' ),
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'clients_group' ),
				)
			);
		}
	}
}

if ( !function_exists( 'healthandcare_clients_settings_theme_setup2' ) ) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_clients_settings_theme_setup2', 3 );
	function healthandcare_clients_settings_theme_setup2() {
		// Add post type 'clients' and taxonomy 'clients_group' into theme inheritance list
		healthandcare_add_theme_inheritance( array('clients' => array(
			'stream_template' => 'blog-clients',
			'single_template' => 'single-client',
			'taxonomy' => array('clients_group'),
			'taxonomy_tags' => array(),
			'post_type' => array('clients'),
			'override' => 'page'
			) )
		);
	}
}


if (!function_exists('healthandcare_clients_after_theme_setup')) {
	add_action( 'healthandcare_action_after_init_theme', 'healthandcare_clients_after_theme_setup' );
	function healthandcare_clients_after_theme_setup() {
		// Update fields in the meta box
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['post_meta_box']) && $HEALTHANDCARE_GLOBALS['post_meta_box']['page']=='clients') {
			// Meta box fields
			$HEALTHANDCARE_GLOBALS['post_meta_box']['title'] = esc_html__('Client Options', 'healthandcare');
			$HEALTHANDCARE_GLOBALS['post_meta_box']['fields'] = array(
				"mb_partition_clients" => array(
					"title" => esc_html__('Clients', 'healthandcare'),
					"override" => "page,post",
					"divider" => false,
					"icon" => "iconadmin-users",
					"type" => "partition"),
				"mb_info_clients_1" => array(
					"title" => esc_html__('Client details', 'healthandcare'),
					"override" => "page,post",
					"divider" => false,
					"desc" => esc_html__('In this section you can put details for this client', 'healthandcare'),
					"class" => "course_meta",
					"type" => "info"),
				"client_name" => array(
					"title" => esc_html__('Contact name',  'healthandcare'),
					"desc" => esc_html__("Name of the contacts manager", 'healthandcare'),
					"override" => "page,post",
					"class" => "client_name",
					"std" => '',
					"type" => "text"),
				"client_position" => array(
					"title" => esc_html__('Position',  'healthandcare'),
					"desc" => esc_html__("Position of the contacts manager", 'healthandcare'),
					"override" => "page,post",
					"class" => "client_position",
					"std" => '',
					"type" => "text"),
				"client_show_link" => array(
					"title" => esc_html__('Show link',  'healthandcare'),
					"desc" => esc_html__("Show link to client page", 'healthandcare'),
					"override" => "page,post",
					"class" => "client_show_link",
					"std" => "no",
					"options" => healthandcare_get_list_yesno(),
					"type" => "switch"),
				"client_link" => array(
					"title" => esc_html__('Link',  'healthandcare'),
					"desc" => esc_html__("URL of the client's site. If empty - use link to this page", 'healthandcare'),
					"override" => "page,post",
					"class" => "client_link",
					"std" => '',
					"type" => "text")
			);
		}
	}
}


// Return true, if current page is clients page
if ( !function_exists( 'healthandcare_is_clients_page' ) ) {
	function healthandcare_is_clients_page() {
		return get_query_var('post_type')=='clients' || is_tax('clients_group') || (is_page() && healthandcare_get_template_page_id('blog-clients')==get_the_ID());
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'healthandcare_clients_detect_inheritance_key' ) ) {
	//add_filter('healthandcare_filter_detect_inheritance_key',	'healthandcare_clients_detect_inheritance_key', 9, 1);
	function healthandcare_clients_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return healthandcare_is_clients_page() ? 'clients' : '';
	}
}

// Filter to detect current page slug
if ( !function_exists( 'healthandcare_clients_get_blog_type' ) ) {
	//add_filter('healthandcare_filter_get_blog_type',	'healthandcare_clients_get_blog_type', 9, 2);
	function healthandcare_clients_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		if ($query && $query->is_tax('clients_group') || is_tax('clients_group'))
			$page = 'clients_category';
		else if ($query && $query->get('post_type')=='clients' || get_query_var('post_type')=='clients')
			$page = $query && $query->is_single() || is_single() ? 'clients_item' : 'clients';
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'healthandcare_clients_get_blog_title' ) ) {
	//add_filter('healthandcare_filter_get_blog_title',	'healthandcare_clients_get_blog_title', 9, 2);
	function healthandcare_clients_get_blog_title($title, $page) {
		if (!empty($title)) return $title;
		if ( healthandcare_strpos($page, 'clients')!==false ) {
			if ( $page == 'clients_category' ) {
				$term = get_term_by( 'slug', get_query_var( 'clients_group' ), 'clients_group', OBJECT);
				$title = $term->name;
			} else if ( $page == 'clients_item' ) {
				$title = healthandcare_get_post_title();
			} else {
				$title = esc_html__('All clients', 'healthandcare');
			}
		}

		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'healthandcare_clients_get_stream_page_title' ) ) {
	//add_filter('healthandcare_filter_get_stream_page_title',	'healthandcare_clients_get_stream_page_title', 9, 2);
	function healthandcare_clients_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (healthandcare_strpos($page, 'clients')!==false) {
			if (($page_id = healthandcare_clients_get_stream_page_id(0, $page=='clients' ? 'blog-clients' : $page)) > 0)
				$title = healthandcare_get_post_title($page_id);
			else
				$title = esc_html__('All clients', 'healthandcare');
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'healthandcare_clients_get_stream_page_id' ) ) {
	//add_filter('healthandcare_filter_get_stream_page_id',	'healthandcare_clients_get_stream_page_id', 9, 2);
	function healthandcare_clients_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (healthandcare_strpos($page, 'clients')!==false) $id = healthandcare_get_template_page_id('blog-clients');
		return $id;
	}
}

// Filter to detect stream page URL
if ( !function_exists( 'healthandcare_clients_get_stream_page_link' ) ) {
	//add_filter('healthandcare_filter_get_stream_page_link',	'healthandcare_clients_get_stream_page_link', 9, 2);
	function healthandcare_clients_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (healthandcare_strpos($page, 'clients')!==false) {
			$id = healthandcare_get_template_page_id('blog-clients');
			if ($id) $url = get_permalink($id);
		}
		return $url;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'healthandcare_clients_get_current_taxonomy' ) ) {
	//add_filter('healthandcare_filter_get_current_taxonomy',	'healthandcare_clients_get_current_taxonomy', 9, 2);
	function healthandcare_clients_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( healthandcare_strpos($page, 'clients')!==false ) {
			$tax = 'clients_group';
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'healthandcare_clients_is_taxonomy' ) ) {
	//add_filter('healthandcare_filter_is_taxonomy',	'healthandcare_clients_is_taxonomy', 9, 2);
	function healthandcare_clients_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else 
			return $query && $query->get('clients_group')!='' || is_tax('clients_group') ? 'clients_group' : '';
	}
}

// Add custom post type and/or taxonomies arguments to the query
if ( !function_exists( 'healthandcare_clients_query_add_filters' ) ) {
	//add_filter('healthandcare_filter_query_add_filters',	'healthandcare_clients_query_add_filters', 9, 2);
	function healthandcare_clients_query_add_filters($args, $filter) {
		if ($filter == 'clients') {
			$args['post_type'] = 'clients';
		}
		return $args;
	}
}





// ---------------------------------- [trx_clients] ---------------------------------------

/*
[trx_clients id="unique_id" columns="3" style="clients-1|clients-2|..."]
	[trx_clients_item name="client name" position="director" image="url"]Description text[/trx_clients_item]
	...
[/trx_clients]
*/
if ( !function_exists( 'healthandcare_sc_clients' ) ) {
	function healthandcare_sc_clients($atts, $content=null){
		if (healthandcare_in_shortcode_blogger()) return '';
		extract(healthandcare_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "clients-1",
			"columns" => 4,
			"slider" => "no",
			"controls" => "no",
			"interval" => "",
			"autoheight" => "no",
			"custom" => "no",
			"ids" => "",
			"cat" => "",
			"count" => 3,
			"offset" => "",
			"orderby" => "date",
			"order" => "desc",
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

		if (empty($id)) $id = "sc_clients_".str_replace('.', '', mt_rand());
		if (empty($width)) $width = "100%";
		if (!empty($height) && healthandcare_param_is_on($autoheight)) $autoheight = "no";
		if (empty($interval)) $interval = mt_rand(5000, 10000);

		$ms = healthandcare_get_css_position_from_values($top, $right, $bottom, $left);
		$ws = healthandcare_get_css_position_from_values('', '', '', '', $width);
		$hs = healthandcare_get_css_position_from_values('', '', '', '', '', $height);
		$css .= ($ms) . ($hs) . ($ws);

		if (healthandcare_param_is_on($slider)) healthandcare_enqueue_slider('swiper');
	
		$columns = max(1, min(12, $columns));
		$count = max(1, (int) $count);
		if (healthandcare_param_is_off($custom) && $count < $columns) $columns = $count;

		global $HEALTHANDCARE_GLOBALS;
		$HEALTHANDCARE_GLOBALS['sc_clients_id'] = $id;
		$HEALTHANDCARE_GLOBALS['sc_clients_style'] = $style;
		$HEALTHANDCARE_GLOBALS['sc_clients_counter'] = 0;
		$HEALTHANDCARE_GLOBALS['sc_clients_columns'] = $columns;
		$HEALTHANDCARE_GLOBALS['sc_clients_slider'] = $slider;
		$HEALTHANDCARE_GLOBALS['sc_clients_css_wh'] = $ws . $hs;

		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_clients sc_clients_style_'.esc_attr($style)
							. ' ' . esc_attr(healthandcare_get_template_property($style, 'container_classes'))
							. ' ' . esc_attr(healthandcare_get_slider_controls_classes($controls))
							. (!empty($class) ? ' '.esc_attr($class) : '')
							. (healthandcare_param_is_on($slider)
								? ' sc_slider_swiper swiper-slider-container'
									. (healthandcare_param_is_on($autoheight) ? ' sc_slider_height_auto' : '')
									. ($hs ? ' sc_slider_height_fixed' : '')
								: '')
						.'"'
						. (!empty($width) && healthandcare_strpos($width, '%')===false ? ' data-old-width="' . esc_attr($width) . '"' : '')
						. (!empty($height) && healthandcare_strpos($height, '%')===false ? ' data-old-height="' . esc_attr($height) . '"' : '')
						. ((int) $interval > 0 ? ' data-interval="'.esc_attr($interval).'"' : '')
						. ($columns > 1 ? ' data-slides-per-view="' . esc_attr($columns) . '"' : '')
						. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
						. (!healthandcare_param_is_off($animation) ? ' data-animation="'.esc_attr(healthandcare_get_animation_classes($animation)).'"' : '')
					. '>'
					. (!empty($subtitle) ? '<h6 class="sc_clients_subtitle sc_item_subtitle">' . trim(healthandcare_strmacros($subtitle)) . '</h6>' : '')
					. (!empty($title) ? '<h2 class="sc_clients_title sc_item_title">' . trim(healthandcare_strmacros($title)) . '</h2>' : '')
					. (!empty($description) ? '<div class="sc_clients_descr sc_item_descr">' . trim(healthandcare_strmacros($description)) . '</div>' : '')
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
				'post_type' => 'clients',
				'post_status' => 'publish',
				'posts_per_page' => $count,
				'ignore_sticky_posts' => true,
				'order' => $order=='asc' ? 'asc' : 'desc',
			);
		
			if ($offset > 0 && empty($ids)) {
				$args['offset'] = $offset;
			}
		
			$args = healthandcare_query_add_sort_order($args, $orderby, $order);
			$args = healthandcare_query_add_posts_and_cats($args, $ids, 'clients', $cat, 'clients_group');

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
				$post_meta = get_post_meta($post_data['post_id'], 'post_custom_options', true);
				$thumb_sizes = healthandcare_get_thumb_sizes(array('layout' => $style));
				$args['client_name'] = $post_meta['client_name'];
				$args['client_position'] = $post_meta['client_position'];
				$args['client_image'] = $post_data['post_thumb'];
				$args['client_link'] = healthandcare_param_is_on('client_show_link')
					? (!empty($post_meta['client_link']) ? $post_meta['client_link'] : $post_data['post_link'])
					: '';
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

		$output .= (!empty($link) ? '<div class="sc_clients_button sc_item_button">'.do_shortcode('[trx_button link="'.esc_url($link).'" icon="icon-right-2"]'.esc_html($link_caption).'[/trx_button]').'</div>' : '')
			. '</div>';
	
		return apply_filters('healthandcare_shortcode_output', $output, 'trx_clients', $atts, $content);
	}
    if (function_exists('healthandcare_require_shortcode')) healthandcare_require_shortcode('trx_clients', 'healthandcare_sc_clients');
}


if ( !function_exists( 'healthandcare_sc_clients_item' ) ) {
	function healthandcare_sc_clients_item($atts, $content=null) {
		if (healthandcare_in_shortcode_blogger()) return '';
		extract(healthandcare_html_decode(shortcode_atts( array(
			// Individual params
			"name" => "",
			"position" => "",
			"image" => "",
			"link" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => ""
		), $atts)));
	
		global $HEALTHANDCARE_GLOBALS;
		$HEALTHANDCARE_GLOBALS['sc_clients_counter']++;
	
		$id = $id ? $id : ($HEALTHANDCARE_GLOBALS['sc_clients_id'] ? $HEALTHANDCARE_GLOBALS['sc_clients_id'] . '_' . $HEALTHANDCARE_GLOBALS['sc_clients_counter'] : '');
	
		$descr = trim(chop(do_shortcode($content)));
	
		$thumb_sizes = healthandcare_get_thumb_sizes(array('layout' => $HEALTHANDCARE_GLOBALS['sc_clients_style']));

		if ($image > 0) {
			$attach = wp_get_attachment_image_src( $image, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$image = $attach[0];
		}
		$image = healthandcare_get_resized_image_tag($image, $thumb_sizes['w'], $thumb_sizes['h']);

		$post_data = array(
			'post_title' => $name,
			'post_excerpt' => $descr
		);
		$args = array(
			'layout' => $HEALTHANDCARE_GLOBALS['sc_clients_style'],
			'number' => $HEALTHANDCARE_GLOBALS['sc_clients_counter'],
			'columns_count' => $HEALTHANDCARE_GLOBALS['sc_clients_columns'],
			'slider' => $HEALTHANDCARE_GLOBALS['sc_clients_slider'],
			'show' => false,
			'descr'  => 0,
			'tag_id' => $id,
			'tag_class' => $class,
			'tag_animation' => $animation,
			'tag_css' => $css,
			'tag_css_wh' => $HEALTHANDCARE_GLOBALS['sc_clients_css_wh'],
			'client_position' => $position,
			'client_link' => $link,
			'client_image' => $image
		);
		$output = healthandcare_show_post_layout($args, $post_data);
		return apply_filters('healthandcare_shortcode_output', $output, 'trx_clients_item', $atts, $content);
	}
    if (function_exists('healthandcare_require_shortcode')) healthandcare_require_shortcode('trx_clients_item', 'healthandcare_sc_clients_item');
}
// ---------------------------------- [/trx_clients] ---------------------------------------



// Add [trx_clients] and [trx_clients_item] in the shortcodes list
if (!function_exists('healthandcare_clients_get_shortcodes')) {
	//add_filter('healthandcare_action_shortcodes_list',	'healthandcare_clients_get_shortcodes');
	function healthandcare_clients_get_shortcodes() {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['shortcodes'])) {

			$users = healthandcare_get_list_users();
			$members = healthandcare_get_list_posts(false, array(
				'post_type'=>'clients',
				'orderby'=>'title',
				'order'=>'asc',
				'return'=>'title'
				)
			);
			$clients_groups = healthandcare_get_list_terms(false, 'clients_group');
			$clients_styles = healthandcare_get_list_templates('clients');
			$controls 		= healthandcare_get_list_slider_controls();

			healthandcare_array_insert_after($HEALTHANDCARE_GLOBALS['shortcodes'], 'trx_chat', array(

				// Clients
				"trx_clients" => array(
					"title" => esc_html__("Clients", "healthandcare"),
					"desc" => esc_html__("Insert clients list in your page (post)", "healthandcare"),
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
							"title" => esc_html__("Clients style", "healthandcare"),
							"desc" => esc_html__("Select style to display clients list", "healthandcare"),
							"value" => "clients-1",
							"type" => "select",
							"options" => $clients_styles
						),
						"columns" => array(
							"title" => esc_html__("Columns", "healthandcare"),
							"desc" => esc_html__("How many columns use to show clients", "healthandcare"),
							"value" => 3,
							"min" => 2,
							"max" => 6,
							"step" => 1,
							"type" => "spinner"
						),
						"slider" => array(
							"title" => esc_html__("Slider", "healthandcare"),
							"desc" => esc_html__("Use slider to show clients", "healthandcare"),
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
						"custom" => array(
							"title" => esc_html__("Custom", "healthandcare"),
							"desc" => esc_html__("Allow get team members from inner shortcodes (custom) or get it from specified group (cat)", "healthandcare"),
							"divider" => true,
							"value" => "no",
							"type" => "switch",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['yes_no']
						),
						"cat" => array(
							"title" => esc_html__("Categories", "healthandcare"),
							"desc" => esc_html__("Select categories (groups) to show team members. If empty - select team members from any category (group) or from IDs list", "healthandcare"),
							"dependency" => array(
								'custom' => array('no')
							),
							"divider" => true,
							"value" => "",
							"type" => "select",
							"style" => "list",
							"multiple" => true,
							"options" => healthandcare_array_merge(array(0 => esc_html__('- Select category -', 'healthandcare')), $clients_groups)
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
						"name" => "trx_clients_item",
						"title" => esc_html__("Client", "healthandcare"),
						"desc" => esc_html__("Single client (custom parameters)", "healthandcare"),
						"container" => true,
						"params" => array(
							"name" => array(
								"title" => esc_html__("Name", "healthandcare"),
								"desc" => esc_html__("Client's name", "healthandcare"),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"position" => array(
								"title" => esc_html__("Position", "healthandcare"),
								"desc" => esc_html__("Client's position", "healthandcare"),
								"value" => "",
								"type" => "text"
							),
							"link" => array(
								"title" => esc_html__("Link", "healthandcare"),
								"desc" => esc_html__("Link on client's personal page", "healthandcare"),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"image" => array(
								"title" => esc_html__("Image", "healthandcare"),
								"desc" => esc_html__("Client's image", "healthandcare"),
								"value" => "",
								"readonly" => false,
								"type" => "media"
							),
							"_content_" => array(
								"title" => esc_html__("Description", "healthandcare"),
								"desc" => esc_html__("Client's short description", "healthandcare"),
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


// Add [trx_clients] and [trx_clients_item] in the VC shortcodes list
if (!function_exists('healthandcare_clients_get_shortcodes_vc')) {
	//add_filter('healthandcare_action_shortcodes_list_vc',	'healthandcare_clients_get_shortcodes_vc');
	function healthandcare_clients_get_shortcodes_vc() {
		global $HEALTHANDCARE_GLOBALS;

		$clients_groups = healthandcare_get_list_terms(false, 'clients_group');
		$clients_styles = healthandcare_get_list_templates('clients');
		$controls		= healthandcare_get_list_slider_controls();

		// Clients
		vc_map( array(
				"base" => "trx_clients",
				"name" => esc_html__("Clients", "healthandcare"),
				"description" => esc_html__("Insert clients list", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_clients',
				"class" => "trx_sc_columns trx_sc_clients",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_clients_item'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Clients style", "healthandcare"),
						"description" => esc_html__("Select style to display clients list", "healthandcare"),
						"class" => "",
						"admin_label" => true,
						"value" => array_flip($clients_styles),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "healthandcare"),
						"description" => esc_html__("How many columns use to show clients", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
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
						"param_name" => "custom",
						"heading" => esc_html__("Custom", "healthandcare"),
						"description" => esc_html__("Allow get clients from inner shortcodes (custom) or get it from specified group (cat)", "healthandcare"),
						"class" => "",
						"value" => array("Custom clients" => "yes" ),
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
						"description" => esc_html__("Select category to show clients. If empty - select clients from any category (group) or from IDs list", "healthandcare"),
						"group" => esc_html__('Query', 'healthandcare'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip(healthandcare_array_merge(array(0 => esc_html__('- Select category -', 'healthandcare')), $clients_groups)),
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
						"heading" => esc_html__("client's IDs list", "healthandcare"),
						"description" => esc_html__("Comma separated list of client's ID. If set - parameters above (category, count, order, etc.)  are ignored!", "healthandcare"),
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
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_top'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_bottom'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_left'],
					$HEALTHANDCARE_GLOBALS['vc_params']['margin_right'],
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css']
				),
				'js_view' => 'VcTrxColumnsView'
			) );
			
			
		vc_map( array(
				"base" => "trx_clients_item",
				"name" => esc_html__("Client", "healthandcare"),
				"description" => esc_html__("Client - all data pull out from it account on your site", "healthandcare"),
				"show_settings_on_create" => true,
				"class" => "trx_sc_item trx_sc_column_item trx_sc_clients_item",
				"content_element" => true,
				"is_container" => false,
				'icon' => 'icon_trx_clients_item',
				"as_child" => array('only' => 'trx_clients'),
				"as_parent" => array('except' => 'trx_clients'),
				"params" => array(
					array(
						"param_name" => "name",
						"heading" => esc_html__("Name", "healthandcare"),
						"description" => esc_html__("Client's name", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "position",
						"heading" => esc_html__("Position", "healthandcare"),
						"description" => esc_html__("Client's position", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link", "healthandcare"),
						"description" => esc_html__("Link on client's personal page", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "image",
						"heading" => esc_html__("Client's image", "healthandcare"),
						"description" => esc_html__("Clients's image", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					$HEALTHANDCARE_GLOBALS['vc_params']['id'],
					$HEALTHANDCARE_GLOBALS['vc_params']['class'],
					$HEALTHANDCARE_GLOBALS['vc_params']['animation'],
					$HEALTHANDCARE_GLOBALS['vc_params']['css']
				)
			) );
			
		class WPBakeryShortCode_Trx_Clients extends HEALTHANDCARE_VC_ShortCodeColumns {}
		class WPBakeryShortCode_Trx_Clients_Item extends HEALTHANDCARE_VC_ShortCodeItem {}

	}
}
?>