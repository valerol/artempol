<?php

get_header(); 

// Start the loop.
while ( have_posts() ) {

	the_post();
	
	if ( $children = artempol_children_pages( get_the_id() ) ) {
		$children_list = '';
		
		foreach ( $children as $post ) {
			$children_list .= artempol_get_post( $post, 'list', array( 'link' ) );
		}
		$children = artempol_container( array( 'tag' => 'ul', 'content' => $children_list ) );
		echo $children;
	}

	if ( $content = apply_filters( 'the_content', get_the_content() ) ) {
		$content = artempol_container( array( 'tag' => 'div', 'content' => $content, 'class' => 'content' ) );
		echo $content;
	}
	
	// Departments pages
	if ( $term = get_term_by( 'slug', $post->post_name, 'department' ) ) {
		
		$doctors = '';
		$questions = '';
		$col_1 = '';
		$col_2 = '';
		$dep_content = '';
		$questions_heading = '';
		
		$doctors .= artempol_get_posts( 'doctor', 
			array( 
				'post_type' => 'doctor',
				'tax_query' => array(
					array(
						'taxonomy' => 'department',
						'field' => 'slug',
						'terms' => $term->slug
					) ) ),
			array( 'image', 'title', 'descriprion', 'content' ) );
			
		$questions .= artempol_get_posts( 'question', 
			array( 			
				'post_type' => 'question',
				'tax_query' => array(
					array(
						'taxonomy' => 'department',
						'field' => 'slug',
						'terms' => $term->slug
					) ) ),
			array( 'title', 'description', 'content', 'edit_link' ) );
		if ( $questions ) {
			 $questions = artempol_container( array( 'tag' => 'h2', 'content' => __( 'Questions', 'artempol' ) ) ) . $questions;
		}
			
		$col_1 = artempol_container( array( 'tag' => 'div', 'content' => $doctors . $questions, 'class' => 'column col_2_3' ) );
		
		if ( $question_form = do_shortcode( '[contact-form-7 id="1067" title="Question"]' ) ) {
			$question_form_title = artempol_container( array( 'tag' => 'h2', 'content' => __( 'Consultation', 'artempol' ), 'class' => 'form_title textwhite padding_tb_20 icon-user-md' ) );
			$col_2 = artempol_container( array( 'tag' => 'div', 'content' => $question_form_title . $question_form , 'class' => 'column col_1_3 question_form colored color_2' ) );
		}
		
		$dep_content = artempol_container( array( 'tag' => 'div', 'content' => $col_1 . $col_2, 'class' => 'department clearfix' ) );
		
		echo $dep_content;
	}

// End the loop.
}

get_footer(); 
?>
