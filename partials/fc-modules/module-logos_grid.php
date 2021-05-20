<?php
$heading = $module['heading'];
$logos = get_field('logos', 'option');
$intro_paragraph = $module['intro_paragraph'];
$logos = $module['logos'];
?>

<div class="container">

  <div class="section__intro">
    <h2 class="section__title"><?php echo $heading; ?></h2>
    <?php echo $intro_paragraph; ?>
  </div>

  <?php if(isset($logos) && is_array($logos) && !empty($logos)): ?>
    <div class="logos-grid">
      <?php foreach($logos as $key => $logo): ?>
        <?php 
          $isLink = $logo['link'] && $logo['link'] !== 'empty'; 
          $newTab = false;
          if($isLink){
            $newTab = $logo['new_tab'];
          }
        ?>
        <?php if(isset($logo['image']) && isset($logo['image']['sizes']) && isset($logo['image']['sizes']['medium'])): ?>
          <?php if($isLink): ?>
            <a href="<?php echo $logo['url']; ?>" class="logos-grid__img-wrapper" <?php if($newTab): ?>target="_blank"<?php endif; ?>>
          <?php else: ?>
            <div class="logos-grid__img-wrapper">
          <?php endif; ?>
            <img class="logos-grid__img" src="<?php echo $logo['image']['sizes']['medium']; ?>" <?php acf_img_alt($logo['image']); ?>>
          <?php if($isLink): ?>
            </a>
          <?php else: ?>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  
  
</div>