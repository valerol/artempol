<?php
/*
Template Name: Main page
*/

get_header(); 

while( have_posts() ) { 
    the_post();
?>
    
<article class="main">
    <div class="column-1_2 left">
    <?php the_post_thumbnail( 'thumb' ); ?>
<!--    <span class="sc_title_icon sc_title_icon_top  sc_title_icon_small icon-heartbeat left"></span>-->
    <h1 class="sc_title sc_title_iconed"><?php the_title(); ?></h1>
    </div>
    <div class="column-1_2 right">
    <?php the_content(); ?>
    </div>
</article>
    
<?php } 

get_footer();

?>