<?php

// Количество хранимых редакций поста
add_filter( 'wp_revisions_to_keep', 'set_revisions_number' );
add_filter( 'post_type_link', 'artempol_permalinks', 10, 3 );
add_filter( 'wpcf7_posted_data', 'insert_question' );
add_filter( 'wpcf7_form_hidden_fields', 'question_form_term' );
add_filter( 'tiny_mce_before_init', 'artempol_mce_before_init' );

add_action('wp_enqueue_scripts','artempol_add_script_function');
add_action( 'init', 'register_questions' );
//add_action( 'init', 'flush_rewrite_rules' );

function set_revisions_number( $revisions ) {
    return 0;
}

function artempol_add_script_function() {
	/** 
	* Enqueue css
	*/
	wp_enqueue_style( 'artempol-style', get_stylesheet_uri() );
	wp_enqueue_style( 'skin-style' , get_template_directory_uri() . '/css/skin.css' );
	wp_enqueue_style( 'responsive-style' , get_template_directory_uri() . '/css/responsive.css' );
	wp_enqueue_style( 'skin-responsive-style' , get_template_directory_uri() . '/css/skin.responsive.css' );
	wp_enqueue_style( 'jssor-style' , get_template_directory_uri() . '/css/jssor.css' );
	wp_enqueue_style( 'shortcodes-style' , get_template_directory_uri() . '/css/shortcodes.css' );
	wp_enqueue_style( 'fontello-style' , get_template_directory_uri() . '/css/fontello/css/fontello.css' );
	wp_enqueue_style( 'fontosc-style', 'https://fonts.googleapis.com/css?family=Open+Sans+Condensed:700&subset=latin,cyrillic' );
	wp_enqueue_style( 'fontos-style', 'https://fonts.googleapis.com/css?family=Open+Sans:700&subset=latin,cyrillic' );
	wp_enqueue_style( 'animation-style' , get_template_directory_uri() . '/css/animation.css' );
	wp_enqueue_style( 'swiper' , get_template_directory_uri() . '/css/swiper.css' );
	wp_enqueue_style( 'colorbox' , get_template_directory_uri() . '/libs/colorbox/colorbox.css' );
	/** 
	 * Enqueue javascripts
	 */
	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/libs/colorbox/jquery.colorbox-min.js', array( 'jquery' ) );
	wp_enqueue_script( 'wow', get_template_directory_uri() . '/js/wow.js', array( 'jquery' ) );
	wp_enqueue_script( 'cs', get_template_directory_uri() . '/js/shortcodes.js', array( 'jquery' ) );
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/js/swiper.jquery.js', array( 'jquery' ) );
	wp_enqueue_script( 'init', get_template_directory_uri() . '/js/init.js', array( 'jquery' ) );

}

// Типы постов и таксономия раздела "Вопрос доктору"
function register_questions() {
	
	$b_args = array(
		'labels' => array(		
			'name' => 'Отделения',
			'singular_name' => 'Отделение',
			'menu_name' => 'Отделения',
			'all_items' => 'Отделения',
			'edit_item' => 'Редактировать отделение',
			'view_item' => 'Посмотреть отделение',
			'update_item' => 'Обновить отделение',
			'add_new_item' => 'Добавить отделение',
			'new_item_name' => 'Название отделения',
			'add_or_remove_items' => 'Добавить или удалить отделение',
		),
		'public' => true,
		'hierarchical' => true,
		'meta_box_cb' => 'post_categories_meta_box', 
	);	
	register_taxonomy( 'department', array ( 'question', 'doctor' ), $b_args );

	$q_args = array(
		'labels' => array(		
			'name' => 'Вопросы',
			'singular_name' => 'Вопрос',
			'menu_name' => 'Вопросы',
			'name_admin_bar' => 'Вопросы',
			'all_items' => 'Вопросы',
			'add_new' => 'Добавить вопрос',
			'add_new_item' => 'Добавить новый вопрос',
			'edit_item' => 'Редактировать вопрос',
			'new_item' => 'Новый вопрос',
			'view_item' => 'Посмотреть вопрос',
			'search_items' => 'Фильтр вопросов',
			'not_found' => 'Вопросов не найдено',
			'not_found_in_trash' => 'В корзине вопросов не найдено',
		),
		'description' => 'Вопросы сотрудникам от посетителей сайта',
		'public' => true,
		'menu_icon' => 'dashicons-lightbulb',
		'supports' => array( 'title', 'editor', 'excerpt', 'author' ),
		'taxonomies' => array( 'department' ),
	);
	register_post_type( 'question', $q_args );
	
	$d_args = array(
		'labels' => array(		
			'name' => 'Сотрудники',
			'singular_name' => 'Сотрудник',
			'menu_name' => 'Сотрудники',
			'name_admin_bar' => 'Сотрудники',
			'all_items' => 'Сотрудники',
			'add_new' => 'Добавить сотрудника',
			'add_new_item' => 'Добавить сотрудника',
			'edit_item' => 'Редактировать страницу сотрудника',
			'new_item' => 'Новый сотрудник',
			'view_item' => 'Посмотреть страницу сотрудника',
			'search_items' => 'Фильтр страниц',
		),
		'description' => 'Страницы докторов',
		'public' => true,
		'menu_icon' => 'dashicons-businessman',
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
		'taxonomies' => array( 'department' ),
	);
	register_post_type( 'doctor', $d_args );
}

