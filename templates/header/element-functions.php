<?php
/**
 * 
 * This is all here so that we can re-arrange the icons in the header. 
 * This was copied from the parent theme and modified slightly (put search before account in the config arrays)
 * 
 */
/* Generate Header Blocks */
if ( ! function_exists( 'lorada_generate_header' ) ) {
	function lorada_generate_header( $header_layout ) {
		$header_config = lorada_get_header_config( $header_layout );
		lorada_config_divi( $header_config );
	}

	function lorada_config_divi( $configuration ) {
		foreach ( $configuration as $key => $block ) {
			lorada_generate_header_block( $key, $block );
		}
	}

	function lorada_generate_header_block( $key, $block ) {
		if ( is_array( $block ) ) {
			ob_start();
			lorada_config_divi( $block );
			$output = ob_get_contents();
			ob_end_clean();

			// Generate div block with $key class
			echo '<div class="' . esc_attr( $key ) . '">';
			if ( ! empty( $output ) ) {
				echo '' . $output;
			}
			echo '</div>';
		} else {
			$block_function = 'lorada_header_block_' . $block;

			if ( function_exists( $block_function ) ) {
				$block_function();
			}
		}
	}

	function lorada_get_header_config( $header_layout = 'header_default' ) {
		$header_config = array();

		$navigation_wrapper_class = 'navigation-wrapper';

		$header_config['header_default'] = array(
			'header-container' => array(
				'header-wrapper' => array(
					'header_mobile_nav',
					'logo',
					'header_widget',
					'right-column' => array(
						'search',
						'account',
						'wishlist',
						'cart'
					)
				)
			),
			$navigation_wrapper_class => array(
				'nav-container' => array(
					'navigation-inner' => array(
						'collection_menu',
						'main_nav_menu',
						'menu_extend_txt'
					)
				)
			)
		);

		$header_config['header_simple'] = array(
			'header-container' => array(
				'header-wrapper' => array(
					'header_mobile_nav',
					'logo',
					'main_nav_menu',
					'right-column' => array(
						'search',
						'account',
						'wishlist',
						'cart'
					)
				)
			)
		);

		$header_config['advanced_logo_center'] = array(
			'header-container' => array(
				'header-wrapper' => array(
					'header_mobile_nav',
					'header_widget',
					'logo',
					'right-column' => array(
						'search',
						'account',
						'wishlist',
						'cart'
					)
				)
			),
			$navigation_wrapper_class => array(
				'nav-container' => array(
					'navigation-inner' => array(
						'main_nav_menu'
					)
				)
			)
		);

		$header_config['left_menu_bar'] = array(
			'left-side-menu-inner' => array(
				'header-sidebar-wrapper' => array(
					'logo',
					'header_widget',
					'navigation-inner' => array(
						'main_nav_menu'
					),
					'header-icon-links' => array(
						'search',
						'account',
						'wishlist',
						'cart'
					),
					'header-multi-settings' => array(
						'multi_cur',
						'multi_lang'
					),
					'left-menu-footer' => array(
						'menu_extend_txt'
					)
				)
			)
		);

		if ( ! isset( $header_config[ $header_layout ] ) ) {
			$header_layout = 'header_default';
		}

		return $header_config[$header_layout];
	}
}