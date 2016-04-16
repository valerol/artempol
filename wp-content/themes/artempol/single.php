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

// End the loop.
endwhile;

get_footer(); ?>
