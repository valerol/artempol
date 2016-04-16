<?php
/**
 * Theme sprecific functions and definitions
 */


/* Theme setup section
------------------------------------------------------------------- */

if ( ! function_exists( 'artempol_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * Create your own artempol_setup() function to override in a child theme.
	 */
	function artempol_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Twenty Sixteen, use a find and replace
		 * to change 'artempol' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'artempol', get_template_directory() . '/languages' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		
	//	set_post_thumbnail_size( 370, 225, true );
		set_post_thumbnail_size( 370, 370, true );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'main-menu' => __( 'Main Menu', 'artempol' ),
		) );
	}
}
add_action( 'after_setup_theme', 'artempol_setup' );

/** 
* Enqueue css & javascripts
*/
add_action('wp_enqueue_scripts','artempol_add_script_function');
function artempol_add_script_function() {

	wp_enqueue_style( 'artempol', get_stylesheet_uri() );
	wp_enqueue_style( 'fontello', get_template_directory_uri() . '/css/fontello/css/fontello.css' );
	wp_enqueue_style( 'animation', get_template_directory_uri() . '/css/animation.css' );
	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/libs/flexslider/flexslider.css' );
	wp_enqueue_style( 'colorbox', get_template_directory_uri() . '/libs/colorbox/colorbox.css' );
	wp_enqueue_style( 'fontosc', 'https://fonts.googleapis.com/css?family=Open+Sans+Condensed:700&subset=latin,cyrillic' );
	wp_enqueue_style( 'fontos', 'https://fonts.googleapis.com/css?family=Open+Sans:400,700,400italic,700italic&subset=latin,cyrillic-ext' );

	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ) );
	wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/libs/colorbox/jquery.colorbox-min.js', array( 'jquery' ) );
	wp_enqueue_script( 'wow', get_template_directory_uri() . '/js/wow.js', array( 'jquery' ) );
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/libs/flexslider/jquery.flexslider.js', array( 'jquery' ) );	
	wp_enqueue_script( 'init', get_template_directory_uri() . '/js/init.js', array( 'jquery' ) );

}

/** 
* Theme Options
*/
include( 'theme-mods.php' );

/**
 * Template functions
 */
 
include( 'templates.php' );

function artempol_container( $tags, $template = 'container' ) {
	$content = artempol_tags_replace( $template, $tags );	
	return $content;
}

function artempol_tags_replace( $template, $tags ) {
	$template = artempol_get_template( $template );

	foreach( $tags as $key => $val ) {
		$key = mb_convert_case( $key, MB_CASE_UPPER );
		
		if ( strpos( $template, '%' . $key . '%' ) ) {
			$template = str_replace( '%' . $key . '%', $val, $template );
		}
	}
	$template = preg_replace( '#\%(\w+)\%#', '', $template );
	return $template;
}

// Post render
function artempol_get_post( $obj_post, $template, $template_tags, $counter = '' ) {
	global $post;
	$post = $obj_post;
	setup_postdata( $post );
	
	switch ( $template ) {				
		case 'team': 
		$image_size = 'medium';	
		break;
		default: $image_size = 'thumbnail';
	}
	
	// Doctor's title
	if ( $post->post_type == 'doctor' ) {
		$link = get_the_title();
	}	
	else $link = '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
	
	// Achievements images tags
	if ( $post->post_type == 'attachment' ) {
		$achievement_image_params = image_downsize( $post->ID, 'medium' );
		$achievement_image = $achievement_image_params[ 0 ];
		$achievement_url = $post->guid;
		$achievement_margin = $achievement_image_params[ 1 ] / 2;
	}
	else {
		$achievement_image = '';
		$achievement_url = '';
		$achievement_margin = '';
	}
	
	// Question edit link
	if ( $post->post_type == 'question' && get_the_content() == '' ) {
		$edit_ancor = __( 'Reply', 'artempol' );
	}
	else $edit_ancor = __( 'Edit', 'artempol' );		
	$edit_link = '<a class="edit-link" href="' . get_edit_post_link( $post->ID ) . '">' . $edit_ancor . '</a>';
	
	// Tags
	foreach( $template_tags as $tag ) {			
		
		switch ( $tag ) {				
			case 'content': $tags[ 'content' ] = get_the_content( __( 'More', 'artempol' ) );
			case 'description': $tags[ 'description' ] = get_the_excerpt();
			case 'title': $tags[ 'title' ] = get_the_title();
			case 'url': $tags[ 'url' ] = get_the_permalink( $post->ID );
			case 'link': $tags[ 'link' ] = $link;
			case 'edit_link': $tags[ 'edit_link' ] = $edit_link;
			case 'image': $tags[ 'image' ] = get_the_post_thumbnail( $post->ID, $image_size );
			case 'counter': $tags[ 'counter' ] = $counter;
			case 'datetime': $tags[ 'datetime' ] = get_the_date( 'Y-m-d' );
			case 'date': $tags[ 'date' ] = get_the_date();
			case 'image_url': $tags[ 'image_url' ] = wp_get_attachment_url( get_post_thumbnail_id() );
			// Greeting tag
			case 'title2': $tags[ 'title2' ] = get_post_meta( $post->ID, 'title2', true );
			// Achievements images tags
			case 'achievement_image': $tags[ 'achievement_image' ] = $achievement_image;
			case 'achievement_url': $tags[ 'achievement_url' ] = $achievement_url;
			case 'achievement_margin': $tags[ 'achievement_margin' ] = $achievement_margin;
			break;
		}
	}
	wp_reset_postdata();
	$content = artempol_tags_replace( $template, $tags );
	return $content;
}

