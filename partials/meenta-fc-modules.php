<?php 
$modules = get_field('meenta_fc_modules');
// dd($modules); 
?>


<?php if(isset($modules) && !empty($modules)): foreach($modules as $key => $module): ?>

  <?php 
    $layoutType = $module['acf_fc_layout']; 
    $moduleName = 'partials/fc-modules/module-' . $layoutType . '.php';
    $modulePath = locate_template( $moduleName, false, false );
    $moduleClasses = ['module--' . $layoutType];
    if(!$modulePath){ $moduleClasses[] = 'module--not-found'; }
    if(isset($module['card_color_scheme']) && !empty($module['card_color_scheme'])){ $moduleClasses[] = 'module--' . $module['card_color_scheme']; }
  ?>
  
  <section class="meenta-fc-module module <?php echo implode(' ', $moduleClasses); ?>">

    <?php 
    if($modulePath): include( $modulePath );
    else: 
    ?>

      <div class="container py-6">
        <p><strong>Hmmm... Looks like something is missing here...</strong></p>
        <p>Please <a href="/contact">contact support</a>.</p>
      </div>

    <?php endif; ?>
  </section>
<?php endforeach; else: ?>

  <div class="container py-6">
    <p><strong>Hmmm... Looks like something is missing here...</strong></p>
    <p>Please <a href="/contact">contact support</a>.</p>
  </div>

<?php endif; ?>