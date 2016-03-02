<!DOCTYPE html>

<!--[if lte IE 8]>    
<html class="ie8 scheme_original"> 
<![endif]--> 
<html class="scheme_<?php echo ot_get_option( 'scheme', 'original' ) ?>" <?php language_attributes(); ?> >

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name = "format-detection" content = "telephone=no">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="icon" type="image/x-icon" href="" />
	<!--[if IE 8]>    
	<style type="text/css">.content_wrap{width:1170px;margin:0 auto}.logo{width:20%}.menu_main.fullsize{width:80%}h1,h2,h3,h4,h5{padding:1em 0}.col_1_2{width:50%}.col_1_3{width:33.3%}.col_2_3{width:66.6%}.col_3_4{width:75%}.col_1_4{width:25%}.page_title,.breadcrumbs{width: 49%}.login{display:none}.contacts .address{border-right:1pt solid #8e91af}</style>
	<![endif]--> 	
	<!--[if IE 7]>    
	<style type="text/css">.colored_line,.flexslider,.login{display:none}.content_wrap{width:1170px;margin:0 auto}.contacts{height:60pt}.contacts .address{border-right:1pt solid #8e91af}.col_1_2{width:585px}.col_1_3{width:390px}.col_2_3{width:780px}.col_3_4{width:877.5px}.col_1_4{width:292.5px}</style>
	<![endif]--> 
    <?php wp_head(); ?>
</head>

<body>
	<div class="header">
		<div class="clearfix">
			<div class="top_panel_top padding_tb_10">
				<div class="content_wrap clearfix">
					<div class="address left">
						<span class="contact icon-phone"><?php echo ot_get_option( 'top_phone' )?></span>
						<span class="contact icon-home"><?php echo ot_get_option( 'top_address' )?></span>
						<span class="contact icon-clock"><?php echo ot_get_option( 'top_time' )?></span>
					</div>
					<div class="login right">
						<?php if ( ! is_user_logged_in() ) : ?>
							<a href="#popup_login" class="popup_link icon-user"><?php esc_html_e( 'Войти', 'healthandcare' ); ?></a>

							<div id="popup_login" class="popup_wrap color_2 popup_login">
								<a href="#" class="popup_close"></a>
								<form action="<?php echo wp_login_url(); ?>" method="post" name="login_form">
									<input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url('/') ); ?>">
									<span class="icon-user"></span><input type="text" id="log" name="log" value="" placeholder="<?php esc_html_e( 'Логин или e-mail' ); ?>">
									<span class="icon-lock"></span><input type="password" id="password" name="pwd" value="" placeholder="<?php esc_html_e( 'Пароль' ); ?>">				
									<p>
										<a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" class="forgot_password"><?php esc_html_e( 'Забыли пароль?' ); ?></a>
										<input type="checkbox" value="forever" id="rememberme" name="rememberme">
										<label for="rememberme"><?php esc_html_e( 'Запомнить меня' ); ?></label>
									</p>									
									<input type="submit" class="button color_2" value="<?php esc_html_e( 'Войти' ); ?>">
								</form>
							</div>		<!-- /.popup_login -->
						<?php else : $current_user = wp_get_current_user(); ?>
							<a href="<?php echo wp_logout_url( esc_url( home_url('/') ) ); ?>" class="icon icon-logout"><?php esc_html_e( 'Выйти', 'healthandcare' ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>			
		
		<div class="nav">
			<?php get_template_part( 'colored_line' ); ?>		

			<div class="content_wrap clearfix">
				<div class="logo left">
					<p class="iconed textcolor_2"><span>
					
					<?php if ( ! is_front_page() ) : ?> 
						<a href="<?php echo home_url(); ?>"> 
					<?php endif; ?>
					
					Артёмовская поликлиника
					
					<?php if ( ! is_front_page() ) : ?> 
						</a>						
					<?php endif; ?>
					
					</span></p>
				</div>
				<a class="menu_main_responsive_button icon-menu" href="#"></a>
				<?php wp_nav_menu( array ( 
					'menu' 				=> 'main', 
					'container' 		=> '',
					'container_class' 	=> '',
					'menu_class' 		=> 'menu_main fullsize right',
					'menu_id'         	=> 'menu_main',
					'fallback_cb'     	=> 'wp_page_menu', ) ); ?>
			</div>
		</div>
			<?php wp_nav_menu( array ( 
				'menu' 				=> 'main', 
				'container' 		=> '',
				'container_class' 	=> '',
				'menu_class' 		=> 'menu_main responsive',
				'menu_id'         	=> '',
				'fallback_cb'     	=> 'wp_page_menu', ) ); ?>
	</div>
	
	<?php if( ! is_front_page() ) : ?>				
		<?php get_template_part( 'breadcrumbs' ); ?>				
		<!-- content begin -->				
		<div class="content_wrap padding_tb_20">				
	<?php endif; ?>
