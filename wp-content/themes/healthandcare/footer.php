<?php if( ! is_front_page() ) : ?>				
	</div> <!-- /.content -->
<?php endif; ?>
		
<div class="contacts clearfix padding_tb_20">
	<div class="content_wrap">
		<p class="address iconed"><?php echo ot_get_option( 'footer_address' )?></p>
		<p class="email iconed"><a href="mailto:uglovka@mail.ru"><?php echo ot_get_option( 'footer_email' )?></a></p>
	</div>
</div>

<?php if ( is_front_page() ) get_template_part( 'map' ); ?>
	
<div class="content_wrap copyright padding_tb_20">
	<p>© <?php echo ot_get_option( 'footer_copyright' )?>, 2014<?php echo '&ndash;' . date( 'o' ) ; ?></p>
</div>

<a href="#" class="scroll_to_top button icon-up color_3 textwhite wow fadeInUp" title="<?php esc_html_e( 'Scroll to top', 'healthandcare' ); ?>"></a>

<?php wp_footer(); ?>

</body>
</html>
