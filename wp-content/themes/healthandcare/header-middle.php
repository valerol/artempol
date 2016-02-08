<div class="top_panel_middle">
	<div class="content_wrap">
		<div class="columns_wrap columns_fluid">
			<div class="column-1_4 contact_logo">
				<div class="logo">	
						
						<?php if ( ! is_front_page() ) : ?> 
							<a href="<?php echo home_url(); ?>"> 
						<?php endif; ?>
						
						<span class="icon-user-md"></span>
						<div class="logo_text"><?php echo ot_get_option( 'header_logo_text' ); ?></div>
						
						<?php if ( ! is_front_page() ) : ?> 
							</a>						
						<?php endif; ?>
				</div>
			</div>
			<div class="column-3_4 menu_main_wrap">
				<a class="menu_main_responsive_button icon-menu" href="#"></a>
				<?php wp_nav_menu( array ( 
					'menu' 				=> 'main', 
					'container' 		=> 'nav',
					'container_class' 	=> 'menu_main_nav_area',
					'menu_class' 		=> 'menu_main_nav inited sf-arrows',
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
	</div>
</div> 
