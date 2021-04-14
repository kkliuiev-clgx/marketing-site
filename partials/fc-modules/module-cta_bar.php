<?php
$heading = $module['heading'];
$content = $module['content'];
?>

<div class="container">
  <?php if($heading): ?>
    <h3 class="section__title"><?php echo $heading; ?></h3>
  <?php endif; ?>
  <?php if($content): ?>
    <?php echo $content; ?>
  <?php endif; ?>
  <?php acf_btn($module); ?>
</div>