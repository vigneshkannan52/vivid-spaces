<div class="scheduled-settings-prewrap">
	<div class="scheduled-settings-wrap scheduled-payment-settings-wrap wrap">
		<div class="scheduled-settings-title"><?php echo __('WooCommerce Settings', 'scheduled') ?></div>

		<div id="scheduled-admin-panel-container">

			<div class="form-wrapper">

				<form action="options.php" method="post">

					<div id="scheduled-general" class="tab-content">
						<?php
						settings_fields(SCHEDULED_WC_PLUGIN_PREFIX . 'payment_options');
						do_settings_sections(SCHEDULED_WC_PLUGIN_PREFIX . 'payment_options'); 	//pass slug name of page
						?>

						<div class="section-row submit-section" style="padding:0;">
							<?php submit_button(); ?>
						</div><!-- /.section-row -->
					</div>
				</form>
			</div>
		</div>
	</div>
</div>