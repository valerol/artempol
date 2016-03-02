<?php

get_header();

$taxonomy = '';

$term = get_query_var( $taxonomy );

$posts = get_posts( 
	array(
		'tax_query' => 
			array(	
				array( 
					'taxonomy' => $taxonomy, 
					'field' => 'id', 
					'terms' => $term ) ) ) ); 

if ( $posts ) { 
	foreach( $posts as $post ) { 
		setup_postdata( $post ); ?>

		<h2><?php the_title(); ?></h2>		


<?php 
	}
	wp_reset_postdata();
}

get_footer(); ?> 
