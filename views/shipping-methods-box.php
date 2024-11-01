<?php
/**
 * Shipping methods data box view.
 *
 * @package ts-osp
 */

?>
<div class="ts-osp-shipping-methods">
	<?php
	foreach ( $all_shipping_methods as $shipping_method ) {
		$checked = '';
		if ( is_array( $disabled_methods ) && in_array( $shipping_method->id, $disabled_methods ) ) {
			$checked = 'checked';
		}
		?>
		<input type="checkbox" <?php echo esc_html( $checked ); ?> name="ts_osp_disabled_methods[]" id="ts_osp_disabled_methods_<?php echo esc_html( $shipping_method->id ); ?>" value="<?php echo esc_html( $shipping_method->id ); ?>">
		<label for="ts_osp_disabled_methods_<?php echo esc_html( $shipping_method->id ); ?>"><?php echo esc_html( $shipping_method->method_title ); ?></label><br>
		<?php
	}
	?>
</div>
