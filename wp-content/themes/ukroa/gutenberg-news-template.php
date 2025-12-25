<?php
/**
 * Template Name: Homepage Ukroa
 *
*/

get_header();

if ('Newscrunch' == wp_get_theme() || 'Newscrunch Child' == wp_get_theme() || 'Newscrunch child' == wp_get_theme() ) {
    $newscrunch_banner_sort=get_theme_mod( 'front_banner_highlight_sort', array('front_banner', 'front_highlight', 'front_ad') );
}
else {
    $newscrunch_banner_sort=get_theme_mod( 'front_banner_highlight_sort', array('front_highlight', 'front_banner', 'front_ad') );
}

if ( ! empty( $newscrunch_banner_sort ) && is_array( $newscrunch_banner_sort ) ) :
    foreach ( $newscrunch_banner_sort as $newscrunch_banner_sort_key => $newscrunch_banner_sort_val ) :

   

        if(get_theme_mod('newscrunch_enable_front_highlight',true)==true):
            if ( 'front_highlight' === $newscrunch_banner_sort_val ) :

                if ( is_front_page() ) {
                    newscrunch_highlight_views('front');
                } else {
                     newscrunch_highlight_views('inner');
                }
                
            endif;
        endif;
    endforeach;
endif;

 if(get_theme_mod('hide_show_page_editor_section',true)==true) { ?>
 

<?php } ?>


<!-- UKROA Main Slider - Bottom Banner Style (Clean & Professional) -->
<section class="ukroa-main-slider-section">
    <div class="swiper ukroa-main-slider">
       <div class="swiper-wrapper">
    <?php
    $slides_query = new WP_Query(array(
        'post_type'      => 'ukroa_slide',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'post_status'    => 'publish'
    ));

    if ($slides_query->have_posts()) :
        while ($slides_query->have_posts()) : $slides_query->the_post();
            $slide_image = '';
            if (has_post_thumbnail()) {
                $slide_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                $slide_image = $slide_image[0]; // Direct URL
            } else {
                $slide_image = 'https://via.placeholder.com/1920x1080/003366/ffffff?text=UKROA+Slide';
            }

            $link_url   = get_post_meta(get_the_ID(), '_ukroa_slide_link_url', true);
            $link_text  = get_post_meta(get_the_ID(), '_ukroa_slide_link_text', true);
            $link_text  = !empty($link_text) ? $link_text : 'Learn More';
            ?>
            <div class="swiper-slide">
                <!-- Direct <img> tag – no wrapper (critical for Swiper) -->
                <img src="<?php echo esc_url($slide_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">

                <div class="ukroa-slide-caption-bottom">
                    <div class="caption-content">
                        <h2><?php the_title(); ?></h2>
                        <?php if (get_the_excerpt()) : ?>
                            <p><?php the_excerpt(); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($link_url)) : ?>
                            <a href="<?php echo esc_url($link_url); ?>" class="ukroa-slider-btn">
                                <?php echo esc_html($link_text); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    else : ?>
        <!-- Fallback if no slides -->
        <div class="swiper-slide">
            <img src="https://via.placeholder.com/1920x1080/003366/ffffff?text=No+Slides+Yet" alt="No slides">
            <div class="ukroa-slide-caption-bottom">
                <div class="caption-content">
                    <h2>Welcome to UKROA</h2>
                    <p>Add slides from Dashboard → UKROA Slides</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

        <!-- Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Swiper CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.ukroa-main-slider', {
        loop: true,
        autoplay: { delay: 6000, disableOnInteraction: false },
        speed: 1000,
        effect: 'fade',
        fadeEffect: { crossFade: true },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: { el: '.swiper-pagination', clickable: true },
        lazy: true,
    });
});
</script>

<style>
.ukroa-main-slider-section {
    width: 100%;
    margin: 0;
    overflow: hidden;
}

.ukroa-main-slider {
    height: 80vh;
    min-height: 520px;
    position: relative;
}

.ukroa-main-slider .swiper-slide {
    position: relative;
    background: #000;
}

.ukroa-main-slider .swiper-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* Bottom caption banner - clean & professional */
.ukroa-slide-caption-bottom {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.92) 0%, rgba(0,0,0,0.7) 70%, transparent 100%);
    padding: 100px 40px 40px 40px;
    z-index: 10;
    pointer-events: none;
}

