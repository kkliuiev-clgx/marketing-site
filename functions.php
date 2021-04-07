<?php
/* Lorada Child Theme Functions */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function lorada_child_theme() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/assets/css/style.css', array( 'parent-style', 'lorada-theme-style' ), wp_get_theme()->get('Version') );
}

add_action( 'wp_enqueue_scripts', 'lorada_child_theme' );

function meenta_remove_scripts() {
  // eliminate the parent theme's bootstrap, we will import it into our child theme stylesheet. This will allow us to use all of bootstrap's functions and customize its variables
  wp_dequeue_style( 'bootstrap-style' );
  wp_deregister_style( 'bootstrap-style' );

  // Now register your styles and scripts here
}
add_action( 'wp_enqueue_scripts', 'meenta_remove_scripts', 20 );

function dd($arr){
  echo "<pre>";
  die(print_r($arr));
  echo "</pre>";
}

/**
 * Output the "per XXX" label -- an ACF Custom Field -- for a product
 */
function meenta_price_unit_label($product, $display = false, $color = false){
  $unit_label = false;
  $classes = '';

  if($display == 'block') {
    $classes .= ' d-block';
  } else {
    $classes .= ' ml-2';
  }

  switch($color){
    case 'dark':
      $classes .= ' text-dark';
      break;
    default:
      break;
  }

  if ( function_exists( 'get_field' ) ) {
    $unit_label = get_field('unit_label', $product->ID);
  } else {
    return false;
  }
  ?>

  <small class="meenta-price__unit-label <?php echo $classes; ?>">
    <?php if($unit_label){ ?>
    per 
      <?php echo $unit_label; ?>
    <?php } ?>
  </small>
  
  <?php 
}

function meenta_template_brand_badge(){
  global $product;
  // die(print_r($product->get_attributes()));
  $brands = wp_get_post_terms( $product->get_id(), 'pa_brand', 'all' );
  if(!is_array($brands)) return false;
  ?>
  <div class="badge badge-primary mb-3 p-2">
    <?php echo $brands[0]->name; ?>
  </div>
  <?php 
}

add_action( 'woocommerce_single_product_summary', 'meenta_template_brand_badge', 4 );



add_action( 'woocommerce_after_shop_loop_item_title', 'meenta_price_unit_label', 12 );


function fooTab(){
  ?>
  <h2>Additional</h2>
  <?php
}

add_filter( 'woocommerce_product_tabs', 'meenta_product_additional_tabs' );

/**
 * ADD EXTRA TABS TO SINGLE PRODUCT PAGE
 */
if ( ! function_exists( 'meenta_product_additional_tabs' ) ) {
	function meenta_product_additional_tabs( $tabs ) {    
    global $product;
		if ( ! empty( get_field('test_details', $product->id) ) ) {
      $title = 'Test Details';
			$tabs['meenta_payment_details_tab'] = array(
				'title'		=>	$title,
				'priority'	=> 12,
				'callback'	=>	'meenta_test_details_tab_content'
			);
		}
    if ( ! empty( get_field('collection_details', $product->id) ) ) {
      $title = 'Collection Details';
			$tabs['meenta_collection_details_tab'] = array(
				'title'		=>	$title,
				'priority'	=> 13,
				'callback'	=>	'meenta_collection_details_tab_content'
			);
		}
    if ( ! empty( get_field('payment_methods', $product->id) ) ) {
      $title = 'Payment Methods';
			$tabs['meenta_payment_methods_tab'] = array(
				'title'		=>	$title,
				'priority'	=> 14,
				'callback'	=>	'meenta_payment_methods_tab_content'
			);
		}

    /** Do not need this tab, hide it for now...  */
    if($tabs['additional_information']) unset($tabs['additional_information']);
    
		return $tabs;
	}
}

if ( ! function_exists( 'meenta_test_details_tab_content' ) ) {
	function meenta_test_details_tab_content() {
		global $product;
    $content = get_field('test_details', $product->id);
		if ( ! empty( $content ) ){
			echo $content;
		}
	}
}

