<script>	
jQuery(document).ready(function() {
   jQuery('ul#menu_main').superfish({
      delay:       1000,                            // задержка в миллисекунду
      animation:   {opacity:'show',height:'show'},  // fade-in и slide-down анимация
      speed:       'fast',                          // увеличение скорости анимации
      autoArrows:  false,                           // отключает стрелку подменю
      dropShadows: false                            // отключает тень
   });
});
</script>

<div class="top_panel_middle">
	<div class="content_wrap">
		<div class="columns_wrap columns_fluid">
			<div class="column-1_4 contact_logo">
				<div class="logo">
					<a href="http://healthandcare.ancorathemes.com/">
						<img alt="" class="logo_main" src="http://healthandcare.ancorathemes.com/wp-content/uploads/2015/09/logo_hospital.png"><img alt="" class="logo_fixed" src="http://healthandcare.ancorathemes.com/wp-content/uploads/2015/09/logo_hospital.png">
						<div class="logo_text"><?php echo ot_get_option( 'header_logo_text' ); ?></div>
					</a>
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
                <div class="search_wrap search_style_regular search_state_closed search_ajax top_panel_icon inited">
					<div class="search_form_wrap">
						<form action="http://healthandcare.ancorathemes.com/" class="search_form" method="get" role="search">
							<button title="Open search" class="search_submit icon-search-light" type="submit"></button>
							<input type="text" title="Search" name="s" value="" placeholder="Search" class="search_field">
						</form>
					</div>
					<div class="search_results widget_area scheme_original">
						<a class="search_results_close icon-cancel"></a>
						<div class="search_results_content"></div>
					</div>
				</div>						
				<ul class="menu_main_responsive">
					<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-ancestor current-menu-parent menu-item-has-children menu-item-79" id="menu-item-79"><a>Home</a>
						<ul class="sub-menu">
							<li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-183 current_page_item menu-item-191" id="menu-item-191">
								<a href="http://healthandcare.ancorathemes.com/">Home</a>
							</li>
							<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-192" id="menu-item-192">
								<a href="http://healthandcare.ancorathemes.com/home-boxed/">Home Boxed</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div> 
