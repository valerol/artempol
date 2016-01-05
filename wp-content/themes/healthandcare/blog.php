<?php
/*
Template Name: Blog streampage
*/

global $HEALTHANDCARE_GLOBALS;
$HEALTHANDCARE_GLOBALS['blog_streampage'] = true;

get_header(); 

global $wp_query, $post;

if (empty($blog_style))	$blog_style = healthandcare_get_custom_option('blog_style');
$blog_columns	= max(1, (int) healthandcare_substr($blog_style, -1));
$show_sidebar 	= healthandcare_get_custom_option('show_sidebar_main');
$show_filters 	= healthandcare_get_custom_option('show_filters');
$ppp			= (int) healthandcare_get_custom_option('posts_per_page');
$hover			= healthandcare_get_custom_option('hover_style');
if (empty($hover)) $hover = 'square effect_shift';
$hover_dir		= healthandcare_get_custom_option('hover_dir');
if (empty($hover_dir)) $hover_dir = 'left_to_right';

$page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);

$wp_query_need_restore = false;

$args = $wp_query->query_vars;
$args['post_status'] = current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish';

if ( is_page() || !empty($HEALTHANDCARE_GLOBALS['blog_filters']) ) {
	unset($args['p']);
	unset($args['page_id']);
	unset($args['pagename']);
	unset($args['name']);
	$args['posts_per_page'] = $ppp;
	if ($page_number > 1) {
		$args['paged'] = $page_number;
		$args['ignore_sticky_posts'] = true;
	}
	$args = healthandcare_query_add_sort_order($args);
	$args = healthandcare_query_add_filters($args, !empty($HEALTHANDCARE_GLOBALS['blog_filters']) ? $HEALTHANDCARE_GLOBALS['blog_filters'] : '');
	query_posts( $args );
	$wp_query_need_restore = true;
}

$per_page = count($wp_query->posts);
$post_number = 0;
$parent_tax_id = (int) healthandcare_get_custom_option('taxonomy_id');
$flt_ids = array();

$container = apply_filters('healthandcare_filter_blog_container', healthandcare_get_template_property($blog_style, 'container'), array('style'=>$blog_style, 'dir'=>'horizontal'));
$container_start = $container_end = '';
if (!empty($container)) {
	$container = explode('%s', $container);
	$container_start = !empty($container[0]) ? $container[0] : '';
	$container_end = !empty($container[1]) ? $container[1] : '';
}

echo ($container_start);

if (healthandcare_get_template_property($blog_style, 'need_columns') && $blog_columns > 1) {
	?>
	<div class="columns_wrap <?php echo esc_attr(healthandcare_get_template_property($blog_style, 'container_classes')); ?>">
	<?php
}

if (healthandcare_get_template_property($blog_style, 'need_isotope')) {
	if (!healthandcare_param_is_off($show_filters)) {
		?>
		<div class="isotope_filters"></div>
		<?php
	}
	?>
	<div class="isotope_wrap <?php echo esc_attr(healthandcare_get_template_property($blog_style, 'container_classes')); ?>" data-columns="<?php echo esc_attr($blog_columns); ?>">
	<?php
}

while ( have_posts() ) { the_post(); 
	$post_number++;
	$post_args = array(
		'layout' => $blog_style,
		'number' => $post_number,
		'add_view_more' => false,
		'posts_on_page' => $per_page,
		'columns_count' => $blog_columns,
		// Get post data
		'strip_teaser' => false,
		'content' => healthandcare_get_template_property($blog_style, 'need_content'),
		'terms_list' => !healthandcare_param_is_off($show_filters) || healthandcare_get_template_property($blog_style, 'need_terms'),
		'parent_tax_id' => $parent_tax_id,
		'descr' => healthandcare_get_custom_option('post_excerpt_maxlength'.($blog_columns > 1 ? '_masonry' : '')),
		'sidebar' => !healthandcare_param_is_off($show_sidebar),
		'filters' => $show_filters != 'hide' ? $show_filters : '',
		'hover' => $hover,
		'hover_dir' => $hover_dir
	);

	$post_data = healthandcare_get_post_data($post_args);

	healthandcare_show_post_layout($post_args, $post_data);

	if ($show_filters=='tags') {					// Use tags as filter items
		if (!empty($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms)) {
			foreach ($post_data['post_terms'][$post_data['post_taxonomy_tags']]->terms as $tag) {
				$flt_ids[$tag->term_id] = $tag->name;
			}
		}
	}
}

if (healthandcare_get_template_property($blog_style, 'need_isotope')) {
	?>
	</div> <!-- /.isotope_wrap -->
	<?php 
}

if (healthandcare_get_template_property($blog_style, 'need_columns') && $blog_columns > 1) {
	?>
	</div> <!-- /.columns_wrap -->
	<?php
}

echo ($container_end);

