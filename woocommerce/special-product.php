<?php
/**
 * Special Product Layout
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce_loop;

$post_thumbnail_id = get_post_thumbnail_id($post->ID);
$attachment_ids = $product->get_gallery_image_ids();
?>

<div class="product-thumbs">
	<div class="images">
		<?php echo lorada_get_product_thumbnail( $post_thumbnail_id, 'shop_single' ); ?>

		<div class="thumb-images">
			<?php
				if ( $attachment_ids && has_post_thumbnail() ) {
					$i = 0;
					$loading_class = 'is-loading';

					foreach ( $attachment_ids as $attachment_id ) {
						if ( $i < 4 ) {
							$props = wc_get_product_attachment_props( $attachment_id, $post );

							$html = '';
							$html .= '<div class="thumb-wrap"><a href="' . get_the_permalink() . '"" class="lorada-product-img-link thumbnail-image ' . esc_attr( $loading_class ) . '">';
							$html .= wp_get_attachment_image( $attachment_id, 'shop_thumbnail', '', array(
								'title'		=>	$props['title'],
								'alt'		=>	$props['alt'],
								'class'		=>	'img-responsive product-thumbnail-img'
							) );
							$html .= "</a></div>";

							echo '' . $html;
						}

						$i++;
					}
				}
			?>
		</div>
	</div>
</div>

<div class="product-infobox">
	<?php
	/**
	 * woocommerce_shop_loop_item_title hook.
	 *
	 * @hooked lorada_woocommerce_template_loop_product_category - 10 : Added
	 * @hooked woocommerce_template_loop_product_title - 20 : Changed
	 */
	do_action( 'woocommerce_shop_loop_item_title' );

	echo woocommerce_template_single_rating();

  echo "<div class='meenta-special-product__price-wrapper d-flex align-items-center'>";
	echo woocommerce_template_loop_price();
  meenta_price_unit_label($product, false);
  echo "</div>";
  

	$stock_output = '<span class="in-stock">' . esc_html__( 'In stock', 'lorada' ) . '</span>';

	if ( ! $product->is_in_stock() ) {
		$stock_output = '<span class="out-stock">' . esc_html__( 'Out of stock', 'lorada' ) . '</span>';		
	}
	?>
	<div class="stock-state">
		<span class="label"><?php echo esc_html__( 'Available', 'lorada' ); ?>:</span>
		<?php echo '' . $stock_output; ?>
	</div>

	<?php if ( ( 'full' == $woocommerce_loop['product_layout'] ) && ( 'yes' == $woocommerce_loop['description_enable'] ) ) : ?>
		<div class="product-summary">
			<p>
				<?php 
					if ( ! empty( $woocommerce_loop['description_length'] ) ) {
						$length = (int) $woocommerce_loop['description_length'];
					} else {
						$length = 25;
					}

					$content = get_the_excerpt();
					$content = lorada_strip_tags( apply_filters( 'the_content', $content ) );
					$content = explode( ' ', $content, $length );

					if ( count( $content ) >= $length ) {
						array_pop( $content );
						$content = implode( ' ', $content ) . '...';
					} else {
						$content = implode( ' ', $content );
					}

					echo '' . $content;
				?>
			</p>
		</div>
	<?php endif; ?>

	<?php
	if ( 'yes' == $woocommerce_loop['countdown_timer'] ) {
		/**
		 * lorada_woocommerce_product_countdown hook.
		 *
		 * @hooked lorada_woocommerce_sale_product_countdown_time - 10
		 */
		do_action( 'lorada_woocommerce_product_countdown' );
	}
	?>

	<?php 
	$available_quantity = 0;

	if ( ! $product->is_type( 'variable' ) ) {
		$available_quantity = $product->get_stock_quantity();
	} else {
		$added_variations = $product->get_available_variations();

		foreach ( $added_variations as $single_variant ) {
			if ( $single_variant['max_qty'] ) $available_quantity = $available_quantity + $single_variant['max_qty'];
		}
	}

	if ( $available_quantity ) {
		$product_sold = get_post_meta( $product->get_id(), 'total_sales', true );
		$total_quantity = $available_quantity + $product_sold;
		$sold_percentage = $product_sold / $total_quantity * 100;

		?>
		<div class="quantity-state">
			<div class="state-progress progress">
				<span class="progress-bar" style="width: <?php echo esc_attr( $sold_percentage ) ?>%"></span>
			</div>

			<div class="quantity-stock-num">
				<span class="number">
					<strong><?php echo esc_html( $product_sold ); ?></strong> / <strong><?php echo esc_html( $total_quantity ); ?></strong>
				</span>
				<span class="label"><?php echo esc_html__( 'Sold', 'lorada' ); ?></span>
			</div>
		</div>
		<?php
	}
	?>
</div>