// Постоянные ссылки кастомных типов записей
function artempol_permalinks( $permalink, $post ) {
	 
	if ( $permalink && $post->post_type == 'achievements' ) {		 
		
		if ( !$categories = get_the_category( $post->ID ) ) {
			$category = get_category_by_slug ( 'uncategorized' );
		}
		
		else {
			$category = $categories['0'];
		}

	$permalink = get_category_link( $category->term_id ) . $post->post_name;
	}
	
	return $permalink;
}

// Добавление вопроса при отправке формы
function insert_question( $posted_data ) {
	
	if ( $posted_data[ 'checktype' ] == 'question' ) {		
		
		$taxonomy = $posted_data[ 'taxonomy' ];		
		$term_id = $posted_data[ 'term' ];		
		$doctors = artempol_get_term_custom_posts( 'doctor', $taxonomy, $term_id );
		$post = array(
		  'post_content'   => '',
		  'post_type'      => 'question',
		  'post_title'   => $posted_data[ 'name' ],
		  'post_excerpt'   => $posted_data[ 'question' ],
 		  'tax_input' => array( $posted_data[ 'taxonomy' ] => $posted_data[ 'term' ] ),
		); 	
		
		wp_insert_post( $post );		
		
		if ( $doctors ) {
			
			$emails = array();	
			$subject = 'Вопрос с сайта ' . get_site_url();		
			$message = 'Кто-то оставил вопрос на странице: ' . get_term_link( intval($term_id), $taxonomy );		
			$headers = 'From: ' . get_bloginfo() . ' <no-reply@' . $_SERVER['SERVER_NAME'] . '>' . "\r\n";			
			
			foreach ( $doctors as $post ) {				
				setup_postdata( $post );				
				$author = get_user_by( 'login', get_the_author() );				
				$author_email = $author->user_email;				
				array_push( $emails, $author_email );
			}			
			
			wp_reset_postdata();
			
			wp_mail( $emails, $subject, $message, $headers );
		}			
	}	
	return $posted_data; 
}

// Добавление скрытого поля раздела
function question_form_term( $array ) {    
    
    global $taxonomy;    
    global $term;    
    $array[ 'taxonomy' ] = $taxonomy;    
    $array[ 'term' ] = $term->term_id;
    
    return $array; 
}; 

// Хлебные крошки
function artempol_breadcrumbs( $delimiter = '', $a_class = '', $cur_before = '', $cur_after = '', $before = '', $after = '' ) {
	
	$a_class != '' ? ( $class = ' class="' . $a_class . '"' ) : ( $class = '' );	
	$crumbs = '<a' . $class . ' href="' . esc_url( home_url() ) . '">' . __( 'Home', 'healthandcare' ) . '</a>';	
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
			
			$crumbs .= $cur_before . get_the_title() . $cur_after;
		}
		
		else {
			$term = get_queried_object();
			
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
						$crumbs .= '<a' . $class . ' href="' . get_term_link( $parent->term_id, $taxonomy ) . '">' . $parent->name . '</a></li><li class="separator"> / </li><li>';				
						$crumbs .= $delimiter;
					}
				}

				$crumbs .= $cur_before . $term->name . $cur_after;		
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
	
		$crumbs .= $cur_before . get_the_title() . $cur_after;
	}
	
	return $crumbs;	
}

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
            'title' => 'Iconed list',
            'selector' => 'li',
            'classes' => 'sc_list_icon icon-checkbox'
        ),
        array(
            'title' => '2 columns',
            'selector' => 'li, p, div',
            'classes' => 'column-1_2 columns'
        ),        
        array(
            'title' => '3 columns',
            'selector' => 'li, p, div',
            'classes' => 'column-1_3 columns'
        ),
        array(
            'title' => '4 columns',
            'selector' => 'li, p, div',
            'classes' => 'column-1_4 columns'
        ),        
    );

    $settings[ 'style_formats' ] = json_encode( $style_formats );

    return $settings;
}

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

?>
