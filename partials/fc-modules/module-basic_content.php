<?php
$heading = $module['heading'];
$subHeading = $module['sub_heading'];
$content = $module['content'];
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
  <?php if($content): ?>
    <?php echo $content; ?>
  <?php endif; ?>
  <?php acf_btn($module); ?>
</div>