<?php
get_header(); 

if ( have_posts() ) {

	// Start the Loop.
	while ( have_posts() ) : the_post();

		/*
		 * Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
		 */
		get_template_part( 'news' );

		

	endwhile; // End the loop.
	
	// Previous/next page navigation.
	the_posts_pagination( array(
		'prev_text'          => __( 'Previous page', 'artempol' ),
		'next_text'          => __( 'Next page', 'artempol' ),
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'artempol' ) . ' </span>',
	) );
}
// If no content, include the "No posts found" template.
else {	
	get_template_part( 'content', 'none' );
}

get_footer(); ?>
