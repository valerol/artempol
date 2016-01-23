<?php
/**
 * HealthandCARE Framework: Team post type settings
 *
 * @package	healthandcare
 * @since	healthandcare 1.0
 */

// Theme init
if (!function_exists('healthandcare_team_theme_setup')) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_team_theme_setup' );
	function healthandcare_team_theme_setup() {

		// Add item in the admin menu
		add_action('admin_menu',							'healthandcare_team_add_meta_box');

		// Save data from meta box
		add_action('save_post',								'healthandcare_team_save_data');
		
		// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
		add_filter('healthandcare_filter_get_blog_type',			'healthandcare_team_get_blog_type', 9, 2);
		add_filter('healthandcare_filter_get_blog_title',		'healthandcare_team_get_blog_title', 9, 2);
		add_filter('healthandcare_filter_get_current_taxonomy',	'healthandcare_team_get_current_taxonomy', 9, 2);
		add_filter('healthandcare_filter_is_taxonomy',			'healthandcare_team_is_taxonomy', 9, 2);
		add_filter('healthandcare_filter_get_stream_page_title',	'healthandcare_team_get_stream_page_title', 9, 2);
		add_filter('healthandcare_filter_get_stream_page_link',	'healthandcare_team_get_stream_page_link', 9, 2);
		add_filter('healthandcare_filter_get_stream_page_id',	'healthandcare_team_get_stream_page_id', 9, 2);
		add_filter('healthandcare_filter_query_add_filters',		'healthandcare_team_query_add_filters', 9, 2);
		add_filter('healthandcare_filter_detect_inheritance_key','healthandcare_team_detect_inheritance_key', 9, 1);

		// Extra column for team members lists
		if (healthandcare_get_theme_option('show_overriden_posts')=='yes') {
			add_filter('manage_edit-team_columns',			'healthandcare_post_add_options_column', 9);
			add_filter('manage_team_posts_custom_column',	'healthandcare_post_fill_options_column', 9, 2);
		}

		// Add shortcodes [trx_team] and [trx_team_item]
		add_action('healthandcare_action_shortcodes_list',		'healthandcare_team_get_shortcodes');
		add_action('healthandcare_action_shortcodes_list_vc',	'healthandcare_team_get_shortcodes_vc');

		// Meta box fields
		global $HEALTHANDCARE_GLOBALS;
		$HEALTHANDCARE_GLOBALS['team_meta_box'] = array(
			'id' => 'team-meta-box',
			'title' => esc_html__('Team Member Details', 'healthandcare'),
			'page' => 'team',
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				"team_member_position" => array(
					"title" => esc_html__('Position',  'healthandcare'),
					"desc" => esc_html__("Position of the team member", 'healthandcare'),
					"class" => "team_member_position",
					"std" => "",
					"type" => "text"),
				"team_member_email" => array(
					"title" => esc_html__("E-mail",  'healthandcare'),
					"desc" => esc_html__("E-mail of the team member - need to take Gravatar (if registered)", 'healthandcare'),
					"class" => "team_member_email",
					"std" => "",
					"type" => "text"),
				"team_member_link" => array(
					"title" => esc_html__('Link to profile',  'healthandcare'),
					"desc" => esc_html__("URL of the team member profile page (if not this page)", 'healthandcare'),
					"class" => "team_member_link",
					"std" => "",
					"type" => "text"),
				"team_member_socials" => array(
					"title" => esc_html__("Social links",  'healthandcare'),
					"desc" => esc_html__("Links to the social profiles of the team member", 'healthandcare'),
					"class" => "team_member_email",
					"std" => "",
					"type" => "social")
			)
		);
		
		if (function_exists('healthandcare_require_data')) {
			// Prepare type "Team"
			healthandcare_require_data( 'post_type', 'team', array(
				'label'               => esc_html__( 'Team member', 'healthandcare' ),
				'description'         => esc_html__( 'Team Description', 'healthandcare' ),
				'labels'              => array(
					'name'                => _x( 'Team', 'Post Type General Name', 'healthandcare' ),
					'singular_name'       => _x( 'Team member', 'Post Type Singular Name', 'healthandcare' ),
					'menu_name'           => esc_html__( 'Team', 'healthandcare' ),
					'parent_item_colon'   => esc_html__( 'Parent Item:', 'healthandcare' ),
					'all_items'           => esc_html__( 'All Team', 'healthandcare' ),
					'view_item'           => esc_html__( 'View Item', 'healthandcare' ),
					'add_new_item'        => esc_html__( 'Add New Team member', 'healthandcare' ),
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
			
			// Prepare taxonomy for team
			healthandcare_require_data( 'taxonomy', 'team_group', array(
				'post_type'			=> array( 'team' ),
				'hierarchical'      => true,
				'labels'            => array(
					'name'              => _x( 'Team Group', 'taxonomy general name', 'healthandcare' ),
					'singular_name'     => _x( 'Group', 'taxonomy singular name', 'healthandcare' ),
					'search_items'      => esc_html__( 'Search Groups', 'healthandcare' ),
					'all_items'         => esc_html__( 'All Groups', 'healthandcare' ),
					'parent_item'       => esc_html__( 'Parent Group', 'healthandcare' ),
					'parent_item_colon' => esc_html__( 'Parent Group:', 'healthandcare' ),
					'edit_item'         => esc_html__( 'Edit Group', 'healthandcare' ),
					'update_item'       => esc_html__( 'Update Group', 'healthandcare' ),
					'add_new_item'      => esc_html__( 'Add New Group', 'healthandcare' ),
					'new_item_name'     => esc_html__( 'New Group Name', 'healthandcare' ),
					'menu_name'         => esc_html__( 'Team Group', 'healthandcare' ),
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'team_group' ),
				)
			);
		}
	}
}

if ( !function_exists( 'healthandcare_team_settings_theme_setup2' ) ) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_team_settings_theme_setup2', 3 );
	function healthandcare_team_settings_theme_setup2() {
		// Add post type 'team' and taxonomy 'team_group' into theme inheritance list
		healthandcare_add_theme_inheritance( array('team' => array(
			'stream_template' => 'blog-team',
			'single_template' => 'single-team',
			'taxonomy' => array('team_group'),
			'taxonomy_tags' => array(),
			'post_type' => array('team'),
			'override' => 'page'
			) )
		);
	}
}


