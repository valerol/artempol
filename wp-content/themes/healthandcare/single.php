<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 */

get_header(); 

while ( have_posts() ) : the_post();

	the_title();
	
	the_content();

	// Previous/next post navigation.
	the_post_navigation( array(
		'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'healthandcare' ) . '</span> ' .
			'<span class="screen-reader-text">' . __( 'Next post:', 'twentyfifteen' ) . '</span> ' .
			'<span class="post-title">%title</span>',
		'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'healthandcare' ) . '</span> ' .
			'<span class="screen-reader-text">' . __( 'Previous post:', 'twentyfifteen' ) . '</span> ' .
			'<span class="post-title">%title</span>',
	) );

// End the loop.
endwhile;

get_footer(); ?>
