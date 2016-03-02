<?php 

$taxonomy = 'department';

$term = get_queried_object();

$doctors = artempol_get_term_custom_posts( 'doctor', $taxonomy, $term );

$questions = artempol_get_term_custom_posts( 'question', $taxonomy, $term );
					
get_header(); 

?>
<!--Content begin-->
<div class="department clearfix">
	<!--Doctors-->
	<?php if ( $doctors ) : ?>

		<div class="column col_2_3">
			<div class="container">
		
			<?php foreach( $doctors as $post ) : ?> 			
				<?php setup_postdata( $post ); ?>		
				<div class="doctor_info padding_tb_10 clearfix">			
					<?php the_post_thumbnail( 'thumb' ); ?>
					<h4 class="post_title"><?php the_title(); ?></h4>				
					<p class="position textcolor_2 bold"><?php echo get_the_excerpt(); ?></p>				
					<?php the_content(); ?>			
				</div>

			<?php endforeach; ?>

			<?php wp_reset_postdata(); ?>
			
			<!--Questions-->
			<?php if ( $questions ) get_template_part( 'questions' ); ?>
		
			</div>
		</div>
		<!--Question form-->
		<div class="column col_1_3 question_form colored color_2">
			<h2 class="form_title textwhite padding_tb_20 icon-user-md">Консультация</h2>	
			<?php echo do_shortcode( '[contact-form-7 id="1067" title="Question"]' ); ?>
		</div>
	
<?php endif; ?>
</div><!--columns_wrap-->

<?php get_footer(); ?> 
