<script>
	jssor_1_slider_init = function() {
		
		var jssor_1_options = {
		  $AutoPlay: true,
		  $AutoPlaySteps: 1,
		  $SlideWidth: 270,
		  $Cols: 2,
		  $ArrowNavigatorOptions: {
			$Class: $JssorArrowNavigator$,
			$Steps: 1
		  },
		  $BulletNavigatorOptions: {
			$Class: $JssorBulletNavigator$,
			$SpacingX: 1,
			$SpacingY: 1
		  }
		};
		
		var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
	};
</script>
<div id="jssor_1" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 809px; height: 312px; overflow: hidden; visibility: hidden;">
	<!-- Loading Screen -->
	<div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
		<div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
		<div style="position:absolute;display:block;background:url('img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
	</div>
	<div data-u="slides" class="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 809px; height: 312px; overflow: hidden;">
		<?php $achievements = get_posts( array ( 'post_type' => 'achievements' ) ); ?>
		<?php foreach ( $achievements as $post ) : setup_postdata( $post ); ?>
		<div class="slide" style="display: none;">
			<?php the_post_thumbnail( 'medium' ); ?>
		</div>
		<?php endforeach; ?>
		<?php wp_reset_postdata(); ?>
	</div>
	<!-- Bullet Navigator -->
	<div data-u="navigator" class="jssorb03" style="bottom:10px;right:10px;">
		<!-- bullet navigator item prototype -->
		<div data-u="prototype" style="width:21px;height:21px;">
			<div data-u="numbertemplate"></div>
		</div>
	</div>
	<!-- Arrow Navigator -->
	<span data-u="arrowleft" class="jssora03l tp-leftarrow tparrows custom noSwipe" style="top:0px;left:8px;width:55px;height:55px;" data-autocenter="2"></span>
	<span data-u="arrowright" class="jssora03r tp-rightarrow tparrows custom noSwipe" style="top:0px;right:8px;width:55px;height:55px;" data-autocenter="2"></span>
	<a href="http://www.jssor.com" style="display:none">Bootstrap Carousel</a>
</div>
<script>
	jssor_1_slider_init();
</script>
