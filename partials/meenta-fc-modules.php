<?php 
$modules = get_field('meenta_fc_modules');
// dd($modules); 
?>


<?php if(isset($modules) && !empty($modules)): foreach($modules as $moduleKey => $module): ?>

  <?php 
    $layoutType = $module['acf_fc_layout']; 
    $moduleId = $module['module_id']; 
    $noPaddingTop = isset($module['no_padding_top']) && $module['no_padding_top'] == 1; 
    $noPaddingBottom = isset($module['no_padding_bottom']) && $module['no_padding_bottom'] == 1; 
    $moduleName = 'partials/fc-modules/module-' . $layoutType . '.php';
    $modulePath = locate_template( $moduleName, false, false );
    $moduleClasses = ['module--' . $layoutType];
    if(!$modulePath){ $moduleClasses[] = 'module--not-found'; }
    if($noPaddingTop){ $moduleClasses[] = 'pt-0'; }
    if($noPaddingBottom){ $moduleClasses[] = 'pb-0'; }
    if(isset($module['color_scheme']) && !empty($module['color_scheme'])){ $moduleClasses[] = 'module--' . $module['color_scheme']; }
  ?>
  
  <section <?php if(isset($moduleId) && !empty($moduleId)){ ?> id="<?php echo $moduleId; ?>" <?php } ?> class="meenta-fc-module module <?php echo implode(' ', $moduleClasses); ?>">

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