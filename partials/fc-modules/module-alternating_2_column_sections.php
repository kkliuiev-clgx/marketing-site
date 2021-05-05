<?php 
$sections = $module['sections']; 
?>
<?php foreach($sections as $innerKey => $section): ?>
  <article class="module-section <?php if($innerKey % 2 == 0){ echo 'odd'; } else { echo 'even'; } ?>">
    <div class="container">
      <div class="module-section__img-wrapper">
      <?php if(isset($section['image']) && isset($section['image']['sizes']) && isset($section['image']['sizes']['large'])): ?>
        <img class="module-section__img" src="<?php echo $section['image']['sizes']['large']; ?>" <?php acf_img_alt($section['image']); ?>>
      <?php endif; ?>
      </div>
      <div class="module-section__content">
        <h3 class="module-section__heading"><?php echo $section['heading']; ?></h3>
        <?php if($section['sub_heading']): ?>
          <p class="lead"><?php echo $section['sub_heading']; ?></p>
        <?php endif; ?>
        <div class="module-section__body">
          <?php echo $section['content']; ?>
        </div>
      </div>
    </div>
  </article>
<?php endforeach; ?>