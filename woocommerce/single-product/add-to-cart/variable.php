<?php
/**
 * Variable product add to cart
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.5.5
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$attribute_keys = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo esc_attr( $variations_attr ); // WPCS: XSS ok. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'lorada' ); ?></p>
	<?php else : ?>
		<div class="variations" cellspacing="0">
			<?php foreach ( $attributes as $attribute_name => $options ) : ?>

				<?php
					$swatches = lorada_attribute_swatches( $product->get_id(), $attribute_name, $options, $available_variations );
					$swatches_class = (! empty( $swatches )) ? ' attribute-swatches-enable' : '';
					$attribute_type = (! empty( lorada_get_opt('product_attribute_type') )) ? lorada_get_opt('product_attribute_type') : 'select';

					$swatches_class .= ' attribute-type-' . $attribute_type;
				?>

				<div class="variations-list-wrapper">
					<div class="attribute-label">
						<label for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?> :</label>
					</div>
					<div class="value<?php echo esc_attr( $swatches_class ); ?>">
						<?php if ( 'buttonset' == $attribute_type ) : ?>
							<div class="product-attribute-swatches select-swatches" data-id="<?php echo sanitize_title( $attribute_name ); ?>">
								<?php
									if ( is_array( $options ) ) {

										if ( isset( $_REQUEST[ 'attribute_' . $attribute_name ] ) ) {
											$selected_swatch_value = wc_clean( urldecode( wp_unslash( $_REQUEST[ 'attribute_' . $attribute_name ] ) ) );
										} else {
											$selected_swatch_value = '';
										}

										if ( taxonomy_exists( $attribute_name ) ) {
											$terms = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'all' ) );

											$options_flip = array_flip( $options );

											foreach ( $terms as $term ) {
												if ( ! in_array( $term->slug, $options ) ) {
													continue;
												}

												$key = $options_flip[$term->slug];
												$bg_style = '';
												$swatch_class = 'lorada-swatch-inner';

												if ( ! empty( $swatches[$key]['attribute_image'] ) ) {
													$swatch_class .= ' image-swatch';
													$bg_style = 'background-image: url(' . $swatches[$key]['attribute_image'] . ')';
												} else if ( ! empty( $swatches[$key]['attribute_color'] ) ) {
													$swatch_class .= ' color-swatch';
													$bg_style = 'background-color: ' . $swatches[$key]['attribute_color'];
												} else {
													$swatch_class .= ' text-swatch';
												}

												echo '<div class="' . esc_attr( $swatch_class ) . '" data-value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_swatch_value ), sanitize_title( $term->slug ), false ) . ' style="' . esc_attr( $bg_style ) .'">' . esc_html( $term->name ) . '</div>';
											}
										} else {
											foreach ( $options as $option ) {
												echo '<div data-value="' . esc_attr( $option->slug ) . '" ' . selected( sanitize_title( $selected_swatch_value ), sanitize_title( $option->slug ), false ) . '>' . esc_html( $option->name ) . '</div>';
											}
										}

									}
								?>
							</div>
						<?php endif; ?>

						<?php
							wc_dropdown_variation_attribute_options( array(
								'options'   => $options,
								'attribute' => $attribute_name,
								'product'   => $product,
							) );
							echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'lorada' ) . '</a>' ) ) : '';
						?>
					</div>
				</div>
			<?php endforeach;?>
		</div>

		<div class="single_variation_wrap">
			<?php
				/**
				 * woocommerce_before_single_variation Hook.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * woocommerce_after_single_variation Hook.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
