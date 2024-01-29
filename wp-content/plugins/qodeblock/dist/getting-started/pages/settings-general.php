<?php
/**
 * General tab for the settings page.
 *
 * @package Qodeblock\Settings
 */

$qodeblock_mailchimp_api_key = get_option( 'qodeblock_mailchimp_api_key', '' );
?>
<table class="form-table">
	<tbody>
		<tr>
			<th>
				<label for="qodeblock-settings[mailchimp-api-key]">
					<?php esc_html_e( 'Mailchimp API Key', 'qodeblock' ); ?>
				</label>
			</th>
			<td>
				<input type="text" id="qodeblock-settings[mailchimp-api-key]" name="qodeblock-settings[mailchimp-api-key]" size="40" value="<?php echo esc_attr( $qodeblock_mailchimp_api_key ); ?>" />
				<?php
					$qodeblock_mailchimp_api_key_link = sprintf(
						'<p><a href="%1$s" target="_blank" rel="noreferrer noopener">%2$s</a></p>',
						'https://mailchimp.com/help/about-api-keys/',
						esc_html__( 'Find your Mailchimp API key.', 'qodeblock' )
					);
					echo wp_kses_post( $qodeblock_mailchimp_api_key_link );
					?>
			</td>
		</tr>
	</tbody>
</table>
