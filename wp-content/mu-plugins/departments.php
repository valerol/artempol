<?php
add_action( 'init', 'department_registers' );
add_filter( 'wpcf7_form_hidden_fields', 'question_form_hidden_field' );

function department_registers() {
// Таксономия "Отделения"	
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
	register_taxonomy( 'department', array ( 'question', 'doctor', 'post' ), $b_args );
// Тип поста "Вопросы"
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
// Тип поста "Сотрудники"
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

// Сохраняем профиль врача или вопрос в общий раздел, если отделение не указано
add_action( 'save_post', 'set_default_term', 100, 2 );
function set_default_term( $post_id, $post ) {	
	$post_types = array( 'doctor', 'question' );
	$taxonomy = 'department';

	if ( in_array( $post->post_type, $post_types ) ) {

		if ( 'publish' === $post->post_status ) {
			$terms = wp_get_post_terms( $post_id, $taxonomy );

			if ( empty( $terms ) ) {
				wp_set_object_terms( $post_id, 'departments', $taxonomy );
			}
		}
	}
}

// Добавление скрытого поля формы вопроса
function question_form_hidden_field( $array ) {    
    
    global $post;
    $array[ 'post_name' ] = $post->post_name;
    
    return $array; 
}; 

// При отправке формы вопроса
function insert_question( $question_form ) {
	
	$submission = WPCF7_Submission::get_instance();

	if ( $submission ) {
		$posted_data = $submission->get_posted_data();
	}

    if ( $posted_data[ 'checktype' ] == 'question' ) {
         $taxonomy = 'department';
         $term = get_term_by( 'slug', $posted_data[ 'post_name' ], $taxonomy );
         $term_id = $term->term_id;
         // Создание пользователя - автора вопроса
         if ( $posted_data[ 'your-email' ] ) {
             $user_email = $posted_data[ 'your-email' ];
             $user_name = $posted_data[ 'your-name' ];
             $user_id = email_exists( $user_email );

             if ( !$user_id and email_exists( $user_email ) == false ) {
                 $random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
                 $user_id = wp_create_user( $user_name, $random_password, $user_email );
             }
         }
         $question = $posted_data[ 'your-question' ];
         
         // Добавление вопроса
         $question_id = wp_insert_post( array(
           'post_content' => '',
           'post_type' => 'question',
           'post_title' => $user_name,
           'post_excerpt' => $question,
           'post_author' => $user_id ) );
         wp_set_object_terms( $question_id, $term_id, $taxonomy );
         
         // Уведомление специалисту
         $doctors = get_posts( array(
             'post_type' => 'doctor',
             'tax_query' => array(
                 array(
                     'taxonomy' => $taxonomy,
                     'field' => 'id',
                     'terms' => $term_id
                 ) ) ) );
         if ( $doctors ) {

			if ( $posted_data[ 'post_name' ] == 'departments' ) {
				$page_url = get_site_url() . '/departments';
			}
			else $page_url = get_site_url() . '/departments/' . $posted_data[ 'post_name' ];
			
			$emails = array();
			$subject = 'Вопрос с сайта ' . get_site_url();
			$message = $posted_data[ 'your-name' ] . ' оставил(а) вопрос на странице: ' . $page_url;
			$headers = 'From: ' . get_bloginfo() . ' <no-reply@' . $_SERVER[ 'SERVER_NAME' ] . '>' . "\r\n";

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
add_filter( 'wpcf7_before_send_mail', 'insert_question' );

// Уведомление автору вопроса про ответе и публикации вопроса
function question_published_notification( $post_id ) {
     $post = get_post( $post_id );

     if ( $post->post_type == 'question' ) {

         if ( $post->post_content != '' || $post->post_status == 'publish' ) {
             $author_id = $post->post_author;
             $author = get_user_by( 'id', $author_id );
             $email = $author->user_email;
             $name = $post->post_title;
             $link = get_the_permalink( $post->ID );
             $subject = 'Ответ на Ваш вопрос на сайте ' . get_bloginfo() . ' опубликован';
             $message = 'Здравствуйте, ' . $name . '! Ответ на Ваш вопрос опубликован на странице: ' . $link;
             $headers = 'From: ' . get_bloginfo() . ' <no-reply@' . $_SERVER[ 'SERVER_NAME' ] . '>' . "\r\n";
             wp_mail( $email, $subject, $message, $headers );
         }
     }
}
add_action( 'save_post', 'question_published_notification', 10, 2 );

// Постоянные ссылки страниц с вопросами и докторами
function ra_permalinks( $url, $post ) {
     $post_types = array( 'doctor', 'question' );
     $taxonomy = 'department';
     $default_term_slug = 'departments';

     if ( in_array( $post->post_type, $post_types ) ) {
         $terms = get_the_terms( $post->ID, $taxonomy );
         $term = $terms[ 0 ];
     }

     if ( !$term or $term->slug == $default_term_slug ) {
         $url = home_url() . '/' . $default_term_slug;
     }
     else $url = home_url() . '/' . $default_term_slug . '/' . $term->slug;

     return $url;
}
add_filter( 'post_type_link', 'ra_permalinks', 10, 2 );


// Колонки списка вопросов
function ra_question_columns( $columns ) {

	$new_columns = array(
		'cb' => 'cb',
		'title' => __( 'Name', 'artempol' ),
		'excerpt-custom' => __( 'Question', 'artempol' ),
		'term' => __( 'Department', 'artempol' ),
		'author' => __( 'E-mail', 'artempol' ),
		'date' => __( 'Date', 'artempol' ),
	);
    return $new_columns;
}
add_filter( 'manage_edit-question_columns' , 'ra_question_columns' );

// Колонки списка врачей
function ra_doctor_columns( $columns ) {

	$new_columns = array(
		'cb' => 'cb',
		'title' => __( 'Name', 'artempol' ),
		'excerpt-custom' => __( 'Position', 'artempol' ),
		'term' => __( 'Department', 'artempol' ),
		'author' => __( 'User', 'artempol' ),
	);
    return $new_columns;
}
add_filter( 'manage_edit-doctor_columns' , 'ra_doctor_columns' );

// Данные колонок списка вопросов
function ra_posts_custom_column( $column_name, $post_id ) {
	$post = get_post( $post_id );
	$taxonomy = 'department';
	setup_postdata( $post );
	
	switch ( $column_name ) {
		case 'excerpt-custom':
			$excerpt = get_the_excerpt();
			if ( $excerpt ) {
				echo $excerpt;
			}
			break;
		case 'term':
			$terms = get_the_term_list( $post_id, $taxonomy, '', ', ' );
			if ( !empty( $terms ) ) {
				echo $terms;
			}
			break;
	}
	wp_reset_postdata();
}
add_action( 'manage_posts_custom_column' , 'ra_posts_custom_column', 10, 2 );

// Названия поля excerpt для кастомных типов постов
function ra_metaboxes( $post_type, $post ) {
     global $wp_meta_boxes;
     $wp_meta_boxes[ 'question' ][ 'normal' ][ 'core' ][ 'postexcerpt' ][ 'title' ] = __( 'Question', 'artempol' );
     $wp_meta_boxes[ 'doctor' ][ 'normal' ][ 'core' ][ 'postexcerpt' ][ 'title' ] = __( 'Position', 'artempol' );
}
add_action( 'add_meta_boxes', 'ra_metaboxes', 10, 2 );

?>
