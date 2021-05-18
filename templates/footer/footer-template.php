<?php
/**
 * Footer Template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$footer_class = array();

if ( 'full' == lorada_get_opt( 'site_layout' ) && 'custom' == lorada_get_opt( 'footer_width_style' ) ) {
	$footer_class[] = 'footer-boxed-width';
} else {
	$footer_class[] = 'container-fluid';
}

$footer_class = implode( ' ', $footer_class );

$footer_layout = lorada_get_opt( 'footer_layout' );
$footer_layout_config = lorada_footer_configuration( $footer_layout );
?>

<footer id="lorada-footer" class="footer-container <?php echo esc_attr( $footer_layout ); ?>-layout">
	<?php if ( '' != lorada_get_opt( 'footer_top_content' ) ) : ?>
		<div class="footer-top">
				<div class="footer-top-wrapper">
					<?php echo do_shortcode( lorada_get_opt( 'footer_top_content' ) ); ?>
				</div>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( count( $footer_layout_config['column'] ) ) ) : ?>
		<div class="footer-main">
			<div class="footer-main-wrapper <?php echo esc_attr( $footer_class ); ?>">
      
        <?php // get_template_part('partials/footer/logo', 'bar'); ?>
        
				<div class="row footer-widget-content">
				<?php
					foreach ( $footer_layout_config[ 'column' ] as $key => $columns ) {
						$column_index = $key + 1;
						?>

						<div class="main-footer-column column-index-<?php echo esc_attr( $column_index ); ?> <?php echo esc_attr( $columns ); ?>">
							<?php

								if ( is_active_sidebar( 'lorada-footer-widget-' . $column_index ) ) {
									dynamic_sidebar( 'lorada-footer-widget-' . $column_index );
								}

							?>
						</div>

						<?php
					}
				?>

				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( lorada_get_opt( 'copyright_setting' ) ) : ?>

		<?php if ( lorada_get_opt( 'split_line' ) ) : ?>
			<div class="split-line <?php echo esc_attr( $footer_class ); ?>">
				<div class="line-content"></div>
			</div>
		<?php endif; ?>

    <div class="meenta-techstars-callout">
      <img class="img-fluid" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/techstars.png" alt="Techstars logo">
      <p class="meenta-techstars-callout__body">Proud participant of Techstars Boston Class '18</p>
    </div>
    
		<div class="footer-bottom">
			<div class="footer-bottom-wrapper <?php echo esc_attr( $footer_class ); ?>">
				<div class="row">

					<div class="copyright col-lg-6 col-md-6">
						<?php if ( '' != lorada_get_opt( 'copyright_text' ) ) { ?>
							<p><?php echo lorada_get_opt( 'copyright_text' ); ?></p>
						<?php } ?>
					</div>

					<div class="payment-logo col-lg-6 col-md-6">
						<?php

						$payment_logo = lorada_get_opt( 'footer_payment_logo' );
						if ( isset( $payment_logo ) && isset( $payment_logo['url'] ) && ! empty( $payment_logo['url'] ) ) {
							?>

							<img src="<?php echo esc_attr( $payment_logo['url'] ); ?>" alt="<?php echo esc_attr__( 'Payment Logo', 'lorada' ); ?>" width="327" height="20">

							<?php
						}

						?>
					</div>

				</div>
			</div>
		</div>
	<?php endif; ?>
</footer>
