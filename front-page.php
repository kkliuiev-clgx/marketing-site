<?php get_header(); ?>

<main id="content" class="page-template">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post();  ?>

<?php $hero_bg = get_field('hero_bg'); ?>
<?php //dd(get_fields()); ?>
  <?php get_template_part('partials/components/hero', 'section'); ?>

  <section class="section section--changing">
      <div class="container">


      <?php if(get_field('intro_cards')): ?>
        <?php $cards = get_field('intro_cards'); ?>

        <div class="intro-cards">

          <?php foreach($cards as $key => $card): ?>
            
            <?php $link = get_acf_button_link($card); ?>
          
            <a 
              href="<?php if(isset($link)&& !empty($link)){ echo $link; } ?>" 
              class="intro-card card"
              <?php acf_button_target($card); ?>
            >
              <?php if(isset($card['title'])&& !empty($card['title'])): ?>
                <h2 class="intro-card__title card-title"><?php echo $card['title']; ?></h2>
              <?php endif; ?>
              <?php if(isset($card['content']) && !empty($card['content'])): ?>
                <?php echo $card['content']; ?>
              <?php endif; ?>
              <?php if(isset($card['button_text']) && !empty($card['button_text'])): ?>
                <span class="intro-card__btn btn"><?php echo $card['button_text']; ?> <i class="fas fa-chevron-right"></i></span>
              <?php endif; ?>
            </a>
          <?php endforeach; ?>
          
          
        </div>
        
      <?php endif; ?>
      
        <div class="leading-institutions">
			
                   
          <h2 class="publications-heading section__title"><?php echo get_field('publications_heading'); ?></h2>

          <div class="logos-grid">
            <?php $logos = get_field('publications_logos'); ?>
            <?php foreach($logos as $key => $logo): ?>
              <?php if(isset($logo['image']) && isset($logo['image']['sizes']) && isset($logo['image']['sizes']['medium'])): ?>
                <div class="logos-grid__frame">
                  <img class="tab-blurb__img" src="<?php echo $logo['image']['sizes']['medium']; ?>" <?php acf_img_alt($logo['image']); ?>>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>			



          <h2 class="institutions-heading section__title"><?php echo get_field('institutions_heading'); ?></h2>

          <div class="logos-grid">
            <?php $logos = get_field('institutions_logos'); ?>
            <?php foreach($logos as $key => $logo): ?>
              <?php if(isset($logo['image']) && isset($logo['image']['sizes']) && isset($logo['image']['sizes']['medium'])): ?>
                <div class="logos-grid__frame">
                  <img class="tab-blurb__img" src="<?php echo $logo['image']['sizes']['medium']; ?>" <?php acf_img_alt($logo['image']); ?>>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
 

        
        </div>
        
      </div>
  </section>

<?php endwhile; endif; ?>

</main>
<?php //end content ?>

<?php get_footer(); ?>