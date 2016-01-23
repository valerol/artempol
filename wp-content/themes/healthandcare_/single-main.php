<?php /*
Template Name: Main page
*/ ?>

<?php get_header(); ?>

<?php if ( ot_get_option( 'show_greeting' ) == 'on' ) : ?>
<div class="wpb_wrapper">
	<div data-animation="animated fadeInUp normal" class="sc_content content_wrap home1_wide_block1 animated fadeInUp normal">
		<div class="columns_wrap sc_columns columns_nofluid sc_columns_count_3">
			<div style="text-align:none;" class="column-1_2 sc_column_item sc_column_item_1 odd first">
				<h1 class="sc_title sc_title_iconed"><span class="sc_title_icon sc_title_icon_top  sc_title_icon_small <?php echo ot_get_option( 'greeting_icon' ); ?>"></span><?php echo ot_get_option( 'greeting' ); ?></h1>
				<h6 class="sc_title sc_title_regular"><?php echo ot_get_option( 'greeting_lead' ); ?></h6>
			</div>
			<div style="text-align:none;" class="column-1_2 sc_column_item sc_column_item_2 even span_2">
				<div class="wpb_text_column wpb_content_element ">
					<div class="wpb_wrapper">
						<?php echo ot_get_option( 'greeting_text' ); ?>
					</div>
				</div>
				<a class="sc_button sc_button_square sc_button_style_border sc_button_bg_user sc_button_size_small  sc_button_iconed icon-right-2" href="<?php echo ot_get_option( 'greeting_ancor' ); ?>"><?php echo ot_get_option( 'greeting_ancor' ); ?></a>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php if ( ot_get_option( 'show_colorblocks' ) == 'on' ) : ?>
<div class="wpb_wrapper">
	<div style="margin-top:5rem !important;margin-bottom:4.61538rem !important;" data-animation="animated fadeInUp normal" class="sc_content content_wrap animated fadeInUp normal">
		<div data-slides-per-view="4" data-interval="7000" style="width:100%;" class="sc_services sc_services_style_services-1 sc_services_type_icons  sc_slider_nopagination sc_slider_nocontrols" id="sc_services_1344188713">
			<div class="sc_columns columns_wrap">

				<div class="column-1_4 column_padding_bottom">			
					<div class="sc_services_item sc_services_item_1 odd first" id="sc_services_1344188713_1">
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

<?php get_footer(); ?>


