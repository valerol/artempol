<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

<p><?php _e( 'К сожалению, эта страница не существует или переехала. Попробуйте воспользоваться поиском.' ); ?></p>

<?php get_search_form(); ?>

<?php get_footer(); ?>
