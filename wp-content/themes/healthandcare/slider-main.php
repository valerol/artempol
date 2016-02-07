<?php global $slides; ?>

<!-- Slider main container -->
<div class="swiper-container main-slider" style="height: 570px;">
	<!-- Additional required wrapper -->
	<div class="slides swiper-wrapper">
	
		<?php foreach( $slides as $slide ) : ?>	
			
			<div class="swiper-slide" style="background-image: url( <?php echo $slide[ 'image' ] ?> ); background-position: center top; background-size: auto 100%" >
				
				<div class="content_wrap">
					<div class="slider_title"><?php echo $slide[ 'title' ]; ?></div>
					<div class="slider_description"><?php echo $slide[ 'description' ]; ?></div>
					<?php if ( $slide[ 'link' ] ) $link = explode( '|', $slide[ 'link' ] ); ?>
					
					<?php if ( isset( $link[ 0 ] ) && isset( $link[ 1 ] ) ) : ?>
						<a class="sc_button sc_button_square sc_button_style_filled sc_button_bg_link sc_button_size_large  sc_button_iconed icon-right-2" href="<?php echo $link[ 1 ]; ?>"><?php echo $link[ 0 ]; ?></a>
					<?php endif; ?>
				</div>
			
			</div>
		<?php endforeach; ?>
	
	</div>
	<!-- If we need pagination -->
	<div class="content_wrap">
		<div class="swiper-pagination"></div>
	</div>
	
	<!-- If we need navigation buttons -->
	<div class="swiper-button-prev tp-leftarrow tparrows custom noSwipe"></div>
	<div class="swiper-button-next tp-rightarrow tparrows custom noSwipe"></div>
	
	<!-- If we need scrollbar -->
	<div class="swiper-scrollbar"></div>

</div>