if ( ! function_exists( 'meenta_collection_details_tab_content' ) ) {
	function meenta_collection_details_tab_content() {
		global $product;
    $content = get_field('collection_details', $product->id);
		if ( ! empty( $content ) ){
			echo $content;
		}
	}
}

if ( ! function_exists( 'meenta_payment_methods_tab_content' ) ) {
	function meenta_payment_methods_tab_content() {
		global $product;
    $content = get_field('payment_methods', $product->id);
		if ( ! empty( $content ) ){
			echo $content;
		}
	}
}

add_shortcode( 'btn', 'bootstrap_btn' );
function bootstrap_btn( $atts, $content = null ) {
  $atts = shortcode_atts( array(
    "type"     => false,   // Type : default, primary, success, info, warning, warning, link
    "size"     => false,   // Size : lg, sm, xs
    "block"    => false,   // Block : true
    "link"     => '#', // Link for the Href
    "disabled" => false,   // Disabled : true
    "active"   => false,   // Active : true
    "xclass"   => false,   // Extra Class
    "title"    => false,   // Title for <a> tag
    "target"  => false // Target for <a> tag
  ), $atts );
   
  $class  = 'btn';
  $class .= ( $atts['type'] ) ? ' btn-' . $atts['type'] : ' btn-default';
  $class .= ( $atts['size'] ) ? ' btn-' . $atts['size'] : '';
  $class .= ( $atts['block'] == 'true' ) ? ' btn-block' : '';
  $class .= ( $atts['disabled'] == 'true' ) ? ' disabled' : '';
  $class .= ( $atts['active'] == 'true' ) ? ' active' : '';
  $class .= ( $atts['xclass'] ) ? ' ' . $atts['xclass'] : '';
   
  $target = ( $atts['target'] ) ? sprintf( 'target="%s"',  esc_attr( $atts['target'] ) ) : '';
  $title = ( $atts['title'] ) ? sprintf( 'title="%s"',  esc_attr( $atts['title'] ) ) : '';
  $button = '<a href="'.esc_url( $atts['link'] ).'" class="'.esc_attr( $class ).'"'.$title.' '.$target.'>'.do_shortcode( $content ).'</a>';
   
  return $button;
}

/**
 * Product Bundle CTA
 */
if ( ! function_exists( 'meenta_custom_bundles_callout' ) ) {
	function meenta_custom_bundles_callout() {
		echo do_shortcode('[lorada_html_block block_id=\'698\']');
	}
}
add_action( 'woocommerce_before_single_product_summary', 'meenta_custom_bundles_callout', 21 );

/**
 * Product Questions CTA
 */
if ( ! function_exists( 'meenta_single_product_questions_callout' ) ) {
  function meenta_single_product_questions_callout() {
    echo do_shortcode('[lorada_html_block block_id=\'707\']');
	}
}
add_action( 'woocommerce_after_single_product_summary', 'meenta_single_product_questions_callout', 19 );

/**
 * Returns the link for an ACF button
 */
function get_acf_button_link($button){
  $link = false;
  if($button['button_type']){
    if($button['button_type'] == 'page-link'){
      $link = $button['button_page'];
    } else {
      $link = $button['button_link'];
    }
  }
  return $link;
}

/**
 * Outputs the target attribute for an ACF button
 */
function acf_button_target($button){
  if($button['button_target'] == 'new_tab'){ 
    echo "target='blank'"; 
  }
}

function acf_img_alt($image){
  if(isset($image['alt']) && !empty(isset($image['alt']))) {
    echo "alt=\"{$image['alt']}\"";
  }
}

/**
 * Prints an ACF button
 */
function acf_btn($button){
  if(!isset($button['button_text']) || empty($button['button_text'])){ return false; }
    $link = get_acf_button_link($button);
  ?>
  <a 
    href="<?php echo $link; ?>" 
    class="btn btn-primary"
    <?php acf_button_target($button); ?>
  >
    <?php if(isset($button['button_text'])): ?>
      <?php echo $button['button_text']; ?>
    <?php endif; ?>
  </a>
  <?php
}