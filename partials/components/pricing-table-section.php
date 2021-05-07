<div class="pricing-table-widget">
  <div class="pricing-table-widget__intro mb-5">
    <?php if(get_field('pricing_table_heading', 'option')): ?>
      <h2 class="module-section__heading text-2xl"><?php echo get_field('pricing_table_heading', 'option'); ?></h2>
    <?php endif; ?>
    <?php if(get_field('pricing_table_sub_heading', 'option')): ?>
      <?php echo get_field('pricing_table_sub_heading', 'option'); ?>
    <?php endif; ?>
  </div>

  <div class="pricing-table-widget__table-wrapper">
    <div class="table-responsive">
      <?php 
      $levels = get_field('pricing_levels', 'option'); 
      $options = get_field('options', 'option'); 
      // dd($levels[0]);
      ?>

      <table class="table table-striped">
        <thead>
          <tr>
            <th class="empty">&nbsp;</th>
            <?php foreach($levels as $levelKey => $level): ?>
              <th><?php echo $level['heading']; ?></th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach($options as $optionKey => $option): ?>
            <tr>
              <td><?php echo $option['label']; ?></td>
              <?php foreach($levels as $levelKey => $level): ?>
                <?php
                $contentKey = 'option_' . ($optionKey + 1) . '_content';
                $valueKey = 'option_' . ($optionKey + 1) . '_value';
                ?>
                <td data-content="<?php echo $contentKey; ?>">
                  <?php if(array_key_exists($contentKey, $level)){ ?>
                    <?php echo $level[$contentKey]; ?>
                  <?php } else if(array_key_exists($valueKey, $level)){ ?>
                      <?php if($level[$valueKey]) { ?>
                        <i class="fas fa-check-circle"></i>
                      <?php } else { ?>
                        <i class="far fa-circle"></i>
                      <?php } ?>
                  <?php } ?>
                </td>

              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="pricing-table-widget__table-wrapper">
    <div class="table-responsive">
      <?php echo get_field('pricing_table_html', 'option'); ?>
    </div>
  </div>
</div>