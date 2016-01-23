<?php
/**
 * Healthandcare Framework: less manipulations
 *
 * @package	themerex
 * @since	themerex 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


// Theme init
if (!function_exists('healthandcare_less_theme_setup2')) {
    add_action( 'healthandcare_action_after_init_theme', 'healthandcare_less_theme_setup2' );
    function healthandcare_less_theme_setup2() {
        // Theme first run - compile and save css
        $theme_data = wp_get_theme();
        $slug = str_replace(' ', '_', trim(healthandcare_strtolower((string) $theme_data->get('Name'))));
        $option_name = 'healthandcare_'.strip_tags($slug).'_less_compiled';
        if (get_option($option_name, false) === false) {
            add_option($option_name, 1, '', 'yes');
            do_action('healthandcare_action_compile_less');
        } else if (!is_admin() && healthandcare_get_theme_option('debug_mode')=='yes') {
            global $HEALTHANDCARE_GLOBALS;
            $HEALTHANDCARE_GLOBALS['less_check_time'] = true;
            do_action('healthandcare_action_compile_less');
            $HEALTHANDCARE_GLOBALS['less_check_time'] = false;
        }
    }
}



/* LESS
-------------------------------------------------------------------------------- */

// Recompile all LESS files
if (!function_exists('healthandcare_compile_less')) {
    function healthandcare_compile_less($list = array(), $recompile=true) {

        if (!function_exists('healthandcare_less_compiler')) return false;

        $success = true;

        // Less compiler
        $less_compiler = healthandcare_get_theme_setting('less_compiler');
        if ($less_compiler == 'no') return $success;

        // Generate map for the LESS-files
        $less_map = healthandcare_get_theme_setting('less_map');
        if (healthandcare_get_theme_option('debug_mode')=='no' || $less_compiler=='lessc') $less_map = 'no';

        // Get separator to split LESS-files
        $less_sep = $less_map!='no' ? '' : healthandcare_get_theme_setting('less_separator');

        // Prepare skin specific LESS-vars (colors, backgrounds, logo height, etc.)
        $vars = apply_filters('healthandcare_filter_prepare_less', '');

        // Collect .less files in parent and child themes
        if (empty($list)) {
            $list = healthandcare_collect_files(get_template_directory(), 'less');
            if (get_template_directory() != get_stylesheet_directory()) $list = array_merge($list, healthandcare_collect_files(get_stylesheet_directory(), 'less'));
        }
        // Prepare separate array with less utils (not compile it alone - only with main files)
        $utils = $less_map!='no' ? array() : '';
        $utils_time = 0;
        if (is_array($list) && count($list) > 0) {
            foreach($list as $k=>$file) {
                $fname = basename($file);
                if ($fname[0]=='_') {
                    if ($less_map!='no')
                        $utils[] = $file;
                    else
                        $utils .= healthandcare_fgc($file);
                    $list[$k] = '';
                    $tmp = filemtime($file);
                    if ($utils_time < $tmp) $utils_time = $tmp;
                }
            }
        }

        // Compile all .less files
        if (is_array($list) && count($list) > 0) {
            global $HEALTHANDCARE_GLOBALS;
            $success = healthandcare_less_compiler($list, array(
                    'compiler' => $less_compiler,
                    'map' => $less_map,
                    'utils' => $utils,
                    'utils_time' => $utils_time,
                    'vars' => $vars,
                    'separator' => $less_sep,
                    'check_time' => !empty($HEALTHANDCARE_GLOBALS['less_check_time']),
                    'compressed' => healthandcare_get_theme_option('debug_mode')=='no'
                )
            );
        }

        return $success;
    }
}
?>