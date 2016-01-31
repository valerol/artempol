<a href="<?php the_permalink(); ?>">
	<div class="post_featured img">
		<?php the_post_thumbnail(); ?>						
	</div>
	
	<div class="post_info_wrap info clearfix">
		<div class="info-back">	
			<h4 class="post_title"><?php the_title(); ?></h4>
			<div class="post_descr">
				<p class="post_info">
					<span class="post_info_item post_info_posted"><?php the_date(); ?></span>
				</p>
				<p><?php the_excerpt(); ?></p>							
			</div>
		</div>	<!-- /.info-back /.info -->
	</div><!-- /.post_content -->
</a> 