.caption-content {
    max-width: 1200px;
    margin: 0 auto;
    text-align: left;
    pointer-events: auto;
}

.caption-content h2 {
    color: white;
    font-size: 3.2rem;
    font-weight: 700;
    margin: 0 0 12px 0;
    line-height: 1.15;
    text-shadow: 0 2px 8px rgba(0,0,0,0.6);
}

.caption-content p {
    color: #f0f0f0;
    font-size: 1.35rem;
    margin: 0 0 24px 0;
    max-width: 700px;
    line-height: 1.5;
}

/* Premium Button - Professional Look */
.ukroa-slider-btn {
    display: inline-block;
    background: #ffcc00;
    color: #003366;
    font-weight: 700;
    font-size: 1.05rem;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    padding: 16px 38px;
    border-radius: 50px;
    text-decoration: none;
    box-shadow: 0 8px 25px rgba(255, 204, 0, 0.4);
    transition: all 0.35s ease;
    border: 3px solid transparent;
}

.ukroa-slider-btn:hover {
    background: white;
    color: #003366;
    transform: translateY(-4px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    border: 3px solid #ffcc00;
}

/* Navigation Arrows */
.ukroa-main-slider .swiper-button-next,
.ukroa-main-slider .swiper-button-prev {
    background: rgba(0,0,0,0.5);
    width: 56px;
    height: 56px;
    border-radius: 50%;
    backdrop-filter: blur(8px);
}

.ukroa-main-slider .swiper-button-next:after,
.ukroa-main-slider .swiper-button-prev:after {
    color: white;
    font-size: 22px;
    font-weight: bold;
}

/* Pagination */
.ukroa-main-slider .swiper-pagination {
    bottom: 25px;
}

.ukroa-main-slider .swiper-pagination-bullet {
    background: white;
    opacity: 0.7;
    width: 11px;
    height: 11px;
}

.ukroa-main-slider .swiper-pagination-bullet-active {
    background: #ffcc00;
    opacity: 1;
    transform: scale(1.3);
}

/* Responsive */
@media (max-width: 991px) {
    .ukroa-main-slider { height: 70vh; min-height: 480px; }
    .caption-content h2 { font-size: 2.6rem; }
    .caption-content p { font-size: 1.2rem; }
    .ukroa-slide-caption-bottom { padding: 80px 30px 30px; }
}

@media (max-width: 576px) {
    .caption-content h2 { font-size: 2.1rem; }
    .caption-content p { font-size: 1.1rem; }
    .ukroa-slider-btn { padding: 14px 30px; font-size: 1rem; }
    .ukroa-slide-caption-bottom { padding: 70px 20px 25px; }
}
</style>
  



<!-- ABout us -->
<!-- ========== ABOUT PREVIEW SECTION ========== -->
<section class="org-preview-section">
  <div class="org-preview-card">
    <div class="org-content">
      <div class="org-badge">About Us</div>
      
      <h2 class="org-title">United Kirat Rai Organization Of America</h2>
      
      <p class="org-description">
         United Kirat Rai Organization of America (UKROA) is a non-profit organization established in 2007 with the aim to practice, preserve, and promote Kirat Rai culture in the United States of America.
 
     
      </p>
      
  <!--     <div class="org-stats">
        <div class="stat">
          <span class="number">50,000+</span>
          <span class="label">Lives Impacted</span>
        </div>
        <div class="stat">
          <span class="number">200+</span>
          <span class="label">Projects Completed</span>
        </div>
        <div class="stat">
          <span class="number">12</span>
          <span class="label">Countries Reached</span>
        </div>
      </div> -->
      
      <a href="/ukroa/sample-page" class="org-readmore-btn">
        <span>Read More</span>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <path d="M7 17L17 7"></path>
          <path d="M7 7h10v10"></path>
        </svg>
      </a>
    </div>
    
    <div class="org-visual">
      <div class="glow-effect"></div>
    </div>
  </div>
</section>

<style>
  .org-preview-section {
    padding: 50px 20px;
    //background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    overflow: hidden;
    position: relative;
  }

  .org-preview-card {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
    position: relative;
  }

  .org-content {
    padding: 70px 60px;
    position: relative;
    z-index: 2;
  }

  .org-badge {
    display: inline-block;
    background: rgba(102, 126, 234, 0.15);
    color: #667eea;
    font-size: 0.9rem;
    font-weight: 600;
    padding: 8px 20px;
    border-radius: 50px;
    margin-bottom: 20px;
  }

  .org-title {
    font-size: 1.4rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.2;
    margin-bottom: 24px;
  }

  .org-description {
    font-size: 1.2rem;
    color: #475569;
    line-height: 1.8;
    margin-bottom: 40px;
  }

  .org-stats {
    display: flex;
    gap: 40px;
    margin-bottom: 40px;
    flex-wrap: wrap;
  }

  .stat {
    text-align: center;
  }

  .stat .number {
    display: block;
    font-size: 2.4rem;
    font-weight: 800;
    color: #667eea;
  }

  .stat .label {
    font-size: 0.95rem;
    color: #64748b;
    font-weight: 500;
  }

  .org-readmore-btn {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 16px 36px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
  }

  .org-readmore-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.5);
  }

  .org-readmore-btn svg {
    transition: transform 0.3s ease;
  }

  .org-readmore-btn:hover svg {
    transform: translateX(5px);
  }

  .org-visual {
    position: relative;
    height: 100%;
    min-height: 500px;
    background: url('http://localhost/ukroa/wp-content/uploads/2025/10/8.jpg?ixlib=rb-4.0.3&auto=format&fit=crop&q=80') center/cover no-repeat;
  }

  .glow-effect {
    position: absolute;
    inset: 1;
    background: linear-gradient(135deg, rgba(102, 126, 100, 0.1), rgba(118, 75, 120, 0.2));
    pointer-events: none;
  }

  /* Responsive */
  @media (max-width: 992px) {
    .org-preview-card {
      grid-template-columns: 1fr;
      gap: 0;
    }
    .org-visual {
      min-height: 300px;
      order: -1;
    }
    .org-content {
      padding: 60px 40px;
      text-align: center;
    }
    .org-stats {
      justify-content: center;
    }
  }

  @media (max-width: 600px) {
    .org-content { padding: 50px 25px; }
    .org-title { font-size: 2.3rem; }
    .org-stats { gap: 25px; }
    .stat .number { font-size: 2rem; }
  }