// Add meta box
if (!function_exists('healthandcare_team_add_meta_box')) {
	//add_action('admin_menu', 'healthandcare_team_add_meta_box');
	function healthandcare_team_add_meta_box() {
		global $HEALTHANDCARE_GLOBALS;
		$mb = $HEALTHANDCARE_GLOBALS['team_meta_box'];
		add_meta_box($mb['id'], $mb['title'], 'healthandcare_team_show_meta_box', $mb['page'], $mb['context'], $mb['priority']);
	}
}

// Callback function to show fields in meta box
if (!function_exists('healthandcare_team_show_meta_box')) {
	function healthandcare_team_show_meta_box() {
		global $post, $HEALTHANDCARE_GLOBALS;

		// Use nonce for verification
		$data = get_post_meta($post->ID, 'team_data', true);
		$fields = $HEALTHANDCARE_GLOBALS['team_meta_box']['fields'];
		?>
		<input type="hidden" name="meta_box_team_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />
		<table class="team_area">
		<?php
		if (is_array($fields) && count($fields) > 0) {
			foreach ($fields as $id=>$field) { 
				$meta = isset($data[$id]) ? $data[$id] : '';
				?>
				<tr class="team_field <?php echo esc_attr($field['class']); ?>" valign="top">
					<td><label for="<?php echo esc_attr($id); ?>"><?php echo esc_attr($field['title']); ?></label></td>
					<td>
						<?php
						if ($id == 'team_member_socials') {
							$socials_type = healthandcare_get_theme_setting('socials_type');
							$social_list = healthandcare_get_theme_option('social_icons');
							if (is_array($social_list) && count($social_list) > 0) {
								foreach ($social_list as $soc) {
									if ($socials_type == 'icons') {
										$parts = explode('-', $soc['icon'], 2);
										$sn = isset($parts[1]) ? $parts[1] : $sn;
									} else {
										$sn = basename($soc['icon']);
										$sn = healthandcare_substr($sn, 0, healthandcare_strrpos($sn, '.'));
										if (($pos=healthandcare_strrpos($sn, '_'))!==false)
											$sn = healthandcare_substr($sn, 0, $pos);
									}   
									$link = isset($meta[$sn]) ? $meta[$sn] : '';
									?>
									<label for="<?php echo esc_attr(($id).'_'.($sn)); ?>"><?php echo esc_attr(healthandcare_strtoproper($sn)); ?></label><br>
									<input type="text" name="<?php echo esc_attr($id); ?>[<?php echo esc_attr($sn); ?>]" id="<?php echo esc_attr(($id).'_'.($sn)); ?>" value="<?php echo esc_attr($link); ?>" size="30" /><br>
									<?php
								}
							}
						} else {
							?>
							<input type="text" name="<?php echo esc_attr($id); ?>" id="<?php echo esc_attr($id); ?>" value="<?php echo esc_attr($meta); ?>" size="30" />
							<?php
						}
						?>
						<br><small><?php echo esc_attr($field['desc']); ?></small>
					</td>
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
if (!function_exists('healthandcare_team_save_data')) {
	//add_action('save_post', 'healthandcare_team_save_data');
	function healthandcare_team_save_data($post_id) {
		// verify nonce
		if (!isset($_POST['meta_box_team_nonce']) || !wp_verify_nonce($_POST['meta_box_team_nonce'], basename(__FILE__))) {
			return $post_id;
		}

		// check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		// check permissions
		if ($_POST['post_type']!='team' || !current_user_can('edit_post', $post_id)) {
			return $post_id;
		}

		global $HEALTHANDCARE_GLOBALS;

		$data = array();

		$fields = $HEALTHANDCARE_GLOBALS['team_meta_box']['fields'];

		// Post type specific data handling
		if (is_array($fields) && count($fields) > 0) {
			foreach ($fields as $id=>$field) {
				if (isset($_POST[$id])) {
					if (is_array($_POST[$id]) && count($_POST[$id]) > 0) {
						foreach ($_POST[$id] as $sn=>$link) {
							$_POST[$id][$sn] = stripslashes($link);
						}
						$data[$id] = $_POST[$id];
					} else {
						$data[$id] = stripslashes($_POST[$id]);
					}
				}
			}
		}

		update_post_meta($post_id, 'team_data', $data);
	}
}



// Return true, if current page is team member page
if ( !function_exists( 'healthandcare_is_team_page' ) ) {
	function healthandcare_is_team_page() {
		return get_query_var('post_type')=='team' || is_tax('team_group') || (is_page() && healthandcare_get_template_page_id('blog-team')==get_the_ID());
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'healthandcare_team_detect_inheritance_key' ) ) {
	//add_filter('healthandcare_filter_detect_inheritance_key',	'healthandcare_team_detect_inheritance_key', 9, 1);
	function healthandcare_team_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return healthandcare_is_team_page() ? 'team' : '';
	}
}

// Filter to detect current page slug
if ( !function_exists( 'healthandcare_team_get_blog_type' ) ) {
	//add_filter('healthandcare_filter_get_blog_type',	'healthandcare_team_get_blog_type', 9, 2);
	function healthandcare_team_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		if ($query && $query->is_tax('team_group') || is_tax('team_group'))
			$page = 'team_category';
		else if ($query && $query->get('post_type')=='team' || get_query_var('post_type')=='team')
			$page = $query && $query->is_single() || is_single() ? 'team_item' : 'team';
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'healthandcare_team_get_blog_title' ) ) {
	//add_filter('healthandcare_filter_get_blog_title',	'healthandcare_team_get_blog_title', 9, 2);
	function healthandcare_team_get_blog_title($title, $page) {
		if (!empty($title)) return $title;
		if ( healthandcare_strpos($page, 'team')!==false ) {
			if ( $page == 'team_category' ) {
				$term = get_term_by( 'slug', get_query_var( 'team_group' ), 'team_group', OBJECT);
				$title = $term->name;
			} else if ( $page == 'team_item' ) {
				$title = healthandcare_get_post_title();
			} else {
				$title = esc_html__('All team', 'healthandcare');
			}
		}

		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'healthandcare_team_get_stream_page_title' ) ) {
	//add_filter('healthandcare_filter_get_stream_page_title',	'healthandcare_team_get_stream_page_title', 9, 2);
	function healthandcare_team_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (healthandcare_strpos($page, 'team')!==false) {
			if (($page_id = healthandcare_team_get_stream_page_id(0, $page=='team' ? 'blog-team' : $page)) > 0)
				$title = healthandcare_get_post_title($page_id);
			else
				$title = esc_html__('All team', 'healthandcare');
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'healthandcare_team_get_stream_page_id' ) ) {
	//add_filter('healthandcare_filter_get_stream_page_id',	'healthandcare_team_get_stream_page_id', 9, 2);
	function healthandcare_team_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (healthandcare_strpos($page, 'team')!==false) $id = healthandcare_get_template_page_id('blog-team');
		return $id;
	}
}

// Filter to detect stream page URL
if ( !function_exists( 'healthandcare_team_get_stream_page_link' ) ) {
	//add_filter('healthandcare_filter_get_stream_page_link',	'healthandcare_team_get_stream_page_link', 9, 2);
	function healthandcare_team_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (healthandcare_strpos($page, 'team')!==false) {
			$id = healthandcare_get_template_page_id('blog-team');
			if ($id) $url = get_permalink($id);
		}
		return $url;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'healthandcare_team_get_current_taxonomy' ) ) {
	//add_filter('healthandcare_filter_get_current_taxonomy',	'healthandcare_team_get_current_taxonomy', 9, 2);
	function healthandcare_team_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( healthandcare_strpos($page, 'team')!==false ) {
			$tax = 'team_group';
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'healthandcare_team_is_taxonomy' ) ) {
	//add_filter('healthandcare_filter_is_taxonomy',	'healthandcare_team_is_taxonomy', 9, 2);
	function healthandcare_team_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else 
			return $query && $query->get('team_group')!='' || is_tax('team_group') ? 'team_group' : '';
	}
}

