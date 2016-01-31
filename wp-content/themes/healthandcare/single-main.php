<?php /*
Template Name: Main page
*/ ?>
<?php get_header(); ?>

<?php if ( ot_get_option( 'show_greeting' ) == 'on' ) : // Приветствие ?>
	<div class="wpb_wrapper greeting list-icon">
		<div data-animation="animated fadeInUp" class="sc_content content_wrap home1_wide_block1">
			<div class="columns_wrap sc_columns columns_nofluid sc_columns_count_3">
				<div style="text-align:none;" class="column-1_2 sc_column_item sc_column_item_1 odd first">
					<h1 class="sc_title sc_title_iconed">
						<span class="sc_title_icon sc_title_icon_top sc_title_icon_small <?php echo ot_get_option( 'greeting_icon' ); ?>"></span>
						<?php echo ot_get_option( 'greeting' ); ?>
					</h1>
					<h6 class="sc_title sc_title_regular"><?php echo ot_get_option( 'greeting_lead' ); ?></h6>
				</div>
				<div style="text-align:none;" class="column-1_2 sc_column_item sc_column_item_2 even span_2">
					<div class="wpb_text_column wpb_content_element ">
						<div class="wpb_wrapper">
							<?php echo ot_get_option( 'greeting_text' ); ?>
						</div>
					</div>
					<a class="sc_button sc_button_square sc_button_style_border sc_button_bg_user sc_button_size_small sc_button_iconed icon-right-2" href="<?php echo ot_get_option( 'greeting_ancor' ); ?>"><?php echo ot_get_option( 'greeting_ancor' ); ?></a>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if ( ot_get_option( 'show_colorblocks' ) == 'on' ) : // Цветные информационные блоки ?>
	<div class="wpb_wrapper">
		<div style="margin-top:5rem !important;margin-bottom:4.61538rem !important;" class="sc_content content_wrap animated fadeInUp normal">
			<div data-slides-per-view="4" data-interval="7000" style="width:100%;" class="sc_services sc_services_style_services-1 sc_services_type_icons sc_slider_nopagination sc_slider_nocontrols" id="sc_services_1344188713">
				<div class="sc_columns columns_wrap">
					<div class="column-1_4 column_padding_bottom">
						<div class="sc_services_item sc_services_item_1">
							<h4 class="sc_services_item_title">
								<a href="<?php echo ot_get_option( 'colorblock_1_link' ); ?>">
									<span class="<?php echo ot_get_option( 'colorblock_1_icon' ); ?>"></span>
									<?php echo ot_get_option( 'colorblock_1_title' ); ?>
								</a>
							</h4>
						<div class="sc_services_item_content">
							<div class="sc_services_item_description">
								<?php echo ot_get_option( 'colorblock_1_text' ); ?>
							</div>
						</div>
					</div>
				</div>

<div class="column-1_4 column_padding_bottom">
<div class="sc_services_item sc_services_item_2 even" id="sc_services_1344188713_1">
<h4 class="sc_services_item_title">
<a href="<?php echo ot_get_option( 'colorblock_2_link' ); ?>">
<span class="<?php echo ot_get_option( 'colorblock_2_icon' ); ?>"></span>
<?php echo ot_get_option( 'colorblock_2_title' ); ?>
</a>
</h4>
<div class="sc_services_item_content">
<div class="sc_services_item_description">
<?php echo ot_get_option( 'colorblock_2_text' ); ?>
</div>
</div>
</div>
</div>
<div class="column-1_4 column_padding_bottom">
<div class="sc_services_item sc_services_item_3 odd" id="sc_services_1344188713_1">
<h4 class="sc_services_item_title">
<a href="<?php echo ot_get_option( 'colorblock_3_link' ); ?>">
<span class="<?php echo ot_get_option( 'colorblock_3_icon' ); ?>"></span>
<?php echo ot_get_option( 'colorblock_3_title' ); ?>
</a>
</h4>
<div class="sc_services_item_content">
<div class="sc_services_item_description">
<?php echo ot_get_option( 'colorblock_3_text' ); ?>
</div>
</div>
</div>
</div>
<div class="column-1_4 column_padding_bottom">
<div class="sc_services_item sc_services_item_4 even" id="sc_services_1344188713_1">
<h4 class="sc_services_item_title">
<a href="<?php echo ot_get_option( 'colorblock_4_link' ); ?>">
<span class="<?php echo ot_get_option( 'colorblock_4_icon' ); ?>"></span>
<?php echo ot_get_option( 'colorblock_4_title' ); ?>
</a>
</h4>
<div class="sc_services_item_content">
<div class="sc_services_item_description">
<?php echo ot_get_option( 'colorblock_4_text' ); ?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php endif; ?>

