<?php
/**
 * The archive page for the `meenta_jobs` CPT
 * -- Copied from the main theme's page.php
 */

/**
 * Main Blog Post Page Template
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( lorada_is_ajax() ) { 
	do_action( 'lorada_main_loop' );
	die();
}

get_header();

lorada_page_heading();

?>
<section class="hero-section hero-section--theme-light">
  <div class="container">
    <div class="hero-section__content">
      <h1 class="hero-section__main-heading">News & PR</h1>
    </div>
  </div>
</section>
<div class="main-content">
	<div class="container">
		<div class="site-content content-section" role="main"> 

    <!-- Start the Loop. -->
    <?php if ( have_posts() ) : ?> 
    
     <div class="pr-cards">

        <?php while ( have_posts() ) : the_post(); ?>

          <article id="post-<?php the_ID(); ?>" class="blog-post-item post-<?php the_ID(); ?> meenta_pr type-meenta_pr status-publish has-post-thumbnail hentry">
            <div class="blog-post-inner">
              <div class="post-head-part">
                <a href="<?php echo get_field('link'); ?>" class="post-featured-part">
                <?php echo get_the_post_thumbnail(get_the_ID(), 'large'); ?>
              </div>
              <div class="post-bottom-part">
                <h3 class="post-title">
                    <a href="<?php echo get_field('link'); ?>"><?php the_title(); ?></a>
                </h3>
                <div class="post-info-part">
                    <span class="post-date"><?php the_date(); ?></span>
                </div>
                <div class="post-summary">
                    <p class="summary-content"><?php the_excerpt(); ?></p>
                </div>
                <a href="<?php echo get_field('link'); ?>" class="post-continue">Read More</a>
              </div>
          </div>
        </article>

        <?php endwhile; ?>
        
        
      </div>
      <nav class="lorada-pagination">
        <?php
          echo paginate_links( array(
              'type'		=> 'list',
              'prev_text'	=> esc_html__( 'Prev', 'lorada' ),
              'next_text'	=> esc_html__( 'Next', 'lorada' ),
            ) );
        ?>
      </nav>

      
      <?php else : ?>


        <!-- The very first "if" tested to see if there were any Posts to -->
        <!-- display.  This "else" part tells what do if there weren't any. -->
        <p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>


      <!-- REALLY stop The Loop. -->
      <?php endif; ?>
      
      


		</div>

		<?php 

		get_sidebar();

		?>
	</div>
</div>

<?php
get_footer();