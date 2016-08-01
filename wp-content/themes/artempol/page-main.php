<?php

// Header
get_header(); 

// Slider
$slides = artempol_get_posts( 'slide', array( 'category_name' => 'slider' ), array( 'image_url', 'title', 'content' ) );

if ( $slides ) {
	$slider = artempol_container( array( 'tag' => 'ul', 'content' => $slides, 'class' => 'slides' ) );
	$slider = artempol_container( array( 'tag' => 'div', 'content' => $slider, 'class' => 'slider-main banner flexslider' ) );
	echo $slider;
}

// Greeting text (main post)
if ( have_posts() ) { 
	$greeting = artempol_get_post( $post, 'greeting', array( 'title', 'title2', 'content' ) );
	echo $greeting;
}

// Colored_blocks
$colored_blocks = artempol_get_posts( 'colored', array( 'category_name' => 'colorblocks' ), array( 'counter', 'title', 'content' ) );

if ( $colored_blocks ) {
	$colored_blocks = artempol_container( array( 'tag' => 'div', 'content' => $colored_blocks, 'class' => 'content_wrap clearfix padding_tb_10 wow fadeInUp' ) );
	echo $colored_blocks;
}

// Achievements
$images = get_attached_media( 'image', get_theme_mod( 'achievements-page' ) );
$achievements = '';

foreach ( $images as $post ) {
	$achievements .= artempol_get_post( $post, 'achievements', array( 'achievement_image', 'achievement_url', 'achievement_margin' ) );
}

if ( $achievements ) {
	$achievements = artempol_container( array( 'tag' => 'ul', 'content' => $achievements, 'class' => 'slides' ) );
	$achievements = artempol_container( array( 'tag' => 'div', 'content' => $achievements, 'class' => 'slider-achieve flexslider wow fadeInUp' ) );
	$achievements = artempol_container( array(), 'line' ) . $achievements;
	echo $achievements;
}

// Services
$services = get_post( get_theme_mod( 'services-page' ) );

if ( $services ) {
	$services = artempol_get_post( $services, 'services', array( 'title', 'content' ) ); 
	echo $services;
}

// Team
$doctors = artempol_get_posts( 'team', array( 'post_type' => 'doctor' ), array( 'url', 'image', 'title', 'description' ) );

if ( $doctors ) {
	$doctors = artempol_container( array( 'tag' => 'div', 'content' => $doctors, 'class' => 'content_wrap clearfix padding_tb_10 wow fadeInUp' ), 'slider-team' );
	$headings = '';
	$headings .= artempol_container( array( 'tag' => 'h2', 'content' => __( 'Our team', 'artempol' ) ) );  
	$headings .= artempol_container( array( 'tag' => 'p', 'content' => __( 'Because we care!', 'artempol' ) ) );
	$doctors = artempol_container( array( 'tag' => 'div', 'content' => $headings . $doctors, 'class' => 'team wow fadeInUp' ) );
	$doctors = artempol_container( array(), 'line' ) . $doctors;
	echo $doctors;
}

// News
$news = artempol_get_posts( 'news-list', array( 'category_name' => 'news', 'posts_per_page' => get_theme_mod( 'news-main-number', 2 ) ), array( 'image', 'title', 'url', 'date', 'content' ) );

if ( $news ) {
	$heading = artempol_container( array( 'tag' => 'h2', 'content' => __( 'News', 'artempol' ) ) );
	$news = artempol_container( array( 'tag' => 'div', 'content' => $heading . $news, 'class' => 'content_wrap news padding_tb_20 wow fadeInUp' ) );
	echo $news;
}

// Banners
$banners = get_posts( array( 'category_name' => 'banners' ) );

if ( !empty( $banners ) ) {
	echo artempol_get_post( $banners[ 0 ], 'banner', array( 'title', 'content' ) );
}

// Footer
get_footer(); 

?>
