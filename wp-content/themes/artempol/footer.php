<?php if( ! is_front_page() ) : ?>				
	</div> <!-- /.content -->
<?php endif; ?>
		
<div class="contacts clearfix padding_tb_20">
	<div class="content_wrap">
		<p class="address iconed"><?php echo get_theme_mod( 'footer-address' )?></p>
		<p class="email iconed"><a href="mailto:uglovka@mail.ru"><?php echo get_theme_mod( 'footer-email' )?></a></p>
	</div>
</div>

<?php if ( is_front_page() ) echo get_theme_mod( 'map' ); ?>
	
<div class="content_wrap copyright padding_tb_20">
	<p>© <?php echo get_theme_mod( 'copyright' )?></p>
</div>

<a href="#" class="scroll_to_top button icon-up color_3 textwhite wow fadeInUp" title="<?php esc_html_e( 'Scroll to top', 'artempol' ); ?>"></a>

<?php wp_footer(); ?>

</body>
</html>
