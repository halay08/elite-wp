<?php
/**
 * Template for displaying user profile cover image.
 *
 * This template can be overridden by copying it to ecademy/learnpress/profile/profile-cover.php.
 *
 * @author   EnvyTheme
 * @package  Learnpress/Templates
 * @version  3.0.0
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();

$profile = LP_Profile::instance();

$user = $profile->get_user();
$user_id = $user->get_id();

global $ecademy_opt;

$massage_btn_text = !empty($ecademy_opt['massage_btn_text']) ? $ecademy_opt['massage_btn_text'] : '';

?>
<div class="profile-box">
    <div class="row align-items-center">
        <div class="col-lg-4 col-md-4">
            <div class="image">
			<?php echo wp_kses_post( $user->get_profile_picture( null, '500') ); ?>
            </div>
        </div>

        <div class="col-lg-8 col-md-8">
            <div class="content">
                <h3 class="profile-name"><?php echo wp_kses_post( $user->get_display_name() ); ?></h3>
                <?php the_field('user_description', 'user_'. $user_id ); ?>

                <ul class="social-link">
                    <?php
                    if( have_rows('user_social_links', 'user_'. $user_id ) ):
                        while ( have_rows('user_social_links', 'user_'. $user_id ) ) : the_row();
                        ?>
                            <li><a href="<?php echo esc_url( the_sub_field('user_social_link')); ?>" class="d-block" target="_blank"><i class="<?php echo esc_attr( the_sub_field('user_select_social_icon') ); ?>"></i></a></li>
                        <?php
                        endwhile;                                    
                    endif;
                    ?>
                </ul>  
                <?php if( $massage_btn_text != '' ): 
			        $massage_btn_link = get_page_link($ecademy_opt['massage_btn_link']); 
                    ?>
                    <a href="<?php echo esc_url( $massage_btn_link ); ?>" class="default-btn">
                        <i class="flaticon-user"></i>
                        <?php  echo esc_html( $massage_btn_text ); ?><span></span>
                    </a> 
                <?php endif; ?>             
            </div>
        </div>
    </div>
</div>