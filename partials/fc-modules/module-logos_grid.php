<?php
$heading = $module['heading'];
$logos = get_field('logos', 'option');
$intro_paragraph = $module['intro_paragraph'];
?>

<div class="container">

  <div class="section__intro">
    <h2 class="section__title"><?php echo $heading; ?></h2>
    <?php echo $intro_paragraph; ?>
  </div>

  <?php if(isset($logos) && is_array($logos) && !empty($logos)): ?>
    <div class="logos-grid">
      <?php foreach($logos as $key => $logo): ?>
        <?php if(isset($logo['image']) && isset($logo['image']['sizes']) && isset($logo['image']['sizes']['medium'])): ?>
          <div class="tab-blurb__img-wrapper">
            <img class="tab-blurb__img" src="<?php echo $logo['image']['sizes']['medium']; ?>" <?php acf_img_alt($logo['image']); ?>>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  
  
</div>