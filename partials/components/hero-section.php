<?php 
$hero_bg = get_field('hero_bg'); 
$has_bg = isset($hero_bg) && !empty($hero_bg);
?>
<section 
  class="hero-section <?php if($has_bg){ echo "hero-section--has-bg"; } ?>" 
  style="<?php if($has_bg){ echo "background: url(" . $hero_bg['sizes']['1536x1536'] . ") no-repeat center"; } ?> ; background-size: cover;">

  <div class="container">

    <div class="hero-section__content">
      <?php if(get_field('hero_sub_heading')): ?>
        <h2 class="hero-section__sub-heading"><?php echo get_field('hero_sub_heading'); ?></h2>
      <?php endif; ?>
      <?php if(get_field('hero_main_heading')): ?>
        <h1 class="hero-section__main-heading"><?php echo get_field('hero_main_heading'); ?></h1>
      <?php endif; ?>
      <div class="hero-section__sub-heading-wrapper">
        <?php if(get_field('hero_content')): ?>
          <?php echo get_field('hero_content'); ?>
        <?php endif; ?>
      </div>
    </div>
    <?php acf_btn(get_field('hero_button')); ?>

    <?php if(get_field('hero_section_extra_content')): ?>
      <?php echo get_field('hero_section_extra_content'); ?>
    <?php endif; ?>
    <?php // get_template_part('partials/search/widget', 'form'); ?>

  </div>

</section>