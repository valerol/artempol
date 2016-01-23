<?php
/**
 * Send email to subscribers from selected group
 */
 
// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


// Theme init
if (!function_exists('healthandcare_emailer_theme_setup')) {
	add_action( 'healthandcare_action_before_init_theme', 'healthandcare_emailer_theme_setup' );
	function healthandcare_emailer_theme_setup() {
		// AJAX: Save e-mail in subscribe list
		add_action('wp_ajax_emailer_submit',				'healthandcare_callback_emailer_submit');
		add_action('wp_ajax_nopriv_emailer_submit',			'healthandcare_callback_emailer_submit');
		// AJAX: Confirm e-mail in subscribe list
		add_action('wp_ajax_emailer_confirm',				'healthandcare_callback_emailer_confirm');
		add_action('wp_ajax_nopriv_emailer_confirm',		'healthandcare_callback_emailer_confirm');
		// AJAX: Get subscribers list if group changed
		add_action('wp_ajax_emailer_group_getlist',			'healthandcare_callback_emailer_group_getlist');
		add_action('wp_ajax_nopriv_emailer_group_getlist',	'healthandcare_callback_emailer_group_getlist');
	}
}

if (!function_exists('healthandcare_emailer_theme_setup2')) {
	add_action( 'healthandcare_action_after_init_theme', 'healthandcare_emailer_theme_setup2' );		// Fire this action after load theme options
	function healthandcare_emailer_theme_setup2() {
		if (is_admin() && current_user_can('manage_options') && healthandcare_get_theme_option('admin_emailer')=='yes') {
			new healthandcare_emailer();
		}
	}
}


class healthandcare_emailer {

	var $subscribers  = array();
	var $error    = '';
	var $success  = '';
	var $nonce    = '';
	var $max_recipients_in_one_letter = 50;

	//-----------------------------------------------------------------------------------
	// Constuctor
	//-----------------------------------------------------------------------------------
	function __construct() {
		// Setup actions handlers
		add_action('admin_menu', array($this, 'admin_menu_item'));
		add_action("admin_enqueue_scripts", array($this, 'load_scripts'));
		add_action("admin_head", array($this, 'prepare_js'));

		// Init properties
		$this->subscribers = healthandcare_emailer_group_getlist();
		$this->nonce = wp_create_nonce(__FILE__);
	}

	//-----------------------------------------------------------------------------------
	// Admin Interface
	//-----------------------------------------------------------------------------------
	function admin_menu_item() {
		if ( current_user_can( 'manage_options' ) ) {
			// In this case menu item is add in admin menu 'Appearance'
			//add_theme_page(__('Emailer', 'healthandcare'), esc_html__('Emailer', 'healthandcare'), 'edit_theme_options', 'trx_emailer', array($this, 'build_page'));

			// In this case menu item is add in admin menu 'Tools'
			add_management_page(__('Emailer', 'healthandcare'), esc_html__('Emailer', 'healthandcare'), 'manage_options', 'trx_emailer', array($this, 'build_page'));
		}
	}


