<?php 
$faq_group_terms = $module['faq_groups']; 
?>
<div class="container">
  <?php foreach ( $faq_group_terms as $faq_group_term ) { ?>
    <?php 
      $faq_group_query = new WP_Query( array(
          'post_type' => 'meenta_faqs',
          'order' => 'ASC',
          'order_by' => 'menu_order',
          'posts_per_page' => -1,
          'tax_query' => array(
              array(
                  'taxonomy' => 'faq_group',
                  'field' => 'slug',
                  'terms' => array( $faq_group_term->slug ),
                  'operator' => 'IN'
              )
          )
      ));
    ?>

    <div class="faq-row-group">
      
      <div class="module__intro">
        <h2 class="section__title mb-5"><?php echo $faq_group_term->name; ?> Questions</h2>
      </div>

      <?php if ( $faq_group_query->have_posts() ) : while ( $faq_group_query->have_posts() ) : $faq_group_query->the_post(); ?>
        <div class="faq-row">
          <h3 class="faq-row__toggle">
            <a 
              class="faq-row__link" 
              data-toggle="collapse" 
              href="#faq-collapse-post-<?php the_ID(); ?>" 
              role="button" 
              aria-expanded="false" 
              aria-controls="faq-collapse-post-<?php the_ID(); ?>">
              <?php echo the_title(); ?>
            </a>
          </h3>
          <div class="faq-row__body collapse" id="faq-collapse-post-<?php the_ID(); ?>">
            <div class="card card-body">
              <?php the_content(); ?>
            </div>
          </div>
        </div>
      <?php endwhile; endif; ?>
      <?php
        // Reset things, for good measure
        $faq_group_query = null;
        wp_reset_postdata();
      ?>
    </div>


  <?php } ?>

</div>