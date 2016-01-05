<?php
/**
 * The template for displaying the footer.
 */

global $HEALTHANDCARE_GLOBALS;

				healthandcare_close_wrapper();	// <!-- </.content> -->

				// Show main sidebar
				get_sidebar();

				if (healthandcare_get_custom_option('body_style')!='fullscreen') healthandcare_close_wrapper();	// <!-- </.content_wrap> -->
				?>
			
			</div>		<!-- </.page_content_wrap> -->
			
			<?php
			// Footer Testimonials stream
			if (healthandcare_get_custom_option('show_testimonials_in_footer')=='yes') {
				$count = max(1, healthandcare_get_custom_option('testimonials_count'));
				$data = healthandcare_do_shortcode('[trx_testimonials style="testimonials-2" columns="3" slider="yes" controls="pagination" slides_space="0" interval="7000" autoheight="" align="none" custom="" title="Testimonials" description="What our patients say about us" count="'.esc_attr($count).'" offset="0" orderby="date" order="asc" animation="none"][/trx_testimonials]');
				if ($data) {
					?>
					<footer class="testimonials_wrap sc_section scheme_<?php echo esc_attr(healthandcare_get_custom_option('testimonials_scheme')); ?>">
						<div class="testimonials_wrap_inner sc_section_inner sc_section_overlay">
							<div class="content_wrap"><?php echo ($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}
			
			// Footer sidebar
			$footer_show  = healthandcare_get_custom_option('show_sidebar_footer');
			$sidebar_name = healthandcare_get_custom_option('sidebar_footer');
			if (!healthandcare_param_is_off($footer_show) && is_active_sidebar($sidebar_name)) {
				$HEALTHANDCARE_GLOBALS['current_sidebar'] = 'footer';
				?>
				<footer class="footer_wrap widget_area scheme_<?php echo esc_attr(healthandcare_get_custom_option('sidebar_footer_scheme')); ?>">
					<div class="footer_wrap_inner widget_area_inner">
						<div class="content_wrap">
							<div class="columns_wrap"><?php
							ob_start();
							do_action( 'before_sidebar' );
							if ( !dynamic_sidebar($sidebar_name) ) {
								// Put here html if user no set widgets in sidebar
							}
							do_action( 'after_sidebar' );
							$out = ob_get_contents();
							ob_end_clean();
							echo trim(chop(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $out)));
							?></div>	<!-- /.columns_wrap -->
						</div>	<!-- /.content_wrap -->
					</div>	<!-- /.footer_wrap_inner -->
				</footer>	<!-- /.footer_wrap -->
			<?php
			}


			// Footer Twitter stream
			if (healthandcare_get_custom_option('show_twitter_in_footer')=='yes') {
				$count = max(1, healthandcare_get_custom_option('twitter_count'));
				$data = healthandcare_do_shortcode('[trx_twitter count="'.esc_attr($count).'"]');
				if ($data) {
					?>
					<footer class="twitter_wrap sc_section scheme_<?php echo esc_attr(healthandcare_get_custom_option('twitter_scheme')); ?>">
						<div class="twitter_wrap_inner sc_section_inner sc_section_overlay">
							<div class="content_wrap"><?php echo ($data); ?></div>
						</div>
					</footer>
					<?php
				}
			}		if (healthandcare_get_custom_option('show_banner_in_footer')=='yes') {?>
						<div class="footer_banner">
							<div class="content_wrap">
								<h2 class="banner_title"><?php esc_html_e('health insurance', 'healthandcare'); ?></h2>
								<p class="banner_desciption"><?php esc_html_e('Medicenter with individual approach', 'healthandcare'); ?></p>
								<div class="btn_banner">
									<a class="btn_banner_btn" href="#"><?php esc_html_e('More info', 'healthandcare'); ?></a>
								</div>
							</div>
						</div>
				<?php }

			if ( healthandcare_get_custom_option('show_googlemap_before_contact')=='yes' ) {
				$map_address = healthandcare_get_custom_option('googlemap_address');
				$map_latlng  = healthandcare_get_custom_option('googlemap_latlng');
				$map_zoom    = healthandcare_get_custom_option('googlemap_zoom');
				$map_style   = healthandcare_get_custom_option('googlemap_style');
				$map_height  = healthandcare_get_custom_option('googlemap_height');
				$map_title   = healthandcare_get_custom_option('googlemap_title');
				$map_descr   = healthandcare_strmacros(healthandcare_get_custom_option('googlemap_description'));
				if (!empty($map_address) || !empty($map_latlng)) {
					echo healthandcare_do_shortcode('[trx_googlemap'
						. (!empty($map_style)   ? ' style="'.esc_attr($map_style).'"' : '')
						. (!empty($map_zoom)    ? ' zoom="'.esc_attr($map_zoom).'"' : '')
						. (!empty($map_height)  ? ' height="'.esc_attr($map_height).'"' : '')
						. ']'
						. '[trx_googlemap_marker'
						. (!empty($map_title)   ? ' title="'.esc_attr($map_title).'"' : '')
						. (!empty($map_descr)   ? ' description="'.esc_attr($map_descr).'"' : '')
						. (!empty($map_address) ? ' address="'.esc_attr($map_address).'"' : '')
						. (!empty($map_latlng)  ? ' latlng="'.esc_attr($map_latlng).'"' : '')
						. ']'
						. '[/trx_googlemap]'
					);
				}
			}

			// Footer contacts
			if (healthandcare_get_custom_option('show_contacts_in_footer')=='yes') {
				$address_2 = healthandcare_get_theme_option('contact_address_2');
                $contact_email = healthandcare_get_theme_option('contact_email');
				if (!empty($address_2) || !empty($contact_email)) {
					?>
					<footer class="contacts_wrap scheme_<?php echo esc_attr(healthandcare_get_custom_option('contacts_scheme')); ?>">
						<div class="contacts_wrap_inner">
                            <div class="contacts_address">
                                <div class="content_wrap">
                                    <address class="address_left">
                                        <div class="address2_contact_info"><?php if (!empty($address_2)) echo ($address_2); ?></div>
                                        <div class="email_contact_info"><?php if (!empty($contact_email)) echo ($contact_email); ?></div>
                                    </address>
<!--                                    <address class="address_right">
                                        <div class="btn_directions">
                                            <a class="btn_directions_map" href="#"><?php //esc_html_e('Get directions on Google Maps', 'healthandcare'); ?><span></span></a>
                                        </div>
                                    </address>-->
                                </div>
                            </div>
						</div>	<!-- /.contacts_wrap_inner -->
					</footer>	<!-- /.contacts_wrap -->
					<?php
				}
			}


                        // Google map
/*                        if ( healthandcare_get_custom_option('show_googlemap')=='yes' ) {
                                $map_address = healthandcare_get_custom_option('googlemap_address');
                                $map_latlng = healthandcare_get_custom_option('googlemap_latlng');
                                $map_zoom = healthandcare_get_custom_option('googlemap_zoom');
                                $map_style = healthandcare_get_custom_option('googlemap_style');
                                $map_height = healthandcare_get_custom_option('googlemap_height');
                                $map_title = healthandcare_get_custom_option('googlemap_title');
                                $map_descr = healthandcare_strmacros(healthandcare_get_custom_option('googlemap_description'));
                                if (!empty($map_address) || !empty($map_latlng)) {
                                        echo healthandcare_do_shortcode('[trx_googlemap'
                                                . (!empty($map_style) ? ' style="' . esc_attr($map_style) . '"' : '')
                                                . (!empty($map_zoom) ? ' zoom="' . esc_attr($map_zoom) . '"' : '')
                                                . (!empty($map_height) ? ' height="' . esc_attr($map_height) . '"' : '')
                                                . ']'
                                                . '[trx_googlemap_marker'
                                                . (!empty($map_title) ? ' title="' . esc_attr($map_title) . '"' : '')
                                                . (!empty($map_descr) ? ' description="' . esc_attr($map_descr) . '"' : '')
                                                . (!empty($map_address) ? ' address="' . esc_attr($map_address) . '"' : '')
                                                . (!empty($map_latlng) ? ' latlng="' . esc_attr($map_latlng) . '"' : '')
                                                . ']'
                                                . '[/trx_googlemap]'
                                        );
                                }
                        }*/
                        
                        // Yandex map
                        $map_show = healthandcare_get_custom_option('show_googlemap');
			$sidebar_name = 'sidebar_map';
			if ( $map_show == 'yes' && is_active_sidebar( $sidebar_name ) ) {
				$HEALTHANDCARE_GLOBALS['current_sidebar'] = 'map';
                                ob_start();
                                do_action( 'before_sidebar' );
                                if ( !dynamic_sidebar($sidebar_name) ) {
                                        // Put here html if user no set widgets in sidebar
                                }
                                do_action( 'after_sidebar' );
                                $out = ob_get_contents();
                                ob_end_clean();
                                echo trim(chop(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $out)));
			}
                        
                        
                        if ( healthandcare_get_custom_option('show_footer_contact_form')=='yes' ) {
                                echo healthandcare_do_shortcode('
                                        [trx_content scheme="inherit" animation="none" class="footer_form_aplication"]
                                        [trx_columns count="2" fluid="" id="" class="" animation="none" css="" width="" height="" top="" bottom="" left="" right=""]
                                        [trx_contact_form custom="yes" style="2" align="center" title="contact us" animation="none" subtitle="Sed ut perspiciatis"]
                                        [trx_column_item span="" align="none" color="" bg_color="" bg_image="" id="" class="" animation="none" css=""]
                                        [trx_form_item type="text" name="Name *" value="Name *" label_position="top" animation="none"]
                                        [trx_form_item type="text" name="Phone *" value="Phone *" label_position="top" animation="none"]
                                        [trx_form_item type="text" name="Email *" value="Email *" label_position="top" animation="none"]
                                        [/trx_column_item]
                                        [trx_column_item span="" align="none" color="" bg_color="" bg_image="" id="" class="" animation="none" css=""]
                                        [trx_form_item type="textarea" name="Message *" value="Message *" label_position="top" animation="none"]
                                        [trx_form_item type="button" name="Send Message" value="Send Message" label_position="top" animation="none"]
                                        [/trx_column_item][/trx_contact_form][/trx_columns][/trx_content]
                                ');
                        }

                        // Copyright area
			$copyright_style = healthandcare_get_custom_option('show_copyright_in_footer');
			if (!healthandcare_param_is_off($copyright_style)) {
			?> 
				<div class="copyright_wrap copyright_style_<?php echo esc_attr($copyright_style); ?>  scheme_<?php echo esc_attr(healthandcare_get_custom_option('copyright_scheme')); ?>">
					<div class="copyright_wrap_inner">
						<div class="content_wrap">
							<?php
							if ($copyright_style == 'menu') {
								if (empty($HEALTHANDCARE_GLOBALS['menu_footer']))	$HEALTHANDCARE_GLOBALS['menu_footer'] = healthandcare_get_nav_menu('menu_footer');
								if (!empty($HEALTHANDCARE_GLOBALS['menu_footer']))	echo ($HEALTHANDCARE_GLOBALS['menu_footer']);
							} else if ($copyright_style == 'socials') {
								echo healthandcare_do_shortcode('[trx_socials size="tiny"][/trx_socials]');
							}
							?>
							<div class="copyright_text"><?php echo force_balance_tags(healthandcare_get_theme_option('footer_copyright')); ?></div>
						</div>
					</div>
				</div>
			<?php } ?>
			
		</div>	<!-- /.page_wrap -->

	</div>		<!-- /.body_wrap -->

<?php
if (healthandcare_get_custom_option('show_theme_customizer')=='yes') {
	require_once( healthandcare_get_file_dir('core/core.customizer/front.customizer.php') );
}
?>

<a href="#" class="scroll_to_top icon-up" title="<?php esc_html_e('Scroll to top', 'healthandcare'); ?>"></a>

<div class="custom_html_section">
<?php echo force_balance_tags(healthandcare_get_custom_option('custom_code')); ?>
</div>

<?php echo force_balance_tags(healthandcare_get_custom_option('gtm_code2')); ?>

<?php wp_footer(); ?>

</body>
</html>