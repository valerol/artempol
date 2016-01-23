<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'healthandcare_template_header_4_theme_setup' ) ) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_template_header_4_theme_setup', 1 );
	function healthandcare_template_header_4_theme_setup() {
		healthandcare_add_template(array(
			'layout' => 'header_4',
			'mode'   => 'header',
			'title'  => esc_html__('Header 4', 'healthandcare'),
			'icon'   => healthandcare_get_file_url('templates/headers/images/4.jpg')
			));
	}
}

// Template output
if ( !function_exists( 'healthandcare_template_header_4_output' ) ) {
	function healthandcare_template_header_4_output($post_options, $post_data) {
		global $HEALTHANDCARE_GLOBALS;

		// WP custom header
		$header_css = '';
		if ($post_options['position'] != 'over') {
			$header_image = get_header_image();
			$header_css = $header_image!='' 
				? ' style="background: url('.esc_url($header_image).') repeat center top"' 
				: '';
		}
		?>
		

		<div class="top_panel_fixed_wrap"></div>

		<header class="top_panel_wrap top_panel_style_4 scheme_<?php echo esc_attr($post_options['scheme']); ?>">
			<div class="top_panel_wrap_inner top_panel_inner_style_4 top_panel_position_<?php echo esc_attr(healthandcare_get_custom_option('top_panel_position')); ?>">
			
			<?php if (healthandcare_get_custom_option('show_top_panel_top')=='yes') { ?>
				<div class="top_panel_top">
					<div class="content_wrap clearfix">
						<?php
						$top_panel_top_components = array('contact_info', 'search', 'login', 'cart', 'currency', 'bookmarks');
						require_once( healthandcare_get_file_dir('templates/headers/_parts/top-panel-top.php') );
						?>
					</div>
				</div>
			<?php } ?>
            <div class="colored_line">
                <div class="colored_line_color1"></div>
                <div class="colored_line_color2"></div>
                <div class="colored_line_color3"></div>
                <div class="colored_line_color4"></div>
            </div>
			<div class="top_panel_middle" <?php echo ($header_css); ?>>
				<div class="content_wrap">
					<div class="columns_wrap columns_fluid"><div
						class="column-1_4 contact_logo">
							<?php require_once( healthandcare_get_file_dir('templates/headers/_parts/logo.php') ); ?>
						</div><div 
						class="column-3_4 menu_main_wrap">
							<a href="#" class="menu_main_responsive_button icon-menu"></a>
							<nav role="navigation" class="menu_main_nav_area">
								<?php
								if (empty($HEALTHANDCARE_GLOBALS['menu_main'])) $HEALTHANDCARE_GLOBALS['menu_main'] = healthandcare_get_nav_menu('menu_main');
								if (empty($HEALTHANDCARE_GLOBALS['menu_main'])) $HEALTHANDCARE_GLOBALS['menu_main'] = healthandcare_get_nav_menu();
								echo ($HEALTHANDCARE_GLOBALS['menu_main']);
								?>
							</nav>
                            <?php
                            if (healthandcare_get_custom_option('show_search')=='yes')
                                echo healthandcare_do_shortcode('[trx_search class="top_panel_icon" state="closed"]');
                            ?>
						</div>
					</div>
				</div>
			</div>
			</div>
		</header>

		<?php
	}
}
?>