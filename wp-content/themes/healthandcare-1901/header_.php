<?php
/**
 * The Header for our theme.
 */

global $HEALTHANDCARE_GLOBALS;


// Theme init - don't remove next row! Load custom options
healthandcare_core_init_theme();

$theme_skin = healthandcare_esc(healthandcare_get_custom_option('theme_skin'));
$body_scheme = healthandcare_get_custom_option('body_scheme');
if (empty($body_scheme)  || healthandcare_is_inherit_option($body_scheme)) $body_scheme = 'original';
$blog_style = healthandcare_get_custom_option(is_singular() && !healthandcare_get_global('blog_streampage') ? 'single_style' : 'blog_style');
$body_style  = healthandcare_get_custom_option('body_style');
$article_style = healthandcare_get_custom_option('article_style');
$top_panel_style = healthandcare_get_custom_option('top_panel_style');
$top_panel_position = healthandcare_get_custom_option('top_panel_position');
$top_panel_scheme = healthandcare_get_custom_option('top_panel_scheme');
$video_bg_show  = healthandcare_get_custom_option('show_video_bg')=='yes' && (healthandcare_get_custom_option('video_bg_youtube_code')!='' || healthandcare_get_custom_option('video_bg_url')!='');
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo esc_attr('scheme_'.$body_scheme); ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name = "format-detection" content = "telephone=no">
	<?php
	if (healthandcare_get_theme_option('responsive_layouts') == 'yes') {
		?>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<?php
	}
	if (floatval(get_bloginfo('version')) < "4.1") {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	?>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <?php
	$favicon = healthandcare_get_custom_option('favicon');
	if (!$favicon) {
		if ( file_exists(healthandcare_get_file_dir('skins/'.($theme_skin).'/images/favicon.ico')) )
			$favicon = healthandcare_get_file_url('skins/'.($theme_skin).'/images/favicon.ico');
		if ( !$favicon && file_exists(healthandcare_get_file_dir('favicon.ico')) )
			$favicon = healthandcare_get_file_url('favicon.ico');
	}
    if ( ! function_exists( 'wp_site_icon' ) || ! wp_site_icon() ) {
        if ($favicon) {
            ?>
            <link rel="icon" type="image/x-icon" href="<?php echo esc_url($favicon); ?>"/>
            <?php
        }
    }
	
	wp_head();
	?>
</head>

<body <?php 
	body_class('healthandcare_body body_style_' . esc_attr($body_style)
		. ' body_' . (healthandcare_get_custom_option('body_filled')=='yes' ? 'filled' : 'transparent')
		. ' theme_skin_' . esc_attr($theme_skin)
		. ' article_style_' . esc_attr($article_style)
		. ' layout_' . esc_attr($blog_style)
		. ' template_' . esc_attr(healthandcare_get_template_name($blog_style))
		. (!healthandcare_param_is_off($top_panel_position) ? ' top_panel_show top_panel_' . esc_attr($top_panel_position) : 'top_panel_hide')
		. ' ' . esc_attr(healthandcare_get_sidebar_class())
		. ($video_bg_show ? ' video_bg_show' : '')
	);
	?>
>

	<?php echo force_balance_tags(healthandcare_get_custom_option('gtm_code')); ?>

	<?php do_action( 'before' ); ?>

	<?php
	// Add TOC items 'Home' and "To top"
	if (healthandcare_get_custom_option('menu_toc_home')=='yes') echo healthandcare_do_shortcode( '[trx_anchor id="toc_home" title="'.esc_html__('Home', 'healthandcare').'" description="'.esc_html__('{{Return to Home}} - ||navigate to home page of the site', 'healthandcare').'" icon="icon-home" separator="yes" url="'.esc_url( home_url('/') ).'"]' );
	if (healthandcare_get_custom_option('menu_toc_top')=='yes') echo healthandcare_do_shortcode( '[trx_anchor id="toc_top" title="'.esc_html__('To Top', 'healthandcare').'" description="'.esc_html__('{{Back to top}} - ||scroll to top of the page', 'healthandcare').'" icon="icon-double-up" separator="yes"]' );
	?>

	<?php if ( !healthandcare_param_is_off(healthandcare_get_custom_option('show_sidebar_outer')) ) { ?>
	<div class="outer_wrap">
	<?php } ?>

	<?php require_once( healthandcare_get_file_dir('sidebar_outer.php') ); ?>

	<?php
		$class = $style = '';
		if ($body_style=='boxed' || healthandcare_get_custom_option('bg_image_load')=='always') {
			$customizer = healthandcare_get_theme_option('show_theme_customizer') == 'yes';
			if ($customizer && ($img = (int) healthandcare_get_value_gpc('bg_image', 0)) > 0)
				$class = 'bg_image_'.($img);
			else if ($customizer && ($img = (int) healthandcare_get_value_gpc('bg_pattern', 0)) > 0)
				$class = 'bg_pattern_'.($img);
			else if ($customizer && ($img = healthandcare_get_value_gpc('bg_color', '')) != '')
				$style = 'background-color: '.($img).';';
			else if (healthandcare_get_custom_option('bg_custom')=='yes') {
				if (($img = healthandcare_get_custom_option('bg_image_custom')) != '')
					$style = 'background: url('.esc_url($img).') ' . str_replace('_', ' ', healthandcare_get_custom_option('bg_image_custom_position')) . ' no-repeat fixed;';
				else if (($img = healthandcare_get_custom_option('bg_pattern_custom')) != '')
					$style = 'background: url('.esc_url($img).') 0 0 repeat fixed;';
				else if (($img = healthandcare_get_custom_option('bg_image')) > 0)
					$class = 'bg_image_'.($img);
				else if (($img = healthandcare_get_custom_option('bg_pattern')) > 0)
					$class = 'bg_pattern_'.($img);
				if (($img = healthandcare_get_custom_option('bg_color')) != '')
					$style .= 'background-color: '.($img).';';
			}
		}
	?>

	<div class="body_wrap<?php echo ($class ? ' '.esc_attr($class) : ''); ?>"<?php echo ($style ? ' style="'.esc_attr($style).'"' : ''); ?>>

		<?php
		if ($video_bg_show) {
			$youtube = healthandcare_get_custom_option('video_bg_youtube_code');
			$video   = healthandcare_get_custom_option('video_bg_url');
			$overlay = healthandcare_get_custom_option('video_bg_overlay')=='yes';
			if (!empty($youtube)) {
				?>
				<div class="video_bg<?php echo ($overlay ? ' video_bg_overlay' : ''); ?>" data-youtube-code="<?php echo esc_attr($youtube); ?>"></div>
				<?php
			} else if (!empty($video)) {
				$info = pathinfo($video);
				$ext = !empty($info['extension']) ? $info['extension'] : 'src';
				?>
				<div class="video_bg<?php echo esc_attr($overlay) ? ' video_bg_overlay' : ''; ?>"><video class="video_bg_tag" width="1280" height="720" data-width="1280" data-height="720" data-ratio="16:9" preload="metadata" autoplay loop src="<?php echo esc_url($video); ?>"><source src="<?php echo esc_url($video); ?>" type="video/<?php echo esc_attr($ext); ?>"></source></video></div>
				<?php
			}
		}
		?>

		<div class="page_wrap">

			<?php
			// Top panel 'Above' or 'Over'
			if (in_array($top_panel_position, array('above', 'over'))) {
				healthandcare_show_post_layout(array(
					'layout' => $top_panel_style,
					'position' => $top_panel_position,
					'scheme' => $top_panel_scheme
					), false);
			}
			// Slider
//			require_once( healthandcare_get_file_dir('templates/headers/_parts/slider.php') );
			if ( is_front_page() ) {
				echo do_shortcode('[smartslider2 slider="3"]');
			}
			// Top panel 'Below'
			if ($top_panel_position == 'below') {
				healthandcare_show_post_layout(array(
					'layout' => $top_panel_style,
					'position' => $top_panel_position,
					'scheme' => $top_panel_scheme
					), false);
			}

			// Top of page section: page title and breadcrumbs
			$show_title = healthandcare_get_custom_option('show_page_title')=='yes';
			$show_breadcrumbs = healthandcare_get_custom_option('show_breadcrumbs')=='yes';
			if ($show_title || $show_breadcrumbs) {
				?>
				<div class="top_panel_title top_panel_style_<?php echo esc_attr(str_replace('header_', '', $top_panel_style)); ?> <?php echo ($show_title ? ' title_present' : '') . ($show_breadcrumbs ? ' breadcrumbs_present' : ''); ?> scheme_<?php echo esc_attr($top_panel_scheme); ?>">
					<div class="top_panel_title_inner top_panel_inner_style_<?php echo esc_attr(str_replace('header_', '', $top_panel_style)); ?> <?php echo ($show_title ? ' title_present_inner' : '') . ($show_breadcrumbs ? ' breadcrumbs_present_inner' : ''); ?>">
						<div class="content_wrap">
							<?php if ($show_title) { ?>
								<h1 class="page_title"><?php echo strip_tags(healthandcare_get_blog_title()); ?></h1>
							<?php } ?>
							<?php if ($show_breadcrumbs) { ?>
								<div class="breadcrumbs">
									<?php if (!is_404()) healthandcare_show_breadcrumbs(); ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php
			}
			?>

			<div class="page_content_wrap">

				<?php
				// Content and sidebar wrapper
				if ($body_style!='fullscreen') healthandcare_open_wrapper('<div class="content_wrap">');
				
				// Main content wrapper
				healthandcare_open_wrapper('<div class="content">');
				?>
