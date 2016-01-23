<?php 

$taxonomy = 'branches';

$branch = get_queried_object();

$doctors = get_posts( 
	array( 
		'post_type' => 'doctor', 
		'tax_query' => 
			array(	
				array( 
					'taxonomy' => 'branches', 
					'field' => 'id', 
					'terms' => $branch ) ) ) ); 

$questions = get_posts( 
	array( 
		'post_type' => 'question', 
		'tax_query' => 
			array(	
				array( 
					'taxonomy' => 'branches', 
					'field' => 'id', 
					'terms' => $branch ) ) ) ); 
					
get_header(); 

get_template_part( 'breadcrumbs' );

?>
<!--Content begin-->
<div class="content_wrap <?php echo $taxonomy; ?>">

	<div class="columns_wrap sc_columns columns_nofluid sc_columns_count_7">
	<!--Doctors-->
	<?php if ( $doctors ) : ?>

		<div class="column-4_7">

		<?php foreach( $doctors as $post ) : ?> 
			
			<?php setup_postdata( $post ); ?>
		
			<div class="doctor_info clearfix">
			
				<?php the_post_thumbnail( 'thumb' ); ?>

				<h4 class="post_title"><?php the_title(); ?></h4>
				
				<p class="red"><?php echo get_the_excerpt(); ?></p>
				
				<?php the_content(); ?>
			
			</div>

		<?php endforeach; ?>

		<?php wp_reset_postdata(); ?>
			
			<!--Questions-->
	<?php if ( $questions ) : ?>
		
		<h2>Вопросы</h2>

		<?php foreach( $questions as $post ) : ?>
			
			<?php setup_postdata( $post ); ?>

				<p><?php the_title(); ?></p>	

				<p><?php the_excerpt(); ?></p>	

				<p><?php the_content(); ?></p>

		<?php endforeach; ?>

		<?php wp_reset_postdata(); ?>

	<?php endif; ?>
		
		</div>
		<!--Question form-->
		<div class="column-3_7">

			<div class="sc_contact_form sc_contact_form_custom sc_contact_form_style_1">

				<h2 class="sc_title sc_title_iconed">

					<span class="sc_title_icon sc_title_icon_top  sc_title_icon_small icon-user-md"></span>
					Консультация

				</h2>
				
				<?php echo do_shortcode( '[contact-form-7 id="1067" title="Question"]' ); ?>
				
			</div>	

		</div>
	
<?php endif; ?>

	</div><!--content_wrap-->

</div><!--columns_wrap-->

<?php get_footer(); ?> 