</style>
<!-- end of about us -->




<!-- Projects -->
<section class="iwgia-work-section">
  <div class="container">
    <h2>UKROA's PROJECTS</h2>
    <p class="section-intro">We advocate for indigenous peoples' rights worldwide through research, publications, and advocacy.</p>
    
    <div class="work-grid">
          <?php
            // Define query args for Nagarpalika posts
                    $update = array(
                        'posts_per_page' => 3,
                        'cat'            => 3,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                        'post_status' => 'publish',
                    );

         
                        $update_query = new WP_Query($update);
                        $posts = $update_query->posts;
                   

            // Display posts
                    if (!empty($posts)) :
                        foreach ($posts as $post) : setup_postdata($post);
                            ?>
      <div class="work-item">
        <?php if (has_post_thumbnail()) : ?>
        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title_attribute(); ?>-UKROA" class="work-img">
          <?php else : ?>
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/screenshot.png'); ?>" alt="<?php the_title_attribute(); ?>" class="highlight-image" loading="lazy">
                                    <?php endif; ?>

        <h3><?php the_title(); ?></h3>
        <p><?php the_excerpt(); ?></p>
        <a href="<?php the_permalink(); ?>" class="learn-more">Learn More</a>
      </div>
         <?php
                        endforeach;
                        wp_reset_postdata();
                    endif;
                 
                        ?>
      
      
   
      
    
    </div>
  </div>
</section>

<style>
  .iwgia-work-section {
    padding: 80px 20px;
    background: #f8f9fa;
    color: #333;
  }
  
  .container {
    max-width: 1200px;
    margin: 0 auto;
  }
  
  .iwgia-work-section h2,  .iwgia-connected-section h2  {
    text-align: center;
    font-size: 2.5rem;
    color: #2E7D32;
    margin-bottom: 20px;
    font-weight: 600;
  }

  
  .work-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
  }
  
  .work-item {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: center;
  }
  
  .work-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
  }
  
  .work-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }
  
  .work-item h3 {
    padding: 20px 20px 10px;
    font-size: 1.3rem;
    margin-bottom: 0;
    color: #00695C;
  }
  
  .work-item p {
    padding: 0 20px 20px;
    color: #303841;
    font-size: 0.95rem;
  }
  
  .learn-more {
    display: inline-block;
    color: #2E7D32;
    text-decoration: none;
    font-weight: 600;
    margin-bottom: 20px;
    padding: 8px 20px;
    border: 2px solid #2E7D32;
    border-radius: 25px;
    transition: background 0.3s ease;
  }
  
  .learn-more:hover {
    background: #2E7D32;
    color: white;
  }
  
  @media (max-width: 768px) {
    .iwgia-work-section { padding: 60px 15px; }
    .iwgia-work-section h2 { font-size: 2rem; }
    .work-grid { grid-template-columns: 1fr; gap: 20px; }
  }