	//-----------------------------------------------------------------------------------
	// Load required styles and scripts
	//-----------------------------------------------------------------------------------
	function load_scripts() {
		if (isset($_REQUEST['page']) && $_REQUEST['page']=='trx_emailer') {
			healthandcare_enqueue_style('trx-emailer-style', healthandcare_get_file_url('tools/emailer/emailer.css'), array(), null);
		}
		if (isset($_REQUEST['page']) && $_REQUEST['page']=='trx_emailer') {
			healthandcare_enqueue_script('jquery-ui-core', false, array('jquery'), null, true);
			healthandcare_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);
			healthandcare_enqueue_script('trx-emailer-script', healthandcare_get_file_url('tools/emailer/emailer.js'), array('jquery'), null, true);
		}
	}
	
	
	//-----------------------------------------------------------------------------------
	// Prepare javascripts global variables
	//-----------------------------------------------------------------------------------
	function prepare_js() { 
		?>
		<script type="text/javascript">
			var HEALTHANDCARE_EMAILER_ajax_nonce = "<?php echo wp_create_nonce('ajax_nonce'); ?>";
			var HEALTHANDCARE_EMAILER_ajax_url   = "<?php echo admin_url('admin-ajax.php'); ?>";
		</script>
		<?php 
	}
	
	
	//-----------------------------------------------------------------------------------
	// Build the Main Page
	//-----------------------------------------------------------------------------------
	function build_page() {
		
		$subject = $message = $attach = $group = $sender_name = $sender_email = '';
		$subscribers_update = $subscribers_delete = $subscribers_clear = false;
		$subscribers = array();
		if ( isset($_POST['emailer_subject']) ) {
			do {
				// Check nonce
				if ( !isset($_POST['nonce']) || !wp_verify_nonce( $_POST['nonce'], __FILE__ ) ) {
					$this->error = esc_html__('Incorrect WP-nonce data! Operation canceled!', 'healthandcare');
					break;
				}
				// Get post data
				$subject = healthandcare_get_value_gp('emailer_subject');
				if (empty($subject)) {
					$this->error = esc_html__('Subject can not be empty! Operation canceled!', 'healthandcare');
					break;
				}
				$message = healthandcare_get_value_gp('emailer_message');
				if (empty($message)) {
					$this->error = esc_html__('Message can not be empty! Operation canceled!', 'healthandcare');
					break;
				}
				$attach  = isset($_FILES['emailer_attachment']['tmp_name']) && file_exists($_FILES['emailer_attachment']['tmp_name']) ? $_FILES['emailer_attachment']['tmp_name'] : '';
				$group   = healthandcare_get_value_gp('emailer_group');
				$subscribers = healthandcare_get_value_gp('emailer_subscribers');
				if (!empty($subscribers))
					$subscribers = explode("\n", str_replace(array(';', ','), array("\n", "\n"), $subscribers));
				else
					$subscribers = array();
				if (count($subscribers)==0) {
					$this->error = esc_html__('Subscribers lists are empty! Operation canceled!', 'healthandcare');
					break;
				}
				$sender_name = healthandcare_get_value_gp('emailer_sender_name', get_bloginfo('name'));
				$sender_email = healthandcare_get_value_gp('emailer_sender_email');
				if (empty($sender_email)) $sender_email = healthandcare_get_theme_option('contact_email');
				if (empty($sender_email)) $sender_email = get_bloginfo('admin_email');
				if (empty($sender_email)) {
					$this->error = esc_html__('Sender email is empty! Operation canceled!', 'healthandcare');
					break;
				}
				$headers = 'From: ' . trim($sender_name) . ' <' . trim($sender_email) . '>' . "\r\n";
				$subscribers_update = isset($_POST['emailer_subscribers_update']);
				$subscribers_delete = isset($_POST['emailer_subscribers_delete']);
				$subscribers_clear  = isset($_POST['emailer_subscribers_clear']);

				// Send email
				add_filter( 'wp_mail_content_type', 'healthandcare_set_html_content_type' );
				$new_list = array();
				$list = array();
				$cnt = 0;
				$mail = healthandcare_get_theme_option('mail_function');
				if (is_array($subscribers) && count($subscribers) > 0) {
					foreach ($subscribers as $email) {
						$email = trim(chop($email));
						if (empty($email)) continue;
						if (!preg_match('/[\.\-_A-Za-z0-9]+?@[\.\-A-Za-z0-9]+?[\ .A-Za-z0-9]{2,}/', $email)) continue;
						$list[] = $email;
						$cnt++;
						if ($cnt >= $this->max_recipients_in_one_letter) {
							@$mail( $list, $subject, $message, $headers, $attach );
							if ($subscribers_update && $group!='none') $new_list = array_merge($new_list, $list);
							$list = array();
							$cnt = 0;
						}
					}
				}
				if ($cnt > 0) {
					@$mail( $list, $subject, $message, $headers, $attach );
					if ($subscribers_update && $group!='none') $new_list = array_merge($new_list, $list);
					$list = array();
					$cnt = 0;
				}
				remove_filter( 'wp_mail_content_type', 'healthandcare_set_html_content_type' );
				$add_msg = '';
				if ($subscribers_update && $group!='none') {
					$rez = array();
					if (is_array($this->subscribers[$group]) && count($this->subscribers[$group]) > 0) {
						foreach ($this->subscribers[$group] as $k=>$v) {
							if (!$subscribers_clear && !empty($v))
								$rez[$k] = $v;
						}
					}
					if (is_array($new_list) && count($new_list) > 0) {
						foreach ($new_list as $v) {
							$rez[$v] = '';
						}
					}
					$this->subscribers[$group] = $rez;
					update_option('healthandcare_emailer_subscribers', $this->subscribers);
					$add_msg = esc_html__(' The subscriber list is updated', 'healthandcare');
				} else if ($subscribers_delete && $group!='none') {
					unset($this->subscribers[$group]);
					update_option('healthandcare_emailer_subscribers', $this->subscribers);
					$add_msg = esc_html__(' The subscriber list is cleared', 'healthandcare');
				}
				$this->success = esc_html__('E-Mail was send successfull!', 'healthandcare') . $add_msg;
			} while (false);
		}

		?>
		<div class="trx_emailer">
			<h2 class="trx_emailer_title"><?php esc_html_e('HealthandCARE Emailer', 'healthandcare'); ?></h2>
			<div class="trx_emailer_result">
				<?php if (!empty($this->error)) { ?>
				<div class="error">
					<p><?php echo trim($this->error); ?></p>
				</div>
				<?php } ?>
				<?php if (!empty($this->success)) { ?>
				<div class="updated">
					<p><?php echo trim($this->success); ?></p>
				</div>
				<?php } ?>
			</div>
	
			<form id="trx_emailer_form" action="#" method="post" enctype="multipart/form-data">

				<input type="hidden" value="<?php echo esc_attr($this->nonce); ?>" name="nonce" />

				<div class="trx_emailer_block">
					<fieldset class="trx_emailer_block_inner">
						<legend> <?php esc_html_e('Letter data', 'healthandcare'); ?> </legend>
						<div class="trx_emailer_fields">
							<div class="trx_emailer_field trx_emailer_subject">
								<label for="emailer_subject"><?php esc_html_e('Subject:', 'healthandcare'); ?></label>
								<input type="text" value="<?php echo esc_attr($subject); ?>" name="emailer_subject" id="emailer_subject" />
							</div>
							<div class="trx_emailer_field trx_emailer_attachment">
								<label for="emailer_attachment"><?php esc_html_e('Attachment:', 'healthandcare'); ?></label>
								<input type="file" name="emailer_attachment" id="emailer_attachment" />
							</div>
							<div class="trx_emailer_field trx_emailer_message">
								<?php
								wp_editor( $message, 'emailer_message', array(
									'wpautop' => false,
									'textarea_rows' => 10
								));
								?>								
							</div>
						</div>
					</fieldset>
				</div>
	
				<div class="trx_emailer_block">
					<fieldset class="trx_emailer_block_inner">
						<legend> <?php esc_html_e('Subscribers', 'healthandcare'); ?> </legend>
						<div class="trx_emailer_fields">
							<div class="trx_emailer_field trx_emailer_group">
								<label for="emailer_group"><?php esc_html_e('Select group:', 'healthandcare'); ?></label>
								<select name="emailer_group" id="emailer_group">
									<option value="none"<?php echo ($group=='none' ? ' selected="selected"' : ''); ?>><?php esc_html_e('- Select group -', 'healthandcare'); ?></option>
									<?php
									if (is_array($this->subscribers) && count($this->subscribers) > 0) {
										foreach ($this->subscribers as $gr=>$list) {
											echo '<option value="'.esc_attr($gr).'"'.($group==$gr ? ' selected="selected"' : '').'>'.healthandcare_strtoproper($gr).'</option>';
										}
									}
									?>
								</select>
								<input type="checkbox" name="emailer_subscribers_update" id="emailer_subscribers_update" value="1"<?php echo ($subscribers_update ? ' checked="checked"' : ''); ?> /><label for="emailer_subscribers_update" class="inline" title="<?php esc_html_e('Update the subscribers list for selected group', 'healthandcare'); ?>"><?php esc_html_e('Update', 'healthandcare'); ?></label>
								<input type="checkbox" name="emailer_subscribers_clear" id="emailer_subscribers_clear" value="1"<?php echo ($subscribers_clear ? ' checked="checked"' : ''); ?> /><label for="emailer_subscribers_clear" class="inline" title="<?php esc_html_e('Clear this group from not confirmed emails after send', 'healthandcare'); ?>"><?php esc_html_e('Clear', 'healthandcare'); ?></label>
								<input type="checkbox" name="emailer_subscribers_delete" id="emailer_subscribers_delete" value="1"<?php echo ($subscribers_delete ? ' checked="checked"' : ''); ?> /><label for="emailer_subscribers_delete" class="inline" title="<?php esc_html_e('Delete this group after send', 'healthandcare'); ?>"><?php esc_html_e('Delete', 'healthandcare'); ?></label>
							</div>
							<div class="trx_emailer_field trx_emailer_subscribers2">
								<label for="emailer_subscribers" class="big"><?php esc_html_e('List of recipients:', 'healthandcare'); ?></label>
								<textarea name="emailer_subscribers" id="emailer_subscribers"><?php echo join("\n", $subscribers); ?></textarea>
							</div>
							<div class="trx_emailer_field trx_emailer_sender_name">
								<label for="emailer_sender_name"><?php esc_html_e('Sender name:', 'healthandcare'); ?></label>
								<input type="text" name="emailer_sender_name" id="emailer_sender_name" value="<?php echo esc_attr($sender_name); ?>" /><br />
							</div>
							<div class="trx_emailer_field trx_emailer_sender_email">
								<label for="emailer_sender_email"><?php esc_html_e('Sender email:', 'healthandcare'); ?></label>
								<input type="text" name="emailer_sender_email" id="emailer_sender_email" value="<?php echo esc_attr($sender_email); ?>" />
							</div>
						</div>
					</fieldset>
				</div>
	
				<div class="trx_emailer_buttons">
					<a href="#" id="trx_emailer_send"><?php echo esc_html_e('Send', 'healthandcare'); ?></a>
				</div>
	
			</form>
		</div>
		<?php
	}

}


