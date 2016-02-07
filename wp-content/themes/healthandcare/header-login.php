<div id="popup_login" class="popup_wrap popup_login bg_tint_light">
	<a href="#" class="popup_close"></a>
	<div class="form_wrap">
		<div class="form_left">
			<form action="<?php echo wp_login_url(); ?>" method="post" name="login_form" class="popup_form login_form">
				<input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url('/') ); ?>">
				<div class="popup_form_field login_field iconed_field icon-user"><input type="text" id="log" name="log" value="" placeholder="<?php esc_html_e('Login or Email', 'healthandcare'); ?>"></div>
				<div class="popup_form_field password_field iconed_field icon-lock"><input type="password" id="password" name="pwd" value="" placeholder="<?php esc_html_e('Password', 'healthandcare'); ?>"></div>
				<div class="popup_form_field remember_field">
					<a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" class="forgot_password"><?php esc_html_e('Forgot password?', 'healthandcare'); ?></a>
					<input type="checkbox" value="forever" id="rememberme" name="rememberme">
					<label for="rememberme"><?php esc_html_e('Remember me', 'healthandcare'); ?></label>
				</div>
				<div class="popup_form_field submit_field"><input type="submit" class="submit_button" value="<?php esc_html_e('Login', 'healthandcare'); ?>"></div>
			</form>
		</div>
	</div>	<!-- /.login_wrap -->
</div>		<!-- /.popup_login -->
