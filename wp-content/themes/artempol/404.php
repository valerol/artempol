<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); 

echo artempol_container( array( 'tag' => 'p', 'content' => __( 'It looks like nothing was found at this location.', 'artempol' ) ) ); 

get_footer();
