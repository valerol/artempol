<?php $doctors = get_posts( array ( 'post_type' => 'doctor' ) ); ?>

<?php if ( $doctors ) : ?>

	<script>
	jssor_team_slider_init = function() {

		var jssor_team_options = {
			$AutoPlay: true,
			$AutoPlaySteps: 1,
			$SlideWidth: 280,
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

		var jssor_team_slider = new $JssorSlider$("jssor_team", jssor_team_options);
	};

	jQuery( document ).ready( function() {
		jQuery( 'a.lic_gallery' ).colorbox( { 
			rel:'lic_gallery', 
			previous:'<span class="sc_icon icon-left"></span>', 
			next:'<span class="sc_icon icon-right"></span>', 
			close:'<span class="sc_icon icon-cancel"></span>',
			current:'',
		} );
	} );
	</script>

	<div id="jssor_team" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: auto; height: 495px; overflow: hidden; visibility: hidden;">
	<!-- Loading Screen -->
		<div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
			<div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
			<div style="position:absolute;display:block;background:url('img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
		</div>

		<div data-u="slides" class="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 809px; height: 495px; overflow: hidden;">

			<?php foreach ( $doctors as $post ) : setup_postdata( $post ); ?>
			
				<?php if ( has_post_thumbnail() ) : ?>

					<div class="slide sc_team_item" style="display: none;">
						
						<?php $department = get_the_terms( $post, 'department' ) ?>
						
						<a href="<?php  ?>">
						
							<div class="sc_team_item_avatar"><?php the_post_thumbnail(); ?></div>
							
							<div class="sc_team_item_info">
							
								<h5 class="sc_team_item_title"><?php the_title(); ?></h5>
							
								<div class="sc_team_item_position"><?php the_excerpt(); ?></div>
								
							</div>
						
						</a>

					</div>
					
				<?php endif; ?>	

			<?php endforeach; ?>

			<?php wp_reset_postdata(); ?>

		</div>

		<!-- Bullet Navigator -->
		<div data-u="navigator" class="jssorb05 tp-bullets horizontal noSwipe" data-autocenter="1">
			<!-- bullet navigator item prototype -->
			<div data-u="prototype" class="tp-bullet"></div>
		</div>

	</div>

	<script>
	jssor_team_slider_init();
	</script>

<?php endif; ?>
