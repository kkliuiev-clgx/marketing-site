<?php 
$blurbs = $module['blurbs']; 
?>

<?php if($blurbs && count($blurbs)): ?>
  <div class="container">

    <?php if($module['heading'] || $module['sub_heading']): ?>
      <div class="module-section__intro">
          <?php if($module['heading']): ?>
            <h3 class="module-section__heading"><?php echo $module['heading']; ?></h3>
          <?php endif; ?>
          <?php if($module['sub_heading']): ?>
            <div class="module-section__content">
              <p class=""><?php echo $module['sub_heading']; ?></p>
            </div>
          <?php endif; ?>
      </div>
    <?php endif; ?>
    
    <div class="line-blurbs">
      <?php foreach($blurbs as $key => $blurb): ?>
        <div class="line-blurb">
          <?php if(isset($blurb['image']) && isset($blurb['image']['sizes']) && isset($blurb['image']['sizes']['medium'])): ?>
            <div class="line-blurb__img-wrapper">
              <img class="line-blurb__img" src="<?php echo $blurb['image']['sizes']['medium']; ?>" <?php acf_img_alt($blurb['blurb_image']); ?>>
            </div>
          <?php endif; ?>
          <h4 class="line-blurb__title"><?php echo $blurb['heading']; ?></h4>
          <p><?php echo $blurb['sub_heading']; ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>