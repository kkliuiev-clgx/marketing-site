<div class="pricing-table-widget">
  <div class="pricing-table-widget__intro mb-5">
    <?php if(get_field('pricing_table_heading', 'option')): ?>
      <h2 class="text-2xl"><?php echo get_field('pricing_table_heading', 'option'); ?></h2>
    <?php endif; ?>
    <?php if(get_field('pricing_table_sub_heading', 'option')): ?>
      <?php echo get_field('pricing_table_sub_heading', 'option'); ?>
    <?php endif; ?>
  </div>

  <div class="pricing-table-widget__table-wrapper">
    <div class="table-responsive">
      <?php echo get_field('pricing_table_html', 'option'); ?>
    </div>
  </div>
</div>