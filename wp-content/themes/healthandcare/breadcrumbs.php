<div class="page_header">
	<div class="content_wrap clearfix padding_tb_10">
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

