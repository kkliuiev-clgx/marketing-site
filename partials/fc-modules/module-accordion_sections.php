<?php 
$sections = $module['sections']; 
?>
<?php foreach($sections as $innerKey => $section): ?>
  <article class="module-section <?php if($innerKey % 2 == 0){ echo 'odd'; } else { echo 'even'; } ?>">
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
        </div>
        <?php if(!empty($section['accordion_content'])){ ?>
          <a class="module-section__link accordion-toggle" href="#collapser-<?php echo $innerKey; ?>" data-toggle="collapse"><?php echo $section['accordion_heading']; ?> <i class="fas fa-chevron-down"></i></a>
        <?php } ?>
        <div id="collapser-<?php echo $innerKey; ?>" class="accordion-body collapse">
          <div class="py-4"><?php echo $section['accordion_content']; ?></div>
        </div>
      </div>
    </div>
  </article>
<?php endforeach; ?>