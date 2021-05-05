<?php
$heading = $module['heading'];
$subHeading = $module['sub_heading'];
$cards = $module['cards'];
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
  <?php if(isset($cards) && !empty($cards)): ?>
    <div class="meenta-img-cards">
      <?php foreach($cards as $key => $card): ?>
        <?php
          $link = get_acf_button_link($card);
          $has_img = isset($card['image']) && !empty($card['image']);
        ?>
        <a 
          href="<?php echo $link; ?>" 
          class="meenta-img-card"
          <?php acf_button_target($card); ?>
        >
          <div class="meenta-img-card__img-wrapper">
            <div 
              class="meenta-img-card__img"
              style="<?php if($has_img){ echo "background: url(" . $card['image']['sizes']['large'] . ") no-repeat center"; } ?> ; background-size: cover;"
            ></div>
          </div>
          <footer class="meenta-img-card__footer d-flex justify-content-between align-items-center py-4">
            <h4 class="text-2xl meenta-img-card__heading">
              <span class="the-text"><?php echo $card['heading']; ?></span>
            </h4>
            <span class="meenta-img-card__button">
              <?php echo $card['button_text']; ?>
              <i class="fas fa-chevron-right d-inline-block ml-2"></i>
            </span>
          </footer>
        </a>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <?php acf_btn($module); ?>
</div>