if (!$post_number) { 
	if ( is_search() ) {
		healthandcare_show_post_layout( array('layout' => 'no-search'), false );
	} else {
		healthandcare_show_post_layout( array('layout' => 'no-articles'), false );
	}
} else {
	// Isotope filters list
	$filters = '';
	$filter_button_classes = 'isotope_filters_button';
	if ($show_filters == 'categories') {			// Use categories as filter items
		$taxonomy = healthandcare_is_taxonomy();
		$cur_term = $taxonomy ? healthandcare_get_current_term($taxonomy) : 0;
		$cur_term_id = $cur_term ? $cur_term->term_id : 0;
		$portfolio_parent = $cur_term_id ? max(0, healthandcare_get_parent_taxonomy_by_property($cur_term_id, 'show_filters', 'yes', true, $taxonomy)) : 0;
		$args2 = array(
			'type'			=> !empty($args['post_type']) ? $args['post_type'] : 'post',
			'child_of'		=> $portfolio_parent,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'include'		=> '',
			'number'		=> '',
			'taxonomy'		=> $taxonomy,
			'pad_counts'	=> false
		);
		$portfolio_list = get_categories($args2);
		if (is_array($portfolio_list) && count($portfolio_list) > 0) {
			$filters .= '<a href="#" data-filter="*" class="'.esc_attr($filter_button_classes . ($portfolio_parent==$cur_term_id ? ' active' : '')) . '">' . esc_html__('All', 'healthandcare').'</a>';
			foreach ($portfolio_list as $cat) {
				if (isset($cat->term_id)) $filters .= '<a href="#" data-filter=".flt_'.esc_attr($cat->term_id).'" class="'.esc_attr($filter_button_classes . ($cat->term_id==$cur_term_id ? ' active' : '')).'">'.($cat->name).'</a>';
			}
		}
	} else if ($show_filters == 'tags') {																	// Use tags as filter items
		if (is_array($flt_ids) && count($flt_ids) > 0) {
			$filters .= '<a href="#" data-filter="*" class="'.esc_attr($filter_button_classes).' active">'.esc_html__('All', 'healthandcare').'</a>';
			foreach ($flt_ids as $flt_id=>$flt_name) {
				$filters .= '<a href="#" data-filter=".flt_'.esc_attr($flt_id).'" class="'.esc_attr($filter_button_classes).'">'.($flt_name).'</a>';
			}
		}
	}
	if ($filters) {
		?>
		<script type="text/javascript">
			jQuery(document).ready(function () {
				HEALTHANDCARE_GLOBALS['ppp'] = <?php echo intval($ppp); ?>;
				jQuery(".isotope_filters").append('<?php echo ($filters); ?>');
			});
		</script>
		<?php
	}
}

if ($post_number > 0) {
	// Pagination
	$pagination = healthandcare_get_custom_option('blog_pagination');
	if (in_array($pagination, array('viewmore', 'infinite'))) {
		if ($page_number < $wp_query->max_num_pages) {
			?>
			<div id="viewmore" class="pagination_wrap pagination_<?php echo esc_attr($pagination); ?>">
				<a href="#" id="viewmore_link" class="theme_button viewmore_button"><span class="icon-spin3 animate-spin viewmore_loading"></span><span class="viewmore_text_1"><?php esc_html_e('LOAD MORE', 'healthandcare'); ?></span><span class="viewmore_text_2"><?php esc_html_e('Loading ...', 'healthandcare'); ?></span></a>
				<span class="viewmore_loader"></span>
				<script type="text/javascript">
					jQuery(document).ready(function () {
						HEALTHANDCARE_GLOBALS['viewmore_page'] = <?php echo intval($page_number); ?>;
						HEALTHANDCARE_GLOBALS['viewmore_data'] = '<?php echo str_replace("'", "\\'", serialize($args)); ?>';
						HEALTHANDCARE_GLOBALS['viewmore_vars'] = '<?php echo str_replace("'", "\\'", serialize(array(
							'blog_style' => $blog_style,
							'columns_count' => $blog_columns,
							'parent_tax_id' => $parent_tax_id,
							'show_sidebar' => $show_sidebar,
							'filters' => $show_filters!='hide' ? $show_filters : '',
							'hover' => $hover,
							'hover_dir' => $hover_dir,
							'ppp' => $ppp
						))); ?>';
					});
				</script>
			</div>
			<?php
		}
	} else {
		healthandcare_show_pagination(array(
			'class' => 'pagination_wrap pagination_'.esc_attr(healthandcare_get_theme_option('blog_pagination_style')),
			'style' => healthandcare_get_theme_option('blog_pagination_style'),
			'button_class' => '',
			'first_text'=> '',
			'last_text' => '',
			'prev_text' => '',
			'next_text' => '',
			'pages_in_group' => healthandcare_get_theme_option('blog_pagination_style')=='pages' ? 10 : 20
			)
		);
	}
}

// Add template specific scripts and styles
do_action('healthandcare_action_blog_scripts', $blog_style);

wp_reset_postdata();

get_footer();
?>