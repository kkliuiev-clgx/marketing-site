<?php 
// dd($module);
?>
  <div class="container-fluid">
    <?php get_template_part('partials/components/pricing-table', 'section'); ?>
    <?php if($module['outro_heading'] || $module['outro_content']): ?>
      <div class="module-section__outro">
          <?php if($module['outro_heading']): ?>
            <h3 class="module-section__heading"><?php echo $module['outro_heading']; ?></h3>
          <?php endif; ?>
          <?php if($module['outro_content']): ?>
            <div class="module-section__content">
              <p><?php echo $module['outro_content']; ?></p>
            </div>
          <?php endif; ?>
      </div>
    <?php endif; ?>
    <?php if(isset($module['outro_button_button_text']) && !empty($module['outro_button_button_text'])){ ?>
      <div class="d-flex justify-content-center mt-5">
        <?php acf_btn($module, 'outro_button'); ?>
      </div>
    <?php } ?>
  </div>