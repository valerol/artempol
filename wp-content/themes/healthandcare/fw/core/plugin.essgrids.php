<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */

// Check if Ess. Grid installed and activated
if ( !function_exists( 'healthandcare_exists_essgrids' ) ) {
	function healthandcare_exists_essgrids() {
		return defined('EG_PLUGIN_PATH');
		//return class_exists('Essential_Grid');
		//return is_plugin_active('essential-grid/essential-grid.php');
	}
}
?>