//==========================================================================================
// Utilities
//==========================================================================================

// Set email content type
if ( !function_exists( 'healthandcare_set_html_content_type' ) ) {
	function healthandcare_set_html_content_type() {
		return 'text/html';
	}
}

// Save e-mail in subscribe list
if ( !function_exists( 'healthandcare_callback_emailer_submit' ) ) {
	function healthandcare_callback_emailer_submit() {
		global $_REQUEST;
		
		if ( !wp_verify_nonce( $_REQUEST['nonce'], 'ajax_nonce' ) )
			die();
	
		$response = array('error'=>'');
		
		$group = $_REQUEST['group'];
		$email = $_REQUEST['email'];

		if (preg_match('/[\.\-_A-Za-z0-9]+?@[\.\-A-Za-z0-9]+?[\ .A-Za-z0-9]{2,}/', $email)) {
			$subscribers = healthandcare_emailer_group_getlist($group);
			if (isset($subscribers[$group][$email]))
				$response['error'] = esc_html__('E-mail address already in the subscribers list!', 'healthandcare');
			else {
				$subscribers[$group][$email] = md5(mt_rand());
				update_option('healthandcare_emailer_subscribers', $subscribers);
				$subj = sprintf(__('Site %s - Subscribe confirmation', 'healthandcare'), get_bloginfo('site_name'));
				$url = admin_url('admin-ajax.php');
				$link = $url . (healthandcare_strpos($url, '?')===false ? '?' : '') . 'action=emailer_confirm&nonce='.urlencode($subscribers[$group][$email]).'&email='.urlencode($email).'&group='.urlencode($group);
				$msg = sprintf(__("You or someone else added this e-mail address into our subcribtion list.\nPlease, confirm your wish to receive newsletters from our website by clicking on the link below:\n\n<a href=\"%s\">%s</a>\n\nIf you do not wiish to subscribe to our newsletters, simply ignore this message.", 'healthandcare'), $link, $link);
				add_filter( 'wp_mail_content_type', 'healthandcare_set_html_content_type' );
				$sender_name = get_bloginfo('name');
				$sender_email = healthandcare_get_theme_option('contact_email');
				if (empty($sender_email)) $sender_email = get_bloginfo('admin_email');
				$headers = 'From: ' . trim($sender_name).' <' . trim($sender_email) . '>' . "\r\n";
				$mail = healthandcare_get_theme_option('mail_function');
				if (!@$mail($email, $subj, nl2br($msg), $headers)) {
					$response['error'] = esc_html__('Error send message!', 'healthandcare');
				}
				remove_filter( 'wp_mail_content_type', 'healthandcare_set_html_content_type' );
			}
		} else
			$response['error'] = esc_html__('E-mail address is not valid!', 'healthandcare');
		echo json_encode($response);
		die();
	}
}

