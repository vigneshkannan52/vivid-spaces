<?php
/**
 * Custom comment walker for this theme
 *
 * @since      1.0.0
 * @package    Aheto
 * @subpackage Aheto
 * @author     FOX-THEMES <info@foxthemes.me>
 */

namespace Aheto\Frontend;

/**
 * This class outputs custom comment walker for HTML5 friendly WordPress comment and threaded replies.
 *
 * @since 1.0.0
 */
class Walker_Comment extends \Walker_Comment {


	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int $depth Depth of the current comment.
	 * @param array $args An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

		?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent aheto-form-btn aheto-btn--primary' : 'aheto-form-btn aheto-btn--primary', $comment ); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <footer class="comment-meta">
                <div class="comment-author vcard">
					<?php

					$avatar = get_avatar( $comment, $args['avatar_size'] );

					if ( 0 != $args['avatar_size'] ) {
						echo $avatar;
					} ?>
                </div><!-- .comment-author -->
            </footer><!-- .comment-meta -->

            <div class="comment-content">
                <div class="comment-text">

                    <div class="comment-author-info">
			            <?php
			            $comment_author_link = get_comment_author_link( $comment );
			            $comment_author_url  = get_comment_author_url( $comment );
			            $comment_author      = get_comment_author( $comment );

			            if ( 0 != $args['avatar_size'] ) {
				            if ( ! empty( $comment_author_url ) ) {
					            printf( '<a href="%s" rel="external nofollow" class="url">', $comment_author_url );
				            }
			            }

			            printf(
			            /* translators: %s: comment author link */
				            wp_kses(
					            __( '%s <span class="screen-reader-text says">says:</span>', 'aheto' ),
					            array(
						            'span' => array(
							            'class' => array(),
						            ),
					            )
				            ),
				            '<b class="fn">' . get_comment_author_link( $comment ) . '</b>'
			            );

			            if ( ! empty( $comment_author_url ) ) {
				            echo '</a>';
			            }
			            ?>

                        <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
				            <?php
				            /* translators: 1: comment date, 2: comment time */
				            $comment_timestamp = sprintf( __( '%1$s at %2$s', 'aheto' ), get_comment_date( '', $comment ), get_comment_time() );
				            ?>
                            <time datetime="<?php comment_time( 'c' ); ?>" title="<?php echo $comment_timestamp; ?>">
					            <?php echo $comment_timestamp; ?>
                            </time>
                        </a>

			            <?php
			            edit_comment_link( __( 'Edit', 'aheto' ), '<span class="edit-link-sep">&mdash;</span> <span class="edit-link">', '</span>' );
			            ?>


                    </div>

		            <?php if ( '0' == $comment->comment_approved ) : ?>
                        <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'aheto' ); ?></p>
		            <?php endif; ?>
                </div>
				<?php comment_text(); ?>
            </div><!-- .comment-content -->
	        <?php
	        comment_reply_link(
		        array_merge(
			        $args,
			        array(
				        'add_below' => 'div-comment',
				        'depth'     => $depth,
				        'max_depth' => $args['max_depth'],
				        'before'    => '<div class="comment-reply">',
				        'after'     => '</div>',
			        )
		        )
	        );
	        ?>
        </article><!-- .comment-body -->

		<?php
	}
}
