<?php
global $moduleKey;
$heading = $module['heading'];
$subHeading = $module['sub_heading'];
$tabs = $module['tabs'];
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
  <?php if($tabs && !empty($tabs)): ?>

    <ul class="nav nav-tabs" id="fc-module-tabs-<?php echo $moduleKey; ?>" role="tablist">
      <?php foreach($tabs as $key => $tab): ?>
        <li class="nav-item">
          <a 
            class="nav-link <?php if($key == 0){ echo "active"; } ?>"
            id="<?php echo "fc-module-" . $moduleKey . "-tab-toggle-{$key}"; ?>"
            data-toggle="tab" 
            href="#<?php echo "fc-module-" . $moduleKey . "-tab-content-id-{$key}"; ?>" 
            role="tab" 
            aria-controls="<?php echo "fc-module-" . $moduleKey . "-tab-content-id-{$key}"; ?>" 
            aria-selected="true">
              <?php echo $tab['tab_heading']; ?>
          </a>
        </li>
      <?php endforeach; ?>
      <!-- <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
      </li> -->
    </ul>
    <div class="tab-content" id="fc-module-tabs-<?php echo $moduleKey; ?>-content">
      <?php foreach($tabs as $key => $tab): ?>
        <div 
          class="tab-pane fade <?php if($key == 0){ echo "show active"; } ?>"
          id="<?php echo "fc-module-" . $moduleKey . "-tab-content-id-{$key}"; ?>" 
          role="tabpanel" 
          aria-labelledby="<?php echo "fc-module-" . $moduleKey . "-tab-toggle-{$key}";?>"
        >
            <div class="tab-pane__inner">
              
              <div class="d-md-flex tab-pane__columns">
                <?php foreach($tab['columns'] as $key => $column): ?>
                  <div class="tab-pane__column module-section py-0">
                    <?php echo $column['content']; ?>
                  </div>
                <?php endforeach; ?>
              </div>

              <div class="text-center mt-5">
                <?php acf_btn($tab); ?>
              </div>
              
            </div>
        </div>
      <?php endforeach; ?>
      <!-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> -->
    </div>
    

  <?php endif; ?>
</div>