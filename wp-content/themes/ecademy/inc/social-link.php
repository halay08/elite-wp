<?php 
/**
 * Social Link
 * @package WordPress
 * @subpackage eCademy
*/ 

if ( ! function_exists( 'ecademy_social_link' ) ) :
    function ecademy_social_link(){ 
        global $ecademy_opt;

        if( isset( $ecademy_opt['ecademy_social_target'] ) ) {
            $target = $ecademy_opt['ecademy_social_target'];
        }else {
            $target = '_blank';
        }
        ?>
        <ul class="social-link">
            <?php if (isset($ecademy_opt['twitter_url'] ) && $ecademy_opt['twitter_url']) { ?>
                <li>
                    <a class="d-block twitter" target="<?php echo esc_attr($target); ?>" href="<?php  echo esc_url($ecademy_opt['twitter_url']);?>"> <i class="fa fa-twitter"></i></a>
                </li>
            <?php  } ?>


            <?php if (isset($ecademy_opt['facebook_url'] ) && $ecademy_opt['facebook_url']) { ?>
                <li>
                    <a class="d-block facebook" target="<?php echo esc_attr($target); ?>" href="<?php  echo esc_url($ecademy_opt['facebook_url']); ?>"> <i class="fa fa-facebook"></i></a>
                </li>
            <?php  } ?>

            <?php if (isset($ecademy_opt['instagram_url'] ) && $ecademy_opt['instagram_url'] ) { ?>
                <li>
                    <a class="d-block instagram" target="<?php echo esc_attr($target); ?>" href="<?php  echo esc_url($ecademy_opt['instagram_url']); ?>"> <i class="fa fa-instagram"></i></a>
                </li>
            <?php  } ?>

            <?php 
            if (isset($ecademy_opt['linkedin_url'] ) && $ecademy_opt['linkedin_url'] ) { ?>
            <li>
                <a class="d-block" target="<?php echo esc_attr($target); ?>" href="<?php  echo esc_url($ecademy_opt['linkedin_url']);?>" > <i class="fa fa-linkedin"></i></a>
            </li>
            <?php  } ?>

            <?php 
            if (isset($ecademy_opt['pinterest_url'] ) && $ecademy_opt['pinterest_url'] ) { ?>
            <li>
                <a class="d-block" target="<?php echo esc_attr($target); ?>" href="<?php echo esc_url($ecademy_opt['pinterest_url']);?>" > <i class="fa fa-pinterest"></i></a>
            </li>
            <?php  } ?>

            <?php if (isset($ecademy_opt['dribbble_url'] ) && $ecademy_opt['dribbble_url'] ) { ?>
                <li>
                    <a class="d-block" target="<?php echo esc_attr($target); ?>" href="<?php echo esc_url($ecademy_opt['dribbble_url']);?>" > <i class="fa fa-dribbble"></i></a>
                </li>
            <?php } ?>

            <?php if (isset($ecademy_opt['tumblr_url'] ) && $ecademy_opt['tumblr_url'] ) { ?>
                <li>
                    <a class="d-block" target="<?php echo esc_attr($target); ?>" href="<?php  echo esc_url($ecademy_opt['tumblr_url']);?>" > <i class="fa fa-tumblr"></i></a>
                </li>
            <?php } ?>

            <?php 
            if (isset($ecademy_opt['youtube_url'] ) && $ecademy_opt['youtube_url'] ) { ?>
            <li>
                <a class="d-block" target="<?php echo esc_attr($target); ?>" href="<?php  echo esc_url($ecademy_opt['youtube_url']);?>" > <i class="fa fa-youtube"></i></a>
            </li>
            <?php  } ?>

            <?php if (isset($ecademy_opt['flickr_url'] ) && $ecademy_opt['flickr_url'] ) { ?>
                <li>
                    <a class="d-block" target="<?php echo esc_attr($target); ?>" href="<?php  echo esc_url($ecademy_opt['flickr_url']);?>" > <i class="fa fa-flickr"></i></a>
                </li>
            <?php } ?>

            <?php if (isset($ecademy_opt['behance_url'] ) && $ecademy_opt['behance_url'] ) { ?>
                <li>
                    <a class="d-block" target="<?php echo esc_attr($target); ?>" href="<?php  echo esc_url($ecademy_opt['behance_url']);?>" > <i class="fa fa-behance"></i></a>
                </li>
            <?php } ?>

            <?php if (isset($ecademy_opt['github_url'] ) &&  $ecademy_opt['github_url'] ) { ?>
                <li>
                    <a class="d-block" target="<?php echo esc_attr($target); ?>" href="<?php  echo esc_url($ecademy_opt['github_url']);?>" > <i class="fa fa-github"></i></a>
                </li>
            <?php } ?>

            <?php if (isset($ecademy_opt['skype_url'] ) && $ecademy_opt['skype_url'] ) { ?>
                <li>
                    <a class="d-block" target="<?php echo esc_attr($target); ?>" href="<?php  echo esc_url($ecademy_opt['skype_url']);?>" > <i class="fa fa-skype"></i></a>
                </li>
            <?php } ?>

            <?php if (isset($ecademy_opt['rss_url'] ) && $ecademy_opt['rss_url'] ) { ?>
                <li>
                    <a class="d-block" target="<?php echo esc_attr($target); ?>" href="<?php  echo esc_url($ecademy_opt['rss_url']);?>" > <i class="fas fa-rss"></i></a>
                </li>
            <?php } ?>
        </ul>
    <?php
    } 
endif; ?>