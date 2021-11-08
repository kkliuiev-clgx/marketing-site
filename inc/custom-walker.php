<?php 
/**
 *	Menu Custom Walker
 */

class LoradaWalker extends Walker_Nav_Menu {
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query, $wpdb;

		/* Get Custom Menu Values */
		$submenu_style = $item->menu_style;		
		$html_block = $item->menu_block;
		$submenu_width = $item->menu_width;
		$submenu_height = $item->menu_height;
		$submenu_bg = $item->menu_background;
		$menu_icon = $item->menu_icon;
		$menu_marker = $item->menu_marker;
		$menu_marker_array = get_option( 'lorada_menu_marker_opt' );
		$submenu_text_scheme = $item->submenu_text_scheme;

		$product_icon = '';
		if ( 'product_cat' == $item->object ) {
			$product_icon = get_term_meta( $item->object_id, 'product_cat_menu_icon', true );
		}
		/* End Getting Custom Menu Values */

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$id_name = $class_names = $extra_classes[] = '';
		$id_name = ' id="lorada-menu-item-' . esc_attr( $item->ID ) . '"';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$extra_classes[] = 'item-level-' . $depth;
		$extra_classes[] = $submenu_style;

    /**
     * If this is not a mega menu, we need to add the default menu class to the <li> . this is needed to bring in the correct styling from the parent theme
     */
		if ( $submenu_style == 'full-width-mega' || $submenu_style == 'sized-mega' ) {
			$extra_classes[] = 'dropdown-mega-menu';
		} else {
      $extra_classes[] = 'default-menu';
    }
		if ( is_numeric( $html_block ) ) {
			$extra_classes[] = 'menu-item-has-block';
		}
		if ( $submenu_text_scheme ) {
			$extra_classes[] = 'submenu-txt-scheme-' . $submenu_text_scheme;
		}
		$extra_classes = implode( ' ', $extra_classes );

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="'. esc_attr( $class_names ) . ' ' . esc_attr( $extra_classes ) . '"';

		$output .= $indent . '<li ' . $id_name . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url ) .'"' : '';
		$submenu_bg = ! empty( $submenu_bg ) ? esc_url( $submenu_bg ) : '';
		$menu_icon = ! empty( $item->menu_icon ) ? '<i class="has-menu-icon ' . $menu_icon . '"></i>' : '';
		$product_icon_img = ! empty( $product_icon ) ? '<img class="product-category-icon" src="' . esc_url( $product_icon ) . '">' : '';

		$prepend = '';
		$append = '';

		if($depth != 0) {
		   $description = $append = $prepend = "";
		}

		if ( 'title' != $menu_marker ) {
			$menu_marker_name = $menu_marker;
		} else {
			$menu_marker_name = '';
		}
		
		// Insert Output Content Start
		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $menu_icon;
		$item_output .= $product_icon_img;
		$item_output .= '<span class="menu-title">' . $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;

		$marker_name = '';
		$marker_color = '';
		$marker_bg = '';

		if ( ! empty( $menu_marker_name ) && ! empty( $menu_marker_array ) ) {
			foreach ( $menu_marker_array as $key ) {
				if ( $menu_marker_name == $key['name'] ) {
					$marker_name = $key['name'];
					$marker_color = $key['color'];
					$marker_bg = $key['bg_color'];
				}
			}

			$item_output .= '<span class="lorada-menu-marker has-menu-marker" style="color: ' . esc_attr( $marker_color ) . '; background-color: ' . esc_attr( $marker_bg ) . ';"><span>' . esc_html( $marker_name ) . '</span><span class="marker-triangle" style="border-color: ' . esc_attr( $marker_bg ) . ';"></span></span>';
		}

		$item_output .= '</span></a>';
		
		if ( ( stripos( $class_names, 'has-children' ) === false ) && is_numeric( $html_block ) && ( 'default-menu' != $submenu_style ) ) {
			if ( class_exists( 'Lorada_Core_Main_Functions' ) ) {
				$item_output .= '<div class="sub-menu-dropdown">' . Lorada_Core_Main_Functions::instance()->lorada_core_html_block( array( 'block_id' => $html_block ) ) . '</div>';
			}
		}

		if ( 'sized-mega' == $submenu_style ) {
			$submenu_width = ! empty( $submenu_width ) ? $submenu_width . 'px' : 'auto';
			$submenu_height = ! empty( $submenu_height ) ? $submenu_height . 'px' : 'auto';

			$item_output .= '<style type="text/css">#lorada-menu-item-' . $item->ID . ' > .sub-menu-dropdown {';
			$item_output .= 'min-width: ' . $submenu_width . '; min-height: ' . $submenu_height . ';';
			$item_output .= '}</style>';
		}

		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

		apply_filters( 'walker_nav_menu_start_lvl', $item_output, $depth, $args->background_url = $submenu_bg );
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( $args->background_url != '' ) {
			$bg_class = 'has-background';
			$bg_style = 'style="background-image: url(' . $args->background_url . ');"';
		} else {
			$bg_class = '';
			$bg_style = '';
		}

		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu-dropdown ". $bg_class . " sub-menu-level-". $depth ."\" " . $bg_style . ">\n";
	}
}

?>