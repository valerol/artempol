<?php

get_header();

$branch = get_query_var( 'branches' );

$doctors = get_posts( 
	array( 
		'post_type' => 'doctor', 
		'tax_query' => 
			array(	
				array( 
					'taxonomy' => 'branches', 
					'field' => 'id', 
					'terms' => $branch ) ) ) ); 

if ( $doctors ) { 
	foreach( $doctors as $post ) { 
		setup_postdata( $post ); ?>

		<h2><?php the_title(); ?></h2>		


<?php 
	}
	wp_reset_postdata();
}

get_footer(); ?> 
