<script>
	jssor_2_slider_init = function() {
		
		var jssor_2_SlideoTransitions = [
		  [{b:5500,d:3000,o:-1,r:240,e:{r:2}}],
		  [{b:-1,d:1,o:-1,c:{x:51.0,t:-51.0}},{b:0,d:1000,o:1,c:{x:-51.0,t:51.0},e:{o:7,c:{x:7,t:7}}}],
		  [{b:-1,d:1,o:-1,sX:9,sY:9},{b:1000,d:1000,o:1,sX:-9,sY:-9,e:{sX:2,sY:2}}],
		  [{b:-1,d:1,o:-1,r:-180,sX:9,sY:9},{b:2000,d:1000,o:1,r:180,sX:-9,sY:-9,e:{r:2,sX:2,sY:2}}],
		  [{b:-1,d:1,o:-1},{b:3000,d:2000,y:180,o:1,e:{y:16}}],
		  [{b:-1,d:1,o:-1,r:-150},{b:7500,d:1600,o:1,r:150,e:{r:3}}],
		  [{b:10000,d:2000,x:-379,e:{x:7}}],
		  [{b:10000,d:2000,x:-379,e:{x:7}}],
		  [{b:-1,d:1,o:-1,r:288,sX:9,sY:9},{b:9100,d:900,x:-1400,y:-660,o:1,r:-288,sX:-9,sY:-9,e:{r:6}},{b:10000,d:1600,x:-200,o:-1,e:{x:16}}]
		];
		
		var jssor_2_options = {
		  $AutoPlay: true,
		  $SlideDuration: 800,
		  $SlideEasing: $Jease$.$OutQuint,
		  $CaptionSliderOptions: {
			$Class: $JssorCaptionSlideo$,
			$Transitions: jssor_2_SlideoTransitions
		  },
		  $ArrowNavigatorOptions: {
			$Class: $JssorArrowNavigator$
		  },
		  $BulletNavigatorOptions: {
			$Class: $JssorBulletNavigator$
		  }
		};
		
		var jssor_2_slider = new $JssorSlider$("jssor_2", jssor_2_options);
		
		//responsive code begin
		//you can remove responsive code if you don't want the slider scales while window resizing
		function ScaleSlider() {
			var refSize = jssor_2_slider.$Elmt.parentNode.clientWidth;
			if (refSize) {
				refSize = Math.min(refSize, 1280);
				jssor_2_slider.$ScaleWidth(refSize);
			}
			else {
				window.setTimeout(ScaleSlider, 30);
			}
		}
		ScaleSlider();
		$Jssor$.$AddEvent(window, "load", ScaleSlider);
		$Jssor$.$AddEvent(window, "resize", ScaleSlider);
		$Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
		//responsive code end
	};
</script>

<div id="jssor_2" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 1280px; height: 570px; overflow: hidden; visibility: hidden;">
	<!-- Loading Screen -->
	<div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
		<div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
		<div style="position:absolute;display:block;background:url('img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
	</div>
	<div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 1920px; height: 570px; overflow: hidden;">
	<?php $slides = ot_get_option( 'slider' ); ?>
	<?php foreach( $slides as $slide ) : ?>	
		<div data-p="225.00" style="display: none;">
			<img class="slider_main_img" data-u="image" style="left: -300px" src="<?php echo $slide[ 'image' ]; ?>" />
			<div style="position: absolute; top: 30px; left: 30px; width: 480px; height: 120px; font-size: 50px; color: #ffffff; line-height: 60px;"><?php echo $slide[ 'title' ]; ?></div>
			<div style="position: absolute; top: 300px; left: 30px; width: 480px; height: 120px; font-size: 30px; color: #ffffff; line-height: 38px;"><?php echo $slide[ 'description' ]; ?></div>
		</div>
	<?php endforeach; ?>
	</div>
	<!-- Bullet Navigator -->
	<div data-u="navigator" class="jssorb05 tp-bullets horizontal noSwipe" data-autocenter="1">
		<!-- bullet navigator item prototype -->
		<div data-u="prototype" class="tp-bullet"></div>
	</div>
	<!-- Arrow Navigator -->
	<span data-u="arrowleft" class="jssora22l tp-leftarrow tparrows custom noSwipe" data-autocenter="2"></span>
	<span data-u="arrowright" class="jssora22r tp-rightarrow tparrows custom noSwipe" data-autocenter="2"></span>
	<a href="http://www.jssor.com" style="display:none">Bootstrap Carousel</a>
</div>
<script>
	jssor_2_slider_init();
</script>