// Add custom post type and/or taxonomies arguments to the query
if ( !function_exists( 'healthandcare_team_query_add_filters' ) ) {
	//add_filter('healthandcare_filter_query_add_filters',	'healthandcare_team_query_add_filters', 9, 2);
	function healthandcare_team_query_add_filters($args, $filter) {
		if ($filter == 'team') {
			$args['post_type'] = 'team';
		}
		return $args;
	}
}





// ---------------------------------- [trx_team] ---------------------------------------

/*
[trx_team id="unique_id" columns="3" style="team-1|team-2|..."]
	[trx_team_item user="user_login"]
	[trx_team_item member="member_id"]
	[trx_team_item name="team member name" photo="url" email="address" position="director"]
[/trx_team]
*/
if ( !function_exists( 'healthandcare_sc_team' ) ) {
	function healthandcare_sc_team($atts, $content=null){
		if (healthandcare_in_shortcode_blogger()) return '';
		extract(healthandcare_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "team-1",
			"columns" => 3,
			"slider" => "no",
			"controls" => "no",
			"interval" => "",
			"autoheight" => "no",
			"align" => "",
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

		if (empty($id)) $id = "sc_team_".str_replace('.', '', mt_rand());
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
		$HEALTHANDCARE_GLOBALS['sc_team_id'] = $id;
		$HEALTHANDCARE_GLOBALS['sc_team_style'] = $style;
		$HEALTHANDCARE_GLOBALS['sc_team_columns'] = $columns;
		$HEALTHANDCARE_GLOBALS['sc_team_counter'] = 0;
		$HEALTHANDCARE_GLOBALS['sc_team_slider'] = $slider;
		$HEALTHANDCARE_GLOBALS['sc_team_css_wh'] = $ws . $hs;

		if (healthandcare_param_is_on($slider)) healthandcare_enqueue_slider('swiper');
	
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
						. ' class="sc_team sc_team_style_'.esc_attr($style)
							. ' ' . esc_attr(healthandcare_get_template_property($style, 'container_classes'))
							. ' ' . esc_attr(healthandcare_get_slider_controls_classes($controls))
							. (healthandcare_param_is_on($slider)
								? ' sc_slider_swiper swiper-slider-container'
									. (healthandcare_param_is_on($autoheight) ? ' sc_slider_height_auto' : '')
									. ($hs ? ' sc_slider_height_fixed' : '')
								: '')
							. (!empty($class) ? ' '.esc_attr($class) : '')
							. ($align!='' && $align!='none' ? ' align'.esc_attr($align) : '')
						.'"'
						. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
						. (!empty($width) && healthandcare_strpos($width, '%')===false ? ' data-old-width="' . esc_attr($width) . '"' : '')
						. (!empty($height) && healthandcare_strpos($height, '%')===false ? ' data-old-height="' . esc_attr($height) . '"' : '')
						. ((int) $interval > 0 ? ' data-interval="'.esc_attr($interval).'"' : '')
						. ($columns > 1 ? ' data-slides-per-view="' . esc_attr($columns) . '"' : '')
						. (!healthandcare_param_is_off($animation) ? ' data-animation="'.esc_attr(healthandcare_get_animation_classes($animation)).'"' : '')
					. '>'
					. (!empty($subtitle) ? '<h6 class="sc_team_subtitle sc_item_subtitle">' . trim(healthandcare_strmacros($subtitle)) . '</h6>' : '')
					. (!empty($title) ? '<h1 class="sc_team_title sc_item_title">' . trim(healthandcare_strmacros($title)) . '</h1>' : '')
					. (!empty($description) ? '<h6 class="sc_title sc_title_regular sc_align_center" style="text-align:center;">' . trim(healthandcare_strmacros($description)) . '</h6>' : '')
					. (healthandcare_param_is_on($slider)
						? '<div class="slides swiper-wrapper">' 
						: ($columns > 1 // && healthandcare_get_template_property($style, 'need_columns')
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
				'post_type' => 'team',
				'post_status' => 'publish',
				'posts_per_page' => $count,
				'ignore_sticky_posts' => true,
				'order' => $order=='asc' ? 'asc' : 'desc',
			);
		
			if ($offset > 0 && empty($ids)) {
				$args['offset'] = $offset;
			}
		
			$args = healthandcare_query_add_sort_order($args, $orderby, $order);
			$args = healthandcare_query_add_posts_and_cats($args, $ids, 'team', $cat, 'team_group');
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
					"columns_count" => $columns,
					'slider' => $slider,
					'tag_id' => $id ? $id . '_' . $post_number : '',
					'tag_class' => '',
					'tag_animation' => '',
					'tag_css' => '',
					'tag_css_wh' => $ws . $hs
				);
				$post_data = healthandcare_get_post_data($args);
				$post_meta = get_post_meta($post_data['post_id'], 'team_data', true);
				$thumb_sizes = healthandcare_get_thumb_sizes(array('layout' => $style));
				$args['position'] = $post_meta['team_member_position'];
				$args['link'] = !empty($post_meta['team_member_link']) ? $post_meta['team_member_link'] : $post_data['post_link'];
				$args['email'] = $post_meta['team_member_email'];
				$args['photo'] = $post_data['post_thumb'];
				if (empty($args['photo']) && !empty($args['email'])) $args['photo'] = get_avatar($args['email'], $thumb_sizes['w']*min(2, max(1, healthandcare_get_theme_option("retina_ready"))));
				$args['socials'] = '';
				$soc_list = $post_meta['team_member_socials'];
				if (is_array($soc_list) && count($soc_list)>0) {
					$soc_str = '';
					foreach ($soc_list as $sn=>$sl) {
						if (!empty($sl))
							$soc_str .= (!empty($soc_str) ? '|' : '') . ($sn) . '=' . ($sl);
					}
					if (!empty($soc_str))
						$args['socials'] = do_shortcode('[trx_socials size="tiny" shape="round" socials="'.esc_attr($soc_str).'"][/trx_socials]');
				}
	
				$output .= healthandcare_show_post_layout($args, $post_data);
			}
			wp_reset_postdata();
		}

		if (healthandcare_param_is_on($slider)) {
			$output .= '</div>'
				. '<div class="sc_slider_controls_wrap"><a class="sc_slider_prev" href="#"></a><a class="sc_slider_next" href="#"></a></div>'
				. '<div class="sc_slider_pagination_wrap"></div>';
		} else if ($columns > 1) {// && healthandcare_get_template_property($style, 'need_columns')) {
			$output .= '</div>';
		}

		$output .= (!empty($link) ? '<div class="sc_team_button sc_item_button">'.do_shortcode('[trx_button type="square" style="filled" size="large" bg_style="menu" align="none" popup="" animation="none" link="'.esc_url($link).'" icon="icon-right-2"]'.esc_html($link_caption).'[/trx_button]').'</div>' : '')
					. '</div>';
	
		return apply_filters('healthandcare_shortcode_output', $output, 'trx_team', $atts, $content);
	}
    if (function_exists('healthandcare_require_shortcode')) healthandcare_require_shortcode('trx_team', 'healthandcare_sc_team');
}


