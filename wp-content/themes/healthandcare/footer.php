		
			<footer class="footer_wrap widget_area scheme_">
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
			<div class="footer_banner">
				<div class="content_wrap">
					<h2 class="banner_title"><?php esc_html_e('health insurance', 'healthandcare'); ?></h2>
					<p class="banner_desciption"><?php esc_html_e('Medicenter with individual approach', 'healthandcare'); ?></p>
					<div class="btn_banner">
						<a class="btn_banner_btn" href="#"><?php esc_html_e('More info', 'healthandcare'); ?></a>
					</div>
				</div>
			</div>
			<footer class="contacts_wrap scheme_original">
				<div class="contacts_wrap_inner">
					<div class="contacts_address">
						<div class="content_wrap">
							<address class="address_left">
								<div class="address2_contact_info"><?php echo ot_get_option( 'footer_address' ); ?></br><?php echo ot_get_option( 'footer_address_2' ); ?></div>
								<div class="email_contact_info"><a href="mailto:<?php echo ot_get_option( 'footer_email' ); ?>"><?php echo ot_get_option( 'footer_email' ); ?></div>
							</address>
						</div>
					</div>
				</div>	<!-- /.contacts_wrap_inner -->
			</footer>	
			<div class="copyright_wrap copyright_style_socials scheme_original">
				<div class="copyright_wrap_inner">
					<div class="content_wrap">
						<div class="copyright_text"><?php echo ot_get_option( 'footer_copyright' ); ?></div>
					</div>
				</div>
			</div>
		</div>	<!-- /.page_wrap -->
	</div>		<!-- /.body_wrap -->

<a href="#" class="scroll_to_top icon-up" title="<?php esc_html_e('Scroll to top', 'healthandcare'); ?>"></a>

<?php wp_footer(); ?>

</body>
</html>
