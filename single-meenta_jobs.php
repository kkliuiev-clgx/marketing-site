<?php
/**
 * Single Post Page Template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_classes = array();

if ( 'full' == lorada_get_opt( 'site_layout' ) && 'custom' == lorada_get_opt( 'single_post_width' ) ) {
	$post_classes[] = 'container';
} else {
	$post_classes[] = 'container-fluid';
}

$post_view_style = lorada_get_opt( 'post_view_style' );
$post_view_style = ( ! empty( $post_view_style ) ) ? $post_view_style : 'default';

$post_classes[] = 'post-' . $post_view_style;
$post_classes = implode( ' ', $post_classes );
$content_class = lorada_get_content_class();

get_header();

lorada_post_backstretch_bg( $post_view_style );

$my_tags = get_the_terms(get_the_ID(), 'job_tag');
$theTags = '';
if ( $my_tags ) {
    foreach ( $my_tags as $tag ) {
        $tag_names[] = $tag->name;
    }
    $theTags = implode( ', ', $tag_names );
}
?>

<div class="single-post-content">
	<div class="<?php echo esc_attr( $post_classes ); ?> main-content-wrapper">
		<?php if ( 'backstretch' == $post_view_style ) : ?>
			<div class="post-backstretch-header">
				<div class="post-header-inner">
					<?php lorada_post_header(); ?>
				</div>
			</div>
		<?php endif; ?>

		<div id="post-content" class="row main-content justify-content-between">
			<div class="post-inner-content <?php echo esc_attr( $content_class ); ?>">
				<?php
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							if ( 'default' == $post_view_style ) {
								lorada_get_template_part( 'post/single', 'post-default' );
							} elseif ( 'backstretch' == $post_view_style ) {
								lorada_get_template_part( 'post/single', 'post-backstretch' );
							}
						endwhile;
					endif;
				?>
			</div>
			
			<aside class="sidebar-container col-lg-3 sidebar-right area-" role="complementary"> 

        <p><strong>Posted:</strong> <?php the_date(); ?></p>
        <p><strong>Status:</strong> <?php echo get_field('status'); ?></p>
        <p><strong>Location:</strong> <?php echo get_field('location'); ?></p>
        <p><strong>Tags:</strong> <?php echo $theTags; ?></p>
        <p class="mt-3"><strong>How to apply:</strong></p>
        <?php echo get_field('how_to_apply'); ?>
       
      </aside>
		</div>
	</div>
</div>

<?php 
get_footer();