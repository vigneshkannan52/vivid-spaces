<?php
/**
 * Wrapper for main settings page.
 *
 * @package Qodeblock\Settings
 */

?>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<?php
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Nonce verified in settings save routine. This is a false positive.
	if ( ! empty( $_GET['qodeblock-settings-saved'] ) && $_GET['qodeblock-settings-saved'] === 'true' ) {
		echo '<div class="updated fade"><p>' . esc_html__( 'Settings saved.', 'qodeblock' ) . '</p></div>';
	}
	?>

	<form method="post" action="options.php" class="qodeblock-options-form">
			<?php
			require $pages_dir . 'settings-general.php';
			submit_button( esc_html__( 'Save Settings', 'qodeblock' ) );
			wp_nonce_field( 'qodeblock-settings-save-nonce', 'qodeblock-settings-save-nonce' );
			?>
	</form>
</div>