// Confirm e-mail in subscribe list
if ( !function_exists( 'healthandcare_callback_emailer_confirm' ) ) {
	function healthandcare_callback_emailer_confirm() {
		global $_REQUEST;
		
		$group = $_REQUEST['group'];
		$email = $_REQUEST['email'];
		$nonce = $_REQUEST['nonce'];
		if (preg_match('/[\.\-_A-Za-z0-9]+?@[\.\-A-Za-z0-9]+?[\ .A-Za-z0-9]{2,}/', $email)) {
			$subscribers = healthandcare_emailer_group_getlist($group);
			if (isset($subscribers[$group][$email])) {
				if ($subscribers[$group][$email] == $nonce) {
					$subscribers[$group][$email] = '';
					update_option('healthandcare_emailer_subscribers', $subscribers);
					healthandcare_set_system_message(__('Confirmation complete! E-mail address succefully added in the subscribers list!', 'healthandcare'), 'success');
					wp_safe_redirect( esc_url( home_url('/') ) );
				} else if ($subscribers[$group][$email] != '') {
					healthandcare_set_system_message(__('Bad confirmation code!', 'healthandcare'), 'error');
					wp_safe_redirect( esc_url( home_url('/') ) );
				} else {
					healthandcare_set_system_message(__('E-mail address already exists in the subscribers list!', 'healthandcare'), 'error');
					wp_safe_redirect( esc_url( home_url('/') ) );
				}
			}
		}
		die();
	}
}


