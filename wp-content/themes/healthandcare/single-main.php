<?php
 /*
Template Name: Main page
*/ ?>
<?php get_header(); ?>

<?php if ( ot_get_option( 'show_slider' ) && $slides = ot_get_option( 'slider' ) ) : ?>
	<!-- Slider main container -->
	<div class="slider-main flexslider">
		<!-- Additional required wrapper -->
		<ul class="slides">		
			
			<?php foreach( $slides as $key => $slide ) : ?>					
				<li style="background-image: url( <?php echo $slide[ 'image' ] ?> );" >
					<div class="content_wrap">
						<div class="slider_title"><?php echo $slide[ 'title' ]; ?></div>
						<div class="slider_description"><?php echo $slide[ 'description' ]; ?></div>
						
						<?php if ( $slide[ 'link' ] ) $link[ $key ] = explode( '|', $slide[ 'link' ] ); ?>
						
						<?php if ( isset( $link[ $key ][ 0 ] ) && isset( $link[ $key ][ 1 ] ) ) : ?>
							<a class="sc_button sc_button_style_filled" href="<?php echo $link[ $key ][ 1 ]; ?>"><?php echo $link[ $key ][ 0 ]; ?></a>
						<?php endif; ?>
					</div>				
				</li>
			<?php endforeach; ?>		
		</ul>
	</div>
<?php endif; ?>

<?php if ( ot_get_option( 'show_greeting' ) == 'on' && ( ot_get_option( 'greeting' ) || ot_get_option( 'greeting_text' ) ) ) : // Приветствие ?>
	<div class="content_wrap columns_wrap">
	
		<?php if ( ot_get_option( 'greeting' ) ) : ?>
			<div style="text-align:none;" class="column-1_2">
					<h1 class="greeting_title">
						
						<?php if ( ot_get_option( 'greeting_icon' ) ) : ?>
							<span class="left red <?php echo ot_get_option( 'greeting_icon' ); ?>"></span>
						<?php endif; ?>
						
						<?php echo ot_get_option( 'greeting' ); ?>
					</h1>
				
				<?php if ( ot_get_option( 'greeting_lead' ) ) : ?>
					<h6><?php echo ot_get_option( 'greeting_lead' ); ?></h6>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		
		<?php if ( ot_get_option( 'greeting_text' ) ) : ?>
			<div class="column-1_<?php echo ( ot_get_option( 'greeting' ) ? '2' : '1' ); ?>">
				<?php echo ot_get_option( 'greeting_text' ); ?>
				
				<?php if ( ot_get_option( 'greeting_link' ) ) : ?>
					<a class="sc_button sc_button_style_border sc_button_size_small" href="<?php echo the_permalink( ot_get_option( 'greeting_link' ) ); ?>">
						<?php echo ( ot_get_option( 'greeting_ancor' ) ? ot_get_option( 'greeting_ancor' ) : get_the_title( ot_get_option( 'greeting_link' ) ) ); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php if ( ot_get_option( 'show_colorblocks' ) == 'on' && ( ot_get_option( 'colorblock_1_title' ) ||  ot_get_option( 'colorblock_2_title' ) || ot_get_option( 'colorblock_3_title' ) || ot_get_option( 'colorblock_4_title' ) ) ) : // Цветные информационные блоки ?>
	<div class="content_wrap columns_wrap wow fadeInUp">
		<div class="sc_services columns_wrap">		
				<?php for( $cb_counter = 1; $cb_counter < 5; $cb_counter++ ) : ?>
					
					<?php if ( ot_get_option( 'colorblock_' . $cb_counter . '_title' ) ) : ?>
						<div class="column-1_4 column_padding_bottom">
							<div class="sc_services_item sc_services_item_<?php echo $cb_counter; ?>">
								<h4 class="sc_services_item_title">
									<span class="<?php echo ot_get_option( 'colorblock_' . $cb_counter . '_icon' ); ?>"></span>
									<?php echo ot_get_option( 'colorblock_' . $cb_counter . '_title' ); ?>
								</h4>							
								<div class="sc_services_item_content">
									<div class="sc_services_item_description">
										<?php echo ot_get_option( 'colorblock_' . $cb_counter . '_text' ); ?>
									</div>
									<a class="sc_services_item_readmore" href="<?php echo ot_get_option( 'colorblock_' . $cb_counter . '_link' ); ?>">
										Подробнее
										<span class="icon-right-2"></span>
									</a>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php endfor; ?>
		</div>
	</div>
<?php endif; ?>

