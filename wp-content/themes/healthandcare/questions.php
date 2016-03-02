<?php
global $taxonomy;

global $term;

global $questions;
?>

<h2>Вопросы</h2>

<?php foreach( $questions as $post ) : ?>
	
	<?php setup_postdata( $post ); ?>
	
		<?php $author = get_user_by( 'login', get_the_author() ); ?>
		
		<?php $author_name = ( $author->first_name ? $author->first_name : '' ); ?>
		
		<?php $author_name .= ( $author_name && $author->last_name ?  ' ' . $author->last_name : '' ); ?>
		
		<article class="question padding_tb_10">		
			<p class="question color_4 textwhite"><b><?php the_title(); ?>: </b> <?php echo get_the_excerpt(); ?></p>		
			<p class="bold"><?php echo ( $author_name ? 'Отвечает ' . $author_name : 'Ответ' ); ?>:</p>		
			<?php echo get_the_content(); ?>			
		</article>

<?php endforeach; ?>

<?php wp_reset_postdata(); ?>