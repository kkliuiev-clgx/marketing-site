<?php 
$cards = $module['cards']; 
// dd($cards);
?>

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
      
  <?php if($cards && count($cards)): ?>
    <div class="pricing-cards">
      <?php foreach($cards as $key => $card): ?>
        <div class="pricing-card card">
          
          <header class="pricing-card__header">
            <?php if(isset($card['heading']) && !empty($card['heading'])): ?>
              <h4 class="pricing-card__heading"><?php echo $card['heading']; ?></h4>
            <?php endif; ?>
            <?php if(isset($card['large_heading']) && !empty($card['large_heading'])): ?>
              <p class="pricing-card__large-heading text-3xl text-lg-4xl mb-1"><?php echo $card['large_heading']; ?></p>
            <?php endif; ?>
            <?php if(isset($card['sub_heading']) && !empty($card['sub_heading'])): ?>
              <p class="pricing-card__sub-heading"><?php echo $card['sub_heading']; ?></p>
            <?php endif; ?>
          </header>
          <div class="card-body">

            <?php if($card['features'] && count($card['features'])): ?>
              <div class="pricing-features">
                <?php foreach($card['features'] as $key => $feature): ?>
                  <div class="pricing-feature d-flex justify-content between align-items-center"> 
                    
                    <h4 class="pricing-feature__label" data-toggle="tooltip" title="<?php echo $feature['tooltip']; ?>"><?php echo $feature['label']; ?></h4>
                    
                    <?php if($feature['value_type'] == 'icon'): ?>
                      <i class="fas fa-check-circle text-secondary"></i>
                    <?php elseif($feature['value_type'] == 'text'): ?>
                      <span class="pricing-feature__value"><?php echo $feature['value']; ?></span>
                    <?php endif; ?>
                    
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
          
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if($module['cards_disclaimer']): ?>
    <p class="text-center mt-4 mt-lg-5"><?php echo $module['cards_disclaimer']; ?></p>
  <?php endif; ?>
  
</div>