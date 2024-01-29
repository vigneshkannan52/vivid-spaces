<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	/**
	 * Represents the view for the administration dashboard.
	 *
	 * This includes the header, options, and other information that should
	 * provide the user interface to the end user.
	 *
	 * @package   Whizzy
	 * @author    FOXTHEMES
	 * @license   GPL-2.0+
	 * @link      http://foxthemes.com
	 */

$config = include whizzy::pluginpath() . 'plugin-config.php';

// invoke processor
$processor = whizzy::processor( $config );
$status = $processor->status();
$errors = $processor->errors(); ?>

<div class="wrap" id="whizzy_form">

	<div id="icon-options-general" class="icon32"><br></div>

	<h2><?php esc_html_e( 'Whizzy Settings', 'whizzy' ); ?></h2>

	<?php if ( $processor->ok() ): ?>

		<?php if ( ! empty( $errors ) ): ?>
			<br/>
			<p class="update-nag">
                <strong><?php esc_html_e( 'Unable to save settings.', 'whizzy' ); ?></strong>
				<?php esc_html_e( 'Please check the fields for errors and typos.', 'whizzy' ); ?>
            </p>
		<?php endif; ?>

		<?php if ( $processor->performed_update() ): ?>
			<br/>
			<p class="update-nag">
				<?php esc_html_e( 'Settings have been updated.', 'whizzy' );?>
			</p>
		<?php endif; ?>

        <div id="whizzy">
            <div class="tabs">
                <div class="tabs-header">
                    <ul>
                        <li class="active"><a href="#"><span class="dashicons-before dashicons-admin-generic"></span><?php esc_html_e( 'General', 'whizzy' ); ?></a></li>
                        <li><a href="#"><span class="dashicons-before dashicons-format-image"></span><?php esc_html_e( 'Whizzy', 'whizzy' ); ?></a></li>
                        <?php do_action( 'whizzy_admin_settings_tab_list' ); ?>
                    </ul>
                </div>
                <div class="tabs-content">
	                <?php echo $f = whizzy::form( $config, $processor ); ?>
                    <div class="tabs-item active">
                        <?php
                        echo $f->field('hiddens')->render();
                        echo $f->field('general')->render();
                        ?>
                    </div>
                    <div class="tabs-item">
                        <?php echo $f->field('post_types')->render(); ?>
                    </div>
                    <?php do_action( 'whizzy_admin_settings_tabs_content', $f ); ?>
                </div>
            </div>
        </div>

        <button type="submit" class="button button-primary">
            <?php esc_html_e( 'Save Changes', 'whizzy' ); ?>
        </button>

		<?php echo $f->endform() ?>

	<?php elseif ( $status['state'] == 'error' ): ?>

		<h3><?php esc_html_e( 'Critical Error', 'whizzy' ); ?></h3>

		<p><?php echo esc_html( $status['message'] ); ?></p>

	<?php endif; ?>
</div>