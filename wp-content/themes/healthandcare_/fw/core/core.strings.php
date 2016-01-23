<?php
/**
 * HealthandCARE Framework: strings manipulations
 *
 * @package	healthandcare
 * @since	healthandcare 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Check multibyte functions
if ( ! defined( 'HEALTHANDCARE_MULTIBYTE' ) ) define( 'HEALTHANDCARE_MULTIBYTE', function_exists('mb_strlen') ? 'UTF-8' : false );

if (!function_exists('healthandcare_strlen')) {
	function healthandcare_strlen($text) {
		return HEALTHANDCARE_MULTIBYTE ? mb_strlen($text) : strlen($text);
	}
}

if (!function_exists('healthandcare_strpos')) {
	function healthandcare_strpos($text, $char, $from=0) {
		return HEALTHANDCARE_MULTIBYTE ? mb_strpos($text, $char, $from) : strpos($text, $char, $from);
	}
}

if (!function_exists('healthandcare_strrpos')) {
	function healthandcare_strrpos($text, $char, $from=0) {
		return HEALTHANDCARE_MULTIBYTE ? mb_strrpos($text, $char, $from) : strrpos($text, $char, $from);
	}
}

if (!function_exists('healthandcare_substr')) {
	function healthandcare_substr($text, $from, $len=-999999) {
		if ($len==-999999) { 
			if ($from < 0)
				$len = -$from; 
			else
				$len = healthandcare_strlen($text)-$from;
		}
		return HEALTHANDCARE_MULTIBYTE ? mb_substr($text, $from, $len) : substr($text, $from, $len);
	}
}

if (!function_exists('healthandcare_strtolower')) {
	function healthandcare_strtolower($text) {
		return HEALTHANDCARE_MULTIBYTE ? mb_strtolower($text) : strtolower($text);
	}
}

if (!function_exists('healthandcare_strtoupper')) {
	function healthandcare_strtoupper($text) {
		return HEALTHANDCARE_MULTIBYTE ? mb_strtoupper($text) : strtoupper($text);
	}
}

if (!function_exists('healthandcare_strtoproper')) {
	function healthandcare_strtoproper($text) {
		$rez = ''; $last = ' ';
		for ($i=0; $i<healthandcare_strlen($text); $i++) {
			$ch = healthandcare_substr($text, $i, 1);
			$rez .= healthandcare_strpos(' .,:;?!()[]{}+=', $last)!==false ? healthandcare_strtoupper($ch) : healthandcare_strtolower($ch);
			$last = $ch;
		}
		return $rez;
	}
}

if (!function_exists('healthandcare_strrepeat')) {
	function healthandcare_strrepeat($str, $n) {
		$rez = '';
		for ($i=0; $i<$n; $i++)
			$rez .= $str;
		return $rez;
	}
}

if (!function_exists('healthandcare_strshort')) {
	function healthandcare_strshort($str, $maxlength, $add='...') {
	//	if ($add && healthandcare_substr($add, 0, 1) != ' ')
	//		$add .= ' ';
		if ($maxlength < 0) 
			return '';
		if ($maxlength < 1 || $maxlength >= healthandcare_strlen($str))
			return strip_tags($str);
		$str = healthandcare_substr(strip_tags($str), 0, $maxlength - healthandcare_strlen($add));
		$ch = healthandcare_substr($str, $maxlength - healthandcare_strlen($add), 1);
		if ($ch != ' ') {
			for ($i = healthandcare_strlen($str) - 1; $i > 0; $i--)
				if (healthandcare_substr($str, $i, 1) == ' ') break;
			$str = trim(healthandcare_substr($str, 0, $i));
		}
		if (!empty($str) && healthandcare_strpos(',.:;-', healthandcare_substr($str, -1))!==false) $str = healthandcare_substr($str, 0, -1);
		return ($str) . ($add);
	}
}

// Clear string from spaces, line breaks and tags (only around text)
if (!function_exists('healthandcare_strclear')) {
	function healthandcare_strclear($text, $tags=array()) {
		if (empty($text)) return $text;
		if (!is_array($tags)) {
			if ($tags != '')
				$tags = explode($tags, ',');
			else
				$tags = array();
		}
		$text = trim(chop($text));
		if (is_array($tags) && count($tags) > 0) {
			foreach ($tags as $tag) {
				$open  = '<'.esc_attr($tag);
				$close = '</'.esc_attr($tag).'>';
				if (healthandcare_substr($text, 0, healthandcare_strlen($open))==$open) {
					$pos = healthandcare_strpos($text, '>');
					if ($pos!==false) $text = healthandcare_substr($text, $pos+1);
				}
				if (healthandcare_substr($text, -healthandcare_strlen($close))==$close) $text = healthandcare_substr($text, 0, healthandcare_strlen($text) - healthandcare_strlen($close));
				$text = trim(chop($text));
			}
		}
		return $text;
	}
}

// Return slug for the any title string
if (!function_exists('healthandcare_get_slug')) {
	function healthandcare_get_slug($title) {
		return healthandcare_strtolower(str_replace(array('\\','/','-',' ','.'), '_', $title));
	}
}

// Replace macros in the string
if (!function_exists('healthandcare_strmacros')) {
	function healthandcare_strmacros($str) {
		return str_replace(array("{{", "}}", "((", "))", "||"), array("<i>", "</i>", "<b>", "</b>", "<br>"), $str);
	}
}
?>