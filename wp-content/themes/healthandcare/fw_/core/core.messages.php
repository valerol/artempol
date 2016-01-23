<?php
/**
 * HealthandCARE Framework: messages subsystem
 *
 * @package	healthandcare
 * @since	healthandcare 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('healthandcare_messages_theme_setup')) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_messages_theme_setup' );
	function healthandcare_messages_theme_setup() {
		// Core messages strings
		add_action('healthandcare_action_add_scripts_inline', 'healthandcare_messages_add_scripts_inline');
	}
}


/* Session messages
------------------------------------------------------------------------------------- */

if (!function_exists('healthandcare_get_error_msg')) {
	function healthandcare_get_error_msg() {
		global $HEALTHANDCARE_GLOBALS;
		return !empty($HEALTHANDCARE_GLOBALS['error_msg']) ? $HEALTHANDCARE_GLOBALS['error_msg'] : '';
	}
}

if (!function_exists('healthandcare_set_error_msg')) {
	function healthandcare_set_error_msg($msg) {
		global $HEALTHANDCARE_GLOBALS;
		$msg2 = healthandcare_get_error_msg();
		$HEALTHANDCARE_GLOBALS['error_msg'] = $msg2 . ($msg2=='' ? '' : '<br />') . ($msg);
	}
}

if (!function_exists('healthandcare_get_success_msg')) {
	function healthandcare_get_success_msg() {
		global $HEALTHANDCARE_GLOBALS;
		return !empty($HEALTHANDCARE_GLOBALS['success_msg']) ? $HEALTHANDCARE_GLOBALS['success_msg'] : '';
	}
}

if (!function_exists('healthandcare_set_success_msg')) {
	function healthandcare_set_success_msg($msg) {
		global $HEALTHANDCARE_GLOBALS;
		$msg2 = healthandcare_get_success_msg();
		$HEALTHANDCARE_GLOBALS['success_msg'] = $msg2 . ($msg2=='' ? '' : '<br />') . ($msg);
	}
}

if (!function_exists('healthandcare_get_notice_msg')) {
	function healthandcare_get_notice_msg() {
		global $HEALTHANDCARE_GLOBALS;
		return !empty($HEALTHANDCARE_GLOBALS['notice_msg']) ? $HEALTHANDCARE_GLOBALS['notice_msg'] : '';
	}
}

if (!function_exists('healthandcare_set_notice_msg')) {
	function healthandcare_set_notice_msg($msg) {
		global $HEALTHANDCARE_GLOBALS;
		$msg2 = healthandcare_get_notice_msg();
		$HEALTHANDCARE_GLOBALS['notice_msg'] = $msg2 . ($msg2=='' ? '' : '<br />') . ($msg);
	}
}


/* System messages (save when page reload)
------------------------------------------------------------------------------------- */
if (!function_exists('healthandcare_set_system_message')) {
	function healthandcare_set_system_message($msg, $status='info', $hdr='') {
		update_option('healthandcare_message', array('message' => $msg, 'status' => $status, 'header' => $hdr));
	}
}

if (!function_exists('healthandcare_get_system_message')) {
	function healthandcare_get_system_message($del=false) {
		$msg = get_option('healthandcare_message', false);
		if (!$msg)
			$msg = array('message' => '', 'status' => '', 'header' => '');
		else if ($del)
			healthandcare_del_system_message();
		return $msg;
	}
}

if (!function_exists('healthandcare_del_system_message')) {
	function healthandcare_del_system_message() {
		delete_option('healthandcare_message');
	}
}


/* Messages strings
------------------------------------------------------------------------------------- */