function artempol_get_posts( $template, $args, $tags ) {

	$defaults = array(
		'posts_per_page'   => 10,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'post',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'author'	   => '',
		'post_status'      => 'publish',
		'suppress_filters' => true,
	);
	
	$args = wp_parse_args( $args, $defaults );

	if ( $posts = get_posts( $args ) ) {
		$counter = 0;
		$buffer = '';
		$output = '';
		$count_posts = count( $posts );
		
		foreach ( $posts as $obj_post ) {
			$counter++;
			$tags[ 'counter' ] = $counter;
			$buffer .= artempol_get_post( $obj_post, $template, $tags );
		}
		$output = $buffer;
		return $output;
	}
	else return false;
}

function artempol_get_comments( $post_id, $template, $template_tags ) {
	$comments = get_comments( array ( 'post_id' => $post_id, 'status' => 'approve' ) );
	
	foreach ( $comments as $comment ) {
		$name = $comment->comment_author;
		$date = date( 'm.d.Y', strtotime( $comment->comment_date ) );
		$info = $date;
		
		if ( $name ) {
			$info .= ', ' . $name;
		}
		
		foreach( $template_tags as $tag ) {
			
			switch ( $tag ) {				
				case 'content': $tags[ 'content' ] = $comment->comment_content;
				case 'info': $tags[ 'info' ] = $info;
				break;
			}
		}
	}
	$comment = artempol_tags_replace( $template, $tags );
	return $comment;
}


function artempol_slides( $template, $args ) {

	$defaults = array(
		'posts_per_page'   => 10,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'post',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'author'	   => '',
		'post_status'      => 'publish',
		'suppress_filters' => true,
	);
	
	$args = wp_parse_args( $args, $defaults );

	if ( $posts = get_posts( $args ) ) {
		
		$slides = '';
		$tags = array();
		
		foreach ( $posts as $obj_post ) {
			global $post;
			$post = $obj_post;
			setup_postdata( $post );
			
			$link = get_post_meta( $post->ID, 'link', true );
			$text = artempol_set_content( 'span', array( 'content' => get_the_title(), 'class' => 'first' ) ) .
					artempol_set_content( 'span', array( 'content' => get_the_content(), 'class' => 'second' ) );
					
			if ( $link ) {
				$text = '<a href="' . $link . '">' . $text . '</a>';
			}
			
			$tags[ 'image_url' ] = wp_get_attachment_url( get_post_thumbnail_id() );
			$tags[ 'text' ] = $text;

			wp_reset_postdata();
			$slides .= artempol_tags_replace( $template, $tags );
		}
	}
	return $slides;
}

/** 
* All sites functions
*/

