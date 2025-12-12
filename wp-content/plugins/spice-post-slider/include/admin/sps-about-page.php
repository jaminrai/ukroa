<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Plugin About Page
 *
 * @package Spice Post Slider
 */
?>
<div id="sps-about" class="sps-about-page">
	<div class="spice-col-2">
		<div class="sps-about-img">
			<?php 
			$sps_attachment_id = sps_save_image_to_media_library(SPS_URL.'assets/img/about-mockup.png');
            echo wp_get_attachment_image(esc_attr($sps_attachment_id), 'full', false) ;
			?>
		</div>
		<div class="sps-about-features">
			<div class="sps-about-feat-box">
				<span><i class="fa fa-check-circle"></i> <?php esc_html_e('Fully Responsive','spice-post-slider');?></span>
			</div>
			<div class="sps-about-feat-box">
				<span><i class="fa fa-check-circle"></i> <?php esc_html_e('User-friendly Panel','spice-post-slider');?></span>
			</div>
			<div class="sps-about-feat-box">
				<span><i class="fa fa-check-circle"></i> <?php esc_html_e('WP themes Compatible','spice-post-slider');?></span>
			</div>
			<div class="sps-about-feat-box">
				<span><i class="fa fa-check-circle"></i> <?php esc_html_e('Beautiful Layouts','spice-post-slider');?></span>
			</div>
			<div class="sps-about-feat-box">
				<span><i class="fa fa-check-circle"></i> <?php esc_html_e('Shortcode Generator','spice-post-slider');?></span>
			</div>
			<div class="sps-about-feat-box">
				<span><i class="fa fa-check-circle"></i> <?php esc_html_e('Post Category Filter','spice-post-slider');?></span>
			</div>
			<div class="sps-about-feat-box">
				<span><i class="fa fa-check-circle"></i> <?php esc_html_e('Color & Typography','spice-post-slider');?></span>
			</div>
			<div class="sps-about-feat-box">
				<span><i class="fa fa-check-circle"></i> <?php esc_html_e('Fast & Active Support','spice-post-slider');?></span>
			</div>
		</div>
		<div class="sps-about-doc-support">
			<div class="sps-about-docsup-box">
				<span><a href="<?php echo esc_url('https://helpdoc.spicethemes.com/category/spice-slider/spice-post-slider/'); ?>" target="_blank"><i class="fa fa-file"></i> <?php esc_html_e('Documentations','spice-post-slider');?></a></span>
			</div>
			<div class="sps-about-docsup-box">
				<span><a href="<?php echo esc_url('https://wordpress.org/support/plugin/spice-post-slider/'); ?>" target="_blank"><i class="fa fa-headphones"></i> <?php esc_html_e('Get Support','spice-post-slider');?></a></span>
			</div>
		</div>
		<div class="sps-about-upgrade">
			<div class="sps-about-upgrade-pro-box">
				<a href="<?php echo esc_url('https://spicethemes.com/spice-slider-pro/'); ?>" target="_blank"><?php esc_html_e('UPGRADE TO PRO','spice-post-slider');?></a>
			</div>
		</div>
	</div>
	<div class="spice-col-4"> 
		<div class="sps-about-free-plugin">
			<span><?php esc_html_e('About Post Slider Free Plugin','spice-post-slider');?></span>
			<p><?php esc_html_e('This plugin allows you to showcase your blog posts in a beautiful slider with multiple options, It is responsive ready so it will work perfectly on different devices like mobile and iPad.','spice-post-slider');?></p>
			<div class="sps-about-button">
				<div class="sps-about-free-btn">
					<a href="<?php echo esc_url('https://plugin-demo.spicethemes.com/spice-post-slider/'); ?>" target="_blank"><?php esc_html_e('View Demo With Free Features','spice-post-slider');?></a>
				</div>
				<div class="sps-about-go-pro-btn">
					<a href="<?php echo esc_url('https://spicethemes.com/spice-slider-pro/'); ?>" target="_blank"><?php esc_html_e('Go To Pro','spice-post-slider');?> <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
		</div>
		<div class="sps-about-powerful-feature">
			<span><?php esc_html_e('Powerful Pro Features','spice-post-slider');?></span>
			<p><?php esc_html_e('The pro plugin allows you to showcase your blog posts in a beautiful slider with multiple design layouts using animation effects. You can also use different typography on different devices.','spice-post-slider');?></p>
			<div class="sps-about-powerful-pro">
				<div class="sps-about-powerful-btn">
					<a href="<?php echo esc_url('https://plugin-demo.spicethemes.com/spice-slider-pro/'); ?>" target="_blank"><?php esc_html_e('View Demo','spice-post-slider');?></a>
				</div>
			</div>
		</div>
		<div class="sps-about-freepro-compare">
			<table>
				<tr>
					<th><?php esc_html_e('General','spice-post-slider');?></th>
					<th class="table-free-head"><?php esc_html_e('Free','spice-post-slider');?></th>
					<th class="table-pro-head"><?php esc_html_e('Pro','spice-post-slider');?></th>
				</tr>
				<tr>
					<td><?php esc_html_e('Permium Support','spice-post-slider');?></td>
					<td class="table-free-icon"><i class="fa fa-times-circle"></i></td>
					<td class="table-pro-icon"><i class="fa fa-check-circle"></i></td>
				</tr>
				<tr>
					<td><?php esc_html_e('Shortcode Generator','spice-post-slider');?></td>
					<td class="table-pro-icon"><i class="fa fa-check-circle"></i></td>
					<td class="table-pro-icon"><i class="fa fa-check-circle"></i></td>
				</tr>
				<tr>
					<td><?php esc_html_e('Designed Layouts','spice-post-slider');?></td>
					<td class="table-td-content"><?php esc_html_e('3','spice-post-slider');?></td>
					<td class="table-td-content"><?php esc_html_e('25+','spice-post-slider');?></td>
				</tr>
				<tr>
					<td><?php esc_html_e('Video Support','spice-post-slider');?></td>
					<td class="table-pro-icon"><i class="fa fa-check-circle"></i></td>
					<td class="table-pro-icon"><i class="fa fa-check-circle"></i></td>
				</tr>
				<tr>
					<td><?php esc_html_e('Color & Typography','spice-post-slider');?></td>
					<td class="table-pro-icon"><i class="fa fa-check-circle"></i></td>
					<td class="table-td-content"><?php esc_html_e('Advanced','spice-post-slider');?></td>
				</tr>
				<tr>
					<td><?php esc_html_e('Animation Effects','spice-post-slider');?></td>
					<td class="table-free-icon"><i class="fa fa-times-circle"></i></td>
					<td class="table-pro-icon"><i class="fa fa-check-circle"></i></td>
				</tr>
				<tr>
					<td><?php esc_html_e('Navigation & Bullets Style','spice-post-slider');?></td>
					<td class="table-free-icon"><i class="fa fa-times-circle"></i></td>
					<td class="table-pro-icon"><i class="fa fa-check-circle"></i></td>
				</tr>
				<tr>
					<td><?php esc_html_e('Custom CSS Field','spice-post-slider');?></td>
					<td class="table-free-icon"><i class="fa fa-times-circle"></i></td>
					<td class="table-pro-icon"><i class="fa fa-check-circle"></i></td>
				</tr>
			</table>
			
		</div>
	</div>
</div>