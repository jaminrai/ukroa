<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<section class="sps page-section-space blog bg-default sps<?php echo esc_attr($sps_post_id);?> <?php if($sps_slider_type=='banner_slider') echo 'sps-banner-style';?>">
                <div id="blog-carousel<?php echo esc_attr($sps_post_id);?>" class="owl-carousel owl-theme">
                <?php 
                global $post;
                $the_query = new WP_Query($query_args);
                if ( $the_query->have_posts() ) {
                    while ( $the_query->have_posts() ) 
                    {
                        $the_query->the_post(); ?>
                        <div class="item">
                            <article class="post">
                                <?php if($sps_slider_type == 'banner_slider') :
                                    if($sps_banner_overlay_enable == 'yes') : ?>
                                        <div class="overlay"></div>
                                    <?php endif;
                                endif;
                                if(has_post_thumbnail()):?>
                                <figure class="post-thumbnail">                     
                                    <?php the_post_thumbnail($sps_img,array('class'=>'img-fluid'));?>
                                </figure>
                                <?php endif;?>
                                <div class="post-content">
                                    <?php if($sps_slider_type == 'blog_post_slider') { ?>                     
                                    <div class="entry-meta">
                                        <?php if($sps_dt=='yes'):?>
                                        <span class="date">  
                                            <i class="far fa-clock"></i> 
                                            <a href="<?php echo esc_url( home_url('/') ); ?><?php echo esc_html(gmdate( 'Y/m' , strtotime( get_the_date() )) ); ?>" >
                                                <time class="entry-date" ><?php echo esc_html(get_the_date()); ?></time>
                                            </a>
                                        </span>
                                        <?php 
                                        endif;
                                        if($sps_cat_enable=='yes')
                                            {       
                                                if ( has_category() ) : 
                                                    echo '<i class="fa fa-folder-open"></i><span class="cat-links" alt="'.esc_attr__('Categories','spice-post-slider').'">';
                                                    the_category( ', ' );
                                                    echo '</span>';
                                                endif;
                                            }
                                        if($sps_comments=='yes'):    
                                        ?>
                                        <span class="comments-link">
                                            <i class="far fa-comment-alt"></i> 
                                            <a href="<?php the_permalink(); ?>#respond" >
                                                <?php echo esc_html(get_comments_number()); echo esc_html__(' Comments','spice-post-slider');?>
                                            </a>
                                        </span>  
                                        <?php endif;?>
                                    </div>
                                    <?php }
                                    if ($sps_slider_type=='banner_slider') { 
                                        if($sps_title_enable=='yes') { ?>
                                            <header class="entry-header">
                                                <h3 class="entry-title">
                                                    <a href="<?php the_permalink();?>" alt="<?php the_title();?>"><?php the_title();?></a>
                                                </h3>                                                  
                                            </header>
                                        <?php } 
                                    }
                                    else { ?>
                                        <header class="entry-header">
                                            <h3 class="entry-title">
                                                <a href="<?php the_permalink();?>" alt="<?php the_title();?>"><?php the_title();?></a>
                                            </h3>                                                  
                                        </header>
                                    <?php } ?>
                                    <div class="entry-content">
                                        <?php 
                                        if ($sps_slider_type=='banner_slider') {
                                            if($sps_desc_enable == 'yes' ) {
                                                the_excerpt();
                                            } 
                                        }
                                        else { 
                                            the_excerpt(); 
                                        } ?>
                                        <div class="spice-seprator"></div>
                                        <?php if($sps_slider_type == 'blog_post_slider') { ?> 
                                        <div class="footer-meta entry-meta">
                                        <?php if($sps_auth=='yes'): ?>    
                                            <span class="author">
                                                <i class="far fa-user"></i>
                                                <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" ><?php echo esc_html(get_the_author());?></a>
                                            </span>
                                        <?php endif;?>    
                                        </div>
                                        <?php }
                                        if( !empty($sps_read) && ($sps_read!='sps_blank') ):?>
                                        <a href="<?php the_permalink();?>" class="more-link" alt="<?php echo esc_attr($sps_read);?>"><?php echo esc_html($sps_read);?><i class="fas fa-chevron-right"></i>
                                        </a>
                                        <?php endif;?>
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