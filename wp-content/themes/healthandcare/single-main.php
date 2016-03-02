<?php
 /*
Template Name: Main page
*/ ?>
<?php get_header(); ?>

<?php if ( $slides = get_posts( $args = array( 'category_name' => 'slider' ) ) ): ?>
	<!-- Slider main container -->
	<div class="slider-main banner flexslider">
		<!-- Additional required wrapper -->
		<ul class="slides">		
			
			<?php foreach( $slides as $post ) : setup_postdata( $post ); ?>
				<li class="slide" style="background-image: url( <?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?> );" >
					<div class="content_wrap">
						<h2><?php the_title(); ?></h2>
						<?php the_content(); ?>
					</div>				
				</li>
			<?php endforeach; ?>	
			<?php wp_reset_postdata(); ?>		
		</ul>
	</div>
<?php endif; ?>

<?php if ( have_posts() ) : the_post(); ?>
	<div class="greeting content_wrap padding_tb_20 clearfix wow fadeInUp">	
		<div class="column col_1_2">
			<h1 class="title iconed textcolor_2"><span><?php the_title(); ?></span></h1>
			<p class="title_2 textcolor_2"><?php echo get_post_meta( $post->ID, 'title2', true ); ?></p>
		</div>
		<div class="column col_1_2"><?php the_content(); ?></div>
	</div>
<?php endif; ?>

<?php if ( $blocks = get_posts( $args = array( 'category_name' => 'colorblocks' ) ) ): // Цветные информационные блоки ?>
	<div class="content_wrap clearfix padding_tb_10 wow fadeInUp">	
	
		<?php for( $cb_counter = 0; $cb_counter < 4; $cb_counter++ ) : ?>
			
			<?php if ( isset( $blocks[ $cb_counter ] ) ) : ?> 
				<?php $post = $blocks[ $cb_counter ]; ?>
				<?php setup_postdata( $post ); ?>			
				<div class="column col_1_4">
					<div class="colored_block color_<?php echo ( $cb_counter + 1 ); ?>">
						<div class="title padding_20">
							<h4 class="iconed"><?php the_title(); ?></h4>
						</div>
						<div class="text padding_20 whited_03"><?php the_content();?></div>
					</div>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		<?php endfor; ?>
	</div>
<?php endif; ?>

<?php $images = get_attached_media( 'image', ot_get_option( 'main_achievements' ) ) ?>
<?php if ( $images ): ?>
	<?php get_template_part( 'colored_line' ); ?>
		<div class="slider-achieve flexslider wow fadeInUp" style="height: 312px;">
			<ul class="slides">
				<?php foreach ( $images as $post ) :  setup_postdata( $post ); ?>				
					<?php $image = image_downsize( $post->ID, 'medium' ); ?>
					<li>
						<a class="colorbox" href="<?php echo $post->guid ?>">
							<img src="<?php echo $image[ 0 ] ?>" style="margin-left: -<?php echo ( $image[ 1 ] / 2 ); ?>px;">
						</a>
					</li>	
				<?php endforeach; ?>				
				<?php wp_reset_postdata(); ?>
			</ul>
		</div>
<?php endif?>

<?php if ( $post = get_post( ot_get_option( 'main_services' ) ) ) : // Услуги ?>
	<?php setup_postdata( $post ); ?>
		<div class="content_wrap padding_tb_20">
			<div class="services content wow fadeInUp">
				<h2><?php the_title(); ?></h2>
				<?php the_content(); ?>
			</div>
		</div>	
	<?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php $doctors = get_posts( array ( 'post_type' => 'doctor' ) ); // Персонал ?>	
<?php if ( $doctors ) : ?>	
	<?php get_template_part( 'colored_line' ); ?>		
	<div class="team wow fadeInUp">	
		<h2>Наши сотрудники</h2>				
		<p>Мы заботимся о вас!</p>	
		<!-- Slider main container -->
		<div class="content_wrap padding_tb_20">
			<div class="slider-team flexslider" style="height: 496px;">
				<ul class="slides">
					<!-- Additional required wrapper -->
					<?php foreach ( $doctors as $post ) : setup_postdata( $post ); ?>
					
						<?php if ( has_post_thumbnail() ) : ?>			
							<li class="columns col_1_4">								
								<?php $departments = get_the_terms( $post, 'department' ); ?>								
								<?php if ( isset ( $departments ) ) $department = $departments[ 0 ]; ?>
								<?php if ( $department ) : ?>				
									<a href="<?php echo get_term_link( $department, 'department' ); ?>">
								<?php endif; ?>							
										<?php the_post_thumbnail( 'medium' ); ?>							
										<div class="container whited_01">										
											<h5 class="name"><?php the_title(); ?></h5>									
											<div class="position"><?php the_excerpt(); ?></div>
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
	</div>	
<?php endif; ?>

<?php if ( $news = get_posts( array( 'category_name' => 'news', 'posts_per_page' => ot_get_option( 'main_news_count', 2 ) ) ) ) : // Новости ?>	
		<div class="content_wrap news padding_tb_20 wow fadeInUp" >			
			<h2>Новости</h2>
				
			<?php foreach( $news as $post ) :?>				
				<?php setup_postdata( $post ); ?>				
				<?php get_template_part( 'news' ); ?>			
			<?php endforeach; ?>
			
			<?php wp_reset_postdata(); ?>		
		</div>		
<?php endif; ?>

<?php if ( $banners = get_posts( array( 'category' => 'banners' ) ) ) : // Баннер ?>	
	<?php $post = $banners[ 0 ]; ?>
	<?php setup_postdata( $post ); ?>
	<div class="banner wow fadeInUp">
		<div class="content_wrap">
			<h2><?php the_title(); ?></h2>
			<?php the_content(); ?>	
		</div>
	</div>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php get_footer(); ?>
