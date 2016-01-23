<?php
/**
Template Name: Single post
 */
get_header(); 

if (empty($single_style)) $single_style = healthandcare_get_custom_option('single_style');

while ( have_posts() ) { the_post();

	// Move healthandcare_set_post_views to the javascript - counter will work under cache system
	if (healthandcare_get_custom_option('use_ajax_views_counter')=='no') {
		healthandcare_set_post_views(get_the_ID());
	}

	healthandcare_show_post_layout(
		array(
			'layout' => $single_style,
			'sidebar' => !healthandcare_param_is_off(healthandcare_get_custom_option('show_sidebar_main')),
			'content' => healthandcare_get_template_property($single_style, 'need_content'),
			'terms_list' => healthandcare_get_template_property($single_style, 'need_terms')
		)
	);

}

get_footer();
?>