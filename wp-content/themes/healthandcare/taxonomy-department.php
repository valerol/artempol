<?php 

$taxonomy = 'department';

$term = get_queried_object();

$doctors = artempol_get_term_custom_posts( 'doctor', $taxonomy, $term );

$questions = artempol_get_term_custom_posts( 'question', $taxonomy, $term );
					
get_header(); 

?>
<!--Content begin-->
<div class="content_wrap content <?php echo $taxonomy; ?>">

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
			
				<?php $author = get_user_by( 'login', get_the_author() ); ?>
				
				<?php $author_name = ( $author->first_name ? $author->first_name : '' ); ?>
				
				<?php $author_name .= ( $author_name && $author->last_name ?  ' ' . $author->last_name : '' ); ?>

				<div class="question-answer">
				
					<p class="question"><b><?php the_title(); ?>: </b> <?php echo get_the_excerpt(); ?></p>
				
					<b><?php echo ( $author_name ? 'Отвечает ' . $author_name : 'Ответ' ); ?>:</b>
				
					<?php echo get_the_content(); ?>
				
				</div>

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
