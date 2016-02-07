<?php if ( $doctors = get_posts( array ( 'post_type' => 'doctor' ) ) ) : ?>
	<!-- Slider main container -->
	<div class="swiper-container doctors" style="height: 496px;">
		<!-- Additional required wrapper -->
		<div class="slides swiper-wrapper">

				<?php foreach ( $doctors as $post ) : setup_postdata( $post ); ?>
				
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="swiper-slide">						
							<div class="sc_team_item">								
								<?php $departments = get_the_terms( $post, 'department' ); ?>								
								<?php $department = $departments[0]; ?>								
								<a href="<?php echo get_term_link( $department, 'department' ); ?>">								
									<div class=""><?php the_post_thumbnail( 'medium' ); ?></div>									
									<div class="sc_team_item_info">									
										<h5 class="sc_team_item_title"><?php the_title(); ?></h5>									
										<div class="sc_team_item_position"><?php the_excerpt(); ?></div>										
									</div>								
								</a>							
							</div>
						</div>						
					<?php endif; ?>	
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>				
		</div>
		<!-- If we need pagination -->
		<div class="bullets bullets-team"></div>		
		<!-- If we need navigation buttons -->
		<div class="swiper-button-prev tp-leftarrow tparrows custom noSwipe"></div>
		<div class="swiper-button-next tp-rightarrow tparrows custom noSwipe"></div>		
		<!-- If we need scrollbar -->
		<div class="swiper-scrollbar"></div>
	</div>
<?php endif; ?>
