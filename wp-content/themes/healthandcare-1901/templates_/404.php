<?php
/*
 * The template for displaying "Page 404"
*/

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'healthandcare_template_404_theme_setup' ) ) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_template_404_theme_setup', 1 );
	function healthandcare_template_404_theme_setup() {
		healthandcare_add_template(array(
			'layout' => '404',
			'mode'   => 'internal',
			'title'  => 'Page 404',
			'theme_options' => array(
				'article_style' => 'stretch'
			),
			'w'		 => null,
			'h'		 => null
			));
	}
}
// Template output
if ( !function_exists( 'healthandcare_template_404_output' ) ) {
	function healthandcare_template_404_output() {
        global $HEALTHANDCARE_GLOBALS;
		?>
		<article class="post_item post_item_404">
			<div class="post_content">
				<h1 class="page_title"><?php esc_html_e( '404', 'healthandcare' ); ?></h1>
				<h2 class="page_subtitle"><?php esc_html_e('The requested page cannot be found', 'healthandcare'); ?></h2>
				<p class="page_description"><?php echo sprintf( wp_kses(__('Can\'t find what you need? Take a moment and do a search below or start from <a href="%s">our homepage</a>.', 'healthandcare'), $HEALTHANDCARE_GLOBALS['allowed_tags'] ), esc_url( home_url('/') ) ); ?></p>
				<div class="page_search"><?php echo healthandcare_do_shortcode('[trx_search style="flat" open="fixed" title="'.esc_html__('To search type and hit enter', 'healthandcare').'"]'); ?></div>
			</div>
		</article>
		<?php
	}
}
?>