<?php
do_action('newscrunch_before_header_ads','before header');
$newscrunch_social_icon_data = get_theme_mod('social_icons');
$newscrunch_social_icon_enable = get_theme_mod('hide_show_social_icons',true);
if(empty($newscrunch_social_icon_data))
{
	$newscrunch_social_icon_data = json_encode( array(
		array(
			'icon_value' 	=> 	'fab fa-facebook-f',
			'link'       	=> 	'#',
			'open_new_tab' 	=> 	'yes',
			'id'         	=> 	'customizer_repeater_641419a132086',
		),
		array(
			'icon_value' 	=> 	'fa-brands fa-x-twitter',
			'link'       	=> 	'#',
			'open_new_tab' 	=> 	'yes',
			'id'         	=> 	'customizer_repeater_641419a132087',
		),
		array(
			'icon_value' 	=> 	'fab fa-dribbble',
			'link'       	=> 	'#',
			'open_new_tab' 	=> 	'yes',
			'id'         	=> 	'customizer_repeater_641419a132088',
		),
		array(
			'icon_value' 	=> 	'fab fa-instagram',
			'link'       	=> 	'#',
			'open_new_tab' 	=> 	'yes',
			'id'         	=> 	'customizer_repeater_641419a132089',
		),
		array(
			'icon_value' 	=> 	'fab fa-youtube',
			'link'       	=> 	'#',
			'open_new_tab' 	=> 	'yes',
			'id'         	=> 	'customizer_repeater_641419a132090',
		)
  	) );
}
?>

<!-- start of the test -->
<style>
	@media (min-width: 768px) {
/* Main topbar */
.spnc-topbar {
    position: relative;
    height: 40px;
    width: 100%;
    background: #f8f9fa; /* light background fallback */
    overflow: hidden;
    border-bottom: 1px solid #e0e0e0;
}

/* Repeating background image layer (flags) */
.spnc-topbar::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    
    background-repeat: repeat-x;
    background-position: center center;
    background-size: auto 100%;
    z-index: 1;
    opacity: 0.9; /* slight transparency so content stands out more */
}

/* Long soft fade ONLY on the background image */
.spnc-topbar::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        to right,
        #fff 0%,
        var(--yellow) 10%,
        transparent 20%,
        transparent 65%,
        var(--yellow) 85%,
        #fff 100%
    );
    pointer-events: none;
    z-index: 2; /* above the image, below the content */
}

/* Ensure all content (left language + right social icons) is fully visible */
.spnc-topbar .spnc-container {
    position: relative;
    z-index: 10; /* high enough to be above everything */
   
    /*justify-content: space-between;*/
   
}




/* Left language section - extreme left with right-slanting edge */
.spnc-topbar .head-contact-info {
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
    padding: 0 50px 3px 20px; /* Padding for content + space for slant */
    background: var(--yellow); /* Light green - adjust shade as needed */
    clip-path: polygon(0 0, 92% 0, 80% 100%, 0 100%); /* Slants right edge inward */
    z-index: 10;

    margin:0 !important;
    color: #333;
    font-weight: 500;
}

/* Right social icons - extreme right with left-slanting edge */
.spnc-topbar .custom-social-icons {
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
    padding: 0 20px 0 80px; /* Padding for content + space for slant */
    background: var(--yellow); /* Same light green */
    clip-path: polygon(20% 0, 100% 0, 100% 100%, 8% 100%); /* Slants left edge inward */
    z-index: 10;
    gap: 15px;
}

/* Text/icon visibility on green background */
.spnc-topbar .head-contact-info a,
.spnc-topbar .head-contact-info span,
.spnc-topbar .custom-social-icons a,
.spnc-topbar .custom-social-icons i {
    color: #333 !important;
    font-size: 14px;
    opacity: 1;
}

/* Optional: Hover effect */
.spnc-topbar .custom-social-icons a:hover {
    opacity: 0.7;
}

}
</style>

<div class="spnc-topbar ukroa-topbar">
	<div class="spnc-container">
		<?php 
		$newscrunch_date_enable = get_theme_mod('hide_show_date', true);
		$newscrunch_time_enable = get_theme_mod('hide_show_time', true);
		if( ($newscrunch_date_enable == true) || ($newscrunch_time_enable == true) ) { ?>
		<aside class="widget spnc-left ukroa_bg_left ">
			<ul class="head-contact-info">

				 <?php 
// Check if the shortcode exists
    if (shortcode_exists('gtranslate')) {
    // Display the output of the shortcode
        echo do_shortcode('[gtranslate]');
    }    ?>

				<!-- <?php if($newscrunch_date_enable == true) { ?>
					<li class="header-date"><i class='far fa-calendar-alt'></i><span class="date"><?php echo date_i18n(get_option('date_format'), current_time('timestamp')); ?></span></li>
				<?php }
				if($newscrunch_time_enable == true) { ?>
					<li class="header-time"><i class="far fa-regular fa-clock"></i><span class="time newscrunch-topbar-time"></span></li>
				<?php } ?> -->
			</ul>
		</aside>
		<?php } 
		if($newscrunch_social_icon_enable == true ) { ?>
		<aside class="widget spnc-right ukroa-userinfo">
			<ul class="custom-social-icons">
				<?php
				$newscrunch_social_icon_data = json_decode($newscrunch_social_icon_data);
                if (!empty($newscrunch_social_icon_data))
                { 
					foreach($newscrunch_social_icon_data as $newscrunch_social)
                  	{ 
	                    $newscrunch_social_icon = ! empty( $newscrunch_social->icon_value ) ? apply_filters( 'newscrunch_translate_single_string', $newscrunch_social->icon_value, 'Social Icon' ) : ''; 
	                    $newscrunch_social_link = ! empty( $newscrunch_social->link ) ? apply_filters( 'newscrunch_translate_single_string', $newscrunch_social->link, 'Social Icon' ) : '#';

	                    $newscrunch_exp = explode("fab fa-",$newscrunch_social_icon);
	                    foreach($newscrunch_exp as $newscrunch_exp_value){
	                    	  $newscrunch_tle = $newscrunch_exp_value;
	                    }
	                   
	                    if(!empty($newscrunch_social_icon)):?>
		                    <li>
		                      <a <?php if($newscrunch_social->open_new_tab== 'yes'){echo "target='_blank'";} ?> href="<?php echo esc_url($newscrunch_social_link); ?>" title="<?php echo esc_attr($newscrunch_tle); ?>"><i class="<?php echo esc_attr($newscrunch_social_icon); ?>"></i></a>
		                    </li>
				     	<?php endif;
			    	} 
			    } ?>
			    <li><a href="#">
			    	<i class="fa fa-sign-in"></i>
                    </a></li>
			</ul>
		</aside>
		<?php } ?>
	</div>
</div>
<?php do_action('newscrunch_inside_header_ads', 'inside header');?>