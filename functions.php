<?php
/* Lorada Child Theme Functions */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( get_stylesheet_directory() . '/templates/header/element-functions.php' );

function lorada_child_theme() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/dist/css/style.css', array( 'parent-style', 'lorada-theme-style' ), wp_get_theme()->get('Version') );
}

add_action( 'wp_enqueue_scripts', 'lorada_child_theme' );

function meenta_remove_scripts() {
  // eliminate the parent theme's bootstrap, we will import it into our child theme stylesheet. This will allow us to use all of bootstrap's functions and customize its variables
  wp_dequeue_style( 'bootstrap-style' );
  wp_deregister_style( 'bootstrap-style' );
  wp_enqueue_script( 'algoliasearch', get_stylesheet_directory_uri() . '/assets/vendor/algoliasearch.min.js', false, false );
  wp_enqueue_script( 'algoliasearch-helper', get_stylesheet_directory_uri() . '/assets/vendor/algoliasearch.helper.min.js', false, false );
  wp_enqueue_script( 'algoliasearch-script', get_stylesheet_directory_uri() . '/assets/js/search/index.js', false, false );
  wp_enqueue_script( 'site-global-scripts', get_stylesheet_directory_uri() . '/assets/js/site.js', false, false );

  // Now register your styles and scripts here
}
add_action( 'wp_enqueue_scripts', 'meenta_remove_scripts', 20 );



function meentaCleanString($string) {
  $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

/**
 * USED TO DEBUG THE DEPENDENCY QUEUE.... This is used to see which scripts and styles have been loaded on a page
 */
function crunchify_print_scripts_styles() {

  $result = [];
  $result['scripts'] = [];
  $result['styles'] = [];

  // Print all loaded Scripts
  global $wp_scripts;
  foreach( $wp_scripts->queue as $script ) :
     $result['scripts'][] =  $wp_scripts->registered[$script]->src . ";";
  endforeach;

  // Print all loaded Styles (CSS)
  global $wp_styles;
  foreach( $wp_styles->queue as $style ) :
     $result['styles'][] =  $wp_styles->registered[$style]->src . ";";
  endforeach;

  return $result;
}
add_action( 'wp_enqueue_scripts', 'crunchify_print_scripts_styles');


function dd($arr){
  echo "<pre>";
  die(print_r($arr));
  echo "</pre>";
}

/**
 * Add GTM to <head>
 */
function meenta_hook_google_tag_manager() {
  get_template_part('partials/tagmanager');
}
add_action('wp_head', 'meenta_hook_google_tag_manager');

/**
 * Add GTM noscript to opening body
 */
add_action( 'wp_body_open', 'meenta_add_gtag_noscript_into_opening_body_tag' );
function meenta_add_gtag_noscript_into_opening_body_tag() {
    echo '<!-- Google Tag Manager (noscript) --><noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5B6SCNB"height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript><!-- End Google Tag Manager (noscript) -->';
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
    $unit_label = get_field('unit_label', $product->get_id());
  } else {
    return false;
  }
  
  ?>


  <?php if($product->is_in_stock() && !$product->is_on_backorder()): ?>
    <small class="meenta-price__unit-label <?php echo $classes; ?>">
      <?php if($unit_label){ ?>
        per 
        <?php echo $unit_label; ?>
      <?php } ?>
    </small>
  <?php else: ?>
    <?php // var_dump($product->stock_status); ?>
  <?php endif; ?>
  
  <?php 
}

/**
 * Add Badge displaying the product's brand
 */
function meenta_template_brand_badge(){
  global $product;
  // die(print_r($product->get_attributes()));
  $brands = wp_get_post_terms( $product->get_id(), 'pa_brand', 'all' );
  if(!is_array($brands)) return false;
  ?>
  <div class="meenta-brand-badge badge badge-dark mb-3 p-2">
    <?php echo $brands[0]->name; ?>
  </div>
  <?php 
}

add_action( 'woocommerce_single_product_summary', 'meenta_template_brand_badge', 4 );

/**
 * Add call to action for backordered products
 * the 21 indicates that this should be shown immediately after the product's description
 */
function meenta_back_ordered_cta(){
  global $product;
  if($product->is_on_backorder() || !$product->is_in_stock()) {
    echo "<div class='meenta-product-back-order-cta'>";
    echo do_shortcode("[lorada_html_block block_id='2217']");
    echo "</div>";
  }
}

