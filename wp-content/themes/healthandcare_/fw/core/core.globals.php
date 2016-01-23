<?php
/**
 * HealthandCARE Framework: global variables storage
 *
 * @package	healthandcare
 * @since	healthandcare 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get global variable
if (!function_exists('healthandcare_get_global')) {
	function healthandcare_get_global($var_name) {
		global $HEALTHANDCARE_GLOBALS;
		return isset($HEALTHANDCARE_GLOBALS[$var_name]) ? $HEALTHANDCARE_GLOBALS[$var_name] : '';
	}
}

// Set global variable
if (!function_exists('healthandcare_set_global')) {
	function healthandcare_set_global($var_name, $value) {
		global $HEALTHANDCARE_GLOBALS;
		$HEALTHANDCARE_GLOBALS[$var_name] = $value;
	}
}

// Inc/Dec global variable with specified value
if (!function_exists('healthandcare_inc_global')) {
	function healthandcare_inc_global($var_name, $value=1) {
		global $HEALTHANDCARE_GLOBALS;
		$HEALTHANDCARE_GLOBALS[$var_name] += $value;
	}
}

// Concatenate global variable with specified value
if (!function_exists('healthandcare_concat_global')) {
	function healthandcare_concat_global($var_name, $value) {
		global $HEALTHANDCARE_GLOBALS;
		$HEALTHANDCARE_GLOBALS[$var_name] .= $value;
	}
}

// Get global array element
if (!function_exists('healthandcare_get_global_array')) {
	function healthandcare_get_global_array($var_name, $key) {
		global $HEALTHANDCARE_GLOBALS;
		return isset($HEALTHANDCARE_GLOBALS[$var_name][$key]) ? $HEALTHANDCARE_GLOBALS[$var_name][$key] : '';
	}
}

// Set global array element
if (!function_exists('healthandcare_set_global_array')) {
	function healthandcare_set_global_array($var_name, $key, $value) {
		global $HEALTHANDCARE_GLOBALS;
		if (!isset($HEALTHANDCARE_GLOBALS[$var_name])) $HEALTHANDCARE_GLOBALS[$var_name] = array();
		$HEALTHANDCARE_GLOBALS[$var_name][$key] = $value;
	}
}

// Inc/Dec global array element with specified value
if (!function_exists('healthandcare_inc_global_array')) {
	function healthandcare_inc_global_array($var_name, $key, $value=1) {
		global $HEALTHANDCARE_GLOBALS;
		$HEALTHANDCARE_GLOBALS[$var_name][$key] += $value;
	}
}

// Concatenate global array element with specified value
if (!function_exists('healthandcare_concat_global_array')) {
	function healthandcare_concat_global_array($var_name, $key, $value) {
		global $HEALTHANDCARE_GLOBALS;
		$HEALTHANDCARE_GLOBALS[$var_name][$key] .= $value;
	}
}
?>