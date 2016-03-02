<div class="post_featured img">
	<?php the_post_thumbnail(); ?>						
</div>

<div class="post_info_wrap info clearfix">
	<div class="info-back">	
		<a href="<?php the_permalink(); ?>"><h4 class="post_title"><?php the_title(); ?></h4></a>
		<div class="post_descr">
			<p class="post_info">
				<span class="post_info_item post_info_posted"><?php the_date(); ?></span>
			</p>
			<p class="content"><?php echo get_the_excerpt(); ?></p>							
		</div>
	</div>	<!-- /.info-back /.info -->
</div><!-- /.post_content -->

