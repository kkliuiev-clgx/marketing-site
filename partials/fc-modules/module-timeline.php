<?php
$heading = $module['heading'];
$intro_paragraph = $module['intro_paragraph'];
$timeline = $module['timeline'];
$columns = $module['columns'];
$disclaimer = $module['disclaimer'];
?>

<div class="container">
  <div class="module__intro">
    <?php if($heading): ?>
      <h3 class="section__title"><?php echo $heading; ?></h3>
    <?php endif; ?>
    <?php if($intro_paragraph): ?>
      <?php echo $intro_paragraph; ?>
    <?php endif; ?>
  </div>
  <div class="section__body">
    <ul class="list-timeline">
      <?php foreach($timeline as $key => $item): ?>
        <li class="list-timeline__item current" data-toggle="tooltip" data-placement="bottom" title="<?php echo $item['tooltip']; ?>" style="left: <?php echo $item['timeline_position']; ?>%;">
          <?php if(isset($item['icon']) && !empty($item['icon'])){ ?>
            <img class="img-fluid mb-3" src="<?php echo $item['icon']['sizes']['medium']; ?>" alt="Icon for the timeline item">
          <?php } ?>
          <h4 class="list-timeline__heading <?php if(empty($item['sub_heading'])){ ?> <?php } ?>"><?php echo $item['heading']; ?></h4>
          <h5 class="list-timeline__sub-heading"><?php echo $item['sub_heading']; ?></h5>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php if(isset($columns) && !empty($columns)): ?>
      <?php
        $col_class = 'col-lg-3';
        if(count($columns) == 1){ 
          $col_class = "col-lg-12 narrow"; 
        } else if(count($columns) == 2){
          $col_class = "col-lg-6"; 
        } else if(count($columns) == 3){
          $col_class = "col-lg-4"; 
        }
      ?>
      <div class="row">
        <?php foreach($columns as $key => $column): ?>
          <div class="<?php echo $col_class; ?>">
            <h4 class="section__sub-title"><?php echo $column['heading']; ?></h4>
            <?php echo $column['content']; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <small class="text-muted mt-4 mt-lg-6 d-block">
      <?php echo $disclaimer; ?>
    </small>
  </div>
  
</div>