if ( !function_exists( 'healthandcare_sc_team_item' ) ) {
	function healthandcare_sc_team_item($atts, $content=null) {
		if (healthandcare_in_shortcode_blogger()) return '';
		extract(healthandcare_html_decode(shortcode_atts( array(
			// Individual params
			"user" => "",
			"member" => "",
			"name" => "",
			"position" => "",
			"photo" => "",
			"email" => "",
			"link" => "",
			"socials" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => ""
		), $atts)));
	
		global $HEALTHANDCARE_GLOBALS;
		$HEALTHANDCARE_GLOBALS['sc_team_counter']++;
	
		$id = $id ? $id : ($HEALTHANDCARE_GLOBALS['sc_team_id'] ? $HEALTHANDCARE_GLOBALS['sc_team_id'] . '_' . $HEALTHANDCARE_GLOBALS['sc_team_counter'] : '');
	
		$descr = trim(chop(do_shortcode($content)));
	
		$thumb_sizes = healthandcare_get_thumb_sizes(array('layout' => $HEALTHANDCARE_GLOBALS['sc_team_style']));
	
		if (!empty($socials)) $socials = do_shortcode('[trx_socials size="tiny" shape="round" socials="'.esc_attr($socials).'"][/trx_socials]');
	
		if (!empty($user) && $user!='none' && ($user_obj = get_user_by('login', $user)) != false) {
			$meta = get_user_meta($user_obj->ID);
			if (empty($email))		$email = $user_obj->data->user_email;
			if (empty($name))		$name = $user_obj->data->display_name;
			if (empty($position))	$position = isset($meta['user_position'][0]) ? $meta['user_position'][0] : '';
			if (empty($descr))		$descr = isset($meta['description'][0]) ? $meta['description'][0] : '';
			if (empty($socials))	$socials = healthandcare_show_user_socials(array('author_id'=>$user_obj->ID, 'echo'=>false));
		}
	
		if (!empty($member) && $member!='none' && ($member_obj = (intval($member) > 0 ? get_post($member, OBJECT) : get_page_by_title($member, OBJECT, 'team'))) != null) {
			if (empty($name))		$name = $member_obj->post_title;
			if (empty($descr))		$descr = $member_obj->post_excerpt;
			$post_meta = get_post_meta($member_obj->ID, 'team_data', true);
			if (empty($position))	$position = $post_meta['team_member_position'];
			if (empty($link))		$link = !empty($post_meta['team_member_link']) ? $post_meta['team_member_link'] : get_permalink($member_obj->ID);
			if (empty($email))		$email = $post_meta['team_member_email'];
			if (empty($photo)) 		$photo = wp_get_attachment_url(get_post_thumbnail_id($member_obj->ID));
			if (empty($socials)) {
				$socials = '';
				$soc_list = $post_meta['team_member_socials'];
				if (is_array($soc_list) && count($soc_list)>0) {
					$soc_str = '';
					foreach ($soc_list as $sn=>$sl) {
						if (!empty($sl))
							$soc_str .= (!empty($soc_str) ? '|' : '') . ($sn) . '=' . ($sl);
					}
					if (!empty($soc_str))
						$socials = do_shortcode('[trx_socials size="tiny" shape="round" socials="'.esc_attr($soc_str).'"][/trx_socials]');
				}
			}
		}
		if (empty($photo)) {
			if (!empty($email)) $photo = get_avatar($email, $thumb_sizes['w']*min(2, max(1, healthandcare_get_theme_option("retina_ready"))));
		} else {
			if ($photo > 0) {
				$attach = wp_get_attachment_image_src( $photo, 'full' );
				if (isset($attach[0]) && $attach[0]!='')
					$photo = $attach[0];
			}
			$photo = healthandcare_get_resized_image_tag($photo, $thumb_sizes['w'], $thumb_sizes['h']);
		}
		$post_data = array(
			'post_title' => $name,
			'post_excerpt' => $descr
		);
		$args = array(
			'layout' => $HEALTHANDCARE_GLOBALS['sc_team_style'],
			'number' => $HEALTHANDCARE_GLOBALS['sc_team_counter'],
			'columns_count' => $HEALTHANDCARE_GLOBALS['sc_team_columns'],
			'slider' => $HEALTHANDCARE_GLOBALS['sc_team_slider'],
			'show' => false,
			'descr'  => 0,
			'tag_id' => $id,
			'tag_class' => $class,
			'tag_animation' => $animation,
			'tag_css' => $css,
			'tag_css_wh' => $HEALTHANDCARE_GLOBALS['sc_team_css_wh'],
			'position' => $position,
			'link' => $link,
			'email' => $email,
			'photo' => $photo,
			'socials' => $socials
		);
		$output = healthandcare_show_post_layout($args, $post_data);

		return apply_filters('healthandcare_shortcode_output', $output, 'trx_team_item', $atts, $content);
	}
    if (function_exists('healthandcare_require_shortcode')) healthandcare_require_shortcode('trx_team_item', 'healthandcare_sc_team_item');
}
// ---------------------------------- [/trx_team] ---------------------------------------



