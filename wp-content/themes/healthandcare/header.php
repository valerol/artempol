<!DOCTYPE html>

<!--[if lte IE 8]>    
<html class="ie8 scheme_original"> 
<![endif]--> 
<html class="scheme_original" <?php language_attributes(); ?> >

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name = "format-detection" content = "telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="icon" type="image/x-icon" href="" />
    <?php wp_head(); ?>
</head>

<body>
	<header>
		<div class="top_panel_top">
			<div class="content_wrap clearfix">
				<div class="left">
					<span class="contact icon-phone"><?php echo ot_get_option( 'header_phone' ); ?></span>
					<span class="contact icon-home"><?php echo ot_get_option( 'header_address' ); ?></span>
					<span class="contact icon-clock"><?php echo ot_get_option( 'header_working_hours' ); ?></span>
				</div>
				<div class="right">
					<?php if ( ! is_user_logged_in() ) : ?>
						<a href="#popup_login" class="popup_link popup_login_link icon-user"><?php esc_html_e( 'Login', 'healthandcare' ); ?></a>

						<div id="popup_login" class="popup_wrap popup_login bg_tint_light">
							<a href="#" class="popup_close"></a>
							<div class="form_wrap">
								<div class="form_left">
									<form action="<?php echo wp_login_url(); ?>" method="post" name="login_form" class="popup_form login_form">
										<input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url('/') ); ?>">
										<div class="popup_form_field login_field iconed_field icon-user"><input type="text" id="log" name="log" value="" placeholder="<?php esc_html_e('Login or Email', 'healthandcare'); ?>"></div>
										<div class="popup_form_field password_field iconed_field icon-lock"><input type="password" id="password" name="pwd" value="" placeholder="<?php esc_html_e('Password', 'healthandcare'); ?>"></div>
										<div class="popup_form_field remember_field">
											<a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" class="forgot_password"><?php esc_html_e('Forgot password?', 'healthandcare'); ?></a>
											<input type="checkbox" value="forever" id="rememberme" name="rememberme">
											<label for="rememberme"><?php esc_html_e('Remember me', 'healthandcare'); ?></label>
										</div>
										<div class="popup_form_field submit_field"><input type="submit" class="submit_button" value="<?php esc_html_e('Login', 'healthandcare'); ?>"></div>
									</form>
								</div>
							</div>	<!-- /.login_wrap -->
						</div>		<!-- /.popup_login -->
					<?php else : $current_user = wp_get_current_user(); ?>
						<a href="<?php echo wp_logout_url( esc_url( home_url('/') ) ); ?>" class="icon icon-logout"><?php esc_html_e( 'Logout', 'healthandcare' ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>			
		
		<?php get_template_part( 'colored_line' ); ?>		

			<div class="content_wrap columns_wrap">
					<div class="column-1_4 contact_logo">
						<div class="logo">
								
							<?php if ( ! is_front_page() ) : ?> 
								<a href="<?php echo home_url(); ?>"> 
							<?php endif; ?>
							
							<span class="icon-user-md left"></span>
							<?php echo ot_get_option( 'header_logo_text' ); ?>
							
							<?php if ( ! is_front_page() ) : ?> 
								</a>						
							<?php endif; ?>
						</div>
					</div>
					<div class="right column-3_4">
						<a class="menu_main_responsive_button icon-menu" href="#"></a>
						<?php wp_nav_menu( array ( 
							'menu' 				=> 'main', 
							'container' 		=> '',
							'container_class' 	=> '',
							'menu_class' 		=> 'menu_main',
							'menu_id'         	=> 'menu_main',
							'fallback_cb'     	=> 'wp_page_menu', ) ); ?>				
						<?php wp_nav_menu( array ( 
							'menu' 				=> 'main', 
							'container' 		=> '',
							'container_class' 	=> '',
							'menu_class' 		=> 'menu_main_responsive',
							'menu_id'         	=> '',
							'fallback_cb'     	=> 'wp_page_menu', ) ); ?>				
					</div>
			</div>
	</header>
	
	<?php if( ! is_front_page() ) : ?>				
		<?php get_template_part( 'breadcrumbs' ); ?>				
		<!-- content begin -->				
		<div class="content_wrap content">				
	<?php endif; ?>

<?php //var_dump($wp_query); ?>
<?php //echo esc_attr(wp_create_nonce('ajax_nonce')); ?>
<?php //echo esc_url(admin_url('admin-ajax.php')); ?>