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

    <?php if (is_user_logged_in()) : ?>
        <a href="<?php echo wp_logout_url(home_url()); ?>">
            <i class="fa fa-sign-out"></i> Sign Out
        </a>
    <?php else : ?>
        <a href="#" class="ukroa_sign_trigger">
            <i class="fa fa-sign-in"></i> Sign In
        </a>
    <?php endif; ?>


			</ul>
		</aside>
		<?php } ?>
	</div>
</div>
<?php do_action('newscrunch_inside_header_ads', 'inside header');?>


<!-- Ukroa Sign In / Sign Up Modal -->
<div class="ukroa_sign_overlay" id="ukroa_sign_overlay"></div>

<div class="ukroa_sign_modal" id="ukroa_sign_modal">
    <div class="ukroa_sign_container">
        
        <!-- Login Form -->
        <div class="ukroa_sign_form" id="ukroa_sign_login">
            <h3>Sign In</h3>
            <form id="ukroa_sign_login_form">
                <input type="text" name="username" placeholder="Username or Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign In</button>
                <p class="ukroa_sign_link">
                    <a href="<?php echo wp_lostpassword_url(); ?>" target="_blank">Forgot Password?</a>
                </p>
                <p class="ukroa_sign_link">Don't have an account? 
                    <a href="#" id="ukroa_sign_to_signup">Sign Up</a>
                </p>
                <div class="ukroa_sign_message"></div>
            </form>
        </div>

        <!-- Signup Form (No Confirm Password) -->
        <div class="ukroa_sign_form" id="ukroa_sign_signup" style="display:none;">
            <h3>Sign Up (Reader Access)</h3>
            <form id="ukroa_sign_signup_form" enctype="multipart/form-data">
                <div class="ukroa_sign_two_cols">
                    <input type="text" name="first_name" placeholder="First Name" required>
                    <input type="text" name="last_name" placeholder="Last Name" required>
                </div>
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="tel" name="phone" placeholder="Contact Number" required>
                <input type="file" name="profile_image" accept="image/*">
                <input type="password" name="password" placeholder="Password" required>
                <textarea name="bio" placeholder="Bio (optional)" rows="3"></textarea>
                <button type="submit">Sign Up</button>
                <p class="ukroa_sign_link">
                    <a href="#" id="ukroa_sign_to_login">← Back to Sign In</a>
                </p>
                <div class="ukroa_sign_message"></div>
            </form>
        </div>

    </div>
</div>