</style>
<!-- End of projects -->


<!-- latest update start -->
<section class="iwgia-updates-section">
  <div class="container">
    <h2>Latest Updates</h2>
    <p class="section-intro">Stay informed with our recent news, reports, and events.</p>
    
    <div class="updates-grid">

           <?php
            // Define query args for Nagarpalika posts
                    $update = array(
                        'posts_per_page' => 3,
                        'cat'            => 1,
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                        'post_status' => 'publish',
                    );

         
                        $update_query = new WP_Query($update);
                        $posts = $update_query->posts;
                   

            // Display posts
                    if (!empty($posts)) :
                        foreach ($posts as $post) : setup_postdata($post);
                            ?>
      <article class="update-card">
      




            <?php if (has_post_thumbnail()) : ?>
                  <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title_attribute(); ?>-UKROA NEWS" class="update-img">
        
          <?php else : ?>
        <img src="<?php echo esc_url(get_template_directory_uri() . '/screenshot.png'); ?>" alt="<?php the_title_attribute(); ?>" class="update-img" loading="lazy">
                                    <?php endif; ?>


        <div class="update-content">
          <span class="update-date">November 15, 2025</span>
          <h3><?php the_title(); ?></h3>
          <p><?php the_excerpt(); ?></p>
          <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
        </div>
      </article>
          <?php
                        endforeach;
                        wp_reset_postdata();
                    endif;
                 
                        ?>
      
    
    </div>
    
    <a href="<?php echo esc_url(get_category_link(1)); ?>" class="view-all">View All Updates</a>
  </div>
</section>

<style>
  .iwgia-updates-section {
    padding: 80px 20px;
    background: white;
    color: #333;
  }
  
  .iwgia-updates-section h2 {
    text-align: center;
    font-size: 2.5rem;
    color: #2E7D32;
    margin-bottom: 20px;
    font-weight: 600;
  }
  

  
  .updates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
  }
  
  .update-card {
    background: #f8f9fa;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
  }
  
  .update-card:hover {
    transform: translateY(-3px);
  }
  
  .update-img {
    width: 100%;
    height: 180px;
    object-fit: cover;
  }
  
  .update-content {
    padding: 20px;
  }
  
  .update-date {
    display: block;
    color: #00695C;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 10px;
  }
  
  .update-content h3 {
    font-size: 1.2rem;
    color: #333;
    margin-bottom: 10px;
    line-height: 1.4;
  }
  
  .update-content p {
    color: #303841;
    font-size: 0.95rem;
    margin-bottom: 15px;
  }
  
  .read-more {
    color: #2E7D32;
    text-decoration: none;
    font-weight: 600;
  }
  
  .read-more:hover {
    text-decoration: underline;
  }
  
  .view-all {
    display: block;
    width: max-content;
    margin: 0 auto;
    color: #2E7D32;
    text-decoration: none;
    font-weight: 600;
    padding: 12px 30px;
    border: 2px solid #2E7D32;
    border-radius: 25px;
    transition: background 0.3s ease;
  }
  
  .view-all:hover {
    background: #2E7D32;
    color: white;
  }
  
  @media (max-width: 768px) {
    .iwgia-updates-section { padding: 60px 15px; }
    .iwgia-updates-section h2 { font-size: 2rem; }
    .updates-grid { grid-template-columns: 1fr; gap: 20px; }
  }
</style>
<!-- end of the latest update -->

<!-- start of team -->
<section class="iwgia-team-section">
  <div class="container">
    <h2>UKROA Team</h2>
    <p class="section-intro">Meet the dedicated professionals driving our mission forward.</p>
    <?php echo do_shortcode('[tmm name="central-chapter"]'); ?>

<?php echo do_shortcode('[tmm name="board-of-assembly-members"]'); ?>