if (!function_exists('healthandcare_messages_add_scripts_inline')) {
	function healthandcare_messages_add_scripts_inline() {
		global $HEALTHANDCARE_GLOBALS;
		echo '<script type="text/javascript">'
			. 'jQuery(document).ready(function() {'
			// Strings for translation
			. 'HEALTHANDCARE_GLOBALS["strings"] = {'
				. 'bookmark_add: 		"' . addslashes(__('Add the bookmark', 'healthandcare')) . '",'
				. 'bookmark_added:		"' . addslashes(__('Current page has been successfully added to the bookmarks. You can see it in the right panel on the tab \'Bookmarks\'', 'healthandcare')) . '",'
				. 'bookmark_del: 		"' . addslashes(__('Delete this bookmark', 'healthandcare')) . '",'
				. 'bookmark_title:		"' . addslashes(__('Enter bookmark title', 'healthandcare')) . '",'
				. 'bookmark_exists:		"' . addslashes(__('Current page already exists in the bookmarks list', 'healthandcare')) . '",'
				. 'search_error:		"' . addslashes(__('Error occurs in AJAX search! Please, type your query and press search icon for the traditional search way.', 'healthandcare')) . '",'
				. 'email_confirm:		"' . addslashes(__('On the e-mail address <b>%s</b> we sent a confirmation email.<br>Please, open it and click on the link.', 'healthandcare')) . '",'
				. 'reviews_vote:		"' . addslashes(__('Thanks for your vote! New average rating is:', 'healthandcare')) . '",'
				. 'reviews_error:		"' . addslashes(__('Error saving your vote! Please, try again later.', 'healthandcare')) . '",'
				. 'error_like:			"' . addslashes(__('Error saving your like! Please, try again later.', 'healthandcare')) . '",'
				. 'error_global:		"' . addslashes(__('Global error text', 'healthandcare')) . '",'
				. 'name_empty:			"' . addslashes(__('The name can\'t be empty', 'healthandcare')) . '",'
				. 'name_long:			"' . addslashes(__('Too long name', 'healthandcare')) . '",'
				. 'email_empty:			"' . addslashes(__('Too short (or empty) email address', 'healthandcare')) . '",'
				. 'email_long:			"' . addslashes(__('Too long email address', 'healthandcare')) . '",'
				. 'email_not_valid:		"' . addslashes(__('Invalid email address', 'healthandcare')) . '",'
				. 'subject_empty:		"' . addslashes(__('The subject can\'t be empty', 'healthandcare')) . '",'
				. 'subject_long:		"' . addslashes(__('Too long subject', 'healthandcare')) . '",'
				. 'text_empty:			"' . addslashes(__('The message text can\'t be empty', 'healthandcare')) . '",'
				. 'text_long:			"' . addslashes(__('Too long message text', 'healthandcare')) . '",'
				. 'send_complete:		"' . addslashes(__("Send message complete!", 'healthandcare')) . '",'
				. 'send_error:			"' . addslashes(__('Transmit failed!', 'healthandcare')) . '",'
				. 'login_empty:			"' . addslashes(__('The Login field can\'t be empty', 'healthandcare')) . '",'
				. 'login_long:			"' . addslashes(__('Too long login field', 'healthandcare')) . '",'
				. 'login_success:		"' . addslashes(__('Login success! The page will be reloaded in 3 sec.', 'healthandcare')) . '",'
				. 'login_failed:		"' . addslashes(__('Login failed!', 'healthandcare')) . '",'
				. 'password_empty:		"' . addslashes(__('The password can\'t be empty and shorter then 4 characters', 'healthandcare')) . '",'
				. 'password_long:		"' . addslashes(__('Too long password', 'healthandcare')) . '",'
				. 'password_not_equal:	"' . addslashes(__('The passwords in both fields are not equal', 'healthandcare')) . '",'
				. 'registration_success:"' . addslashes(__('Registration success! Please log in!', 'healthandcare')) . '",'
				. 'registration_failed:	"' . addslashes(__('Registration failed!', 'healthandcare')) . '",'
				. 'geocode_error:		"' . addslashes(__('Geocode was not successful for the following reason:', 'healthandcare')) . '",'
				. 'googlemap_not_avail:	"' . addslashes(__('Google map API not available!', 'healthandcare')) . '",'
				. 'editor_save_success:	"' . addslashes(__("Post content saved!", 'healthandcare')) . '",'
				. 'editor_save_error:	"' . addslashes(__("Error saving post data!", 'healthandcare')) . '",'
				. 'editor_delete_post:	"' . addslashes(__("You really want to delete the current post?", 'healthandcare')) . '",'
				. 'editor_delete_post_header:"' . addslashes(__("Delete post", 'healthandcare')) . '",'
				. 'editor_delete_success:	"' . addslashes(__("Post deleted!", 'healthandcare')) . '",'
				. 'editor_delete_error:		"' . addslashes(__("Error deleting post!", 'healthandcare')) . '",'
				. 'editor_caption_cancel:	"' . addslashes(__('Cancel', 'healthandcare')) . '",'
				. 'editor_caption_close:	"' . addslashes(__('Close', 'healthandcare')) . '"'
				. '};'
			. '});'
			. '</script>';
	}
}
?>