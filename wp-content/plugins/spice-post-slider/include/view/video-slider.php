<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<section class="sps page-section-space blog sps-bnr-video video_slider default sps<?php echo esc_attr($sps_post_id);?>">
   <video autoplay="" muted="" loop="" id="video_slider">
      <source src="<?php echo esc_attr($sps_video_banner);?>" type="video/mp4">
   </video>
	<div id="blog-carousel<?php echo esc_attr($sps_post_id);?>" class="owl-carousel owl-theme">
	<?php 
      global $post;
      $the_query = new WP_Query($query_args);
         if ( $the_query->have_posts() ) 
            {
               while ( $the_query->have_posts() ) 
                  {
                     $the_query->the_post();?>
         				<div class="item">
         				<?php if($sps_slider_type == 'vdo_slider') : if($sps_banner_overlay_enable == 'yes') : ?>
         				<div class="sps-post-overlay"></div>
         				<?php endif; endif;?>
							<article class="sps-post">	
								<div class="sps-post-content"> 
									<div class="sps-content-wrapper"> 
										<div class="sps-post-wrapper"> 
											<header class="sps-entry-header">
												<div class="sps-entry-meta">	
													<?php
													 if($sps_cat_enable=='yes')
                                            {       
                                                if ( has_category() ) : 
                                                    echo '<span class="sps-cat-links" alt="'.esc_attr__('Categories','spice-post-slider').'">';
                                                    the_category( ' ' );
                                                    echo '</span>';
                                                endif;
                                            }
													?>	
												</div>
												<?php
												if ($sps_slider_type=='vdo_slider') { 
                                        if($sps_title_enable=='yes') { ?>
												<h3 class="sps-entry-title">
													 <a href="<?php the_permalink();?>" alt="<?php the_title();?>"><?php the_title();?></a>
												</h3> 
												<?php } 
                                    }
                                    if ($sps_slider_type=='vdo_slider') {
                                            if($sps_desc_enable == 'yes' ) {
                                                the_excerpt();
                                            } 
                                        }
                                        ?>
											</header>
											<div class="sps-entry-content">
												<div class="footer-meta">
													<div class="sps-entry-meta">
														<?php if($sps_auth=='yes'): ?>    
                                            <span class="sps-author">
                                                <i class="far fa-user"></i>
                                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" ><?php echo esc_html(get_the_author());?></a>
                                            </span>
                                        <?php endif;
                                         if($sps_dt=='yes'):?>
	                                        <span class="sps-date">  
	                                            <i class="far fa-clock"></i> 
	                                            <a href="<?php echo esc_url( home_url('/') ); ?><?php echo esc_html(gmdate( 'Y/m' , strtotime( get_the_date() )) ); ?>" >
	                                                <time class="entry-date" ><?php echo esc_html(get_the_date()); ?></time>
	                                            </a>
	                                        </span>
                                        <?php endif;
                                        if($sps_comments=='yes'): ?>
                                          <span class="sps-comment-links"><i class="far fa-comment-alt"></i><a href="<?php the_permalink(); ?>#respond" >
                                             <?php echo esc_html(get_comments_number()); echo esc_html__(' Comments','spice-post-slider');?>
                                          </a></span> 
                                       <?php endif; ?>
													</div>
													<?php 
													if( !empty($sps_read) && ($sps_read!='sps_blank') ):?>
                                        <a href="<?php the_permalink();?>" class="sps-more-link" alt="<?php echo esc_attr($sps_read);?>"><?php echo esc_html($sps_read);?>
                                        </a>
                                        <?php endif;?>
												</div>
											</div>
										</div>
									</div>
								</div>
				    		</article>
						</div>
						<?php 
               }
            wp_reset_postdata();
         }
      ?>
   </div>
</section> 