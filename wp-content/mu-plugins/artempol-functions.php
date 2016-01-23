<?php

// Количество хранимых редакций поста
add_filter( 'wp_revisions_to_keep', 'set_revisions_number' );

function set_revisions_number( $revisions ) {
    return 0;
}

function artempol_add_script_function() {
	/** 
	* Enqueue css
	*/
	wp_enqueue_style( 'artempol-style', get_stylesheet_uri() );
	wp_enqueue_style( 'skin-style' , get_template_directory_uri() . '/css/skin.css');
	wp_enqueue_style( 'responsive-style' , get_template_directory_uri() . '/css/responsive.css');
	wp_enqueue_style( 'jssor-style' , get_template_directory_uri() . '/css/jssor.css');
	wp_enqueue_style( 'shortcodes-style' , get_template_directory_uri() . '/css/shortcodes.css');
	wp_enqueue_style( 'fontello-style' , get_template_directory_uri() . '/css/fontello/css/fontello.css');
	wp_enqueue_style( 'fontosc-style', 'https://fonts.googleapis.com/css?family=Open+Sans+Condensed:700&subset=latin,cyrillic' );
	wp_enqueue_style( 'fontos-style', 'https://fonts.googleapis.com/css?family=Open+Sans:700&subset=latin,cyrillic' );

	/** 
	 * Enqueue javascripts
	 */
	wp_enqueue_script( 'slider', get_template_directory_uri() . '/js/jssor.slider.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.min.js', array( 'jquery' ) );

}

add_action('wp_enqueue_scripts','artempol_add_script_function');


// Тип поста и таксономия раздела "Вопрос доктору"
add_action( 'init', 'register_questions' );
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
	register_taxonomy( 'branches', array ( 'question', 'doctor' ), $b_args );

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
		'menu_icon' => 'dashicons-welcome-learn-more',
		'supports' => array( 'title', 'editor', 'excerpt', 'author' ),
		'taxonomies' => array( 'branches' ),
	);
	register_post_type( 'question', $q_args );
	
	$d_args = array(
		'labels' => array(		
			'name' => 'Доктора',
			'singular_name' => 'Доктор',
			'menu_name' => 'Доктора',
			'name_admin_bar' => 'Доктора',
			'all_items' => 'Доктора',
			'add_new' => 'Добавить доктора',
			'add_new_item' => 'Добавить доктора',
			'edit_item' => 'Редактировать доктора',
			'new_item' => 'Новый доктор',
			'view_item' => 'Посмотреть страницу',
			'search_items' => 'Фильтр страниц',
		),
		'description' => 'Страницы докторов',
		'public' => true,
		'menu_icon' => 'dashicons-welcome-learn-more',
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
		'taxonomies' => array( 'branches' ),
	);
	register_post_type( 'doctor', $d_args );
}

// Тип записи рубрики "Грамоты и благодарности (Наши достижения)"
add_action( 'init', 'register_certificates' );
function register_certificates() {
	
	$p_args = array(
		'labels' => array(		
			'name' => 'Награды',
			'singular_name' => 'Награда',
			'menu_name' => 'Награды',
			'name_admin_bar' => 'Награды',
			'all_items' => 'Награды',
			'add_new' => 'Добавить награду',
			'add_new_item' => 'Добавить новую награду',
			'edit_item' => 'Редактировать награду',
			'new_item' => 'Новая награда',
			'view_item' => 'Посмотреть награду',
			'search_items' => 'Фильтр наград',
			'not_found' => 'Наград не найдено',
			'not_found_in_trash' => 'В корзине наград не найдено',
		),
		'public' => true,
		'menu_icon' => 'dashicons-awards',
		'supports' => array( 'title', 'excerpt', 'thumbnail' ),
		'taxonomies' => array( 'category' ),
		'has_archive' => true,
		'rewrite' => array ( 
			'slug' => '%category%',
		),
	);
	
	register_post_type( 'achievements', $p_args );
	flush_rewrite_rules();
	
}



add_filter( 'post_type_link', 'artempol_permalinks', 10, 3 );
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


add_filter( 'wpcf7_posted_data', 'insert_question' );

function insert_question( $posted_data ) {
	
	if ( $posted_data[ 'checktype' ] == 'question' ) {
		
		$post = array(
		  'post_content'   => '',
		  'post_type'      => 'question',
		  'post_title'   => $posted_data[ 'name' ],
		  'post_excerpt'   => $posted_data[ 'question' ],
		);  
	
		wp_insert_post( $post );
		
		$WPCF7_ContactForm->mail['recipient'] = "xolepa83@ya.ru";
	
	}
	
	return $posted_data; 
}

add_action( 'wpcf7_before_send_mail', 'mail_doctor' );

function mail_doctor( $contact_form ) {
	
	$template = $contact_form->prop( 'mail' );
	$template[ 'recipient' ] = 'xolepa83@ya.ru';	
	WPCF7_Mail::send( $template, 'mail' );
}

// Хлебные крошки
function artempol_breadcrumbs( $taxonomy = 'category', $delimiter = '', $a_class = '', $cur_before = '', $cur_after = '', $before = '', $after = '' ) {
	
	$a_class != '' ? $class = ' class="' . $a_class . '"' : $class = '';
	
	$crumbs = '<a' . $class . ' href="' . esc_url( home_url() ) . '">' . __( 'Home', 'healthandcare' ) . '</a>';
	
	$crumbs .= $delimiter;
	
	if ( is_single() ) {
	
		$parent_slugs = explode( '/', $wp_query->query_vars[ $taxonomy ] );
		
		if ( $parent_slugs ) {

			foreach ( $parent_slugs as $parent_slug ) {

				$parent = get_term_by( 'slug', $parent_slug, $taxonomy );

				$crumbs .= '<a' . $class . ' href="' . get_term_link( $parent->term_id, $taxonomy ) . '">' . $parent->name . '</a>';

				$crumbs .= $delimiter;
			}
		}

		$crumbs .= $cur_before . the_title() . $cur_after;
	}

	else {

		$term = get_queried_object();

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
	
	return $crumbs;	
}

?>
