<?php
$heading = $module['heading'];
$subHeading = $module['sub_heading'];
$testimonials = $module['testimonials'];
?>

<div class="container">

  <div class="module__intro">
    <?php if($heading): ?>
      <h3 class="section__title text-lg-3xl"><?php echo $heading; ?></h3>
    <?php endif; ?>
    <?php if($subHeading): ?>
      <p class="lead"><?php echo $subHeading; ?></p>
    <?php endif; ?>
  </div>
  <div class="testimonials-slider">
    <?php foreach($testimonials as $key => $testimonial): ?>
      <div class="testimonial-card">
        <?php if(isset($testimonial['image']) && isset($testimonial['image']['sizes']) && isset($testimonial['image']['sizes']['large'])): ?>
          <div class="testimonial-card__image" style="background: url(<?php echo $testimonial['image']['sizes']['large']; ?>) no-repeat center; background-size: cover;"></div>
        <?php endif; ?>
        <div class="testimonial-card__content">
          <div class="testimonial-card__body">“<?php echo $testimonial['body']; ?>”</div>
          <p class="testimonial-card__author"><?php echo $testimonial['author']; ?></p>
          <p class="testimonial-card__title"><?php echo $testimonial['title']; ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

</div>