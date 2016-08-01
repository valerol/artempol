<?php

/*
Template tags:
class
heading
level
content
image
image_url
description
link
edit_link

*/

function artempol_get_template( $template ) {
	$templates = array();

//	$templates[ '' ] = '';
	
	$templates[ 'container' ] = '
	<%TAG% class="%CLASS%">%CONTENT%</%TAG%>
	';
	
	$templates[ 'slide' ] = '
	<li class="slide" style="background-image: url( %IMAGE_URL% );" >
		<div class="content_wrap">
			<h2>%TITLE%</h2>
			%CONTENT%
		</div>				
	</li>
	';
	
	$templates[ 'greeting' ] = '
	<div class="greeting content_wrap padding_tb_20 clearfix wow fadeInUp">	
		<div class="column col_1_2">
			<h1 class="title iconed textcolor_2"><span>%TITLE%</span></h1>
			<p class="title_2 textcolor_2">%TITLE2%</p>
		</div>
		<div class="column col_1_2">%CONTENT%</div>
	</div>
	';
	
	$templates[ 'colored' ] = '
	<div class="column col_1_4">
		<div class="colored_block color_%COUNTER%">
			<div class="title padding_20">
				<h4 class="iconed">%TITLE%</h4>
			</div>
			<div class="text padding_20 whited_03">%CONTENT%</div>
		</div>
	</div>
	';

	$templates[ 'services' ] = '	
	<div class="content_wrap padding_tb_20">
		<div class="services content wow fadeInUp">
			<h2>%TITLE%</h2>
			%CONTENT%
		</div>
	</div>	
	';
	
	$templates[ 'banner' ] = '	
	<div class="banner wow fadeInUp">
		<div class="content_wrap">
			<h2>%TITLE%</h2>
			%CONTENT%	
		</div>
	</div>
	';
	
	$templates[ 'news-list' ] = '	
	<div class="post_featured img">
		%IMAGE%						
	</div>

	<div class="post_info_wrap info clearfix">
		<div class="info-back">	
			<a href="%URL%"><h4 class="post_title">%TITLE%</h4></a>
			<div class="post_descr">
				<p class="post_info">
					<span class="post_info_item post_info_posted">%DATE%</span>
				</p>
				%CONTENT%				
			</div>
		</div>
	</div>
	';
	
	$templates[ 'achievements' ] = '
	<li>
		<a class="colorbox" href="%ACHIEVEMENT_URL%">
			<img src="%ACHIEVEMENT_IMAGE%" style="margin-left: -%ACHIEVEMENT_MARGIN%px;">
		</a>
	</li>	
	';
	
	$templates[ 'team' ] = '
	<li class="columns col_1_4">
		<a href="%URL%">
			%IMAGE%
			<div class="container whited_01">										
				<h5 class="name">%TITLE%</h5>									
				<div class="position">%DESCRIPTION%</div>
			</div>						
		</a>						
	</li>		
	';
	
	$templates[ 'slider-team' ] = '
	<div class="content_wrap padding_tb_20">
		<div class="slider-team flexslider">
			<ul class="slides">
				%CONTENT%
			</ul>
		</div>
	</div>
	';
	
	$templates[ 'list' ] = '
	<li class="iconed parent-page">
		%LINK%
	</li>
	';
	
	$templates[ 'question' ] = '
	<div class="question padding_tb_10">		
		<p class="color_4 textwhite"><b>%TITLE%: </b> %DESCRIPTION%</p>				
		%CONTENT%
		%EDIT_LINK%		
	</div>
	';
	
	$templates[ 'line' ] = '
	<div class="colored_line clearfix">
		<div class="color_1"></div>
		<div class="color_2"></div>
		<div class="color_3"></div>
		<div class="color_4"></div>
	</div> 
	';
	
	$templates[ 'doctor' ] = '
	<div class="doctor_info padding_tb_10 clearfix">			
		%IMAGE%
		<h4 class="post_title">%TITLE%</h4>				
		<p class="position textcolor_2 bold">%DESCRIPTION%</p>				
		%CONTENT%		
	</div>
	';
	
	if ( $templates[ $template ] ) {
		return $templates[ $template ];
	}
}

?>
