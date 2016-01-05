<?php
/**
 * HealthandCARE Framework: return lists
 *
 * @package healthandcare
 * @since healthandcare 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



// Return styles list
if ( !function_exists( 'healthandcare_get_list_styles' ) ) {
	function healthandcare_get_list_styles($from=1, $to=2, $prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_styles']))
			$list = $HEALTHANDCARE_GLOBALS['list_styles'];
		else {
			$list = array();
			for ($i=$from; $i<=$to; $i++)
				$list[$i] = sprintf(__('Style %d', 'healthandcare'), $i);
			$HEALTHANDCARE_GLOBALS['list_styles'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}


// Return list of the animations
if ( !function_exists( 'healthandcare_get_list_animations' ) ) {
	function healthandcare_get_list_animations($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_animations']))
			$list = $HEALTHANDCARE_GLOBALS['list_animations'];
		else {
			$list = array();
			$list['none']			= esc_html__('- None -',	'healthandcare');
			$list['bounced']		= esc_html__('Bounced',		'healthandcare');
			$list['flash']			= esc_html__('Flash',		'healthandcare');
			$list['flip']			= esc_html__('Flip',		'healthandcare');
			$list['pulse']			= esc_html__('Pulse',		'healthandcare');
			$list['rubberBand']		= esc_html__('Rubber Band',	'healthandcare');
			$list['shake']			= esc_html__('Shake',		'healthandcare');
			$list['swing']			= esc_html__('Swing',		'healthandcare');
			$list['tada']			= esc_html__('Tada',		'healthandcare');
			$list['wobble']			= esc_html__('Wobble',		'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_animations'] = $list = apply_filters('healthandcare_filter_list_animations', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}


// Return list of the enter animations
if ( !function_exists( 'healthandcare_get_list_animations_in' ) ) {
	function healthandcare_get_list_animations_in($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_animations_in']))
			$list = $HEALTHANDCARE_GLOBALS['list_animations_in'];
		else {
			$list = array();
			$list['none']			= esc_html__('- None -',	'healthandcare');
			$list['bounceIn']		= esc_html__('Bounce In',			'healthandcare');
			$list['bounceInUp']		= esc_html__('Bounce In Up',		'healthandcare');
			$list['bounceInDown']	= esc_html__('Bounce In Down',		'healthandcare');
			$list['bounceInLeft']	= esc_html__('Bounce In Left',		'healthandcare');
			$list['bounceInRight']	= esc_html__('Bounce In Right',		'healthandcare');
			$list['fadeIn']			= esc_html__('Fade In',				'healthandcare');
			$list['fadeInUp']		= esc_html__('Fade In Up',			'healthandcare');
			$list['fadeInDown']		= esc_html__('Fade In Down',		'healthandcare');
			$list['fadeInLeft']		= esc_html__('Fade In Left',		'healthandcare');
			$list['fadeInRight']	= esc_html__('Fade In Right',		'healthandcare');
			$list['fadeInUpBig']	= esc_html__('Fade In Up Big',		'healthandcare');
			$list['fadeInDownBig']	= esc_html__('Fade In Down Big',	'healthandcare');
			$list['fadeInLeftBig']	= esc_html__('Fade In Left Big',	'healthandcare');
			$list['fadeInRightBig']	= esc_html__('Fade In Right Big',	'healthandcare');
			$list['flipInX']		= esc_html__('Flip In X',			'healthandcare');
			$list['flipInY']		= esc_html__('Flip In Y',			'healthandcare');
			$list['lightSpeedIn']	= esc_html__('Light Speed In',		'healthandcare');
			$list['rotateIn']		= esc_html__('Rotate In',			'healthandcare');
			$list['rotateInUpLeft']		= esc_html__('Rotate In Down Left',	'healthandcare');
			$list['rotateInUpRight']	= esc_html__('Rotate In Up Right',	'healthandcare');
			$list['rotateInDownLeft']	= esc_html__('Rotate In Up Left',	'healthandcare');
			$list['rotateInDownRight']	= esc_html__('Rotate In Down Right','healthandcare');
			$list['rollIn']				= esc_html__('Roll In',			'healthandcare');
			$list['slideInUp']			= esc_html__('Slide In Up',		'healthandcare');
			$list['slideInDown']		= esc_html__('Slide In Down',	'healthandcare');
			$list['slideInLeft']		= esc_html__('Slide In Left',	'healthandcare');
			$list['slideInRight']		= esc_html__('Slide In Right',	'healthandcare');
			$list['zoomIn']				= esc_html__('Zoom In',			'healthandcare');
			$list['zoomInUp']			= esc_html__('Zoom In Up',		'healthandcare');
			$list['zoomInDown']			= esc_html__('Zoom In Down',	'healthandcare');
			$list['zoomInLeft']			= esc_html__('Zoom In Left',	'healthandcare');
			$list['zoomInRight']		= esc_html__('Zoom In Right',	'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_animations_in'] = $list = apply_filters('healthandcare_filter_list_animations_in', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}


// Return list of the out animations
if ( !function_exists( 'healthandcare_get_list_animations_out' ) ) {
	function healthandcare_get_list_animations_out($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_animations_out']))
			$list = $HEALTHANDCARE_GLOBALS['list_animations_out'];
		else {
			$list = array();
			$list['none']			= esc_html__('- None -',	'healthandcare');
			$list['bounceOut']		= esc_html__('Bounce Out',			'healthandcare');
			$list['bounceOutUp']	= esc_html__('Bounce Out Up',		'healthandcare');
			$list['bounceOutDown']	= esc_html__('Bounce Out Down',		'healthandcare');
			$list['bounceOutLeft']	= esc_html__('Bounce Out Left',		'healthandcare');
			$list['bounceOutRight']	= esc_html__('Bounce Out Right',	'healthandcare');
			$list['fadeOut']		= esc_html__('Fade Out',			'healthandcare');
			$list['fadeOutUp']		= esc_html__('Fade Out Up',			'healthandcare');
			$list['fadeOutDown']	= esc_html__('Fade Out Down',		'healthandcare');
			$list['fadeOutLeft']	= esc_html__('Fade Out Left',		'healthandcare');
			$list['fadeOutRight']	= esc_html__('Fade Out Right',		'healthandcare');
			$list['fadeOutUpBig']	= esc_html__('Fade Out Up Big',		'healthandcare');
			$list['fadeOutDownBig']	= esc_html__('Fade Out Down Big',	'healthandcare');
			$list['fadeOutLeftBig']	= esc_html__('Fade Out Left Big',	'healthandcare');
			$list['fadeOutRightBig']= esc_html__('Fade Out Right Big',	'healthandcare');
			$list['flipOutX']		= esc_html__('Flip Out X',			'healthandcare');
			$list['flipOutY']		= esc_html__('Flip Out Y',			'healthandcare');
			$list['hinge']			= esc_html__('Hinge Out',			'healthandcare');
			$list['lightSpeedOut']	= esc_html__('Light Speed Out',		'healthandcare');
			$list['rotateOut']		= esc_html__('Rotate Out',			'healthandcare');
			$list['rotateOutUpLeft']	= esc_html__('Rotate Out Down Left',	'healthandcare');
			$list['rotateOutUpRight']	= esc_html__('Rotate Out Up Right',		'healthandcare');
			$list['rotateOutDownLeft']	= esc_html__('Rotate Out Up Left',		'healthandcare');
			$list['rotateOutDownRight']	= esc_html__('Rotate Out Down Right',	'healthandcare');
			$list['rollOut']			= esc_html__('Roll Out',		'healthandcare');
			$list['slideOutUp']			= esc_html__('Slide Out Up',		'healthandcare');
			$list['slideOutDown']		= esc_html__('Slide Out Down',	'healthandcare');
			$list['slideOutLeft']		= esc_html__('Slide Out Left',	'healthandcare');
			$list['slideOutRight']		= esc_html__('Slide Out Right',	'healthandcare');
			$list['zoomOut']			= esc_html__('Zoom Out',			'healthandcare');
			$list['zoomOutUp']			= esc_html__('Zoom Out Up',		'healthandcare');
			$list['zoomOutDown']		= esc_html__('Zoom Out Down',	'healthandcare');
			$list['zoomOutLeft']		= esc_html__('Zoom Out Left',	'healthandcare');
			$list['zoomOutRight']		= esc_html__('Zoom Out Right',	'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_animations_out'] = $list = apply_filters('healthandcare_filter_list_animations_out', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return classes list for the specified animation
if (!function_exists('healthandcare_get_animation_classes')) {
	function healthandcare_get_animation_classes($animation, $speed='normal', $loop='none') {
		// speed:	fast=0.5s | normal=1s | slow=2s
		// loop:	none | infinite
		return healthandcare_param_is_off($animation) ? '' : 'animated '.esc_attr($animation).' '.esc_attr($speed).(!healthandcare_param_is_off($loop) ? ' '.esc_attr($loop) : '');
	}
}


// Return list of categories
if ( !function_exists( 'healthandcare_get_list_categories' ) ) {
	function healthandcare_get_list_categories($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_categories']))
			$list = $HEALTHANDCARE_GLOBALS['list_categories'];
		else {
			$list = array();
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false );
			$taxonomies = get_categories( $args );
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			$HEALTHANDCARE_GLOBALS['list_categories'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'healthandcare_get_list_terms' ) ) {
	function healthandcare_get_list_terms($prepend_inherit=false, $taxonomy='category') {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_taxonomies_'.($taxonomy)]))
			$list = $HEALTHANDCARE_GLOBALS['list_taxonomies_'.($taxonomy)];
		else {
			$list = array();
			$args = array(
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => $taxonomy,
				'pad_counts'               => false );
			$taxonomies = get_terms( $taxonomy, $args );
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;	// . ($taxonomy!='category' ? ' /'.($cat->taxonomy).'/' : '');
				}
			}
			$HEALTHANDCARE_GLOBALS['list_taxonomies_'.($taxonomy)] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return list of post's types
if ( !function_exists( 'healthandcare_get_list_posts_types' ) ) {
	function healthandcare_get_list_posts_types($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_posts_types']))
			$list = $HEALTHANDCARE_GLOBALS['list_posts_types'];
		else {
			$list = array();
			/* 
			// This way to return all registered post types
			$types = get_post_types();
			if (in_array('post', $types)) $list['post'] = esc_html__('Post', 'healthandcare');
			if (is_array($types) && count($types) > 0) {
				foreach ($types as $t) {
					if ($t == 'post') continue;
					$list[$t] = healthandcare_strtoproper($t);
				}
			}
			*/
			// Return only theme inheritance supported post types
			$HEALTHANDCARE_GLOBALS['list_posts_types'] = $list = apply_filters('healthandcare_filter_list_post_types', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'healthandcare_get_list_posts' ) ) {
	function healthandcare_get_list_posts($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		global $HEALTHANDCARE_GLOBALS;
		$hash = 'list_posts_'.($opt['post_type']).'_'.($opt['taxonomy']).'_'.($opt['taxonomy_value']).'_'.($opt['orderby']).'_'.($opt['order']).'_'.($opt['return']).'_'.($opt['posts_per_page']);
		if (isset($HEALTHANDCARE_GLOBALS[$hash]))
			$list = $HEALTHANDCARE_GLOBALS[$hash];
		else {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'healthandcare');
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => (int) $opt['taxonomy_value'] > 0 ? 'id' : 'slug',
						'terms' => $opt['taxonomy_value']
					)
				);
			}
			$posts = get_posts( $args );
			if (is_array($posts) && count($posts) > 0) {
				foreach ($posts as $post) {
					$list[$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
				}
			}
			$HEALTHANDCARE_GLOBALS[$hash] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}


