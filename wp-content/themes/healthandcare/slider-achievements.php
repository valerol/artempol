<!-- Slider main container -->
<div class="swiper-container achievements" style="height: 312px;">
	<!-- Additional required wrapper -->
	<div class="slides swiper-wrapper">
			<?php if ( ot_get_option( 'achievements_page' ) ) $images = get_attached_media( 'image', ot_get_option( 'achievements_page' ) );  // get images ?>
			
			<?php if ( $images ) : // show images ?>

				<?php foreach ( $images as $post ) :  setup_postdata( $post ); ?>				
					<?php $image = image_downsize( $post->ID, 'medium' ); ?>
					<div class="swiper-slide">
						<a class="colorbox" href="<?php echo $post->guid ?>"><img src="<?php echo $image[ 0 ] ?>"></a>
					</div>	
				<?php endforeach; ?>
				
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>				
	</div>
	<!-- If we need pagination -->
	<div class="bullets bullets-achievements"></div>
	
	<!-- If we need navigation buttons -->
	<div class="swiper-button-prev tp-leftarrow tparrows custom noSwipe"></div>
	<div class="swiper-button-next tp-rightarrow tparrows custom noSwipe"></div>
	
	<!-- If we need scrollbar -->
	<div class="swiper-scrollbar"></div>

</div>
