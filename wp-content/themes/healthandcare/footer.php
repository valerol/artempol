<?php
if( ! is_front_page() ) : ?>				
	</div> <!-- /.content -->
<?php endif; ?>
		
<footer class="contacts_wrap scheme_original">
	<div class="contacts_wrap_inner">
		<div class="contacts_address">
			<div class="content_wrap">
				<address class="address_left">
					<div class="address2_contact_info"><?php echo ot_get_option( 'footer_address' ); ?></br><?php echo ot_get_option( 'footer_address_2' ); ?></div>
					<div class="email_contact_info"><a href="mailto:<?php echo ot_get_option( 'footer_email' ); ?>"><?php echo ot_get_option( 'footer_email' ); ?></a></div>
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

<a href="#" class="scroll_to_top icon-up" title="<?php esc_html_e('Scroll to top', 'healthandcare'); ?>"></a>

<?php wp_footer(); ?>

</body>
</html>