// Return list of registered users
if ( !function_exists( 'healthandcare_get_list_users' ) ) {
	function healthandcare_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_users']))
			$list = $HEALTHANDCARE_GLOBALS['list_users'];
		else {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'healthandcare');
			$args = array(
				'orderby'	=> 'display_name',
				'order'		=> 'ASC' );
			$users = get_users( $args );
			if (is_array($users) && count($users) > 0) {
				foreach ($users as $user) {
					$accept = true;
					if (is_array($user->roles)) {
						if (is_array($user->roles) && count($user->roles) > 0) {
							$accept = false;
							foreach ($user->roles as $role) {
								if (in_array($role, $roles)) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ($accept) $list[$user->user_login] = $user->display_name;
				}
			}
			$HEALTHANDCARE_GLOBALS['list_users'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}


// Return slider engines list, prepended inherit (if need)
if ( !function_exists( 'healthandcare_get_list_sliders' ) ) {
	function healthandcare_get_list_sliders($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_sliders']))
			$list = $HEALTHANDCARE_GLOBALS['list_sliders'];
		else {
			$list = array();
			if (healthandcare_exists_revslider())
				$list["revo"] = esc_html__("Layer slider (Revolution)", 'healthandcare');
			if (healthandcare_exists_royalslider())
				$list["royal"] = esc_html__("Layer slider (Royal)", 'healthandcare');
			$list["swiper"] = esc_html__("Posts slider (Swiper)", 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_sliders'] = $list = apply_filters('healthandcare_filter_list_sliders', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}


// Return Revo Sliders list, prepended inherit (if need)
if ( !function_exists( 'healthandcare_get_list_revo_sliders' ) ) {
	function healthandcare_get_list_revo_sliders($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_revo_sliders']))
			$list = $HEALTHANDCARE_GLOBALS['list_revo_sliders'];
		else {
			$list = array();
			if (healthandcare_exists_revslider()) {
				global $wpdb;
				$rows = $wpdb->get_results( "SELECT alias, title FROM " . esc_sql($wpdb->prefix) . "revslider_sliders" );
				if (is_array($rows) && count($rows) > 0) {
					foreach ($rows as $row) {
						$list[$row->alias] = $row->title;
					}
				}
			}
			$HEALTHANDCARE_GLOBALS['list_revo_sliders'] = $list = apply_filters('healthandcare_filter_list_revo_sliders', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}


// Return slider controls list, prepended inherit (if need)
if ( !function_exists( 'healthandcare_get_list_slider_controls' ) ) {
	function healthandcare_get_list_slider_controls($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_slider_controls']))
			$list = $HEALTHANDCARE_GLOBALS['list_slider_controls'];
		else {
			$list = array(
				'no' => esc_html__('None', 'healthandcare'),
				'side' => esc_html__('Side', 'healthandcare'),
				'bottom' => esc_html__('Bottom', 'healthandcare'),
				'pagination' => esc_html__('Pagination', 'healthandcare')
			);
			$HEALTHANDCARE_GLOBALS['list_slider_controls'] = $list = apply_filters('healthandcare_filter_list_slider_controls', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}


// Return slider controls classes
if ( !function_exists( 'healthandcare_get_slider_controls_classes' ) ) {
	function healthandcare_get_slider_controls_classes($controls) {
		if (healthandcare_param_is_off($controls))	$classes = 'sc_slider_nopagination sc_slider_nocontrols';
		else if ($controls=='bottom')				$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_bottom';
		else if ($controls=='pagination')			$classes = 'sc_slider_pagination sc_slider_pagination_bottom sc_slider_nocontrols';
		else										$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_side';
		return $classes;
	}
}

// Return list with popup engines
if ( !function_exists( 'healthandcare_get_list_popup_engines' ) ) {
	function healthandcare_get_list_popup_engines($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_popup_engines']))
			$list = $HEALTHANDCARE_GLOBALS['list_popup_engines'];
		else {
			$list = array();
			$list["pretty"] = esc_html__("Pretty photo", 'healthandcare');
			$list["magnific"] = esc_html__("Magnific popup", 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_popup_engines'] = $list = apply_filters('healthandcare_filter_list_popup_engines', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_menus' ) ) {
	function healthandcare_get_list_menus($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_menus']))
			$list = $HEALTHANDCARE_GLOBALS['list_menus'];
		else {
			$list = array();
			$list['default'] = esc_html__("Default", 'healthandcare');
			$menus = wp_get_nav_menus();
			if (is_array($menus) && count($menus) > 0) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
			$HEALTHANDCARE_GLOBALS['list_menus'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'healthandcare_get_list_sidebars' ) ) {
	function healthandcare_get_list_sidebars($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_sidebars'])) {
			$list = $HEALTHANDCARE_GLOBALS['list_sidebars'];
		} else {
			$list = isset($HEALTHANDCARE_GLOBALS['registered_sidebars']) ? $HEALTHANDCARE_GLOBALS['registered_sidebars'] : array();
			$HEALTHANDCARE_GLOBALS['list_sidebars'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return sidebars positions
if ( !function_exists( 'healthandcare_get_list_sidebars_positions' ) ) {
	function healthandcare_get_list_sidebars_positions($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_sidebars_positions']))
			$list = $HEALTHANDCARE_GLOBALS['list_sidebars_positions'];
		else {
			$list = array();
			$list['none']  = esc_html__('Hide',  'healthandcare');
			$list['left']  = esc_html__('Left',  'healthandcare');
			$list['right'] = esc_html__('Right', 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_sidebars_positions'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return sidebars class
if ( !function_exists( 'healthandcare_get_sidebar_class' ) ) {
	function healthandcare_get_sidebar_class() {
		$sb_main = healthandcare_get_custom_option('show_sidebar_main');
		$sb_outer = healthandcare_get_custom_option('show_sidebar_outer');
		return (healthandcare_param_is_off($sb_main) ? 'sidebar_hide' : 'sidebar_show sidebar_'.($sb_main))
				. ' ' . (healthandcare_param_is_off($sb_outer) ? 'sidebar_outer_hide' : 'sidebar_outer_show sidebar_outer_'.($sb_outer));
	}
}

// Return body styles list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_body_styles' ) ) {
	function healthandcare_get_list_body_styles($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_body_styles']))
			$list = $HEALTHANDCARE_GLOBALS['list_body_styles'];
		else {
			$list = array();
			$list['boxed']		= esc_html__('Boxed',		'healthandcare');
			$list['wide']		= esc_html__('Wide',		'healthandcare');
			$list['fullwide']	= esc_html__('Fullwide',	'healthandcare');
			$list['fullscreen']	= esc_html__('Fullscreen',	'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_body_styles'] = $list = apply_filters('healthandcare_filter_list_body_styles', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return skins list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_skins' ) ) {
	function healthandcare_get_list_skins($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_skins']))
			$list = $HEALTHANDCARE_GLOBALS['list_skins'];
		else
			$HEALTHANDCARE_GLOBALS['list_skins'] = $list = healthandcare_get_list_folders("skins");
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return css-themes list
if ( !function_exists( 'healthandcare_get_list_themes' ) ) {
	function healthandcare_get_list_themes($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_themes']))
			$list = $HEALTHANDCARE_GLOBALS['list_themes'];
		else
			$HEALTHANDCARE_GLOBALS['list_themes'] = $list = healthandcare_get_list_files("css/themes");
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return templates list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_templates' ) ) {
	function healthandcare_get_list_templates($mode='') {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_templates_'.($mode)]))
			$list = $HEALTHANDCARE_GLOBALS['list_templates_'.($mode)];
		else {
			$list = array();
			if (is_array($HEALTHANDCARE_GLOBALS['registered_templates']) && count($HEALTHANDCARE_GLOBALS['registered_templates']) > 0) {
				foreach ($HEALTHANDCARE_GLOBALS['registered_templates'] as $k=>$v) {
					if ($mode=='' || healthandcare_strpos($v['mode'], $mode)!==false)
						$list[$k] = !empty($v['icon']) 
									? $v['icon'] 
									: (!empty($v['title']) 
										? $v['title'] 
										: healthandcare_strtoproper($v['layout'])
										);
				}
			}
			$HEALTHANDCARE_GLOBALS['list_templates_'.($mode)] = $list;
		}
		return $list;
	}
}

// Return blog styles list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_templates_blog' ) ) {
	function healthandcare_get_list_templates_blog($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_templates_blog']))
			$list = $HEALTHANDCARE_GLOBALS['list_templates_blog'];
		else {
			$list = healthandcare_get_list_templates('blog');
			$HEALTHANDCARE_GLOBALS['list_templates_blog'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return blogger styles list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_templates_blogger' ) ) {
	function healthandcare_get_list_templates_blogger($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_templates_blogger']))
			$list = $HEALTHANDCARE_GLOBALS['list_templates_blogger'];
		else {
			$list = healthandcare_array_merge(healthandcare_get_list_templates('blogger'), healthandcare_get_list_templates('blog'));
			$HEALTHANDCARE_GLOBALS['list_templates_blogger'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return single page styles list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_templates_single' ) ) {
	function healthandcare_get_list_templates_single($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_templates_single']))
			$list = $HEALTHANDCARE_GLOBALS['list_templates_single'];
		else {
			$list = healthandcare_get_list_templates('single');
			$HEALTHANDCARE_GLOBALS['list_templates_single'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return header styles list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_templates_header' ) ) {
	function healthandcare_get_list_templates_header($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_templates_header']))
			$list = $HEALTHANDCARE_GLOBALS['list_templates_header'];
		else {
			$list = healthandcare_get_list_templates('header');
			$HEALTHANDCARE_GLOBALS['list_templates_header'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return article styles list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_article_styles' ) ) {
	function healthandcare_get_list_article_styles($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_article_styles']))
			$list = $HEALTHANDCARE_GLOBALS['list_article_styles'];
		else {
			$list = array();
			$list["boxed"]   = esc_html__('Boxed', 'healthandcare');
			$list["stretch"] = esc_html__('Stretch', 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_article_styles'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return button styles list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_button_styles' ) ) {
	function healthandcare_get_list_button_styles($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_button_styles']))
			$list = $HEALTHANDCARE_GLOBALS['list_button_styles'];
		else {
			$list = array();
			$list["custom"]	= esc_html__('Custom', 'healthandcare');
			$list["link"] 	= esc_html__('Style 1', 'healthandcare');
			$list["menu"] 	= esc_html__('Style 2', 'healthandcare');
			$list["user"] 	= esc_html__('Style 3', 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_button_styles'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return post-formats filters list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_post_formats_filters' ) ) {
	function healthandcare_get_list_post_formats_filters($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_post_formats_filters']))
			$list = $HEALTHANDCARE_GLOBALS['list_post_formats_filters'];
		else {
			$list = array();
			$list["no"]      = esc_html__('All posts', 'healthandcare');
			$list["thumbs"]  = esc_html__('With thumbs', 'healthandcare');
			$list["reviews"] = esc_html__('With reviews', 'healthandcare');
			$list["video"]   = esc_html__('With videos', 'healthandcare');
			$list["audio"]   = esc_html__('With audios', 'healthandcare');
			$list["gallery"] = esc_html__('With galleries', 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_post_formats_filters'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return portfolio filters list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_portfolio_filters' ) ) {
	function healthandcare_get_list_portfolio_filters($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_portfolio_filters']))
			$list = $HEALTHANDCARE_GLOBALS['list_portfolio_filters'];
		else {
			$list = array();
			$list["hide"] = esc_html__('Hide', 'healthandcare');
			$list["tags"] = esc_html__('Tags', 'healthandcare');
			$list["categories"] = esc_html__('Categories', 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_portfolio_filters'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return hover styles list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_hovers' ) ) {
	function healthandcare_get_list_hovers($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_hovers']))
			$list = $HEALTHANDCARE_GLOBALS['list_hovers'];
		else {
			$list = array();
			$list['circle effect1']  = esc_html__('Circle Effect 1',  'healthandcare');
			$list['circle effect2']  = esc_html__('Circle Effect 2',  'healthandcare');
			$list['circle effect3']  = esc_html__('Circle Effect 3',  'healthandcare');
			$list['circle effect4']  = esc_html__('Circle Effect 4',  'healthandcare');
			$list['circle effect5']  = esc_html__('Circle Effect 5',  'healthandcare');
			$list['circle effect6']  = esc_html__('Circle Effect 6',  'healthandcare');
			$list['circle effect7']  = esc_html__('Circle Effect 7',  'healthandcare');
			$list['circle effect8']  = esc_html__('Circle Effect 8',  'healthandcare');
			$list['circle effect9']  = esc_html__('Circle Effect 9',  'healthandcare');
			$list['circle effect10'] = esc_html__('Circle Effect 10',  'healthandcare');
			$list['circle effect11'] = esc_html__('Circle Effect 11',  'healthandcare');
			$list['circle effect12'] = esc_html__('Circle Effect 12',  'healthandcare');
			$list['circle effect13'] = esc_html__('Circle Effect 13',  'healthandcare');
			$list['circle effect14'] = esc_html__('Circle Effect 14',  'healthandcare');
			$list['circle effect15'] = esc_html__('Circle Effect 15',  'healthandcare');
			$list['circle effect16'] = esc_html__('Circle Effect 16',  'healthandcare');
			$list['circle effect17'] = esc_html__('Circle Effect 17',  'healthandcare');
			$list['circle effect18'] = esc_html__('Circle Effect 18',  'healthandcare');
			$list['circle effect19'] = esc_html__('Circle Effect 19',  'healthandcare');
			$list['circle effect20'] = esc_html__('Circle Effect 20',  'healthandcare');
			$list['square effect1']  = esc_html__('Square Effect 1',  'healthandcare');
			$list['square effect2']  = esc_html__('Square Effect 2',  'healthandcare');
			$list['square effect3']  = esc_html__('Square Effect 3',  'healthandcare');
	//		$list['square effect4']  = esc_html__('Square Effect 4',  'healthandcare');
			$list['square effect5']  = esc_html__('Square Effect 5',  'healthandcare');
			$list['square effect6']  = esc_html__('Square Effect 6',  'healthandcare');
			$list['square effect7']  = esc_html__('Square Effect 7',  'healthandcare');
			$list['square effect8']  = esc_html__('Square Effect 8',  'healthandcare');
			$list['square effect9']  = esc_html__('Square Effect 9',  'healthandcare');
			$list['square effect10'] = esc_html__('Square Effect 10',  'healthandcare');
			$list['square effect11'] = esc_html__('Square Effect 11',  'healthandcare');
			$list['square effect12'] = esc_html__('Square Effect 12',  'healthandcare');
			$list['square effect13'] = esc_html__('Square Effect 13',  'healthandcare');
			$list['square effect14'] = esc_html__('Square Effect 14',  'healthandcare');
			$list['square effect15'] = esc_html__('Square Effect 15',  'healthandcare');
			$list['square effect_dir']   = esc_html__('Square Effect Dir',   'healthandcare');
			$list['square effect_shift'] = esc_html__('Square Effect Shift', 'healthandcare');
			$list['square effect_book']  = esc_html__('Square Effect Book',  'healthandcare');
			$list['square effect_more']  = esc_html__('Square Effect More',  'healthandcare');
			$list['square effect_fade']  = esc_html__('Square Effect Fade',  'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_hovers'] = $list = apply_filters('healthandcare_filter_portfolio_hovers', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return extended hover directions list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_hovers_directions' ) ) {
	function healthandcare_get_list_hovers_directions($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_hovers_directions']))
			$list = $HEALTHANDCARE_GLOBALS['list_hovers_directions'];
		else {
			$list = array();
			$list['left_to_right'] = esc_html__('Left to Right',  'healthandcare');
			$list['right_to_left'] = esc_html__('Right to Left',  'healthandcare');
			$list['top_to_bottom'] = esc_html__('Top to Bottom',  'healthandcare');
			$list['bottom_to_top'] = esc_html__('Bottom to Top',  'healthandcare');
			$list['scale_up']      = esc_html__('Scale Up',  'healthandcare');
			$list['scale_down']    = esc_html__('Scale Down',  'healthandcare');
			$list['scale_down_up'] = esc_html__('Scale Down-Up',  'healthandcare');
			$list['from_left_and_right'] = esc_html__('From Left and Right',  'healthandcare');
			$list['from_top_and_bottom'] = esc_html__('From Top and Bottom',  'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_hovers_directions'] = $list = apply_filters('healthandcare_filter_portfolio_hovers_directions', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}


// Return list of the label positions in the custom forms
if ( !function_exists( 'healthandcare_get_list_label_positions' ) ) {
	function healthandcare_get_list_label_positions($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_label_positions']))
			$list = $HEALTHANDCARE_GLOBALS['list_label_positions'];
		else {
			$list = array();
			$list['top']	= esc_html__('Top',		'healthandcare');
			$list['bottom']	= esc_html__('Bottom',		'healthandcare');
			$list['left']	= esc_html__('Left',		'healthandcare');
			$list['over']	= esc_html__('Over',		'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_label_positions'] = $list = apply_filters('healthandcare_filter_label_positions', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}


// Return list of the bg image positions
if ( !function_exists( 'healthandcare_get_list_bg_image_positions' ) ) {
	function healthandcare_get_list_bg_image_positions($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_bg_image_positions']))
			$list = $HEALTHANDCARE_GLOBALS['list_bg_image_positions'];
		else {
			$list = array();
			$list['left top']	  = esc_html__('Left Top', 'healthandcare');
			$list['center top']   = esc_html__("Center Top", 'healthandcare');
			$list['right top']    = esc_html__("Right Top", 'healthandcare');
			$list['left center']  = esc_html__("Left Center", 'healthandcare');
			$list['center center']= esc_html__("Center Center", 'healthandcare');
			$list['right center'] = esc_html__("Right Center", 'healthandcare');
			$list['left bottom']  = esc_html__("Left Bottom", 'healthandcare');
			$list['center bottom']= esc_html__("Center Bottom", 'healthandcare');
			$list['right bottom'] = esc_html__("Right Bottom", 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_bg_image_positions'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}


// Return list of the bg image repeat
if ( !function_exists( 'healthandcare_get_list_bg_image_repeats' ) ) {
	function healthandcare_get_list_bg_image_repeats($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_bg_image_repeats']))
			$list = $HEALTHANDCARE_GLOBALS['list_bg_image_repeats'];
		else {
			$list = array();
			$list['repeat']	  = esc_html__('Repeat', 'healthandcare');
			$list['repeat-x'] = esc_html__('Repeat X', 'healthandcare');
			$list['repeat-y'] = esc_html__('Repeat Y', 'healthandcare');
			$list['no-repeat']= esc_html__('No Repeat', 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_bg_image_repeats'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}


// Return list of the bg image attachment
if ( !function_exists( 'healthandcare_get_list_bg_image_attachments' ) ) {
	function healthandcare_get_list_bg_image_attachments($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_bg_image_attachments']))
			$list = $HEALTHANDCARE_GLOBALS['list_bg_image_attachments'];
		else {
			$list = array();
			$list['scroll']	= esc_html__('Scroll', 'healthandcare');
			$list['fixed']	= esc_html__('Fixed', 'healthandcare');
			$list['local']	= esc_html__('Local', 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_bg_image_attachments'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return custom fields types list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_field_types' ) ) {
	function healthandcare_get_list_field_types($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_field_types']))
			$list = $HEALTHANDCARE_GLOBALS['list_field_types'];
		else {
			$list = array();
			$list['text']     = esc_html__('Text',  'healthandcare');
			$list['textarea'] = esc_html__('Text Area','healthandcare');
			$list['password'] = esc_html__('Password',  'healthandcare');
			$list['radio']    = esc_html__('Radio',  'healthandcare');
			$list['checkbox'] = esc_html__('Checkbox',  'healthandcare');
			$list['select']   = esc_html__('Select',  'healthandcare');
			$list['button']   = esc_html__('Button','healthandcare');
			$HEALTHANDCARE_GLOBALS['list_field_types'] = $list = apply_filters('healthandcare_filter_field_types', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return Google map styles
if ( !function_exists( 'healthandcare_get_list_googlemap_styles' ) ) {
	function healthandcare_get_list_googlemap_styles($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_googlemap_styles']))
			$list = $HEALTHANDCARE_GLOBALS['list_googlemap_styles'];
		else {
			$list = array();
			$list['default'] = esc_html__('Default', 'healthandcare');
			$list['simple'] = esc_html__('Simple', 'healthandcare');
			$list['greyscale'] = esc_html__('Greyscale', 'healthandcare');
			$list['greyscale2'] = esc_html__('Greyscale 2', 'healthandcare');
			$list['invert'] = esc_html__('Invert', 'healthandcare');
			$list['dark'] = esc_html__('Dark', 'healthandcare');
			$list['style1'] = esc_html__('Custom style 1', 'healthandcare');
			$list['style2'] = esc_html__('Custom style 2', 'healthandcare');
			$list['style3'] = esc_html__('Custom style 3', 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_googlemap_styles'] = $list = apply_filters('healthandcare_filter_googlemap_styles', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return iconed classes list
if ( !function_exists( 'healthandcare_get_list_icons' ) ) {
	function healthandcare_get_list_icons($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_icons']))
			$list = $HEALTHANDCARE_GLOBALS['list_icons'];
		else
			$HEALTHANDCARE_GLOBALS['list_icons'] = $list = healthandcare_parse_icons_classes(healthandcare_get_file_dir("css/fontello/css/fontello-codes.css"));
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return socials list
if ( !function_exists( 'healthandcare_get_list_socials' ) ) {
	function healthandcare_get_list_socials($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_socials']))
			$list = $HEALTHANDCARE_GLOBALS['list_socials'];
		else
			$HEALTHANDCARE_GLOBALS['list_socials'] = $list = healthandcare_get_list_files("images/socials", "png");
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return flags list
if ( !function_exists( 'healthandcare_get_list_flags' ) ) {
	function healthandcare_get_list_flags($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_flags']))
			$list = $HEALTHANDCARE_GLOBALS['list_flags'];
		else
			$HEALTHANDCARE_GLOBALS['list_flags'] = $list = healthandcare_get_list_files("images/flags", "png");
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( !function_exists( 'healthandcare_get_list_yesno' ) ) {
	function healthandcare_get_list_yesno($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_yesno']))
			$list = $HEALTHANDCARE_GLOBALS['list_yesno'];
		else {
			$list = array();
			$list["yes"] = esc_html__("Yes", 'healthandcare');
			$list["no"]  = esc_html__("No", 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_yesno'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( !function_exists( 'healthandcare_get_list_onoff' ) ) {
	function healthandcare_get_list_onoff($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_onoff']))
			$list = $HEALTHANDCARE_GLOBALS['list_onoff'];
		else {
			$list = array();
			$list["on"] = esc_html__("On", 'healthandcare');
			$list["off"] = esc_html__("Off", 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_onoff'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( !function_exists( 'healthandcare_get_list_showhide' ) ) {
	function healthandcare_get_list_showhide($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_showhide']))
			$list = $HEALTHANDCARE_GLOBALS['list_showhide'];
		else {
			$list = array();
			$list["show"] = esc_html__("Show", 'healthandcare');
			$list["hide"] = esc_html__("Hide", 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_showhide'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return list with 'Ascending' and 'Descending' items
if ( !function_exists( 'healthandcare_get_list_orderings' ) ) {
	function healthandcare_get_list_orderings($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_orderings']))
			$list = $HEALTHANDCARE_GLOBALS['list_orderings'];
		else {
			$list = array();
			$list["asc"] = esc_html__("Ascending", 'healthandcare');
			$list["desc"] = esc_html__("Descending", 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_orderings'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( !function_exists( 'healthandcare_get_list_directions' ) ) {
	function healthandcare_get_list_directions($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_directions']))
			$list = $HEALTHANDCARE_GLOBALS['list_directions'];
		else {
			$list = array();
			$list["horizontal"] = esc_html__("Horizontal", 'healthandcare');
			$list["vertical"] = esc_html__("Vertical", 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_directions'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return list with item's shapes
if ( !function_exists( 'healthandcare_get_list_shapes' ) ) {
	function healthandcare_get_list_shapes($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_shapes']))
			$list = $HEALTHANDCARE_GLOBALS['list_shapes'];
		else {
			$list = array();
			$list["round"]  = esc_html__("Round", 'healthandcare');
			$list["square"] = esc_html__("Square", 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_shapes'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return list with item's sizes
if ( !function_exists( 'healthandcare_get_list_sizes' ) ) {
	function healthandcare_get_list_sizes($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_sizes']))
			$list = $HEALTHANDCARE_GLOBALS['list_sizes'];
		else {
			$list = array();
			$list["tiny"]   = esc_html__("Tiny", 'healthandcare');
			$list["small"]  = esc_html__("Small", 'healthandcare');
			$list["medium"] = esc_html__("Medium", 'healthandcare');
			$list["large"]  = esc_html__("Large", 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_sizes'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return list with float items
if ( !function_exists( 'healthandcare_get_list_floats' ) ) {
	function healthandcare_get_list_floats($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_floats']))
			$list = $HEALTHANDCARE_GLOBALS['list_floats'];
		else {
			$list = array();
			$list["none"] = esc_html__("None", 'healthandcare');
			$list["left"] = esc_html__("Float Left", 'healthandcare');
			$list["right"] = esc_html__("Float Right", 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_floats'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return list with alignment items
if ( !function_exists( 'healthandcare_get_list_alignments' ) ) {
	function healthandcare_get_list_alignments($justify=false, $prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_alignments']))
			$list = $HEALTHANDCARE_GLOBALS['list_alignments'];
		else {
			$list = array();
			$list["none"] = esc_html__("None", 'healthandcare');
			$list["left"] = esc_html__("Left", 'healthandcare');
			$list["center"] = esc_html__("Center", 'healthandcare');
			$list["right"] = esc_html__("Right", 'healthandcare');
			if ($justify) $list["justify"] = esc_html__("Justify", 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_alignments'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return sorting list items
if ( !function_exists( 'healthandcare_get_list_sortings' ) ) {
	function healthandcare_get_list_sortings($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_sortings']))
			$list = $HEALTHANDCARE_GLOBALS['list_sortings'];
		else {
			$list = array();
			$list["date"] = esc_html__("Date", 'healthandcare');
			$list["title"] = esc_html__("Alphabetically", 'healthandcare');
			$list["views"] = esc_html__("Popular (views count)", 'healthandcare');
			$list["comments"] = esc_html__("Most commented (comments count)", 'healthandcare');
			$list["author_rating"] = esc_html__("Author rating", 'healthandcare');
			$list["users_rating"] = esc_html__("Visitors (users) rating", 'healthandcare');
			$list["random"] = esc_html__("Random", 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_sortings'] = $list = apply_filters('healthandcare_filter_list_sortings', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return list with columns widths
if ( !function_exists( 'healthandcare_get_list_columns' ) ) {
	function healthandcare_get_list_columns($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_columns']))
			$list = $HEALTHANDCARE_GLOBALS['list_columns'];
		else {
			$list = array();
			$list["none"] = esc_html__("None", 'healthandcare');
			$list["1_1"] = esc_html__("100%", 'healthandcare');
			$list["1_2"] = esc_html__("1/2", 'healthandcare');
			$list["1_3"] = esc_html__("1/3", 'healthandcare');
			$list["2_3"] = esc_html__("2/3", 'healthandcare');
			$list["1_4"] = esc_html__("1/4", 'healthandcare');
			$list["3_4"] = esc_html__("3/4", 'healthandcare');
			$list["1_5"] = esc_html__("1/5", 'healthandcare');
			$list["2_5"] = esc_html__("2/5", 'healthandcare');
			$list["3_5"] = esc_html__("3/5", 'healthandcare');
			$list["4_5"] = esc_html__("4/5", 'healthandcare');
			$list["1_6"] = esc_html__("1/6", 'healthandcare');
			$list["5_6"] = esc_html__("5/6", 'healthandcare');
			$list["1_7"] = esc_html__("1/7", 'healthandcare');
			$list["2_7"] = esc_html__("2/7", 'healthandcare');
			$list["3_7"] = esc_html__("3/7", 'healthandcare');
			$list["4_7"] = esc_html__("4/7", 'healthandcare');
			$list["5_7"] = esc_html__("5/7", 'healthandcare');
			$list["6_7"] = esc_html__("6/7", 'healthandcare');
			$list["1_8"] = esc_html__("1/8", 'healthandcare');
			$list["3_8"] = esc_html__("3/8", 'healthandcare');
			$list["5_8"] = esc_html__("5/8", 'healthandcare');
			$list["7_8"] = esc_html__("7/8", 'healthandcare');
			$list["1_9"] = esc_html__("1/9", 'healthandcare');
			$list["2_9"] = esc_html__("2/9", 'healthandcare');
			$list["4_9"] = esc_html__("4/9", 'healthandcare');
			$list["5_9"] = esc_html__("5/9", 'healthandcare');
			$list["7_9"] = esc_html__("7/9", 'healthandcare');
			$list["8_9"] = esc_html__("8/9", 'healthandcare');
			$list["1_10"]= esc_html__("1/10", 'healthandcare');
			$list["3_10"]= esc_html__("3/10", 'healthandcare');
			$list["7_10"]= esc_html__("7/10", 'healthandcare');
			$list["9_10"]= esc_html__("9/10", 'healthandcare');
			$list["1_11"]= esc_html__("1/11", 'healthandcare');
			$list["2_11"]= esc_html__("2/11", 'healthandcare');
			$list["3_11"]= esc_html__("3/11", 'healthandcare');
			$list["4_11"]= esc_html__("4/11", 'healthandcare');
			$list["5_11"]= esc_html__("5/11", 'healthandcare');
			$list["6_11"]= esc_html__("6/11", 'healthandcare');
			$list["7_11"]= esc_html__("7/11", 'healthandcare');
			$list["8_11"]= esc_html__("8/11", 'healthandcare');
			$list["9_11"]= esc_html__("9/11", 'healthandcare');
			$list["10_11"]= esc_html__("10/11", 'healthandcare');
			$list["1_12"]= esc_html__("1/12", 'healthandcare');
			$list["5_12"]= esc_html__("5/12", 'healthandcare');
			$list["7_12"]= esc_html__("7/12", 'healthandcare');
			$list["10_12"]= esc_html__("10/12", 'healthandcare');
			$list["11_12"]= esc_html__("11/12", 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_columns'] = $list = apply_filters('healthandcare_filter_list_columns', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return list of locations for the dedicated content
if ( !function_exists( 'healthandcare_get_list_dedicated_locations' ) ) {
	function healthandcare_get_list_dedicated_locations($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_dedicated_locations']))
			$list = $HEALTHANDCARE_GLOBALS['list_dedicated_locations'];
		else {
			$list = array();
			$list["default"] = esc_html__('As in the post defined', 'healthandcare');
			$list["center"]  = esc_html__('Above the text of the post', 'healthandcare');
			$list["left"]    = esc_html__('To the left the text of the post', 'healthandcare');
			$list["right"]   = esc_html__('To the right the text of the post', 'healthandcare');
			$list["alter"]   = esc_html__('Alternates for each post', 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_dedicated_locations'] = $list = apply_filters('healthandcare_filter_list_dedicated_locations', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return post-format name
if ( !function_exists( 'healthandcare_get_post_format_name' ) ) {
	function healthandcare_get_post_format_name($format, $single=true) {
		$name = '';
		if ($format=='gallery')		$name = $single ? esc_html__('gallery', 'healthandcare') : esc_html__('galleries', 'healthandcare');
		else if ($format=='video')	$name = $single ? esc_html__('video', 'healthandcare') : esc_html__('videos', 'healthandcare');
		else if ($format=='audio')	$name = $single ? esc_html__('audio', 'healthandcare') : esc_html__('audios', 'healthandcare');
		else if ($format=='image')	$name = $single ? esc_html__('image', 'healthandcare') : esc_html__('images', 'healthandcare');
		else if ($format=='quote')	$name = $single ? esc_html__('quote', 'healthandcare') : esc_html__('quotes', 'healthandcare');
		else if ($format=='link')	$name = $single ? esc_html__('link', 'healthandcare') : esc_html__('links', 'healthandcare');
		else if ($format=='status')	$name = $single ? esc_html__('status', 'healthandcare') : esc_html__('statuses', 'healthandcare');
		else if ($format=='aside')	$name = $single ? esc_html__('aside', 'healthandcare') : esc_html__('asides', 'healthandcare');
		else if ($format=='chat')	$name = $single ? esc_html__('chat', 'healthandcare') : esc_html__('chats', 'healthandcare');
		else						$name = $single ? esc_html__('standard', 'healthandcare') : esc_html__('standards', 'healthandcare');
		return apply_filters('healthandcare_filter_list_post_format_name', $name, $format);
	}
}

// Return post-format icon name (from Fontello library)
if ( !function_exists( 'healthandcare_get_post_format_icon' ) ) {
	function healthandcare_get_post_format_icon($format) {
		$icon = 'icon-';
		if ($format=='gallery')		$icon .= 'pictures';
		else if ($format=='video')	$icon .= 'video';
		else if ($format=='audio')	$icon .= 'note';
		else if ($format=='image')	$icon .= 'picture';
		else if ($format=='quote')	$icon .= 'quote';
		else if ($format=='link')	$icon .= 'link';
		else if ($format=='status')	$icon .= 'comment';
		else if ($format=='aside')	$icon .= 'doc-text';
		else if ($format=='chat')	$icon .= 'chat';
		else						$icon .= 'book-open';
		return apply_filters('healthandcare_filter_list_post_format_icon', $icon, $format);
	}
}

// Return fonts styles list, prepended inherit
if ( !function_exists( 'healthandcare_get_list_fonts_styles' ) ) {
	function healthandcare_get_list_fonts_styles($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_fonts_styles']))
			$list = $HEALTHANDCARE_GLOBALS['list_fonts_styles'];
		else {
			$list = array();
			$list['i'] = esc_html__('I','healthandcare');
			$list['u'] = esc_html__('U', 'healthandcare');
			$HEALTHANDCARE_GLOBALS['list_fonts_styles'] = $list;
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return Google fonts list
if ( !function_exists( 'healthandcare_get_list_fonts' ) ) {
	function healthandcare_get_list_fonts($prepend_inherit=false) {
		global $HEALTHANDCARE_GLOBALS;
		if (isset($HEALTHANDCARE_GLOBALS['list_fonts']))
			$list = $HEALTHANDCARE_GLOBALS['list_fonts'];
		else {
			$list = array();
			$list = healthandcare_array_merge($list, healthandcare_get_list_font_faces());
			// Google and custom fonts list:
			//$list['Advent Pro'] = array(
			//		'family'=>'sans-serif',																						// (required) font family
			//		'link'=>'Advent+Pro:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic',	// (optional) if you use Google font repository
			//		'css'=>healthandcare_get_file_url('/css/font-face/Advent-Pro/stylesheet.css')									// (optional) if you use custom font-face
			//		);
			$list['Advent Pro'] = array('family'=>'sans-serif');
			$list['Alegreya Sans'] = array('family'=>'sans-serif');
			$list['Arimo'] = array('family'=>'sans-serif');
			$list['Asap'] = array('family'=>'sans-serif');
			$list['Averia Sans Libre'] = array('family'=>'cursive');
			$list['Averia Serif Libre'] = array('family'=>'cursive');
			$list['Bree Serif'] = array('family'=>'serif',);
			$list['Cabin'] = array('family'=>'sans-serif');
			$list['Cabin Condensed'] = array('family'=>'sans-serif');
			$list['Caudex'] = array('family'=>'serif');
			$list['Comfortaa'] = array('family'=>'cursive');
			$list['Cousine'] = array('family'=>'sans-serif');
			$list['Crimson Text'] = array('family'=>'serif');
			$list['Cuprum'] = array('family'=>'sans-serif');
			$list['Dosis'] = array('family'=>'sans-serif');
			$list['Economica'] = array('family'=>'sans-serif');
			$list['Exo'] = array('family'=>'sans-serif');
			$list['Expletus Sans'] = array('family'=>'cursive');
			$list['Karla'] = array('family'=>'sans-serif');
			$list['Lato'] = array('family'=>'sans-serif');
			$list['Lekton'] = array('family'=>'sans-serif');
			$list['Lobster Two'] = array('family'=>'cursive');
			$list['Maven Pro'] = array('family'=>'sans-serif');
			$list['Merriweather'] = array('family'=>'serif');
			$list['Montserrat'] = array('family'=>'sans-serif');
			$list['Neuton'] = array('family'=>'serif');
			$list['Noticia Text'] = array('family'=>'serif');
			$list['Old Standard TT'] = array('family'=>'serif');
			$list['Open Sans'] = array('family'=>'sans-serif');
			$list['Orbitron'] = array('family'=>'sans-serif');
			$list['Oswald'] = array('family'=>'sans-serif');
			$list['Overlock'] = array('family'=>'cursive');
			$list['Oxygen'] = array('family'=>'sans-serif');
			$list['PT Serif'] = array('family'=>'serif');
			$list['Puritan'] = array('family'=>'sans-serif');
			$list['Raleway'] = array('family'=>'sans-serif');
			$list['Roboto'] = array('family'=>'sans-serif');
			$list['Roboto Slab'] = array('family'=>'sans-serif');
			$list['Roboto Condensed'] = array('family'=>'sans-serif');
			$list['Rosario'] = array('family'=>'sans-serif');
			$list['Share'] = array('family'=>'cursive');
			$list['Signika'] = array('family'=>'sans-serif');
			$list['Signika Negative'] = array('family'=>'sans-serif');
			$list['Source Sans Pro'] = array('family'=>'sans-serif');
			$list['Tinos'] = array('family'=>'serif');
			$list['Ubuntu'] = array('family'=>'sans-serif');
			$list['Vollkorn'] = array('family'=>'serif');
			$HEALTHANDCARE_GLOBALS['list_fonts'] = $list = apply_filters('healthandcare_filter_list_fonts', $list);
		}
		return $prepend_inherit ? healthandcare_array_merge(array('inherit' => esc_html__("Inherit", 'healthandcare')), $list) : $list;
	}
}

// Return Custom font-face list
if ( !function_exists( 'healthandcare_get_list_font_faces' ) ) {
	function healthandcare_get_list_font_faces($prepend_inherit=false) {
		static $list = false;
		if (is_array($list)) return $list;
		$list = array();
		$dir = healthandcare_get_folder_dir("css/font-face");
		if ( is_dir($dir) ) {
			$hdir = @ opendir( $dir );
			if ( $hdir ) {
				while (($file = readdir( $hdir ) ) !== false ) {
					$pi = pathinfo( ($dir) . '/' . ($file) );
					if ( substr($file, 0, 1) == '.' || ! is_dir( ($dir) . '/' . ($file) ) )
						continue;
					$css = file_exists( ($dir) . '/' . ($file) . '/' . ($file) . '.css' ) 
						? healthandcare_get_folder_url("css/font-face/".($file).'/'.($file).'.css')
						: (file_exists( ($dir) . '/' . ($file) . '/stylesheet.css' ) 
							? healthandcare_get_folder_url("css/font-face/".($file).'/stylesheet.css')
							: '');
					if ($css != '')
						$list[$file.' ('.esc_html__('uploaded font', 'healthandcare').')'] = array('css' => $css);
				}
				@closedir( $hdir );
			}
		}
		return $list;
	}
}
?>