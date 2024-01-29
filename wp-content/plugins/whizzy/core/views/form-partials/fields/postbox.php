<?php defined( 'ABSPATH' ) or die;
/* @var WhizzyFormField $field */
/* @var WhizzyForm $form */
/* @var mixed $default */
/* @var string $name */
/* @var string $idname */
/* @var string $label */
/* @var string $desc */
/* @var string $rendering */

?>
<div class="inside">
	<?php foreach ( $field->getmeta( 'options', array() ) as $fieldname => $fieldconfig ):
		$field = $form->field( $fieldname, $fieldconfig );
		// we set the fields to default to inline
		$field->ensuremeta( 'rendering', 'blocks' );
		// export field meta for processing
		$fielddesc = $field->getmeta( 'desc', null );
		$show_group = $field->getmeta( 'show_group', null ); ?>

        <div class="field-wrap" <?php if ( $fieldconfig['type'] == 'group' ) { echo 'id="' . esc_attr( $fieldname ) . '"'; } ?>>
			<?php if ( ! empty( $fielddesc ) ): ?>
                <div class="field-desc"><?php echo esc_html( $fielddesc ); ?></div>
			<?php endif;
			echo $field->render();
			if ( ! empty( $fieldnote ) ): ?>
                <span class="note"><?php echo esc_html( $fieldnote ); ?></span>
			<?php endif; ?>
        </div>

	<?php endforeach; ?>
</div>