<?php get_template_part( 'colored_line' ); ?>

<?php // Грамоты и благодарности ?>
<footer class="testimonials_wrap sc_section scheme_">
	<div data-animation="animated fadeInUp" class="testimonials_wrap_inner sc_section_inner sc_section_overlay">
		<div class="content_wrap">
			<?php get_template_part( 'slider', 'achievements' ); ?>
		</div>
	</div>
</footer>

<?php // Услуги ?>
<div class="wpb_wrapper services list-icon">
	<div  data-animation="animated fadeInUp" class="sc_content content_wrap">
		<h1 style="margin-top:5.84615rem;margin-bottom:0.23076rem;text-align:center;" class="sc_title sc_title_regular sc_align_center">
			<?php echo ot_get_option( 'services_title' ); ?>
		</h1>
		<h6 style="margin-bottom:3.76923rem;text-align:center;" class="sc_title sc_title_regular sc_align_center">
			<?php echo ot_get_option( 'services_description' ); ?>
		</h6>
		<div class="columns_wrap sc_columns columns_nofluid sc_columns_count_3">
			<div style="text-align:none;" class="column-1_3 sc_column_item sc_column_item_1 odd first"><?php echo ot_get_option( 'services_1' ); ?></div>
			<div style="text-align:none;" class="column-1_3 sc_column_item sc_column_item_2 even"><?php echo ot_get_option( 'services_2' ); ?></div>
			<div style="text-align:none;" class="column-1_3 sc_column_item sc_column_item_3 odd"><?php echo ot_get_option( 'services_3' ); ?></div>
		</div>
	</div>
</div>

<?php if ( ot_get_option( 'show_team' ) == 'on' ) : // Персонал ?>

	<?php $doctors = get_posts( array ( 'post_type' => 'doctor' ) ); ?>
	
	<?php if ( $doctors ) : ?>
	
		<?php get_template_part( 'colored_line' ); ?>
		
		<div class="team">
			<div class="content_wrap">
			
				<h2><?php echo ot_get_option( 'team_title' ); ?></h2>
				
				<h6><?php echo ot_get_option( 'team_description' ); ?></h6>
			
				<?php get_template_part( 'slider', 'team' ); ?>		
			</div>
		</div>
	
	<?php endif; ?>

<?php endif; ?>

<?php if ( ot_get_option( 'show_news' ) == 'on' ) : // Новости ?>
	
	<?php $news = get_posts( array( 'category' => ot_get_option( 'news_category' ), 'posts_per_page'   => ot_get_option( 'news_number' ) ) ); ?>
	
	<?php if ( $news ) : ?>
	
		<div data-animation="animated fadeInUp" class="sc_content content_wrap home1_wide_block1" >
			
			<h2><?php echo ot_get_option( 'news_title' ); ?></h2>
	
			<?php foreach( $news as $post ) :?>
				
				<?php setup_postdata( $post ); ?>
				
				<?php get_template_part( 'news' ); ?>
			
			<?php endforeach; ?>
			
			<?php wp_reset_postdata(); ?>
		
		</div>
		
	<?php endif; ?>

<?php endif; ?>

<?php get_footer(); ?>
