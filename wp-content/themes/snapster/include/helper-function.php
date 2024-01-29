<?php

require_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * Create custom html structure for comments
 */
if ( !function_exists('snapster_comment') ) {
	function snapster_comment($comment, $args, $depth) {

		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ):
			case 'pingback':
			case 'trackback': ?>
				<div class="pinback">
					<span class="pin-title"><?php esc_html_e('Pingback: ', 'snapster'); ?></span><?php comment_author_link(); ?>
					<?php edit_comment_link(esc_html__('(Edit)', 'snapster'), '<span class="edit-link">', '</span>'); ?>

				<?php
				break;
			default:
				// generate comments
				?>
			<div <?php comment_class('snapster-blog--single__comments-item'); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>" class="snapster-blog--single__comments-item-wrap">
					<div class="snapster-blog--single__comments-content">
                        <span class="person-img">
							<?php echo get_avatar($comment, '80', '', '', array('class' => 'img-person')); ?>
                        </span>
						<div class="comment-content">
							<div class="author-wrap">
								<div class="author">
									<?php comment_author(); ?>
								</div>
								<?php comment_reply_link(
									array_merge($args,
										array(
											'reply_text' => esc_html__('Reply', 'snapster'),
											'after'      => '',
											'depth'      => $depth,
											'max_depth'  => $args['max_depth']
										)
									)
								); ?>
							</div>
                            <div class="comment-date">
                                <?php comment_date(get_option('date_format')); ?>
                            </div>
							<div class="comment-text">
								<?php comment_text(); ?>
							</div>

						</div>
					</div>
				</div>
				<?php
				break;
		endswitch;
	}
}


/**
 * Filter for excerpt more string
 */

if ( !function_exists('snapster_excerpt_more') ) {
	function snapster_excerpt_more() {
		return ' ...';
	}

	add_filter('excerpt_more', 'snapster_excerpt_more');
}


/**
 * Header template
 */

if ( ! function_exists( 'snapster_main_header_html' ) ) {
	function snapster_main_header_html() {

		$active_plugin = function_exists( 'aheto' ) ? true : false;
	    $template_name = $active_plugin ? 'aheto' : 'theme';

		get_template_part( 'template-parts/' . $template_name . '-header' );

	}
}

add_action( 'snapster_main_header', 'snapster_main_header_html' );



/**
 * Footer template
 */

if ( ! function_exists( 'snapster_main_footer_html' ) ) {
	function snapster_main_footer_html() {

		$active_plugin = function_exists( 'aheto' ) ? true : false;
		$template_name = $active_plugin ? 'aheto' : 'theme';

		get_template_part( 'template-parts/' . $template_name . '-footer' );

	}
}


add_action( 'snapster_main_footer', 'snapster_main_footer_html' );