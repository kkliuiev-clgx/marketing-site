<?php
$heading = $module['heading'];
$subHeading = $module['sub_heading'];
$teamMembers = $module['team_members'];
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
  <?php if($teamMembers && !empty($teamMembers)): ?>

    <div class="meenta-team-members">
      <?php foreach($teamMembers as $key => $member): ?>
        <?php
        $needsExpander = strlen($member['bio']) > 350;
        ?>
        
        <div class="meenta-team-member module-section py-0">
          <?php if(isset($member['headshot']) && isset($member['headshot']['sizes']) && isset($member['headshot']['sizes']['large'])): ?>
            <div class="meenta-team-member__img-wrapper" style="background: url(<?php echo $member['headshot']['sizes']['large']; ?>) no-repeat center; background-size: cover;">
              <img class="meenta-team-member__img" src="" <?php acf_img_alt($member['headshot']); ?>>
            </div>
          <?php endif; ?>
          <div class="meenta-team-member__content">
            <div id="team-member-collapser-<?php echo meentaCleanString($member['name']); ?>" class="meenta-team-member__collapser <?php if(!$needsExpander){ echo 'inactive'; } ?>">
              <a class="meenta-team-member__name" data-toggle='tooltip' href="<?php echo $member['linkedin_url']; ?>" title="Visit <?php echo $member['name']; ?> on LinkedIn" target="_blank">
                <?php echo $member['name']; ?>
              </a>
              <p class="meenta-team-member__title"><?php echo $member['title']; ?></p>
              <?php echo $member['bio']; ?>
            </div>
            <?php if($needsExpander){ ?>
              <a href="#team-member-collapser-<?php echo meentaCleanString($member['name']); ?>" class="meenta-team-member__read-more" data-meenta-toggle="collapse">
                <span class="the-text">Read More</span>
                <i class="fas fa-chevron-down"></i>
              </a>
            <?php } ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <?php acf_btn($module); ?>
</div>