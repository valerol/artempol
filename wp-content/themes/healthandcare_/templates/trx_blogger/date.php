<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'healthandcare_template_date_theme_setup' ) ) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_template_date_theme_setup', 1 );
	function healthandcare_template_date_theme_setup() {
		healthandcare_add_template(array(
			'layout' => 'date',
			'mode'   => 'blogger',
			'title'  => esc_html__('Blogger layout: Timeline', 'healthandcare')
			));
	}
}

// Template output
if ( !function_exists( 'healthandcare_template_date_output' ) ) {
	function healthandcare_template_date_output($post_options, $post_data) {
		if (healthandcare_param_is_on($post_options['scroll'])) healthandcare_enqueue_slider();
		require(healthandcare_get_file_dir('templates/_parts/reviews-summary.php'));
		?>
		
		<div class="post_item sc_blogger_item
			<?php echo ($post_options['number'] == $post_options['posts_on_page'] && !healthandcare_param_is_on($post_options['loadmore']) ? ' sc_blogger_item_last' : '');
				//. (healthandcare_param_is_on($post_options['scroll']) ? ' sc_scroll_slide swiper-slide' : ''); ?>"
			<?php echo ($post_options['dir'] == 'horizontal' ? ' style="width:'.(100/$post_options['posts_on_page']).'%"' : ''); ?>>
			<div class="sc_blogger_date">
				<span class="day_month"><?php echo ($post_data['post_date_part1']); ?></span>
				<span class="year"><?php echo ($post_data['post_date_part2']); ?></span>
			</div>

			<div class="post_content">
				<h6 class="post_title sc_title sc_blogger_title">
					<?php echo (!isset($post_options['links']) || $post_options['links'] ? '<a href="' . esc_url($post_data['post_link']) . '">' : ''); ?>
					<?php echo ($post_data['post_title']); ?>
					<?php echo (!isset($post_options['links']) || $post_options['links'] ? '</a>' : ''); ?>
				</h6>
				
				<?php echo ($reviews_summary); ?>
	
				<?php if (healthandcare_param_is_on($post_options['info'])) { ?>
				<div class="post_info">
					<span class="post_info_item post_info_posted_by"><?php esc_html_e('by', 'healthandcare'); ?> <a href="<?php echo esc_url($post_data['post_author_url']); ?>" class="post_info_author"><?php echo esc_html($post_data['post_author']); ?></a></span>
					<span class="post_info_item post_info_counters">
						<?php echo ($post_options['orderby']=='comments' || $post_options['counters']=='comments' ? esc_html__('Comments', 'healthandcare') : esc_html__('Views', 'healthandcare')); ?>
						<span class="post_info_counters_number"><?php echo ($post_options['orderby']=='comments' || $post_options['counters']=='comments' ? $post_data['post_comments'] : $post_data['post_views']); ?></span>
					</span>
				</div>
				<?php } ?>

			</div>	<!-- /.post_content -->
		
		</div>		<!-- /.post_item -->

		<?php
		if ($post_options['number'] == $post_options['posts_on_page'] && healthandcare_param_is_on($post_options['loadmore'])) {
		?>
			<div class="load_more<?php //echo esc_attr(healthandcare_param_is_on($post_options['scroll']) && $post_options['dir'] == 'vertical' ? ' sc_scroll_slide swiper-slide' : ''); ?>"<?php echo ($post_options['dir'] == 'horizontal' ? ' style="width:'.(100/$post_options['posts_on_page']).'%"' : ''); ?>></div>
		<?php
		}
	}
}
?>