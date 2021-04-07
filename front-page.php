<?php get_header(); ?>

<main id="content" class="page-template">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();  ?>

<?php $hero_bg = get_field('hero_bg'); ?>
<?php //dd(get_fields()); ?>
  <?php get_template_part('partials/components/hero', 'section'); ?>

  <section id="search-section" class="section section--search">
    <div class="container">

      <?php if(get_field('intro_cards')): ?>
        <?php $cards = get_field('intro_cards'); ?>

        <div class="intro-cards">

          <?php foreach($cards as $key => $card): ?>
            
            <?php $link = get_acf_button_link($card); ?>
          
            <a 
              href="<?php if(isset($link)&& !empty($link)){ echo $link; } ?>" 
              class="intro-card card"
              <?php acf_button_target($button); ?>
            >
              <?php if(isset($card['title'])&& !empty($card['title'])): ?>
                <h2 class="intro-card__title card-title"><?php echo $card['title']; ?></h2>
              <?php endif; ?>
              <?php if(isset($card['content']) && !empty($card['content'])): ?>
                <?php echo $card['content']; ?>
              <?php endif; ?>
              <?php if(isset($card['button_text']) && !empty($card['button_text'])): ?>
                <span class="intro-card__btn"><?php echo $card['button_text']; ?> <i class="fas fa-chevron-right"></i></span>
              <?php endif; ?>
            </a>
          <?php endforeach; ?>
          
          
        </div>
        
      <?php endif; ?>
    
    
      <div class="section__intro">
        <?php if(get_field('instruments_heading')): ?>
          <h2 class="section__title"><?php echo get_field('instruments_heading'); ?></h2>
        <?php endif; ?>
        <?php if(get_field('instruments_content')): ?>
          <?php echo get_field('instruments_content'); ?>
        <?php endif; ?>
      </div>

      <?php get_template_part('partials/search/widget', 'form'); ?>
      
    </div>
    
  </section>

  <section class="section section--works">
      <div class="container">
        <?php if(get_field('cards')): ?>
          <?php $cards = get_field('cards'); ?>

          <div class="how-it-works-cards">

            <?php foreach($cards as $key => $card): ?>
              <div class="hiw-card card card-<?php echo $card['card_color_scheme']; ?>">
                <?php if(isset($card['card_title'])&& !empty($card['card_title'])): ?>
                  <h3 class="hiw-card__title card-title"><?php echo $card['card_title']; ?></h3>
                <?php endif; ?>
                <?php if(isset($card['card_content']) && !empty($card['card_content'])): ?>
                  <p><?php echo $card['card_content']; ?></p>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
            
          </div>
          
        <?php endif; ?>

        <div class="section__intro">
          <?php if(get_field('how_it_works_title')): ?>
            <h2 class="section__title"><?php echo get_field('how_it_works_title'); ?></h2>
          <?php endif; ?>
          <?php if(get_field('how_it_works_intro_content')): ?>
            <p><?php echo get_field('how_it_works_intro_content'); ?></p>
          <?php endif; ?>
          
        </div>

        <?php if(get_field('how_it_works_tabs')): ?>
          <?php $tabs = get_field('how_it_works_tabs'); ?>
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <?php foreach($tabs as $key => $tab): ?>
              <li class="nav-item">
                <a 
                  class="nav-link <?php if($key == 0){ echo "active"; } ?>"
                  id="<?php echo "how-works-tab-toggle-{$key}"; ?>"
                  data-toggle="tab" 
                  href="#<?php echo "how-works-tab-content-id-{$key}"; ?>" 
                  role="tab" 
                  aria-controls="<?php echo "how-works-tab-content-id-{$key}"; ?>" 
                  aria-selected="true">
                    <?php echo $tab['tb_title']; ?>
                </a>
              </li>
            <?php endforeach; ?>
            <!-- <li class="nav-item">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
            </li> -->
          </ul>
          <div class="tab-content" id="myTabContent">
            <?php foreach($tabs as $key => $tab): ?>
              <div 
                class="tab-pane fade <?php if($key == 0){ echo "show active"; } ?>"
                id="<?php echo "how-works-tab-content-id-{$key}"; ?>" 
                role="tabpanel" 
                aria-labelledby="<?php echo "how-works-tab-toggle-{$key}";?>"
              >
                  <div class="tab-pane__inner">
                    <div class="tab-blurbs">
                      <?php foreach($tab['tab_blurbs'] as $key => $blurb): ?>
                        <div class="tab-blurb">
                          <?php if(isset($blurb['blurb_image']) && isset($blurb['blurb_image']['sizes']) && isset($blurb['blurb_image']['sizes']['medium'])): ?>
                            <div class="tab-blurb__img-wrapper">
                              <img class="tab-blurb__img" src="<?php echo $blurb['blurb_image']['sizes']['medium']; ?>" <?php acf_img_alt($blurb['blurb_image']); ?>>
                            </div>
                          <?php endif; ?>
                          <h4 class="tab-blurb__title"><?php echo $blurb['blurb_title']; ?></h4>
                          <p><?php echo $blurb['blurb_content']; ?></p>
                        </div>
                      <?php endforeach; ?>
                    </div>

                    <div class="tab-features">
                      <?php foreach($tab['tab_features'] as $key => $feature): ?>
                        <div class="tab-feature">
                          <h4 class="tab-feature__heading"><?php echo $feature['heading']; ?></h4>
                          <p class="tab-feature__content"><?php echo $feature['content']; ?></p>
                        </div>
                      <?php endforeach; ?>
                    </div>

                    <?php acf_btn($tab); ?>
                    
                  </div>
              </div>
            <?php endforeach; ?>
            <!-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> -->
          </div>


          
        <?php endif; ?>

        
        
      </div>
  </section>

  <section class="section section--solution">
      <div class="container">
        <div class="section__intro">
            <h2 class="section__title"><?php echo get_field('solutions_heading'); ?></h2>
            <p>
              <?php echo get_field('solutions_intro'); ?>
            </p>
        </div>

        <div class="solutions-groups">
          <?php $groups = get_field('groups'); ?>
          <?php foreach($groups as $key => $group): ?>
            <div class="solutions-group">
              <h3 class="solutions-group__heading"><i class="fas fa-user-circle"></i><?php echo $group['title']; ?></h3>
              <div class="solutions-group__inner">

                <?php $groupCards = $group['cards']; ?>
                
                <div class="group-cards">
                  <?php foreach($groupCards as $key => $groupCard): ?>
                    <a href="<?php echo $link; ?>" class="group-card card" <?php acf_button_target($button); ?>>
                      <div class="group-card__body">
                        <?php $link = get_acf_button_link($groupCard); ?>
                        <h4 class="group-card__title"><?php echo $groupCard['title']; ?></h4>
                      </div>
                      <div class="group-card__footer">
                        <span>
                          <?php echo $groupCard['button_text']; ?>
                          <i class="fas fa-chevron-right"></i>
                        </span>
                      </div>
                    </a>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        
      </div>
  </section>

  <section class="section section--changing">
      <div class="container">
        <div class="section__intro">
            <h2 class="section__title"><?php echo get_field('testimonials_heading'); ?></h2>
            <p>
              <?php echo get_field('testimonials_content'); ?>
            </p>
        </div>

        <div class="testimonials-slider">
          <?php $testimonials = get_field('testimonials'); ?>
          <?php foreach($testimonials as $key => $testimonial): ?>
            <div class="testimonial-card">
              <?php if(isset($testimonial['image']) && isset($testimonial['image']['sizes']) && isset($testimonial['image']['sizes']['large'])): ?>
                <div class="testimonial-card__image" style="background: url(<?php echo $testimonial['image']['sizes']['large']; ?>) no-repeat center; background-size: cover;"></div>
              <?php endif; ?>
              <div class="testimonial-card__content">
                <p class="testimonial-card__body">“<?php echo $testimonial['body']; ?>”</p>
                <p class="testimonial-card__author"><?php echo $testimonial['author']; ?></p>
                <p class="testimonial-card__title"><?php echo $testimonial['title']; ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="leading-institutions">

          <h2 class="institutions-heading section__title"><?php echo get_field('institutions_heading'); ?></h2>

          <div class="logos-grid">
            <?php $logos = get_field('institutions_logos'); ?>
            <?php foreach($logos as $key => $logo): ?>
              <?php if(isset($logo['image']) && isset($logo['image']['sizes']) && isset($logo['image']['sizes']['medium'])): ?>
                <div class="tab-blurb__img-wrapper">
                  <img class="tab-blurb__img" src="<?php echo $logo['image']['sizes']['medium']; ?>" <?php acf_img_alt($logo['image']); ?>>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>


          <h2 class="publications-heading section__title"><?php echo get_field('publications_heading'); ?></h2>

          <div class="logos-grid">
            <?php $logos = get_field('publications_logos'); ?>
            <?php foreach($logos as $key => $logo): ?>
              <?php if(isset($logo['image']) && isset($logo['image']['sizes']) && isset($logo['image']['sizes']['medium'])): ?>
                <img class="tab-blurb__img" src="<?php echo $logo['image']['sizes']['medium']; ?>" <?php acf_img_alt($logo['image']); ?>>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        
        </div>
        
      </div>
  </section>

  <section class="changing-outro">
    <div class="container">
      <div class="changing-section-outro">
        <?php if(get_field('testimonials_cta_heading')): ?>
          <h3 class="section__title"><?php echo get_field('testimonials_cta_heading'); ?></h3>
        <?php endif; ?>
        <?php if(get_field('testimonials_cta_content')): ?>
          <p><?php echo get_field('testimonials_cta_content'); ?></p>
        <?php endif; ?>
        <?php acf_btn(get_field('testimonials_cta_button')); ?>
      </div>
    </div>
  </section>

  <?php $explore_bg = get_field('explore_bg'); ?>
  <section class="section section--explore" style="background: url(<?php if(isset($explore_bg)){ echo $explore_bg['sizes']['1536x1536']; } ?>) no-repeat center; background-size: cover;">
      <div class="container">
        <div class="section__intro">
            <h2 class="section__title"><?php echo get_field('explore_heading'); ?></h2>
            <p>
              <?php echo get_field('explore_content'); ?>
            </p>
            <?php acf_btn(get_field('explore_button')); ?>
        </div>
      </div>
  </section>
<?php endwhile; endif; ?>



</main>
<?php //end content ?>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/vendor/algoliasearch.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/vendor/algoliasearch.helper.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/search/index.js"></script>

<?php get_footer(); ?>