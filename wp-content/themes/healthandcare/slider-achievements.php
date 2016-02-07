<?php if ( $achievements = get_posts( array ( 'post_type' => 'achievements', 'category_name' => 'achievements' ) ) ) : ?>

	<!-- Slider main container -->
	<div class="swiper-container achievements" style="height: 312px;">
		<!-- Additional required wrapper -->
		<div class="slides swiper-wrapper">

			<?php foreach ( $achievements as $post ) : setup_postdata( $post ); ?>

				<div class="swiper-slide">

					<?php $images = get_attached_media( 'image', $post->ID );  // get images ?>
					
					<?php if ( $images ) : // show images ?>

						<?php foreach ( $images as $post ) :  setup_postdata( $post ); ?>
						
							<?php $images = image_downsize( $post->ID, 'medium' ); ?>

							<a class="colorbox" href="<?php echo $post->guid ?>"><img src="<?php echo $images[ 0 ] ?>"></a>

						<?php endforeach; ?>

						<?php wp_reset_postdata(); ?>

					<?php endif; ?>		

				</div>	

			<?php endforeach; ?>

			<?php wp_reset_postdata(); ?>

		</div>
		<!-- If we need pagination -->
		<div class="swiper-pagination"></div>
		
		<!-- If we need navigation buttons -->
		<div class="swiper-button-prev tp-leftarrow tparrows custom noSwipe"></div>
		<div class="swiper-button-next tp-rightarrow tparrows custom noSwipe"></div>
		
		<!-- If we need scrollbar -->
		<div class="swiper-scrollbar"></div>

	</div>

<?php endif; ?>