// Get subscribers list if group changed
if ( !function_exists( 'healthandcare_callback_emailer_group_getlist' ) ) {
	function healthandcare_callback_emailer_group_getlist() {
		global $_REQUEST;
		
		if ( !wp_verify_nonce( $_REQUEST['nonce'], 'ajax_nonce' ) )
			die();
	
		$response = array('error'=>'', 'subscribers' => '');
		
		$group = $_REQUEST['group'];
		$subscribers = healthandcare_emailer_group_getlist($group);
		$list = array();
		if (isset($subscribers[$group]) && is_array($subscribers[$group]) && count($subscribers[$group]) > 0) {
			foreach ($subscribers[$group] as $k=>$v) {
				if (empty($v))
					$list[] = $k;
			}
		}
		$response['subscribers'] = join("\n", $list);

		echo json_encode($response);
		die();
	}
}

// Get Subscribers list
if ( !function_exists( 'healthandcare_emailer_group_getlist' ) ) {
	function healthandcare_emailer_group_getlist($group='') {
		$subscribers = get_option('healthandcare_emailer_subscribers', array());
		if (!is_array($subscribers))
			$subscribers = array();
		if (!empty($group) && (!isset($subscribers[$group]) || !is_array($subscribers[$group])))
			$subscribers[$group] = array();
		if (is_array($subscribers) && count($subscribers) > 0) {
			$need_save = false;
			foreach ($subscribers as $grp=>$list) {
				if (isset($list[0])) {	// Plain array - old format - convert it
					$rez = array();
					foreach ($list as $v) {
						$rez[$v] = '';
					}
					$subscribers[$grp] = $rez;
					$need_save = true;
				}
			}
			if ($need_save)
				update_option('healthandcare_emailer_subscribers', $subscribers);
		}
		return $subscribers;
	}
}
?>