add_action( 'woocommerce_single_product_summary', 'meenta_back_ordered_cta', 21 );


function add_meenta_price_unit_label(){
  global $product;
  meenta_price_unit_label($product);
}


add_action( 'woocommerce_after_shop_loop_item_title', 'add_meenta_price_unit_label', 12 );


if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Child Theme Settings',
		'menu_title'	=> 'Child Theme Settings',
		'menu_slug' 	=> 'child-theme-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

  acf_add_options_sub_page(array(
		'page_title' 	=> 'Pricing Table',
		'menu_title'	=> 'Pricing Table',
		'parent_slug'	=> 'child-theme-settings',
	));

}

add_filter( 'woocommerce_product_tabs', 'meenta_product_additional_tabs' );

/**
 * ADD EXTRA TABS TO SINGLE PRODUCT PAGE
 */
if ( ! function_exists( 'meenta_product_additional_tabs' ) ) {
	function meenta_product_additional_tabs( $tabs ) {    
    global $product;
		if ( ! empty( get_field('test_details', $product->get_id()) ) ) {
      $title = 'Test Details';
			$tabs['meenta_payment_details_tab'] = array(
				'title'		=>	$title,
				'priority'	=> 12,
				'callback'	=>	'meenta_test_details_tab_content'
			);
		}
    if ( ! empty( get_field('collection_details', $product->get_id()) ) ) {
      $title = 'Collection Details';
			$tabs['meenta_collection_details_tab'] = array(
				'title'		=>	$title,
				'priority'	=> 13,
				'callback'	=>	'meenta_collection_details_tab_content'
			);
		}
    if ( ! empty( get_field('payment_methods', $product->get_id()) ) ) {
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
    $content = get_field('test_details', $product->get_id());
		if ( ! empty( $content ) ){
			echo $content;
		}
	}
}

if ( ! function_exists( 'meenta_collection_details_tab_content' ) ) {
	function meenta_collection_details_tab_content() {
		global $product;
    $content = get_field('collection_details', $product->get_id());
		if ( ! empty( $content ) ){
			echo $content;
		}
	}
}

if ( ! function_exists( 'meenta_payment_methods_tab_content' ) ) {
	function meenta_payment_methods_tab_content() {
		global $product;
    $content = get_field('payment_methods', $product->get_id());
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
function acf_button_target($button, $prefix = ''){
  $prefixName = '';
  if($prefix){
    $prefixName = $prefix . '_';
  }
  if($button[$prefixName . 'button_target'] == 'new_tab'){ 
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
function acf_btn($button, $prefix = ''){
  $prefixName = '';
  if($prefix){
    $prefixName = $prefix . '_';
  }
  if(!isset($button[$prefixName . 'button_text']) || empty($button[$prefixName . 'button_text'])){ return false; }
    $chatTrigger = isset($button[$prefixName . 'chat_trigger']) && $button[$prefixName . 'chat_trigger'] === true;
    $modalTrigger = isset($button[$prefixName . 'modal_trigger']) && $button[$prefixName . 'modal_trigger'] === true;
    $link = get_acf_button_link($button);

    if(strpos($link, '#') == 0){
      
    }
    
  ?>
  <a 
    href="<?php echo $link; ?>" 
    class="btn btn-primary"
    <?php if($chatTrigger): echo 'onclick="window.fcWidget.open();window.fcWidget.show();"'; ?>
    <?php elseif($modalTrigger): echo 'data-toggle="modal"'; ?>
    <?php endif; ?>
    <?php acf_button_target($button); ?>
  >
    <?php if(isset($button[$prefixName . 'button_text'])): ?>
      <?php echo $button[$prefixName . 'button_text']; ?>
    <?php endif; ?>
  </a>
  <?php
}

add_shortcode( 'search-instruments', 'meenta_instruments_search' );
function meenta_instruments_search( $atts ) {
  echo "<div class='search-widget-wrapper'>";
  get_template_part('partials/search/widget', 'form');
  echo "</div>";
}


/**
 * Register a FAQ.
 */
function meenta_faq_cpt_init() {
  $args = array(
      'public' => true,
      'label'  => __( 'FAQs', 'textdomain' ),
      'supports' => ['page-attributes']
  );
  register_post_type( 'meenta_faqs', $args );
}
add_action( 'init', 'meenta_faq_cpt_init' );

/**
 * Register a 'group' taxonomy for post type 'meenta_faqs'.
 *
 * @see register_post_type for registering post types.
 */
function meenta_faq_type_register_tax() {
  register_taxonomy( 'faq_group', 'meenta_faqs', array(
      'label'        => __( 'Group', 'textdomain' ),
      'rewrite'      => array( 'slug' => 'group' ),
      'hierarchical' => true,
  ) );
}
add_action( 'init', 'meenta_faq_type_register_tax', 0 );

/**
 * Register a Job CPT.
 */
function meenta_job_cpt_init() {
  $args = array(
      'public' => true,
      'label'  => __( 'Jobs', 'textdomain' ),
      'has_archive' => true,
      'supports' => ['title', 'excerpt', 'editor', 'page-attributes'],
      'rewrite' => array('slug' => 'jobs','with_front' => false),
  );
  register_post_type( 'meenta_jobs', $args );
}
add_action( 'init', 'meenta_job_cpt_init' );

/**
 * Register a 'group' taxonomy for post type 'meenta_faqs'.
 *
 * @see register_post_type for registering post types.
 */
function meenta_job_tag_register_tax() {
  register_taxonomy( 'job_tag', 'meenta_jobs', array(
      'label'        => __( 'Tag', 'textdomain' ),
      'rewrite'      => array( 'slug' => 'tag' ),
      'hierarchical' => false,
  ) );
}
add_action( 'init', 'meenta_job_tag_register_tax', 0 );

/**
 * Register a PR Custom Post Type.
 */
function meenta_pr_cpt_init() {
  $args = array(
      'public' => true,
      'label'  => __( 'PR', 'textdomain' ),
      'has_archive' => true,
      'supports' => ['title', 'excerpt', 'editor', 'thumbnail', 'page-attributes'],
      'rewrite' => array('slug' => 'pr','with_front' => false),
  );
  register_post_type( 'meenta_pr', $args );
}
add_action( 'init', 'meenta_pr_cpt_init' );

/**
 * Display Product Flash
 * This is here so that we can change the small red badges that appear on top of the product cards in the shop from 'Hot' to 'New' and re-style it
 */
if ( ! function_exists( 'lorada_product_flash' ) ) {
	function lorada_product_flash() {
		global $product;

		$flash_output = array();

		if ( $product->is_on_sale() ) {
			$percentage = '';

			if ( 'variable' == $product->get_type() ) {

				$maximum_percentage = 0;
				$variations = $product->get_variation_prices();

				foreach( $variations['regular_price'] as $key => $regular_price ) {
					$sale_price = $variations['sale_price'][$key];

					if ( $sale_price < $regular_price ) {
						$percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );

						if ( $percentage > $maximum_percentage ) {
							$maximum_percentage = $percentage;
						}
					}
				}

				$percentage = $maximum_percentage;

			} elseif ( 'simple' == $product->get_type() || 'external' == $product->get_type() ) {
				$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
			}

			if ( $percentage && lorada_get_opt('sale_label_view') ) {
				$flash_output[] = '<span class="onsale product-flash">-' . $percentage . '%</span>';
			} else {
				$flash_output[] = '<span class="onsale product-flash">' . esc_html__( 'Sale!', 'lorada' ) . '</span>';
			}
		}

		if ( ! $product->is_in_stock() ) {
			$flash_output[] = '<span class="out-stock product-flash">' . esc_html__( 'Sold Out', 'lorada' ) . '</span>';
		}

    if ( $product->is_on_backorder() ) {
			$flash_output[] = '<span class="out-stock product-flash">' . esc_html__( 'Back-Ordered', 'lorada' ) . '</span>';
		}

		if ( $product->is_featured() && lorada_get_opt( 'hot_label' ) ) {
			$flash_output[] = '<span class="featured product-flash">' . esc_html__( 'Featured', 'lorada' ) . '</span>';
		}

		if ( $flash_output ) {
			echo '<div class="product-flashs">' . implode( '', $flash_output ) . '</div>';
		}
	}
}


/**
 * Product categories widget class.
 *
 * THIS IS A MODIFIED VERSION OF WC_Widget_Product_Categories 
 * -- This is almost identical, but it changed the widget_cssclass so that the javascript would no longer expand or collapse the list of categories - per pre-launch fixes list
 */
class Meenta_WC_Widget_Product_Categories extends WC_Widget {

	/**
	 * Category ancestors.
	 *
	 * @var array
	 */
	public $cat_ancestors;

	/**
	 * Current Category.
	 *
	 * @var bool
	 */
	public $current_cat;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce meenta_widget_product_categories';
		$this->widget_description = __( 'A list or dropdown of product categories.', 'woocommerce' );
		$this->widget_id          = 'meenta_woocommerce_product_categories';
		$this->widget_name        = __( 'Meenta Product Categories', 'woocommerce' );
		$this->settings           = array(
			'title'              => array(
				'type'  => 'text',
				'std'   => __( 'Product categories', 'woocommerce' ),
				'label' => __( 'Title', 'woocommerce' ),
			),
			'orderby'            => array(
				'type'    => 'select',
				'std'     => 'name',
				'label'   => __( 'Order by', 'woocommerce' ),
				'options' => array(
					'order' => __( 'Category order', 'woocommerce' ),
					'name'  => __( 'Name', 'woocommerce' ),
				),
			),
			'dropdown'           => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show as dropdown', 'woocommerce' ),
			),
			'count'              => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show product counts', 'woocommerce' ),
			),
			'hierarchical'       => array(
				'type'  => 'checkbox',
				'std'   => 1,
				'label' => __( 'Show hierarchy', 'woocommerce' ),
			),
			'show_children_only' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Only show children of the current category', 'woocommerce' ),
			),
			'hide_empty'         => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Hide empty categories', 'woocommerce' ),
			),
			'max_depth'          => array(
				'type'  => 'text',
				'std'   => '',
				'label' => __( 'Maximum depth', 'woocommerce' ),
			),
		);

		parent::__construct();
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 * @param array $args     Widget arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		global $wp_query, $post;

		$count              = isset( $instance['count'] ) ? $instance['count'] : $this->settings['count']['std'];
		$hierarchical       = isset( $instance['hierarchical'] ) ? $instance['hierarchical'] : $this->settings['hierarchical']['std'];
		$show_children_only = isset( $instance['show_children_only'] ) ? $instance['show_children_only'] : $this->settings['show_children_only']['std'];
		$dropdown           = isset( $instance['dropdown'] ) ? $instance['dropdown'] : $this->settings['dropdown']['std'];
		$orderby            = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];
		$hide_empty         = isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->settings['hide_empty']['std'];
		$dropdown_args      = array(
			'hide_empty' => $hide_empty,
		);
		$list_args          = array(
			'show_count'   => $count,
			'hierarchical' => $hierarchical,
			'taxonomy'     => 'product_cat',
			'hide_empty'   => $hide_empty,
		);
		$max_depth          = absint( isset( $instance['max_depth'] ) ? $instance['max_depth'] : $this->settings['max_depth']['std'] );

		$list_args['menu_order'] = false;
		$dropdown_args['depth']  = $max_depth;
		$list_args['depth']      = $max_depth;

		if ( 'order' === $orderby ) {
			$list_args['orderby']      = 'meta_value_num';
			$dropdown_args['orderby']  = 'meta_value_num';
			$list_args['meta_key']     = 'order';
			$dropdown_args['meta_key'] = 'order';
		}

		$this->current_cat   = false;
		$this->cat_ancestors = array();

		if ( is_tax( 'product_cat' ) ) {
			$this->current_cat   = $wp_query->queried_object;
			$this->cat_ancestors = get_ancestors( $this->current_cat->term_id, 'product_cat' );

		} elseif ( is_singular( 'product' ) ) {
			$terms = wc_get_product_terms(
				$post->ID,
				'product_cat',
				apply_filters(
					'woocommerce_product_categories_widget_product_terms_args',
					array(
						'orderby' => 'parent',
						'order'   => 'DESC',
					)
				)
			);

			if ( $terms ) {
				$main_term           = apply_filters( 'woocommerce_product_categories_widget_main_term', $terms[0], $terms );
				$this->current_cat   = $main_term;
				$this->cat_ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
			}
		}

		// Show Siblings and Children Only.
		if ( $show_children_only && $this->current_cat ) {
			if ( $hierarchical ) {
				$include = array_merge(
					$this->cat_ancestors,
					array( $this->current_cat->term_id ),
					get_terms(
						'product_cat',
						array(
							'fields'       => 'ids',
							'parent'       => 0,
							'hierarchical' => true,
							'hide_empty'   => false,
						)
					),
					get_terms(
						'product_cat',
						array(
							'fields'       => 'ids',
							'parent'       => $this->current_cat->term_id,
							'hierarchical' => true,
							'hide_empty'   => false,
						)
					)
				);
				// Gather siblings of ancestors.
				if ( $this->cat_ancestors ) {
					foreach ( $this->cat_ancestors as $ancestor ) {
						$include = array_merge(
							$include,
							get_terms(
								'product_cat',
								array(
									'fields'       => 'ids',
									'parent'       => $ancestor,
									'hierarchical' => false,
									'hide_empty'   => false,
								)
							)
						);
					}
				}
			} else {
				// Direct children.
				$include = get_terms(
					'product_cat',
					array(
						'fields'       => 'ids',
						'parent'       => $this->current_cat->term_id,
						'hierarchical' => true,
						'hide_empty'   => false,
					)
				);
			}

			$list_args['include']     = implode( ',', $include );
			$dropdown_args['include'] = $list_args['include'];

			if ( empty( $include ) ) {
				return;
			}
		} elseif ( $show_children_only ) {
			$dropdown_args['depth']        = 1;
			$dropdown_args['child_of']     = 0;
			$dropdown_args['hierarchical'] = 1;
			$list_args['depth']            = 1;
			$list_args['child_of']         = 0;
			$list_args['hierarchical']     = 1;
		}

		$this->widget_start( $args, $instance );

		if ( $dropdown ) {
			wc_product_dropdown_categories(
				apply_filters(
					'woocommerce_product_categories_widget_dropdown_args',
					wp_parse_args(
						$dropdown_args,
						array(
							'show_count'         => $count,
							'hierarchical'       => $hierarchical,
							'show_uncategorized' => 0,
							'selected'           => $this->current_cat ? $this->current_cat->slug : '',
						)
					)
				)
			);

			wp_enqueue_script( 'selectWoo' );
			wp_enqueue_style( 'select2' );

			wc_enqueue_js(
				"
				jQuery( '.dropdown_product_cat' ).change( function() {
					if ( jQuery(this).val() != '' ) {
						var this_page = '';
						var home_url  = '" . esc_js( home_url( '/' ) ) . "';
						if ( home_url.indexOf( '?' ) > 0 ) {
							this_page = home_url + '&product_cat=' + jQuery(this).val();
						} else {
							this_page = home_url + '?product_cat=' + jQuery(this).val();
						}
						location.href = this_page;
					} else {
						location.href = '" . esc_js( wc_get_page_permalink( 'shop' ) ) . "';
					}
				});

				if ( jQuery().selectWoo ) {
					var wc_product_cat_select = function() {
						jQuery( '.dropdown_product_cat' ).selectWoo( {
							placeholder: '" . esc_js( __( 'Select a category', 'woocommerce' ) ) . "',
							minimumResultsForSearch: 5,
							width: '100%',
							allowClear: true,
							language: {
								noResults: function() {
									return '" . esc_js( _x( 'No matches found', 'enhanced select', 'woocommerce' ) ) . "';
								}
							}
						} );
					};
					wc_product_cat_select();
				}
			"
			);
		} else {
			include_once WC()->plugin_path() . '/includes/walkers/class-wc-product-cat-list-walker.php';

			$list_args['walker']                     = new WC_Product_Cat_List_Walker();
			$list_args['title_li']                   = '';
			$list_args['pad_counts']                 = 1;
			$list_args['show_option_none']           = __( 'No product categories exist.', 'woocommerce' );
			$list_args['current_category']           = ( $this->current_cat ) ? $this->current_cat->term_id : '';
			$list_args['current_category_ancestors'] = $this->cat_ancestors;
			$list_args['max_depth']                  = $max_depth;

			echo '<ul class="product-categories">';

			wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $list_args ) );

			echo '</ul>';
		}

		$this->widget_end( $args );
	}
}

function meenta_wc_register_widgets() {
	register_widget( 'Meenta_WC_Widget_Product_Categories' );
}
add_action( 'widgets_init', 'meenta_wc_register_widgets' );

