					<div class="logo">
						<a href="<?php echo esc_url( home_url('/') ); ?>"><?php
							echo !empty($HEALTHANDCARE_GLOBALS['logo'])
								? '<img src="'.esc_url($HEALTHANDCARE_GLOBALS['logo']).'" class="logo_main" alt="">'
								: ''; 
							echo ($HEALTHANDCARE_GLOBALS['logo_text']
								? '<div class="logo_text">'.($HEALTHANDCARE_GLOBALS['logo_text']).'</div>'
								: '');
							echo ($HEALTHANDCARE_GLOBALS['logo_slogan']
								? '<br><div class="logo_slogan">' . esc_html($HEALTHANDCARE_GLOBALS['logo_slogan']) . '</div>'
								: '');
						?></a>
					</div>
