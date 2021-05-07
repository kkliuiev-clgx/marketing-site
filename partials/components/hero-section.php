<?php 
$heroSectionClasses = [];
$hero_bg = get_field('hero_bg'); 
$featuredImage = get_field('featured_image'); 
$colorScheme = get_field('color_scheme'); 
$colorScheme = isset($colorScheme['color_scheme']) && !empty($colorScheme['color_scheme']) ? $colorScheme['color_scheme'] : false;
$hasBg = isset($hero_bg) && !empty($hero_bg);
$hasFeaturedImage = isset($featuredImage) && !empty($featuredImage);
// dd(get_fields());
if($hasBg){ $heroSectionClasses[] = "hero-section--has-bg"; }
if($colorScheme){ $heroSectionClasses[] = "hero-section--theme-" . $colorScheme; }
if($hasFeaturedImage){ $heroSectionClasses[] = "hero-section--has-featured-img"; }
?>
<section 
  class="hero-section <?php echo implode(' ', $heroSectionClasses); ?>" 
  style="<?php if($hasBg){ echo "background: url(" . $hero_bg['sizes']['1536x1536'] . ") no-repeat center"; } ?> ; background-size: cover;">

  <div class="container <?php if($hasFeaturedImage): ?> d-lg-flex <?php endif; ?>">

    <div class="hero-section__left">
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
    </div>
    <?php if($hasFeaturedImage): ?>
      <div class="hero-section__right mt-5 mt-lg-0 pl-lg-5">
        <img class="img-fluid" src="<?php echo $featuredImage['sizes']['1536x1536']; ?>" alt="featured image for the page">
      </div>
    <?php endif; ?>
    
    <?php // get_template_part('partials/search/widget', 'form'); ?>

  </div>

</section>