// Set breadcrumbs
function artempol_breadcrumbs( $delimiter = '', $a_class = '', $before_cur = '', $after_cur = '', $before_a = '', $after_a = '' ) {
	
	$a_class != '' ? ( $class = ' class="' . $a_class . '"' ) : ( $class = '' );	
	$crumbs = '<a' . $class . ' href="' . esc_url( home_url() ) . '">' . __( 'Главная' ) . '</a>';	
	$crumbs .= $delimiter;
	
	if ( is_single() || is_category() || is_tax() ) {	
		global $taxonomy;	
		global $wp_query;	
		
		if ( ! $taxonomy ) {			
			$taxonomy = 'category';
		}
		
		if ( is_single() ) {	
			$parent_slugs = ( $taxonomy == 'category' ) ? explode( '/', $wp_query->query_vars[ 'category_name' ] ) : explode( '/', $wp_query->query_vars[ $taxonomy ] );
			
			if ( $parent_slugs ) {

				foreach ( $parent_slugs as $parent_slug ) {
					$parent = get_term_by( 'slug', $parent_slug, $taxonomy );
					
					if ( $parent ) {
						$crumbs .= '<a' . $class . ' href="' . get_term_link( $parent->term_id, $taxonomy ) . '">' . $parent->name . '</a>';
						$crumbs .= $delimiter;
					}
				}
			}
			
			$crumbs .= $before_cur . get_the_title() . $after_cur;
		}
		
		else {
			$taxonomy_obj = get_taxonomy( $taxonomy );	
			$taxonomy_labels = $taxonomy_obj->labels;		
			$term = get_queried_object();
			
			$crumbs .= '<a' . $class . ' href="/' . $taxonomy . '/">' . $taxonomy_labels->name . '</a>';
			$crumbs .= $delimiter;
			
			if ( $term ) {
				$parents = array();
				$current_term = $term;

				while ( $current_term->parent !== 0 ) {
					$current_term = get_term( $current_term->parent, $taxonomy );
					array_push( $parents, $current_term );
				}

				if ( $parents ) {		
					$parents = array_reverse( $parents );
						
					foreach ( $parents as $parent ) {						
						$crumbs .= '<a' . $class . ' href="' . get_term_link( $parent->term_id, $taxonomy ) . '">' . $parent->name . '</a>';				
						$crumbs .= $delimiter;
					}
				}

				$crumbs .= $before_cur . $term->name . $after_cur;		
			}				
		}
	}
	
	if ( is_page() ) {		
		$parent_ids = get_ancestors( get_the_ID(), 'page' );
		
		if ( $parent_ids ) {
			$parent_ids = array_reverse( $parent_ids );
			
			foreach ( $parent_ids as $parent_id ) {
				$crumbs .= '<a' . $class . ' href="' . get_permalink( $parent_id ) . '">' . get_the_title( $parent_id ) . '</a>';
				$crumbs .= $delimiter;
			}
		}
	
		$crumbs .= $before_cur . get_the_title() . $after_cur;
	}
	
	return $crumbs;	
}

// Get custom posts
function artempol_get_term_custom_posts( $post_type, $taxonomy = '', $term = '' ) {
	
	$custom_posts = get_posts( 	
		array( 
			'post_type' => $post_type,
			'tax_query' => array(	
				array( 
					'taxonomy' => $taxonomy, 
					'field' => 'id', 
					'terms' => $term 
				) 
			) 
		) 
	); 
					
	return $custom_posts;	
}

// Children pages navigation
function artempol_children_pages( $id, $args = '' ) {		
	$children = get_posts( 
		array(
			'post_parent' => $id,
			'post_type'   => 'page', 
			'orderby' 	=> 'menu_order',
			'order' => 'ASC'
		)
	);
	return $children;
}

/** 
* Admin section
*/

// Revisions number
add_filter( 'wp_revisions_to_keep', 'set_revisions_number' );
function set_revisions_number( $revisions ) {
    return 0;
}

// Editor formats
add_filter( 'tiny_mce_before_init', 'artempol_mce_before_init' );
function artempol_mce_before_init( $settings ) {

    $style_formats = array(
        array(
            'title' => 'PDF file',
            'selector' => 'a',
            'classes' => 'file icon-file-pdf'
        ),
        array(
            'title' => 'DOC file',
            'selector' => 'a',
            'classes' => 'file icon-file-word'
        ),
        array(
            'title' => 'Excel file',
            'selector' => 'a',
            'classes' => 'file icon-file-excel'
        ),
        array(
            'title' => 'Archive file',
            'selector' => 'a',
            'classes' => 'file icon-file-archive'
        ),

        array(
            'title' => '2 columns',
            'selector' => 'li, p',
            'classes' => 'column col_1_2'
        ),        
        array(
            'title' => '3 columns',
            'selector' => 'li, p',
            'classes' => 'column col_1_3'
        ),
        array(
            'title' => '4 columns',
            'selector' => 'li, p',
            'classes' => 'column col_1_4'
        ),      
        
        array(
            'title' => '1-й цвет текста',
            'selector' => 'p',
            'classes' => 'textcolor_1'
        ),  
        
        array(
            'title' => '2-й цвет текста',
            'selector' => 'p',
            'classes' => 'textcolor_2'
        ), 
        
        array(
            'title' => '3-й цвет текста',
            'selector' => 'p',
            'classes' => 'textcolor_3'
        ),  
        
        array(
            'title' => '4-й цвет текста',
            'selector' => 'p',
            'classes' => 'textcolor_4'
        ),   
        
        array(
            'title' => 'без обтекания',
            'selector' => 'p, h2, h3, h4',
            'classes' => 'clear'
        ), 
        
        array(
            'title' => 'кнопка 2-го цвета',
            'selector' => 'a',
            'classes' => 'button color_2'
        ), 
        
        array(
            'title' => 'кнопка 3-го цвета',
            'selector' => 'a',
            'classes' => 'button color_3'
        ), 
        
        array(
            'title' => 'ссылка со стрелкой',
            'selector' => 'a',
            'classes' => 'arrow'
        ), 
    );

    $settings[ 'style_formats' ] = json_encode( $style_formats );

    return $settings;
}

?>
