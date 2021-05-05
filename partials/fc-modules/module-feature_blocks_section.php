<?php 
$feature_blocks = $module['feature_blocks']; 
// dd($module);
?>
  <div class="container">
    <?php if($module['heading'] || $module['sub_heading']): ?>
      <div class="module__intro">
          <?php if($module['heading']): ?>
            <h4 class="section__title text-lg-3xl"><?php echo $module['heading']; ?></h4>
          <?php endif; ?>
          <?php if($module['sub_heading']): ?>
            <p class="lead"><?php echo $module['sub_heading']; ?></p>
          <?php endif; ?>
      </div>
    <?php endif; ?>
    <?php if($feature_blocks && count($feature_blocks)): ?>
      <div class="feature-blocks">
        <?php foreach($feature_blocks as $key => $feature): ?>
          <div class="feature-block">
            <h4 class="feature-block__heading"><?php echo $feature['heading']; ?></h4>
            <p class="feature-block__content"><?php echo $feature['sub_heading']; ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <?php if(isset($module['button_text']) && !empty($module['button_text'])){ ?>
      <div class="d-flex justify-content-center mt-5">
        <?php acf_btn($module); ?>
      </div>
    <?php } ?>
  </div>