// Add [trx_team] and [trx_team_item] in the shortcodes list
if (!function_exists('healthandcare_team_get_shortcodes')) {
	//add_filter('healthandcare_action_shortcodes_list',	'healthandcare_team_get_shortcodes');
	function healthandcare_team_get_shortcodes() {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['shortcodes'])) {

			$users = healthandcare_get_list_users();
			$members = healthandcare_get_list_posts(false, array(
				'post_type'=>'team',
				'orderby'=>'title',
				'order'=>'asc',
				'return'=>'title'
				)
			);
			$team_groups = healthandcare_get_list_terms(false, 'team_group');
			$team_styles = healthandcare_get_list_templates('team');
			$controls	 = healthandcare_get_list_slider_controls();

			healthandcare_array_insert_after($HEALTHANDCARE_GLOBALS['shortcodes'], 'trx_tabs', array(

				// Team
				"trx_team" => array(
					"title" => esc_html__("Team", "healthandcare"),
					"desc" => esc_html__("Insert team in your page (post)", "healthandcare"),
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
							"title" => esc_html__("Team style", "healthandcare"),
							"desc" => esc_html__("Select style to display team members", "healthandcare"),
							"value" => "1",
							"type" => "select",
							"options" => $team_styles
						),
						"columns" => array(
							"title" => esc_html__("Columns", "healthandcare"),
							"desc" => esc_html__("How many columns use to show team members", "healthandcare"),
							"value" => 3,
							"min" => 2,
							"max" => 5,
							"step" => 1,
							"type" => "spinner"
						),
						"slider" => array(
							"title" => esc_html__("Slider", "healthandcare"),
							"desc" => esc_html__("Use slider to show team members", "healthandcare"),
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
							"desc" => esc_html__("Alignment of the team block", "healthandcare"),
							"divider" => true,
							"value" => "",
							"type" => "checklist",
							"dir" => "horizontal",
							"options" => $HEALTHANDCARE_GLOBALS['sc_params']['align']
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
							"options" => healthandcare_array_merge(array(0 => esc_html__('- Select category -', 'healthandcare')), $team_groups)
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
						"name" => "trx_team_item",
						"title" => esc_html__("Member", "healthandcare"),
						"desc" => esc_html__("Team member", "healthandcare"),
						"container" => true,
						"params" => array(
							"user" => array(
								"title" => esc_html__("Registerd user", "healthandcare"),
								"desc" => esc_html__("Select one of registered users (if present) or put name, position, etc. in fields below", "healthandcare"),
								"value" => "",
								"type" => "select",
								"options" => $users
							),
							"member" => array(
								"title" => esc_html__("Team member", "healthandcare"),
								"desc" => esc_html__("Select one of team members (if present) or put name, position, etc. in fields below", "healthandcare"),
								"value" => "",
								"type" => "select",
								"options" => $members
							),
							"link" => array(
								"title" => esc_html__("Link", "healthandcare"),
								"desc" => esc_html__("Link on team member's personal page", "healthandcare"),
								"divider" => true,
								"value" => "",
								"type" => "text"
							),
							"name" => array(
								"title" => esc_html__("Name", "healthandcare"),
								"desc" => esc_html__("Team member's name", "healthandcare"),
								"divider" => true,
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"position" => array(
								"title" => esc_html__("Position", "healthandcare"),
								"desc" => esc_html__("Team member's position", "healthandcare"),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"email" => array(
								"title" => esc_html__("E-mail", "healthandcare"),
								"desc" => esc_html__("Team member's e-mail", "healthandcare"),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"photo" => array(
								"title" => esc_html__("Photo", "healthandcare"),
								"desc" => esc_html__("Team member's photo (avatar)", "healthandcare"),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"readonly" => false,
								"type" => "media"
							),
							"socials" => array(
								"title" => esc_html__("Socials", "healthandcare"),
								"desc" => esc_html__("Team member's socials icons: name=url|name=url... For example: facebook=http://facebook.com/myaccount|twitter=http://twitter.com/myaccount", "healthandcare"),
								"dependency" => array(
									'user' => array('is_empty', 'none'),
									'member' => array('is_empty', 'none')
								),
								"value" => "",
								"type" => "text"
							),
							"_content_" => array(
								"title" => esc_html__("Description", "healthandcare"),
								"desc" => esc_html__("Team member's short description", "healthandcare"),
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


// Add [trx_team] and [trx_team_item] in the VC shortcodes list
if (!function_exists('healthandcare_team_get_shortcodes_vc')) {
	//add_filter('healthandcare_action_shortcodes_list_vc',	'healthandcare_team_get_shortcodes_vc');
	function healthandcare_team_get_shortcodes_vc() {
		global $HEALTHANDCARE_GLOBALS;

		$users = healthandcare_get_list_users();
		$members = healthandcare_get_list_posts(false, array(
			'post_type'=>'team',
			'orderby'=>'title',
			'order'=>'asc',
			'return'=>'title'
			)
		);
		$team_groups = healthandcare_get_list_terms(false, 'team_group');
		$team_styles = healthandcare_get_list_templates('team');
		$controls	 = healthandcare_get_list_slider_controls();

		// Team
		vc_map( array(
				"base" => "trx_team",
				"name" => esc_html__("Team", "healthandcare"),
				"description" => esc_html__("Insert team members", "healthandcare"),
				"category" => esc_html__('Content', 'js_composer'),
				'icon' => 'icon_trx_team',
				"class" => "trx_sc_columns trx_sc_team",
				"content_element" => true,
				"is_container" => true,
				"show_settings_on_create" => true,
				"as_parent" => array('only' => 'trx_team_item'),
				"params" => array(
					array(
						"param_name" => "style",
						"heading" => esc_html__("Team style", "healthandcare"),
						"description" => esc_html__("Select style to display team members", "healthandcare"),
						"class" => "",
						"admin_label" => true,
						"value" => array_flip($team_styles),
						"type" => "dropdown"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", "healthandcare"),
						"description" => esc_html__("How many columns use to show team members", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "3",
						"type" => "textfield"
					),
					array(
						"param_name" => "slider",
						"heading" => esc_html__("Slider", "healthandcare"),
						"description" => esc_html__("Use slider to show team members", "healthandcare"),
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
						"description" => esc_html__("Alignment of the team block", "healthandcare"),
						"class" => "",
						"value" => array_flip($HEALTHANDCARE_GLOBALS['sc_params']['align']),
						"type" => "dropdown"
					),
					array(
						"param_name" => "custom",
						"heading" => esc_html__("Custom", "healthandcare"),
						"description" => esc_html__("Allow get team members from inner shortcodes (custom) or get it from specified group (cat)", "healthandcare"),
						"class" => "",
						"value" => array("Custom members" => "yes" ),
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
						"description" => esc_html__("Select category to show team members. If empty - select team members from any category (group) or from IDs list", "healthandcare"),
						"group" => esc_html__('Query', 'healthandcare'),
						'dependency' => array(
							'element' => 'custom',
							'is_empty' => true
						),
						"class" => "",
						"value" => array_flip(healthandcare_array_merge(array(0 => esc_html__('- Select category -', 'healthandcare')), $team_groups)),
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
					[trx_team_item user="' . esc_html__( 'Member 1', 'healthandcare' ) . '"][/trx_team_item]
					[trx_team_item user="' . esc_html__( 'Member 2', 'healthandcare' ) . '"][/trx_team_item]
					[trx_team_item user="' . esc_html__( 'Member 4', 'healthandcare' ) . '"][/trx_team_item]
				',
				'js_view' => 'VcTrxColumnsView'
			) );
			
			
		vc_map( array(
				"base" => "trx_team_item",
				"name" => esc_html__("Team member", "healthandcare"),
				"description" => esc_html__("Team member - all data pull out from it account on your site", "healthandcare"),
				"show_settings_on_create" => true,
				"class" => "trx_sc_item trx_sc_column_item trx_sc_team_item",
				"content_element" => true,
				"is_container" => false,
				'icon' => 'icon_trx_team_item',
				"as_child" => array('only' => 'trx_team'),
				"as_parent" => array('except' => 'trx_team'),
				"params" => array(
					array(
						"param_name" => "user",
						"heading" => esc_html__("Registered user", "healthandcare"),
						"description" => esc_html__("Select one of registered users (if present) or put name, position, etc. in fields below", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($users),
						"type" => "dropdown"
					),
					array(
						"param_name" => "member",
						"heading" => esc_html__("Team member", "healthandcare"),
						"description" => esc_html__("Select one of team members (if present) or put name, position, etc. in fields below", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip($members),
						"type" => "dropdown"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Link", "healthandcare"),
						"description" => esc_html__("Link on team member's personal page", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "name",
						"heading" => esc_html__("Name", "healthandcare"),
						"description" => esc_html__("Team member's name", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "position",
						"heading" => esc_html__("Position", "healthandcare"),
						"description" => esc_html__("Team member's position", "healthandcare"),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "email",
						"heading" => esc_html__("E-mail", "healthandcare"),
						"description" => esc_html__("Team member's e-mail", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "photo",
						"heading" => esc_html__("Member's Photo", "healthandcare"),
						"description" => esc_html__("Team member's photo (avatar)", "healthandcare"),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "socials",
						"heading" => esc_html__("Socials", "healthandcare"),
						"description" => esc_html__("Team member's socials icons: name=url|name=url... For example: facebook=http://facebook.com/myaccount|twitter=http://twitter.com/myaccount", "healthandcare"),
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
			
		class WPBakeryShortCode_Trx_Team extends HEALTHANDCARE_VC_ShortCodeColumns {}
		class WPBakeryShortCode_Trx_Team_Item extends HEALTHANDCARE_VC_ShortCodeItem {}

	}
}
?>