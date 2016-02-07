<!DOCTYPE html>

<html class="scheme_original js_active vc_desktop vc_transform" <?php language_attributes(); ?> >

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name = "format-detection" content = "telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="icon" type="image/x-icon" href="" />
    <?php wp_head(); ?>
</head>

<body class="healthandcare_body body_style_fullscreen body_filled theme_skin_healthandcare article_style_stretch layout_single-standard template_single-standard top_panel_show top_panel_above sidebar_hide sidebar_outer_hide wpb-js-composer js-comp-ver-4.8.1 vc_responsive">

	<?php // Add TOC items 'Home' and "To top" ?>

	<div class="body_wrap">
		<div class="page_wrap">			
			<header class="top_panel_wrap top_panel_style_4 scheme_original menu_show">
				<div class="top_panel_wrap_inner top_panel_inner_style_4 top_panel_position_above">
					<?php get_template_part( 'header', 'top' ); ?>
					<?php get_template_part( 'colored_line' ); ?>
					<?php get_template_part( 'header', 'middle' ); ?>
				</div>
			</header>
			
			<?php if( ! is_front_page() ) : ?>				
				<?php //get_template_part( 'breadcrumbs' ); ?>				
				
				<!-- content begin -->				
				<div class="content_wrap content">				
			<?php endif; ?>

<?php var_dump($wp_query); ?>
<?php //echo esc_attr(wp_create_nonce('ajax_nonce')); ?>
<?php //echo esc_url(admin_url('admin-ajax.php')); ?>