<?php echo do_shortcode('[tmm name="advisors-media-co-ordinator"]'); ?>
<?php echo do_shortcode('[tmm name="patrons"]'); ?>



        <a href="<?php echo esc_url( get_permalink( get_page_by_path('team') ) ); ?>" class="view-all">View All Teams</a>
    </div>
  </div>
</section>

<style>
  .iwgia-team-section {
    padding: 80px 20px;
    background: #f8f9fa;
    color: #333;
  }
  
  .iwgia-team-section h2 {
    text-align: center;
    font-size: 2.5rem;
    color: #2E7D32;
    margin-bottom: 20px;
    font-weight: 600;
  }
  

</style>
<!-- end of team -->


<!-- start of stay connected -->
<section class="iwgia-connected-section">
  <div class="container">
    <h2>Stay Connected</h2>
    <p class="section-intro">Subscribe to our newsletter and follow us for the latest updates on indigenous affairs.</p>
    
    <form class="newsletter-form" action="/subscribe" method="post">
      <input type="email" placeholder="Enter your email address" required class="email-input">
      <button type="submit" class="subscribe-btn">Subscribe</button>
    </form>
    
    <div class="social-links">
      <a href="https://twitter.com" class="social-icon" aria-label="Twitter">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
      </a>
      <a href="https://facebook.com" class="social-icon" aria-label="Facebook">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.024 3.47h-3.304v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
      </a>
      <a href="https://instagram.com" class="social-icon" aria-label="Instagram">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
      </a>
      <a href="https://linkedin.com/company/" class="social-icon" aria-label="LinkedIn">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
      </a>
    </div>
    
    <div class="footer-links">
      <a href="/donate.html">Donate</a>
      <a href="/contact.html">Contact</a>
      <a href="/privacy.html">Privacy Policy</a>
    </div>


  </div>
</section>

<style>
  .iwgia-connected-section {
    padding: 80px 20px 40px;
    background: #eeeef5;
    color: white;
    text-align: center;
  }
  

  
  .section-intro {
       text-align: center;
    font-size: 1.1rem;
    color: #303841;
    margin-bottom: 50px;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
  }
  
  .newsletter-form {
    display: flex;
    max-width: 500px;
    margin: 0 auto 40px;
    gap: 10px;
  }
  
  .email-input {
    flex: 1;
    padding: 12px 16px;
    border: none;
    border-radius: 25px;
    font-size: 1rem;
  }
  
  .subscribe-btn {
    padding: 12px 24px;
    background: #00695C;
    color: white;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease;
  }
  
  .subscribe-btn:hover {
    background: #004d40;
  }
  
  .social-links {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 30px;
  }
  
  .social-icon {
    color: #171618;
    font-size: 1.5rem;
    transition: transform 0.3s ease;
  }
  
  .social-icon:hover {
    transform: scale(1.2);
  }
  
  .footer-links {
    display: flex;
    justify-content: center;
    gap: 30px;
  }
  
  .footer-links a {
    color: #4b4954;
    text-decoration: none;
    font-size: 0.95rem;
    transition: color 0.3s ease;
  }
  
  .footer-links a:hover {
    color: white;
  }
  
  @media (max-width: 768px) {
    .iwgia-connected-section { padding: 60px 15px 30px; }
    .iwgia-connected-section h2 { font-size: 2rem; }
    .newsletter-form { flex-direction: column; }
    .social-links { gap: 15px; }
    .footer-links { flex-direction: column; gap: 15px; }
  }
</style>
<!-- end of stay connected -->



<section class="spnc-page-section-space spnc-missed-section spncmc-1 spncmc-selective" style="margin-top: 20px;">
    <div class="spnc-container">
 

      <div class="ukroa-simple-contact">
    <div class="ukroa-simple-row">
        <div class="ukroa-simple-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1476488.8181899202!2d-71.066163!3d42.425096!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e371638a44d3e9%3A0x68895d9987691b55!2s229%20MA-60%2C%20Malden%2C%20MA%2002148!5e1!3m2!1sen!2sus!4v1760772621505!5m2!1sen!2sus"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <div class="ukroa-simple-form">
            
            <?php echo do_shortcode('[contact-form-7 id="f32c516" title="Contact form 1"]'); ?>
        </div>
    </div>
</div>

</div>
</section>









<?php 
get_footer();
 ?>