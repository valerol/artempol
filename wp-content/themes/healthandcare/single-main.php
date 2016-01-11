<?php
/*
Template Name: Main page
*/

get_header(); 

while( have_posts() ) { 
    the_post();
	?>
    
	<article class="main clearfix">
		<div class="column-1_2 left">
		<?php the_post_thumbnail( 'thumb' ); ?>
		<h1 class="sc_title sc_title_iconed"><?php the_title(); ?></h1>
		</div>
		<div class="column-1_2 right">
		<?php the_content(); ?>
		</div>
	</article>
<?php 
} 

// Frontpage sidebar

$sidebar_name = 'sidebar_frontpage';

if ( is_active_sidebar( $sidebar_name ) ) { ?>
	
<?php
	$HEALTHANDCARE_GLOBALS[ 'current_sidebar' ] = 'services';

	$active_services = true;
	
	ob_start();
	do_action( 'before_sidebar' );

	if ( ! dynamic_sidebar( $sidebar_name ) ) {
		// Put here html if user no set widgets in sidebar
	}

	do_action( 'after_sidebar' );
	$out = ob_get_contents();
	ob_end_clean();
	echo trim( chop( preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $out ) ) );
} 

get_footer();

?>
