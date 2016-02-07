<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<?php
		// Start the loop.
		while ( have_posts() ) : 
		
			the_post();
		
			$children = artempol_children_pages( get_the_id() ); ?>
			
			<ul>
			<?php
			foreach ( $children as $post ) :
				
				setup_postdata( $post ); ?>
				
				<li class="iconed parent-page icon-doc-text">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</li>
			<?php
			endforeach;
			wp_reset_postdata(); ?>
			</ul>
			
			<?php
			the_content();

		// End the loop.
		endwhile;
		?>
	</div><!-- .content-area -->

<?php get_footer(); ?>