<?php if ( ot_get_option( 'show_achievements' ) == 'on' ) : // Грамоты ?>
	<?php get_template_part( 'colored_line' ); ?>
		<!-- Slider main container -->
		<div class="slider-achieve flexslider" style="height: 312px;">
			<!-- Additional required wrapper -->
			<ul class="slides">
				<?php if ( ot_get_option( 'achievements_page' ) ) $images = get_attached_media( 'image', ot_get_option( 'achievements_page' ) );  // get images ?>
				
				<?php if ( $images ) : // show images ?>

					<?php foreach ( $images as $post ) :  setup_postdata( $post ); ?>				
						<?php $image = image_downsize( $post->ID, 'medium' ); ?>
						<li>
							<a class="colorbox" href="<?php echo $post->guid ?>"><img src="<?php echo $image[ 0 ] ?>" style="margin-left: -<?php echo ( $image[ 1 ] / 2 ); ?>px;"></a>
						</li>	
					<?php endforeach; ?>				
					<?php wp_reset_postdata(); ?>
				<?php endif; ?>				
			</ul>
		</div>
<?php endif; ?>

<?php if ( ot_get_option( 'show_services' ) == 'on' ) : // Услуги ?>
	<div class="wpb_wrapper services list-icon">
		<div class="sc_content content_wrap wow fadeInUp">
			<h1 style="margin-top:5.84615rem;margin-bottom:0.23076rem;text-align:center;" class="sc_title sc_title_regular sc_align_center">
				<?php echo ot_get_option( 'services_title' ); ?>
			</h1>
			<?php $services_post = get_post( ot_get_option( 'services_page' ) ); ?>
			<?php echo $services_post->post_content; ?>
		</div>
	</div>
<?php endif; ?>

<?php if ( ot_get_option( 'show_team' ) == 'on' ) : // Персонал ?>
	<?php $doctors = get_posts( array ( 'post_type' => 'doctor' ) ); ?>
	
	<?php if ( $doctors ) : ?>	
		<?php get_template_part( 'colored_line' ); ?>		
		<div class="team wow fadeInUp">		
			<h2><?php echo ot_get_option( 'team_title' ); ?></h2>				
			<h6><?php echo ot_get_option( 'team_description' ); ?></h6>
			
			<?php if ( $doctors = get_posts( array ( 'post_type' => 'doctor' ) ) ) : ?>
				<!-- Slider main container -->
				<div class="content_wrap">
					<div class="slider-team flexslider" style="height: 496px;">
						<ul class="slides">
							<!-- Additional required wrapper -->
							<?php foreach ( $doctors as $post ) : setup_postdata( $post ); ?>
							
								<?php if ( has_post_thumbnail() ) : ?>			
									<li class="sc_team_item">								
										<?php $departments = get_the_terms( $post, 'department' ); ?>								
										<?php if ( isset ( $departments ) ) $department = $departments[ 0 ]; ?>
										<?php if ( $department ) : ?>				
											<a href="<?php echo get_term_link( $department, 'department' ); ?>">
										<?php endif; ?>							
												<?php the_post_thumbnail( 'medium' ); ?>							
												<div class="sc_team_item_info_container">	
													<div class="sc_team_item_info">												
														<h5 class="sc_team_item_title"><?php the_title(); ?></h5>									
														<div class="sc_team_item_position"><?php the_excerpt(); ?></div>
													</div>													
												</div>		
										<?php if ( $department ) : ?>							
											</a>
										<?php endif; ?>							
									</li>				
								<?php endif; ?>	
							<?php endforeach; ?>
							<?php wp_reset_postdata(); ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>
		</div>	
	<?php endif; ?>
<?php endif; ?>

<?php if ( ot_get_option( 'show_news' ) == 'on' ) : // Новости ?>	
	<?php $news = get_posts( array( 'category' => ot_get_option( 'news_category' ), 'posts_per_page'   => ot_get_option( 'news_number' ) ) ); ?>
	
	<?php if ( $news ) : ?>
		<div class="sc_content content_wrap home1_wide_block1  wow fadeInUp" >			
			<h2><?php echo ot_get_option( 'news_title' ); ?></h2>
	
			<?php foreach( $news as $post ) :?>				
				<?php setup_postdata( $post ); ?>				
				<?php get_template_part( 'news' ); ?>			
			<?php endforeach; ?>
			
			<?php wp_reset_postdata(); ?>		
		</div>		
	<?php endif; ?>
<?php endif; ?>

<?php if ( ot_get_option( 'show_banner' ) == 'on' ) : // Баннер ?>	
	<div class="footer_banner">
		<div class="content_wrap">
			
			<?php if ( ot_get_option( 'banner_title' ) ) : ?>
				<h2 class="banner_title"><?php echo ot_get_option( 'banner_title' ); ?></h2>
			<?php endif; ?>
			
			
			<?php if ( ot_get_option( 'banner_description' ) ) : ?>
				<p class="banner_desciption"><?php echo ot_get_option( 'banner_description' ); ?></p>
			<?php endif; ?>
			
			
			<?php if ( ot_get_option( 'banner_link' ) ) : ?>
				<div class="btn_banner">
					<a class="btn_banner_btn" href="#"><?php echo ot_get_option( 'banner_ancor' ) ? ot_get_option( 'banner_ancor' ) : "Подробнее" ; ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>

<?php get_footer(); ?>
