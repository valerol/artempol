<?php
//####################################################
//#### Inheritance system (for internal use only) #### 
//####################################################

// Add item to the inheritance settings
if ( !function_exists( 'healthandcare_add_theme_inheritance' ) ) {
	function healthandcare_add_theme_inheritance($options, $append=true) {
		global $HEALTHANDCARE_GLOBALS;
		if (!isset($HEALTHANDCARE_GLOBALS["inheritance"])) $HEALTHANDCARE_GLOBALS["inheritance"] = array();
		$HEALTHANDCARE_GLOBALS['inheritance'] = $append
			? healthandcare_array_merge($HEALTHANDCARE_GLOBALS['inheritance'], $options)
			: healthandcare_array_merge($options, $HEALTHANDCARE_GLOBALS['inheritance']);
	}
}



// Return inheritance settings
if ( !function_exists( 'healthandcare_get_theme_inheritance' ) ) {
	function healthandcare_get_theme_inheritance($key = '') {
		global $HEALTHANDCARE_GLOBALS;
		return $key ? $HEALTHANDCARE_GLOBALS['inheritance'][$key] : $HEALTHANDCARE_GLOBALS['inheritance'];
	}
}



// Detect inheritance key for the current mode
if ( !function_exists( 'healthandcare_detect_inheritance_key' ) ) {
	function healthandcare_detect_inheritance_key() {
		static $inheritance_key = '';
		if (!empty($inheritance_key)) return $inheritance_key;
		$inheritance_key = apply_filters('healthandcare_filter_detect_inheritance_key', '');
		return $inheritance_key;
	}
}


// Return key for override parameter
if ( !function_exists( 'healthandcare_get_override_key' ) ) {
	function healthandcare_get_override_key($value, $by) {
		$key = '';
		$inheritance = healthandcare_get_theme_inheritance();
		if (!empty($inheritance) && is_array($inheritance)) {
			foreach ($inheritance as $k=>$v) {
				if (!empty($v[$by]) && in_array($value, $v[$by])) {
					$key = $by=='taxonomy' 
						? $value
						: (!empty($v['override']) ? $v['override'] : $k);
					break;
				}
			}
		}
		return $key;
	}
}


// Return taxonomy (for categories) by post_type from inheritance array
if ( !function_exists( 'healthandcare_get_taxonomy_categories_by_post_type' ) ) {
	function healthandcare_get_taxonomy_categories_by_post_type($value) {
		$key = '';
		$inheritance = healthandcare_get_theme_inheritance();
		if (!empty($inheritance) && is_array($inheritance)) {
			foreach ($inheritance as $k=>$v) {
				if (!empty($v['post_type']) && in_array($value, $v['post_type'])) {
					$key = !empty($v['taxonomy']) ? $v['taxonomy'][0] : '';
					break;
				}
			}
		}
		return $key;
	}
}


// Return taxonomy (for tags) by post_type from inheritance array
if ( !function_exists( 'healthandcare_get_taxonomy_tags_by_post_type' ) ) {
	function healthandcare_get_taxonomy_tags_by_post_type($value) {
		$key = '';
		$inheritance = healthandcare_get_theme_inheritance();
		if (!empty($inheritance) && is_array($inheritance)) {
			foreach($inheritance as $k=>$v) {
				if (!empty($v['post_type']) && in_array($value, $v['post_type'])) {
					$key = !empty($v['taxonomy_tags']) ? $v['taxonomy_tags'][0] : '';
					break;
				}
			}
		}
		return $key;
	}
}
?>