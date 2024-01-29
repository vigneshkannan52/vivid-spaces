<div id="scheduled-welcome-screen">
	<div class="wrap about-wrap">
		<div id="scheduled-welcome-panel" class="scheduled-welcome-panel">

			<img src="<?php echo SCHEDULED_PLUGIN_URL; ?>/templates/images/welcome-banner.png" class="scheduled-welcome-banner">

			<div class="scheduled-welcome-panel-intro">
				<h1><?php echo sprintf(esc_html__('Thank you for choosing %s.','scheduled'),'Scheduled'); ?></h1>
                <p><?php echo sprintf(esc_html__('If this is your first time using %s, you will find some helpful "Getting Started" links below. If you just updated the plugin, you can find out what\'s new in the "What\'s New" section below.','scheduled'),'Scheduled'); ?></p>
            </div>

			<div class="scheduled-welcome-panel-content">
				<div class="scheduled-welcome-panel-column-container">
					<div class="scheduled-welcome-panel-column">
						<h3><?php esc_html_e('Getting Started','scheduled'); ?></h3>
						<ul>
							<li><i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp;&nbsp;<a class="welcome-icon welcome-learn-more" href="https://boxystudio.ticksy.com/article/3239/" target="_blank"><?php esc_html_e('Installation & Setup Guide','scheduled'); ?></a></li>
							<li><i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp;&nbsp;<a class="welcome-icon welcome-learn-more" href="https://boxystudio.ticksy.com/article/6268/" target="_blank"><?php esc_html_e('Custom Calendars','scheduled'); ?></a></li>
							<li><i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp;&nbsp;<a class="welcome-icon welcome-learn-more" href="https://boxystudio.ticksy.com/article/3238/" target="_blank"><?php esc_html_e('Default Time Slots','scheduled'); ?></a></li>
							<li><i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp;&nbsp;<a class="welcome-icon welcome-learn-more" href="https://boxystudio.ticksy.com/article/3233/" target="_blank"><?php esc_html_e('Custom Time Slots','scheduled'); ?></a></li>
							<li><i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp;&nbsp;<a class="welcome-icon welcome-learn-more" href="https://boxystudio.ticksy.com/article/6267/" target="_blank"><?php esc_html_e('Custom Fields','scheduled'); ?></a></li>
							<li><i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp;&nbsp;<a class="welcome-icon welcome-learn-more" href="https://boxystudio.ticksy.com/article/3240/" target="_blank"><?php esc_html_e('Shortcodes','scheduled'); ?></a></li>
						</ul>
						<a class="button" style="margin-bottom:15px; margin-top:0;" href="https://boxystudio.ticksy.com/articles/7827/" target="_blank"><?php esc_html_e('View all Guides','scheduled'); ?>&nbsp;&nbsp;<i class="fa-solid fa-arrow-up-right-from-square"></i></a>&nbsp;
						<a class="button button-primary" style="margin-bottom:15px; margin-top:0;" href="<?php echo get_admin_url().'admin.php?page=scheduled-settings'; ?>"><?php esc_html_e('Get Started','scheduled'); ?></a>
					</div>
					<div class="scheduled-welcome-panel-column scheduled-welcome-panel-last">
						<?php do_action( 'scheduled_welcome_before_changelog' ); ?>
						<?php echo scheduled_parse_readme_changelog(); ?>
						<?php do_action( 'scheduled_welcome_after_changelog' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
