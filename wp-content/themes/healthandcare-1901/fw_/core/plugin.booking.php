<?php
/* Booking Calendar support functions
------------------------------------------------------------------------------- */

// Check if Booking Calendar installed and activated
if ( !function_exists( 'healthandcare_exists_booking' ) ) {
	function healthandcare_exists_booking() {
		return function_exists('wp_booking_start_session');
	}
}
?>