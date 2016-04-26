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

<!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter36997590 = new Ya.Metrika({ id:36997590, clickmap:true, trackLinks:true, accurateTrackBounce:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/36997590" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->

</body>
</html>
