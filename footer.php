<?php
/**
 * Child Theme Footer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

		<!-- Footer -->
		<?php
			if ( lorada_get_opt( 'enable_footer' ) ) :
				lorada_get_template_part( 'footer/footer', 'template' );
			endif;
		?>
		<!-- End Footer -->

		<?php if ( ! empty( lorada_get_opt( 'site_layout' ) ) && 'boxed' == lorada_get_opt( 'site_layout' ) ) : ?>
			</div>
		<?php endif; ?>

		<?php if ( is_singular( 'post' ) && ( 'backstretch' == lorada_get_opt( 'post_view_style' ) ) ) : ?>
			</div>
		<?php endif; ?>

	</div>
	<!-- End Page wrapper -->

	<!-- WordPress wp_footer() -->
	<?php wp_footer(); ?>

  <?php get_template_part('partials/third-party', 'services'); ?>

</body>
</html>
