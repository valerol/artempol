<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Check if RevSlider installed and activated
if ( !function_exists( 'healthandcare_exists_revslider' ) ) {
	function healthandcare_exists_revslider() {
		return function_exists('rev_slider_shortcode');
		//return class_exists('RevSliderFront');
		//return is_plugin_active('revslider/revslider.php');
	}
}
?>