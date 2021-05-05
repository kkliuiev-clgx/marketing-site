<?php
/**
 * The archive page for the `meenta_jobs` CPT
 * -- Copied from the main theme's page.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$page_classes = array();

if ( 'full' == lorada_get_opt( 'site_layout' ) && 'custom' == lorada_get_opt( 'page_width' ) ) {
	$page_classes[] = 'container';
} else {
	$page_classes[] = 'container-fluid';
}

$page_classes = implode( ' ', $page_classes );
$content_class = lorada_get_content_class();

get_header();

lorada_page_heading();
?>

<div class="container content-section">

  <div class="module__intro text-center mb-3 mb-lg-5">
    <h1 class="section__title">Jobs at Meenta</h1>
  </div>

  <div class="intro-cards">
    <!-- Loop Setting -->
			<?php while ( have_posts() ) : the_post(); ?>
        <?php
          $my_tags = get_the_terms(get_the_ID(), 'job_tag');
          $theTags = '';
          $tagNames = [];
          if ( $my_tags ) {
              foreach ( $my_tags as $tag ) {
                  $tagNames[] = $tag->name;
              }
              $theTags = implode( ', ', $tagNames );
          }
        ?>
        <a href="<?php the_permalink(); ?>" class="intro-card card">
          <h2 class="intro-card__title card-title"><?php the_title(); ?></h2>
          <?php the_excerpt(); ?>
          <div class="card-footer d-flex justify-content-between align-items-center"><i class="fas fa-tag mr-1 text-primary"></i><?php echo $theTags; ?> <strong class="d-inline-block mr-1 ml-auto">Type: </strong><span class="text-nowrap"><?php echo get_field('work_type'); ?></span></div>
        </a>
        <?php $theTags = ''; ?>
			<?php endwhile; ?>
			<!-- Resetting the page Loop -->
  </div>
  
</div>

<?php
get_footer();
