<div class="top_panel_title top_panel_style_4  title_present breadcrumbs_present scheme_original">
	<div class="top_panel_title_inner top_panel_inner_style_4  title_present_inner breadcrumbs_present_inner">
		<div class="content_wrap">
			<h1 class="page_title">
				<?php is_single() || is_page() ? the_title() : single_cat_title(); ?>
			</h1>
			<div class="breadcrumbs">
				<?php echo artempol_breadcrumbs(

					'<span class="breadcrumbs_delimiter"></span>', 

					'breadcrumbs_item all',

					'<span class="breadcrumbs_item current">',

					'</span>' 
				); ?>
			</div>
		</div>
	</div>
</div> 
