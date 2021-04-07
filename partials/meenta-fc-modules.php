<?php 
$modules = get_field('meenta_fc_modules');
// dd($modules); 
?>


<?php foreach($modules as $key => $module): ?>
  <?php
  $layoutType = $module['acf_fc_layout'];
  $sections = $module['sections'];
  ?>
  
  <section class="meenta-fc-module module module--<?php echo $layoutType; ?>">

    <?php foreach($sections as $innerKey => $section): ?>
      <article class="module-section">
        <div class="container">
          <div class="module-section__img-wrapper">
          <?php if(isset($section['image']) && isset($section['image']['sizes']) && isset($section['image']['sizes']['medium'])): ?>
            <img class="module-section__img" src="<?php echo $section['image']['sizes']['medium']; ?>" <?php acf_img_alt($section['image']); ?>>
          <?php endif; ?>
          </div>
          <div class="module-section__content">
            <h3 class="module-section__heading"><?php echo $section['heading']; ?></h3>
            <div class="module-section__body">
              <?php echo $section['content']; ?>
              <a href="#collapser-<?php echo $innerKey; ?>" data-toggle="collapse"><?php echo $section['accordion_heading']; ?> <i class="fas fa-chevron-down"></i></a>
              <div id="collapser-<?php echo $innerKey; ?>" class="collapse">
                <div class="py-4"><?php echo $section['accordion_content']; ?></div>
              </div>
            </div>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  
  </section>
<?php endforeach; ?>