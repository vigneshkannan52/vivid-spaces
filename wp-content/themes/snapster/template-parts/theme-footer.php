<?php

$footer_text = get_bloginfo( 'name' ) . ' ' . esc_html__( ' &copy;', 'snapster' ) . date( 'Y' );

?>

</div><!-- #content -->

<footer id="footer" class="snapster-footer">
	<div class="snapster-footer--copyright"><?php echo wp_kses($footer_text, 'post'); ?></div>
</footer>