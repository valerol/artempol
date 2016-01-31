<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); 

?>

<script>

jQuery( document ).ready( function() {

	jQuery( 'a.lic_gallery' ).colorbox( { 

		rel:'lic_gallery', 

		previous:'<span class="sc_icon icon-left"></span>', 

		next:'<span class="sc_icon icon-right"></span>', 

		close:'<span class="sc_icon icon-cancel"></span>',

		current:''

	} );

} );

</script>

<?php $licenses = get_posts( array ( 'post_type' => 'achievements', 'category_name' => 'licenses' ) ); ?>

<?php if ( $licenses ) { 
		//the loop
		foreach( $licenses as $post ) {
	
			setup_postdata( $post ); 

			echo '<h2>';
			the_title();
			echo '</h2>';
			
			// get images
			$images = get_attached_media( 'image', $post->ID );
			// get pdfs
			$pdfs = get_attached_media( 'application/pdf', $post->ID );
			
			// show images
			if ( $images ) {
				
				echo '<div class="lic_images">';
				
				foreach ( $images as $post ) {
					setup_postdata( $post );
					echo '<a class="lic_gallery" href="'  . $post->guid	. '"><img src="' . image_downsize( $post->ID, 'medium' )[ 0 ] . '"></a>';
				}
				wp_reset_postdata();
				
				echo '</div>';
			}
			
			// show pdfs
			if ( $pdfs ) {
				
				foreach ( $pdfs as $post ) {
					setup_postdata( $post ); 
					echo '<span class="sc_icon icon-file-pdf"></span>';
					echo '<a href="'  . $post->guid	. '">Скачать в формате PDF</a>';
				}
				wp_reset_postdata();
			}
		}
	
		wp_reset_postdata();
	
	// Previous/next page navigation.
	the_posts_pagination( array(
		'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
		'next_text'          => __( 'Next page', 'twentyfifteen' ),
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
	) );			
}

// If no content, include the "No posts found" template.
else {
	get_template_part( 'content', 'none' );

}
?>
		
<?php get_footer(); ?>
