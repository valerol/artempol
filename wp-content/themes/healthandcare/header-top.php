<div class="top_panel_top">
	<div class="content_wrap clearfix">
		<div class="top_panel_top_contact_area">
			<span class="contact_icon icon-phone"></span>
			<span class="contact_label contact_phone"><?php echo ot_get_option( 'header_phone' ); ?></span>
			<span class="contact_icon icon-home"></span>
			<span class="contact_label contact_address_1"><?php echo ot_get_option( 'header_address' ); ?></span>
			<span class="contact_icon icon-clock"></span>
			<span class="contact_label "><?php echo ot_get_option( 'header_working_hours' ); ?></span>
		</div>
		<div class="top_panel_top_user_area">
			<ul id="menu_user" class="menu_user_nav">
				<?php if ( !is_user_logged_in() ) : ?>
					<li class="menu_user_register">
						<a href="#popup_registration" class="popup_link popup_register_link icon-pencil"><?php esc_html_e('Register', 'healthandcare'); ?></a>
						<?php get_template_part( 'header', 'login' ); ?></li>
					<li class="menu_user_login">
						<a href="#popup_login" class="popup_link popup_login_link icon-user"><?php esc_html_e('Login', 'healthandcare'); ?></a>
						<?php get_template_part( 'header', 'register'); ?>
					</li>
				<?php else : $current_user = wp_get_current_user(); ?>
					<li class="menu_user_controls">
						<a href="#"><?php
							$user_avatar = '';
							if ($current_user->user_email) $user_avatar = get_avatar($current_user->user_email);
							if ($user_avatar) {
								?><span class="user_avatar"><?php echo ($user_avatar); ?></span><?php
							}?><span class="user_name"><?php echo ($current_user->display_name); ?></span></a>
						<ul>
							<?php if (current_user_can('publish_posts')) { ?>
							<li><a href="<?php echo esc_url( home_url('/') ); ?>/wp-admin/post-new.php?post_type=post" class="icon icon-doc"><?php esc_html_e('New post', 'healthandcare'); ?></a></li>
							<?php } ?>
							<li><a href="<?php echo get_edit_user_link(); ?>" class="icon icon-cog"><?php esc_html_e('Settings', 'healthandcare'); ?></a></li>
						</ul>
					</li>
					<li class="menu_user_logout"><a href="<?php echo wp_logout_url(esc_url( home_url('/') )); ?>" class="icon icon-logout"><?php esc_html_e('Logout', 'healthandcare'); ?></a></li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</div>
