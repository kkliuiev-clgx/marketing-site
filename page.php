<?php get_header(); ?>

<main id="content" class="page-template">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();  ?>

<?php //dd(get_fields()); ?>
<?php get_template_part('partials/components/hero', 'section'); ?>
<?php get_template_part('partials/meenta-fc', 'modules'); ?>

  
<?php endwhile; endif; ?>



</main>
<?php //end content ?>

<?php get_footer(); ?>