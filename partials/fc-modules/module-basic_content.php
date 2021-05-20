<?php
$heading = $module['heading'];
$subHeading = $module['sub_heading'];
$content = $module['content'];
$columns = $module['columns'];
?>

<div class="container">
  <div class="module__intro <?php if(empty($content)){ echo 'mb-0'; } ?>">
    <?php if($heading): ?>
      <h3 class="section__title text-lg-3xl <?php if(empty($content) && empty($subHeading)){ echo 'mb-0'; } ?>"><?php echo $heading; ?></h3>
    <?php endif; ?>
    <?php if($subHeading): ?>
      <p class="lead <?php if(empty($content)){ echo 'mb-0'; } ?>"><?php echo $subHeading; ?></p>
    <?php endif; ?>
  </div>
  <?php if($columns && !empty($columns)): ?>

    <div class="d-md-flex module__columns">
      <?php foreach($columns as $key => $column): ?>
        <div class="module__column module-section py-0">
          <?php echo $column['content']; ?>
        </div>
      <?php endforeach; ?>
    </div>
    
  <?php elseif($content): ?>
    <?php echo $content; ?>
  <?php endif; ?>
  <?php acf_btn($module); ?>
</div>